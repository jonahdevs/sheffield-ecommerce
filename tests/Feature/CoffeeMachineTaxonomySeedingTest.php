<?php

use App\Enums\CategorySection;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryPlacement;
use App\Models\Product;
use Database\Seeders\BrandSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Support\Str;

/**
 * The coffee taxonomy mirrors the "Ecommerce Listing- Coffee Machines Final"
 * workbook: a Coffee Machines parent holding five ordered child categories — two of
 * which carry an accessories child of their own — with each product's sort_order
 * encoding the sheet's ARRANGEMENT column.
 *
 * Seeding the full catalogue is expensive, so this file asserts the whole
 * taxonomy from a single seed rather than one per case.
 */
it('seeds the coffee taxonomy from the final e-commerce listing', function () {
    $this->seed([BrandSeeder::class, CategorySeeder::class, ProductSeeder::class]);

    $parent = Category::whereNull('parent_id')->where('slug', 'coffee-machines')->sole();

    // Children are nested under the parent, in the workbook's declared order. The machine
    // types are named for the drill-down ("Semi Automatic"), not repeating the parent.
    expect($parent->children()->orderBy('sort_order')->pluck('name')->all())->toBe([
        'Semi Automatic',
        'Coffee Grinders',
        'Automatic',
        'Coffee Brewers',
        'Coffee Servery',
    ]);

    $childId = fn (string $name) => Category::where('name', $name)->value('id');

    // Each accessories category hangs off the machine type it serves, so the tree
    // is three levels deep.
    $semiMachines = Category::where('name', 'Semi Automatic')->sole();
    $autoMachines = Category::where('name', 'Automatic')->sole();

    expect($semiMachines->children()->pluck('name')->all())
        ->toBe(['Semi Automatic Accessories'])
        ->and($autoMachines->children()->pluck('name')->all())
        ->toBe(['Automatic Accessories'])
        // Three levels: accessories → machine type → Coffee Machines.
        ->and($semiMachines->parent_id)->toBe($parent->id)
        ->and($autoMachines->parent_id)->toBe($parent->id);

    $countIn = fn (string $name) => Product::where('primary_category_id', $childId($name))->count();

    expect($countIn('Semi Automatic'))->toBe(7)
        ->and($countIn('Coffee Grinders'))->toBe(4)
        ->and($countIn('Semi Automatic Accessories'))->toBe(3)
        ->and($countIn('Automatic'))->toBe(7)
        ->and($countIn('Automatic Accessories'))->toBe(2)
        ->and($countIn('Coffee Brewers'))->toBe(10)
        ->and($countIn('Coffee Servery'))->toBe(4);

    // The workbook reuses one "COFFEE MACHINE ACCESSORIES" label twice; the block
    // is split by whichever machine type it follows.
    expect(
        Product::where('primary_category_id', $childId('Semi Automatic Accessories'))
            ->pluck('sku')->sort()->values()->all()
    )->toBe(['IMG/COF/00048', 'IMS/MEC/00303', 'IMS/MEC/00469'])
        ->and(
            Product::where('primary_category_id', $childId('Automatic Accessories'))
                ->pluck('sku')->sort()->values()->all()
        )->toBe(['IMG/COF/00047', 'IMG/COF/00097']);

    // ARRANGEMENT: "Silvia, Group 1, 2, 3".
    expect(
        Product::where('primary_category_id', $childId('Semi Automatic'))
            ->orderBy('sort_order')->pluck('sku')->all()
    )->toBe([
        'IMG/COF/00041', // Silvia
        'IMG/COF/00079', // Silvia Pro
        'IMG/COF/00035', // Classe 5S GR1
        'IMG/COF/00036', // Classe 5ST GR1
        'IMG/COF/00037', // Classe 5S GR2 black
        'IMG/COF/00038', // Classe 5S GR2 white
        'IMG/COF/00039', // Classe 7S GR3
    ]);

    // Listed products that carry a price are sellable, including the six that were
    // previously archived (both tampers, the CREM decanter, the airpot, both
    // serving stations).
    $listed = Product::whereIn('sku', [
        'IMS/MEC/00469', 'IMS/MEC/00303', 'IMG/COF/00008',
        'IMG/COF/00011', 'IMG/COF/00009', 'IMG/COF/00010',
    ])->get();

    expect($listed)->toHaveCount(6)
        ->and($listed->every(fn (Product $p) => $p->status->value === 'published'))->toBeTrue()
        ->and($listed->every(fn (Product $p) => $p->price > 0))->toBeTrue();

    // The Goodwill brewers and the filter papers carry no delivery-inclusive e-commerce
    // price in the workbook, only a SAP one. They are sold at that SAP price rather than
    // held back as drafts, so they are published — the workbook's missing e-commerce
    // column is not a bar to listing. GOODWILL still resolves to a brand.
    $goodwillId = Brand::where('name', 'GOODWILL')->value('id');
    $brewers = Product::whereIn('sku', ['IMG/COF/00139', 'IMG/COF/00140', 'IMG/COF/00141'])->get();

    expect($brewers)->toHaveCount(3)
        ->and($brewers->every(fn (Product $p) => $p->status->value === 'published'))->toBeTrue()
        ->and($brewers->every(fn (Product $p) => $p->price > 0))->toBeTrue()
        ->and($brewers->every(fn (Product $p) => $p->brand_id === $goodwillId))->toBeTrue();

    $papers = Product::where('sku', 'IMS/FIT/00992')->sole();

    expect($papers->status->value)->toBe('published')
        ->and($papers->price)->toBeGreaterThan(0)
        ->and($papers->primary_category_id)->toBe($childId('Coffee Brewers'));

    // The workbook mistypes the CREM decanter's item number as IMG/COF/00001; its
    // real SKU is IMG/COF/00008. The Berjaya water urn that actually owns
    // IMG/COF/00001 must be left alone, in Beverage Equipment.
    $decanter = Product::where('sku', 'IMG/COF/00008')->sole();

    expect($decanter->name)->toBe('Decanter 1.8 Litres CREM')
        ->and($decanter->brand->name)->toBe('CREM')
        ->and($decanter->primary_category_id)->toBe($childId('Coffee Brewers'));

    $waterUrn = Product::where('sku', 'IMG/COF/00001')->sole();

    expect($waterUrn->name)->toContain('Heated Water Urn')
        ->and($waterUrn->brand->name)->toBe('BERJAYA')
        ->and($waterUrn->primaryCategory->name)->toBe('Beverage Equipment');

    // Every coffee product now drills into a machine type, grinder, brewer, servery or
    // accessories child — nothing is left parked on the Coffee Machines parent itself.
    expect(Product::where('primary_category_id', $parent->id)->count())->toBe(0);

    assertWaterTreatmentSitsUnderHygiene();

    // Coffee Machines leads the navbar, and its five active children make it a
    // mega-menu trigger rather than a plain link.
    $navbar = CategoryPlacement::query()
        ->where('location', CategorySection::NAVBAR)
        ->orderBy('sort_order')
        ->first();

    expect($navbar->category_id)->toBe($parent->id)
        ->and($navbar->sort_order)->toBe(1);

    assertSpecificationsRenderAsTables();
    assertCoffeeDescriptionsSplitFromSeoCopy();
    assertCoffeeImagesFollowTheNamingConvention();
});

/**
 * The standalone water treatment units are sold as hygiene equipment rather than
 * coffee gear, so they hang off a Water Softeners child of Hygiene. The Rancilio DP2
 * is the exception: it ships as a semi-automatic machine accessory and stays there.
 * Folded into the seeding test above because seeding the catalogue is slow.
 */
function assertWaterTreatmentSitsUnderHygiene(): void
{
    $hygiene = Category::whereNull('parent_id')->where('slug', 'hygiene')->sole();
    $softeners = Category::where('slug', 'water-softeners')->sole();

    expect($softeners->parent_id)->toBe($hygiene->id);

    expect(
        Product::where('primary_category_id', $softeners->id)->orderBy('sku')->pluck('name')->all()
    )->toBe([
        'Water Softeners HLT.12',
        'Aq-Hc-Ro',
        'GST-1V',
        'AQ-RO-600 Watermark',
        'Ultrafiltration System VZN-511V',
        'Hrs Hardness Reduction System',
    ]);

    expect(Product::where('sku', 'IMG/COF/00048')->value('primary_category_id'))
        ->toBe(Category::where('name', 'Semi Automatic Accessories')->value('id'));
}

/**
 * Workbook technical specifications render as a two-column label/value table.
 * Folded into the seeding test above because seeding the catalogue is slow.
 */
function assertSpecificationsRenderAsTables(): void
{
    $silvia = Product::where('sku', 'IMG/COF/00041')->sole();

    expect($silvia->technical_specification)
        ->toStartWith('<table><tbody>')
        ->toContain('<tr><td><strong>Brand</strong></td><td>Rancilio</td></tr>')
        ->toContain('<tr><td><strong>Boiler Capacity</strong></td><td>0.3 L</td></tr>')
        // Length/Width/Height collapse into a single Dimensions row.
        ->toContain('<tr><td><strong>Dimensions (L × W × H)</strong></td><td>235 × 290 × 340 mm</td></tr>')
        ->not->toContain('<strong>Length</strong>')
        ->not->toContain('<strong>Width</strong>')
        ->not->toContain('<strong>Height</strong>');

    // Every workbook row resolves to a label/value pair — no dangling full-width
    // cells, including the strays that used tabs or lost their colon.
    $workbook = Product::whereIn('sku', [
        'IMG/COF/00035', 'IMG/COF/00036', 'IMG/COF/00104', 'IMG/COF/00139',
    ])->get();

    expect($workbook->every(fn (Product $p) => ! str_contains($p->technical_specification, 'colspan')))->toBeTrue()
        ->and($workbook->every(fn (Product $p) => str_starts_with($p->technical_specification, '<table>')))->toBeTrue();

    // The Classe 5 ST's unlabelled "Built-in water tank" line is named, and the
    // 5 S's duplicate trailing line is dropped rather than repeated.
    $classe5st = Product::where('sku', 'IMG/COF/00036')->sole();
    $classe5s = Product::where('sku', 'IMG/COF/00035')->sole();

    expect($classe5st->technical_specification)
        ->toContain('<tr><td><strong>Water Supply</strong></td><td>Built-in water tank</td></tr>')
        ->and(substr_count($classe5s->technical_specification, 'Direct Water Connection'))->toBe(1);

    // Tab-separated and colon-less lines still parse into proper cells, and the
    // colon-less "Length 205mm" still folds into the Dimensions row.
    expect(Product::where('sku', 'IMG/COF/00104')->value('technical_specification'))
        ->toContain('<tr><td><strong>Weight</strong></td><td>6 kg</td></tr>')
        ->and(Product::where('sku', 'IMG/COF/00139')->value('technical_specification'))
        ->toContain('<tr><td><strong>Dimensions (L × W × H)</strong></td><td>205 × 405 × 455 mm</td></tr>')
        ->toContain('<tr><td><strong>Housing Material</strong></td><td>Stainless Steel</td></tr>');

    // "Length (Depth)" is still the length axis, so the Kryo 65 OD gets all three.
    expect(Product::where('sku', 'IMG/COF/00135')->value('technical_specification'))
        ->toContain('<tr><td><strong>Dimensions (L × W × H)</strong></td><td>356 × 220 × 575 mm</td></tr>');

    // A lone axis stays its own row rather than becoming a one-sided "Dimensions".
    expect(Product::where('sku', 'IMS/MEC/00303')->value('technical_specification'))
        ->toContain('<tr><td><strong>Height</strong></td><td>90 mm</td></tr>')
        ->not->toContain('Dimensions');

    // The workbook copies the single-decanter brewer's footprint onto the twin, so
    // that row is withheld rather than published as a known-wrong spec.
    expect(Product::where('sku', 'IMG/COF/00104')->value('technical_specification'))
        ->not->toContain('Dimensions')
        ->not->toContain('<strong>Length</strong>');

    // Products outside the workbook keep the list format they already had.
    expect(Product::where('sku', 'IMG/COF/00054')->value('technical_specification'))
        ->toStartWith('<ul>');
}

/**
 * The two description fields do different jobs, so the copy is split rather than shared:
 * short_description is a neutral, scannable summary drawn from the product's own
 * description, while the SEO-pattern copy (brand + model, use case, market framing)
 * lives in meta_description where the search engines read it.
 * Folded into the seeding test above because seeding the catalogue is slow.
 */
function assertCoffeeDescriptionsSplitFromSeoCopy(): void
{
    $coffee = Product::whereHas(
        'primaryCategory',
        fn ($query) => $query->whereIn('slug', [
            'semi-automatic', 'semi-automatic-accessories', 'coffee-grinders',
            'automatic', 'automatic-accessories', 'coffee-brewers', 'coffee-servery',
        ])
    )->get();

    expect($coffee)->toHaveCount(37);

    // Both fields are populated for every product, so no PDP or <meta> tag falls back.
    expect($coffee->every(fn (Product $p) => filled($p->short_description)))->toBeTrue()
        ->and($coffee->every(fn (Product $p) => filled($p->meta_description)))->toBeTrue();

    // Anyone is welcome to buy, so the customer-facing summary never narrows the
    // audience to a region — that framing belongs to the SEO copy alone.
    $geographic = fn (?string $copy) => str_contains($copy ?? '', 'Kenya')
        || str_contains($copy ?? '', 'East Africa');

    expect($coffee->every(fn (Product $p) => ! $geographic($p->short_description)))->toBeTrue()
        ->and($coffee->contains(fn (Product $p) => $geographic($p->meta_description)))->toBeTrue();

    // The summary is scannable: a sentence or two, not the description's full lead
    // paragraph repeated above the fold.
    expect($coffee->every(fn (Product $p) => strlen($p->short_description) <= 220))->toBeTrue();

    // Worked example — the Pradeep brewer. The summary states what the product is and
    // its headline specs; the SEO copy keeps the brand/model and market framing.
    $brewer = Product::where('sku', 'IMG/COF/00033')->sole();

    expect($brewer->short_description)
        ->toBe('Commercial filter brewer that delivers straight into a 3.0-litre insulated thermal server, keeping coffee hot without a warming plate. Stainless steel, countertop, and simple to run and clean.')
        ->and($brewer->meta_description)
        ->toBe('Pradeep 9230 commercial coffee brewer with filter for fresh-brewed drip coffee service at hotels, restaurants, and office canteens across Kenya.');
}

/**
 * Product images are named <name-slug>-<sku-slug>.<ext>, which keeps a photo traceable
 * to its SKU and survives a rename of the file on someone's desktop.
 *
 * This matters more than tidiness: ProductSeeder::createImages() silently skips an
 * image path that is not on disk, so a typo costs the product its photo with no error
 * anywhere. Asserting the media actually attached is what catches that.
 * Folded into the seeding test above because seeding the catalogue is slow.
 */
function assertCoffeeImagesFollowTheNamingConvention(): void
{
    $coffee = Product::whereHas(
        'primaryCategory',
        fn ($query) => $query->whereIn('slug', [
            'semi-automatic', 'semi-automatic-accessories', 'coffee-grinders',
            'automatic', 'automatic-accessories', 'coffee-brewers', 'coffee-servery',
        ])
    )->with('media')->get();

    // The Egro Zero milk fridge, Rocky Doser and DAC-05 cup dispenser have no photo
    // anywhere yet; every other coffee product carries one.
    $withoutImage = ['IMG/COF/00047', 'IMG/COF/00128', 'IMG/COF/00133'];
    [$unphotographed, $photographed] = $coffee->partition(
        fn (Product $p) => in_array($p->sku, $withoutImage, true)
    );

    expect($unphotographed)->toHaveCount(3)
        ->and($photographed)->toHaveCount(34);

    // Every referenced file resolved on disk and became media — no silent skips.
    expect($photographed->every(fn (Product $p) => $p->media->isNotEmpty()))->toBeTrue();

    // Each cover file is named for the product that owns it.
    foreach ($photographed as $product) {
        $cover = $product->media->first(fn ($media) => $media->getCustomProperty('is_cover') === true);
        $expected = Str::slug($product->name).'-'.Str::slug($product->sku);

        expect($cover)->not->toBeNull()
            ->and(pathinfo($cover->file_name, PATHINFO_FILENAME))->toBe($expected);
    }
}
