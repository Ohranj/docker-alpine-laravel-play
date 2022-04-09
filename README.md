## Getting started

### Key env Variables

```
APP_MASTER_EMAIL
APP_MASTER_PASSWORD
```

### Setup

```
php artisan run:refreshDB
```

The above command will migrate and seed the database with necessary starter data, alongside 10 dummy user accounts. A master account will also be seeded, created from the data associated to the APP_MASTER_EMAIL and APP_MASTER_PASSWORD env keys.

## Good to knows

### Custom Commands

```
php artisan run:refreshDB
 - Wipe the database, run migrations and repopulate the necessary tables with dummy data

php artisan run:backupDB
 - Create a backup of the database data - stored in Storage/app/backup
```

## Docker - TBC

```
docker build -t fitness-tracker .
docker run -it -p 8000:8000 fitness-tracker
```
