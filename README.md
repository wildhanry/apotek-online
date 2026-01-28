# 🏥 Sistem Apotek Online

[![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-blue.svg)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-orange.svg)](https://www.mysql.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.0-38B2AC.svg)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

Aplikasi manajemen apotek online berbasis web yang dibangun dengan Laravel 11, dilengkapi dengan AI Chatbot powered by Google Gemini untuk memberikan rekomendasi obat dan panduan kesehatan.

---

## 📋 Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Teknologi](#-teknologi-yang-digunakan)
- [Prasyarat](#-prasyarat)
- [Instalasi](#-instalasi)
- [Konfigurasi](#-konfigurasi)
- [Struktur Database](#-struktur-database)
- [Role & Hak Akses](#-role--hak-akses)
- [Fitur AI Chatbot](#-fitur-ai-chatbot)
- [Screenshot](#-screenshot)
- [Testing](#-testing)
- [Deployment](#-deployment)
- [Kontribusi](#-kontribusi)
- [Lisensi](#-lisensi)

---

## ✨ Fitur Utama

### 🛒 Untuk Pelanggan
- **Katalog Obat**: Browse produk dengan search dan filter kategori
- **Keranjang Belanja**: Add to cart dengan update quantity real-time
- **Upload Resep**: Upload foto resep dokter saat checkout
- **Riwayat Pesanan**: Track status pesanan (Pending → Processing → Completed)
- **AI Chatbot**: Asisten apoteker pintar untuk rekomendasi OTC dan FAQ

### 💊 Untuk Apoteker
- **Validasi Resep**: Review dan approve/reject resep yang diupload pelanggan
- **Manajemen Pesanan**: Update status pesanan dan monitoring
- **Dashboard Statistik**: Pesanan pending, processing, completed hari ini
- **Alert Stok Rendah**: Notifikasi produk yang stoknya menipis

### 🔐 Untuk Admin
- **CRUD Produk**: Create, Read, Update, Delete obat-obatan
- **Manajemen Pengguna**: Monitoring dan kontrol user
- **Dashboard Analytics**: Total revenue, orders, customers, low stock products
- **Laporan Penjualan**: Riwayat transaksi lengkap dengan detail

---

## 🚀 Teknologi yang Digunakan

| Kategori | Teknologi |
|----------|-----------|
| **Backend** | Laravel 11, PHP 8.2+ |
| **Frontend** | Blade Templates, Tailwind CSS 3.0, Alpine.js |
| **Database** | MySQL 8.0 |
| **Authentication** | Laravel Breeze (Session-based) |
| **AI Integration** | Google Gemini API 2.5-flash (Free Tier) |
| **Asset Bundling** | Vite |
| **Version Control** | Git |

---

## 📦 Prasyarat

Pastikan sistem Anda telah terinstal:

- **PHP** >= 8.2
- **Composer** >= 2.0
- **Node.js** >= 20.x & npm >= 10.x
- **MySQL** >= 8.0
- **Git**

---

## 🔧 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/wildhanry/apotek-online.git
cd apotek-online
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

### 3. Setup Environment

```bash
# Copy file .env
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=apotek
DB_USERNAME=root
DB_PASSWORD=
```

Buat database:

```bash
mysql -u root -p
CREATE DATABASE apotek;
exit;
```

### 5. Migrasi & Seeding

```bash
# Run migrations
php artisan migrate

# Seed database dengan sample data
php artisan db:seed
```

**Default Users:**
| Role | Email | Password |
|------|-------|----------|
| Admin | admin@apotek.com | password |
| Apoteker | apoteker@apotek.com | password |
| Customer | customer@apotek.com | password |

### 6. Setup Storage

```bash
php artisan storage:link
```

### 7. Build Assets

```bash
npm run build
```

### 8. Jalankan Server

```bash
php artisan serve
```

Akses aplikasi di: **http://localhost:8000**

---

## ⚙️ Konfigurasi

### Google Gemini API (AI Chatbot)

1. Dapatkan API Key gratis di: https://makersuite.google.com/app/apikey
2. Tambahkan ke `.env`:

```env
GEMINI_API_KEY=AIzaSyXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
```

3. Clear config cache:

```bash
php artisan config:clear
```

### File Upload Configuration

Edit `php.ini` jika perlu upload file lebih besar:

```ini
upload_max_filesize = 2M
post_max_size = 2M
```

---

## 🗄️ Struktur Database

### Tabel Utama

#### `users`
| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary Key |
| name | varchar(255) | Nama user |
| email | varchar(255) | Email (unique) |
| password | varchar(255) | Hashed password |
| role | enum | 'admin', 'apoteker', 'customer' |
| created_at | timestamp | Waktu registrasi |

#### `products`
| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary Key |
| name | varchar(255) | Nama obat |
| slug | varchar(255) | URL-friendly name |
| category | varchar(255) | Kategori obat |
| price | integer | Harga (Rupiah) |
| stock | integer | Jumlah stok |
| description | text | Deskripsi produk |
| image | varchar(255) | Path gambar |

#### `orders`
| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary Key |
| user_id | bigint | FK → users |
| total_price | integer | Total harga |
| status | enum | 'pending', 'processing', 'completed', 'cancelled' |
| prescription_image | varchar(255) | Path resep (nullable) |
| created_at | timestamp | Waktu pemesanan |

#### `order_items`
| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary Key |
| order_id | bigint | FK → orders |
| product_id | bigint | FK → products |
| quantity | integer | Jumlah |
| price | integer | Harga per item |

### Relasi Database

```
users (1) ──→ (N) orders
orders (1) ──→ (N) order_items
products (1) ──→ (N) order_items
```

---

## 👥 Role & Hak Akses

### Admin
✅ Full access ke semua fitur  
✅ CRUD produk  
✅ View semua pesanan & users  
✅ Dashboard analytics lengkap  

### Apoteker
✅ View & update status pesanan  
✅ Validasi resep (approve/reject)  
✅ Dashboard monitoring pesanan  
✅ Alert stok rendah  
❌ Tidak bisa CRUD produk  

### Customer
✅ Browse & search produk  
✅ Keranjang belanja & checkout  
✅ Upload resep dokter  
✅ Track status pesanan  
✅ Akses AI chatbot  
❌ Tidak bisa akses admin panel  

**Middleware:** `RoleMiddleware.php` - Route protection berdasarkan role

---

## 🤖 Fitur AI Chatbot

### Kemampuan Chatbot

1. **Rekomendasi OTC (Over-the-Counter)**
   - Deteksi gejala ringan: flu, sakit kepala, demam, batuk
   - Rekomendasi produk dari database real-time
   - Informasi harga dan stok

2. **Panduan Resep Dokter**
   - Cara upload resep saat checkout
   - Proses validasi apoteker

3. **Order Tracking**
   - Panduan cek status pesanan
   - Arahkan ke menu "Riwayat Pesanan"

4. **FAQ**
   - Jam operasional: 08:00 - 22:00 WIB
   - Pertanyaan umum tentang apotek

### Teknologi

- **Model:** Google Gemini 2.5-flash (Free Tier)
- **Context:** Dynamic product database injection
- **UI:** WhatsApp-style floating chat widget
- **Framework:** Alpine.js for interactivity

### Contoh Interaksi

```
User: "Saya sakit kepala, obat apa yang cocok?"

AI: "Untuk sakit kepala, saya rekomendasikan:

💊 Paracetamol 500mg - Rp 5.000
   Efektif meredakan sakit kepala dan demam.
   Stok tersedia: 100 unit

Konsumsi sesuai dosis dan jangan melebihi 3x sehari. 
Jika sakit berlanjut, segera konsultasi dokter. 😊"
```

---

## 📸 Screenshot

### Customer View
- Katalog Produk
- Detail Produk & Add to Cart
- Checkout dengan Upload Resep
- Riwayat Pesanan
- AI Chatbot Interface

### Admin Dashboard
- Stats Cards (Products, Orders, Revenue)
- Recent Orders Table
- Low Stock Alerts
- Manage Products (CRUD)

### Apoteker Panel
- Pending Orders
- Prescription Validation
- Order Status Update

---

## 🧪 Testing

### Manual Testing Checklist

**Authentication:**
```bash
✅ Register new user
✅ Login/Logout
✅ Update profile
```

**Product Management (Admin):**
```bash
✅ Create product with image
✅ Update product details
✅ Delete product
✅ Search & filter products
```

**Ordering Flow (Customer):**
```bash
✅ Add product to cart
✅ Update cart quantity
✅ Checkout dengan resep
✅ Checkout tanpa resep
✅ View order history
```

**Prescription Validation (Apoteker):**
```bash
✅ View uploaded prescription
✅ Approve prescription (status → processing)
✅ Reject prescription (status → cancelled)
```

**AI Chatbot:**
```bash
✅ Ask OTC recommendation
✅ Ask prescription guide
✅ Ask order tracking
✅ Ask FAQ
✅ Test markdown removal
```

### Test Credentials

```bash
# Run seeder untuk test data
php artisan db:seed

# Test users sudah tersedia:
# admin@apotek.com / password
# apoteker@apotek.com / password
# customer@apotek.com / password
```

---

## 🌐 Deployment

### Production Checklist

1. **Environment:**
```bash
APP_ENV=production
APP_DEBUG=false
```

2. **Database:**
```bash
php artisan migrate --force
php artisan db:seed --force
```

3. **Optimization:**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
npm run build
```

4. **Permissions:**
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

5. **SSL:**
   - Install SSL certificate (Let's Encrypt)
   - Force HTTPS di `.env`: `APP_URL=https://yourdomain.com`

### Server Requirements

- **OS:** Linux (Ubuntu 22.04 LTS recommended)
- **Web Server:** Nginx / Apache
- **PHP:** 8.2+ dengan extensions: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML
- **Database:** MySQL 8.0 / MariaDB 10.3+
- **Memory:** Minimum 512MB RAM

---

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan fork repository ini dan submit pull request.

### Development Workflow

1. Fork repository
2. Create feature branch: `git checkout -b feature/AmazingFeature`
3. Commit changes: `git commit -m 'Add some AmazingFeature'`
4. Push to branch: `git push origin feature/AmazingFeature`
5. Open Pull Request

### Coding Standards

- Follow PSR-12 coding standard
- Write descriptive commit messages
- Add comments untuk complex logic
- Test sebelum submit PR

---

## 📄 Lisensi

Project ini menggunakan [MIT License](LICENSE).

---

## 👨‍💻 Developer

**Wildan Hanry**  
📧 Email: admin@apotek.com  
🔗 GitHub: [@wildhanry](https://github.com/wildhanry)

---

## 🙏 Acknowledgments

- [Laravel Documentation](https://laravel.com/docs)
- [Tailwind CSS](https://tailwindcss.com)
- [Google Gemini AI](https://ai.google.dev)
- [Alpine.js](https://alpinejs.dev)

---

## 📝 Changelog

### Version 1.0.0 (January 2026)
- ✅ Initial release
- ✅ Complete CRUD operations
- ✅ Role-based access control
- ✅ AI Chatbot integration
- ✅ Prescription upload system
- ✅ Stock management
- ✅ Dashboard analytics

---

## 🐛 Known Issues & Roadmap

### Current Issues
- None reported

### Roadmap
- [ ] Export reports to PDF/Excel
- [ ] Email notifications
- [ ] SMS notifications for order updates
- [ ] Payment gateway integration
- [ ] Multi-language support
- [ ] Mobile app (Flutter)

---

**Made with ❤️ for UAS Final Exam**
