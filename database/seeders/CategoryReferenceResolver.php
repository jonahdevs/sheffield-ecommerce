<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Resolves the "category" value carried by each row of products.json to a category id.
 *
 * A bare name ("Ovens") is ambiguous the moment two branches of the tree reuse it —
 * "Coffee Machines > Automatic" and "Dishwashers > Automatic" would both answer to
 * "Automatic". Rows may therefore address a category by its full path, parent first:
 *
 *     "category": "Coffee Machines > Automatic"
 *
 * A bare name is still accepted while it stays unique, which keeps the top-level rows
 * (the bulk of the catalogue) short. Anything unknown or ambiguous throws rather than
 * seeding a null primary_category_id, which would drop the product off every category
 * page with no other symptom.
 */
class CategoryReferenceResolver
{
    public const SEPARATOR = '>';

    /** @var array<string, int> lowercased "parent > child" path → category id */
    private array $idByPath = [];

    /** @var array<string, list<string>> lowercased name → every path carrying that name */
    private array $pathsByName = [];

    public function __construct()
    {
        /** @var array<int, Category> $byId */
        $byId = Category::all()->keyBy('id')->all();

        foreach ($byId as $category) {
            $path = $this->pathOf($category, $byId);

            $this->idByPath[$this->normalise($path)] = $category->id;
            $this->pathsByName[$this->normalise($category->name)][] = $path;
        }
    }

    /**
     * @throws RuntimeException when the reference matches no category, or matches more
     *                          than one because a bare name is reused across branches.
     */
    public function idFor(string $reference): int
    {
        $key = $this->normalise($reference);

        if (isset($this->idByPath[$key])) {
            return $this->idByPath[$key];
        }

        // A path that missed is simply wrong; only a bare name can be ambiguous.
        if (str_contains($reference, self::SEPARATOR)) {
            throw new RuntimeException(sprintf('Unknown category path "%s".', $reference));
        }

        $paths = $this->pathsByName[$key] ?? [];

        if ($paths === []) {
            throw new RuntimeException(sprintf('Unknown category "%s".', $reference));
        }

        if (count($paths) > 1) {
            throw new RuntimeException(sprintf(
                'Category "%s" is ambiguous — it exists at %s. Use the full path.',
                $reference,
                implode(' and ', array_map(fn (string $p) => '"'.$p.'"', $paths)),
            ));
        }

        return $this->idByPath[$this->normalise($paths[0])];
    }

    /**
     * @param  array<int, Category>  $byId
     */
    private function pathOf(Category $category, array $byId): string
    {
        $segments = [$category->name];

        $parentId = $category->parent_id;

        while ($parentId !== null && isset($byId[$parentId])) {
            $parent = $byId[$parentId];
            array_unshift($segments, $parent->name);
            $parentId = $parent->parent_id;
        }

        return implode(' '.self::SEPARATOR.' ', $segments);
    }

    /**
     * Collapses casing and the spacing around separators, so "Coffee Machines>Automatic"
     * and "coffee machines > automatic" address the same category.
     */
    private function normalise(string $reference): string
    {
        $segments = array_map(
            fn (string $segment) => Str::lower(trim($segment)),
            explode(self::SEPARATOR, $reference),
        );

        return implode(' '.self::SEPARATOR.' ', $segments);
    }
}
