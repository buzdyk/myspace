---
type: adr
status: proposed
date: 2026-03-21
---
# ADR-007: Service Definition — Four-Service Architecture

## Status
Proposed

## Context
The monorepo currently contains `app/` (Laravel 11 + Vue 3 + Inertia), which handles time tracking. ADR-005 decided to add a Python service alongside it. As the project scope grows — personal metrics, data collection, AI agent access — the service boundaries need to be defined explicitly.

The existing Laravel app works and has a solid provider pattern (async Guzzle, tracker CRUD, enums). Rather than rewriting it, repurposing it as an API-only service (stripping Inertia, serving JSON) preserves working code.
## Decision
Four services, all in the monorepo, sharing a single Postgres database:

### 1. Frontend (`dashboard/`)
- **Role:** Dashboard UI, replaces `app/`
- **Stack:** Vue 3, TypeScript
- **Owns:** Presentation only — stored data via the API, live data directly from collectors

### 2. API (`api/`) — repurposed from `app/`
- **Role:** CRUD, query layer, business logic
- **Stack:** Laravel 11, stripped to API-only (no Inertia, no Blade)
- **Owns:** All reads and user-facing writes — trackers, settings, metrics queries
- **Owns:** Database schema — all migrations live here
- **Consumers:** Frontend and MCP server

### 3. Collectors (`collectors/`)
- **Role:** Data collection from external sources
- **Stack:** Python, per ADR-002
- **Owns:** All external data ingestion — Garmin, Umami, GA4, LinkedIn CSV, time tracker APIs
- **Modes:**
  - Cron-based scripts that write directly to Postgres
  - Lightweight API for on-demand/live data (e.g. time tracked today) — called directly by the frontend, not proxied through the API
- **DB access:** Lightweight (raw SQL or minimal ORM) — no duplication of Laravel's model layer

### 4. MCP Server (`mcp/`)
- **Role:** Model Context Protocol interface for Claude and other AI agents
- **Stack:** TBD
- **Owns:** Agent-facing access to collected data, consumed via the API

### Data Flow
- **Collectors → Postgres:** Direct writes on cron schedules
- **API → Postgres:** Reads and user CRUD writes
- **Frontend → API:** Stored/historical data
- **Frontend → Collectors:** Live/point-in-time data (e.g. current time tracking)
- **MCP → API:** All data access

### Schema Ownership
- **Laravel (API) owns all migrations** — single source of truth for table structure
- Collectors write to those tables using lightweight DB access, not full model definitions
- Frontend TypeScript types mirror API responses — standard SPA pattern

## Open Questions
- MCP server language: Python or TypeScript — less critical now since it's a thin adapter over the API

## Consequences
- `app/` is repurposed as `api/`, not rewritten — existing provider pattern, CRUD, and migrations carry over
- Two backend languages (PHP + Python) — acceptable since they have distinct roles and don't share model code
