---
type: adr
status: accepted
date: 2026-03-21
---
# ADR-006: Integration Ethics — No ToS Violations, Community Libraries OK

## Status
Accepted

## Context
This is a public repo. Some data sources (LinkedIn, Garmin) lack official APIs or have restrictive access. The temptation to scrape or use undocumented endpoints exists.

## Decision
- **Never violate a service's Terms of Service** — no scraping, no undocumented endpoints, no reverse-engineered auth flows
- **Community-maintained libraries are acceptable** — e.g. `garminconnect` is unofficial but uses Garmin's own endpoints in the way a user would; it doesn't circumvent access controls
- The line: if a library automates what a logged-in user can already do, it's fine. If it bypasses restrictions, it's not.

## Consequences
- Some data sources may only be accessible via CSV import or manual export until official APIs open up
- Slower to integrate, but the repo stays clean and legally defensible
