<?php

namespace Database\Seeders;

use App\Enums\CategoryStatus;
use App\Models\Category;
use App\Models\CategoryPlacement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use RuntimeException;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('data/categories.json');

        if (! File::exists($jsonPath)) {
            $this->command->error('categories.json file not found at '.$jsonPath);

            return;
        }

        $data = json_decode(File::get($jsonPath), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->command->error('Error parsing JSON: '.json_last_error_msg());

            return;
        }

        // Track sort_order independently per placement location.
        $placementOrders = [];

        foreach ($data as $item) {
            $this->createCategory($item, null, $placementOrders);
        }
    }

    /**
     * Slugs are globally unique (the storefront routes /shop/{category:slug} without a
     * parent segment), but child names are not — "Automatic" reads perfectly well under
     * both Coffee Machines and Dishwashers. A child that would collide is therefore
     * qualified with its parent: coffee-machines-automatic, dishwashers-automatic. The
     * first one seeded keeps the bare slug, so existing URLs never shift underneath us.
     * A category may also pin its own slug in categories.json to opt out entirely.
     *
     * Reads the categories already seeded, so it must be called as the tree is built.
     */
    public static function deriveSlug(string $name, ?string $parentName): string
    {
        $slug = Str::slug($name);

        if (! Category::where('slug', $slug)->exists()) {
            return $slug;
        }

        if ($parentName === null) {
            throw new RuntimeException(sprintf('Duplicate top-level category "%s".', $name));
        }

        $qualified = Str::slug($parentName.' '.$name);

        if (Category::where('slug', $qualified)->exists()) {
            throw new RuntimeException(sprintf(
                'Cannot derive a unique slug for "%s" under "%s" — "%s" is taken too.',
                $name,
                $parentName,
                $qualified,
            ));
        }

        return $qualified;
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<string, int>  $placementOrders
     */
    private function createCategory(array $data, ?Category $parent, array &$placementOrders): Category
    {
        $category = Category::create([
            'name' => $data['name'],
            'slug' => $data['slug'] ?? self::deriveSlug($data['name'], $parent?->name),
            'parent_id' => $parent?->id,
            'description' => $data['description'] ?? null,
            'banner' => $data['banner'] ?? null,
            'image' => $data['image'] ?? null,
            'icon' => $data['icon'] ?? null,
            'status' => CategoryStatus::ACTIVE,
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        foreach ($data['placements'] ?? [] as $location) {
            $placementOrders[$location] = ($placementOrders[$location] ?? 0) + 1;

            CategoryPlacement::create([
                'category_id' => $category->id,
                'location' => $location,
                'sort_order' => $placementOrders[$location],
                'status' => CategoryStatus::ACTIVE,
            ]);
        }

        foreach ($data['children'] ?? [] as $child) {
            $this->createCategory($child, $category, $placementOrders);
        }

        return $category;
    }
}
