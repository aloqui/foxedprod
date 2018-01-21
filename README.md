# foxedprod

##Install:
##prerequisite(s)
composer (latest)
node npm (latest)
xampp (latest)
php (at least 7.1 up)

##Installation proper:
npm install
composer self-update
composer install
composer-update

php artisan migrate
php artisan storage:link
php artisan event:generate

##Database:
php artisan passport:install

##Development
cd backend
##on two(2) terminals, run these commands:
npm run watch
php artisan serve

## Production/Deployment

---
