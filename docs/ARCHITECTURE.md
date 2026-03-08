# Architecture

## Stack
- Laravel 11, Vue 3, Inertia.js, SQLite, Tailwind

## Core Concept
Aggregates time tracking data from multiple providers (Clockify, Everhour, Mayven) into a unified view for daily tracking and monthly invoicing.

## Architecture

### Time Trackers
- `app/Interfaces/TimeTracker.php` - Contract for all providers
- `app/Trackers/` - Provider implementations (Clockify, Everhour, Mayven, Placeholder)
- `app/TrackerConfigs/` - Typed config classes per tracker
- `app/Casts/TrackerConfigCast.php` - Resolves JSON to config instances
- All extend `Rest` base class for HTTP operations

### Data Layer
- `app/Repositories/Trackers.php` - Loads active trackers from DB, aggregates time data
- `app/Repositories/TodayCache.php` - Caches running totals
- `app/Types/ProjectTime(s).php` - Time entry data structures

### Database
- `trackers` - Tracker configs (title, type, status, encrypted config JSON)
- `projects` - Project metadata
- `tracks` - Time entries cache
- `settings` - User preferences

### Routes & Views
- `/today` - Current day overview
- `/{year}/{month}/calendar` - Monthly calendar
- `/{year}/{month}/projects` - Monthly project breakdown
- `/settings/trackers` - CRUD for tracker management

### Configuration
Tracker credentials stored in `trackers.config` column (database), not environment variables. Config validated per tracker type before storage.