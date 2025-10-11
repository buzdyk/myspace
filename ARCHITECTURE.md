# MySpace Time Tracking Application - Architecture Documentation

## Overview
MySpace is a Laravel-based time tracking application that unifies time data from multiple time tracking providers (Clockify, Everhour, Mayven). It provides transparent day-to-day time tracking and serves as a source of truth for monthly invoicing.

## Technology Stack
- **Backend**: PHP 8.2+ with Laravel 11.x
- **Frontend**: Vue.js with Inertia.js for SPA-like experience
- **Database**: SQLite (configurable)
- **HTTP Client**: Guzzle for external API calls
- **Styling**: Tailwind CSS
- **Build Tools**: Vite

## Application Architecture

### Core Components

#### 1. Time Tracker Interface
**File**: `app/Interfaces/TimeTracker.php`

Defines the contract that all time tracking providers must implement:
```php
interface TimeTracker {
    public function getUserId(): null|int|string;
    public function getSeconds(Carbon $from, Carbon $to): int;
    public function getRunningSeconds(): int;
    public function getMonthlyTimeByProject(Carbon $dayOfMonth): ProjectTimes;
    public function getMonthIntervals(Carbon $dayOfMonth): ProjectTimes;
}
```

#### 2. Time Tracking Providers
**Directory**: `app/Trackers/`

Currently supported providers:
- **Clockify** (`Clockify.php`) - Professional time tracking
- **Everhour** (`Everhour.php`) - Project time tracking
- **Mayven** (`Mayven.php`) - Custom time tracker
- **Dota2** (`Dota2.php`) - Gaming time tracking (commented out)
- **Placeholder** (`Placeholder.php`) - Testing/demo data

All providers extend the `Rest` base class and implement the `TimeTracker` interface.

#### 3. Repository Layer
**Directory**: `app/Repositories/`

- **Trackers** (`Trackers.php`) - Aggregates data from all configured time trackers
- **Today** (`Today.php`) - Handles current day data presentation
- **TodayCache** (`TodayCache.php`) - Caches frequently accessed data
- **MonthMeta** (`MonthMeta.php`) - Provides month-related metadata
- **Preferences** (`Preferences.php`) - User settings and preferences
- **Projects** (`Projects.php`) - Project-related data operations

## Database Schema

### Core Tables

#### 1. Users Table
Standard Laravel user authentication table with fields:
- `id` (primary key)
- `name`, `email`, `password`
- `email_verified_at`, `remember_token`
- `created_at`, `updated_at`

#### 2. Trackers Table
**Migration**: `2024_06_10_000105_create_trackers_table.php`
```sql
CREATE TABLE trackers (
    id INTEGER PRIMARY KEY,
    name VARCHAR NOT NULL,
    type VARCHAR NOT NULL,
    config JSON NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

#### 3. Projects Table
**Migration**: `2024_08_19_232247_create_projects_table.php`
```sql
CREATE TABLE projects (
    id INTEGER PRIMARY KEY,
    tracker_id INTEGER NOT NULL,
    name VARCHAR NOT NULL,
    token TEXT NOT NULL,
    FOREIGN KEY (tracker_id) REFERENCES trackers(id) ON DELETE CASCADE
);
```

#### 4. Tracks Table
**Migration**: `2024_08_19_232841_create_tracks_table.php`
```sql
CREATE TABLE tracks (
    id INTEGER PRIMARY KEY,
    tracker_id INTEGER NOT NULL,
    project_id INTEGER NOT NULL,
    seconds INTEGER NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (tracker_id) REFERENCES trackers(id) ON DELETE CASCADE,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);
```

#### 5. Settings Table
**Migration**: `2024_08_04_055406_create_settings_table.php`
Stores user preferences and configuration.

## API Routes & Controllers

### Route Structure
**File**: `routes/web.php`

#### Public Routes
- `GET /` → Redirects to `/today`

#### Settings Routes
- `GET /settings/trackers` → `TrackersController@index`
- `GET /settings` → `GeneralController@index`
- `POST /settings` → `GeneralController@store`

#### Protected Routes (require valid settings)
All routes below are protected by `RedirectIfSettingsNotValid` middleware:

- `GET /month` → `ProjectsController@redirect`
- `GET /{year}/{month}/calendar` → `CalendarController@index`
- `GET /{year}/{month}/projects` → `ProjectsController@index`
- `GET /today` → `TodayController@redirect`
- `GET /{year}/{month}/{day}` → `TodayController@index`

### Controllers

#### 1. TodayController
**File**: `app/Http/Controllers/TodayController.php`

Handles current day time tracking display:
- `redirect()` - Redirects to current date URL
- `index()` - Shows time tracking data for specific day
- `cacheValues()` - Updates cached values for performance

#### 2. ProjectsController (Month)
**File**: `app/Http/Controllers/Month/ProjectsController.php`

Monthly project view:
- `index()` - Shows monthly project breakdown with hours
- `redirect()` - Redirects to current month projects view

#### 3. CalendarController
**File**: `app/Http/Controllers/Month/CalendarController.php`

Monthly calendar view:
- `index()` - Shows calendar view with daily hours
- `getDays()` - Formats calendar data with proper week alignment

## Frontend Structure

### Vue Components
**Directory**: `resources/js/pages/`

#### Main Pages
- **Today.vue** - Daily time tracking overview
- **month/Calendar.vue** - Monthly calendar view
- **month/Projects.vue** - Monthly project breakdown
- **settings/General.vue** - General application settings
- **settings/Trackers.vue** - Time tracker configuration

#### Sub-components
- **month/projects/DailyHours.vue** - Daily hours visualization
- **month/projects/EmptyPlaceholder.vue** - Empty state component
- **month/projects/Overview.vue** - Project overview stats
- **today/Month.vue** - Monthly summary on today page
- **today/Pace.vue** - Work pace indicators
- **today/Today.vue** - Current day details

### Shared Components
- **Navigation.vue** - Main navigation component

## Data Flow

### Time Data Aggregation
1. **Configuration** - Time trackers are configured via environment variables
2. **Hydration** - `Trackers` repository initializes configured providers
3. **Data Fetching** - Each provider fetches data from their respective APIs
4. **Aggregation** - `Trackers` repository combines data from all providers
5. **Caching** - Frequently accessed data is cached via `TodayCache`
6. **Presentation** - Controllers format data for frontend consumption

### Key Data Types

#### ProjectTime
**File**: `app/Types/ProjectTime.php`
Represents a single time entry with project association.

#### ProjectTimes
**File**: `app/Types/ProjectTimes.php`
Collection of ProjectTime objects with aggregation methods.

## Configuration

### Environment Variables
Time tracker configuration via `.env`:
- `CLOCKIFY_TOKEN` - Clockify API token
- `CLOCKIFY_WORKSPACE_ID` - Clockify workspace ID
- `CLOCKIFY_USER_ID` - Clockify user ID
- `EVERHOUR_TOKEN` - Everhour API token
- `MAYVEN_AUTH` - Mayven authentication config

### Service Configuration
**File**: `config/services.php`
Centralizes external service configurations.

## Key Features

### 1. Multi-Provider Support
- Pluggable architecture for time trackers
- Unified interface for all providers
- Automatic data aggregation

### 2. Real-time Caching
- Running hours cache for active tracking
- Daily/monthly aggregations cached
- Background job processing for heavy operations

### 3. Responsive Calendar Views
- Monthly calendar with daily hours
- Project-based time breakdown
- Historical data navigation

### 4. Settings Management
- Tracker configuration interface
- User preferences storage
- Validation middleware for required settings

## Performance Optimizations

### 1. Caching Strategy
- **TodayCache** - Caches current day running totals
- **Laravel Cache** - Framework-level caching for API responses
- **Database Queries** - Optimized queries with proper indexing

### 2. Background Processing
- **StoreTracks** command for data synchronization
- **CacheToday** job for background cache updates
- Queue system for heavy API operations

### 3. API Rate Limiting
- Respectful API usage with external providers
- Cached responses to reduce API calls
- Error handling for API failures

## Testing Structure
**Directory**: `tests/`
- **Feature Tests** - End-to-end functionality testing
- **Unit Tests** - Individual component testing
- **TestCase** - Base test setup and utilities

## Deployment
- **Docker Support** - `docker-compose.yml` for containerized deployment
- **Laravel Sail** - Local development environment
- **Valet Support** - macOS local development

## Security Considerations
- API tokens stored in environment variables
- CSRF protection on all forms
- Input validation via Form Requests
- Database query parameter binding

## Extension Points

### Adding New Time Trackers
1. Create new class in `app/Trackers/`
2. Implement `TimeTracker` interface
3. Extend `Rest` base class if HTTP-based
4. Add configuration to `config/services.php`
5. Update `Trackers::hydrate()` method

### Adding New Views
1. Create Vue component in `resources/js/pages/`
2. Add route in `routes/web.php`
3. Create corresponding controller
4. Update navigation as needed

This architecture provides a solid foundation for a Go rewrite, with clear separation of concerns and well-defined interfaces.