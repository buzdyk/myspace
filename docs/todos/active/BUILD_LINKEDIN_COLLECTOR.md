# Build LinkedIn CSV Importer

## Problem

Need to ingest impression/reach data from LinkedIn Creator Analytics. LinkedIn's ToS prohibits scraping and proper API access is not available — CSV import is the clean path.

## Approach

- Build a CSV parser for LinkedIn's analytics export format (daily article views, profile visits)
- Design an automation-ready schema so external tools (n8n, Make, etc.) can feed CSVs later
- Upsert into `linkedin_impressions`
- Keep the importer generic enough to accept different LinkedIn export formats

## Constraints

- No scraping, no unofficial API usage — legal risk and bad optics for a public repo
- No manual data entry — import only
