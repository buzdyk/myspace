---
type: adr
status: accepted
date: 2026-03-21
---
# ADR-005: Merge Lifeline Scope into Myspace Monorepo

## Status
Accepted

## Context
myspace is an existing Laravel 11 + Inertia/Vue 3 application used for time tracking at an agency. It has a well-established provider pattern, working async via Guzzle promises, a web UI, and Docker infrastructure. Lifeline was planned as a separate Python + Postgres project to track broader personal metrics (Garmin, Umami, GA, LinkedIn).

The question: should lifeline's scope be merged into myspace instead of building a new project?

### What myspace has today

**Stack:** Laravel 11, PHP 8.2+, Inertia.js, Vue 3, Tailwind, MySQL 8.0, Redis, Docker Compose (Sail)

**Provider pattern:**
- `TimeTracker` interface — `getUserId()`, `getSeconds()`, `getRunningSeconds()`, `getMonthlyTimeByProject()`, `getMonthIntervals()`
- All methods return `GuzzleHttp\Promise\PromiseInterface` — async is already solved
- `Rest` abstract base class — shared Guzzle client with `getAsync()` for concurrent HTTP
- `Trackers` repository — hydrates providers from DB, executes all concurrently via `Utils::settle()`
- **4 working providers:** Clockify, Everhour, Mayven, Dota2 (plus Placeholder for dev)

**The interface question:** `TimeTracker` returns seconds. Lifeline's new sources return different metrics:

| Source | Data shape | Fits TimeTracker? |
|--------|-----------|-------------------|
| Clockify/Everhour/Mayven | Time entries (seconds per project) | Yes |
| Dota2 | Match durations (seconds) | Yes — already stretches the concept |
| Garmin | Fitness: distance, pace, HR, VO2max | Partially — duration fits, other metrics don't |
| Umami | Web analytics: pageviews, sessions, referrers | No |
| Google Analytics | Site traffic: pageviews, users, bounce rate | No |
| LinkedIn | Content: article views, profile visits | No |

## Options

### Option A: Full merge into Laravel app
Add lifeline's scope as a new subsystem in the existing Laravel app.
- **For:** hard parts already exist (web UI, async HTTP, Docker, queue/jobs)
- **Against:** need second interface for non-time data, Python has better libraries for target integrations, mixing agency time tracking with personal analytics gets messy

### Option B: Keep fully separate
- **For:** clean separation, Python library ecosystem, Postgres for analytics
- **Against:** rebuilds infrastructure that already exists, two projects to maintain, starts from zero

### Option C: Monorepo with Python service alongside myspace
Neither a full merge nor a full separation.

## Decision
**Option C: Monorepo with Python service alongside myspace.**

### Rationale
- PHP lacks generics — building a generic `DataSource` with typed metric collections means manual boilerplate without real type safety. Python handles this natively.
- Python ecosystem has mature, well-typed libraries for the target integrations (`garminconnect`, `google-analytics-data`).
- myspace already works and has users — no reason to destabilize it with a breaking refactor.
- Monorepo gives shared infrastructure (Docker Compose, networking) without coupling the codebases.
- Door stays open to absorb myspace's PHP functionality into the Python service later.

## Consequences
- ADR-002 (Python + Postgres) remains valid for the lifeline service
- ADR-003 (LinkedIn CSV import) and ADR-004 (GA4) apply to the Python service
- myspace continues as-is — no breaking changes, no refactor
- Shared Docker Compose will need coordination (ports, networking, potentially shared DB)
- Two languages in the monorepo (PHP + Python) — acceptable tradeoff for type safety and library availability
