# noÖmmies - Sistem Inventory Management Kedai Jus Buah

## Deskripsi
Sistem inventory management untuk kedai jus buah yang dibangun dengan CodeIgniter 3. Sistem ini mencakup manajemen bahan baku, produk jus, penjualan, laporan, dan waste management.

## Fitur Utama

### 🔐 Authentication & Authorization
- Login/Register dengan role-based access control
- 3 Level user: Admin, Owner, Karyawan
- Session management yang aman

### 📊 Dashboard
- Statistik real-time
- Grafik penjualan
- Notifikasi sistem
- Quick access ke fitur utama

### 🛒 Master Data
- **Produk Jus**: Manajemen produk jus dengan kategori dan harga
- **Bahan Baku**: Manajemen bahan baku dengan stok dan supplier
- **Supplier**: Data supplier bahan baku
- **Users**: Manajemen pengguna sistem

### 💰 Transaksi
- **Penjualan**: Input penjualan dengan detail produk
- **Stok Masuk**: Input stok masuk bahan baku
- **Waste Management**: Manajemen waste/sampah

### 📈 Laporan
- **Laporan Penjualan**: Laporan penjualan dengan filter tanggal
- **Laporan Stok**: Laporan stok dengan status alert
- **Laporan Pembelian**: Laporan pembelian bahan baku
- **Laporan Waste**: Laporan waste management

### 🔔 Monitoring
- **Stok Menipis**: Alert bahan baku dengan stok menipis
- **Mendekati Expired**: Alert bahan baku yang akan expired
- **Notifikasi**: Sistem notifikasi real-time

## Teknologi yang Digunakan

- **Backend**: PHP 7.4+ dengan CodeIgniter 3
- **Database**: MySQL 5.7+ / MariaDB 10.2+
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 4
- **Icons**: Font Awesome 6
- **Charts**: Chart.js
- **Tables**: DataTables

## Instalasi

### Prerequisites
- PHP 7.4 atau lebih baru
- MySQL 5.7+ atau MariaDB 10.2+
- Web server (Apache/Nginx)
- XAMPP/WAMP/LAMP (recommended)

### Setup Database

1. **Clone repository:**
   ```bash
   git clone https://github.com/niviayuu/noOmmies.git
   cd noOmmies
   ```

2. **Setup database:**
   ```bash
   cd database/db
   mysql -u root -p < kedai_jus_complete.sql
   ```

3. **Konfigurasi database:**
   Edit `application/config/database.php`:
   ```php
   $db['default']['hostname'] = 'localhost';
   $db['default']['username'] = 'root';
   $db['default']['password'] = 'your_password';
   $db['default']['database'] = 'kedai_jus';
   ```

4. **Akses aplikasi:**
   - URL: `http://localhost/noOmmies/`
   - Login: `admin@kedaijus.com`
   - Password: `password`

## Login Default

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@kedaijus.com | password |
| Owner | owner@kedaijus.com | password |
| Karyawan | karyawan@kedaijus.com | password |

## Struktur Database

### Tabel Utama
- `users` - Data pengguna sistem
- `supplier` - Data supplier bahan baku
- `bahan_baku` - Data bahan baku
- `produk_jus` - Data produk jus
- `resep_jus` - Resep pembuatan jus
- `stok_masuk` - Data stok masuk
- `penjualan` - Data penjualan
- `detail_penjualan` - Detail penjualan
- `notifikasi` - Notifikasi sistem
- `waste_records` - Data waste management

### Fitur Database
- **Triggers**: Auto-update stok setelah transaksi
- **Views**: View untuk laporan
- **Stored Procedures**: Procedure untuk query khusus
- **Foreign Keys**: Relasi antar tabel

## Role & Permission

### Admin
- Full access ke semua fitur
- Manajemen user
- Konfigurasi sistem

### Owner
- Full access ke semua fitur kecuali manajemen user
- Laporan lengkap
- Waste management

### Karyawan
- Read-only access ke master data
- Input penjualan
- Lihat laporan penjualan dan stok
- Monitoring stok menipis dan expired

## Screenshots

### Dashboard
- Statistik real-time
- Grafik penjualan
- Quick access menu

### Login Page
- Modern design dengan gradient background
- Responsive layout
- Form validation

### Master Data
- CRUD operations
- Data tables dengan search dan filter
- Role-based access control

## Contributing

1. Fork repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## License

Distributed under the MIT License. See `LICENSE` for more information.

## Contact

- **Developer**: Nivia Ayu Andini
- **Email**: nivia@example.com
- **GitHub**: [@niviayuu](https://github.com/niviayuu)

## Acknowledgments

- CodeIgniter Framework
- Bootstrap CSS Framework
- Font Awesome Icons
- Chart.js Library
- DataTables Plugin

---

**noÖmmies** - Sistem Inventory Management Kedai Jus Buah 🍊🥤