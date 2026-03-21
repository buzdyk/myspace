---
type: adr
status: accepted
date: 2026-03-21
---
# ADR-004: Add Google Analytics as a Data Source

## Status
Accepted

## Context
Google Analytics 4 provides site traffic metrics alongside Umami. GA4 has an official, well-supported Data API with a clean auth model (service accounts with read-only scope). Adding it rounds out the web analytics picture.

Three ingestion approaches were evaluated:
1. **GA4 Data API** — official, read-only service account auth, Python client library available
2. **BigQuery export** — GA4 streams raw events to BigQuery; more granular but overkill for personal scale
3. **CSV export** — manual, no setup, but unnecessary since the API is straightforward

## Decision
Use the GA4 Data API with service account authentication:
- Narrow `analytics.readonly` scope
- Service account credentials stored in `.env` (not committed)
- No user-facing OAuth flow required

## Consequences
- Requires a Google Cloud project with the Analytics Data API enabled
- Service account JSON key is a secret that must be managed
- Adds `google-analytics-data` Python package as a dependency
