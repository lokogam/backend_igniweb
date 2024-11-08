# Aplicación de Reserva de Libros

Este es un proyecto desarrollado para el proceso de selección de Igniweb SAS. La aplicación permite a los usuarios gestionar sus reservas de libros, incluyendo:

- Autenticación de usuarios 
- Listado de libros disponibles con filtrado por categoría
- Reserva de libros por un número de días seleccionado
- Listado de reservas activas del usuario
- Eliminación de reservas

## Tecnologías utilizadas

### Backend
- Laravel 
- PHP 8
- MySQL

### Frontend
- Vue.js 3
- Vite
- Axios (Para las peticiones asíncronas)
- Tailwind CSS (Para el diseño)

## Instalación y puesta en marcha

### Backend

1. Clona el repositorio:
   ```bash
   git clone https://github.com/lokogam/backend_igniweb.git
   cd backend_igniweb
   ```
2. Ejecuta el script de configuración del entorno:
   ```bash
   chmod +x setup-docker.sh
   ./setup-docker.sh
   ```
3. Accede a la aplicación en el navegador: [http://localhost:80](http://localhost:80)

### Frontend

1. Clona el repositorio:
   ```bash
   git clone https://github.com/lokogam/frontend_igniweb.git
   cd frontend_igniweb
   ```
2. Levanta los contenedores Docker:
   ```bash
   docker-compose up -d --build
   ```
3. Accede a la aplicación en el navegador: [http://localhost:8000](http://localhost:8000)

## Características principales

- **Autenticación de usuarios**: Los usuarios deben iniciar sesión para poder acceder a la aplicación y gestionar sus reservas.
- **Listado de libros disponibles**: Se muestra un listado de los libros disponibles para reservar, con la posibilidad de filtrar por categoría.
- **Reserva de libros**: Los usuarios pueden reservar libros seleccionando la cantidad de días que desean tenerlos.
- **Listado de reservas activas**: Los usuarios pueden ver un listado de sus reservas activas y eliminarlas cuando lo deseen.
- **Validación y mensajes de estado**: El sistema valida las acciones de los usuarios y muestra los mensajes de éxito, advertencia o error correspondientes.
- **Documentación en inglés**: El código fuente y la documentación del proyecto están en inglés.

## Video de guía

Puedes ver un video explicativo de la funcionalidad del sistema en el siguiente enlace: [Video de guía](#)

## Autor
LinkedIn: [Duvan Gamboa](https://www.linkedin.com/in/duvan-gamboa-5193951b2/)
Email: [duvangamboa8@gmail.com](mailto:duvangamboa8@gmail.com) 