# composer self-update
# composer install --optimize-autoloader --no-interaction --no-progress --no-cache
# ->^  --no-dev

php artisan cache:clear
php artisan route:cache
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan config:clear

#php artisan optimize:clear
#php artisan clear-compiled
#composer dump-autoload
#php artisan migrate

# php artisan migrate:fresh --seed
# php artisan db:seed

# php artisan l5-swagger:generate