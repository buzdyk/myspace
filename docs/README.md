# myspace

Features:
- Unifies time data gathered from connected providers
- Transparent day-to-day time tracking
- Serves as a source of truth for monthly invoicing

<img src="readme.gif" alt="drawing" style="width:800px;"/>

Currently available time providers are:
- clockify
- everhour
- mayven

## Setup

### Running with Docker (Recommended)

Prerequisites:
- [Docker](https://docs.docker.com/get-docker/) and Docker Compose installed
- Make

```bash
# Copy environment file
cp .env.example .env

# Start Docker containers
make up

# Install dependencies and setup application
make composer
make artisan CMD='key:generate'
make migrate
make npm
make build
```

The application will be available at `http://localhost:8888`

**Common commands:**
```bash
# View all available commands
make help

# Stop containers
make down

# Restart containers
make restart

# Access container shell
make shell

# Run artisan commands
make artisan CMD='cache:clear'

# Run migrations
make migrate

# Development mode with hot reload
make watch

# Build assets for production
make build

# Access MySQL database
make mysql
```

**Environment Configuration for Docker:**

Update your `.env` file with the following database and cache settings:
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=myspace
DB_USERNAME=sail
DB_PASSWORD=password

CACHE_STORE=redis
REDIS_HOST=redis
QUEUE_CONNECTION=redis
```

### Alternative Setup (Without Docker)

```bash
cp .env.example .env
composer install
php artisan migrate
npm install
npm run build
```

Alternative self-hosting options:
1. `php artisan serve`
2. [Laravel Valet](https://laravel.com/docs/11.x/valet)
3. [Laravel Sail](https://laravel.com/docs/11.x/sail)

To make /today page run smoother use queue connection other than sync.
