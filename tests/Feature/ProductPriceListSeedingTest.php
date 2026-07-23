<?php

use App\Enums\ProductStatus;
use App\Enums\ProductType;
use App\Enums\StockStatus;
use App\Models\Brand;
use App\Models\Product;
use Database\Seeders\AttributeSeeder;
use Database\Seeders\BrandSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Support\Facades\File;

// Seeding the full catalogue is slow, so this file seeds once and asserts
// everything it needs from that single run.
it('seeds each product with the status, price and default variant from products.json', function () {
    $items = json_decode(File::get(database_path('data/products.json')), true);

    // products.json carries an explicit status for every item (published for the
    // approved e-commerce price-list SKUs, draft for the rest).
    expect(collect($items)->every(fn ($i) => isset($i['status'])))->toBeTrue();
    $expected = collect($items)->keyBy('sku');

    // AttributeSeeder must run first: without it there are no attribute values for
    // ProductSeeder to attach, and every variant seeds with no variation axis at all.
    $this->seed([BrandSeeder::class, CategorySeeder::class, AttributeSeeder::class, ProductSeeder::class]);

    Product::query()->get(['sku', 'status', 'price'])->each(function (Product $product) use ($expected) {
        $item = $expected->get($product->sku);

        expect($product->status->value)->toBe($item['status'])
            ->and($product->price)->toBe(
                $item['price'] === null ? null : (int) round(((float) $item['price']) * 100)
            );
    });

    // Every published priced product has a price; quote-only products (e.g. the
    // imported cold-room/laundry/healthcare items) may legitimately be published
    // with no price. The catalog has both published and draft states.
    expect(
        Product::where('status', ProductStatus::PUBLISHED)
            ->where('requires_quotation', false)
            ->whereNull('price')
            ->count()
    )->toBe(0)
        ->and(Product::where('status', ProductStatus::PUBLISHED)->count())->toBeGreaterThan(0)
        ->and(Product::where('status', ProductStatus::DRAFT)->count())->toBeGreaterThan(0);

    // brands.json holds the display casing ("Rational") while products.json still
    // carries the supplier's ("RATIONAL"), so the seeder matches on a lowercased
    // name. Comparing verbatim would leave brand_id null right across the catalogue.
    $rational = Brand::where('slug', 'rational')->sole();

    expect($rational->name)->toBe('Rational')
        ->and(Product::where('brand_id', $rational->id)->count())->toBeGreaterThan(0);

    // Every variable product opens on a concrete variant rather than falling back
    // at render time, and that variant is one of its own and in stock.
    $variableProducts = Product::where('type', ProductType::VARIABLE)->with('variants')->get();

    expect($variableProducts)->not->toBeEmpty();

    $variableProducts->each(function (Product $product) {
        expect($product->default_variant_id)->not->toBeNull();

        $default = $product->variants->firstWhere('id', $product->default_variant_id);

        expect($default)->not->toBeNull()
            ->and($default->stock_status)->toBe(StockStatus::IN_STOCK);
    });

    // The GN-size ranges are each one variable product, and every size carries its
    // own photo - they look different, so a shared parent image would misrepresent
    // them. Sizes that used to be standalone products must be gone.
    $ranges = [
        'GROUP/ROASTING-BAKING-TRAY' => ['IMG/OVE/00060' => '23-gn', 'IMG/OVE/00058' => '11-gn', 'IMG/OVE/00059' => '21-gn'],
        'GROUP/MULTIBAKER' => ['IMG/OVE/00049' => '13-gn', 'IMG/OVE/00048' => '23-gn', 'IMG/OVE/00047' => '11-gn'],
        'GROUP/CROSS-N-STRIPE-GRILL' => ['IMG/OVE/00028' => '23-gn', 'IMG/OVE/00029' => '11-gn'],
        // Bakery standard is not a GN fraction, but it shares the size axis because
        // it is the other footprint this tray is sold in.
        'GROUP/PERFORATED-BAKING-TRAY' => ['IMG/OVE/00051' => '11-gn', 'IMG/OVE/00050' => 'bakery-standard'],
        'GROUP/COMBI-FRY' => ['IMG/OVE/00025' => '23-gn', 'IMG/OVE/00024' => '11-gn'],
        'GROUP/GRILLING-PIZZA-TRAY' => ['IMG/OVE/00039' => '23-gn', 'IMG/OVE/00038' => '11-gn'],
        // Both spikes are 1/1 GN; they vary by how many birds they hold, not footprint.
        'GROUP/CHICKEN-SUPER-SPIKE' => ['IMG/OVE/00021' => '8-birds', 'IMG/OVE/00022' => '10-birds'],
        // The LAR tabletop blenders vary by cup volume. The 25 L is deliberately not
        // here: it is floor-standing with a tilting cup, not a bigger tabletop unit.
        'GROUP/BLENDER-KITCHEN-SS' => [
            'IMG/FPR/00033' => '3-litres',
            'IMG/FPR/00034' => '4-litres',
            'IMG/FPR/00036' => '8-litres',
            'IMG/FPR/00037' => '10-litres',
        ],
    ];

    foreach ($ranges as $parentSku => $expectedSizes) {
        $parent = Product::where('sku', $parentSku)->with('variants.attributeValues')->first();

        expect($parent)->not->toBeNull()
            ->and($parent->type)->toBe(ProductType::VARIABLE)
            ->and($parent->variants)->toHaveCount(count($expectedSizes));

        // The former standalone products are folded in, not left alongside.
        expect(Product::whereIn('sku', array_keys($expectedSizes))->count())->toBe(0);

        $sizes = $parent->variants
            ->mapWithKeys(fn ($v) => [$v->sku => $v->attributeValues->first()?->slug])
            ->all();

        expect($sizes)->toEqual($expectedSizes);

        $parent->variants->each(function ($variant) {
            expect($variant->getFirstMedia('image'))->not->toBeNull("{$variant->sku} has no variant image")
                ->and($variant->model_number)->not->toBeNull("{$variant->sku} has no model number");
        });
    }

    // Each range opens on the size flagged in the source data, not merely inferred.
    $defaultSku = function (string $parentSku): ?string {
        $parent = Product::where('sku', $parentSku)->with('variants')->first();

        return $parent->variants->firstWhere('id', $parent->default_variant_id)?->sku;
    };

    expect($defaultSku('GROUP/MULTIBAKER'))->toBe('IMG/OVE/00047')
        ->and($defaultSku('GROUP/CROSS-N-STRIPE-GRILL'))->toBe('IMG/OVE/00029')
        ->and($defaultSku('GROUP/ROASTING-BAKING-TRAY'))->toBe('IMG/OVE/00058')
        ->and($defaultSku('GROUP/GRANITE-ENAMELED'))->toBe('IMG/OVE/00031')
        ->and($defaultSku('GROUP/COMBI-FRY'))->toBe('IMG/OVE/00024')
        ->and($defaultSku('GROUP/CHICKEN-SUPER-SPIKE'))->toBe('IMG/OVE/00022');

    // The granite-enameled container varies on two axes at once, so each variant
    // must carry a value for both - a variant missing one can never be selected.
    $granite = Product::where('sku', 'GROUP/GRANITE-ENAMELED')
        ->with(['variants.attributeValues.attribute', 'productAttributes.attribute'])
        ->first();

    expect($granite->productAttributes->pluck('attribute.slug')->sort()->values()->all())
        ->toBe(['depth', 'gn-size']);

    $combos = $granite->variants
        ->map(fn ($v) => $v->attributeValues
            ->sortBy(fn ($value) => $value->attribute->slug)
            ->map(fn ($value) => $value->slug)
            ->join('/'))
        ->sort()
        ->values()
        ->all();

    // A complete 2x2 matrix: both depths in both footprints.
    expect($combos)->toBe(['20-mm/11-gn', '20-mm/23-gn', '60-mm/11-gn', '60-mm/23-gn']);

    // Discontinued sizes stay archived standalone products rather than joining a
    // range: they are not for sale, and each carries a zero price that would drag
    // the range's lower bound down to nothing.
    Product::whereIn('sku', ['IMG/OVE/00033', 'IMG/OVE/00023'])->get()->each(function (Product $product) {
        expect($product->status)->toBe(ProductStatus::ARCHIVED)
            ->and($product->type)->not->toBe(ProductType::VARIABLE);
    });

    expect(Product::whereIn('sku', ['IMG/OVE/00033', 'IMG/OVE/00023'])->count())->toBe(2);
});
