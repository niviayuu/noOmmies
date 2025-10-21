-- ========================================
-- DATABASE KEDAI JUS - TABLES ONLY
-- ========================================
-- Script untuk membuat database dengan tabel saja (tanpa Views)

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
    stok_minimum INT DEFAULT 10,
    stok INT DEFAULT 0,
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
    kategori VARCHAR(50) NOT NULL DEFAULT 'juice',
    ukuran VARCHAR(20) NOT NULL DEFAULT 'medium',
    harga DECIMAL(10,2) NOT NULL DEFAULT 0,
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
    created_by INT,
    approved_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kategori_id) REFERENCES waste_categories(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (approved_by) REFERENCES users(id) ON DELETE SET NULL
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

-- Insert default bahan baku
INSERT INTO bahan_baku (supplier_id, nama_bahan, satuan, harga_beli, stok_minimum, stok) VALUES
(1, 'Jeruk', 'kg', 15000, 10, 50),
(1, 'Apel', 'kg', 20000, 5, 30),
(1, 'Mangga', 'kg', 18000, 8, 25),
(2, 'Susu UHT', 'liter', 12000, 20, 100),
(3, 'Gula Pasir', 'kg', 12000, 15, 40);

-- Insert default produk jus
INSERT INTO produk_jus (nama_produk, kategori, ukuran, harga, harga_jual, deskripsi) VALUES
('Jus Jeruk Segar', 'juice', 'medium', 15000, 15000, 'Jus jeruk segar tanpa pengawet'),
('Jus Apel Manis', 'juice', 'large', 18000, 18000, 'Jus apel dengan rasa manis alami'),
('Jus Mangga Tropis', 'smoothie', 'large', 20000, 20000, 'Jus mangga dengan rasa tropis'),
('Jus Mix Buah', 'blend', 'large', 25000, 25000, 'Campuran berbagai buah segar');

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

-- Insert default waste categories
INSERT INTO waste_categories (nama_kategori, deskripsi) VALUES
('Buah Busuk', 'Buah-buahan yang sudah tidak layak konsumsi'),
('Susu Expired', 'Susu yang sudah melewati tanggal expired'),
('Kemasan Rusak', 'Kemasan yang rusak atau tidak layak pakai'),
('Lainnya', 'Kategori lainnya untuk waste management');

-- ========================================
-- COMPLETION MESSAGE
-- ========================================
SELECT 'Database kedai_jus berhasil dibuat dengan tabel saja!' as message;
