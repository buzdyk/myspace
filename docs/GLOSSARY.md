# Glossary

## Services

| Term | Definition |
|------|------------|
| app/ | Laravel service — personal dashboard showing tracked hours from various sources |
| lifeline | Python service — personal metrics aggregator (Garmin, Umami, GA, LinkedIn) |
| MCP | Model Context Protocol service for data ingestion and agent communication |
| Garmin Connect | Garmin's platform for fitness/health data; accessed via unofficial `garminconnect` Python library |
| Umami | Self-hosted web analytics platform; accessed via REST API |
| LinkedIn Creator Analytics | LinkedIn's analytics for content performance; ingested via CSV export — no scraping |
| Google Analytics 4 (GA4) | Google's web analytics platform; accessed via official GA4 Data API with service account auth |
| Anthropic API | Claude API used for AI-powered analysis over collected data |

## Data Entities

| Term | Definition |
|------|------------|
| Tracked hours | Time entries aggregated from different tracking sources into the dashboard |
| garmin_activities | Running metrics: distance, pace, heart rate, VO2max |
| umami_stats | Web analytics: pageviews, sessions, referrers |
| linkedin_impressions | Content performance: article views, profile visits, impressions, reach — imported from CSV exports |
| ga_stats | Site traffic: pageviews, sessions, users, bounce rate from GA4 |

## Infrastructure

| Term | Definition |
|------|------------|
| Laravel | PHP framework powering the existing app/ service |
| Python | Language for the lifeline service and collectors |
| PostgreSQL | Central data store for lifeline metrics |
| MCP | Protocol layer bridging data ingestion and an AI agent |
| garminconnect | Unofficial Python library for Garmin Connect API |
| google-analytics-data | Google's Python client for the GA4 Data API |
