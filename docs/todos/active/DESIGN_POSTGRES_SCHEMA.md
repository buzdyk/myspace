# Design Postgres Schema

## Problem

Need tables to store metrics from four sources: Garmin (running activities), Umami (web analytics), LinkedIn (content impressions via CSV), and Google Analytics (site traffic). Schema should support daily upserts from collector scripts and CSV imports.

## Approach

- `garmin_activities` — distance, pace, heart rate, VO2max, activity date
- `umami_stats` — pageviews, sessions, referrers, date
- `linkedin_impressions` — article views, profile visits, impressions, reach, date (ingested via CSV import)
- `ga_stats` — pageviews, sessions, users, bounce rate, date, property identifier
- Use natural keys or source IDs for upsert deduplication
- LinkedIn schema should be automation-ready (consistent column names, predictable format) for later ingestion via n8n/Make
