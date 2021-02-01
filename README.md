# Mollo Module Dashboard


## How to use
**Enable the Dashboard:**
in Role Permissions check for "Show Dashboard"

**Add a create a new View.**
"Machine Name" have to start with 'dashboard_'
Optional: Add a Header 'Dashboard', chose New and a List button
Optional: Chose an Icon (via views_admintools module)

**Add Fields. They are usually:**
- Content: ID [hidden]
- Content: Published (Formatter: Boolean / Custom output for FALSE: '<i class="fal fa-eye-slash"></i>')
- Content: Image
- Content: Title
- Content revision: Changed
- Admin: Admin Buttons (edit / publish )

Don't forget to define correct access


## Features
- [x] Add Dashboard Button to Admin Main Menu
- [ ] Provide a Standalone Page and a Block for including in User Pages
- [ ] Add all Views witch id starts with 'dashboard_'
- [ ] Add "New" Buttons
- [ ] Add "Clear Cache" Button (via mollo_Utils/clear_cache_block)
- [ ] Add "Open Media Browser" Button
- [ ] Add a User Greeting

## Predefined Dashboard Lists:

Build in
- [ ] View: Last Changes
- [ ] View: Unpublished Content
- [ ] View: Article
- [ ] View: Basic Page
- [ ] View: Internal Content (require the field 'mollo_intern')

Depend on other Modules
- [ ] Matomo Analytics
- [ ] View: UniG Projects (via UniG Module)
- [ ] Vocabulary List (via Taxons )

Depend on Mollo Modules (.yml in their own module config)
- [ ] Mollo Blog
- [ ] Mollo News
- [ ] And all other Mollo Modules

### Style


### Settings Page

Dashboard Items

- [ ] Rearrange Views Position
- [ ] Chose Size of View - one or zwo column
- [ ] Disable unwanted Views
- [ ] Rearrange and Disable Vocabularies in Taxonomy View

New Buttons

- [ ] Rearrange New Buttons
- [ ] Disable unwanted New Buttons
- [ ] Chose Style
  - Default Theme
  - MolloUi Light
  - MolloUi Dark

Dashboard Button
- [ ] Chose Destination of Dashboard Button
      ( /user, /dashboard, /admin/dashboard, etc.)
