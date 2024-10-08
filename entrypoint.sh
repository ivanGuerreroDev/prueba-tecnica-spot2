#!/bin/bash

# Espera a que MySQL esté listo
/usr/bin/wait-for-it mysql:3306 --timeout=30 --strict -- echo "MySQL is up"

# Ejecuta migraciones solo si MySQL está disponible
php artisan migrate --seed

# Inicia el servidor PHP-FPM
php-fpm
