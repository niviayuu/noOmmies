<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="laporan_waste_' . date('Y-m-d') . '.xls"');
header('Cache-Control: max-age=0');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Waste</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .header { text-align: center; margin-bottom: 20px; }
        .summary { margin-bottom: 20px; }
        .summary table { width: auto; margin: 0 auto; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN WASTE MANAGEMENT</h2>
        <h3>Kedai Jus Management System</h3>
        <p>Tanggal Export: <?= date('d/m/Y H:i:s') ?></p>
    </div>

    <?php if (!empty($waste_records)): ?>
        <!-- Summary -->
        <div class="summary">
            <h4>Ringkasan Data</h4>
            <table>
                <tr>
                    <th>Total Waste</th>
                    <td><?= count($waste_records) ?> item</td>
                </tr>
                <tr>
                    <th>Total Nilai Waste</th>
                    <td>Rp <?= number_format(array_sum(array_column($waste_records, 'total_nilai_waste')), 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <th>Status Pending</th>
                    <td><?= count(array_filter($waste_records, function($item) { return $item->status == 'pending'; })) ?> item</td>
                </tr>
                <tr>
                    <th>Status Disetujui</th>
                    <td><?= count(array_filter($waste_records, function($item) { return $item->status == 'approved'; })) ?> item</td>
                </tr>
                <tr>
                    <th>Status Ditolak</th>
                    <td><?= count(array_filter($waste_records, function($item) { return $item->status == 'rejected'; })) ?> item</td>
                </tr>
            </table>
        </div>

        <!-- Detail Data -->
        <h4>Detail Data Waste</h4>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Waste</th>
                    <th>Kategori</th>
                    <th>Nama Item</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Harga per Satuan</th>
                    <th>Total Nilai</th>
                    <th>Status</th>
                    <th>Alasan Waste</th>
                    <th>Dibuat Oleh</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($waste_records as $index => $waste): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= date('d/m/Y', strtotime($waste->tanggal_waste)) ?></td>
                    <td><?= $waste->nama_kategori ?></td>
                    <td><?= $waste->nama_item ?></td>
                    <td><?= number_format($waste->jumlah_waste, 2) ?></td>
                    <td><?= $waste->satuan ?></td>
                    <td>Rp <?= number_format($waste->harga_per_satuan, 0, ',', '.') ?></td>
                    <td>Rp <?= number_format($waste->total_nilai_waste, 0, ',', '.') ?></td>
                    <td>
                        <?php 
                        switch($waste->status) {
                            case 'pending': echo 'Pending'; break;
                            case 'approved': echo 'Disetujui'; break;
                            case 'rejected': echo 'Ditolak'; break;
                            default: echo ucfirst($waste->status);
                        }
                        ?>
                    </td>
                    <td><?= $waste->alasan_waste ?></td>
                    <td><?= $waste->created_by_name ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr style="background-color: #f2f2f2; font-weight: bold;">
                    <td colspan="7" style="text-align: right;">TOTAL NILAI WASTE:</td>
                    <td>Rp <?= number_format(array_sum(array_column($waste_records, 'total_nilai_waste')), 0, ',', '.') ?></td>
                    <td colspan="3"></td>
                </tr>
            </tfoot>
        </table>

        <!-- Kategori Summary -->
        <h4>Ringkasan per Kategori</h4>
        <table>
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th>Jumlah Item</th>
                    <th>Total Nilai</th>
                    <th>Persentase</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $categories_summary = array();
                $total_value = array_sum(array_column($waste_records, 'total_nilai_waste'));
                
                foreach ($waste_records as $waste) {
                    if (!isset($categories_summary[$waste->nama_kategori])) {
                        $categories_summary[$waste->nama_kategori] = array(
                            'count' => 0,
                            'total_value' => 0
                        );
                    }
                    $categories_summary[$waste->nama_kategori]['count']++;
                    $categories_summary[$waste->nama_kategori]['total_value'] += $waste->total_nilai_waste;
                }
                
                foreach ($categories_summary as $category => $data): 
                    $percentage = $total_value > 0 ? ($data['total_value'] / $total_value) * 100 : 0;
                ?>
                <tr>
                    <td><?= $category ?></td>
                    <td><?= $data['count'] ?> item</td>
                    <td>Rp <?= number_format($data['total_value'], 0, ',', '.') ?></td>
                    <td><?= number_format($percentage, 2) ?>%</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php else: ?>
        <div style="text-align: center; padding: 50px;">
            <h3>Tidak ada data waste</h3>
            <p>Belum ada data waste untuk diekspor</p>
        </div>
    <?php endif; ?>

    <div style="margin-top: 30px; text-align: center; font-size: 12px; color: #666;">
        <p>Dokumen ini dibuat secara otomatis oleh sistem Kedai Jus Management System</p>
        <p>Tanggal: <?= date('d/m/Y H:i:s') ?> | Halaman: 1</p>
    </div>
</body>
</html>
