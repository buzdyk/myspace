# Secrets Management

## Problem

Collectors need API credentials (Garmin, GA4 service account, Umami). Need to decide on a secrets management approach before collectors ship.

## Options

- `.env` files (current approach in app/)
- Docker secrets
- External vault (overkill for personal project)
