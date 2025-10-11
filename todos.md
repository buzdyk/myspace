# Move Tracker Configuration to Database with CRUD

> **Note:** Tasks use unique IDs across all sections. New tasks are added to "In Queue" with next available ID. When marking a task complete, move it from "In Queue" to "Completed" section.

## In Queue

12. [ ] Encrypt trackers.config column:
    - Create migration to change `config` column from `json` to `text`
    - Update `app/Casts/TrackerConfigCast.php` to encrypt/decrypt using `Crypt::encryptString()` and `Crypt::decryptString()`
    - Preserve ability to resolve config into config class instances (MayvenConfig, ClockifyConfig, etc.)
14. [ ] Add config validation in TrackersController based on tracker type (no connection testing on CRUD)
15. [ ] Add method to `app/Http/Controllers/TrackersController.php` with `connect()` method to test credentials, it's called from frontend, updates and returns the tracker status

## Completed

1. [x] Create new migration to rename `name` to `title` and add `status` column (no default)
2. [x] Create enum `app/Enums/TrackerStatus.php` with cases: Disconnected, Active, Paused
3. [x] Create enum `app/Enums/TrackerType.php` with cases: Mayven, Clockify, Everhour, Dota2, Placeholder
4. [x] Update `app/Models/Tracker.php` with proper fillable fields, casts, and relationships
5. [x] Create config classes for each tracker type:
   - `app/TrackerConfigs/MayvenConfig.php` (api_url, token)
   - `app/TrackerConfigs/ClockifyConfig.php` (token, workspace_id, user_id)
   - `app/TrackerConfigs/EverhourConfig.php` (api_url, token)
6. [x] Create custom cast `app/Casts/TrackerConfigCast.php` to auto-resolve JSON to config class instances
7. [x] Update tracker classes constructors to accept config class instances:
   - Mayven: accept MayvenConfig
   - Clockify: accept ClockifyConfig
   - Everhour: accept EverhourConfig
8. [x] Fix `app/Repositories/Trackers.php::hydrate()` to use config class instances (still using config file)
9. [x] Update `app/Http/Controllers/Settings/TrackersController.php`:
   - `index()`: Return all trackers
   - `store()`: Create new tracker with validation
   - `update()`: Update tracker (title, status, config)
   - `destroy()`: Delete tracker
10. [x] Add routes for tracker CRUD operations
11. [x] Rebuild `resources/js/pages/settings/Trackers.vue`:
    - List all trackers with title, type, status
    - Add "Create Tracker" form with fields: title, type selector, status selector, config (JSON textarea)
    - Add inline edit/delete buttons for each tracker
    - Add status selector dropdown (disconnected/active/paused)
    - Use axios for CRUD operations
13. [x] Add helper text below config textarea showing expected JSON format for each tracker type:
    - Mayven: `{"api_url": "https://...", "token": "Bearer ..."}`
    - Clockify: `{"token": "...", "workspace_id": "...", "user_id": "..."}`
    - Everhour: `{"api_url": "https://...", "token": "..."}`
16. [x] Refactor `app/Repositories/Trackers.php::hydrate()` to load from database instead of config file
17. [x] Move Create Tracker form to separate page at `/settings/trackers/create`
