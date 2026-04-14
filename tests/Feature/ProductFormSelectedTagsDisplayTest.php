<?php

use App\Livewire\Forms\Admin\ProductForm;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/**
 * Property 1: Selected Tags Display
 * 
 * **Validates: Requirements 1.2, 6.2**
 * 
 * For any set of selected tags (existing or pending), all tags SHALL appear 
 * in the rendered UI with their names and appropriate indicators 
 * (sparkles icon for pending tags).
 */
test('property: selected tags display includes all existing and pending tags', function () {
    // Run the property test multiple times with different random inputs
    $iterations = 100;

    for ($i = 0; $i < $iterations; $i++) {
        // Generate random test data
        $numExistingTags = rand(0, 10);
        $numPendingTags = rand(0, 5);

        // Create existing tags in database
        $existingTags = [];
        for ($j = 0; $j < $numExistingTags; $j++) {
            $tag = Tag::findOrCreate('Tag_' . uniqid());
            $existingTags[] = $tag;
        }

        // Create a mock component
        $mockComponent = Mockery::mock('Livewire\Component');
        $form = new ProductForm($mockComponent, 'form');

        // Create test component instance that uses the trait
        $component = new class ($mockComponent, $form) {
            use \App\Livewire\Concerns\ManagesProductForm;

            public $form;

            public function __construct($mockComponent, $form)
            {
                $this->form = $form;
            }

            public function render()
            {
                return '';
            }
        };

        // Set up tag_ids with existing tags
        $existingTagIds = array_map(fn($tag) => $tag->id, $existingTags);
        $component->form->tag_ids = $existingTagIds;

        // Add pending tags
        $pendingTagIds = [];
        $pendingTagNames = [];
        for ($j = 0; $j < $numPendingTags; $j++) {
            $pendingId = -($j + 1);
            $pendingName = 'Pending_' . uniqid();
            $pendingTagIds[] = $pendingId;
            $pendingTagNames[$pendingId] = $pendingName;
            $component->form->tag_ids[] = $pendingId;
        }
        $component->pendingTags = $pendingTagNames;

        // Get selected tags
        $selectedTags = $component->selectedTags();

        // Property assertion 1: Total count should match
        expect(count($selectedTags))
            ->toBe(
                $numExistingTags + $numPendingTags,
                "Iteration {$i}: Expected " . ($numExistingTags + $numPendingTags) . " tags, got " . count($selectedTags)
            );

        // Property assertion 2: All existing tags should be present
        foreach ($existingTags as $tag) {
            $found = collect($selectedTags)->contains(fn($t) => $t['id'] === $tag->id);
            expect($found)
                ->toBeTrue("Iteration {$i}: Existing tag {$tag->id} not found in selected tags");
        }

        // Property assertion 3: All pending tags should be present with is_pending flag
        foreach ($pendingTagIds as $pendingId) {
            $found = collect($selectedTags)->first(fn($t) => $t['id'] === $pendingId);
            expect($found)
                ->not->toBeNull("Iteration {$i}: Pending tag {$pendingId} not found in selected tags");

            if ($found) {
                expect($found['is_pending'] ?? false)
                    ->toBeTrue("Iteration {$i}: Pending tag {$pendingId} should have is_pending flag");

                $expectedName = $pendingTagNames[$pendingId];
                $actualName = is_array($found['name']) ? ($found['name']['en'] ?? '') : $found['name'];
                expect($actualName)
                    ->toBe($expectedName, "Iteration {$i}: Pending tag {$pendingId} name mismatch");
            }
        }

        // Property assertion 4: Existing tags should NOT have is_pending flag
        foreach ($existingTags as $tag) {
            $found = collect($selectedTags)->first(fn($t) => $t['id'] === $tag->id);
            if ($found) {
                expect($found['is_pending'] ?? false)
                    ->toBeFalse("Iteration {$i}: Existing tag {$tag->id} should not have is_pending flag");
            }
        }
    }
});

test('property: selected tags display handles empty tag list', function () {
    // Create a mock component
    $mockComponent = Mockery::mock('Livewire\Component');
    $form = new ProductForm($mockComponent, 'form');

    // Create test component instance
    $component = new class ($mockComponent, $form) {
        use \App\Livewire\Concerns\ManagesProductForm;

        public $form;

        public function __construct($mockComponent, $form)
        {
            $this->form = $form;
        }

        public function render()
        {
            return '';
        }
    };

    // Set empty tag_ids
    $component->form->tag_ids = [];
    $component->pendingTags = [];

    // Get selected tags
    $selectedTags = $component->selectedTags();

    // Property assertion: Should return empty array
    expect($selectedTags)->toBeArray()->toBeEmpty();
});

test('property: selected tags display preserves all tag IDs', function () {
    // Run multiple iterations
    $iterations = 50;

    for ($i = 0; $i < $iterations; $i++) {
        // Create random number of tags with unique names
        $numTags = rand(3, 10);
        $tags = [];
        for ($j = 0; $j < $numTags; $j++) {
            // Use iteration and index to ensure uniqueness
            $tag = Tag::findOrCreate('OrderTest_i' . $i . '_j' . $j . '_' . uniqid());
            $tags[] = $tag;
        }

        // Create a mock component
        $mockComponent = Mockery::mock('Livewire\Component');
        $form = new ProductForm($mockComponent, 'form');

        // Create test component instance
        $component = new class ($mockComponent, $form) {
            use \App\Livewire\Concerns\ManagesProductForm;

            public $form;

            public function __construct($mockComponent, $form)
            {
                $this->form = $form;
            }

            public function render()
            {
                return '';
            }
        };

        // Set tag_ids
        $tagIds = array_map(fn($tag) => $tag->id, $tags);
        $component->form->tag_ids = $tagIds;
        $component->pendingTags = [];

        // Get selected tags
        $selectedTags = $component->selectedTags();

        // Property assertion: Count should match
        expect(count($selectedTags))->toBe(
            count($tagIds),
            "Iteration {$i}: Expected " . count($tagIds) . " tags, got " . count($selectedTags)
        );

        // Property assertion: All tag IDs should be present
        $selectedIds = array_map(fn($t) => $t['id'], $selectedTags);

        foreach ($tagIds as $expectedId) {
            $found = in_array($expectedId, $selectedIds);
            expect($found)->toBeTrue(
                "Iteration {$i}: Tag ID {$expectedId} not found. Expected IDs: " .
                implode(', ', $tagIds) . ". Got IDs: " . implode(', ', $selectedIds)
            );
        }
    }
});
