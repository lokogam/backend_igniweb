#!/bin/bash

# Verificar si el directorio actual es el correcto
if [ ! -f "composer.json" ]; then
    echo "Error: composer.json no encontrado. Asegúrate de estar en el directorio correcto del proyecto."
    exit 1
fi

# Verificar si el archivo .env existe; si no, copiar desde .env.example
if [ ! -f ".env" ]; then
    echo ".env no encontrado. Creando desde .env.example..."
    cp .env.example .env
    echo ".env creado exitosamente."
else
    echo ".env ya existe."
fi

# Generar la clave de la aplicación
echo "Generando clave de aplicación de Laravel..."
./vendor/bin/sail artisan key:generate

echo "Iniciando instalación de dependencias con Composer..."

# Ejecutar composer install con Docker
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs

# Verificar si la instalación de composer fue exitosa
if [ $? -ne 0 ]; then
    echo "Error: La instalación de Composer falló"
    exit 1
fi

sleep 2


# Ejecutar Composer update y las migraciones con seeds dentro del contenedor
./vendor/bin/sail up -d

# Verificar si Sail se inició correctamente
if [ $? -ne 0 ]; then
    echo "Error: No se pudo iniciar Sail"
    exit 1
fi

sleep 2

# Actulizacion de  composer
./vendor/bin/sail composer update

# Verificar si Composer  se actualizó correctamente
if [ $? -ne 0 ]; then
    echo "Error: No se pudo  actualizar Composer"
    exit 1
fi

sleep 2
# Ejecutar las migraciones con seeds
./vendor/bin/sail artisan migrate:fresh --seed

# Verificar si  las migraciones se ejecutaron correctamente
if [ $? -ne 0 ]; then
    echo "Error: No se pudo  ejecutar la migración"
    exit 1
fi

sleep 2

echo "¡Proceso completado exitosamente!"