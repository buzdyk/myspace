---
type: adr
status: accepted
date: 2026-03-21
---
# ADR-001: Monorepo Structure

## Status
Accepted

## Context
The project is a personal dashboard that will grow to include multiple services (Laravel, Python, MCP). Keeping services in separate repos would add coordination overhead for a single-maintainer OSS project.

## Decision
Use a monorepo with each service in its own top-level directory (e.g. `app/` for Laravel, future dirs for Python services and MCP).

## Consequences
- Simpler cross-service changes and shared tooling
- Single CI/CD pipeline to manage
- Must be deliberate about service boundaries to avoid tight coupling
