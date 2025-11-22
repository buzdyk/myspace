.PHONY: help watch build up down restart shell mysql composer artisan migrate test npm clean

# Default target
help:
	@echo "Available commands:"
	@echo "  make watch      - Start Vite dev server with hot reload"
	@echo "  make build      - Build assets for production"
	@echo "  make clean      - Clean Vite build cache"
	@echo "  make up         - Start Docker stack"
	@echo "  make down       - Stop Docker stack"
	@echo "  make restart    - Restart Docker stack"
	@echo "  make shell      - Open shell in Laravel container"
	@echo "  make mysql      - Login to MySQL database"
	@echo "  make composer   - Run composer install"
	@echo "  make npm        - Run npm install"
	@echo "  make artisan    - Run artisan commands (e.g., make artisan CMD='migrate')"
	@echo "  make migrate    - Run database migrations"
	@echo "  make test       - Run tests"

# Watch assets (development mode with hot reload)
watch:
	docker-compose exec laravel.test npm run dev

# Build assets for production
build:
	docker-compose exec laravel.test npm run build

# Clean Vite cache
clean:
	docker-compose exec laravel.test rm -rf public/build node_modules/.vite

# Start Docker stack
up:
	docker-compose up -d

# Stop Docker stack
down:
	docker-compose down

# Restart Docker stack
restart: down up

# Open shell in Laravel container
shell:
	docker-compose exec laravel.test bash

# Login to MySQL database
mysql:
	docker-compose exec mysql mysql -usail -ppassword myspace

# Install composer dependencies
composer:
	docker-compose exec laravel.test composer install

# Install npm dependencies
npm:
	docker-compose exec laravel.test npm install

# Run artisan commands
artisan:
	docker-compose exec laravel.test php artisan $(CMD)

# Run database migrations
migrate:
	docker-compose exec laravel.test php artisan migrate

# Run tests
test:
	docker-compose exec laravel.test php artisan test