# SISTEM MANAJEMEN KEDAI JUS 🍹

Sistem manajemen lengkap untuk kedai jus yang mencakup manajemen bahan baku, produk, stok, penjualan, dan laporan.

## 🎯 Fitur Utama

### 1. **Master Data**
- ✅ Manajemen Supplier
- ✅ Manajemen Bahan Baku
- ✅ Manajemen Produk Jus
- ✅ Manajemen Resep Jus

### 2. **Manajemen Stok**
- ✅ Input Stok Masuk (Pembelian)
- ✅ Pengurangan Stok Otomatis (Penjualan)
- ✅ Notifikasi Stok Menipis
- ✅ Peringatan Bahan Mendekati Expired

### 3. **Manajemen Penjualan**
- ✅ Input Transaksi Penjualan
- ✅ Sistem Keranjang Belanja
- ✅ Multiple Payment Methods (Cash, Transfer, QRIS, Debit)
- ✅ Invoice / Struk Digital

### 4. **Laporan & Analisis**
- ✅ Laporan Penjualan (Harian/Bulanan)
- ✅ Laporan Pembelian Bahan Baku
- ✅ Laporan Stok Terkini
- ✅ Produk Terlaris
- ✅ Grafik Penjualan

### 5. **Notifikasi & Pengingat**
- ✅ Notifikasi Stok Menipis
- ✅ Notifikasi Bahan Expired
- ✅ Pengingat Input Bahan
- ✅ Dashboard Alerts

### 6. **User Management**
- ✅ Role-Based Access Control (Admin, Owner, Karyawan)
- ✅ Login & Registration
- ✅ User Profile Management
- ✅ Approval System untuk Registrasi

### 7. **Dashboard Interaktif**
- ✅ Statistik Real-time
- ✅ Grafik Penjualan
- ✅ Quick Alerts
- ✅ Recent Transactions

## 🛠️ Teknologi

- **Framework:** CodeIgniter 3
- **Database:** MySQL 5.7+
- **Frontend:** HTML5, CSS3, JavaScript
- **Chart:** Chart.js
- **Icons:** Font Awesome 6
- **DataTables:** jQuery DataTables

## 📋 Persyaratan Sistem

- PHP 7.2 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Apache/Nginx Web Server
- PHP Extensions:
  - mysqli
  - mbstring
  - json
  - session

## 🚀 Instalasi

### 1. Clone/Download Project

```bash
git clone https://github.com/yourusername/kedai-jus.git
cd kedai-jus
```

Atau extract file ZIP ke folder `htdocs/jusbaru` (untuk XAMPP) atau `www/jusbaru` (untuk Laragon).

### 2. Import Database

1. Buka phpMyAdmin
2. Buat database baru dengan nama `kedai_jus`
3. Import file `database/kedai_jus.sql`
4. Database akan otomatis terisi dengan:
   - Struktur tabel lengkap
   - Views untuk laporan
   - Triggers untuk automasi
   - Stored Procedures
   - Data sample (users, supplier, bahan baku, produk)

### 3. Konfigurasi Database

Edit file `application/config/database.php`:

```php
'hostname' => 'localhost',
'username' => 'root',        // Sesuaikan dengan username MySQL Anda
'password' => '',            // Sesuaikan dengan password MySQL Anda
'database' => 'kedai_jus',
```

### 4. Konfigurasi Base URL

Edit file `application/config/config.php`:

```php
$config['base_url'] = 'http://localhost/jusbaru/';
// Sesuaikan dengan URL project Anda
```

### 5. Pastikan File/Folder Permission (Linux/Mac)

```bash
chmod -R 755 application/cache
chmod -R 755 application/logs
chmod -R 755 assets
```

### 6. Jalankan Aplikasi

Buka browser dan akses:
```
http://localhost/jusbaru/
```

## 👤 Default User Accounts

Sistem sudah dilengkapi dengan 3 akun default:

### Admin
- Email: `admin@kedaijus.com`
- Password: `password`
- Akses: Full access ke semua fitur

### Owner
- Email: `owner@kedaijus.com`
- Password: `password`
- Akses: Semua fitur kecuali pengaturan sistem

### Karyawan
- Email: `karyawan@kedaijus.com`
- Password: `password`
- Akses: Penjualan dan laporan (terbatas)

## 📂 Struktur Project

```
jusbaru/
├── application/
│   ├── controllers/      # Controllers
│   │   ├── Auth.php
│   │   ├── Dashboard.php
│   │   ├── Supplier.php
│   │   ├── Bahan_baku.php
│   │   ├── Produk_jus.php
│   │   ├── Stok_masuk.php
│   │   ├── Penjualan.php
│   │   ├── Laporan.php
│   │   ├── Notifikasi.php
│   │   └── Users.php
│   ├── models/           # Models
│   │   ├── User_model.php
│   │   ├── Supplier_model.php
│   │   ├── Bahan_baku_model.php
│   │   ├── Produk_jus_model.php
│   │   ├── Resep_jus_model.php
│   │   ├── Stok_masuk_model.php
│   │   ├── Penjualan_model.php
│   │   ├── Detail_penjualan_model.php
│   │   └── Notifikasi_model.php
│   ├── views/            # Views
│   │   ├── templates/    # Header, Sidebar, Footer
│   │   ├── auth/         # Login, Register
│   │   ├── dashboard/
│   │   ├── supplier/
│   │   └── ...
│   ├── core/
│   │   └── MY_Controller.php  # Base Controllers
│   └── config/           # Konfigurasi
├── assets/
│   ├── css/
│   │   └── style.css     # Custom CSS
│   └── js/
│       └── script.js     # Custom JavaScript
├── database/
│   └── kedai_jus.sql     # Database Schema
└── index.php
```

## 🎨 Fitur Highlights

### Automasi Stok
- Stok bahan baku **otomatis bertambah** saat input stok masuk
- Stok bahan baku **otomatis berkurang** saat penjualan (berdasarkan resep)
- Sistem trigger database memastikan konsistensi data

### Notifikasi Cerdas
- Auto-generate notifikasi stok menipis (berdasarkan stok minimum)
- Auto-generate notifikasi bahan expired (H-3)
- Notifikasi muncul saat login

### Role-Based Access
- **Admin**: Full access semua fitur
- **Owner**: Akses semua fitur kecuali system settings
- **Karyawan**: Akses terbatas (penjualan dan laporan)

### Laporan Lengkap
- Laporan penjualan dengan filter tanggal
- Laporan pembelian bahan baku
- Laporan stok real-time
- Produk terlaris
- Grafik penjualan interaktif

## 🔐 Keamanan

- ✅ Password hashing dengan `bcrypt`
- ✅ Session management
- ✅ CSRF protection (optional, dapat diaktifkan)
- ✅ XSS filtering
- ✅ SQL injection prevention (Query Builder)
- ✅ Role-based access control

## 📊 Database Design

### Fitur Database
- **Views**: Untuk laporan yang kompleks
- **Triggers**: Automasi stok dan notifikasi
- **Stored Procedures**: Generate notifikasi berkala
- **Foreign Keys**: Menjaga integritas data
- **Indexes**: Optimasi query

### Relasi Utama
```
users ─┬─> stok_masuk.created_by
       └─> penjualan.user_id

supplier ─┬─> bahan_baku.supplier_id
          └─> stok_masuk.supplier_id

bahan_baku ─┬─> resep_jus.bahan_id
            └─> stok_masuk.bahan_id

produk_jus ─┬─> resep_jus.produk_id
            └─> detail_penjualan.produk_id

penjualan ──> detail_penjualan.penjualan_id
```

## 🐛 Troubleshooting

### Error: "A PHP Error was encountered"
- Pastikan PHP version >= 7.2
- Cek log di `application/logs/`

### Database Connection Error
- Cek konfigurasi database di `application/config/database.php`
- Pastikan MySQL service running
- Pastikan database `kedai_jus` sudah dibuat dan diimport

### CSS/JS Not Loading
- Cek `base_url` di `application/config/config.php`
- Pastikan folder `assets/` bisa diakses

### Session Error
- Pastikan `sess_save_path` sudah di-set dengan benar
- Cek permission folder temporary

## 📝 TODO / Future Enhancements

- [ ] WhatsApp API Integration untuk notifikasi
- [ ] Export laporan ke Excel/PDF
- [ ] FIFO/FEFO Stock Management
- [ ] Point of Sale (POS) System
- [ ] Customer Management
- [ ] Loyalty Program
- [ ] Multi-branch Support
- [ ] Mobile App Integration

## 👨‍💻 Development

Untuk development:

1. Set environment ke development di `index.php`:
```php
define('ENVIRONMENT', 'development');
```

2. Enable database debug di `application/config/database.php`:
```php
'db_debug' => TRUE,
```

3. Enable error logging di `application/config/config.php`:
```php
$config['log_threshold'] = 4;
```

## 📄 License

This project is open source and available under the [MIT License](LICENSE).

## 🤝 Contributing

Contributions, issues, and feature requests are welcome!

## 📧 Contact

Untuk pertanyaan atau support, silakan hubungi:
- Email: support@kedaijus.com
- Website: https://kedaijus.com

---

**Happy Coding! 🍹**

Dibuat dengan ❤️ untuk mempermudah manajemen Kedai Jus

