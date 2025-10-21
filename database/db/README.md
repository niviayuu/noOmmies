# Kedai Jus Database Setup

## Cara Penggunaan

1. Pastikan MySQL/MariaDB sudah terinstall dan berjalan
2. Jalankan script SQL:
   ```bash
   mysql -u root -p < kedai_jus_complete.sql
   ```
3. Masukkan password MySQL root
4. Database `kedai_jus` akan dibuat dengan semua tabel dan data default

## Login Default

- **Email**: admin@kedaijus.com
- **Password**: password

## Yang Dibuat

- Database: `kedai_jus`
- 10 Tabel lengkap dengan relasi
- Data default untuk testing
- Trigger untuk update stok otomatis
- View untuk laporan
- Stored procedure untuk query khusus

## File SQL

- `kedai_jus_complete.sql` - File SQL lengkap untuk setup database
