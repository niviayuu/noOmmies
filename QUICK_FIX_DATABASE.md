# ⚡ QUICK FIX - Database Error

## ❗ Error: Unknown column 'status' in produk_jus

---

## 🚀 SOLUSI TERCEPAT (Copy-Paste)

Buka **phpMyAdmin** → Database `kedai_jus` → Tab **SQL**

Kemudian copy-paste dan jalankan query ini:

```sql
USE kedai_jus;

-- Tambah kolom no_hp di users (jika belum ada)
ALTER TABLE users ADD COLUMN no_hp VARCHAR(15) NULL AFTER role;

-- Tambah kolom status di produk_jus (jika belum ada)
ALTER TABLE produk_jus ADD COLUMN status ENUM('active', 'inactive') DEFAULT 'active' AFTER gambar;

-- Update data existing
UPDATE produk_jus SET status = 'active' WHERE status IS NULL;

-- Verifikasi
DESCRIBE produk_jus;
```

**Note:** Jika ada error "Duplicate column name" untuk salah satu query, **ABAIKAN** (itu artinya kolom sudah ada). Lanjut aja ke query berikutnya.

---

## 📁 ATAU: Import File SQL

1. Di phpMyAdmin → Database `kedai_jus`
2. Tab **Import**
3. Pilih file: `database/ADD_MISSING_COLUMNS.sql`
4. Klik **Go**
5. ✅ Selesai!

---

## ✅ VERIFIKASI

Setelah menjalankan query, cek dengan:

```sql
DESCRIBE produk_jus;
```

Pastikan ada kolom **`status`** dalam daftar:

```
+--------------+----------------------------------------+------+-----+---------+
| Field        | Type                                   | Null | Key | Default |
+--------------+----------------------------------------+------+-----+---------+
| id           | int                                    | NO   | PRI | NULL    |
| nama_produk  | varchar(100)                           | NO   |     | NULL    |
| kategori     | enum('juice','smoothie'...)            | NO   |     | juice   |
| ukuran       | enum('small','medium','large')         | NO   |     | medium  |
| harga        | decimal(12,2)                          | NO   |     | NULL    |
| deskripsi    | text                                   | YES  |     | NULL    |
| gambar       | varchar(255)                           | YES  |     | NULL    |
| status       | enum('active','inactive')              | YES  |     | active  | ✅
| created_at   | timestamp                              | YES  |     | ...     |
| updated_at   | timestamp                              | YES  |     | ...     |
+--------------+----------------------------------------+------+-----+---------+
```

---

## 🔄 REFRESH DASHBOARD

Setelah fix database:

1. **Refresh browser** (F5 atau Ctrl + F5)
2. Akses: `http://localhost/jusbaru/`
3. ✅ Dashboard harus muncul tanpa error!

---

## 🐛 JIKA MASIH ERROR LAIN

Kemungkinan ada kolom lain yang juga hilang. Solusi lengkap:

### OPSI 1: Import Ulang Database (RECOMMENDED)

**⚠️ PERHATIAN: Ini akan menghapus semua data!**

1. Backup data penting (jika ada)
2. Di phpMyAdmin, drop database `kedai_jus`
3. Buat database baru: `kedai_jus`
4. Import file: `database/kedai_jus.sql`
5. ✅ Semua struktur & data sample akan ter-create ulang

### OPSI 2: Fix Manual Satu-Satu

Jika muncul error kolom lain hilang, tambahkan manual:

```sql
-- Template:
ALTER TABLE nama_tabel 
ADD COLUMN nama_kolom TIPE_DATA [OPTIONS] AFTER kolom_sebelumnya;

-- Contoh untuk kolom lain yang mungkin hilang:
ALTER TABLE supplier ADD COLUMN status ENUM('active','inactive') DEFAULT 'active' AFTER keterangan;
ALTER TABLE bahan_baku ADD COLUMN keterangan TEXT NULL AFTER tanggal_expired;
```

---

## 📋 CHECKLIST KOLOM PENTING

Pastikan kolom-kolom ini ada:

**Tabel users:**
- [x] id, nama_lengkap, email, password, role
- [x] **no_hp** ← sering hilang
- [x] status, created_at, updated_at

**Tabel produk_jus:**
- [x] id, nama_produk, kategori, ukuran, harga
- [x] deskripsi, gambar
- [x] **status** ← sering hilang
- [x] created_at, updated_at

**Tabel supplier:**
- [x] id, nama_supplier, alamat, no_hp, email
- [x] keterangan, **status**
- [x] created_at, updated_at

---

## 💡 KENAPA INI TERJADI?

Kemungkinan:
1. Database di-import dari versi lama SQL file
2. Import tidak sempurna
3. Manual create table tanpa semua kolom

**Solusi terbaik:** Import ulang `database/kedai_jus.sql` yang terbaru.

---

## ✅ SELESAI!

Setelah menjalankan fix di atas:

```
http://localhost/jusbaru/
```

Dashboard harus sudah bisa diakses! 🎉

