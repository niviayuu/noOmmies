-- ========================================
-- FIX DATABASE STRUCTURE
-- ========================================
-- Script untuk memperbaiki struktur database yang rusak
-- Jalankan dengan: mysql -u root -p < fix_database_structure.sql

-- Hapus database jika ada
DROP DATABASE IF EXISTS kedai_jus;

-- Buat database baru dengan struktur yang benar
CREATE DATABASE kedai_jus 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Gunakan database kedai_jus
USE kedai_jus;

-- ========================================
-- TABEL USERS
-- ========================================
CREATE TABLE users (
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
CREATE TABLE supplier (
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
CREATE TABLE bahan_baku (
    id INT AUTO_INCREMENT PRIMARY KEY,
    supplier_id INT,
    nama_bahan VARCHAR(100) NOT NULL,
    satuan VARCHAR(20) NOT NULL,
    harga_beli DECIMAL(10,2) NOT NULL,
    stok_minimal INT DEFAULT 10,
    stok_sekarang INT DEFAULT 0,
    tanggal_expired DATE,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (supplier_id) REFERENCES supplier(id) ON DELETE SET NULL
);

-- ========================================
-- TABEL PRODUK JUS
-- ========================================
CREATE TABLE produk_jus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_produk VARCHAR(100) NOT NULL,
    harga_jual DECIMAL(10,2) NOT NULL,
    deskripsi TEXT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ========================================
-- TABEL RESEP JUS
-- ========================================
CREATE TABLE resep_jus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produk_id INT NOT NULL,
    bahan_id INT NOT NULL,
    jumlah DECIMAL(8,2) NOT NULL,
    satuan VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (produk_id) REFERENCES produk_jus(id) ON DELETE CASCADE,
    FOREIGN KEY (bahan_id) REFERENCES bahan_baku(id) ON DELETE CASCADE
);

-- ========================================
-- TABEL STOK MASUK
-- ========================================
CREATE TABLE stok_masuk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    supplier_id INT,
    bahan_id INT NOT NULL,
    jumlah INT NOT NULL,
    harga_satuan DECIMAL(10,2) NOT NULL,
    total_harga DECIMAL(10,2) NOT NULL,
    tanggal_masuk DATE NOT NULL,
    tanggal_expired DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (supplier_id) REFERENCES supplier(id) ON DELETE SET NULL,
    FOREIGN KEY (bahan_id) REFERENCES bahan_baku(id) ON DELETE CASCADE
);

-- ========================================
-- TABEL PENJUALAN
-- ========================================
CREATE TABLE penjualan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    no_transaksi VARCHAR(50) UNIQUE NOT NULL,
    tanggal_transaksi TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    nama_pembeli VARCHAR(100),
    metode_pembayaran ENUM('cash', 'transfer', 'qris') DEFAULT 'cash',
    total_harga DECIMAL(10,2) NOT NULL,
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- ========================================
-- TABEL DETAIL PENJUALAN
-- ========================================
CREATE TABLE detail_penjualan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    penjualan_id INT NOT NULL,
    produk_id INT NOT NULL,
    jumlah INT NOT NULL,
    harga_satuan DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (penjualan_id) REFERENCES penjualan(id) ON DELETE CASCADE,
    FOREIGN KEY (produk_id) REFERENCES produk_jus(id) ON DELETE CASCADE
);

-- ========================================
-- TABEL NOTIFIKASI
-- ========================================
CREATE TABLE notifikasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    pesan TEXT NOT NULL,
    tipe ENUM('info', 'warning', 'success', 'error') DEFAULT 'info',
    status ENUM('unread', 'read') DEFAULT 'unread',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ========================================
-- TABEL WASTE MANAGEMENT
-- ========================================
CREATE TABLE waste_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE waste_management (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kategori_id INT NOT NULL,
    nama_item VARCHAR(100) NOT NULL,
    jumlah DECIMAL(10,2) NOT NULL,
    satuan VARCHAR(20) NOT NULL,
    harga_per_unit DECIMAL(10,2) NOT NULL,
    total_nilai DECIMAL(10,2) NOT NULL,
    tanggal_waste DATE NOT NULL,
    alasan TEXT,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kategori_id) REFERENCES waste_categories(id) ON DELETE CASCADE
);

CREATE TABLE waste_disposal (
    id INT AUTO_INCREMENT PRIMARY KEY,
    waste_id INT NOT NULL,
    metode_disposal ENUM('buang', 'daur_ulang', 'donasi', 'lainnya') NOT NULL,
    lokasi_disposal VARCHAR(200),
    tanggal_disposal DATE NOT NULL,
    catatan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (waste_id) REFERENCES waste_management(id) ON DELETE CASCADE
);

-- ========================================
-- VIEWS
-- ========================================
CREATE VIEW v_laporan_penjualan_harian AS
SELECT 
    DATE(p.tanggal_transaksi) as tanggal,
    COUNT(*) as total_transaksi,
    SUM(p.total_harga) as total_pendapatan,
    COUNT(DISTINCT p.user_id) as total_kasir
FROM penjualan p
GROUP BY DATE(p.tanggal_transaksi)
ORDER BY tanggal DESC;

CREATE VIEW v_laporan_stok AS
SELECT 
    bb.id,
    bb.nama_bahan,
    bb.satuan,
    bb.stok_sekarang,
    bb.stok_minimal,
    bb.tanggal_expired,
    s.nama_supplier,
    CASE 
        WHEN bb.stok_sekarang <= bb.stok_minimal THEN 'Stok Menipis'
        WHEN bb.tanggal_expired <= DATE_ADD(CURDATE(), INTERVAL 7 DAY) THEN 'Mendekati Expired'
        ELSE 'Normal'
    END as status_stok
FROM bahan_baku bb
LEFT JOIN supplier s ON bb.supplier_id = s.id
WHERE bb.status = 'active';

CREATE VIEW v_laporan_pembelian AS
SELECT 
    sm.id,
    sm.tanggal_masuk,
    bb.nama_bahan,
    s.nama_supplier,
    sm.jumlah,
    sm.harga_satuan,
    sm.total_harga,
    sm.tanggal_expired
FROM stok_masuk sm
JOIN bahan_baku bb ON sm.bahan_id = bb.id
LEFT JOIN supplier s ON sm.supplier_id = s.id
ORDER BY sm.tanggal_masuk DESC;

CREATE VIEW v_produk_dengan_resep AS
SELECT 
    pj.id,
    pj.nama_produk,
    pj.harga_jual,
    COUNT(rj.id) as jumlah_bahan,
    GROUP_CONCAT(CONCAT(bb.nama_bahan, ' (', rj.jumlah, ' ', rj.satuan, ')') SEPARATOR ', ') as resep_detail
FROM produk_jus pj
LEFT JOIN resep_jus rj ON pj.id = rj.produk_id
LEFT JOIN bahan_baku bb ON rj.bahan_id = bb.id
GROUP BY pj.id, pj.nama_produk, pj.harga_jual;

CREATE VIEW v_waste_report AS
SELECT 
    wm.id,
    wm.nama_item,
    wc.nama_kategori,
    wm.jumlah,
    wm.satuan,
    wm.harga_per_unit,
    wm.total_nilai,
    wm.tanggal_waste,
    wm.status,
    wm.alasan
FROM waste_management wm
JOIN waste_categories wc ON wm.kategori_id = wc.id
ORDER BY wm.tanggal_waste DESC;

CREATE VIEW v_waste_disposal_report AS
SELECT 
    wd.id,
    wm.nama_item,
    wc.nama_kategori,
    wd.metode_disposal,
    wd.lokasi_disposal,
    wd.tanggal_disposal,
    wd.catatan,
    wm.total_nilai
FROM waste_disposal wd
JOIN waste_management wm ON wd.waste_id = wm.id
JOIN waste_categories wc ON wm.kategori_id = wc.id
ORDER BY wd.tanggal_disposal DESC;

-- ========================================
-- TRIGGERS
-- ========================================
DELIMITER //

-- Trigger untuk update stok bahan baku saat stok masuk
CREATE TRIGGER tr_update_stok_after_stok_masuk
AFTER INSERT ON stok_masuk
FOR EACH ROW
BEGIN
    UPDATE bahan_baku 
    SET stok_sekarang = stok_sekarang + NEW.jumlah,
        tanggal_expired = NEW.tanggal_expired
    WHERE id = NEW.bahan_id;
END//

-- Trigger untuk update stok bahan baku saat penjualan
CREATE TRIGGER tr_update_stok_after_penjualan
AFTER INSERT ON detail_penjualan
FOR EACH ROW
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE bahan_id INT;
    DECLARE jumlah_digunakan DECIMAL(8,2);
    DECLARE cur CURSOR FOR 
        SELECT bahan_id, jumlah FROM resep_jus WHERE produk_id = NEW.produk_id;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    
    OPEN cur;
    read_loop: LOOP
        FETCH cur INTO bahan_id, jumlah_digunakan;
        IF done THEN
            LEAVE read_loop;
        END IF;
        
        UPDATE bahan_baku 
        SET stok_sekarang = stok_sekarang - (jumlah_digunakan * NEW.jumlah)
        WHERE id = bahan_id;
    END LOOP;
    CLOSE cur;
END//

-- Trigger untuk menghitung total nilai waste
CREATE TRIGGER tr_calculate_waste_total
BEFORE INSERT ON waste_management
FOR EACH ROW
BEGIN
    SET NEW.total_nilai = NEW.jumlah * NEW.harga_per_unit;
END//

CREATE TRIGGER tr_calculate_waste_total_update
BEFORE UPDATE ON waste_management
FOR EACH ROW
BEGIN
    SET NEW.total_nilai = NEW.jumlah * NEW.harga_per_unit;
END//

DELIMITER ;

-- ========================================
-- INSERT DEFAULT DATA
-- ========================================

-- Insert default users
INSERT INTO users (nama_lengkap, email, password, role, status) VALUES
('Admin System', 'admin@noommies.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'active'),
('Owner System', 'owner@noommies.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'owner', 'active'),
('Karyawan System', 'karyawan@noommies.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'karyawan', 'active');

-- Insert default suppliers
INSERT INTO supplier (nama_supplier, alamat, no_telepon, email, kontak_person) VALUES
('Supplier Buah Segar', 'Jl. Raya Buah No. 123', '021-12345678', 'buah@supplier.com', 'Budi Santoso'),
('Supplier Susu', 'Jl. Susu Segar No. 456', '021-87654321', 'susu@supplier.com', 'Siti Aminah'),
('Supplier Gula', 'Jl. Gula Manis No. 789', '021-11223344', 'gula@supplier.com', 'Ahmad Wijaya');

-- Insert default waste categories
INSERT INTO waste_categories (nama_kategori, deskripsi) VALUES
('Buah Busuk', 'Buah-buahan yang sudah tidak layak konsumsi'),
('Susu Expired', 'Susu yang sudah melewati tanggal expired'),
('Kemasan Rusak', 'Kemasan yang rusak atau tidak layak pakai'),
('Lainnya', 'Kategori lainnya untuk waste management');

-- Insert default bahan baku
INSERT INTO bahan_baku (supplier_id, nama_bahan, satuan, harga_beli, stok_minimal, stok_sekarang) VALUES
(1, 'Jeruk', 'kg', 15000, 10, 50),
(1, 'Apel', 'kg', 20000, 5, 30),
(1, 'Mangga', 'kg', 18000, 8, 25),
(2, 'Susu UHT', 'liter', 12000, 20, 100),
(3, 'Gula Pasir', 'kg', 12000, 15, 40);

-- Insert default produk jus
INSERT INTO produk_jus (nama_produk, harga_jual, deskripsi) VALUES
('Jus Jeruk Segar', 15000, 'Jus jeruk segar tanpa pengawet'),
('Jus Apel Manis', 18000, 'Jus apel dengan rasa manis alami'),
('Jus Mangga Tropis', 20000, 'Jus mangga dengan rasa tropis'),
('Jus Mix Buah', 25000, 'Campuran berbagai buah segar');

-- Insert default resep
INSERT INTO resep_jus (produk_id, bahan_id, jumlah, satuan) VALUES
(1, 1, 0.5, 'kg'),
(1, 4, 0.2, 'liter'),
(1, 5, 0.1, 'kg'),
(2, 2, 0.4, 'kg'),
(2, 4, 0.2, 'liter'),
(2, 5, 0.1, 'kg'),
(3, 3, 0.6, 'kg'),
(3, 4, 0.2, 'liter'),
(3, 5, 0.1, 'kg'),
(4, 1, 0.2, 'kg'),
(4, 2, 0.2, 'kg'),
(4, 3, 0.2, 'kg'),
(4, 4, 0.3, 'liter'),
(4, 5, 0.15, 'kg');

-- Insert sample notifications
INSERT INTO notifikasi (judul, pesan, tipe) VALUES
('Selamat Datang', 'Selamat datang di sistem inventory management noÖmmies!', 'success'),
('Update Sistem', 'Sistem telah diperbarui dengan fitur terbaru.', 'info'),
('Pengingat Stok', 'Periksa stok bahan baku secara berkala.', 'warning');

-- ========================================
-- COMPLETION MESSAGE
-- ========================================
SELECT 'Database kedai_jus berhasil dibuat dengan struktur yang benar!' as message;
