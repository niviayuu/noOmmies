-- ============================================================
-- UPDATE: Perbaikan Tabel Users
-- Jalankan SQL ini untuk memperbaiki error no_hp
-- ============================================================

USE kedai_jus;

-- Cek apakah kolom no_hp sudah ada
-- Jika error "Duplicate column name", berarti kolom sudah ada (SKIP)
-- Jika berhasil, berarti kolom berhasil ditambahkan

ALTER TABLE `users` 
ADD COLUMN `no_hp` VARCHAR(15) NULL AFTER `role`;

-- Verifikasi hasil
SELECT 'Kolom no_hp berhasil ditambahkan!' AS status;
DESCRIBE users;

-- ============================================================
-- Alternatif: Drop & Recreate tabel users (HATI-HATI!)
-- Uncomment jika ingin reset ulang tabel users
-- ============================================================

-- DROP TABLE IF EXISTS users;
-- 
-- CREATE TABLE users (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     nama_lengkap VARCHAR(100) NOT NULL,
--     email VARCHAR(100) NOT NULL UNIQUE,
--     password VARCHAR(255) NOT NULL,
--     role ENUM('admin', 'owner', 'karyawan') NOT NULL DEFAULT 'karyawan',
--     no_hp VARCHAR(15),
--     status ENUM('active', 'inactive') DEFAULT 'active',
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
--     INDEX idx_email (email),
--     INDEX idx_role (role)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- 
-- -- Insert ulang default users
-- INSERT INTO users (nama_lengkap, email, password, role, no_hp, status) VALUES
-- ('Administrator', 'admin@kedaijus.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '081234567890', 'active'),
-- ('Owner Kedai', 'owner@kedaijus.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'owner', '081234567891', 'active'),
-- ('Karyawan 1', 'karyawan@kedaijus.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'karyawan', '081234567892', 'active');

