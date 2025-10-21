<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-shopping-bag"></i> Laporan Pembelian
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
            <div class="col-md-4" style="flex: 1;">
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
            <div class="col-md-4" style="flex: 1;">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-dollar-sign fa-2x mr-3"></i>
                            <div>
                                <h6 class="mb-0">Total Pembelian</h6>
                                <h4 class="mb-0">Rp <?php echo number_format($total_pembelian, 0, ',', '.'); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="flex: 1;">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-receipt fa-2x mr-3"></i>
                            <div>
                                <h6 class="mb-0">Total Transaksi</h6>
                                <h4 class="mb-0"><?php echo count($pembelian_list); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Pembelian -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Bahan Baku</th>
                        <th>Supplier</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Harga Satuan</th>
                        <th>Total Harga</th>
                        <th>No. Faktur</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pembelian_list)): ?>
                        <?php $no = 1; foreach ($pembelian_list as $item): ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($item->tanggal_masuk)); ?></td>
                                <td><?php echo $item->nama_bahan; ?></td>
                                <td><?php echo $item->nama_supplier ?: '-'; ?></td>
                                <td><?php echo number_format($item->jumlah, 0, ',', '.'); ?></td>
                                <td><?php echo $item->satuan; ?></td>
                                <td>Rp <?php echo number_format($item->harga_satuan, 0, ',', '.'); ?></td>
                                <td>Rp <?php echo number_format($item->total_harga, 0, ',', '.'); ?></td>
                                <td><?php echo $item->no_faktur ?: '-'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data pembelian</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
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
