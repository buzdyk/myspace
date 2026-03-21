# Build Google Analytics Collector

## Problem

Need a Python script that pulls site traffic metrics from Google Analytics 4 via the official GA4 Data API into Postgres.

## Approach

- Use GA4 Data API with a service account (JSON credentials, `analytics.readonly` scope)
- Add service account email as Viewer on the GA4 property
- Fetch daily stats: pageviews, sessions, users, bounce rate
- Upsert into `ga_stats`
- No OAuth dance needed — service account auth is sufficient for personal use
