# 🍊 noÖmmies - Sistem Inventory Management Kedai Jus Buah

## 📋 Deskripsi
Sistem inventory management untuk kedai jus buah yang dibangun dengan CodeIgniter 3. Sistem ini mencakup manajemen bahan baku, produk jus, penjualan, laporan, dan waste management.

## 🚀 Quick Start

### Prerequisites
- **PHP**: 7.4 atau lebih baru
- **MySQL**: 5.7+ atau MariaDB 10.2+
- **Web Server**: Apache/Nginx (XAMPP/WAMP/LAMP recommended)

### Installation Steps

1. **Clone Repository**
   ```bash
   git clone https://github.com/your-team/noOmmies.git
   cd noOmmies
   ```

2. **Setup Database**
   ```bash
   # Import database
   mysql -u root -p < database/db/kedai_jus_complete.sql
   ```

3. **Configure Database**
   Edit `application/config/database.php`:
   ```php
   $db['default']['hostname'] = 'localhost';
   $db['default']['username'] = 'root';
   $db['default']['password'] = 'your_password';
   $db['default']['database'] = 'kedai_jus';
   ```

4. **Configure Base URL**
   Edit `application/config/config.php`:
   ```php
   $config['base_url'] = 'http://localhost/noOmmies/';
   ```

5. **Access Application**
   - **URL**: `http://localhost/noOmmies/`
   - **Auto-redirect**: Login page

## 👥 Default Login

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@kedaijus.com | password |
| **Owner** | owner@kedaijus.com | password |
| **Karyawan** | karyawan@kedaijus.com | password |

## 🎯 Fitur Utama

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

## 🛠️ Teknologi

- **Backend**: PHP 7.4+ dengan CodeIgniter 3
- **Database**: MySQL 5.7+ / MariaDB 10.2+
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 4
- **Icons**: Font Awesome 6
- **Charts**: Chart.js
- **Tables**: DataTables

## 🔑 Role & Permission

### 👑 Admin
- Full access ke semua fitur
- Manajemen user
- Konfigurasi sistem

### 👨‍💼 Owner
- Full access ke semua fitur kecuali manajemen user
- Laporan lengkap
- Waste management

### 👷 Karyawan
- Read-only access ke master data
- Input penjualan
- Lihat laporan penjualan dan stok
- Monitoring stok menipis dan expired

## 📁 Struktur Database

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
- `waste_management` - Data waste management
- `waste_categories` - Kategori waste

## 🐛 Troubleshooting

### Common Issues

1. **404 Error**
   - Pastikan base_url di `config.php` sesuai dengan path project
   - Cek .htaccess file ada dan berfungsi

2. **Database Connection Error**
   - Pastikan MySQL/MariaDB running
   - Cek konfigurasi database di `database.php`
   - Pastikan database `kedai_jus` sudah diimport

3. **Permission Error**
   - Pastikan folder `application/cache` dan `application/logs` writable
   - Set permission 755 atau 777 jika diperlukan

## 🔧 Development

### File Structure
```
noOmmies/
├── application/
│   ├── controllers/     # Controllers
│   ├── models/         # Models
│   ├── views/          # Views
│   └── config/         # Configuration
├── assets/
│   ├── css/           # Stylesheets
│   └── js/            # JavaScript
├── database/
│   └── db/            # Database files
└── system/            # CodeIgniter core
```

### Adding New Features
1. Create controller in `application/controllers/`
2. Create model in `application/models/`
3. Create views in `application/views/`
4. Add routes in `application/config/routes.php`

## 📞 Support

- **Developer**: Team noÖmmies
- **Email**: support@noommies.com
- **Documentation**: README.md

## 📄 License

Distributed under the MIT License.

---

**🍊 noÖmmies** - Sistem Inventory Management Kedai Jus Buah