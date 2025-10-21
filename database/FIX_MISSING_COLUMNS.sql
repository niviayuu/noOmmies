-- ============================================================
-- FIX: Tambah kolom yang hilang di database
-- Jalankan SQL ini untuk memperbaiki semua error kolom
-- ============================================================

USE kedai_jus;

-- 1. Fix kolom no_hp di tabel users (jika belum ada)
ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `no_hp` VARCHAR(15) NULL AFTER `role`;

-- Untuk MySQL versi lama yang tidak support IF NOT EXISTS:
-- Jika error "Duplicate column name" muncul, abaikan (skip)
-- ALTER TABLE `users` ADD COLUMN `no_hp` VARCHAR(15) NULL AFTER `role`;

-- 2. Verifikasi struktur tabel
SELECT 'Checking users table...' as '';
DESCRIBE users;

SELECT 'Checking produk_jus table...' as '';
DESCRIBE produk_jus;

SELECT 'Checking bahan_baku table...' as '';
DESCRIBE bahan_baku;

SELECT 'Checking supplier table...' as '';
DESCRIBE supplier;

-- ============================================================
-- SELESAI
-- ============================================================
SELECT '========================================' as '';
SELECT 'Fix completed! Silakan refresh dashboard.' as STATUS;
SELECT '========================================' as '';

