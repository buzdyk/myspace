# Extend Myspace with New Providers

## Problem

Myspace (existing Laravel/Vue project) already has provider integrations (Clockify, Everhour). Could add Garmin/Umami/GA/LinkedIn as new providers following the same pattern.

## Reason for icebox

Decided to build lifeline as a separate Python service in the monorepo instead. Myspace stays alive for its current purpose but PHP's lack of generics and the desire for a clean-slate Python stack with better library support made a separate service the better path. Myspace has users — not shelving it, but not extending it for this use case.
