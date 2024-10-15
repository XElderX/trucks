# Trucks CRUD Application

## Description
This is a Laravel-based web application for managing trucks. It allows users to create, read, update, and delete (CRUD) truck records, including details about each truck and its subunits. A subunit represents a truck that temporarily replaces another truck when it is out of service.

## Features
- **CRUD Operations for Trucks**
  - Unit Number 
  - Year of Registration
  - Notes

- **Subunit Management**
  - Assign subunits to trucks with:
    - Main Truck
    - Subunit Truck
    - Start Date
    - End Date
  - Validations to ensure:
    - A truck cannot be its own subunit.
    - Subunit date ranges do not overlap.
    - A truck cannot be assigned as a subunit while it is already a subunit for another truck.

## Installation

###

```bash
git clone https://github.com/XElderX/trucks.git

composer install
cp .env.example .env

set up .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=trucks_db
DB_USERNAME=your_username
DB_PASSWORD=your_password

php artisan key:generate
php artisan migrate
php artisan serve

