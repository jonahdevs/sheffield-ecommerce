# Requirements Document

## Introduction

This document specifies the requirements for adding tag management functionality to the admin product create and edit forms. The feature enables administrators to assign, create, and manage tags for products directly within the product form interface, leveraging the existing Spatie Tags infrastructure.

## Glossary

- **Product_Form**: The Livewire component and form class responsible for creating and editing products in the admin interface
- **Tag_Manager**: The UI component within the product form sidebar that handles tag selection, creation, and removal
- **Tag**: A label or keyword assigned to products for organization, filtering, and search purposes (extends Spatie\Tags\Tag)
- **Tag_Sync**: The process of persisting tag associations between products and tags in the database
- **Inline_Tag_Creation**: The ability to create new tags without leaving the product form

## Requirements

### Requirement 1: Display Tag Management UI

**User Story:** As an admin, I want to see a tag management section in the product form sidebar, so that I can easily assign tags to products alongside other product attributes.

#### Acceptance Criteria

1. THE Product_Form SHALL display a "Tags" section in the sidebar below the "Gallery" section
2. THE Tag_Manager SHALL display all currently selected tags with their names
3. WHEN no tags are selected, THE Tag_Manager SHALL display placeholder text indicating no tags are assigned
4. THE Tag_Manager SHALL provide a searchable input field for finding existing tags
5. THE Tag_Manager SHALL display a list of matching tags as the admin types in the search field

### Requirement 2: Select Existing Tags

**User Story:** As an admin, I want to select existing tags from a searchable list, so that I can quickly assign relevant tags to products without creating duplicates.

#### Acceptance Criteria

1. WHEN an admin types in the tag search field, THE Tag_Manager SHALL filter and display tags matching the search query
2. WHEN an admin clicks on a tag from the search results, THE Tag_Manager SHALL add the tag to the selected tags list
3. WHEN a tag is already selected, THE Tag_Manager SHALL exclude it from the search results
4. THE Tag_Manager SHALL display at least the tag name in search results
5. WHEN the search field is empty, THE Tag_Manager SHALL display no search results or a default state

### Requirement 3: Create New Tags Inline

**User Story:** As an admin, I want to create new tags directly from the product form, so that I can add tags without interrupting my workflow.

#### Acceptance Criteria

1. WHEN an admin types a tag name that does not exist, THE Tag_Manager SHALL provide an option to create a new tag
2. WHEN an admin selects the create option, THE Tag_Manager SHALL add the new tag to the selected tags list
3. THE Tag_Manager SHALL create the new tag in the database when the product is saved
4. THE Tag_Manager SHALL validate that tag names are not empty before creation
5. THE Tag_Manager SHALL handle tag name normalization (trimming whitespace, slug generation)

### Requirement 4: Remove Selected Tags

**User Story:** As an admin, I want to remove tags from the selected list, so that I can correct mistakes or update product categorization.

#### Acceptance Criteria

1. WHEN a tag is selected, THE Tag_Manager SHALL display a remove button or icon next to the tag
2. WHEN an admin clicks the remove button, THE Tag_Manager SHALL remove the tag from the selected tags list
3. THE Tag_Manager SHALL update the UI immediately after tag removal
4. WHEN a tag is removed, THE Tag_Manager SHALL make it available again in search results
5. THE Tag_Manager SHALL persist tag removal when the product is saved

### Requirement 5: Persist Tag Associations

**User Story:** As an admin, I want tags to be saved when I create or update a product, so that the tag assignments are stored permanently.

#### Acceptance Criteria

1. WHEN an admin saves a product, THE Product_Form SHALL sync all selected tags to the product
2. THE Product_Form SHALL create any new tags before syncing them to the product
3. THE Product_Form SHALL remove tag associations for tags that were deselected
4. THE Product_Form SHALL maintain tag associations for tags that remain selected
5. THE Tag_Sync SHALL use the existing Spatie Tags relationship methods

### Requirement 6: Load Existing Tags on Edit

**User Story:** As an admin, I want to see existing tags when editing a product, so that I can review and modify the current tag assignments.

#### Acceptance Criteria

1. WHEN an admin opens a product for editing, THE Product_Form SHALL load all tags currently assigned to the product
2. THE Tag_Manager SHALL display all loaded tags in the selected tags list
3. THE Product_Form SHALL use the existing product-tag relationship to retrieve tags
4. WHEN a product has no tags, THE Tag_Manager SHALL display the empty state
5. THE Product_Form SHALL load tags efficiently without causing performance issues

### Requirement 7: Tag Form Property Management

**User Story:** As a developer, I want the ProductForm to include a tag_ids property, so that tag data can be managed consistently with other form properties.

#### Acceptance Criteria

1. THE Product_Form SHALL include a tag_ids property of type array
2. THE Product_Form SHALL validate that tag_ids contains only integer values
3. THE Product_Form SHALL include tag_ids in the validation rules
4. THE Product_Form SHALL hydrate tag_ids when loading an existing product
5. THE Product_Form SHALL use tag_ids during the sync process when saving

### Requirement 8: UI Consistency with Category Selection

**User Story:** As an admin, I want the tag selection UI to be similar to the category selection pattern, so that the interface feels familiar and intuitive.

#### Acceptance Criteria

1. THE Tag_Manager SHALL use a collapsible card layout similar to other sidebar sections
2. THE Tag_Manager SHALL use similar styling and spacing as the category selection UI
3. THE Tag_Manager SHALL display selected tags in a similar visual format as selected categories
4. THE Tag_Manager SHALL use consistent icon styles and button variants
5. THE Tag_Manager SHALL follow the same interaction patterns (search, select, remove) as category selection
