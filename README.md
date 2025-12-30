# 🏥 Aplikasi Apotek - Laravel

Aplikasi manajemen apotek lengkap dengan fitur CRUD obat, transaksi, laporan, dan REST API.

## ✨ Fitur Utama

### 📊 Manajemen Obat
- ✅ CRUD data obat lengkap
- ✅ Manajemen stok otomatis
- ✅ Status stok (Aman/Hati-hati/Kritis)
- ✅ Export data ke PDF

### 💰 Transaksi Penjualan
- ✅ Transaksi real-time
- ✅ Cetak struk otomatis
- ✅ Perhitungan otomatis
- ✅ Update stok otomatis

### 📈 Laporan
- ✅ Laporan stok obat
- ✅ Laporan penjualan
- ✅ Analisis penjualan
- ✅ Export PDF

### 🗺️ Manajemen Distributor
- ✅ CRUD distributor
- ✅ Maps lokasi distributor
- ✅ Koordinat GPS

### 📱 REST API
- ✅ API untuk mobile app
- ✅ Pemesanan obat via API
- ✅ Cek stok via API
- ✅ Dokumentasi API lengkap

## 🛠️ Teknologi

- **Backend:** Laravel 9/10
- **Frontend:** Bootstrap 5, jQuery
- **Database:** MySQL
- **PDF:** DomPDF
- **Maps:** Leaflet.js
- **API:** RESTful JSON

## 🚀 Instalasi

### Prerequisites
- PHP 8.0+
- Composer
- MySQL
- Node.js (opsional)

### Langkah Instalasi
```bash
# 1. Clone repository
git clone https://github.com/username/apotek-app.git
cd apotek-app

# 2. Install dependencies
composer install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database di .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=apotek_db
DB_USERNAME=root
DB_PASSWORD=

# 5. Migrasi database
php artisan migrate --seed

# 6. Install DomPDF
composer require barryvdh/laravel-dompdf

# 7. Jalankan server
php artisan serve
