# Design Document: Product Tag Management

## Overview

This design implements tag management functionality within the admin product create and edit forms. The feature enables administrators to assign existing tags, create new tags inline, and manage tag associations directly from the product form interface without leaving the workflow.

The implementation leverages the existing Spatie Tags package infrastructure, which provides a polymorphic many-to-many relationship between products and tags. The UI follows established patterns from the category selection interface to maintain consistency and familiarity.

### Key Design Decisions

1. **Leverage Spatie Tags Package**: Use the existing `HasTags` trait and polymorphic relationship rather than building custom tag infrastructure
2. **Inline Tag Creation**: Allow tag creation directly in the product form to minimize workflow interruption
3. **UI Consistency**: Mirror the category selection pattern for familiar user experience
4. **Form Property Management**: Add `tag_ids` array property to ProductForm for consistent data handling
5. **Eager Loading**: Load tags with product relationships to avoid N+1 queries

## Architecture

### Component Structure

```
ProductForm (Livewire Component)
├── ProductForm (Form Class)
│   ├── tag_ids: array<int>
│   ├── validation rules
│   ├── hydration logic
│   └── persistence logic
├── ManagesProductForm (Trait)
│   ├── tag search state
│   ├── computed tag properties
│   └── tag action methods
└── _form-fields.blade.php (View)
    └── Tags Card (Sidebar Section)
        ├── Selected tags display
        ├── Tag search input
        ├── Search results dropdown
        └── Create new tag option
```

### Data Flow

1. **Load**: Product → tags relationship → ProductForm.tag_ids
2. **Search**: User input → filter tags → display results
3. **Select**: Click tag → add to tag_ids → update UI
4. **Create**: Enter new name → add to tag_ids (with negative ID) → create on save
5. **Remove**: Click remove → remove from tag_ids → update UI
6. **Save**: ProductForm.tag_ids → sync tags → persist associations

## Components and Interfaces

### ProductForm Class Extensions

**New Property:**

```php
/** @var array<int, int> */
public array $tag_ids = [];
```

**Validation Rules:**

```php
'tag_ids' => ['nullable', 'array'],
'tag_ids.*' => ['integer'],
```

**Hydration Method (setProduct):**

```php
// In setProduct method
$this->tag_ids = $product->tags->pluck('id')->toArray();
```

**Persistence Method (syncRelationships):**

```php
protected function syncTags(Product $product): void
{
    // Separate existing tags from new tags (negative IDs)
    $existingTagIds = array_filter($this->tag_ids, fn($id) => $id > 0);
    $newTagNames = array_filter(
        array_map(fn($id) => $this->pendingTags[$id] ?? null, $this->tag_ids),
        fn($name) => !is_null($name)
    );

    // Create new tags
    foreach ($newTagNames as $name) {
        $tag = Tag::findOrCreate(trim($name));
        $existingTagIds[] = $tag->id;
    }

    // Sync all tags
    $product->syncTags($existingTagIds);
}
```

### ManagesProductForm Trait Extensions

**New Properties:**

```php
public string $tagQuery = '';

/** @var array<int, string> Temporary storage for new tag names keyed by negative ID */
public array $pendingTags = [];

private int $nextPendingTagId = -1;
```

**Computed Properties:**

```php
#[Computed]
public function tagResults(): array
{
    if (strlen(trim($this->tagQuery)) < 1) {
        return [];
    }

    $selectedIds = array_filter($this->form->tag_ids, fn($id) => $id > 0);

    return Tag::where('name->en', 'like', "%{$this->tagQuery}%")
        ->whereNotIn('id', $selectedIds)
        ->limit(10)
        ->get(['id', 'name'])
        ->toArray();
}

#[Computed]
public function selectedTags(): array
{
    $existingIds = array_filter($this->form->tag_ids, fn($id) => $id > 0);
    $existing = Tag::whereIn('id', $existingIds)->get(['id', 'name'])->toArray();

    $pending = collect($this->form->tag_ids)
        ->filter(fn($id) => $id < 0)
        ->map(fn($id) => [
            'id' => $id,
            'name' => ['en' => $this->pendingTags[$id] ?? 'Unknown'],
            'is_pending' => true
        ])
        ->values()
        ->toArray();

    return array_merge($existing, $pending);
}
```

**Action Methods:**

```php
public function addExistingTag(int $tagId): void
{
    if (!in_array($tagId, $this->form->tag_ids)) {
        $this->form->tag_ids[] = $tagId;
    }
    $this->tagQuery = '';
}

public function createNewTag(): void
{
    $name = trim($this->tagQuery);

    if (empty($name)) {
        return;
    }

    // Check if tag already exists
    $existing = Tag::where('name->en', $name)->first();
    if ($existing) {
        $this->addExistingTag($existing->id);
        return;
    }

    // Add as pending tag with negative ID
    $pendingId = $this->nextPendingTagId--;
    $this->pendingTags[$pendingId] = $name;
    $this->form->tag_ids[] = $pendingId;
    $this->tagQuery = '';
}

public function removeTag(int $index): void
{
    $tagId = $this->form->tag_ids[$index] ?? null;

    // Remove from pending tags if it's a new tag
    if ($tagId < 0 && isset($this->pendingTags[$tagId])) {
        unset($this->pendingTags[$tagId]);
    }

    array_splice($this->form->tag_ids, $index, 1);
    $this->form->tag_ids = array_values($this->form->tag_ids);
}
```

### View Component (\_form-fields.blade.php)

**Location:** After Gallery section in sidebar

**Structure:**

```blade
<flux:card class="p-0" x-data="{ open: true }">
    <div class="flex items-center justify-between px-3 py-2 dark:border-zinc-600"
        :class="{ 'border-b ': open }">
        <flux:heading>Tags</flux:heading>
        <flux:button icon="chevron-down" size="xs" variant="ghost"
            class="cursor-pointer transition-transform duration-300"
            @click="open = !open">
            <x-slot name="icon">
                <flux:icon.chevron-down variant="outline" class="size-4 text-zinc-400"
                    x-bind:class="{ 'rotate-180': open }" />
            </x-slot>
        </flux:button>
    </div>

    <div x-show="open" x-collapse class="p-4 space-y-3">
        <!-- Selected Tags Display -->
        @if (count($this->selectedTags) > 0)
            <div class="flex flex-wrap gap-2">
                @foreach ($this->selectedTags as $index => $tag)
                    <flux:badge size="sm" class="flex items-center gap-1.5">
                        <span>{{ $tag['name']['en'] ?? $tag['name'] }}</span>
                        @if ($tag['is_pending'] ?? false)
                            <flux:icon.sparkles class="size-3" />
                        @endif
                        <button type="button"
                            wire:click="removeTag({{ $index }})"
                            class="hover:text-red-500">
                            <flux:icon.x-mark class="size-3" />
                        </button>
                    </flux:badge>
                @endforeach
            </div>
        @else
            <flux:text class="text-sm text-zinc-500">No tags assigned</flux:text>
        @endif

        <!-- Tag Search Input -->
        <div class="relative">
            <flux:input
                wire:model.live.debounce.300ms="tagQuery"
                placeholder="Search or create tags..."
                class="w-full"
            />

            <!-- Search Results Dropdown -->
            @if (strlen($tagQuery) > 0)
                <div class="absolute z-10 w-full mt-1 bg-white dark:bg-zinc-800 border dark:border-zinc-700 rounded-md shadow-lg max-h-48 overflow-y-auto">
                    @if (count($this->tagResults) > 0)
                        @foreach ($this->tagResults as $tag)
                            <button type="button"
                                wire:click="addExistingTag({{ $tag['id'] }})"
                                class="w-full px-3 py-2 text-left hover:bg-zinc-100 dark:hover:bg-zinc-700 text-sm">
                                {{ $tag['name']['en'] ?? $tag['name'] }}
                            </button>
                        @endforeach
                    @endif

                    <!-- Create New Tag Option -->
                    <button type="button"
                        wire:click="createNewTag"
                        class="w-full px-3 py-2 text-left hover:bg-zinc-100 dark:hover:bg-zinc-700 text-sm border-t dark:border-zinc-700 flex items-center gap-2">
                        <flux:icon.plus class="size-4" />
                        <span>Create "{{ $tagQuery }}"</span>
                    </button>
                </div>
            @endif
        </div>
    </div>
</flux:card>
```

### Product Model

No changes required - the `HasTags` trait from Spatie already provides:

- `tags()` relationship
- `syncTags()` method
- `attachTag()` / `detachTag()` methods

### Tag Model

Already exists and extends `Spatie\Tags\Tag`:

```php
class Tag extends SpatieTag
{
    public function products()
    {
        return $this->morphedByMany(Product::class, 'taggable');
    }
}
```

## Data Models

### Database Schema

**Existing Tables (Spatie Tags):**

```sql
-- tags table
CREATE TABLE tags (
    id BIGINT UNSIGNED PRIMARY KEY,
    name JSON NOT NULL,           -- Multilingual support
    slug JSON NOT NULL,           -- Multilingual slugs
    type VARCHAR(255) NULL,       -- Optional tag type
    order_column INT NULL,        -- Optional ordering
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- taggables pivot table (polymorphic)
CREATE TABLE taggables (
    tag_id BIGINT UNSIGNED,
    taggable_id BIGINT UNSIGNED,
    taggable_type VARCHAR(255),
    PRIMARY KEY (tag_id, taggable_id, taggable_type),
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
);
```

### Data Structures

**ProductForm.tag_ids:**

```php
// Array of tag IDs
// Positive integers: existing tags
// Negative integers: pending new tags (temporary IDs)
[1, 5, 12, -1, -2]
```

**ManagesProductForm.pendingTags:**

```php
// Map of temporary negative IDs to tag names
[
    -1 => "New Tag Name",
    -2 => "Another New Tag"
]
```

**Tag JSON Structure:**

```json
{
    "id": 1,
    "name": {
        "en": "Electronics"
    },
    "slug": {
        "en": "electronics"
    },
    "type": null,
    "order_column": null
}
```

## Error Handling

### Validation Errors

**Empty Tag Name:**

- **Trigger:** User attempts to create tag with empty or whitespace-only name
- **Handling:** Silently ignore in `createNewTag()` method
- **User Feedback:** None (input cleared)

**Invalid Tag ID:**

- **Trigger:** Non-integer value in tag_ids array
- **Handling:** Laravel validation rejects the request
- **User Feedback:** Validation error notification

**Duplicate Tag Selection:**

- **Trigger:** User attempts to add already-selected tag
- **Handling:** Check in `addExistingTag()` before adding
- **User Feedback:** None (no-op)

### Database Errors

**Tag Creation Failure:**

- **Trigger:** Database constraint violation or connection error
- **Handling:** Catch exception in `syncTags()`, log error
- **User Feedback:** "Failed to save tags" notification
- **Recovery:** Transaction rollback, preserve form state

**Sync Failure:**

- **Trigger:** Database error during `syncTags()` call
- **Handling:** Catch exception, log error
- **User Feedback:** "Failed to update product tags" notification
- **Recovery:** Transaction rollback

### Edge Cases

**Tag Name Collision:**

- **Scenario:** User creates tag with name that exists (case-insensitive)
- **Handling:** `createNewTag()` checks for existing tag first
- **Resolution:** Use existing tag instead of creating duplicate

**Concurrent Tag Creation:**

- **Scenario:** Two admins create same tag simultaneously
- **Handling:** Spatie's `findOrCreate()` handles race condition
- **Resolution:** One tag created, both products use same tag

**Orphaned Pending Tags:**

- **Scenario:** User adds pending tag but doesn't save product
- **Handling:** Pending tags stored in component state only
- **Resolution:** Lost on page navigation (expected behavior)

**Tag Deletion During Edit:**

- **Scenario:** Tag deleted by another admin while product is being edited
- **Handling:** Foreign key constraint prevents deletion if in use
- **Resolution:** Tag remains until all products untagged

## Testing Strategy

This feature requires a dual testing approach combining unit tests for specific scenarios and property-based tests for universal behaviors.

### Unit Tests

**Tag Selection Tests:**

- Adding existing tag to empty list
- Adding existing tag to populated list
- Preventing duplicate tag selection
- Removing tag from middle of list
- Removing last tag from list

**Tag Creation Tests:**

- Creating new tag with valid name
- Rejecting empty tag name
- Rejecting whitespace-only tag name
- Detecting existing tag by name (case-insensitive)
- Using existing tag instead of creating duplicate

**Tag Search Tests:**

- Searching with empty query returns no results
- Searching with single character returns matches
- Searching excludes already-selected tags
- Search results limited to 10 items

**Form Hydration Tests:**

- Loading product with no tags
- Loading product with single tag
- Loading product with multiple tags
- Tag IDs correctly populated in form

**Form Persistence Tests:**

- Saving product with no tags
- Saving product with only existing tags
- Saving product with only new tags
- Saving product with mixed existing and new tags
- Removing all tags from product
- Updating tags (add some, remove some, keep some)

**UI Rendering Tests:**

- Empty state displays "No tags assigned"
- Selected tags display with remove buttons
- Pending tags display with sparkles icon
- Search dropdown appears when query not empty
- Create option displays current query text

### Property-Based Tests

Property-based testing is appropriate for this feature because:

- Tag operations involve data transformations (arrays, strings)
- Universal properties exist (sync behavior, uniqueness)
- Input space is large (tag names, combinations)
- We're testing our code's logic, not external services

**Testing Library:** Use `pest-plugin-faker` or `phpunit-quickcheck` for PHP property-based testing.

**Test Configuration:**

- Minimum 100 iterations per property test
- Each test tagged with feature name and property number
- Use database transactions for isolation

## Correctness Properties

_A property is a characteristic or behavior that should hold true across all valid executions of a system—essentially, a formal statement about what the system should do. Properties serve as the bridge between human-readable specifications and machine-verifiable correctness guarantees._

### Property Reflection

After analyzing all acceptance criteria, I identified the following redundancies:

- Properties 1.2 and 6.2 both test that selected tags display correctly (consolidated into Property 1)
- Properties 1.5 and 2.1 both test search filtering (consolidated into Property 2)
- Properties 6.1 and 7.4 both test tag loading on edit (consolidated into Property 11)
- Properties 1.3 and 6.4 both test empty state (kept as example test, not property)
- Properties 5.3 and 5.4 can be combined into a single sync property (consolidated into Property 10)

### Property 1: Selected Tags Display

_For any_ set of selected tags (existing or pending), all tags SHALL appear in the rendered UI with their names and appropriate indicators (sparkles icon for pending tags).

**Validates: Requirements 1.2, 6.2**

### Property 2: Search Results Match Query

_For any_ search query string and tag database, all returned search results SHALL contain the query string (case-insensitive) in the tag name.

**Validates: Requirements 1.5, 2.1**

### Property 3: Tag Selection Adds to List

_For any_ tag from search results, clicking to select it SHALL add the tag to the selected tags list.

**Validates: Requirements 2.2**

### Property 4: Selected Tags Excluded from Search

_For any_ set of selected tags and search query, no selected tag SHALL appear in the search results.

**Validates: Requirements 2.3**

### Property 5: Search Results Include Tag Name

_For any_ search result item, the rendered output SHALL include the tag name field.

**Validates: Requirements 2.4**

### Property 6: Create Option for Non-Existent Tags

_For any_ tag name that does not exist in the database, the search interface SHALL provide a create option.

**Validates: Requirements 3.1**

### Property 7: New Tag Creation Adds to Selection

_For any_ new tag name, selecting the create option SHALL add the tag to the selected tags list with a pending status.

**Validates: Requirements 3.2**

### Property 8: Pending Tags Persisted on Save

_For any_ set of pending tags, saving the product SHALL create all pending tags in the database and associate them with the product.

**Validates: Requirements 3.3**

### Property 9: Empty Tag Names Rejected

_For any_ string composed entirely of whitespace characters (spaces, tabs, newlines), attempting to create a tag SHALL be rejected and the tag SHALL NOT be added to the selected list.

**Validates: Requirements 3.4**

### Property 10: Tag Name Normalization

_For any_ tag name with leading or trailing whitespace, the system SHALL trim the whitespace before storage and generate a slug from the normalized name.

**Validates: Requirements 3.5**

### Property 11: Remove Button Present for Selected Tags

_For any_ selected tag, the UI SHALL display a remove button or icon adjacent to the tag.

**Validates: Requirements 4.1**

### Property 12: Tag Removal Removes from List

_For any_ selected tag, clicking the remove button SHALL remove the tag from the selected tags list.

**Validates: Requirements 4.2**

### Property 13: Removed Tag Available in Search (Round-Trip)

_For any_ tag that was selected and then removed, the tag SHALL appear in search results when queried.

**Validates: Requirements 4.4**

### Property 14: Tag Removal Persisted on Save

_For any_ tag removed from the selected list, saving the product SHALL remove the tag association from the database.

**Validates: Requirements 4.5**

### Property 15: Tag Sync Completeness

_For any_ set of selected tags, saving the product SHALL result in the product being associated with exactly those tags in the database (no more, no less).

**Validates: Requirements 5.1, 5.3, 5.4**

### Property 16: Pending Tags Created Before Sync

_For any_ set of pending tags, saving the product SHALL create all pending tags in the database before establishing the product-tag associations.

**Validates: Requirements 5.2**

### Property 17: Tag Loading on Edit

_For any_ product with associated tags, loading the product for editing SHALL populate the tag_ids property with all associated tag IDs.

**Validates: Requirements 6.1, 7.4**

### Property 18: Tag IDs Validation

_For any_ tag_ids array containing non-integer values, form validation SHALL reject the submission.

**Validates: Requirements 7.2**
