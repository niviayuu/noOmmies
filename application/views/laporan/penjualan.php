<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-chart-bar"></i> Laporan Penjualan
        </h3>
        <button onclick="window.print()" class="btn btn-success">
            <i class="fas fa-print"></i> Cetak
        </button>
    </div>
    <div class="card-body">
        <!-- Filter Periode -->
        <div class="row mb-3">
            <div class="col-md-12">
                <form method="GET" class="form-inline">
                    <div class="form-group mr-3">
                        <label for="start_date" class="mr-2">Dari Tanggal:</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" 
                               value="<?php echo $start_date; ?>">
                    </div>
                    <div class="form-group mr-3">
                        <label for="end_date" class="mr-2">Sampai Tanggal:</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" 
                               value="<?php echo $end_date; ?>">
                    </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Filter
                            </button>
                </form>
            </div>
        </div>

        <!-- Ringkasan -->
        <div class="row mb-4" style="display: flex; gap: 15px;">
            <div class="col-md-3" style="flex: 1;">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar-alt fa-2x mr-3"></i>
                            <div>
                                <h6 class="mb-0">Periode</h6>
                                <small><?php echo date('d/m/Y', strtotime($start_date)); ?> - <?php echo date('d/m/Y', strtotime($end_date)); ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3" style="flex: 1;">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-receipt fa-2x mr-3"></i>
                            <div>
                                <h6 class="mb-0">Total Transaksi</h6>
                                <h4 class="mb-0"><?php echo $total_transaksi; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3" style="flex: 1;">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-dollar-sign fa-2x mr-3"></i>
                            <div>
                                <h6 class="mb-0">Total Pendapatan</h6>
                                <h4 class="mb-0">Rp <?php echo number_format($total_pendapatan, 0, ',', '.'); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3" style="flex: 1;">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-chart-line fa-2x mr-3"></i>
                            <div>
                                <h6 class="mb-0">Rata-rata/Transaksi</h6>
                                <h4 class="mb-0">Rp <?php echo $total_transaksi > 0 ? number_format($total_pendapatan / $total_transaksi, 0, ',', '.') : '0'; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Penjualan -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>No. Transaksi</th>
                        <th>Customer</th>
                        <th>Metode Bayar</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($penjualan_list)): ?>
                        <?php $no = 1; foreach ($penjualan_list as $item): ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($item->tanggal_transaksi)); ?></td>
                                <td><?php echo $item->no_transaksi; ?></td>
                                <td><?php echo $item->nama_pembeli ?: 'Walk-in Customer'; ?></td>
                                <td><?php echo ucfirst($item->metode_pembayaran); ?></td>
                                <td>Rp <?php echo number_format($item->total_harga, 0, ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data penjualan</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Produk Terlaris -->
        <?php if (!empty($best_selling)): ?>
            <div class="row mt-4">
                <div class="col-md-12">
                            <h5>
                                <i class="fas fa-medal"></i> Produk Terlaris
                            </h5>
                     <div class="table-responsive">
                         <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Total Terjual</th>
                                    <th>Total Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($best_selling as $produk): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $produk->nama_produk; ?></td>
                                        <td><?php echo ucfirst($produk->kategori); ?></td>
                                        <td><?php echo $produk->total_terjual; ?> pcs</td>
                                        <td>Rp <?php echo number_format($produk->total_pendapatan, 0, ',', '.'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
@media print {
    .card-header, .btn, .form-inline {
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
}
</style>
