# Medical Devices Inventory System

## About
A web-based application for managing medical devices inventory, including purchase orders, stock management, and sales.

## Requirements
- PHP 8.1+
- Composer
- MySQL/MariaDB
- Node.js & NPM

## Installation

1. Copy `.env.example` to `.env`
   ```bash
   cp .env.example .env
   ```

2. Install PHP dependencies
   ```bash
   composer install
   ```

3. Generate App Key
   ```bash
   php artisan key:generate
   ```

4. Install Frontend dependencies
   ```bash
   npm install
   npm run build
   ```

5. Run Migrations
   ```bash
   php artisan migrate --seed
   ```

## License
[MIT](https://opensource.org/licenses/MIT)
