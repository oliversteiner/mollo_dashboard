# Mollo Module Dashboard

Version 1.1.0b

## How to use

#### Enable the Dashboard:
in Role Permissions check  **Show Dashboard**

#### Add a Dashboard:
- Create a new view
- Enable Display for Dashboard in Dashboard Section

#### Add Fields. They are usually:
  - Content: ID [hidden]
  - Content: Published --> Formatter: Boolean / Custom output for FALSE: ``<i class="fal fa-eye-slash"></i>``
  - Content: Image
  - Content: Title
  - Content revision: Changed
  - Admin: Admin Buttons (edit / publish )
    - Don't forget to define correct access

## Features

- [x] Add Dashboard Button to Admin Main Menu
- [x] Provide a Standalone Page and a Block for including in User Pages
- [x] Add "New" Buttons
- [x] Add "Clear Cache" Button (via mollo_Utils/clear_cache_block)
- [x] Add "Open Media Browser" Button
- [x] Add a User Greeting

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
- [ ] Vocabulary List (via Taxons )

### Depend on Mollo Modules (.yml in their own module config)

- [ ] Mollo Blog
- [ ] Mollo News
- [ ] And all other Mollo Modules

## Style

## Development

- [ ] Add Display Extender  to View Dialog

Display Extender Options

- [ x Checkbox for 'New'- Button with Dropdown for Node Type
      Dropdown Default: Node Type used in View

- [x] Checkbox for 'List'- Button  | Path (Text input)
      Prefill with 'admin/node_type/list'

- [x] Title  (Text input) - Default: View Title without 'Dashboard'
- [x] Info  (Text input)

Icon (via views_admintools)
- [x] Icon  (Text input)
- [ ] FontAwesome Picker


### Settings Page

Dashboard Items

- [ ] Rearrange Views Position
- [ ] Chose Size of View - one or zwo column
- [ ] Disable unwanted Views
- [ ] Rearrange and Disable Vocabularies in Taxonomy View

New Buttons

- [ ] Rearrange New Buttons
- [ ] Disable unwanted New Buttons
- [ ] Chose Style / Theme
  - Default
  - MolloUi Light
  - MolloUi Dark

Dashboard Button in Main Menu

- [ ] Chose Path
  ( /user, /dashboard, /admin/dashboard, etc.)
