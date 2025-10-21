-- ============================================================
-- DATABASE: SISTEM MANAJEMEN KEDAI JUS 🍹
-- Database Name: kedai_jus
-- Version: 1.0
-- ============================================================

-- Create Database
CREATE DATABASE IF NOT EXISTS kedai_jus;
USE kedai_jus;

-- ============================================================
-- TABLE 1: users - User Management
-- ============================================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'owner', 'karyawan') NOT NULL DEFAULT 'karyawan',
    no_hp VARCHAR(15),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABLE 2: supplier - Data Supplier Bahan Baku
-- ============================================================
CREATE TABLE supplier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_supplier VARCHAR(100) NOT NULL,
    alamat TEXT,
    no_hp VARCHAR(15),
    email VARCHAR(100),
    keterangan TEXT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_nama (nama_supplier)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABLE 3: bahan_baku - Data Bahan Baku
-- ============================================================
CREATE TABLE bahan_baku (
    id INT AUTO_INCREMENT PRIMARY KEY,
    supplier_id INT,
    nama_bahan VARCHAR(100) NOT NULL,
    satuan ENUM('kg', 'gram', 'liter', 'ml', 'pcs', 'pack') NOT NULL,
    stok DECIMAL(10,2) DEFAULT 0,
    stok_minimum DECIMAL(10,2) DEFAULT 10,
    harga_satuan DECIMAL(12,2) DEFAULT 0,
    tanggal_expired DATE,
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (supplier_id) REFERENCES supplier(id) ON DELETE SET NULL,
    INDEX idx_nama (nama_bahan),
    INDEX idx_stok (stok),
    INDEX idx_expired (tanggal_expired)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABLE 4: produk_jus - Data Produk Jus
-- ============================================================
CREATE TABLE produk_jus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_produk VARCHAR(100) NOT NULL,
    kategori ENUM('juice', 'smoothie', 'milkshake', 'blend') NOT NULL DEFAULT 'juice',
    ukuran ENUM('small', 'medium', 'large') NOT NULL DEFAULT 'medium',
    harga DECIMAL(12,2) NOT NULL,
    deskripsi TEXT,
    gambar VARCHAR(255),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_nama (nama_produk),
    INDEX idx_kategori (kategori)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABLE 5: resep_jus - Resep Produk (Relasi Produk & Bahan)
-- ============================================================
CREATE TABLE resep_jus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produk_id INT NOT NULL,
    bahan_id INT NOT NULL,
    jumlah DECIMAL(10,2) NOT NULL,
    satuan ENUM('kg', 'gram', 'liter', 'ml', 'pcs', 'pack') NOT NULL,
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (produk_id) REFERENCES produk_jus(id) ON DELETE CASCADE,
    FOREIGN KEY (bahan_id) REFERENCES bahan_baku(id) ON DELETE CASCADE,
    INDEX idx_produk (produk_id),
    INDEX idx_bahan (bahan_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABLE 6: stok_masuk - Pembelian/Stok Masuk Bahan Baku
-- ============================================================
CREATE TABLE stok_masuk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bahan_id INT NOT NULL,
    supplier_id INT,
    jumlah DECIMAL(10,2) NOT NULL,
    harga_satuan DECIMAL(12,2) NOT NULL,
    total_harga DECIMAL(15,2) NOT NULL,
    tanggal_masuk DATE NOT NULL,
    tanggal_expired DATE,
    no_faktur VARCHAR(50),
    keterangan TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (bahan_id) REFERENCES bahan_baku(id) ON DELETE CASCADE,
    FOREIGN KEY (supplier_id) REFERENCES supplier(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_bahan (bahan_id),
    INDEX idx_tanggal (tanggal_masuk)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABLE 7: penjualan - Data Transaksi Penjualan
-- ============================================================
CREATE TABLE penjualan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    no_transaksi VARCHAR(50) NOT NULL UNIQUE,
    tanggal_transaksi DATETIME NOT NULL,
    total_harga DECIMAL(15,2) NOT NULL,
    metode_pembayaran ENUM('cash', 'transfer', 'qris', 'debit') DEFAULT 'cash',
    nama_pembeli VARCHAR(100),
    user_id INT,
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_no_transaksi (no_transaksi),
    INDEX idx_tanggal (tanggal_transaksi)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABLE 8: detail_penjualan - Detail Item Penjualan
-- ============================================================
CREATE TABLE detail_penjualan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    penjualan_id INT NOT NULL,
    produk_id INT NOT NULL,
    jumlah INT NOT NULL,
    harga_satuan DECIMAL(12,2) NOT NULL,
    subtotal DECIMAL(15,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (penjualan_id) REFERENCES penjualan(id) ON DELETE CASCADE,
    FOREIGN KEY (produk_id) REFERENCES produk_jus(id) ON DELETE CASCADE,
    INDEX idx_penjualan (penjualan_id),
    INDEX idx_produk (produk_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- TABLE 9: notifikasi - Notifikasi & Peringatan
-- ============================================================
CREATE TABLE notifikasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipe ENUM('stok_menipis', 'expired', 'pengingat_input', 'info') NOT NULL,
    judul VARCHAR(255) NOT NULL,
    pesan TEXT NOT NULL,
    status ENUM('unread', 'read') DEFAULT 'unread',
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_status (status),
    INDEX idx_tipe (tipe)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- VIEW 1: v_laporan_stok - Laporan Stok Terkini
-- ============================================================
CREATE OR REPLACE VIEW v_laporan_stok AS
SELECT 
    bb.id,
    bb.nama_bahan,
    bb.satuan,
    bb.stok,
    bb.stok_minimum,
    bb.harga_satuan,
    bb.tanggal_expired,
    s.nama_supplier,
    CASE 
        WHEN bb.stok <= bb.stok_minimum THEN 'Stok Menipis'
        WHEN bb.stok > bb.stok_minimum AND bb.stok <= (bb.stok_minimum * 2) THEN 'Perlu Perhatian'
        ELSE 'Stok Aman'
    END AS status_stok,
    CASE 
        WHEN bb.tanggal_expired IS NOT NULL AND DATEDIFF(bb.tanggal_expired, CURDATE()) <= 3 THEN 'Segera Expired'
        WHEN bb.tanggal_expired IS NOT NULL AND DATEDIFF(bb.tanggal_expired, CURDATE()) <= 7 THEN 'Mendekati Expired'
        ELSE 'Aman'
    END AS status_expired,
    DATEDIFF(bb.tanggal_expired, CURDATE()) AS hari_tersisa
FROM bahan_baku bb
LEFT JOIN supplier s ON bb.supplier_id = s.id
ORDER BY bb.stok ASC, bb.tanggal_expired ASC;

-- ============================================================
-- VIEW 2: v_laporan_penjualan_harian - Laporan Penjualan Harian
-- ============================================================
CREATE OR REPLACE VIEW v_laporan_penjualan_harian AS
SELECT 
    DATE(p.tanggal_transaksi) AS tanggal,
    COUNT(p.id) AS total_transaksi,
    SUM(p.total_harga) AS total_pendapatan,
    AVG(p.total_harga) AS rata_rata_transaksi,
    SUM(dp.jumlah) AS total_produk_terjual,
    GROUP_CONCAT(DISTINCT p.metode_pembayaran) AS metode_pembayaran_digunakan
FROM penjualan p
LEFT JOIN detail_penjualan dp ON p.id = dp.penjualan_id
GROUP BY DATE(p.tanggal_transaksi)
ORDER BY tanggal DESC;

-- ============================================================
-- VIEW 3: v_laporan_pembelian - Laporan Pembelian Bahan
-- ============================================================
CREATE OR REPLACE VIEW v_laporan_pembelian AS
SELECT 
    sm.id,
    sm.tanggal_masuk,
    bb.nama_bahan,
    s.nama_supplier,
    sm.jumlah,
    bb.satuan,
    sm.harga_satuan,
    sm.total_harga,
    sm.no_faktur,
    u.nama_lengkap AS dibuat_oleh
FROM stok_masuk sm
JOIN bahan_baku bb ON sm.bahan_id = bb.id
LEFT JOIN supplier s ON sm.supplier_id = s.id
LEFT JOIN users u ON sm.created_by = u.id
ORDER BY sm.tanggal_masuk DESC;

-- ============================================================
-- VIEW 4: v_produk_dengan_resep - Produk Jus dengan Detail Resep
-- ============================================================
CREATE OR REPLACE VIEW v_produk_dengan_resep AS
SELECT 
    pj.id AS produk_id,
    pj.nama_produk,
    pj.kategori,
    pj.ukuran,
    pj.harga,
    bb.nama_bahan,
    rj.jumlah,
    rj.satuan,
    bb.stok AS stok_bahan
FROM produk_jus pj
LEFT JOIN resep_jus rj ON pj.id = rj.produk_id
LEFT JOIN bahan_baku bb ON rj.bahan_id = bb.id
WHERE pj.status = 'active'
ORDER BY pj.nama_produk, bb.nama_bahan;

-- ============================================================
-- TRIGGER 1: Otomatis Update Stok Saat Stok Masuk
-- ============================================================
DELIMITER $$
CREATE TRIGGER trg_after_stok_masuk
AFTER INSERT ON stok_masuk
FOR EACH ROW
BEGIN
    -- Update stok bahan baku
    UPDATE bahan_baku 
    SET stok = stok + NEW.jumlah,
        harga_satuan = NEW.harga_satuan,
        tanggal_expired = COALESCE(NEW.tanggal_expired, tanggal_expired)
    WHERE id = NEW.bahan_id;
    
    -- Hapus notifikasi stok menipis jika stok sudah cukup
    DELETE FROM notifikasi 
    WHERE tipe = 'stok_menipis' 
    AND pesan LIKE CONCAT('%', (SELECT nama_bahan FROM bahan_baku WHERE id = NEW.bahan_id), '%');
END$$
DELIMITER ;

-- ============================================================
-- TRIGGER 2: Generate Nomor Transaksi Otomatis
-- ============================================================
DELIMITER $$
CREATE TRIGGER trg_before_insert_penjualan
BEFORE INSERT ON penjualan
FOR EACH ROW
BEGIN
    DECLARE next_number INT;
    DECLARE trans_date VARCHAR(8);
    
    -- Format: TRX-YYYYMMDD-XXXX
    SET trans_date = DATE_FORMAT(NEW.tanggal_transaksi, '%Y%m%d');
    
    -- Dapatkan nomor urut terakhir
    SELECT IFNULL(MAX(CAST(SUBSTRING(no_transaksi, -4) AS UNSIGNED)), 0) + 1
    INTO next_number
    FROM penjualan
    WHERE DATE(tanggal_transaksi) = DATE(NEW.tanggal_transaksi);
    
    SET NEW.no_transaksi = CONCAT('TRX-', trans_date, '-', LPAD(next_number, 4, '0'));
END$$
DELIMITER ;

-- ============================================================
-- TRIGGER 3: Kurangi Stok Bahan Saat Penjualan
-- ============================================================
DELIMITER $$
CREATE TRIGGER trg_after_detail_penjualan
AFTER INSERT ON detail_penjualan
FOR EACH ROW
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE v_bahan_id INT;
    DECLARE v_jumlah_resep DECIMAL(10,2);
    DECLARE cur CURSOR FOR 
        SELECT bahan_id, jumlah 
        FROM resep_jus 
        WHERE produk_id = NEW.produk_id;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    
    OPEN cur;
    read_loop: LOOP
        FETCH cur INTO v_bahan_id, v_jumlah_resep;
        IF done THEN
            LEAVE read_loop;
        END IF;
        
        -- Kurangi stok bahan baku
        UPDATE bahan_baku 
        SET stok = stok - (v_jumlah_resep * NEW.jumlah)
        WHERE id = v_bahan_id;
        
    END LOOP;
    CLOSE cur;
END$$
DELIMITER ;

-- ============================================================
-- TRIGGER 4: Cek Stok Menipis Setelah Update
-- ============================================================
DELIMITER $$
CREATE TRIGGER trg_after_update_bahan_stok
AFTER UPDATE ON bahan_baku
FOR EACH ROW
BEGIN
    -- Jika stok menipis, buat notifikasi
    IF NEW.stok <= NEW.stok_minimum THEN
        INSERT INTO notifikasi (tipe, judul, pesan, status)
        VALUES (
            'stok_menipis',
            'Stok Bahan Menipis!',
            CONCAT('Bahan "', NEW.nama_bahan, '" tersisa ', NEW.stok, ' ', NEW.satuan, '. Segera lakukan pembelian!'),
            'unread'
        );
    END IF;
    
    -- Jika mendekati expired (H-3)
    IF NEW.tanggal_expired IS NOT NULL AND DATEDIFF(NEW.tanggal_expired, CURDATE()) <= 3 THEN
        INSERT INTO notifikasi (tipe, judul, pesan, status)
        VALUES (
            'expired',
            'Bahan Mendekati Expired!',
            CONCAT('Bahan "', NEW.nama_bahan, '" akan expired dalam ', DATEDIFF(NEW.tanggal_expired, CURDATE()), ' hari (', NEW.tanggal_expired, ')'),
            'unread'
        );
    END IF;
END$$
DELIMITER ;

-- ============================================================
-- STORED PROCEDURE: sp_generate_notif_stok_menipis
-- Jalankan secara berkala untuk cek stok
-- ============================================================
DELIMITER $$
CREATE PROCEDURE sp_generate_notif_stok_menipis()
BEGIN
    INSERT INTO notifikasi (tipe, judul, pesan, status)
    SELECT 
        'stok_menipis',
        'Peringatan Stok Menipis',
        CONCAT('Bahan "', nama_bahan, '" tersisa ', stok, ' ', satuan, '. Stok minimum: ', stok_minimum),
        'unread'
    FROM bahan_baku
    WHERE stok <= stok_minimum
    AND NOT EXISTS (
        SELECT 1 FROM notifikasi 
        WHERE tipe = 'stok_menipis' 
        AND pesan LIKE CONCAT('%', bahan_baku.nama_bahan, '%')
        AND status = 'unread'
    );
END$$
DELIMITER ;

-- ============================================================
-- STORED PROCEDURE: sp_generate_notif_expired
-- Jalankan secara berkala untuk cek expired
-- ============================================================
DELIMITER $$
CREATE PROCEDURE sp_generate_notif_expired()
BEGIN
    INSERT INTO notifikasi (tipe, judul, pesan, status)
    SELECT 
        'expired',
        'Peringatan Bahan Mendekati Expired',
        CONCAT('Bahan "', nama_bahan, '" akan expired dalam ', DATEDIFF(tanggal_expired, CURDATE()), ' hari (', tanggal_expired, ')'),
        'unread'
    FROM bahan_baku
    WHERE tanggal_expired IS NOT NULL
    AND DATEDIFF(tanggal_expired, CURDATE()) <= 3
    AND NOT EXISTS (
        SELECT 1 FROM notifikasi 
        WHERE tipe = 'expired' 
        AND pesan LIKE CONCAT('%', bahan_baku.nama_bahan, '%')
        AND DATE(created_at) = CURDATE()
    );
END$$
DELIMITER ;

-- ============================================================
-- DATA AWAL: Insert Default Admin User
-- ============================================================
INSERT INTO users (nama_lengkap, email, password, role, no_hp, status) VALUES
('Administrator', 'admin@kedaijus.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '081234567890', 'active'),
('Owner Kedai', 'owner@kedaijus.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'owner', '081234567891', 'active'),
('Karyawan 1', 'karyawan@kedaijus.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'karyawan', '081234567892', 'active');
-- Password default untuk semua user: password

-- ============================================================
-- DATA CONTOH: Supplier
-- ============================================================
INSERT INTO supplier (nama_supplier, alamat, no_hp, email, status) VALUES
('Toko Buah Segar', 'Jl. Pasar Induk No. 12, Jakarta', '0812345678', 'segar@email.com', 'active'),
('CV. Susu Murni', 'Jl. Raya Bogor KM 15', '0813456789', 'susu@email.com', 'active'),
('Distributor Gula Manis', 'Jl. Industri No. 45', '0814567890', 'gula@email.com', 'active');

-- ============================================================
-- DATA CONTOH: Bahan Baku
-- ============================================================
INSERT INTO bahan_baku (supplier_id, nama_bahan, satuan, stok, stok_minimum, harga_satuan, tanggal_expired) VALUES
(1, 'Buah Jeruk', 'kg', 50, 10, 15000, DATE_ADD(CURDATE(), INTERVAL 7 DAY)),
(1, 'Buah Apel', 'kg', 30, 10, 25000, DATE_ADD(CURDATE(), INTERVAL 5 DAY)),
(1, 'Buah Mangga', 'kg', 25, 10, 20000, DATE_ADD(CURDATE(), INTERVAL 10 DAY)),
(1, 'Buah Strawberry', 'kg', 15, 5, 45000, DATE_ADD(CURDATE(), INTERVAL 3 DAY)),
(1, 'Buah Naga', 'kg', 20, 8, 30000, DATE_ADD(CURDATE(), INTERVAL 6 DAY)),
(2, 'Susu Cair', 'liter', 40, 15, 18000, DATE_ADD(CURDATE(), INTERVAL 14 DAY)),
(2, 'Yogurt', 'liter', 25, 10, 22000, DATE_ADD(CURDATE(), INTERVAL 10 DAY)),
(3, 'Gula Pasir', 'kg', 100, 20, 12000, NULL),
(3, 'Madu', 'liter', 10, 5, 80000, DATE_ADD(CURDATE(), INTERVAL 90 DAY)),
(1, 'Es Batu', 'pack', 50, 20, 5000, NULL);

-- ============================================================
-- DATA CONTOH: Produk Jus
-- ============================================================
INSERT INTO produk_jus (nama_produk, kategori, ukuran, harga, deskripsi, status) VALUES
('Jus Jeruk Segar', 'juice', 'medium', 15000, 'Jus jeruk asli tanpa tambahan gula', 'active'),
('Jus Apel Manis', 'juice', 'medium', 18000, 'Jus apel segar dengan madu', 'active'),
('Smoothie Strawberry', 'smoothie', 'medium', 25000, 'Smoothie strawberry dengan yogurt', 'active'),
('Milkshake Mangga', 'milkshake', 'large', 28000, 'Milkshake mangga dengan susu segar', 'active'),
('Mix Fruit Juice', 'blend', 'large', 30000, 'Campuran buah naga, mangga, dan jeruk', 'active');

-- ============================================================
-- DATA CONTOH: Resep Jus
-- ============================================================
-- Jus Jeruk Segar (ID 1)
INSERT INTO resep_jus (produk_id, bahan_id, jumlah, satuan) VALUES
(1, 1, 300, 'gram'),    -- Jeruk 300g
(1, 8, 20, 'gram'),     -- Gula 20g
(1, 10, 1, 'pack');     -- Es Batu 1 pack

-- Jus Apel Manis (ID 2)
INSERT INTO resep_jus (produk_id, bahan_id, jumlah, satuan) VALUES
(2, 2, 250, 'gram'),    -- Apel 250g
(2, 9, 15, 'ml'),       -- Madu 15ml
(2, 10, 1, 'pack');     -- Es Batu 1 pack

-- Smoothie Strawberry (ID 3)
INSERT INTO resep_jus (produk_id, bahan_id, jumlah, satuan) VALUES
(3, 4, 200, 'gram'),    -- Strawberry 200g
(3, 7, 150, 'ml'),      -- Yogurt 150ml
(3, 8, 15, 'gram'),     -- Gula 15g
(3, 10, 1, 'pack');     -- Es Batu 1 pack

-- Milkshake Mangga (ID 4)
INSERT INTO resep_jus (produk_id, bahan_id, jumlah, satuan) VALUES
(4, 3, 300, 'gram'),    -- Mangga 300g
(4, 6, 200, 'ml'),      -- Susu 200ml
(4, 8, 20, 'gram'),     -- Gula 20g
(4, 10, 1, 'pack');     -- Es Batu 1 pack

-- Mix Fruit Juice (ID 5)
INSERT INTO resep_jus (produk_id, bahan_id, jumlah, satuan) VALUES
(5, 5, 150, 'gram'),    -- Buah Naga 150g
(5, 3, 150, 'gram'),    -- Mangga 150g
(5, 1, 150, 'gram'),    -- Jeruk 150g
(5, 9, 20, 'ml'),       -- Madu 20ml
(5, 10, 1, 'pack');     -- Es Batu 1 pack

-- ============================================================
-- END OF SCRIPT
-- ============================================================

