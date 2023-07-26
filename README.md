# Project Readme

This project is built with PHP and Laravel, utilizing MySQL as the database.

## Project Details

- PHP version: PHP 8.1.10
- Laravel version: Laravel Framework 10.16.0
- MySQL version: MySQL 8.0.30

## Setup

To set up the project, follow these steps:

1. Install PHP 8.1.10 and MySQL 8.0.30 on your system if you haven't already.
2. Clone the project repository to your local machine.
3. Create .env file
```
APP_NAME="Online Store"
APP_ENV=local
APP_KEY=base64:iFaWhi9hI3ckOvqn5pZzJHUfteV4767JE9pez6fiRbg=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=online_store
DB_USERNAME=root
DB_PASSWORD=
```
4. Run
```
composer install
```
5. Install Vite as a local project dependency within your specific project directory
```
npm install vite --save-dev
```
6. Run 
```
npm run build
```
7. Run the migration script to set up the database schema
```
php artisan migrate
```

## Run Test Scripts

To execute the test scripts, run the following command:

```
php artisan test
```

Hope to hear from you soon!🚀