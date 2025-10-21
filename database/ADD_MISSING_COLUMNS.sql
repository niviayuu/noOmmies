-- ============================================================
-- FIX: Tambah semua kolom yang hilang
-- Jalankan file ini di phpMyAdmin
-- ============================================================

USE kedai_jus;

-- ============================================================
-- 1. Fix tabel users - tambah kolom no_hp
-- ============================================================
SET @exist_no_hp := (
    SELECT COUNT(*) 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = 'kedai_jus' 
    AND TABLE_NAME = 'users' 
    AND COLUMN_NAME = 'no_hp'
);

SET @sql_users := IF(
    @exist_no_hp = 0,
    'ALTER TABLE users ADD COLUMN no_hp VARCHAR(15) NULL AFTER role',
    'SELECT "Kolom no_hp sudah ada di users" as Info'
);

PREPARE stmt FROM @sql_users;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- ============================================================
-- 2. Fix tabel produk_jus - tambah kolom status
-- ============================================================
SET @exist_status_produk := (
    SELECT COUNT(*) 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = 'kedai_jus' 
    AND TABLE_NAME = 'produk_jus' 
    AND COLUMN_NAME = 'status'
);

SET @sql_produk := IF(
    @exist_status_produk = 0,
    'ALTER TABLE produk_jus ADD COLUMN status ENUM(\'active\', \'inactive\') DEFAULT \'active\' AFTER gambar',
    'SELECT "Kolom status sudah ada di produk_jus" as Info'
);

PREPARE stmt FROM @sql_produk;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- ============================================================
-- 3. Verifikasi - Tampilkan struktur tabel
-- ============================================================
SELECT '========================================' as '';
SELECT 'VERIFIKASI STRUKTUR TABEL' as '';
SELECT '========================================' as '';

SELECT 'Tabel: users' as '';
DESCRIBE users;

SELECT '' as '';
SELECT 'Tabel: produk_jus' as '';
DESCRIBE produk_jus;

-- ============================================================
-- 4. Update existing data - set default status
-- ============================================================
UPDATE produk_jus SET status = 'active' WHERE status IS NULL;

-- ============================================================
-- SELESAI
-- ============================================================
SELECT '' as '';
SELECT '========================================' as '';
SELECT '✅ Fix completed!' as STATUS;
SELECT 'Kolom yang ditambahkan:' as '';
SELECT '- users.no_hp' as '';
SELECT '- produk_jus.status' as '';
SELECT '========================================' as '';

