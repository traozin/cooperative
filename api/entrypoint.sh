#!/bin/bash

until nc -z "$DB_HOST" 3306; do
  echo "Aguardando MySQL em $DB_HOST:3306..."
  sleep 10
done

echo "MySQL está pronto. Continuando..."

if [ ! -f .env ]; then
  cp .env.example .env
fi

composer install --no-interaction --optimize-autoloader
php artisan key:generate
php artisan migrate
php artisan db:seed

chmod -R 775 storage bootstrap/cache

if [ "$RUN_TESTS" = "true" ]; then
  echo "Executando testes com PHPUnit..."
  php artisan test
fi

exec "$@"
