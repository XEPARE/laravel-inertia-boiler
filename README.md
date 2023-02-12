<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

# Boilerplate Laravel 9.x

A Laravel boilerplate with the latest technologies and best practices to kickstart your project.

## Features
- PHP 8.2
- Vite
- TailwindCSS
- InertiaJS
- Vue3
- Docker ready
- Jetstream for authentication and authorization
- Enums for improved database management
- Snowflake for unique ID generation
- Sentry for error tracking and reporting
- Buildset for continuous integration and deployment (Github Actions)

## Getting Started

1. Clone the repository
   git clone https://github.com/XEPARE/laravel-inertia-boiler.git
2. Install composer dependencies
   composer install
3. Install npm dependencies
   npm install
4. Copy the example env file and make the required configuration changes in the .env file
   cp .env.example .env
5. Add database credentials to .env file
6. Generate application key
   php artisan key:generate
7. Create tables and seed initial data
   php artisan migrate --seed
8. Run the npm build script
   npm run dev
9. Start the local development server
   php artisan serve
10. You can now access the server at http://localhost:8000
11. Login using the default credentials
    Email: admin@example.com - Password: 123admin456