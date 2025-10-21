<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-arrow-circle-down"></i> Data Stok Masuk (Pembelian)</h3>
        <a href="<?php echo site_url('stok_masuk/tambah'); ?>" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Input Stok Masuk
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Bahan</th>
                        <th>Supplier</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Total Harga</th>
                        <th>No Faktur</th>
                        <th>Dibuat Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($stok_list as $stok): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo date('d M Y', strtotime($stok->tanggal_masuk)); ?></td>
                        <td><strong><?php echo $stok->nama_bahan; ?></strong></td>
                        <td><?php echo $stok->nama_supplier ?: '-'; ?></td>
                        <td>
                            <span style="color: var(--success-color); font-weight: bold;">
                                <?php echo $stok->jumlah . ' ' . $stok->satuan; ?>
                            </span>
                        </td>
                        <td>Rp <?php echo number_format($stok->harga_satuan, 0, ',', '.'); ?></td>
                        <td>
                            <strong style="color: var(--primary-color);">
                                Rp <?php echo number_format($stok->total_harga, 0, ',', '.'); ?>
                            </strong>
                        </td>
                        <td><?php echo $stok->no_faktur ?: '-'; ?></td>
                        <td><?php echo $stok->nama_lengkap ?: '-'; ?></td>
                        <td>
                            <div style="display: flex; gap: 5px; align-items: center;">
                                <a href="<?php echo site_url('stok_masuk/detail/' . $stok->id); ?>" 
                                   class="btn btn-sm btn-info" title="Detail">
                                    <i class="fas fa-search-plus"></i>
                                </a>
                                <a href="<?php echo site_url('stok_masuk/hapus/' . $stok->id); ?>" 
                                   class="btn btn-sm btn-danger btn-delete" title="Hapus"
                                   onclick="return confirm('Hapus stok masuk ini? Stok bahan akan dikurangi otomatis!');">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr style="background: #f8f9fa; font-weight: bold;">
                        <td colspan="6" style="text-align: right; padding: 15px;">TOTAL:</td>
                        <td colspan="4" style="padding: 15px; font-size: 16px; color: var(--success-color);">
                            Rp <?php 
                            $total = 0;
                            foreach ($stok_list as $s) {
                                $total += $s->total_harga;
                            }
                            echo number_format($total, 0, ',', '.'); 
                            ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

