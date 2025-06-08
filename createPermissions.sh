#!/bin/bash

# Executa o seeder para criar o super-admin e permissões
php artisan db:seed --class=AdminAssignAllPermissions

# Limpa os caches do Laravel
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan permission:cache-reset

echo "Permissões criadas e caches limpos com sucesso!"