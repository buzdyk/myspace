---
type: adr
status: accepted
date: 2026-03-21
---
# ADR-003: LinkedIn Data via CSV Import, Not Scraping

## Status
Accepted

## Context
LinkedIn Creator Analytics provides impression/reach data (daily article views, profile visits) that we want to track. Three approaches were considered:

1. **LinkedIn API** — proper API access is not currently available for personal/small-scale use
2. **Scraping** — violates LinkedIn's ToS, legally gray, and a bad look for a public repo
3. **CSV import** — LinkedIn allows manual export of analytics data from the dashboard

Since this project is public, anything that looks shady will reflect poorly. Legality matters.

## Decision
Use CSV import as the sole LinkedIn data ingestion method:
- Parse LinkedIn's analytics export CSVs
- Design the schema to be automation-ready so external tools (n8n, Make) can feed CSVs later
- No manual data entry — import files only
- No scraping or unofficial API usage

## Consequences
- Data will lag behind real-time (depends on how often CSVs are exported/fed)
- Schema must be flexible enough to handle LinkedIn changing their export format
- Door stays open for proper API integration if LinkedIn grants access later
