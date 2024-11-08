#!/bin/bash

# Verificar si el directorio actual es el correcto
if [ ! -f "composer.json" ]; then
    echo "Error: composer.json no encontrado. Asegúrate de estar en el directorio correcto del proyecto."
    exit 1
fi

echo "Iniciando instalación de dependencias con Composer..."

# Ejecutar composer install con Docker
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    composer install

# Verificar si la instalación de composer fue exitosa
if [ $? -ne 0 ]; then
    echo "Error: La instalación de Composer falló"
    exit 1
fi

echo "Instalación de Composer completada. Iniciando Sail..."

# Esperar un momento para asegurar que todos los archivos estén escritos
sleep 2

# Iniciar Sail
./vendor/bin/sail up -d

# Verificar si Sail se inició correctamente
if [ $? -ne 0 ]; then
    echo "Error: No se pudo iniciar Sail"
    exit 1
fi

echo "¡Proceso completado exitosamente!"
