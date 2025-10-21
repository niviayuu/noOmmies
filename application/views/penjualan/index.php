<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-shopping-bag"></i> Data Penjualan</h3>
        <a href="<?php echo site_url('penjualan/form'); ?>" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Tambah Penjualan
        </a>
    </div>
    <div class="card-body">
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
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($penjualan)): ?>
                        <?php $no = 1; foreach ($penjualan as $item): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($item->tanggal_transaksi)); ?></td>
                            <td><?php echo $item->no_transaksi; ?></td>
                            <td><?php echo $item->nama_pembeli ?: 'Walk-in Customer'; ?></td>
                            <td><?php echo ucfirst($item->metode_pembayaran); ?></td>
                            <td>Rp <?php echo number_format($item->total_harga, 0, ',', '.'); ?></td>
                            <td>
                                <span class="badge badge-success">Selesai</span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 5px; align-items: center;">
                                    <a href="<?php echo site_url('penjualan/detail/' . $item->id); ?>" class="btn btn-sm btn-info" title="Detail">
                                        <i class="fas fa-search-plus"></i>
                                    </a>
                                    <a href="<?php echo site_url('penjualan/invoice/' . $item->id); ?>" class="btn btn-sm btn-success" title="Invoice">
                                        <i class="fas fa-receipt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data penjualan</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
