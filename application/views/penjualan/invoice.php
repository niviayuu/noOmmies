<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #<?php echo $penjualan->no_transaksi; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #333;
        }
        
        .invoice-header h1 {
            color: #FF6B35;
            margin-bottom: 5px;
        }
        
        .invoice-info {
            margin: 20px 0;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        
        .invoice-info div {
            padding: 10px;
        }
        
        .invoice-info strong {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        table thead {
            background: #f8f9fa;
        }
        
        table th,
        table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        
        table th {
            font-weight: bold;
        }
        
        table tfoot td {
            font-weight: bold;
            font-size: 18px;
        }
        
        .total-row {
            background: #f8f9fa;
        }
        
        .invoice-footer {
            margin-top: 40px;
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            color: #666;
        }
        
        @media print {
            .no-print {
                display: none;
            }
        }
        
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: #FF6B35;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-btn no-print">
        <i class="fas fa-print"></i> Cetak
    </button>
    
    <div class="invoice-header">
        <h1>🍋 noÖmmies</h1>
        <p>Jl. Contoh No. 123, Jakarta</p>
        <p>Telp: 021-12345678 | Email: info@noommies.com</p>
    </div>
    
    <h2 style="text-align: center; margin: 20px 0;">INVOICE</h2>
    
    <div class="invoice-info">
        <div>
            <strong>No. Transaksi:</strong>
            <?php echo $penjualan->no_transaksi; ?>
        </div>
        <div>
            <strong>Tanggal:</strong>
            <?php echo date('d M Y H:i', strtotime($penjualan->tanggal_transaksi)); ?>
        </div>
        <div>
            <strong>Kasir:</strong>
            <?php echo $penjualan->nama_lengkap ?: '-'; ?>
        </div>
        <div>
            <strong>Pembeli:</strong>
            <?php echo $penjualan->nama_pembeli ?: 'Umum'; ?>
        </div>
        <div>
            <strong>Metode Pembayaran:</strong>
            <?php echo strtoupper($penjualan->metode_pembayaran); ?>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th style="text-align: center;">Qty</th>
                <th style="text-align: right;">Harga</th>
                <th style="text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            foreach ($penjualan->details as $detail): 
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $detail->nama_produk; ?></td>
                <td style="text-align: center;"><?php echo $detail->jumlah; ?></td>
                <td style="text-align: right;">Rp <?php echo number_format($detail->harga_satuan, 0, ',', '.'); ?></td>
                <td style="text-align: right;">Rp <?php echo number_format($detail->subtotal, 0, ',', '.'); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" style="text-align: right;">TOTAL:</td>
                <td style="text-align: right; color: #FF6B35;">
                    Rp <?php echo number_format($penjualan->total_harga, 0, ',', '.'); ?>
                </td>
            </tr>
        </tfoot>
    </table>
    
    <div class="invoice-footer">
        <p>Terima kasih atas kunjungan Anda!</p>
        <p>-- Selamat Menikmati --</p>
        <p style="margin-top: 20px; font-size: 12px;">
            Dicetak pada: <?php echo date('d M Y H:i:s'); ?>
        </p>
    </div>
</body>
</html>

