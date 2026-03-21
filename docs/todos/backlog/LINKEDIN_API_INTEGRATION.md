# LinkedIn API Integration

## Problem

LinkedIn Creator Analytics data is currently ingested via CSV import. If LinkedIn opens up proper API access (they grant it to some creators), a direct collector would eliminate the manual/external-tool step.

## Approach

- Monitor LinkedIn API access availability
- If granted: build a collector similar to Umami/GA (REST API, daily sync)
- Keep the CSV importer as a fallback regardless
