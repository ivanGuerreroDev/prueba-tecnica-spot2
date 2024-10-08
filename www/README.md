# Laravel ReactJS Test Code

(2021) A Laravel 11.x

* [Installation](#installation)

* [Usage](#usage)

* [API Documentation](#api-documentation)

* [Unit Tests](#unit-tests)

## Installation

* [Laravel Herd](https://herd.laravel.com)
* [MySQL (recommended) or database engine of SQLite, MariaDB, PostgreSQL, SQL Server](https://laravel.com/docs/11.x/database#introduction)
* [https://laravel.com/docs/11.x/installation](https://laravel.com/docs/11.x/installation)
* [https://laravel.com/docs/11.x/vite#main-content](https://laravel.com/docs/11.x/vite#main-content)

```bash
# Create our environment file.
cp .env.example .env
# Update database values in .env file.
# Install our app dependencies.
composer i
php artisan key:generate
# Before running the next command:
# Update your database details in .env
php artisan migrate --seed
npm install
npm run build
```

## Usage

```bash
php artisan serve
```

## API Documentation

```bash
php artisan route:list
```

## Unit Tests

```bash
php artisan test
```
