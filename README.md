## Create Database
create database cars;

##  use the below config in .env

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cars
DB_USERNAME=root
DB_PASSWORD=


## table migration
php artisan migrate
