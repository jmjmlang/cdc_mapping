# PHC Mapping System

A web-based Primary Health Care case mapping system for the Municipality of Luna, Apayao.
Built as a capstone project using Laravel, Leaflet.js, and Tailwind CSS.

## Features

- Interactive disease case mapping with OpenStreetMap
- Case report submission and admin verification workflow
- Decision Support System (DSS) with 30-day rolling analysis
- Role-based access (Admin / Citizen)
- Activity logging and user management

## Requirements

- PHP 8.3+
- Composer
- Node.js 
- MySQL

## Setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan serve
```

## Laravel Cloud

Recommended Laravel Cloud commands:

```bash
# Build command
composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan optimize

# Deploy command
php artisan migrate --force
```

If you later add user-uploaded files, attach Laravel Cloud Object Storage and set `FILESYSTEM_DISK` to that bucket instead of relying on local disk persistence.

## Default Admin Account

After seeding, log in with the admin credentials defined in `database/seeders/AdminUserSeeder.php`.

## Tech Stack

- Laravel
- Tailwind CSS 
- Alpine.js
- Leaflet.js 
- Chart.js 
- MySQL
