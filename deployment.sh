#!/bin/bash

git up
composer install
composer dump-autoload -o
php /var/www/html/application/artisan down
php /var/www/html/application/artisan clear-compiled
php /var/www/html/application/artisan cache:clear
php /var/www/html/application/artisan view:clear
php /var/www/html/application/artisan config:clear
php /var/www/html/application/artisan config:cache
php /var/www/html/application/artisan route:clear
php /var/www/html/application/artisan route:cache
php /var/www/html/application/artisan optimize
php /var/www/html/application/artisan queue:restart
php /var/www/html/application/artisan up
