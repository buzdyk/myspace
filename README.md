# myspace

- Unifies time data it gathers from different providers.
- Helps with invoicing and day-to-day time tracking.

<img src="readme.gif" alt="drawing" style="width:800px;"/>


Currently available time providers are:
- clockify
- everhour
- mayven

## Setup

```
cp .env.example .env
composer install
php artisan migrate
npm install
npm run build
```

There are 3 common options to self-host:
1. `php artisan serve` 
2. [Laravel Valet](https://laravel.com/docs/11.x/valet)
3. [Laravel Sail](https://laravel.com/docs/11.x/sail)

To make /today page run smoother use queue connection other than sync.
