<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-chart-line"></i> Laporan Waste
        </h3>
        <div class="card-tools">
            <button onclick="window.print()" class="btn btn-success btn-sm">
                <i class="fas fa-print"></i> Cetak
            </button>
            <a href="<?= base_url('waste/export?format=excel') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Filter -->
        <div class="row mb-3">
            <div class="col-md-12">
                <form method="GET" action="<?= base_url('laporan/waste') ?>" class="form-inline">
                    <div class="form-group mr-3">
                        <label for="start_date" class="mr-2">
                            <i class="fas fa-calendar-days"></i> Dari Tanggal:
                        </label>
                        <input type="date" 
                               class="form-control" 
                               id="start_date" 
                               name="start_date" 
                               value="<?= $this->input->get('start_date') ?: date('Y-m-01') ?>">
                    </div>
                    <div class="form-group mr-3">
                        <label for="end_date" class="mr-2">
                            <i class="fas fa-calendar-days"></i> Sampai Tanggal:
                        </label>
                        <input type="date" 
                               class="form-control" 
                               id="end_date" 
                               name="end_date" 
                               value="<?= $this->input->get('end_date') ?: date('Y-m-d') ?>">
                    </div>
                    <div class="form-group mr-3">
                        <label for="category" class="mr-2">
                            <i class="fas fa-tags"></i> Kategori:
                        </label>
                        <select class="form-control" id="category" name="category">
                            <option value="">Semua Kategori</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category->id ?>" 
                                        <?= $this->input->get('category') == $category->id ? 'selected' : '' ?>>
                                    <?= $category->nama_kategori ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="<?= base_url('laporan/waste') ?>" class="btn btn-secondary ml-2">
                        <i class="fas fa-arrow-rotate-left"></i> Reset
                    </a>
                </form>
            </div>
        </div>

        <!-- Ringkasan -->
        <div class="row mb-4" style="display: flex; gap: 15px;">
            <div class="col-md-3" style="flex: 1;">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-trash-can fa-2x mr-3"></i>
                            <div>
                                <h6 class="mb-0">Total Waste</h6>
                                <h4 class="mb-0"><?= $statistics['total_waste'] ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3" style="flex: 1;">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-hourglass-half fa-2x mr-3"></i>
                            <div>
                                <h6 class="mb-0">Pending</h6>
                                <h4 class="mb-0"><?= $statistics['pending_waste'] ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3" style="flex: 1;">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-circle-check fa-2x mr-3"></i>
                            <div>
                                <h6 class="mb-0">Disetujui</h6>
                                <h4 class="mb-0"><?= $statistics['approved_waste'] ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3" style="flex: 1;">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-money-bill-wave fa-2x mr-3"></i>
                            <div>
                                <h6 class="mb-0">Total Nilai</h6>
                                <h4 class="mb-0">Rp <?= number_format($statistics['total_value'], 0, ',', '.') ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-donut"></i> Grafik Waste per Kategori
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="wasteChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-trophy"></i> Kategori Terbanyak
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($top_categories)): ?>
                            <?php foreach ($top_categories as $index => $category): ?>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <span class="badge badge-primary"><?= $index + 1 ?></span>
                                        <?= $category->nama_kategori ?>
                                    </div>
                                    <div class="text-right">
                                        <small class="text-muted"><?= $category->total_record ?> item</small><br>
                                        <strong>Rp <?= number_format($category->total_nilai, 0, ',', '.') ?></strong>
                                    </div>
                                </div>
                                <?php if ($index < count($top_categories) - 1): ?>
                                    <hr class="my-2">
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted text-center">Tidak ada data</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Laporan -->
        <?php if (!empty($waste_records)): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Nama Item</th>
                            <th>Jumlah</th>
                            <th>Harga/Satuan</th>
                            <th>Total Nilai</th>
                            <th>Status</th>
                            <th>Dibuat Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($waste_records as $index => $waste): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= date('d/m/Y', strtotime($waste->tanggal_waste)) ?></td>
                                <td>
                                    <span class="badge badge-secondary"><?= $waste->nama_kategori ?></span>
                                </td>
                                <td><?= $waste->nama_item ?></td>
                                <td><?= number_format($waste->jumlah_waste, 2) ?> <?= $waste->satuan ?></td>
                                <td>Rp <?= number_format($waste->harga_per_satuan, 0, ',', '.') ?></td>
                                <td>
                                    <span class="text-danger font-weight-bold">
                                        Rp <?= number_format($waste->total_nilai_waste, 0, ',', '.') ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($waste->status == 'pending'): ?>
                                        <span class="badge badge-warning">Pending</span>
                                    <?php elseif ($waste->status == 'approved'): ?>
                                        <span class="badge badge-success">Disetujui</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Ditolak</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $waste->created_by_name ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="table-info">
                            <th colspan="6" class="text-right">Total Nilai Waste:</th>
                            <th class="text-danger font-weight-bold">
                                Rp <?= number_format($statistics['total_value'], 0, ',', '.') ?>
                            </th>
                            <th colspan="2"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-4">
                <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada data waste</h5>
                <p class="text-muted">Belum ada data waste untuk periode yang dipilih</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    // Waste Chart
    var ctx = document.getElementById('wasteChart').getContext('2d');
    var wasteChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [
                <?php foreach ($top_categories as $category): ?>
                    '<?= $category->nama_kategori ?>',
                <?php endforeach; ?>
            ],
            datasets: [{
                data: [
                    <?php foreach ($top_categories as $category): ?>
                        <?= $category->total_nilai ?>,
                    <?php endforeach; ?>
                ],
                backgroundColor: [
                    '#007bff',
                    '#28a745',
                    '#ffc107',
                    '#dc3545',
                    '#17a2b8',
                    '#6f42c1',
                    '#fd7e14',
                    '#20c997'
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var label = context.label || '';
                            var value = context.parsed;
                            return label + ': Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
});
</script>

<style>
@media print {
    .card-header, .btn, .form-inline {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    .table {
        font-size: 12px;
    }
    .chart-container {
        display: none !important;
    }
}
</style>
