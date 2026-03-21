# Build Umami Collector

## Problem

Need a Python script that pulls web analytics (pageviews, sessions, referrers) from Umami's REST API into Postgres.

## Approach

- Authenticate via Umami API token
- Fetch daily stats and upsert into `umami_stats`
- Use read-only API scope
