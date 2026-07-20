<?php

namespace Database\Seeders;

use App\Enums\AttributeType;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attributes = [
            [
                'name' => 'Color',
                'slug' => 'color',
                'type' => AttributeType::COLOR,
                'values' => [
                    ['value' => 'red', 'label' => 'Red', 'color_code' => '#EF4444'],
                    ['value' => 'blue', 'label' => 'Blue', 'color_code' => '#3B82F6'],
                    ['value' => 'green', 'label' => 'Green', 'color_code' => '#22C55E'],
                ],
            ],
            [
                'name' => 'Size',
                'slug' => 'size',
                'type' => AttributeType::SELECT,
                'values' => [
                    ['value' => 's', 'label' => 'Small'],
                    ['value' => 'm', 'label' => 'Medium'],
                    ['value' => 'l', 'label' => 'Large'],
                ],
            ],
            [
                // Gastronorm size — the variation axis for combi-oven trays, containers,
                // grids and similar accessories that ship in the standard GN footprints.
                // Bakery standard (400 x 600 mm) is a separate norm, not a GN fraction,
                // but it sits on the same axis because it is the alternative a buyer
                // picks between when a tray comes in both.
                'name' => 'GN Size',
                'slug' => 'gn-size',
                'type' => AttributeType::SELECT,
                'values' => [
                    ['value' => '1/3 GN', 'label' => '1/3 GN'],
                    ['value' => '2/3 GN', 'label' => '2/3 GN'],
                    ['value' => '1/1 GN', 'label' => '1/1 GN'],
                    ['value' => '2/1 GN', 'label' => '2/1 GN'],
                    ['value' => 'Bakery standard', 'label' => 'Bakery standard'],
                ],
            ],
            [
                // Container depth — pairs with GN Size for gastronorm containers, which
                // come in the same footprint at more than one depth. Shallow suits dry
                // roasting and baking; deep holds sauce for braising and stewing.
                'name' => 'Depth',
                'slug' => 'depth',
                'type' => AttributeType::SELECT,
                'values' => [
                    ['value' => '20 mm', 'label' => '20 mm'],
                    ['value' => '60 mm', 'label' => '60 mm'],
                    ['value' => '100 mm', 'label' => '100 mm'],
                ],
            ],
            [
                // Working volume in litres — the variation axis for blenders and other
                // machines sold as one design in several cup or bowl sizes. Kept apart
                // from Capacity, which counts items rather than measuring volume.
                'name' => 'Volume',
                'slug' => 'volume',
                'type' => AttributeType::SELECT,
                'values' => [
                    ['value' => '3 litres', 'label' => '3 litres'],
                    ['value' => '4 litres', 'label' => '4 litres'],
                    ['value' => '8 litres', 'label' => '8 litres'],
                    ['value' => '10 litres', 'label' => '10 litres'],
                ],
            ],
            [
                // How much a rack holds. Some accessories share a footprint but differ
                // in what they carry — the poultry spikes are all 1/1 GN, and vary only
                // in how many birds fit (and therefore how large each bird may be).
                'name' => 'Capacity',
                'slug' => 'capacity',
                'type' => AttributeType::SELECT,
                'values' => [
                    ['value' => '4 birds', 'label' => '4 birds'],
                    ['value' => '8 birds', 'label' => '8 birds'],
                    ['value' => '10 birds', 'label' => '10 birds'],
                ],
            ],
        ];

        foreach ($attributes as $attrIndex => $attr) {
            $attribute = Attribute::create([
                'name' => $attr['name'],
                'slug' => $attr['slug'],
                'type' => $attr['type'],
                'is_active' => true,
                'sort_order' => $attrIndex + 1,
            ]);

            foreach ($attr['values'] as $valueIndex => $value) {
                AttributeValue::create([
                    'attribute_id' => $attribute->id,
                    'value' => $value['value'],
                    'label' => $value['label'],
                    'slug' => Str::slug($value['value']),
                    'color_code' => $value['color_code'] ?? null,
                    'is_active' => true,
                    'sort_order' => $valueIndex + 1,
                ]);
            }
        }
    }
}
