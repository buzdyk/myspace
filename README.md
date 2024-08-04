# myspace

Shows time tracked with enabled sources (app/Services/Api/*).
Supports daily and monthly goals (see .env).

![goals page](./readme.png)
![month review page](./readme2.png)


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
