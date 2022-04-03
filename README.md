#### Docker

```
docker build -t fitness-tracker .
docker run -it -p 8000:8000 fitness-tracker
```

#### Commands

```
php artisan run:refreshDB
 - Wipe the database, run migrations and repopulate the necessary tables with dummy data

php artisan run:backupDB
 - Create a backup of the database data - stored in Storage/app/backup
```
