#!/bin/sh

php artisan migrate --force --seed
exec apache2-foreground