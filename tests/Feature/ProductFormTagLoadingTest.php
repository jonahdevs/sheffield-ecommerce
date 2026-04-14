<?php

use App\Livewire\Forms\Admin\ProductForm;
use App\Models\Product;
use App\Models\Tag;
use Livewire\Component;

/**
 * Property Test: Tag Loading on Edit
 * 
 * **Validates: Requirements 6.1, 7.4**
 * 
 * Property 17: Tag Loading on Edit
 * 
 * For ANY product with associated tags, loading the product for editing
 * SHALL populate the tag_ids property with all associated tag IDs.
 * 
 * This test validates that:
 * - Products with no tags load with empty tag_ids array
 * - Products with single tag load with correct tag ID
 * - Products with multiple tags load with all tag IDs
 * - Tag IDs are loaded in correct format (array of integers)
 * - Tag loading works regardless of tag count
 */

describe('Product Form Tag Loading', function () {

    /**
     * Property Test: Tag IDs are loaded for products with any number of tags
     * 
     * Tests the universal property that tag_ids SHALL be populated with
     * all associated tag IDs when loading a product for editing.
     */
    it('loads tag_ids for products with varying tag counts', function () {
        // Test cases with different tag counts (0, 1, 3, 5, 10)
        $tagCounts = [0, 1, 3, 5, 10];

        foreach ($tagCounts as $count) {
            // Create product
            $product = Product::factory()->create([
                'name' => "Product with {$count} tags",
            ]);

            // Create and attach tags
            $expectedTagIds = [];
            for ($i = 0; $i < $count; $i++) {
                $tag = Tag::findOrCreate("Tag {$i} for product {$product->id}");
                $product->attachTag($tag);
                $expectedTagIds[] = $tag->id;
            }

            // Reload product with tags relationship
            $product->load('tags');

            // Create form and load product
            $component = Mockery::mock(Component::class);
            $form = new ProductForm($component, 'form');
            $form->setProduct($product);

            // Verify tag_ids property is populated correctly
            expect($form->tag_ids)
                ->toBeArray()
                ->toHaveCount($count);

            // Verify all expected tag IDs are present
            if ($count > 0) {
                expect($form->tag_ids)->toEqual($expectedTagIds);

                // Verify all elements are integers
                foreach ($form->tag_ids as $tagId) {
                    expect($tagId)->toBeInt();
                }
            }
        }
    });

    /**
     * Property Test: Tag loading preserves tag order
     * 
     * Tests that the order of tags is preserved when loading.
     */
    it('preserves tag order when loading product', function () {
        // Create product
        $product = Product::factory()->create();

        // Create multiple tags in specific order
        $tagNames = ['Alpha', 'Beta', 'Gamma', 'Delta', 'Epsilon'];
        $expectedTagIds = [];

        foreach ($tagNames as $name) {
            $tag = Tag::findOrCreate($name);
            $product->attachTag($tag);
            $expectedTagIds[] = $tag->id;
        }

        // Reload product with tags
        $product->load('tags');

        // Create form and load product
        $component = Mockery::mock(Component::class);
        $form = new ProductForm($component, 'form');
        $form->setProduct($product);

        // Verify tag IDs match expected order
        expect($form->tag_ids)->toEqual($expectedTagIds);
    });

    /**
     * Property Test: Tag loading works with multilingual tag names
     * 
     * Tests that tag loading works correctly with Spatie's multilingual
     * tag names (JSON format).
     */
    it('loads tags with multilingual names correctly', function () {
        // Create product
        $product = Product::factory()->create();

        // Create tags with multilingual names
        $tag1 = Tag::findOrCreate('Electronics', 'en');
        $tag2 = Tag::findOrCreate('Featured', 'en');
        $tag3 = Tag::findOrCreate('Sale', 'en');

        $product->attachTags([$tag1, $tag2, $tag3]);

        // Reload product with tags
        $product->load('tags');

        // Create form and load product
        $component = Mockery::mock(Component::class);
        $form = new ProductForm($component, 'form');
        $form->setProduct($product);

        // Verify all tag IDs are loaded
        expect($form->tag_ids)
            ->toBeArray()
            ->toHaveCount(3)
            ->toContain($tag1->id)
            ->toContain($tag2->id)
            ->toContain($tag3->id);
    });

    /**
     * Property Test: Tag loading is idempotent
     * 
     * Tests that loading the same product multiple times produces
     * the same tag_ids result.
     */
    it('produces consistent tag_ids when loading same product multiple times', function () {
        // Create product with tags
        $product = Product::factory()->create();

        $tag1 = Tag::findOrCreate('Consistent Tag 1');
        $tag2 = Tag::findOrCreate('Consistent Tag 2');
        $product->attachTags([$tag1, $tag2]);

        $product->load('tags');

        // Load product into form multiple times
        $component = Mockery::mock(Component::class);

        $form1 = new ProductForm($component, 'form');
        $form1->setProduct($product);
        $firstLoad = $form1->tag_ids;

        $form2 = new ProductForm($component, 'form');
        $form2->setProduct($product);
        $secondLoad = $form2->tag_ids;

        $form3 = new ProductForm($component, 'form');
        $form3->setProduct($product);
        $thirdLoad = $form3->tag_ids;

        // All loads should produce identical results
        expect($firstLoad)->toEqual($secondLoad)
            ->and($secondLoad)->toEqual($thirdLoad);
    });

    /**
     * Property Test: Empty tag_ids for products without tags
     * 
     * Tests that products with no tags result in an empty tag_ids array.
     */
    it('loads empty tag_ids array for products without tags', function () {
        // Create multiple products without tags
        for ($i = 0; $i < 5; $i++) {
            $product = Product::factory()->create([
                'name' => "Product without tags {$i}",
            ]);

            // Explicitly ensure no tags
            $product->load('tags');

            // Create form and load product
            $component = Mockery::mock(Component::class);
            $form = new ProductForm($component, 'form');
            $form->setProduct($product);

            // Verify tag_ids is empty array
            expect($form->tag_ids)
                ->toBeArray()
                ->toBeEmpty();
        }
    });

    /**
     * Property Test: Tag loading works with large number of tags
     * 
     * Tests that the system can handle products with many tags.
     */
    it('loads tag_ids correctly for products with many tags', function () {
        // Create product
        $product = Product::factory()->create();

        // Create 50 tags
        $expectedTagIds = [];
        for ($i = 0; $i < 50; $i++) {
            $tag = Tag::findOrCreate("Tag {$i}");
            $product->attachTag($tag);
            $expectedTagIds[] = $tag->id;
        }

        // Reload product with tags
        $product->load('tags');

        // Create form and load product
        $component = Mockery::mock(Component::class);
        $form = new ProductForm($component, 'form');
        $form->setProduct($product);

        // Verify all 50 tag IDs are loaded
        expect($form->tag_ids)
            ->toBeArray()
            ->toHaveCount(50)
            ->toEqual($expectedTagIds);
    });
});
