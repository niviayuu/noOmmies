<?php $this->load->view('templates/header'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                        <h3 class="card-title">Laporan Penjualan Harian</h3>
                    <div class="card-tools">
                        <button onclick="window.print()" class="btn btn-success btn-sm">
                            Cetak
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter Tanggal -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form method="GET" class="form-inline">
                                <div class="form-group mr-3">
                                    <label for="date" class="mr-2">Tanggal:</label>
                                    <input type="date" class="form-control" id="date" name="date" 
                                           value="<?= $date ?>">
                                </div>
                                    <button type="submit" class="btn btn-primary">
                                        Filter
                                    </button>
                            </form>
                        </div>
                    </div>

                    <!-- Ringkasan Harian -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h6 class="mb-0">Tanggal</h6>
                                    <h4 class="mb-0"><?= date('d/m/Y', strtotime($date)) ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h6 class="mb-0">Total Transaksi</h6>
                                    <h4 class="mb-0"><?= $daily_report->total_transaksi ?: 0 ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h6 class="mb-0">Total Pendapatan</h6>
                                    <h4 class="mb-0">Rp <?= number_format($daily_report->total_pendapatan ?: 0, 0, ',', '.') ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h6 class="mb-0">Rata-rata/Transaksi</h6>
                                    <h4 class="mb-0">
                                        Rp <?= $daily_report->total_transaksi > 0 ? number_format($daily_report->rata_rata ?: 0, 0, ',', '.') : '0' ?>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Penjualan Harian -->
                    <div class="table-responsive">
                        <table id="harianTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Waktu</th>
                                    <th>No. Transaksi</th>
                                    <th>Customer</th>
                                    <th>Metode Bayar</th>
                                    <th>Total Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($penjualan_list)): ?>
                                    <?php foreach ($penjualan_list as $index => $item): ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= date('H:i', strtotime($item->tanggal_transaksi)) ?></td>
                                            <td><?= $item->no_transaksi ?></td>
                                            <td><?= $item->nama_pembeli ?: 'Walk-in Customer' ?></td>
                                            <td><?= ucfirst($item->metode_pembayaran) ?></td>
                                            <td>Rp <?= number_format($item->total_harga, 0, ',', '.') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td>1</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Grafik Harian (jika ada data) -->
                    <?php if (!empty($penjualan_list)): ?>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h5>Grafik Penjualan Harian</h5>
                                <canvas id="dailyChart" width="400" height="100"></canvas>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    $('#harianTable').DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "order": [[1, "desc"]],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        }
    });

    // Grafik harian
    <?php if (!empty($penjualan_list)): ?>
        var ctx = document.getElementById('dailyChart').getContext('2d');
        var hourlyData = {};
        
        <?php foreach ($penjualan_list as $item): ?>
            var hour = '<?= date('H', strtotime($item->tanggal_transaksi)) ?>:00';
            if (!hourlyData[hour]) {
                hourlyData[hour] = 0;
            }
            hourlyData[hour] += <?= $item->total_harga ?>;
        <?php endforeach; ?>
        
        var labels = Object.keys(hourlyData).sort();
        var data = labels.map(function(hour) {
            return hourlyData[hour];
        });
        
        var dailyChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Pendapatan: Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    <?php endif; ?>
});
</script>

<style>
@media print {
    .card-header, .card-tools, .btn, .form-inline {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    .info-box {
        border: 1px solid #ddd !important;
        margin-bottom: 10px !important;
    }
    canvas {
        max-height: 300px !important;
    }
}
</style>

<?php $this->load->view('templates/footer'); ?>
