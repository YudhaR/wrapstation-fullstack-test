# Wrap Station Group - Full Stack Developer Technical Test

Repository ini berisi hasil pengerjaan technical test Full Stack Developer dari Wrap Station Group yang terdiri dari 3 bagian utama:

1. AI Training - Fruit Object Detection  
2. IoT & Embedded Systems - Camera Control  
3. CodeIgniter CMS - Product Purchase System  

---

# Repository Structure

```bash
wrapstation-fullstack-test/
│
├── 01-ai-training/
├── 02-iot-camera/
├── 03-codeigniter-cms/
│
└── README.md
```

---

# System Specifications

### 1. AI Training - Fruit Object Detection

| Component | Specification |
|---|---|
| Operating System | Windows 11 64-bit |
| Processor | AMD Ryzen 7 6800H |
| RAM | 16 GB |
| GPU | NVIDIA GeForce RTX 3050 Ti Laptop GPU 4 GB |
| Storage | 1.4 TB SSD |

---

### 2. IoT & Embedded Systems - Camera Control

| Component | Specification |
|---|---|
| Operating System | Linux Ubuntu 24 |
| Processor | Intel i9-12900K |
| RAM | 32 GB |
| GPU | RTX 3060 |
| Storage | 1 TB SSD |
| Camera Library | OpenCV + V4L2 |
| Camera | EYD 2K QHD |
| GUI Framework | CustomTkinter |

---

### 3. CodeIgniter CMS - Product Purchase System

| Component | Specification |
|---|---|
| Operating System | Windows 11 64-bit |
| Processor | AMD Ryzen 7 6800H |
| RAM | 16 GB |
| GPU | NVIDIA GeForce RTX 3050 Ti Laptop GPU 4 GB |
| Storage | 1.4 TB SSD |

---

# 1. AI Training - Fruit Object Detection

Implementasi Object Detection menggunakan YOLO (Ultralytics) untuk mendeteksi dan mengklasifikasikan berbagai jenis buah berdasarkan dataset yang telah disediakan.

## Features

- Training model menggunakan YOLOv11
- Object Detection pada gambar buah
- Menampilkan bounding box dan label kelas
- Popup preview hasil deteksi menggunakan OpenCV
- Menggunakan model hasil training (`best.pt`)
- Dataset sudah menggunakan format YOLO

## Technologies

- Python
- YOLO Ultralytics
- OpenCV
- Jupyter Notebook

## Folder

```bash
01-ai-training/
```

## Main Files

```bash
train.ipynb
inference.py
runs/train/yolo11_fruits/weights/best.pt
```

## Dataset

Dataset yang digunakan:

```bash
https://www.kaggle.com/datasets/kapturovalexander/fruits-by-yolo-fruits-detection
```

## Run Project

Detail README project AI Training tersedia pada folder:

```bash
01-ai-training/README.md
```

---

# 2. IoT & Embedded Systems - Camera Control

Implementasi aplikasi Camera Control menggunakan OpenCV dan V4L2 untuk mengakses, menampilkan, dan mengontrol webcam/kamera sesuai requirement technical test.

## Features

- Live Preview kamera realtime
- Multiple Camera Support
- Capture Image & Burst Capture
- GUI menggunakan CustomTkinter
- Cross-platform support:
  - Windows untuk preview dan development
  - Linux dengan kontrol kamera penuh menggunakan V4L2
- Dynamic camera control detection pada Linux
- Auto manual exposure & autofocus handling
- Kontrol kamera:
  - Brightness
  - Exposure / Shutter
  - ISO / Gain
- Pengaturan resolusi kamera
- Auto save hasil capture
- Windows mode dengan camera control disabled

## Technologies

- Python
- OpenCV
- CustomTkinter
- Pillow
- Video4Linux (V4L2)

## Folder

```bash
02-iot-camera/
```

## Main Files

```bash
run.py
app/ui.py
app/camera.py
app/v4l2_control.py
```

## Key Mapping

| Key | Function |
|---|---|
| C | Capture Image |
| B | Burst Capture |
| Q | Quit Application |

## Run Project

Detail README project IoT Camera tersedia pada folder:

```bash
02-iot-camera/README.md
```

---

# 3. CodeIgniter CMS - Product Purchase System

Implementasi CMS sederhana menggunakan CodeIgniter 4 untuk simulasi proses pembelian produk sesuai requirement technical test Wrap Station Group.

Sistem mengimplementasikan:
- CRUD Produk
- Shopping Cart
- Checkout
- Payment Simulation
- Inventory Management

## Features

- Product CRUD
- Dashboard Admin
- Upload gambar produk
- Shopping Cart System
- Checkout System
- Payment Simulation
- Product Inventory Management
- Database Migration & Seeder
- Responsive UI menggunakan Tailwind CSS

## Technologies

- PHP 8+
- CodeIgniter 4
- MySQL
- Tailwind CSS
- phpMyAdmin

## Folder

```bash
03-codeigniter-cms/
```

## Main Features

### Admin
- Menambahkan produk
- Mengedit produk
- Menghapus produk
- Upload gambar produk
- Inventory Management

### User
- Melihat daftar produk
- Menambahkan produk ke cart
- Checkout produk
- Simulasi pembayaran
- Melihat history transaksi

## Run Project

```bash
cd 03-codeigniter-cms

composer install
npm install

php spark migrate
php spark db:seed DatabaseSeeder

php spark serve
npm run dev
```

Akses project:

```bash
http://localhost:8080
```

Detail README project CMS tersedia pada folder:

```bash
03-codeigniter-cms/README.md
```

---

# Notes

- Seluruh project menggunakan localhost environment.
- Authentication dan authorization tidak diimplementasikan sesuai requirement technical test.
- Struktur project dipisahkan menjadi 3 folder utama sesuai soal technical test.
- Semua source code, migration, dan assets sudah disertakan.



