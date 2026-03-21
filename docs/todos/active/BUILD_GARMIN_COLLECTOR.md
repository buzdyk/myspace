# Build Garmin Collector

## Problem

Need a Python script that authenticates with Garmin Connect via the `garminconnect` library and pulls running metrics (distance, pace, heart rate, VO2max) into Postgres.

## Approach

- Use `garminconnect` library for auth and data fetch
- Implement daily sync: fetch recent activities, upsert into `garmin_activities`
- Handle session/token management for unattended cron runs
