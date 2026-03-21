---
type: adr
status: accepted
date: 2026-03-20
---
# ADR-002: Lifeline Tech Stack — Python, PostgreSQL, Claude

## Status
Accepted

## Context
Need a stack for collecting data from multiple APIs (Garmin, Umami, LinkedIn), storing it centrally, and providing analysis capabilities. The project is personal, so simplicity and speed of development matter more than scale.

## Decision
- **Python** for all collector scripts — strong library ecosystem for API integrations, `garminconnect` already exists
- **PostgreSQL** as the central data store — reliable, good for structured metrics data, well-supported
- **Claude (Anthropic API)** for AI-powered data analysis via chat or export workflows

## Consequences
- Python is the only backend language to maintain for the lifeline service
- Postgres requires a running instance (local or hosted) — adds an infrastructure dependency
- Anthropic API adds a cost per query; acceptable for personal use volume
