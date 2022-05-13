## Getting started

### Key env Variables

```
APP_MASTER_EMAIL
APP_MASTER_PASSWORD
QUEUE_CONNECTION=database
```

### Setup

```
php artisan run:refreshDB
```

The above command will migrate and seed the database with necessary starter data, alongside 10 dummy accounts. A master account is included in the seed, created from the data associated to the APP_MASTER_EMAIL and APP_MASTER_PASSWORD env keys.

## Good to knows

-   Emails are dispatched to a queue and so the queue worker will need to be ran (emails: contact us form, password reset).

### Custom Commands

```
php artisan run:refreshDB
 - Wipe the database, run migrations and repopulate the necessary tables with dummy data

php artisan run:backupDB
 - Create a backup of the database data - stored in Storage/app/backup
```

## Tests

Tests are split into the following groups

-   @group login
    -   Login Success and Login Failuer

```
php artisan dusk --group=login
```

## Docker - TBC

```
Create a mysql folder in the root of the project
docker compose run --rm composer install
docker compose run --rm npm install - needed for browsersync
docker compose run --rm artisan run:refreshDB
docker compose run nginx OR docker compose up

You can run npm or artisan commands via docker compose run --rm [artisan || npm] [make:model POST --migration || i package]
```

## Tech used

-   Laravel
-   AlpineJS
-   Tailwind
