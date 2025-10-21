# 📥 PANDUAN INSTALASI LENGKAP
## Sistem Manajemen Kedai Jus

---

## 📋 Persyaratan

### Software yang Dibutuhkan:
1. **XAMPP** (Windows/Mac/Linux) atau **Laragon** (Windows)
   - Download: https://www.apachefriends.org/
   - Atau Laragon: https://laragon.org/

2. **Web Browser** (Chrome, Firefox, Edge, dll)

3. **Text Editor** (opsional, untuk edit konfigurasi)
   - VS Code, Sublime Text, Notepad++, dll

---

## 🚀 INSTALASI STEP-BY-STEP

### LANGKAH 1: Install XAMPP

1. Download XAMPP dari website resmi
2. Install XAMPP (pilih Apache dan MySQL)
3. Jalankan XAMPP Control Panel
4. Start Apache dan MySQL

### LANGKAH 2: Extract Project

1. Extract file project ke folder:
   - **Windows (XAMPP)**: `C:\xampp\htdocs\jusbaru`
   - **Mac (XAMPP)**: `/Applications/XAMPP/htdocs/jusbaru`
   - **Windows (Laragon)**: `C:\laragon\www\jusbaru`

2. Pastikan struktur folder seperti ini:
   ```
   htdocs/
   └── jusbaru/
       ├── application/
       ├── assets/
       ├── database/
       ├── system/
       ├── index.php
       └── README.md
   ```

### LANGKAH 3: Buat Database

#### Cara 1: Menggunakan phpMyAdmin

1. Buka browser, akses: `http://localhost/phpmyadmin`
2. Klik tab **"New"** atau **"Database"**
3. Nama database: `kedai_jus`
4. Collation: `utf8mb4_general_ci`
5. Klik **"Create"**

#### Cara 2: Menggunakan MySQL Command Line

```sql
CREATE DATABASE kedai_jus CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
```

### LANGKAH 4: Import Database

1. Di phpMyAdmin, pilih database `kedai_jus`
2. Klik tab **"Import"**
3. Klik **"Choose File"** atau **"Browse"**
4. Pilih file: `jusbaru/database/kedai_jus.sql`
5. Scroll ke bawah, klik **"Go"** atau **"Import"**
6. Tunggu sampai muncul pesan sukses

**✅ Yang Ter-import:**
- 9 Tabel (users, supplier, bahan_baku, dll)
- 4 Views (laporan)
- 4 Triggers (automasi)
- 2 Stored Procedures
- Data sample (users, supplier, bahan baku, produk)

### LANGKAH 5: Konfigurasi Database

1. Buka file: `jusbaru/application/config/database.php`
2. Edit bagian berikut:

```php
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'root',        // Username MySQL Anda
    'password' => '',            // Password MySQL (kosong untuk default XAMPP)
    'database' => 'kedai_jus',
);
```

**Catatan:**
- Default XAMPP: username=`root`, password=``(kosong)
- Laragon: username=`root`, password=``(kosong)
- Jika password berbeda, sesuaikan

### LANGKAH 6: Konfigurasi Base URL

1. Buka file: `jusbaru/application/config/config.php`
2. Cari baris `$config['base_url']`
3. Edit sesuai URL Anda:

```php
$config['base_url'] = 'http://localhost/jusbaru/';
```

**Sesuaikan dengan:**
- XAMPP: `http://localhost/jusbaru/`
- Laragon: `http://jusbaru.test/` (jika menggunakan virtual host)
- Custom port: `http://localhost:8080/jusbaru/`

### LANGKAH 7: Set Permission (Linux/Mac Only)

Untuk Linux atau Mac, jalankan di terminal:

```bash
cd /path/to/jusbaru
chmod -R 755 application/cache
chmod -R 755 application/logs
chmod -R 755 assets
```

Windows tidak memerlukan langkah ini.

### LANGKAH 8: Jalankan Aplikasi

1. Pastikan Apache dan MySQL di XAMPP sudah running
2. Buka browser
3. Akses: `http://localhost/jusbaru/`
4. Anda akan diarahkan ke halaman login

---

## 🔐 LOGIN PERTAMA KALI

Gunakan salah satu akun default:

### 👨‍💼 Admin (Full Access)
- **Email**: `admin@kedaijus.com`
- **Password**: `password`

### 👔 Owner
- **Email**: `owner@kedaijus.com`
- **Password**: `password`

### 👤 Karyawan
- **Email**: `karyawan@kedaijus.com`
- **Password**: `password`

**⚠️ PENTING:** Ganti password setelah login pertama!

---

## ✅ VERIFIKASI INSTALASI

Setelah login, cek hal berikut:

1. **Dashboard**: Statistik muncul dengan benar
2. **Master Data**: Buka menu Supplier, Bahan Baku, Produk Jus
3. **Notifikasi**: Cek apakah ada notifikasi muncul
4. **Database**: Cek apakah data sample terlihat

---

## 🐛 TROUBLESHOOTING

### Problem 1: Blank Page / Error 500

**Solusi:**
1. Cek `application/logs/` untuk error log
2. Pastikan PHP version >= 7.2
3. Edit `index.php`, ubah:
   ```php
   define('ENVIRONMENT', 'development');
   ```

### Problem 2: Database Connection Error

**Solusi:**
1. Cek apakah MySQL running di XAMPP
2. Cek username/password di `config/database.php`
3. Cek apakah database `kedai_jus` sudah dibuat
4. Test koneksi manual dengan phpMyAdmin

### Problem 3: CSS/JS Tidak Load

**Solusi:**
1. Cek `base_url` di `config/config.php`
2. Pastikan folder `assets/` ada
3. Clear browser cache (Ctrl+F5)
4. Cek console browser untuk error

### Problem 4: Session Error

**Solusi:**
1. Buka `config/config.php`
2. Pastikan:
   ```php
   $config['sess_save_path'] = sys_get_temp_dir();
   ```
3. Atau ganti dengan path absolute:
   ```php
   $config['sess_save_path'] = APPPATH . 'cache/sessions';
   ```
4. Buat folder `application/cache/sessions` jika belum ada

### Problem 5: 404 Page Not Found

**Solusi:**
1. Pastikan ada file `.htaccess` di root project
2. Aktifkan `mod_rewrite` di Apache:
   - Buka `httpd.conf`
   - Uncomment: `LoadModule rewrite_module modules/mod_rewrite.so`
   - Restart Apache
3. Atau ubah `config.php`:
   ```php
   $config['index_page'] = 'index.php';
   ```

### Problem 6: Trigger/Stored Procedure Error

**Solusi:**
1. Pastikan MySQL version >= 5.7
2. Import ulang database
3. Cek privileges user MySQL:
   ```sql
   GRANT ALL PRIVILEGES ON kedai_jus.* TO 'root'@'localhost';
   FLUSH PRIVILEGES;
   ```

---

## 🔧 KONFIGURASI LANJUTAN

### Enable Error Reporting (Development)

Edit `index.php`:
```php
define('ENVIRONMENT', 'development');
```

Edit `config/config.php`:
```php
$config['log_threshold'] = 4; // Log semua error
```

### Enable Database Debug

Edit `config/database.php`:
```php
'db_debug' => TRUE,
```

### Enable CSRF Protection (Recommended)

Edit `config/config.php`:
```php
$config['csrf_protection'] = TRUE;
```

### Custom Session Path

Buat folder baru:
```bash
mkdir application/cache/sessions
chmod 755 application/cache/sessions
```

Edit `config/config.php`:
```php
$config['sess_save_path'] = APPPATH . 'cache/sessions';
```

---

## 📚 TESTING FITUR

### 1. Test Input Stok Masuk
1. Login sebagai Admin/Owner
2. Menu **Stok Masuk** → **Tambah Stok Masuk**
3. Pilih bahan, supplier, jumlah
4. Submit
5. Cek apakah stok bahan bertambah

### 2. Test Penjualan
1. Menu **Penjualan** → **Tambah Penjualan**
2. Pilih produk, tambah ke keranjang
3. Isi form transaksi
4. Submit
5. Cek:
   - Stok bahan berkurang otomatis
   - Invoice dapat dicetak

### 3. Test Notifikasi
1. Set stok bahan < stok_minimum
2. Reload dashboard
3. Cek apakah muncul notifikasi

### 4. Test Laporan
1. Menu **Laporan** → **Lap. Penjualan**
2. Filter tanggal
3. Lihat data dan grafik

---

## 🔄 UPDATE APLIKASI

Jika ada update:

1. Backup database:
   ```bash
   mysqldump -u root -p kedai_jus > backup.sql
   ```

2. Backup folder project

3. Replace file baru

4. Import update database (jika ada)

---

## 📞 BANTUAN

Jika masih ada masalah:

1. Baca `README.md`
2. Cek `application/logs/` untuk error
3. Cek browser console (F12)
4. Tanya di forum/support

---

## 🎉 SELESAI!

Jika semua langkah diikuti dengan benar, aplikasi sudah siap digunakan!

**Selamat menggunakan Sistem Manajemen Kedai Jus! 🍹**

