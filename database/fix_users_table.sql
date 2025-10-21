-- ============================================================
-- FIX: Tambah kolom no_hp ke tabel users
-- ============================================================

USE kedai_jus;

-- Tambah kolom no_hp jika belum ada
ALTER TABLE `users` 
ADD COLUMN `no_hp` VARCHAR(15) NULL AFTER `role`;

-- Verifikasi struktur tabel
DESCRIBE users;

