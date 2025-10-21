-- ========================================
-- DATABASE KEDAI JUS - COMPLETE SETUP
-- ========================================
-- Script lengkap untuk membuat database dan semua tabel
-- Jalankan dengan: mysql -u root -p < kedai_jus_complete.sql

-- Buat database kedai_jus
CREATE DATABASE IF NOT EXISTS kedai_jus 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Gunakan database kedai_jus
USE kedai_jus;

-- ========================================
-- TABEL USERS
-- ========================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    no_hp VARCHAR(20),
    role ENUM('admin', 'owner', 'karyawan') DEFAULT 'karyawan',
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ========================================
-- TABEL SUPPLIER
-- ========================================
CREATE TABLE IF NOT EXISTS supplier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_supplier VARCHAR(100) NOT NULL,
    alamat TEXT,
    no_telepon VARCHAR(20),
    email VARCHAR(100),
    kontak_person VARCHAR(100),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ========================================
-- TABEL BAHAN BAKU
-- ========================================
CREATE TABLE IF NOT EXISTS bahan_baku (
    id INT AUTO_INCREMENT PRIMARY KEY,
    supplier_id INT,
    nama_bahan VARCHAR(100) NOT NULL,
    satuan VARCHAR(20) NOT NULL,
    stok DECIMAL(10,2) DEFAULT 0,
    stok_minimum DECIMAL(10,2) DEFAULT 0,
    harga_satuan DECIMAL(10,2) DEFAULT 0,
    tanggal_expired DATE,
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (supplier_id) REFERENCES supplier(id) ON DELETE SET NULL
);

-- ========================================
-- TABEL PRODUK JUS
-- ========================================
CREATE TABLE IF NOT EXISTS produk_jus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_produk VARCHAR(100) NOT NULL,
    kategori VARCHAR(50),
    ukuran VARCHAR(20),
    harga DECIMAL(10,2) NOT NULL,
    deskripsi TEXT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ========================================
-- TABEL RESEP JUS
-- ========================================
CREATE TABLE IF NOT EXISTS resep_jus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produk_id INT NOT NULL,
    bahan_id INT NOT NULL,
    jumlah DECIMAL(10,2) NOT NULL,
    satuan VARCHAR(20) NOT NULL,
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (produk_id) REFERENCES produk_jus(id) ON DELETE CASCADE,
    FOREIGN KEY (bahan_id) REFERENCES bahan_baku(id) ON DELETE CASCADE
);

-- ========================================
-- TABEL STOK MASUK
-- ========================================
CREATE TABLE IF NOT EXISTS stok_masuk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bahan_id INT NOT NULL,
    supplier_id INT,
    jumlah DECIMAL(10,2) NOT NULL,
    harga_satuan DECIMAL(10,2) NOT NULL,
    total_harga DECIMAL(10,2) NOT NULL,
    tanggal_masuk DATE NOT NULL,
    tanggal_expired DATE,
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (bahan_id) REFERENCES bahan_baku(id) ON DELETE CASCADE,
    FOREIGN KEY (supplier_id) REFERENCES supplier(id) ON DELETE SET NULL
);

-- ========================================
-- TABEL PENJUALAN
-- ========================================
CREATE TABLE IF NOT EXISTS penjualan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    tanggal_penjualan DATE NOT NULL,
    total_harga DECIMAL(10,2) NOT NULL,
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ========================================
-- TABEL DETAIL PENJUALAN
-- ========================================
CREATE TABLE IF NOT EXISTS detail_penjualan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    penjualan_id INT NOT NULL,
    produk_id INT NOT NULL,
    jumlah INT NOT NULL,
    harga_satuan DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (penjualan_id) REFERENCES penjualan(id) ON DELETE CASCADE,
    FOREIGN KEY (produk_id) REFERENCES produk_jus(id) ON DELETE CASCADE
);

-- ========================================
-- TABEL NOTIFIKASI
-- ========================================
CREATE TABLE IF NOT EXISTS notifikasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    judul VARCHAR(200) NOT NULL,
    pesan TEXT NOT NULL,
    tipe ENUM('info', 'warning', 'error', 'success') DEFAULT 'info',
    status ENUM('read', 'unread') DEFAULT 'unread',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ========================================
-- TABEL WASTE RECORDS
-- ========================================
CREATE TABLE IF NOT EXISTS waste_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_item VARCHAR(100) NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    jumlah DECIMAL(10,2) NOT NULL,
    satuan VARCHAR(20) NOT NULL,
    nilai_waste DECIMAL(10,2) NOT NULL,
    tanggal_waste DATE NOT NULL,
    alasan TEXT,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    disposal_method VARCHAR(100),
    disposal_date DATE,
    disposal_location VARCHAR(200),
    disposal_cost DECIMAL(10,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ========================================
-- INSERT DATA DEFAULT
-- ========================================

-- Insert Users Default
INSERT INTO users (nama_lengkap, email, password, role, status) VALUES
('Administrator', 'admin@kedaijus.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'active'),
('Owner', 'owner@kedaijus.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'owner', 'active'),
('Karyawan', 'karyawan@kedaijus.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'karyawan', 'active');

-- Insert Supplier Default
INSERT INTO supplier (nama_supplier, alamat, no_telepon, email, kontak_person) VALUES
('Toko Buah Segar', 'Jl. Raya No. 123', '081234567890', 'toko@buahsegar.com', 'Budi Santoso'),
('Elok Buah', 'Jl. Merdeka No. 456', '081234567891', 'elok@buah.com', 'Siti Aminah'),
('Fresh Market', 'Jl. Sudirman No. 789', '081234567892', 'fresh@market.com', 'Ahmad Wijaya');

-- Insert Bahan Baku Default
INSERT INTO bahan_baku (supplier_id, nama_bahan, satuan, stok, stok_minimum, harga_satuan) VALUES
(1, 'Buah Jeruk', 'kg', 50.00, 10.00, 15000.00),
(1, 'Buah Apel', 'kg', 30.00, 5.00, 20000.00),
(2, 'Buah Mangga', 'kg', 25.00, 8.00, 18000.00),
(2, 'Buah Sirsak', 'kg', 15.00, 5.00, 12000.00),
(3, 'Gula Pasir', 'kg', 100.00, 20.00, 12000.00),
(3, 'Susu UHT', 'liter', 50.00, 10.00, 15000.00);

-- Insert Produk Jus Default
INSERT INTO produk_jus (nama_produk, kategori, ukuran, harga, deskripsi) VALUES
('Jus Jeruk Segar', 'Jus Buah', 'Medium', 15000.00, 'Jus jeruk segar tanpa pengawet'),
('Jus Apel Manis', 'Jus Buah', 'Large', 20000.00, 'Jus apel dengan rasa manis alami'),
('Jus Mangga Tropis', 'Jus Buah', 'Medium', 18000.00, 'Jus mangga dengan rasa tropis'),
('Jus Sirsak Segar', 'Jus Buah', 'Large', 16000.00, 'Jus sirsak segar dan menyegarkan');

-- Insert Resep Jus Default
INSERT INTO resep_jus (produk_id, bahan_id, jumlah, satuan, keterangan) VALUES
(1, 1, 0.5, 'kg', 'Buah jeruk untuk jus'),
(1, 5, 0.1, 'kg', 'Gula pasir untuk pemanis'),
(1, 6, 0.2, 'liter', 'Susu UHT untuk tekstur'),
(2, 2, 0.3, 'kg', 'Buah apel untuk jus'),
(2, 5, 0.05, 'kg', 'Gula pasir untuk pemanis'),
(3, 3, 0.4, 'kg', 'Buah mangga untuk jus'),
(3, 5, 0.08, 'kg', 'Gula pasir untuk pemanis'),
(4, 4, 0.3, 'kg', 'Buah sirsak untuk jus'),
(4, 5, 0.06, 'kg', 'Gula pasir untuk pemanis');

-- Insert Stok Masuk Default
INSERT INTO stok_masuk (bahan_id, supplier_id, jumlah, harga_satuan, total_harga, tanggal_masuk, tanggal_expired) VALUES
(1, 1, 50.00, 15000.00, 750000.00, '2025-01-01', '2025-01-15'),
(2, 1, 30.00, 20000.00, 600000.00, '2025-01-01', '2025-01-20'),
(3, 2, 25.00, 18000.00, 450000.00, '2025-01-01', '2025-01-18'),
(4, 2, 15.00, 12000.00, 180000.00, '2025-01-01', '2025-01-12'),
(5, 3, 100.00, 12000.00, 1200000.00, '2025-01-01', '2025-12-31'),
(6, 3, 50.00, 15000.00, 750000.00, '2025-01-01', '2025-01-30');

-- Insert Notifikasi Default
INSERT INTO notifikasi (user_id, judul, pesan, tipe, status) VALUES
(1, 'Selamat Datang', 'Selamat datang di sistem inventory management kedai jus!', 'info', 'unread'),
(2, 'Setup Database', 'Database berhasil dibuat dan siap digunakan.', 'success', 'unread'),
(3, 'Data Default', 'Data default telah dimasukkan ke sistem.', 'info', 'unread');

-- ========================================
-- TRIGGER UNTUK UPDATE STOK
-- ========================================
DELIMITER $$

CREATE TRIGGER update_stok_after_stok_masuk
AFTER INSERT ON stok_masuk
FOR EACH ROW
BEGIN
    UPDATE bahan_baku 
    SET stok = stok + NEW.jumlah,
        harga_satuan = NEW.harga_satuan,
        tanggal_expired = NEW.tanggal_expired
    WHERE id = NEW.bahan_id;
END$$

CREATE TRIGGER update_stok_after_penjualan
AFTER INSERT ON detail_penjualan
FOR EACH ROW
BEGIN
    -- Update stok bahan baku berdasarkan resep
    UPDATE bahan_baku bb
    JOIN resep_jus rj ON bb.id = rj.bahan_id
    SET bb.stok = bb.stok - (rj.jumlah * NEW.jumlah)
    WHERE rj.produk_id = NEW.produk_id;
END$$

DELIMITER ;

-- ========================================
-- VIEW UNTUK LAPORAN
-- ========================================

-- View untuk laporan penjualan
CREATE VIEW v_laporan_penjualan AS
SELECT 
    p.id,
    p.tanggal_penjualan,
    u.nama_lengkap as nama_kasir,
    COUNT(dp.id) as total_item,
    p.total_harga
FROM penjualan p
LEFT JOIN users u ON p.user_id = u.id
LEFT JOIN detail_penjualan dp ON p.id = dp.penjualan_id
GROUP BY p.id, p.tanggal_penjualan, u.nama_lengkap, p.total_harga;

-- View untuk laporan stok
CREATE VIEW v_laporan_stok AS
SELECT 
    bb.id,
    bb.nama_bahan,
    bb.stok,
    bb.stok_minimum,
    bb.satuan,
    bb.harga_satuan,
    s.nama_supplier,
    CASE 
        WHEN bb.stok <= bb.stok_minimum THEN 'Stok Menipis'
        WHEN bb.tanggal_expired <= DATE_ADD(CURDATE(), INTERVAL 7 DAY) THEN 'Mendekati Expired'
        ELSE 'Normal'
    END as status_stok
FROM bahan_baku bb
LEFT JOIN supplier s ON bb.supplier_id = s.id;

-- View untuk waste report
CREATE VIEW v_waste_report AS
SELECT 
    wr.id,
    wr.nama_item,
    wr.kategori,
    wr.jumlah,
    wr.satuan,
    wr.nilai_waste,
    wr.tanggal_waste,
    wr.status,
    wr.disposal_method,
    wr.disposal_date,
    wr.disposal_cost
FROM waste_records wr
ORDER BY wr.tanggal_waste DESC;

-- ========================================
-- STORED PROCEDURE
-- ========================================

-- Procedure untuk mendapatkan stok menipis
DELIMITER $$
CREATE PROCEDURE GetLowStock()
BEGIN
    SELECT * FROM bahan_baku 
    WHERE stok <= stok_minimum 
    ORDER BY (stok/stok_minimum) ASC;
END$$

-- Procedure untuk mendapatkan bahan yang mendekati expired
CREATE PROCEDURE GetNearExpiry(IN days INT)
BEGIN
    SELECT *, DATEDIFF(tanggal_expired, CURDATE()) as hari_tersisa
    FROM bahan_baku 
    WHERE tanggal_expired <= DATE_ADD(CURDATE(), INTERVAL days DAY)
    AND tanggal_expired > CURDATE()
    ORDER BY tanggal_expired ASC;
END$$

DELIMITER ;

-- ========================================
-- KONFIRMASI SETUP
-- ========================================
SELECT '========================================' AS '';
SELECT 'DATABASE KEDAI JUS BERHASIL DIBUAT!' AS '';
SELECT '========================================' AS '';
SELECT '' AS '';
SELECT 'Database: kedai_jus' AS '';
SELECT 'Character Set: utf8mb4' AS '';
SELECT 'Collation: utf8mb4_unicode_ci' AS '';
SELECT '' AS '';
SELECT 'Tabel yang dibuat:' AS '';
SELECT '- users (pengguna sistem)' AS '';
SELECT '- supplier (data supplier)' AS '';
SELECT '- bahan_baku (bahan baku)' AS '';
SELECT '- produk_jus (produk jus)' AS '';
SELECT '- resep_jus (resep pembuatan)' AS '';
SELECT '- stok_masuk (stok masuk)' AS '';
SELECT '- penjualan (data penjualan)' AS '';
SELECT '- detail_penjualan (detail penjualan)' AS '';
SELECT '- notifikasi (notifikasi sistem)' AS '';
SELECT '- waste_records (waste management)' AS '';
SELECT '' AS '';
SELECT 'Data default berhasil diinsert!' AS '';
SELECT 'Trigger dan View berhasil dibuat!' AS '';
SELECT 'Stored Procedure berhasil dibuat!' AS '';
SELECT '' AS '';
SELECT 'LOGIN DEFAULT:' AS '';
SELECT 'Email: admin@kedaijus.com' AS '';
SELECT 'Password: password' AS '';
SELECT '' AS '';
SELECT 'Setup database selesai!' AS '';
SELECT '========================================' AS '';
