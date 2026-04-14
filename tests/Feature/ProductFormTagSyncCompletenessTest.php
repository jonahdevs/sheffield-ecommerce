<?php

use App\Livewire\Forms\Admin\ProductForm;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/**
 * Property 15: Tag Sync Completeness
 * 
 * **Validates: Requirements 5.1, 5.3, 5.4**
 * 
 * For any set of selected tags, saving the product SHALL result in the product 
 * being associated with exactly those tags in the database (no more, no less).
 */
test('property: tag sync completeness - product has exactly the selected tags after save', function () {
    // Run the property test multiple times with different random inputs
    $iterations = 100;

    for ($i = 0; $i < $iterations; $i++) {
        // Generate random test data
        $numExistingTags = rand(0, 10);
        $numSelectedTags = rand(0, 8);

        // Create a pool of existing tags in the database
        $existingTags = [];
        for ($j = 0; $j < $numExistingTags; $j++) {
            $existingTags[] = Tag::findOrCreate("Tag_" . uniqid());
        }

        // Create a product
        $product = Product::factory()->create();

        // Randomly assign some initial tags to the product (to test removal)
        $initialTagCount = rand(0, min(5, $numExistingTags));
        if ($initialTagCount > 0 && count($existingTags) > 0) {
            $initialTags = array_slice($existingTags, 0, $initialTagCount);
            foreach ($initialTags as $tag) {
                $product->attachTag($tag);
            }
        }

        // Select a random subset of tags to sync
        $selectedTagIds = [];
        if ($numSelectedTags > 0 && count($existingTags) > 0) {
            $selectedIndices = array_rand(
                $existingTags,
                min($numSelectedTags, count($existingTags))
            );

            // Handle case where array_rand returns single value instead of array
            if (!is_array($selectedIndices)) {
                $selectedIndices = [$selectedIndices];
            }

            foreach ($selectedIndices as $index) {
                $selectedTagIds[] = $existingTags[$index]->id;
            }
        }

        // Create ProductForm and set tag_ids
        $component = Mockery::mock('Livewire\Component');
        $form = new ProductForm($component, 'form');
        $form->tag_ids = $selectedTagIds;

        // Use reflection to call the protected syncTags method
        $reflection = new ReflectionClass($form);
        $method = $reflection->getMethod('syncTags');
        $method->setAccessible(true);

        // Execute the sync
        $method->invoke($form, $product);

        // Refresh the product to get updated relationships
        $product->refresh();

        // Property assertion: Product should have exactly the selected tags
        $actualTagIds = $product->tags->pluck('id')->sort()->values()->toArray();
        $expectedTagIds = collect($selectedTagIds)->sort()->values()->toArray();

        expect($actualTagIds)
            ->toBe(
                $expectedTagIds,
                "Iteration {$i}: Expected tags " . json_encode($expectedTagIds) .
                " but got " . json_encode($actualTagIds)
            );

        // Additional assertion: Count should match
        expect($product->tags()->count())
            ->toBe(
                count($selectedTagIds),
                "Iteration {$i}: Tag count mismatch"
            );
    }
});

test('property: tag sync completeness - empty selection removes all tags', function () {
    // Run multiple iterations
    $iterations = 50;

    for ($i = 0; $i < $iterations; $i++) {
        // Create a product with random number of initial tags
        $product = Product::factory()->create();
        $numInitialTags = rand(1, 10);

        for ($j = 0; $j < $numInitialTags; $j++) {
            $tag = Tag::findOrCreate("InitialTag_" . uniqid());
            $product->attachTag($tag);
        }

        // Verify product has tags
        expect($product->tags()->count())->toBeGreaterThan(0);

        // Create ProductForm with empty tag_ids
        $component = Mockery::mock('Livewire\Component');
        $form = new ProductForm($component, 'form');
        $form->tag_ids = [];

        // Use reflection to call the protected syncTags method
        $reflection = new ReflectionClass($form);
        $method = $reflection->getMethod('syncTags');
        $method->setAccessible(true);

        // Execute the sync
        $method->invoke($form, $product);

        // Refresh the product
        $product->refresh();

        // Property assertion: Product should have no tags
        expect($product->tags()->count())
            ->toBe(0, "Iteration {$i}: Expected 0 tags but got " . $product->tags()->count());
    }
});

test('property: tag sync completeness - sync is idempotent', function () {
    // Run multiple iterations
    $iterations = 50;

    for ($i = 0; $i < $iterations; $i++) {
        // Create a product
        $product = Product::factory()->create();

        // Create random tags
        $numTags = rand(1, 8);
        $tagIds = [];
        for ($j = 0; $j < $numTags; $j++) {
            $tag = Tag::findOrCreate("Tag_" . uniqid());
            $tagIds[] = $tag->id;
        }

        // Create ProductForm
        $component = Mockery::mock('Livewire\Component');
        $form = new ProductForm($component, 'form');
        $form->tag_ids = $tagIds;

        // Use reflection to call the protected syncTags method
        $reflection = new ReflectionClass($form);
        $method = $reflection->getMethod('syncTags');
        $method->setAccessible(true);

        // Execute the sync twice
        $method->invoke($form, $product);
        $product->refresh();
        $firstSyncTagIds = $product->tags->pluck('id')->sort()->values()->toArray();

        $method->invoke($form, $product);
        $product->refresh();
        $secondSyncTagIds = $product->tags->pluck('id')->sort()->values()->toArray();

        // Property assertion: Syncing twice should produce the same result
        expect($secondSyncTagIds)
            ->toBe(
                $firstSyncTagIds,
                "Iteration {$i}: Sync is not idempotent"
            );

        expect($secondSyncTagIds)
            ->toBe(
                collect($tagIds)->sort()->values()->toArray(),
                "Iteration {$i}: Tags don't match expected after double sync"
            );
    }
});
