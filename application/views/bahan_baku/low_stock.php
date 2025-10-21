<div class="card">
    <div class="card-header" style="background: #fff3cd;">
        <h3 class="card-title" style="color: #856404;">
            <i class="fas fa-exclamation-triangle"></i> Bahan Stok Menipis
        </h3>
        <a href="<?php echo site_url('bahan_baku'); ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-circle-left"></i> Kembali
        </a>
    </div>
    <div class="card-body">
        <?php if (!empty($bahan_list)): ?>
        <div class="alert alert-warning">
            <i class="fas fa-info-circle"></i>
            Ditemukan <strong><?php echo count($bahan_list); ?></strong> bahan dengan stok menipis atau di bawah stok minimum.
            Segera lakukan pembelian!
        </div>
        
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Bahan</th>
                        <th>Supplier</th>
                        <th>Stok Saat Ini</th>
                        <th>Stok Minimum</th>
                        <th>Selisih</th>
                        <th>Harga Satuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($bahan_list as $bahan): ?>
                    <?php $selisih = $bahan->stok_minimum - $bahan->stok; ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><strong><?php echo $bahan->nama_bahan; ?></strong></td>
                        <td><?php echo $bahan->nama_supplier ?: '-'; ?></td>
                        <td style="color: red; font-weight: bold;">
                            <?php echo $bahan->stok . ' ' . $bahan->satuan; ?>
                        </td>
                        <td><?php echo $bahan->stok_minimum . ' ' . $bahan->satuan; ?></td>
                        <td>
                            <span class="badge badge-danger">
                                <?php echo ($selisih > 0 ? '-' : '+') . abs($selisih) . ' ' . $bahan->satuan; ?>
                            </span>
                        </td>
                        <td>Rp <?php echo number_format($bahan->harga_satuan ?? 0, 0, ',', '.'); ?></td>
                        <td>
                            <div style="display: flex; gap: 5px; align-items: center;">
                                <a href="<?php echo site_url('stok_masuk/tambah'); ?>" 
                                   class="btn btn-sm btn-success" title="Input Stok">
                                    <i class="fas fa-plus-circle"></i> Stok Masuk
                                </a>
                                <a href="<?php echo site_url('bahan_baku/detail/' . $bahan->id); ?>" 
                                   class="btn btn-sm btn-info" title="Detail">
                                    <i class="fas fa-search-plus"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            Tidak ada bahan dengan stok menipis. Semua stok dalam kondisi aman!
        </div>
        <?php endif; ?>
    </div>
</div>

