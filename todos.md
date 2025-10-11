# Move Tracker Configuration to Database with CRUD

> **Note:** New tasks are added to "In Queue" at the top. Mark tasks with [x] when completed, then move them to "Completed" section.

## In Queue

- [ ] Add helper text below config textarea showing expected JSON format for each tracker type:
  - Mayven: `{"api_url": "https://...", "token": "Bearer ..."}`
  - Clockify: `{"token": "...", "workspace_id": "...", "user_id": "..."}`
  - Everhour: `{"api_url": "https://...", "token": "..."}`
- [ ] Add config validation in TrackersController based on tracker type (no connection testing on CRUD)
- [ ] Add method to `app/Http/Controllers/TrackersController.php` with `connect()` method to test credentials, it's called from frontend, updates and returns the tracker status
- [ ] Refactor `app/Repositories/Trackers.php::hydrate()` to load from database instead of config file

## Completed

- [x] Create new migration to rename `name` to `title` and add `status` column (no default)
- [x] Create enum `app/Enums/TrackerStatus.php` with cases: Disconnected, Active, Paused
- [x] Create enum `app/Enums/TrackerType.php` with cases: Mayven, Clockify, Everhour, Dota2, Placeholder
- [x] Update `app/Models/Tracker.php` with proper fillable fields, casts, and relationships
- [x] Create config classes for each tracker type:
  - `app/TrackerConfigs/MayvenConfig.php` (api_url, token)
  - `app/TrackerConfigs/ClockifyConfig.php` (token, workspace_id, user_id)
  - `app/TrackerConfigs/EverhourConfig.php` (api_url, token)
- [x] Create custom cast `app/Casts/TrackerConfigCast.php` to auto-resolve JSON to config class instances
- [x] Update tracker classes constructors to accept config class instances:
  - Mayven: accept MayvenConfig
  - Clockify: accept ClockifyConfig
  - Everhour: accept EverhourConfig
- [x] Fix `app/Repositories/Trackers.php::hydrate()` to use config class instances (still using config file)
- [x] Update `app/Http/Controllers/Settings/TrackersController.php`:
  - `index()`: Return all trackers
  - `store()`: Create new tracker with validation
  - `update()`: Update tracker (title, status, config)
  - `destroy()`: Delete tracker
- [x] Add routes for tracker CRUD operations
- [x] Rebuild `resources/js/pages/settings/Trackers.vue`:
  - List all trackers with title, type, status
  - Add "Create Tracker" form with fields: title, type selector, status selector, config (JSON textarea)
  - Add inline edit/delete buttons for each tracker
  - Add status selector dropdown (disconnected/active/paused)
  - Use axios for CRUD operations
