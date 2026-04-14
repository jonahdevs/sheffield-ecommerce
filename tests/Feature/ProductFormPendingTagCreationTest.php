<?php

use App\Livewire\Forms\Admin\ProductForm;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/**
 * Property 16: Pending Tags Created Before Sync
 * 
 * **Validates: Requirements 5.2**
 * 
 * For any set of pending tags, saving the product SHALL create all pending tags 
 * in the database before establishing the product-tag associations.
 */
test('property: pending tags are created in database before sync', function () {
    // Run the property test multiple times with different random inputs
    $iterations = 100;

    for ($i = 0; $i < $iterations; $i++) {
        // Generate random test data
        $numPendingTags = rand(1, 10);
        $numExistingTags = rand(0, 5);

        // Create a product
        $product = Product::factory()->create();

        // Create some existing tags
        $existingTagIds = [];
        for ($j = 0; $j < $numExistingTags; $j++) {
            $tag = Tag::findOrCreate("ExistingTag_" . uniqid());
            $existingTagIds[] = $tag->id;
        }

        // Generate pending tags with negative IDs and names
        $pendingTags = [];
        $pendingTagIds = [];
        for ($j = 0; $j < $numPendingTags; $j++) {
            $pendingId = -($j + 1);
            $pendingName = "PendingTag_" . uniqid();
            $pendingTags[$pendingId] = $pendingName;
            $pendingTagIds[] = $pendingId;
        }

        // Combine existing and pending tag IDs
        $allTagIds = array_merge($existingTagIds, $pendingTagIds);

        // Record the initial tag count in the database
        $initialTagCount = Tag::count();

        // Create ProductForm and set tag_ids
        $component = Mockery::mock('Livewire\Component');
        $form = new ProductForm($component, 'form');
        $form->tag_ids = $allTagIds;

        // Set the pendingTags property on the form (simulating component state)
        $form->pendingTags = $pendingTags;

        // Use reflection to call the protected syncTags method
        $reflection = new ReflectionClass($form);
        $method = $reflection->getMethod('syncTags');
        $method->setAccessible(true);

        // Execute the sync
        $method->invoke($form, $product);

        // Refresh the product to get updated relationships
        $product->refresh();

        // Property assertion 1: All pending tags should now exist in the database
        $finalTagCount = Tag::count();
        expect($finalTagCount)
            ->toBe(
                $initialTagCount + $numPendingTags,
                "Iteration {$i}: Expected {$numPendingTags} new tags to be created"
            );

        // Property assertion 2: All pending tag names should exist in the database
        foreach ($pendingTags as $pendingName) {
            $trimmedName = trim($pendingName);
            $tag = Tag::findFromString($trimmedName);
            expect($tag)
                ->not->toBeNull(
                    "Iteration {$i}: Pending tag '{$trimmedName}' was not created in database"
                );
        }

        // Property assertion 3: Product should be associated with all tags (existing + created)
        $expectedTotalTags = $numExistingTags + $numPendingTags;
        expect($product->tags()->count())
            ->toBe(
                $expectedTotalTags,
                "Iteration {$i}: Expected {$expectedTotalTags} tags associated with product"
            );

        // Property assertion 4: Product should have the correct tag names
        $productTagNames = $product->tags->map(fn($tag) => $tag->getTranslation('name', 'en'))->sort()->values()->toArray();
        $existingTagNames = Tag::whereIn('id', $existingTagIds)->get()->map(fn($tag) => $tag->getTranslation('name', 'en'))->toArray();
        $expectedTagNames = array_merge(
            $existingTagNames,
            array_map('trim', array_values($pendingTags))
        );
        sort($expectedTagNames);

        expect($productTagNames)
            ->toBe(
                $expectedTagNames,
                "Iteration {$i}: Product tag names don't match expected"
            );
    }
});

test('property: pending tags with whitespace are trimmed before creation', function () {
    // Run multiple iterations
    $iterations = 50;

    for ($i = 0; $i < $iterations; $i++) {
        // Create a product
        $product = Product::factory()->create();

        // Generate pending tags with various whitespace patterns
        $pendingTags = [];
        $numTags = rand(1, 5);

        for ($j = 0; $j < $numTags; $j++) {
            $pendingId = -($j + 1);
            $baseName = "Tag_" . uniqid();

            // Add random whitespace (spaces, tabs, newlines)
            $whitespacePatterns = [
                " {$baseName}",           // leading space
                "{$baseName} ",           // trailing space
                " {$baseName} ",          // both
                "  {$baseName}  ",        // multiple spaces
                "\t{$baseName}",          // leading tab
                "{$baseName}\n",          // trailing newline
                " \t{$baseName} \n",      // mixed whitespace
            ];

            $nameWithWhitespace = $whitespacePatterns[array_rand($whitespacePatterns)];
            $pendingTags[$pendingId] = $nameWithWhitespace;
        }

        // Create ProductForm
        $component = Mockery::mock('Livewire\Component');
        $form = new ProductForm($component, 'form');
        $form->tag_ids = array_keys($pendingTags);
        $form->pendingTags = $pendingTags;

        // Use reflection to call the protected syncTags method
        $reflection = new ReflectionClass($form);
        $method = $reflection->getMethod('syncTags');
        $method->setAccessible(true);

        // Execute the sync
        $method->invoke($form, $product);

        // Refresh the product
        $product->refresh();

        // Property assertion: All tags should be stored with trimmed names
        foreach ($pendingTags as $nameWithWhitespace) {
            $trimmedName = trim($nameWithWhitespace);
            $tag = Tag::findFromString($trimmedName);

            expect($tag)
                ->not->toBeNull(
                    "Iteration {$i}: Tag with trimmed name '{$trimmedName}' should exist"
                );

            // Verify the tag name doesn't have leading/trailing whitespace
            expect($tag->getTranslation('name', 'en'))
                ->toBe(
                    $trimmedName,
                    "Iteration {$i}: Tag name should be trimmed"
                );
        }
    }
});

test('property: pending tags are created only once even with duplicate names', function () {
    // Run multiple iterations
    $iterations = 50;

    for ($i = 0; $i < $iterations; $i++) {
        // Create a product
        $product = Product::factory()->create();

        // Create pending tags with some duplicate names
        $baseName = "DuplicateTag_" . uniqid();
        $numDuplicates = rand(2, 5);

        $pendingTags = [];
        for ($j = 0; $j < $numDuplicates; $j++) {
            $pendingId = -($j + 1);
            $pendingTags[$pendingId] = $baseName; // Same name for all
        }

        // Record initial tag count
        $initialTagCount = Tag::count();

        // Create ProductForm
        $component = Mockery::mock('Livewire\Component');
        $form = new ProductForm($component, 'form');
        $form->tag_ids = array_keys($pendingTags);
        $form->pendingTags = $pendingTags;

        // Use reflection to call the protected syncTags method
        $reflection = new ReflectionClass($form);
        $method = $reflection->getMethod('syncTags');
        $method->setAccessible(true);

        // Execute the sync
        $method->invoke($form, $product);

        // Refresh the product
        $product->refresh();

        // Property assertion: Only ONE tag should be created despite multiple pending entries
        $finalTagCount = Tag::count();
        expect($finalTagCount)
            ->toBe(
                $initialTagCount + 1,
                "Iteration {$i}: Expected only 1 tag to be created for duplicate names"
            );

        // Property assertion: Product should have only one tag
        expect($product->tags()->count())
            ->toBe(
                1,
                "Iteration {$i}: Product should have only 1 tag despite duplicate pending entries"
            );

        // Verify the tag name
        expect($product->tags->first()->getTranslation('name', 'en'))
            ->toBe($baseName);
    }
});

test('property: mixed existing and pending tags are synced correctly', function () {
    // Run multiple iterations
    $iterations = 50;

    for ($i = 0; $i < $iterations; $i++) {
        // Create a product
        $product = Product::factory()->create();

        // Create some existing tags
        $numExisting = rand(1, 5);
        $existingTagIds = [];
        for ($j = 0; $j < $numExisting; $j++) {
            $tag = Tag::findOrCreate("Existing_" . uniqid());
            $existingTagIds[] = $tag->id;
        }

        // Create some pending tags
        $numPending = rand(1, 5);
        $pendingTags = [];
        $pendingTagIds = [];
        for ($j = 0; $j < $numPending; $j++) {
            $pendingId = -($j + 1);
            $pendingName = "Pending_" . uniqid();
            $pendingTags[$pendingId] = $pendingName;
            $pendingTagIds[] = $pendingId;
        }

        // Mix them together
        $allTagIds = array_merge($existingTagIds, $pendingTagIds);

        // Shuffle to ensure order doesn't matter
        shuffle($allTagIds);

        // Create ProductForm
        $component = Mockery::mock('Livewire\Component');
        $form = new ProductForm($component, 'form');
        $form->tag_ids = $allTagIds;
        $form->pendingTags = $pendingTags;

        // Use reflection to call the protected syncTags method
        $reflection = new ReflectionClass($form);
        $method = $reflection->getMethod('syncTags');
        $method->setAccessible(true);

        // Execute the sync
        $method->invoke($form, $product);

        // Refresh the product
        $product->refresh();

        // Property assertion: Product should have all tags (existing + pending)
        $expectedTotal = $numExisting + $numPending;
        expect($product->tags()->count())
            ->toBe(
                $expectedTotal,
                "Iteration {$i}: Expected {$expectedTotal} tags (existing + pending)"
            );

        // Property assertion: All existing tags should be associated
        foreach ($existingTagIds as $existingId) {
            $hasTag = $product->tags->contains('id', $existingId);
            expect($hasTag)
                ->toBeTrue(
                    "Iteration {$i}: Product should have existing tag ID {$existingId}"
                );
        }

        // Property assertion: All pending tags should be created and associated
        foreach ($pendingTags as $pendingName) {
            $trimmedName = trim($pendingName);
            $tag = Tag::findFromString($trimmedName);
            expect($tag)
                ->not->toBeNull(
                    "Iteration {$i}: Pending tag '{$trimmedName}' should be created"
                );

            $hasTag = $product->tags->contains('id', $tag->id);
            expect($hasTag)
                ->toBeTrue(
                    "Iteration {$i}: Product should have newly created tag '{$trimmedName}'"
                );
        }
    }
});
