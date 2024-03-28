#!/bin/sh
set -e
# chmod -Rv 777 storage

# Parse .env file to Environment
set -a
[ -f .env ] && . .env
set +a

php artisan config:clear
php artisan migrate
# php artisan l5-swagger:generate
php artisan about

figlet POMODORO APP

echo "Starting $@"
exec "$@"