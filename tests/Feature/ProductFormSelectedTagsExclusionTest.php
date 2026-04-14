<?php

use App\Livewire\Forms\Admin\ProductForm;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/**
 * Property 4: Selected Tags Excluded from Search
 * 
 * **Validates: Requirements 2.3**
 * 
 * For any set of selected tags and search query, no selected tag SHALL appear 
 * in the search results.
 */
test('property: selected tags are excluded from search results', function () {
    // Run the property test multiple times with different random inputs
    $iterations = 100;

    for ($i = 0; $i < $iterations; $i++) {
        // Generate random test data
        $numTags = rand(10, 25);
        $tags = [];

        // Create random tags with a common substring for searching
        $commonSubstring = 'tag_' . uniqid();
        for ($j = 0; $j < $numTags; $j++) {
            $tagName = $commonSubstring . '_' . fake()->word() . '_' . $j;
            $tag = Tag::findOrCreate($tagName);
            $tags[] = [
                'id' => $tag->id,
                'name' => $tag->getTranslation('name', 'en'),
            ];
        }

        // Randomly select some tags as "already selected"
        $numSelected = rand(1, min(10, count($tags)));
        $selectedIndices = array_rand($tags, $numSelected);

        // Handle case where array_rand returns a single integer instead of array
        if (!is_array($selectedIndices)) {
            $selectedIndices = [$selectedIndices];
        }

        $selectedTagIds = array_map(fn($idx) => $tags[$idx]['id'], $selectedIndices);

        // Create a mock component with the trait
        $mockComponent = Mockery::mock('Livewire\Component');
        $form = new ProductForm($mockComponent, 'form');
        $form->tag_ids = $selectedTagIds;

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

        // Search for the common substring (should match all tags)
        $component->tagQuery = $commonSubstring;

        // Get search results
        $results = $component->tagResults();

        // Property assertion: None of the selected tags should appear in results
        $resultIds = array_column($results, 'id');

        foreach ($selectedTagIds as $selectedId) {
            expect(in_array($selectedId, $resultIds, true))
                ->toBeFalse(
                    "Iteration {$i}: Selected tag ID {$selectedId} should not appear in search results"
                );
        }

        // Additional assertion: Verify that unselected tags DO appear in results
        $unselectedTagIds = array_diff(
            array_column($tags, 'id'),
            $selectedTagIds
        );

        // At least some unselected tags should appear (up to the limit of 10)
        $expectedResultCount = min(10, count($unselectedTagIds));
        expect(count($results))
            ->toBe(
                $expectedResultCount,
                "Iteration {$i}: Expected {$expectedResultCount} unselected tags in results, got " . count($results)
            );

        // Verify all results are from unselected tags
        foreach ($resultIds as $resultId) {
            expect(in_array($resultId, $unselectedTagIds, true))
                ->toBeTrue(
                    "Iteration {$i}: Result tag ID {$resultId} should be from unselected tags"
                );
        }
    }
});

test('property: selected tags exclusion works with partial name matches', function () {
    // Run multiple iterations
    $iterations = 50;

    for ($i = 0; $i < $iterations; $i++) {
        // Create tags with overlapping names using unique prefix
        $uniquePrefix = 'electr_' . uniqid();
        $baseNames = ['onics', 'onic', 'on', 'ic'];
        $createdTags = [];

        foreach ($baseNames as $baseName) {
            $uniqueName = $uniquePrefix . $baseName;
            $tag = Tag::findOrCreate($uniqueName);
            $createdTags[] = [
                'id' => $tag->id,
                'name' => $tag->getTranslation('name', 'en'),
            ];
        }

        // Select some tags randomly
        $numSelected = rand(1, count($createdTags) - 1);
        $selectedIndices = array_rand($createdTags, $numSelected);

        if (!is_array($selectedIndices)) {
            $selectedIndices = [$selectedIndices];
        }

        $selectedTagIds = array_map(fn($idx) => $createdTags[$idx]['id'], $selectedIndices);

        // Create a mock component with the trait
        $mockComponent = Mockery::mock('Livewire\Component');
        $form = new ProductForm($mockComponent, 'form');
        $form->tag_ids = $selectedTagIds;

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

        // Search for the unique prefix that matches only our created tags
        $component->tagQuery = $uniquePrefix;

        // Get search results
        $results = $component->tagResults();
        $resultIds = array_column($results, 'id');

        // Property assertion: None of the selected tags should appear
        foreach ($selectedTagIds as $selectedId) {
            expect(in_array($selectedId, $resultIds, true))
                ->toBeFalse(
                    "Iteration {$i}: Selected tag ID {$selectedId} should not appear in search results"
                );
        }

        // Verify only unselected tags from our created set appear
        $unselectedTagIds = array_diff(
            array_column($createdTags, 'id'),
            $selectedTagIds
        );

        // All results should be from our unselected tags
        foreach ($resultIds as $resultId) {
            expect(in_array($resultId, $unselectedTagIds, true))
                ->toBeTrue(
                    "Iteration {$i}: Result tag ID {$resultId} should be from unselected tags"
                );
        }

        // Verify we got the expected number of results
        $expectedCount = min(10, count($unselectedTagIds));
        expect(count($results))
            ->toBe(
                $expectedCount,
                "Iteration {$i}: Expected {$expectedCount} unselected tags in results"
            );
    }
});

test('property: all tags selected means empty search results', function () {
    // Run multiple iterations
    $iterations = 50;

    for ($i = 0; $i < $iterations; $i++) {
        // Create a set of tags
        $numTags = rand(3, 15);
        $commonSubstring = 'alltags_' . uniqid();
        $allTagIds = [];

        for ($j = 0; $j < $numTags; $j++) {
            $tag = Tag::findOrCreate($commonSubstring . '_' . $j);
            $allTagIds[] = $tag->id;
        }

        // Select ALL tags
        $mockComponent = Mockery::mock('Livewire\Component');
        $form = new ProductForm($mockComponent, 'form');
        $form->tag_ids = $allTagIds;

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

        // Search for the common substring
        $component->tagQuery = $commonSubstring;

        // Get search results
        $results = $component->tagResults();

        // Property assertion: When all matching tags are selected, results should be empty
        expect(count($results))
            ->toBe(
                0,
                "Iteration {$i}: Expected no results when all matching tags are selected"
            );
    }
});

test('property: exclusion works with negative pending tag IDs', function () {
    // Run multiple iterations
    $iterations = 50;

    for ($i = 0; $i < $iterations; $i++) {
        // Create some real tags
        $numTags = rand(5, 15);
        $commonSubstring = 'pending_' . uniqid();
        $realTagIds = [];

        for ($j = 0; $j < $numTags; $j++) {
            $tag = Tag::findOrCreate($commonSubstring . '_' . $j);
            $realTagIds[] = $tag->id;
        }

        // Mix real tag IDs with negative (pending) IDs
        $numPending = rand(1, 5);
        $pendingIds = [];
        for ($j = 0; $j < $numPending; $j++) {
            $pendingIds[] = -($j + 1);
        }

        // Select some real tags and some pending tags
        $numSelectedReal = rand(1, min(5, count($realTagIds)));
        $selectedRealIds = array_slice($realTagIds, 0, $numSelectedReal);
        $allSelectedIds = array_merge($selectedRealIds, $pendingIds);

        // Create a mock component with the trait
        $mockComponent = Mockery::mock('Livewire\Component');
        $form = new ProductForm($mockComponent, 'form');
        $form->tag_ids = $allSelectedIds;

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

        // Search for the common substring
        $component->tagQuery = $commonSubstring;

        // Get search results
        $results = $component->tagResults();
        $resultIds = array_column($results, 'id');

        // Property assertion: Selected real tags should not appear
        foreach ($selectedRealIds as $selectedId) {
            expect(in_array($selectedId, $resultIds, true))
                ->toBeFalse(
                    "Iteration {$i}: Selected real tag ID {$selectedId} should not appear in search results"
                );
        }

        // Property assertion: Negative IDs should never appear in results (they're pending)
        foreach ($resultIds as $resultId) {
            expect($resultId)
                ->toBeGreaterThan(
                    0,
                    "Iteration {$i}: Result should only contain positive (real) tag IDs, got {$resultId}"
                );
        }

        // Verify unselected real tags DO appear
        $unselectedRealIds = array_diff($realTagIds, $selectedRealIds);
        $expectedCount = min(10, count($unselectedRealIds));

        expect(count($results))
            ->toBe(
                $expectedCount,
                "Iteration {$i}: Expected {$expectedCount} unselected tags in results"
            );
    }
});

test('property: exclusion is case-insensitive for search but respects selected IDs', function () {
    // Run multiple iterations
    $iterations = 50;

    for ($i = 0; $i < $iterations; $i++) {
        // Create tags with mixed case names
        $baseWord = fake()->word();
        $variations = [
            strtolower($baseWord),
            strtoupper($baseWord),
            ucfirst(strtolower($baseWord)),
        ];

        $createdTags = [];
        foreach ($variations as $variation) {
            $uniqueName = $variation . '_' . uniqid();
            $tag = Tag::findOrCreate($uniqueName);
            $createdTags[] = [
                'id' => $tag->id,
                'name' => $tag->getTranslation('name', 'en'),
            ];
        }

        // Select one tag
        $selectedTagId = $createdTags[0]['id'];

        // Create a mock component with the trait
        $mockComponent = Mockery::mock('Livewire\Component');
        $form = new ProductForm($mockComponent, 'form');
        $form->tag_ids = [$selectedTagId];

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

        // Search with different case variations
        $searchVariations = [
            strtolower($baseWord),
            strtoupper($baseWord),
            ucfirst(strtolower($baseWord)),
        ];

        foreach ($searchVariations as $searchQuery) {
            $component->tagQuery = $searchQuery;
            $results = $component->tagResults();
            $resultIds = array_column($results, 'id');

            // Property assertion: Selected tag should not appear regardless of search case
            expect(in_array($selectedTagId, $resultIds, true))
                ->toBeFalse(
                    "Iteration {$i}: Selected tag ID {$selectedTagId} should not appear with query '{$searchQuery}'"
                );

            // The other tags should appear
            expect(count($results))
                ->toBeGreaterThan(
                    0,
                    "Iteration {$i}: Should find unselected tags with query '{$searchQuery}'"
                );
        }
    }
});
