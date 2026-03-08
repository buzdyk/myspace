# Monorepo Migration TODO

## Target structure

```
myspace/
├── app/                        # Laravel application
│   ├── app/
│   ├── config/
│   ├── database/
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── tests/
│   ├── public/
│   ├── composer.json
│   ├── package.json
│   ├── vite.config.js
│   └── ...
├── deploy/
│   ├── terraform/
│   │   ├── modules/
│   │   │   ├── hetzner/
│   │   │   └── ovhcloud/
│   │   ├── main.tf
│   │   ├── variables.tf
│   │   └── outputs.tf
│   └── scripts/
│       └── setup.sh
├── docker/
│   ├── web/
│   │   └── Dockerfile
│   └── caddy/
│       └── Caddyfile
├── docs/
├── docker-compose.yml          # Dev
├── docker-compose.prod.yml     # Production
├── Makefile
└── .env.example
```

## 1. Switch to monorepo

- [ ] Move all Laravel files into `app/` subdirectory
- [ ] Update `docker-compose.yml` volume mounts (`.` → `./app`)
- [ ] Update `Makefile` paths
- [ ] Update mysql init script path (currently points into vendor/)
- [ ] Verify `make up`, `make watch`, `make test` still work
- [ ] Move root-level docs (ARCHITECTURE.md, todos.md) into `docs/` or remove
- [ ] Update `.gitignore` for new structure

## 2. Docker — replace Sail with custom setup

- [ ] Create `docker/web/Dockerfile` (PHP 8.3-FPM, node, composer)
- [ ] Create `docker/caddy/Caddyfile` (reverse proxy to PHP-FPM, auto-SSL in prod)
- [ ] Rewrite `docker-compose.yml` for dev (mount app/, hot reload, SQLite default)
- [ ] Create `docker-compose.prod.yml` (built assets, Caddy with domain + auto-SSL)
- [ ] Optional MySQL sidecar in compose for those who want it
- [ ] Redis sidecar if needed, or drop if SQLite + sync queue is enough
- [ ] Update Makefile commands for new compose setup

## 3. Deploy — Terraform provisioning

- [ ] `deploy/terraform/modules/hetzner/` — minimal CX22 server, firewall (22, 80, 443), SSH key
- [ ] `deploy/terraform/modules/ovhcloud/` — minimal instance, security group, SSH key
- [ ] Provider selection via variable: `provider = "hetzner"` or `provider = "ovhcloud"`
- [ ] `deploy/terraform/main.tf` — wires the selected module
- [ ] `deploy/terraform/variables.tf` — provider, SSH key, domain, server size
- [ ] `deploy/terraform/outputs.tf` — server IP, SSH command

## 4. Deploy — Application setup

- [ ] `deploy/scripts/setup.sh` — cloud-init: install Docker + Compose, clone repo
- [ ] First-run: copy `.env`, `docker compose -f docker-compose.prod.yml up -d`, migrate
- [ ] Deploy/update script: git pull, rebuild containers, migrate
- [ ] Caddy handles domain + Let's Encrypt automatically

## Decisions made

- **Reverse proxy**: Caddy (built-in automatic HTTPS)
- **Database (prod)**: SQLite by default, optional MySQL sidecar
- **Cloud providers**: Hetzner and OVHCloud, switchable via Terraform variable
- **Structure**: `app/` (not `services/`), `deploy/terraform/` for infra
