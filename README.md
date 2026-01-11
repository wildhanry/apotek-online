# Sistem Apotek Online (Simple Online Pharmacy System)

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat&logo=mysql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.0-38B2AC?style=flat&logo=tailwind-css&logoColor=white)

A comprehensive online pharmacy management system built with Laravel 11, featuring role-based access control for Admin, Pharmacist (Apoteker), and Customer roles. This project was developed as a university assignment to demonstrate modern web development practices.

## 📸 Screenshots

### Customer Interface
- Browse products with search and filter functionality
- Shopping cart with quantity management
- Order checkout and history tracking

### Admin Dashboard
- Complete product management (Create, Read, Update, Delete)
- Order monitoring and status updates
- Stock management and analytics

### Pharmacist Dashboard
- Order processing and fulfillment
- Status updates for customer orders
- Low stock alerts

## 🚀 Features

### For Customers
- 🛍️ Browse product catalog with search and filter
- 🛒 Add products to shopping cart with quantity control
- 💳 Secure checkout process
- 📦 View order history and real-time status tracking
- 👤 User profile management
- 📊 Personalized dashboard

### For Pharmacists (Apoteker)
- 📋 Manage order processing workflow
- ✅ Update order status (Pending → Processing → Completed → Cancelled)
- 📉 Monitor low stock products
- 🔔 View pending orders requiring attention
- 📈 Order statistics and metrics

### For Administrators
- ⚙️ Complete product management (CRUD operations)
- 📦 Order management and monitoring
- 👥 User role management
- 📊 System statistics and analytics
- 🏷️ Product category management
- 📸 Product image upload and management
- ⚠️ Stock monitoring and alerts

## 🛠️ Tech Stack

- **Backend**: PHP 8.2+ with Laravel 11
- **Database**: MySQL 8.0
- **Authentication**: Laravel Breeze (Blade Stack)
- **Frontend**: 
  - Blade Templates
  - Tailwind CSS 3.0
  - Alpine.js for interactivity
- **Icons**: Heroicons (SVG)
- **Asset Bundling**: Vite

## 📦 Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & npm
- MySQL 8.0 or higher
- Git

### Step-by-Step Installation

1. **Clone the repository**
```bash
git clone https://github.com/wildhanry/apotek-online.git
cd apotek-online
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install Node.js dependencies**
```bash
npm install
```

4. **Environment setup**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure database in `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=apotek
DB_USERNAME=root
DB_PASSWORD=
```

6. **Create database**
```bash
# MySQL command line or phpMyAdmin
CREATE DATABASE apotek;
```

7. **Run migrations and seeders**
```bash
php artisan migrate:fresh --seed
```

8. **Create storage link**
```bash
php artisan storage:link
```

9. **Build frontend assets**
```bash
npm run build
# Or for development with hot reload:
npm run dev
```

10. **Start development server**
```bash
php artisan serve
```

Visit `http://127.0.0.1:8000` in your browser.

## 👥 Default Users

After running the seeder, you can login with these credentials:

| Role | Email | Password | Access Level |
|------|-------|----------|--------------|
| Admin | admin@example.com | password | Full system access |
| Apoteker | apoteker@example.com | password | Order & stock management |
| Customer | customer@example.com | password | Shopping & order tracking |

## 📁 Project Structure

```
apotek-online/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                    # Authentication controllers
│   │   │   ├── ProductController.php    # Product CRUD
│   │   │   ├── CartController.php       # Shopping cart logic
│   │   │   ├── OrderController.php      # Order processing
│   │   │   ├── DashboardController.php  # Role-based dashboards
│   │   │   └── ProfileController.php    # User profile
│   │   ├── Middleware/
│   │   │   └── RoleMiddleware.php       # Role-based access control
│   │   └── Requests/
│   │       └── Auth/                    # Form validation requests
│   └── Models/
│       ├── User.php                     # User with roles
│       ├── Product.php                  # Product catalog
│       ├── Order.php                    # Order headers
│       └── OrderItem.php                # Order line items
│
├── database/
│   ├── migrations/
│   │   ├── create_users_table.php       # Users with role column
│   │   ├── create_products_table.php    # Product catalog
│   │   ├── create_orders_table.php      # Order headers
│   │   └── create_order_items_table.php # Order details
│   └── seeders/
│       └── DatabaseSeeder.php           # Sample data
│
├── resources/
│   ├── css/
│   │   └── app.css                      # Tailwind CSS + custom styles
│   ├── js/
│   │   ├── app.js                       # Alpine.js initialization
│   │   └── bootstrap.js                 # Axios setup
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php            # Main layout
│       │   ├── navigation.blade.php     # Navigation bar
│       │   └── guest.blade.php          # Guest layout
│       ├── auth/                        # Login, Register
│       ├── products/                    # Product views
│       ├── cart/                        # Shopping cart
│       ├── orders/                      # Order management
│       ├── dashboard/                   # Role dashboards
│       └── admin/                       # Admin panels
│
├── routes/
│   ├── web.php                          # Application routes
│   └── auth.php                         # Authentication routes
│
├── public/
│   ├── storage/                         # Symlink to storage/app/public
│   └── build/                           # Compiled assets
│
└── storage/
    └── app/
        └── public/                      # Public file uploads
            └── products/                # Product images
```

## 🗄️ Database Schema

### Users Table
- id, name, email, password
- **role** (enum: 'admin', 'apoteker', 'customer')
- timestamps

### Products Table
- id, name, slug, category, price, stock, description, image
- timestamps

### Orders Table
- id, user_id (FK), total_price
- **status** (enum: 'pending', 'processing', 'completed', 'cancelled')
- timestamps

### Order Items Table
- id, order_id (FK), product_id (FK), quantity, price
- timestamps

## 🔐 Role-Based Access Control

### Middleware Implementation
```php
// Protect routes with role middleware
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('admin/products', ProductController::class);
});

Route::middleware(['auth', 'role:admin,apoteker'])->group(function () {
    Route::get('admin/orders', [OrderController::class, 'adminIndex']);
});
```

### Roles & Permissions

| Feature | Admin | Apoteker | Customer |
|---------|-------|----------|----------|
| View Products | ✅ | ✅ | ✅ |
| Manage Products | ✅ | ❌ | ❌ |
| View All Orders | ✅ | ✅ | Own Only |
| Update Order Status | ✅ | ✅ | ❌ |
| Place Orders | ✅ | ✅ | ✅ |
| Manage Users | ✅ | ❌ | ❌ |

## 🎨 UI/UX Features

- **Responsive Design**: Mobile-first approach with Tailwind CSS
- **Interactive Components**: Alpine.js for dropdown menus and modals
- **Clean Interface**: Professional pharmacy-themed design
- **User Feedback**: Toast notifications and form validation
- **Accessibility**: Semantic HTML and ARIA labels

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit
```

## 🚀 Deployment

### Production Setup

1. Set environment to production in `.env`:
```env
APP_ENV=production
APP_DEBUG=false
```

2. Optimize Laravel:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. Build production assets:
```bash
npm run build
```

4. Set proper file permissions:
```bash
chmod -R 775 storage bootstrap/cache
```

## 🎓 University Project

This project was developed as a university assignment to demonstrate:
- ✅ Laravel framework proficiency and best practices
- ✅ MVC architecture implementation
- ✅ Database design with proper relationships
- ✅ Role-based access control (RBAC)
- ✅ E-commerce functionality (cart, checkout, orders)
- ✅ Modern UI/UX design with Tailwind CSS
- ✅ RESTful API principles
- ✅ Security best practices (CSRF, password hashing, authorization)

## 📚 Key Learning Outcomes

- Building full-stack web applications with Laravel
- Implementing authentication and authorization
- Database design and Eloquent ORM
- Frontend development with Blade and Tailwind CSS
- Version control with Git
- Project documentation and deployment

## 🤝 Contributing

Contributions, issues, and feature requests are welcome!

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is open-sourced for educational purposes under the MIT License.

## 👨‍💻 Author

**Wildhan RY**
- GitHub: [@wildhanry](https://github.com/wildhanry)

## 🙏 Acknowledgments

- Laravel framework and community
- Tailwind CSS for the amazing utility-first CSS framework
- Alpine.js for lightweight JavaScript interactivity
- All contributors and supporters

---

**Made with ❤️ for educational purposes**
