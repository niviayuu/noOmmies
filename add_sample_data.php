<?php
// Script untuk menambahkan data sample penjualan
// Jalankan script ini untuk testing

// Include CodeIgniter
require_once('index.php');

// Get CodeIgniter instance
$CI =& get_instance();
$CI->load->database();

// Sample data penjualan
$sample_penjualan = [
    [
        'no_transaksi' => 'TRX20251021001',
        'tanggal_transaksi' => '2025-10-21 08:30:00',
        'total_harga' => 25000,
        'metode_pembayaran' => 'cash',
        'nama_pembeli' => 'Budi Santoso',
        'user_id' => 1,
        'keterangan' => 'Pembelian jus jeruk'
    ],
    [
        'no_transaksi' => 'TRX20251021002',
        'tanggal_transaksi' => '2025-10-21 09:15:00',
        'total_harga' => 35000,
        'metode_pembayaran' => 'transfer',
        'nama_pembeli' => 'Siti Nurhaliza',
        'user_id' => 1,
        'keterangan' => 'Pembelian smoothie mangga'
    ],
    [
        'no_transaksi' => 'TRX20251021003',
        'tanggal_transaksi' => '2025-10-21 10:45:00',
        'total_harga' => 18000,
        'metode_pembayaran' => 'qris',
        'nama_pembeli' => 'Ahmad Wijaya',
        'user_id' => 1,
        'keterangan' => 'Pembelian jus apel'
    ],
    [
        'no_transaksi' => 'TRX20251021004',
        'tanggal_transaksi' => '2025-10-21 11:20:00',
        'total_harga' => 42000,
        'metode_pembayaran' => 'cash',
        'nama_pembeli' => 'Maria Magdalena',
        'user_id' => 1,
        'keterangan' => 'Pembelian milkshake coklat'
    ],
    [
        'no_transaksi' => 'TRX20251021005',
        'tanggal_transaksi' => '2025-10-21 12:00:00',
        'total_harga' => 30000,
        'metode_pembayaran' => 'debit',
        'nama_pembeli' => 'John Doe',
        'user_id' => 1,
        'keterangan' => 'Pembelian jus strawberry'
    ]
];

// Sample detail penjualan
$sample_detail = [
    [
        'penjualan_id' => 1,
        'produk_id' => 1,
        'jumlah' => 2,
        'harga_satuan' => 12500,
        'subtotal' => 25000
    ],
    [
        'penjualan_id' => 2,
        'produk_id' => 2,
        'jumlah' => 1,
        'harga_satuan' => 35000,
        'subtotal' => 35000
    ],
    [
        'penjualan_id' => 3,
        'produk_id' => 3,
        'jumlah' => 1,
        'harga_satuan' => 18000,
        'subtotal' => 18000
    ],
    [
        'penjualan_id' => 4,
        'produk_id' => 4,
        'jumlah' => 1,
        'harga_satuan' => 42000,
        'subtotal' => 42000
    ],
    [
        'penjualan_id' => 5,
        'produk_id' => 5,
        'jumlah' => 2,
        'harga_satuan' => 15000,
        'subtotal' => 30000
    ]
];

echo "Menambahkan data sample penjualan...\n";

// Insert penjualan
foreach ($sample_penjualan as $penjualan) {
    $CI->db->insert('penjualan', $penjualan);
    echo "Penjualan " . $penjualan['no_transaksi'] . " berhasil ditambahkan\n";
}

// Insert detail penjualan
foreach ($sample_detail as $detail) {
    $CI->db->insert('detail_penjualan', $detail);
    echo "Detail penjualan ID " . $detail['penjualan_id'] . " berhasil ditambahkan\n";
}

echo "\nData sample berhasil ditambahkan!\n";
echo "Sekarang Anda bisa melihat data penjualan di: http://localhost/jusbaru/penjualan\n";
?>
