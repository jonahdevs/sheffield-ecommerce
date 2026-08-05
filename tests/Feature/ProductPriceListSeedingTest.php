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

    // Variable/grouped/bundle parents persist a null SKU (their variants carry the
    // real ones), so they are matched back to their source row by name - parent
    // names are unique across the catalogue.
    $expectedParentsByName = collect($items)
        ->filter(fn ($i) => in_array($i['type'] ?? 'simple', ['variable', 'grouped', 'bundle', 'bundled'], true))
        ->keyBy('name');

    // AttributeSeeder must run first: without it there are no attribute values for
    // ProductSeeder to attach, and every variant seeds with no variation axis at all.
    $this->seed([BrandSeeder::class, CategorySeeder::class, AttributeSeeder::class, ProductSeeder::class]);

    // ProductSeeder demotes a row products.json marked published to draft when it has
    // no price and isn't quote-only (see hasSellablePrice()) - a published listing
    // with no price and no quote path is unbuyable, not a legitimate storefront state.
    // Their status therefore diverges from the source row on purpose.
    $unpricedNonQuoteSkus = collect($items)
        ->reject(fn ($i) => (bool) ($i['requires_quotation'] ?? false))
        ->filter(fn ($i) => ($i['status'] ?? null) === 'published')
        ->filter(fn ($i) => empty($i['price']) || (float) $i['price'] <= 0)
        ->pluck('sku')
        ->all();

    Product::query()->get(['sku', 'status', 'price', 'name', 'type'])->each(function (Product $product) use ($expected, $expectedParentsByName, $unpricedNonQuoteSkus) {
        $item = $product->sku !== null
            ? $expected->get($product->sku)
            : $expectedParentsByName->get($product->name);

        expect($item)->not->toBeNull("No source row for {$product->name} ({$product->sku})");

        $expectedStatus = in_array($product->sku, $unpricedNonQuoteSkus, true)
            ? ProductStatus::DRAFT->value
            : $item['status'];

        expect($product->status->value)->toBe($expectedStatus)
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

    // The seeder reads "model_number" and nothing else, so a row spelling the key any
    // other way persists no code at all - fourteen rows once did, losing every Antunes
    // and Kalerm part number. Assert the codes survive the round trip, not just that
    // the key is spelled right in the JSON.
    $expectedCodes = collect($items)
        ->filter(fn ($i) => ! empty($i['sku']) && ! empty($i['model_number']))
        ->pluck('model_number', 'sku');

    $persisted = Product::whereIn('sku', $expectedCodes->keys())->pluck('model_number', 'sku');

    $lost = $expectedCodes
        ->reject(fn ($code, $sku) => $persisted->get($sku) === $code)
        ->map(fn ($code, $sku) => $sku.' → expected '.$code.', got '.($persisted->get($sku) ?? 'null'))
        ->values()
        ->all();

    expect($lost)->toBe([]);

    // Every variable product opens on a concrete variant rather than falling back
    // at render time, and that variant is one of its own and in stock.
    $variableProducts = Product::where('type', ProductType::VARIABLE)->with('variants')->get();

    expect($variableProducts)->not->toBeEmpty();

    $variableProducts->each(function (Product $product) {
        // A variable parent owns no SKU - its variants carry the real ones. The
        // parent's products.json value is only an internal join key and must never
        // be persisted as the product's SKU.
        expect($product->sku)->toBeNull("{$product->name} persisted a parent SKU");

        expect($product->default_variant_id)->not->toBeNull();

        $default = $product->variants->firstWhere('id', $product->default_variant_id);

        expect($default)->not->toBeNull();

        // Open on a variant the customer can actually buy - but only when one exists.
        // A product whose every variant is out of stock (Pradeep's electric catering
        // urn: all four are 0 in SAP) has no in-stock default to choose, so requiring
        // one asserts something unsatisfiable rather than catching a bad default.
        $anyInStock = $product->variants
            ->contains(fn ($variant) => $variant->stock_status === StockStatus::IN_STOCK);

        if ($anyInStock) {
            expect($default->stock_status)->toBe(
                StockStatus::IN_STOCK,
                "{$product->name} defaults to an out-of-stock variant while another is in stock"
            );
        }
    });

    // No parent leaks its join key as a SKU. The key used to be a "GROUP/..." string,
    // which was obvious when it leaked; it is now the default variant's article number,
    // which would look plausible on a page, so assert the invariant directly.
    expect(Product::where('type', ProductType::VARIABLE)->whereNotNull('sku')->count())->toBe(0);

    // The GN-size ranges are each one variable product, and every size carries its
    // own photo - they look different, so a shared parent image would misrepresent
    // them. Sizes that used to be standalone products must be gone.
    // Keyed by the parent's products.json join key, which is its default variant's
    // article number - the parent itself persists no SKU.
    $ranges = [
        'IMG/OVE/00058' => ['IMG/OVE/00060' => '23-gn', 'IMG/OVE/00058' => '11-gn', 'IMG/OVE/00059' => '21-gn'],
        'IMG/OVE/00047' => ['IMG/OVE/00049' => '13-gn', 'IMG/OVE/00048' => '23-gn', 'IMG/OVE/00047' => '11-gn'],
        'IMG/OVE/00028' => ['IMG/OVE/00028' => '23-gn', 'IMG/OVE/00029' => '11-gn'],
        // Bakery standard is not a GN fraction, but it shares the size axis because
        // it is the other footprint this tray is sold in.
        'IMG/OVE/00051' => ['IMG/OVE/00051' => '11-gn', 'IMG/OVE/00050' => 'bakery-standard'],
        'IMG/OVE/00024' => ['IMG/OVE/00025' => '23-gn', 'IMG/OVE/00024' => '11-gn'],
        'IMG/OVE/00038' => ['IMG/OVE/00039' => '23-gn', 'IMG/OVE/00038' => '11-gn'],
        // Both spikes are 1/1 GN; they vary by how many birds they hold, not footprint.
        'IMG/OVE/00022' => ['IMG/OVE/00021' => '8-birds', 'IMG/OVE/00022' => '10-birds'],
        // The LAR tabletop blenders vary by cup volume. The 25 L is deliberately not
        // here: it is floor-standing with a tilting cup, not a bigger tabletop unit.
        'IMG/FPR/00034' => [
            'IMG/FPR/00033' => '3-litres',
            'IMG/FPR/00034' => '4-litres',
            'IMG/FPR/00036' => '8-litres',
            'IMG/FPR/00037' => '10-litres',
        ],
    ];

    // Parents do not persist their join key as a SKU, so they are found by the name
    // carried on that source row rather than by the (now null) parent SKU.
    $parentQuery = function (string $groupSku) use ($items) {
        $name = collect($items)->firstWhere('sku', $groupSku)['name'];

        return Product::where('name', $name)->where('type', ProductType::VARIABLE);
    };

    foreach ($ranges as $parentSku => $expectedSizes) {
        $parent = $parentQuery($parentSku)->with('variants.attributeValues')->first();

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
    $defaultSku = function (string $parentSku) use ($parentQuery): ?string {
        $parent = $parentQuery($parentSku)->with('variants')->first();

        return $parent->variants->firstWhere('id', $parent->default_variant_id)?->sku;
    };

    // Cross N Stripe opens on 00028, not the 00029 it used to: SAP put 00029 to zero
    // stock, and a range should not open on a size the customer cannot buy while its
    // sibling is available.
    expect($defaultSku('IMG/OVE/00047'))->toBe('IMG/OVE/00047')
        ->and($defaultSku('IMG/OVE/00028'))->toBe('IMG/OVE/00028')
        ->and($defaultSku('IMG/OVE/00058'))->toBe('IMG/OVE/00058')
        ->and($defaultSku('IMG/OVE/00031'))->toBe('IMG/OVE/00031')
        ->and($defaultSku('IMG/OVE/00024'))->toBe('IMG/OVE/00024')
        ->and($defaultSku('IMG/OVE/00022'))->toBe('IMG/OVE/00022');

    // The granite-enameled container varies on two axes at once, so each variant
    // must carry a value for both - a variant missing one can never be selected.
    $granite = $parentQuery('IMG/OVE/00031')
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
