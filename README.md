# Check DC Book Library API

This repository holds Check DC Book Library Code Assessment

## Prerequisites

- PHP version 8.0

## Start up

To start the book library app, perform the following step in the order

- Clone the repository by running the command 'git clone https://github.com/'
- Run composer install
- Run 'cp .env.example .env'
- Fill your configuration settings in the '.env' file you created above
- Run 'php artisan key:generate'
- Run 'php artisan migrate --seed'
- Run './vendor/bin/sail up' to startup the application
