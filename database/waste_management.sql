-- Database untuk Waste Management System
-- File: waste_management.sql

-- Table untuk kategori waste
CREATE TABLE IF NOT EXISTS `waste_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) NOT NULL,
  `deskripsi` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data kategori waste
INSERT INTO `waste_categories` (`nama_kategori`, `deskripsi`) VALUES
('Bahan Expired', 'Bahan baku yang sudah expired dan tidak bisa digunakan'),
('Produk Rusak', 'Produk jus yang rusak atau tidak layak konsumsi'),
('Kemasan Rusak', 'Kemasan yang rusak atau tidak layak pakai'),
('Sisa Produksi', 'Sisa bahan dari proses produksi yang tidak bisa digunakan'),
('Lainnya', 'Waste lainnya yang tidak termasuk kategori di atas');

-- Table untuk waste management
CREATE TABLE IF NOT EXISTS `waste_management` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal_waste` date NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `bahan_baku_id` int(11) DEFAULT NULL,
  `produk_jus_id` int(11) DEFAULT NULL,
  `nama_item` varchar(200) NOT NULL,
  `jumlah_waste` decimal(10,2) NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `harga_per_satuan` decimal(12,2) DEFAULT 0,
  `total_nilai_waste` decimal(12,2) DEFAULT 0,
  `alasan_waste` text NOT NULL,
  `foto_waste` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `approved_by` int(11) DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `kategori_id` (`kategori_id`),
  KEY `bahan_baku_id` (`bahan_baku_id`),
  KEY `produk_jus_id` (`produk_jus_id`),
  KEY `created_by` (`created_by`),
  KEY `approved_by` (`approved_by`),
  CONSTRAINT `waste_management_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `waste_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `waste_management_ibfk_2` FOREIGN KEY (`bahan_baku_id`) REFERENCES `bahan_baku` (`id`) ON DELETE SET NULL,
  CONSTRAINT `waste_management_ibfk_3` FOREIGN KEY (`produk_jus_id`) REFERENCES `produk_jus` (`id`) ON DELETE SET NULL,
  CONSTRAINT `waste_management_ibfk_4` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `waste_management_ibfk_5` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table untuk waste disposal (pembuangan waste)
CREATE TABLE IF NOT EXISTS `waste_disposal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `waste_id` int(11) NOT NULL,
  `tanggal_disposal` date NOT NULL,
  `metode_disposal` enum('dibuang','didaur_ulang','dijual','disedekahkan') NOT NULL,
  `lokasi_disposal` varchar(200) DEFAULT NULL,
  `nama_penerima` varchar(100) DEFAULT NULL,
  `kontak_penerima` varchar(50) DEFAULT NULL,
  `catatan_disposal` text,
  `foto_disposal` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `waste_id` (`waste_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `waste_disposal_ibfk_1` FOREIGN KEY (`waste_id`) REFERENCES `waste_management` (`id`) ON DELETE CASCADE,
  CONSTRAINT `waste_disposal_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- View untuk laporan waste dengan detail
CREATE OR REPLACE VIEW `v_waste_report` AS
SELECT 
    wm.id,
    wm.tanggal_waste,
    wc.nama_kategori,
    wm.nama_item,
    wm.jumlah_waste,
    wm.satuan,
    wm.harga_per_satuan,
    wm.total_nilai_waste,
    wm.alasan_waste,
    wm.status,
    u1.nama_lengkap AS created_by_name,
    u2.nama_lengkap AS approved_by_name,
    wm.approved_at,
    wm.created_at,
    wm.updated_at
FROM waste_management wm
LEFT JOIN waste_categories wc ON wm.kategori_id = wc.id
LEFT JOIN users u1 ON wm.created_by = u1.id
LEFT JOIN users u2 ON wm.approved_by = u2.id;

-- View untuk laporan waste disposal
CREATE OR REPLACE VIEW `v_waste_disposal_report` AS
SELECT 
    wd.id,
    wd.waste_id,
    wm.tanggal_waste,
    wc.nama_kategori,
    wm.nama_item,
    wm.jumlah_waste,
    wm.satuan,
    wm.total_nilai_waste,
    wd.tanggal_disposal,
    wd.metode_disposal,
    wd.lokasi_disposal,
    wd.nama_penerima,
    wd.kontak_penerima,
    wd.catatan_disposal,
    u.nama_lengkap AS disposal_by_name,
    wd.created_at
FROM waste_disposal wd
LEFT JOIN waste_management wm ON wd.waste_id = wm.id
LEFT JOIN waste_categories wc ON wm.kategori_id = wc.id
LEFT JOIN users u ON wd.created_by = u.id;

-- Insert sample data untuk testing
INSERT INTO `waste_management` (`tanggal_waste`, `kategori_id`, `nama_item`, `jumlah_waste`, `satuan`, `harga_per_satuan`, `total_nilai_waste`, `alasan_waste`, `status`, `created_by`) VALUES
('2024-01-15', 1, 'Buah Strawberry', 2.50, 'kg', 25000.00, 62500.00, 'Buah strawberry sudah expired dan tidak layak konsumsi', 'approved', 1),
('2024-01-16', 2, 'Jus Jeruk', 5.00, 'botol', 15000.00, 75000.00, 'Produk jus jeruk rusak karena kemasan bocor', 'approved', 1),
('2024-01-17', 3, 'Botol Plastik', 20.00, 'pcs', 500.00, 10000.00, 'Botol plastik rusak saat proses produksi', 'pending', 1),
('2024-01-18', 4, 'Sisa Buah Apel', 1.20, 'kg', 18000.00, 21600.00, 'Sisa buah apel dari proses produksi yang tidak bisa digunakan', 'approved', 1),
('2024-01-19', 1, 'Buah Mangga', 3.00, 'kg', 20000.00, 60000.00, 'Buah mangga sudah expired', 'pending', 1);

-- Insert sample disposal data
INSERT INTO `waste_disposal` (`waste_id`, `tanggal_disposal`, `metode_disposal`, `lokasi_disposal`, `catatan_disposal`, `created_by`) VALUES
(1, '2024-01-16', 'dibuang', 'TPA Kota', 'Buah strawberry expired dibuang ke TPA', 1),
(2, '2024-01-17', 'dibuang', 'TPA Kota', 'Jus jeruk rusak dibuang ke TPA', 1),
(4, '2024-01-19', 'didaur_ulang', 'Pusat Daur Ulang', 'Sisa buah apel didaur ulang menjadi kompos', 1);

-- Trigger untuk menghitung total nilai waste otomatis
DELIMITER $$
CREATE TRIGGER `calculate_waste_total` 
BEFORE INSERT ON `waste_management`
FOR EACH ROW
BEGIN
    SET NEW.total_nilai_waste = NEW.jumlah_waste * NEW.harga_per_satuan;
END$$

CREATE TRIGGER `calculate_waste_total_update` 
BEFORE UPDATE ON `waste_management`
FOR EACH ROW
BEGIN
    SET NEW.total_nilai_waste = NEW.jumlah_waste * NEW.harga_per_satuan;
END$$
DELIMITER ;

-- Index untuk optimasi query
CREATE INDEX `idx_waste_date` ON `waste_management` (`tanggal_waste`);
CREATE INDEX `idx_waste_status` ON `waste_management` (`status`);
CREATE INDEX `idx_waste_category` ON `waste_management` (`kategori_id`);
CREATE INDEX `idx_disposal_date` ON `waste_disposal` (`tanggal_disposal`);
CREATE INDEX `idx_disposal_method` ON `waste_disposal` (`metode_disposal`);
