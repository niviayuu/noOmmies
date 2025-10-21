<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-cubes"></i> Laporan Stok
        </h3>
        <button onclick="window.print()" class="btn btn-success">
            <i class="fas fa-print"></i> Cetak
        </button>
    </div>
    <div class="card-body">
        <!-- Alert Stok Menipis -->
        <?php if (!empty($low_stock)): ?>
            <div class="alert alert-warning mb-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 font-weight-bold">
                            <i class="fas fa-exclamation-triangle"></i> Peringatan Stok Menipis
                        </h6>
                        <p class="mb-0">Ada <?php echo count($low_stock); ?> bahan baku dengan stok menipis</p>
                    </div>
                    <button class="btn btn-outline-warning btn-sm" type="button" data-toggle="collapse" data-target="#lowStockList" aria-expanded="false" aria-controls="lowStockList">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="collapse mt-2" id="lowStockList">
                    <div class="border-top pt-2">
                        <?php foreach ($low_stock as $item): ?>
                            <div class="mb-1">
                                <i class="fas fa-cube text-warning mr-2"></i>
                                <strong><?php echo $item->nama_bahan; ?></strong> - 
                                Stok: <?php echo $item->stok; ?> <?php echo $item->satuan; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Alert Mendekati Expired -->
        <?php if (!empty($near_expiry)): ?>
            <div class="alert alert-danger mb-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-1 font-weight-bold">
                            <i class="fas fa-hourglass-half"></i> Peringatan Mendekati Expired
                        </h6>
                        <p class="mb-0">Ada <?php echo count($near_expiry); ?> bahan baku yang akan expired dalam 7 hari</p>
                    </div>
                    <button class="btn btn-outline-danger btn-sm" type="button" data-toggle="collapse" data-target="#expiredList" aria-expanded="false" aria-controls="expiredList">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="collapse mt-2" id="expiredList">
                    <div class="border-top pt-2">
                        <?php foreach ($near_expiry as $item): ?>
                            <div class="mb-1">
                                <i class="fas fa-calendar-times text-danger mr-2"></i>
                                <strong><?php echo $item->nama_bahan; ?></strong> - 
                                Expired: <?php echo date('d/m/Y', strtotime($item->tanggal_expired)); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Ringkasan -->
        <div class="row mb-4" style="display: flex; gap: 15px;">
            <div class="col-md-3" style="flex: 1;">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-cubes fa-2x mr-3"></i>
                            <div>
                                <h6 class="mb-0">Total Bahan Baku</h6>
                                <h4 class="mb-0"><?php echo count($bahan_list); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3" style="flex: 1;">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle fa-2x mr-3"></i>
                            <div>
                                <h6 class="mb-0">Stok Menipis</h6>
                                <h4 class="mb-0"><?php echo count($low_stock); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3" style="flex: 1;">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-hourglass-half fa-2x mr-3"></i>
                            <div>
                                <h6 class="mb-0">Mendekati Expired</h6>
                                <h4 class="mb-0"><?php echo count($near_expiry); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3" style="flex: 1;">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle fa-2x mr-3"></i>
                            <div>
                                <h6 class="mb-0">Stok Normal</h6>
                                <h4 class="mb-0"><?php echo count($bahan_list) - count($low_stock); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Stok -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Bahan</th>
                        <th>Stok</th>
                        <th>Satuan</th>
                        <th>Harga Satuan</th>
                        <th>Tanggal Expired</th>
                        <th>Supplier</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($bahan_list)): ?>
                        <?php $no = 1; foreach ($bahan_list as $item): ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $item->nama_bahan; ?></td>
                                <td><?php echo number_format($item->stok, 0, ',', '.'); ?></td>
                                <td><?php echo $item->satuan; ?></td>
                                <td>Rp <?php echo number_format($item->harga_satuan, 0, ',', '.'); ?></td>
                                <td>
                                    <?php if ($item->tanggal_expired): ?>
                                        <?php echo date('d/m/Y', strtotime($item->tanggal_expired)); ?>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $item->nama_supplier ?: '-'; ?></td>
                                <td>
                                    <?php 
                                    $is_low_stock = false;
                                    $is_near_expiry = false;
                                    
                                    foreach ($low_stock as $low) {
                                        if ($low->id == $item->id) {
                                            $is_low_stock = true;
                                            break;
                                        }
                                    }
                                    
                                    foreach ($near_expiry as $exp) {
                                        if ($exp->id == $item->id) {
                                            $is_near_expiry = true;
                                            break;
                                        }
                                    }
                                    
                                    if ($is_near_expiry): ?>
                                        <span class="badge badge-danger">Expired</span>
                                    <?php elseif ($is_low_stock): ?>
                                        <span class="badge badge-warning">Menipis</span>
                                    <?php else: ?>
                                        <span class="badge badge-success">Normal</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data stok</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
/* Print styles */
@media print {
    .card-header, .btn {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    .alert {
        border: 1px solid #ddd !important;
        margin-bottom: 10px !important;
        background: #f8f9fa !important;
    }
    .collapse {
        display: block !important;
    }
}
</style>
