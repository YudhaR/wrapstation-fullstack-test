# CodeIgniter CMS - Product Purchase System

Project ini merupakan implementasi Content Management System (CMS) sederhana menggunakan CodeIgniter 4 untuk mensimulasikan proses pembelian produk sesuai technical test dari Wrap Station Group.

Sistem ini mengimplementasikan dasar CRUD (Create, Read, Update, Delete), cart system, checkout, dan payment simulation  tanpa fitur authentication maupun authorization.

## Features

- Product CRUD (Create, Read, Update, Delete)
- Dashboard Admin
- Upload gambar produk
- Shopping Cart System
- Checkout System
- Payment Simulation
- Product Inventory Management
- Database Migration & Seeder
- Responsive UI menggunakan Tailwind CSS

---

# Technologies

- PHP 8+
- CodeIgniter 4
- MySQL
- Tailwind CSS
- phpMyAdmin

---

# Project Structure

```bash
03-codeigniter-cms/
│
├── app/
│   ├── Config/
│   ├── Controllers/
│   │   ├── admin/
│   │   │   ├── DashboardController.php
│   │   │   └── ProductController.php
│   │   ├── CartController.php
│   │   ├── CheckoutController.php
│   │   ├── HistoryController.php
│   │   ├── HomeController.php
│   │   └── PaymentController.php
│   │
│   ├── Database/
│   │   ├── Migrations/
│   │   │   ├── 2026-05-12-154750_CreateUsersTable.php
│   │   │   ├── 2026-05-12-154755_CreateProductsTable.php
│   │   │   └── 2026-05-12-154800_CreateTransactionsTable.php
│   │   └── Seeds/
│   │       ├── DatabaseSeeder.php
│   │       ├── ProductSeeder.php
│   │       ├── TransactionSeeder.php
│   │       └── UserSeeder.php
│   │
│   ├── Models/
│   │   ├── ProductModel.php
│   │   ├── TransactionModel.php
│   │   └── UserModel.php
│   │
│   └── Views/
│       ├── admin/
│       ├── cart/
│       ├── checkout/
│       ├── history/
│       ├── home/
│       └── payment/
│
├── public/
│   ├── assets/
│   │   ├── css/
│   │   └── images/
│   │
│   └── uploads/
│       └── products/
│
├── writable/
├── spark
├── composer.json
└── README.md
```

---

# Database Migration

Project ini menggunakan fitur Migration bawaan CodeIgniter 4.

Pastikan database sudah dibuat terlebih dahulu di MySQL/phpMyAdmin.

Contoh:

```sql
CREATE DATABASE db_wrapstation_cms;
```

---

# Setup Project

Masuk ke folder project:

```bash
cd 03-codeigniter-cms
```

Install dependencies:

```bash
composer install
```

Copy file environment:

```bash
cp env .env
```

Atur konfigurasi database pada file:

```bash
.env
```

Contoh konfigurasi:

```env
database.default.hostname = localhost
database.default.database = db_wrapstation_cms
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3306
```

---

# Tailwind CSS Setup

Project ini menggunakan Tailwind CSS untuk styling UI.

Install dependencies Tailwind CSS:

```bash
npm install
```


Tailwind CSS digunakan untuk:

- Responsive Layout
- Product Card Styling
- Dashboard Admin
- Form Styling
- Button & Toast Notification
- Shopping Cart Interface
- Payment UI

---

# Run Migration

Jalankan migration:

```bash
php spark migrate
```

Jalankan seeder:

```bash
php spark db:seed DatabaseSeeder
```

---

# Run Project

Jalankan server CodeIgniter:

```bash
php spark serve
```

Jalankan server CodeIgniter:

```bash
npm run dev
```

Akses project melalui browser:

```bash
http://localhost:8080
```

---

# Admin Features

Halaman admin digunakan untuk:

- Menambahkan produk
- Mengedit produk
- Menghapus produk
- Melihat inventory produk
- Upload gambar produk

Route admin:

```bash
/admin/products
```

---

# User Features

User dapat:

- Melihat daftar produk
- Menambahkan produk ke cart
- Checkout produk
- Simulasi pembayaran
- Melihat history transaksi

---

# Product Images

Gambar produk disimpan pada folder:

```bash
public/uploads/products/
```

---

# Tailwind CSS

File output Tailwind berada di:

```bash
public/assets/css/output.css
```

---

# Notes

- Project ini menggunakan localhost environment.
- Authentication dan authorization tidak diimplementasikan sesuai requirement technical test.
- Database migration dan seeder sudah disediakan.
- UI dibuat responsive menggunakan Tailwind CSS.