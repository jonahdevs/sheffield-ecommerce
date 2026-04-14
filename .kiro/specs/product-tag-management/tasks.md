# Implementation Plan: Product Tag Management

## Overview

This implementation adds tag management functionality to the admin product create and edit forms. The feature leverages the existing Spatie Tags package infrastructure and follows established patterns from the category selection interface for consistency.

## Tasks

- [x]   1. Add tag_ids property and validation to ProductForm
    - Add `tag_ids` array property to ProductForm class
    - Add validation rules for `tag_ids` (nullable array of integers)
    - Add validation messages for tag_ids errors
    - _Requirements: 7.1, 7.2, 7.3_

- [x]   2. Implement tag hydration in ProductForm
    - [x] 2.1 Load tags in setProduct method
        - Modify `setProduct()` to populate `tag_ids` from product tags relationship
        - Use `pluck('id')->toArray()` to extract tag IDs
        - _Requirements: 6.1, 7.4_
    - [x] 2.2 Write property test for tag loading
        - **Property 17: Tag Loading on Edit**
        - **Validates: Requirements 6.1, 7.4**

- [ ]   3. Implement tag persistence in ProductForm
    - [x] 3.1 Create syncTags method
        - Add `syncTags()` method to ProductForm
        - Separate existing tag IDs (positive) from pending tags (negative)
        - Create new tags using `Tag::findOrCreate()`
        - Sync all tags using `$product->syncTags()`
        - _Requirements: 5.1, 5.2, 5.3, 5.4_
    - [x] 3.2 Call syncTags from syncRelationships
        - Add `$this->syncTags($product)` call in `syncRelationships()` method
        - _Requirements: 5.1_
    - [x] 3.3 Write property test for tag sync
        - **Property 15: Tag Sync Completeness**
        - **Validates: Requirements 5.1, 5.3, 5.4**
    - [x] 3.4 Write property test for pending tag creation
        - **Property 16: Pending Tags Created Before Sync**
        - **Validates: Requirements 5.2**

- [x]   4. Add tag management properties to ManagesProductForm trait
    - Add `tagQuery` string property for search input
    - Add `pendingTags` array property for temporary new tag storage
    - Add `nextPendingTagId` integer property initialized to -1
    - _Requirements: 3.2_

- [x]   5. Implement tag search computed property
    - [x] 5.1 Create tagResults computed property
        - Add `tagResults()` computed method
        - Return empty array if query length < 1
        - Filter tags by name matching query (case-insensitive)
        - Exclude already-selected tags from results
        - Limit results to 10 tags
        - _Requirements: 2.1, 2.3, 2.5_
    - [x] 5.2 Write property test for search results
        - **Property 2: Search Results Match Query**
        - **Validates: Requirements 1.5, 2.1**
    - [x] 5.3 Write property test for selected tags exclusion
        - **Property 4: Selected Tags Excluded from Search**
        - **Validates: Requirements 2.3**

- [x]   6. Implement selectedTags computed property
    - [x] 6.1 Create selectedTags computed property
        - Add `selectedTags()` computed method
        - Load existing tags from database using tag IDs
        - Map pending tags from `pendingTags` array with `is_pending` flag
        - Merge existing and pending tags into single array
        - _Requirements: 1.2, 6.2_
    - [x] 6.2 Write property test for selected tags display
        - **Property 1: Selected Tags Display**
        - **Validates: Requirements 1.2, 6.2**

- [ ]   7. Checkpoint - Ensure all tests pass
    - Ensure all tests pass, ask the user if questions arise.

- [ ]   8. Implement tag action methods in ManagesProductForm
    - [ ] 8.1 Create addExistingTag method
        - Add `addExistingTag(int $tagId)` method
        - Check if tag already in `tag_ids` array
        - Add tag ID to `tag_ids` if not present
        - Clear `tagQuery` after adding
        - _Requirements: 2.2_
    - [ ] 8.2 Create createNewTag method
        - Add `createNewTag()` method
        - Trim and validate tag name from `tagQuery`
        - Check if tag already exists in database
        - If exists, call `addExistingTag()` with existing ID
        - If new, generate negative ID and add to `pendingTags` and `tag_ids`
        - Clear `tagQuery` after creating
        - _Requirements: 3.1, 3.2, 3.4, 3.5_
    - [ ] 8.3 Create removeTag method
        - Add `removeTag(int $index)` method
        - Get tag ID from `tag_ids` at index
        - Remove from `pendingTags` if negative ID
        - Remove from `tag_ids` array using `array_splice()`
        - Re-index array with `array_values()`
        - _Requirements: 4.2, 4.5_
    - [ ] 8.4 Write property test for tag selection
        - **Property 3: Tag Selection Adds to List**
        - **Validates: Requirements 2.2**
    - [ ] 8.5 Write property test for tag removal
        - **Property 12: Tag Removal Removes from List**
        - **Validates: Requirements 4.2**
    - [ ] 8.6 Write property test for removed tag availability
        - **Property 13: Removed Tag Available in Search (Round-Trip)**
        - **Validates: Requirements 4.4**
    - [ ] 8.7 Write property test for empty tag name rejection
        - **Property 9: Empty Tag Names Rejected**
        - **Validates: Requirements 3.4**
    - [ ] 8.8 Write property test for tag name normalization
        - **Property 10: Tag Name Normalization**
        - **Validates: Requirements 3.5**

- [ ]   9. Create Tags UI card in product form view
    - [ ] 9.1 Add Tags card to sidebar
        - Add collapsible card after Gallery section in `_form-fields.blade.php`
        - Use same card structure as other sidebar sections
        - Add "Tags" heading with chevron toggle button
        - _Requirements: 1.1, 8.1, 8.2_
    - [ ] 9.2 Implement selected tags display
        - Display selected tags using `$this->selectedTags` computed property
        - Show tags as badges with tag name
        - Add sparkles icon for pending tags (`is_pending` flag)
        - Add remove button (X icon) for each tag
        - Wire remove button to `removeTag(index)` method
        - Show "No tags assigned" text when empty
        - _Requirements: 1.2, 1.3, 4.1, 6.2, 6.4_
    - [ ] 9.3 Implement tag search input
        - Add search input field with `wire:model.live.debounce.300ms="tagQuery"`
        - Set placeholder text "Search or create tags..."
        - _Requirements: 1.4, 1.5_
    - [ ] 9.4 Implement search results dropdown
        - Add dropdown container that appears when `tagQuery` is not empty
        - Display search results from `$this->tagResults`
        - Each result as clickable button calling `addExistingTag(tagId)`
        - Display tag name in each result
        - _Requirements: 2.1, 2.2, 2.4_
    - [ ] 9.5 Add create new tag option
        - Add "Create" button at bottom of dropdown
        - Display current `tagQuery` value in button text
        - Wire button to `createNewTag()` method
        - Add plus icon to button
        - _Requirements: 3.1, 3.2_
    - [ ] 9.6 Write unit tests for UI rendering
        - Test empty state displays correctly
        - Test selected tags render with names
        - Test pending tags show sparkles icon
        - Test search dropdown appears when query not empty
        - Test create option displays query text

- [ ]   10. Eager load tags relationship in product controllers
    - [ ] 10.1 Add tags to eager loading in edit action
        - Locate product edit controller/component
        - Add 'tags' to `with()` or `load()` call when fetching product
        - _Requirements: 6.3, 6.5_
    - [ ] 10.2 Add tags to eager loading in create action (if applicable)
        - Check if create action loads product template or defaults
        - Add 'tags' to eager loading if needed

- [ ]   11. Final checkpoint - Ensure all tests pass
    - Ensure all tests pass, ask the user if questions arise.

## Notes

- Tasks marked with `*` are optional and can be skipped for faster MVP
- Each task references specific requirements for traceability
- Property tests validate universal correctness properties from the design document
- The implementation uses PHP/Laravel with Livewire framework
- All tag operations leverage the existing Spatie Tags package infrastructure
