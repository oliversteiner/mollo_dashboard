# Mollo Module Dashboard

Version 1.2

## How to use

#### Enable the Dashboard:
in Role Permissions check  **Show Dashboard**

#### Add a Dashboard:
- Create a new view
- Enable Display for Dashboard in Dashboard Section

#### Add Fields. They are usually:
  - Content: ID (hidden)
  - Content: Published --> Formatter: Boolean / Custom output for FALSE: ``<i class="fal fa-eye-slash"></i>``
  - Content: Image
  - Content: Title
  - Content revision: Changed
  - Admin: Admin Buttons (edit / publish )
    - Don't forget to define correct access

## Features
-  Add Dashboard Button to Admin Main Menu
-  Provide a Standalone Page and a Block for including in User Pages
-  Add "New" Buttons
-  Add "Clear Cache" Button (via mollo_Utils/clear_cache_block)
-  Add "Open Media Browser" Button
-  Add a User Greeting

## Predefined Dashboards:

### Build in
- [ ] View: Last Changes
- [ ] View: Unpublished Content
- [ ] View: Article
- [ ] View: Basic Page
- [ ] View: Internal Content (require the field 'mollo_intern')

### Depend on other Modules
- [ ] Matomo Analytics
- [ ] View: UniG Projects (via UniG Module)
- [ ] Vocabulary List (via Taxons Module - in deployment )

### Depend on Mollo Modules
via views.yml in their own module config

- [ ] Mollo Blog
- [ ] Mollo News
- [ ] And all other Mollo Modules

### Display Extender
- [x] Checkbox for 'New'- Button with Dropdown for Node Type
  Dropdown Default: Node Type used in View
- [x] Checkbox for 'List'- Button  | Path (Text input)
  Prefill with 'admin/node_type/'
- [x] Title (Text input) - Default: View Title without 'Dashboard'
- [x] Info (Text input)

### Settings Page

#### Dashboard Items
- [ ] Disable unwanted Views
- [ ] Rearrange and Disable Vocabularies in Taxonomy View

#### 'Add' Buttons
- [ ] Disable unwanted Add Buttons

## In Development
- [ ] Add Display Extender  to View Dialog
- [ ] Dashboard Button in Main Menu Path
  ( /user, /dashboard, /admin/dashboard, etc.)

## Future Functions
- [ ] Rearrange Views Position
- [ ] Rearrange Add Buttons
- [ ] Chose Size of View - one or zwo column
- [ ] Chose Style / Theme
  - Default
  - MolloUi Light
  - MolloUi Dark
