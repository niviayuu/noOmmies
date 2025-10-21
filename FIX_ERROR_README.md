# 🔧 PERBAIKAN ERROR: Unknown column 'no_hp'

## ❗ Masalah
```
Error Number: 1054
Unknown column 'no_hp' in 'field list'
```

Error ini terjadi karena tabel `users` di database Anda tidak memiliki kolom `no_hp`.

---

## ✅ SOLUSI (Pilih salah satu)

### **SOLUSI 1: ALTER TABLE (RECOMMENDED)** ⭐

Jalankan query SQL berikut di phpMyAdmin:

1. Buka **phpMyAdmin** → pilih database `kedai_jus`
2. Klik tab **SQL**
3. Copy-paste query ini:

```sql
ALTER TABLE `users` 
ADD COLUMN `no_hp` VARCHAR(15) NULL AFTER `role`;
```

4. Klik **Go/Jalankan**
5. ✅ Selesai! Coba registrasi lagi.

---

### **SOLUSI 2: Import File SQL**

1. Buka **phpMyAdmin** → database `kedai_jus`
2. Klik tab **Import**
3. Pilih file: `database/UPDATE_USERS_TABLE.sql`
4. Klik **Go**
5. ✅ Selesai!

---

### **SOLUSI 3: Drop & Import Ulang Database** (Jika data masih sample)

⚠️ **PERHATIAN:** Ini akan menghapus semua data di database!

1. Di phpMyAdmin, pilih database `kedai_jus`
2. Klik tab **Operations**
3. Scroll ke bawah, klik **Drop the database**
4. Konfirmasi
5. Buat database baru: `kedai_jus`
6. Import ulang file: `database/kedai_jus.sql`
7. ✅ Selesai!

---

## 🔍 VERIFIKASI

Setelah menjalankan salah satu solusi di atas, verifikasi dengan:

```sql
DESCRIBE users;
```

Anda harus melihat kolom `no_hp` di daftar kolom:

```
+---------------+----------------------------------+------+-----+---------+
| Field         | Type                             | Null | Key | Default |
+---------------+----------------------------------+------+-----+---------+
| id            | int                              | NO   | PRI | NULL    |
| nama_lengkap  | varchar(100)                     | NO   |     | NULL    |
| email         | varchar(100)                     | NO   | UNI | NULL    |
| password      | varchar(255)                     | NO   |     | NULL    |
| role          | enum('admin','owner','karyawan') | NO   |     | ...     |
| no_hp         | varchar(15)                      | YES  |     | NULL    | ✅
| status        | enum('active','inactive')        | YES  |     | active  |
| created_at    | timestamp                        | YES  |     | ...     |
| updated_at    | timestamp                        | YES  |     | ...     |
+---------------+----------------------------------+------+-----+---------+
```

---

## 🎯 TEST REGISTRASI

Setelah perbaikan, coba registrasi lagi:

1. Buka: `http://localhost/jusbaru/auth/register`
2. Isi form:
   - Nama: Nivia Ayu
   - Email: nivia25@gmail.com
   - No HP: 081298119743
   - Password: (password Anda)
   - Konfirmasi Password: (sama)
3. Klik **DAFTAR**
4. ✅ Harus berhasil!

---

## 💡 PENJELASAN

File `database/kedai_jus.sql` yang baru sudah include kolom `no_hp`, tapi jika Anda sudah import versi lama sebelumnya, database Anda tidak memiliki kolom ini.

Struktur tabel `users` yang benar:

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'owner', 'karyawan') NOT NULL DEFAULT 'karyawan',
    no_hp VARCHAR(15),                    -- 👈 KOLOM INI HARUS ADA
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

---

## 🆘 Masih Error?

Jika masih error setelah menjalankan solusi di atas:

1. **Clear cache browser** (Ctrl + F5)
2. **Logout & Login** lagi
3. **Cek kembali** struktur tabel dengan `DESCRIBE users;`
4. **Screenshot error** dan struktur tabel untuk debugging

---

**Selamat mencoba! 🍹**

