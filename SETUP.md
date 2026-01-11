# Sistem Apotek Online - Setup Instructions

## Prerequisites
- PHP 8.2 or higher
- Composer
- MySQL
- Node.js & NPM

## Installation Steps

### 1. Install Dependencies
```bash
composer install
npm install
```

### 2. Environment Setup
```bash
# Copy .env.example to .env
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 3. Database Configuration
Edit `.env` file and configure your database:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=apotek
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Run Migrations & Seeders
```bash
# Create database tables and seed initial data
php artisan migrate:fresh --seed
```

### 5. Storage Link
```bash
# Create symbolic link for public storage
php artisan storage:link
```

### 6. Build Assets
```bash
# Compile CSS and JavaScript
npm run build

# Or for development with hot reload:
npm run dev
```

### 7. Start Development Server
```bash
php artisan serve
```

Visit: http://localhost:8000

## Default User Credentials

### Admin
- Email: admin@example.com
- Password: password

### Apoteker
- Email: apoteker@example.com
- Password: password

### Customer
- Email: customer@example.com
- Password: password

## Features by Role

### Admin
- Full product management (CRUD)
- Order management
- View all statistics
- Manage order status

### Apoteker
- View and manage orders
- Update order status
- View product stock alerts

### Customer
- Browse product catalog
- Add products to cart
- Checkout and create orders
- View order history

## Project Structure
```
app/
├── Http/Controllers/
│   ├── ProductController.php
│   ├── CartController.php
│   ├── OrderController.php
│   └── DashboardController.php
├── Models/
│   ├── Product.php
│   ├── Order.php
│   └── OrderItem.php
└── Middleware/
    └── RoleMiddleware.php

resources/views/
├── layouts/
├── products/
├── cart/
├── orders/
├── dashboard/
└── admin/

routes/
└── web.php
```

## Technologies Used
- Laravel 11
- Laravel Breeze (Authentication)
- Tailwind CSS
- Alpine.js
- MySQL
