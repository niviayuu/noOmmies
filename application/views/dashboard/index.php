<?php if ($show_no_input_notification): ?>
<div id="noInputModal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h4 class="modal-title">
                    <i class="fas fa-calendar-times"></i> Pengingat Input Barang
                </h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Pengingat!</strong> Anda belum melakukan input barang selama <strong><?php echo $days_since_input; ?> hari</strong> terakhir.
                </div>
                
                <p>Untuk menjaga kelancaran operasional kedai, disarankan untuk:</p>
                <ul>
                    <li>Memeriksa stok bahan baku yang tersedia</li>
                    <li>Melakukan pembelian bahan baku yang diperlukan</li>
                    <li>Mencatat semua barang yang masuk ke sistem</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="dismissNotification('no_input')">
                    <i class="fas fa-times"></i> Tutup
                </button>
                <a href="<?php echo site_url('stok_masuk/tambah'); ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Input Barang
                </a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Statistics Row -->
<div class="stats-row" style="display: flex; gap: 20px; margin-bottom: 30px;">
    <div class="stat-card" style="flex: 1; display: flex; align-items: center; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <div class="stat-icon primary" style="margin-right: 15px; font-size: 24px; color:rgb(255, 255, 255);">
            <i class="fas fa-cubes"></i>
        </div>
        <div class="stat-content">
            <h3 style="margin: 0; font-size: 28px; font-weight: bold; color: #333;"><?php echo $total_bahan; ?></h3>
            <p style="margin: 5px 0 0; color: #6c757d; font-size: 14px;">Total Bahan Baku</p>
        </div>
    </div>
    
    <div class="stat-card" style="flex: 1; display: flex; align-items: center; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <div class="stat-icon success" style="margin-right: 15px; font-size: 24px; color:rgb(255, 255, 255);">
            <i class="fas fa-wine-bottle"></i>
        </div>
        <div class="stat-content">
            <h3 style="margin: 0; font-size: 28px; font-weight: bold; color: #333;"><?php echo $total_produk; ?></h3>
            <p style="margin: 5px 0 0; color: #6c757d; font-size: 14px;">Produk Jus Aktif</p>
        </div>
    </div>
    
    <div class="stat-card" style="flex: 1; display: flex; align-items: center; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <div class="stat-icon info" style="margin-right: 15px; font-size: 24px; color:rgb(255, 255, 255);">
            <i class="fas fa-shipping-fast"></i>
        </div>
        <div class="stat-content">
            <h3 style="margin: 0; font-size: 28px; font-weight: bold; color: #333;"><?php echo $total_supplier; ?></h3>
            <p style="margin: 5px 0 0; color: #6c757d; font-size: 14px;">Total Supplier</p>
        </div>
    </div>
    
    <div class="stat-card" style="flex: 1; display: flex; align-items: center; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <div class="stat-icon warning" style="margin-right: 15px; font-size: 24px; color:rgb(255, 255, 255);">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="stat-content">
            <h3 style="margin: 0; font-size: 28px; font-weight: bold; color: #333;"><?php echo $low_stock_count; ?></h3>
            <p style="margin: 5px 0 0; color: #6c757d; font-size: 14px;">Stok Menipis</p>
        </div>
    </div>
</div>

<!-- Sales Statistics -->
<div class="stats-row">
    <div class="card" style="grid-column: span 2;">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-chart-bar"></i> Penjualan Hari Ini</h3>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 8px;">
                    <h2 style="color: var(--primary-color); margin: 0;">
                        <?php echo $today_transactions; ?>
                    </h2>
                    <p style="margin: 10px 0 0; color: #6c757d;">Transaksi</p>
                </div>
                <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 8px;">
                    <h2 style="color: var(--success-color); margin: 0;">
                        Rp <?php echo number_format($today_sales->total_pendapatan ?: 0, 0, ',', '.'); ?>
                    </h2>
                    <p style="margin: 10px 0 0; color: #6c757d;">Pendapatan</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card" style="grid-column: span 2;">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-calendar-alt"></i> Penjualan Bulan Ini</h3>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 8px;">
                    <h2 style="color: var(--primary-color); margin: 0;">
                        <?php echo $month_transactions; ?>
                    </h2>
                    <p style="margin: 10px 0 0; color: #6c757d;">Transaksi</p>
                </div>
                <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 8px;">
                    <h2 style="color: var(--success-color); margin: 0;">
                        Rp <?php echo number_format($month_sales ?: 0, 0, ',', '.'); ?>
                    </h2>
                    <p style="margin: 10px 0 0; color: #6c757d;">Pendapatan</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Tables -->
<div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
    <!-- Sales Chart -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-chart-line"></i> Grafik Penjualan 7 Hari Terakhir</h3>
        </div>
        <div class="card-body">
            <canvas id="salesChart"></canvas>
        </div>
    </div>
    
    <!-- Best Selling Products -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-medal"></i> Produk Terlaris Bulan Ini</h3>
        </div>
        <div class="card-body">
            <?php if (!empty($best_selling)): ?>
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th style="text-align: right;">Terjual</th>
                        <th style="text-align: right;">Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($best_selling as $item): ?>
                    <tr>
                        <td><?php echo $item->nama_produk; ?></td>
                        <td style="text-align: right;"><?php echo $item->total_terjual; ?></td>
                        <td style="text-align: right;">Rp <?php echo number_format($item->total_pendapatan, 0, ',', '.'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p style="text-align: center; color: #6c757d; padding: 20px;">Belum ada data penjualan</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Alerts -->
<?php if (!empty($low_stock_items)): ?>
<div class="card">
    <div class="card-header" style="background: #fff3cd;">
        <h3 class="card-title" style="color: #856404;">
            <i class="fas fa-exclamation-triangle"></i> Peringatan Stok Menipis
        </h3>
    </div>
    <div class="card-body">
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th>Nama Bahan</th>
                    <th>Stok Saat Ini</th>
                    <th>Stok Minimum</th>
                    <th>Supplier</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($low_stock_items as $item): ?>
                <tr>
                    <td><?php echo $item->nama_bahan; ?></td>
                    <td><?php echo $item->stok . ' ' . $item->satuan; ?></td>
                    <td><?php echo $item->stok_minimum . ' ' . $item->satuan; ?></td>
                    <td><?php echo $item->nama_supplier ?: '-'; ?></td>
                    <td><span class="badge badge-warning">Stok Menipis</span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?php if (!empty($expiring_items)): ?>
<div class="card">
    <div class="card-header" style="background: #f8d7da;">
        <h3 class="card-title" style="color: #721c24;">
            <i class="fas fa-hourglass-half"></i> Peringatan Bahan Mendekati Expired
        </h3>
    </div>
    <div class="card-body">
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th>Nama Bahan</th>
                    <th>Tanggal Expired</th>
                    <th>Hari Tersisa</th>
                    <th>Stok</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($expiring_items as $item): ?>
                <tr>
                    <td><?php echo $item->nama_bahan; ?></td>
                    <td><?php echo date('d M Y', strtotime($item->tanggal_expired)); ?></td>
                    <td><?php echo $item->hari_tersisa . ' hari'; ?></td>
                    <td><?php echo $item->stok . ' ' . $item->satuan; ?></td>
                    <td>
                        <span class="badge badge-danger">
                            <?php echo $item->hari_tersisa <= 1 ? 'Segera Expired!' : 'Mendekati Expired'; ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<!-- Recent Transactions -->
<div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
    <!-- Recent Sales -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-shopping-bag"></i> Penjualan Terbaru</h3>
            <a href="<?php echo site_url('penjualan'); ?>" class="btn btn-sm btn-primary" style="margin-left: 10px;">Lihat Semua</a>
        </div>
        <div class="card-body">
            <?php if (!empty($recent_sales)): ?>
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th>No Transaksi</th>
                        <th>Tanggal</th>
                        <th style="text-align: right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_sales as $sale): ?>
                    <tr>
                        <td>
                            <a href="<?php echo site_url('penjualan/detail/' . $sale->id); ?>">
                                <?php echo $sale->no_transaksi; ?>
                            </a>
                        </td>
                        <td><?php echo date('d M Y H:i', strtotime($sale->tanggal_transaksi)); ?></td>
                        <td style="text-align: right;">Rp <?php echo number_format($sale->total_harga, 0, ',', '.'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p style="text-align: center; color: #6c757d; padding: 20px;">Belum ada transaksi</p>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Recent Stock Entries -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-arrow-circle-down"></i> Stok Masuk Terbaru</h3>
            <?php if (in_array($this->session->userdata('role'), ['admin', 'owner'])): ?>
            <a href="<?php echo site_url('stok_masuk'); ?>" class="btn btn-sm btn-primary" style="margin-left: 10px;">Lihat Semua</a>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <?php if (!empty($recent_stock)): ?>
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th>Bahan</th>
                        <th>Tanggal</th>
                        <th style="text-align: right;">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_stock as $stock): ?>
                    <tr>
                        <td><?php echo $stock->nama_bahan; ?></td>
                        <td><?php echo date('d M Y', strtotime($stock->tanggal_masuk)); ?></td>
                        <td style="text-align: right;"><?php echo $stock->jumlah . ' ' . $stock->satuan; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p style="text-align: center; color: #6c757d; padding: 20px;">Belum ada stok masuk</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
// Sales Chart
const salesChartCtx = document.getElementById('salesChart');
if (salesChartCtx) {
    new Chart(salesChartCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($chart_labels); ?>,
            datasets: [{
                label: 'Penjualan (Rp)',
                data: <?php echo json_encode($chart_data); ?>,
                borderColor: '#FF6B35',
                backgroundColor: 'rgba(255, 107, 53, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
}

// Login Notifications
$(document).ready(function() {
    // Show no input modal directly
    <?php if ($show_no_input_notification): ?>
    $('#noInputModal').modal('show');
    <?php endif; ?>
});

// Dismiss notification function
function dismissNotification(type) {
    $.ajax({
        url: '<?php echo site_url("dashboard/dismiss_notification"); ?>/' + type,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            if (type === 'no_input') {
                $('#noInputModal').modal('hide');
            }
        },
        error: function() {
            // Still close modal even if AJAX fails
            if (type === 'no_input') {
                $('#noInputModal').modal('hide');
            }
        }
    });
}
</script>

