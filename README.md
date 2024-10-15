# Trucks CRUD Application

## Description
This is a Laravel-based web application for managing trucks. It allows users to create, read, update, and delete (CRUD) truck records, including details about each truck and its subunits. A subunit represents a truck that temporarily replaces another truck when it is out of service.

## Features
- **CRUD Operations for Trucks**
  - Unit Number (required)
  - Year of Registration (required, must be between 1900 and 5 years from now)
  - Notes (optional)

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

## Requirements
- PHP >= 8.1
- Composer
- Laravel >= 10
- MySQL or another database supported by Laravel

## Installation

### 1. Clone the Repository
```bash
git clone https://github.com/XElderX/trucks.git
