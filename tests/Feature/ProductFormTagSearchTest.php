<?php

use App\Livewire\Forms\Admin\ProductForm;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/**
 * Property 2: Search Results Match Query
 * 
 * **Validates: Requirements 1.5, 2.1**
 * 
 * For any search query string and tag database, all returned search results 
 * SHALL contain the query string (case-insensitive) in the tag name.
 */
test('property: search results match query string case-insensitively', function () {
    // Run the property test multiple times with different random inputs
    $iterations = 100;

    for ($i = 0; $i < $iterations; $i++) {
        // Generate random test data
        $numTags = rand(5, 20);
        $tags = [];

        // Create random tags with various names
        for ($j = 0; $j < $numTags; $j++) {
            // Use a combination of faker and unique ID to avoid running out of unique words
            $baseName = fake()->word() . '_' . uniqid();
            $tag = Tag::findOrCreate($baseName);
            $tags[] = [
                'id' => $tag->id,
                'name' => $tag->getTranslation('name', 'en'),
            ];
        }

        // Pick a random tag and extract a substring for the query
        $randomTag = $tags[array_rand($tags)];
        $tagName = $randomTag['name'];

        // Generate query: substring of the tag name with random casing
        $queryLength = rand(1, min(strlen($tagName), 5));
        $startPos = rand(0, strlen($tagName) - $queryLength);
        $substring = substr($tagName, $startPos, $queryLength);

        // Randomly change case to test case-insensitivity
        $query = match (rand(0, 2)) {
            0 => strtolower($substring),
            1 => strtoupper($substring),
            2 => ucfirst(strtolower($substring)),
        };

        // Create a mock component with the trait
        $mockComponent = Mockery::mock('Livewire\Component');
        $form = new ProductForm($mockComponent, 'form');

        // Create a test component instance that uses the trait
        $component = new class ($mockComponent, $form) {
            use \App\Livewire\Concerns\ManagesProductForm;

            public $form;

            public function __construct($mockComponent, $form)
            {
                $this->form = $form;
            }

            public function render()
            {
                return ''; }
        };

        // Set the query
        $component->tagQuery = $query;

        // Get search results
        $results = $component->tagResults();

        // Property assertion: All results must contain the query string (case-insensitive)
        foreach ($results as $result) {
            $resultName = is_array($result['name'])
                ? ($result['name']['en'] ?? '')
                : $result['name'];

            $containsQuery = stripos($resultName, $query) !== false;

            expect($containsQuery)
                ->toBeTrue(
                    "Iteration {$i}: Result '{$resultName}' does not contain query '{$query}' (case-insensitive)"
                );
        }

        // Additional assertion: Verify results are not empty when matching tags exist
        $matchingTags = array_filter($tags, function ($tag) use ($query) {
            return stripos($tag['name'], $query) !== false;
        });

        // If there are matching tags in the database, we should get some results
        // (unless all matching tags are selected, but we're not selecting any in this test)
        if (count($matchingTags) > 0) {
            expect(count($results))
                ->toBeGreaterThan(
                    0,
                    "Iteration {$i}: Expected at least one result for query '{$query}' when matching tags exist"
                );
        }
    }
});

test('property: search results are limited to 10 items', function () {
    // Run multiple iterations
    $iterations = 50;

    for ($i = 0; $i < $iterations; $i++) {
        // Create many tags with a common substring
        $commonSubstring = 'test' . uniqid();
        $numTags = rand(15, 30); // More than the limit of 10

        for ($j = 0; $j < $numTags; $j++) {
            Tag::findOrCreate($commonSubstring . '_' . $j);
        }

        // Create a mock component with the trait
        $mockComponent = Mockery::mock('Livewire\Component');
        $form = new ProductForm($mockComponent, 'form');

        $component = new class ($mockComponent, $form) {
            use \App\Livewire\Concerns\ManagesProductForm;

            public $form;

            public function __construct($mockComponent, $form)
            {
                $this->form = $form;
            }

            public function render()
            {
                return ''; }
        };

        // Search for the common substring
        $component->tagQuery = $commonSubstring;

        // Get search results
        $results = $component->tagResults();

        // Property assertion: Results should be limited to 10
        expect(count($results))
            ->toBeLessThanOrEqual(
                10,
                "Iteration {$i}: Expected at most 10 results, got " . count($results)
            );
    }
});

test('property: empty or whitespace-only queries return no results', function () {
    // Run multiple iterations with different whitespace patterns
    $iterations = 50;

    for ($i = 0; $i < $iterations; $i++) {
        // Create some tags
        $numTags = rand(5, 10);
        for ($j = 0; $j < $numTags; $j++) {
            Tag::findOrCreate('Tag_' . uniqid());
        }

        // Generate whitespace-only queries
        $whitespaceQueries = [
            '',
            ' ',
            '  ',
            "\t",
            "\n",
            " \t ",
            "   \n   ",
        ];

        $query = $whitespaceQueries[array_rand($whitespaceQueries)];

        // Create a mock component with the trait
        $mockComponent = Mockery::mock('Livewire\Component');
        $form = new ProductForm($mockComponent, 'form');

        $component = new class ($mockComponent, $form) {
            use \App\Livewire\Concerns\ManagesProductForm;

            public $form;

            public function __construct($mockComponent, $form)
            {
                $this->form = $form;
            }

            public function render()
            {
                return ''; }
        };

        // Set the query
        $component->tagQuery = $query;

        // Get search results
        $results = $component->tagResults();

        // Property assertion: Empty/whitespace queries should return no results
        expect(count($results))
            ->toBe(
                0,
                "Iteration {$i}: Expected no results for whitespace query, got " . count($results)
            );
    }
});

test('property: search excludes already selected tags', function () {
    // Run multiple iterations
    $iterations = 50;

    for ($i = 0; $i < $iterations; $i++) {
        // Create tags with a common substring
        $commonSubstring = 'selected' . uniqid();
        $numTags = rand(5, 15);
        $createdTags = [];

        for ($j = 0; $j < $numTags; $j++) {
            $tag = Tag::findOrCreate($commonSubstring . '_' . $j);
            $createdTags[] = $tag->id;
        }

        // Randomly select some tags as "already selected"
        $numSelected = rand(1, min(5, count($createdTags)));
        $selectedTagIds = array_slice($createdTags, 0, $numSelected);

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
                return ''; }
        };

        // Search for the common substring
        $component->tagQuery = $commonSubstring;

        // Get search results
        $results = $component->tagResults();

        // Property assertion: None of the selected tags should appear in results
        $resultIds = array_column($results, 'id');

        foreach ($selectedTagIds as $selectedId) {
            expect(in_array($selectedId, $resultIds))
                ->toBeFalse(
                    "Iteration {$i}: Selected tag ID {$selectedId} should not appear in search results"
                );
        }
    }
});

test('property: search handles special regex characters safely', function () {
    // Run multiple iterations with special characters
    $iterations = 50;

    for ($i = 0; $i < $iterations; $i++) {
        // Create tags with special characters
        $specialChars = ['(', ')', '[', ']', '{', '}', '.', '*', '+', '?', '^', '$', '|', '\\'];
        $randomChar = $specialChars[array_rand($specialChars)];

        // Create a tag with the special character
        $tagName = 'tag' . $randomChar . 'name' . uniqid();
        Tag::findOrCreate($tagName);

        // Create a mock component with the trait
        $mockComponent = Mockery::mock('Livewire\Component');
        $form = new ProductForm($mockComponent, 'form');

        $component = new class ($mockComponent, $form) {
            use \App\Livewire\Concerns\ManagesProductForm;

            public $form;

            public function __construct($mockComponent, $form)
            {
                $this->form = $form;
            }

            public function render()
            {
                return ''; }
        };

        // Search using the special character
        $component->tagQuery = $randomChar;

        // Property assertion: Should not throw an error
        try {
            $results = $component->tagResults();
            expect(true)->toBeTrue(); // If we get here, no error was thrown
        } catch (\Exception $e) {
            expect(false)
                ->toBeTrue(
                    "Iteration {$i}: Search with special character '{$randomChar}' threw exception: {$e->getMessage()}"
                );
        }
    }
});
