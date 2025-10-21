<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-cubes"></i> Data Bahan Baku</h3>
        <a href="<?php echo site_url('bahan_baku/tambah'); ?>" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Tambah Bahan Baku
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Bahan</th>
                        <th>Supplier</th>
                        <th>Stok</th>
                        <th>Stok Min</th>
                        <th>Harga Satuan</th>
                        <th>Expired</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($bahan_list as $bahan): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><strong><?php echo $bahan->nama_bahan; ?></strong></td>
                        <td><?php echo $bahan->nama_supplier ?: '-'; ?></td>
                        <td>
                            <?php 
                            $stok_class = '';
                            if ($bahan->stok <= $bahan->stok_minimum) {
                                $stok_class = 'style="color: red; font-weight: bold;"';
                            }
                            ?>
                            <span <?php echo $stok_class; ?>>
                                <?php echo $bahan->stok . ' ' . $bahan->satuan; ?>
                            </span>
                        </td>
                        <td><?php echo $bahan->stok_minimum . ' ' . $bahan->satuan; ?></td>
                        <td>Rp <?php echo number_format($bahan->harga_satuan, 0, ',', '.'); ?></td>
                        <td>
                            <?php if ($bahan->tanggal_expired): ?>
                                <?php 
                                $exp_date = strtotime($bahan->tanggal_expired);
                                $today = strtotime(date('Y-m-d'));
                                $diff_days = floor(($exp_date - $today) / (60 * 60 * 24));
                                
                                if ($diff_days <= 3) {
                                    echo '<span style="color: red; font-weight: bold;">' . date('d M Y', $exp_date) . '</span>';
                                } elseif ($diff_days <= 7) {
                                    echo '<span style="color: orange; font-weight: bold;">' . date('d M Y', $exp_date) . '</span>';
                                } else {
                                    echo date('d M Y', $exp_date);
                                }
                                ?>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($bahan->stok <= $bahan->stok_minimum): ?>
                                <span class="badge badge-danger">Stok Menipis</span>
                            <?php elseif ($bahan->stok <= ($bahan->stok_minimum * 2)): ?>
                                <span class="badge badge-warning">Perlu Perhatian</span>
                            <?php else: ?>
                                <span class="badge badge-success">Stok Aman</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="display: flex; gap: 5px; align-items: center;">
                                <a href="<?php echo site_url('bahan_baku/detail/' . $bahan->id); ?>" 
                                   class="btn btn-sm btn-info" title="Detail">
                                    <i class="fas fa-search-plus"></i>
                                </a>
                                <a href="<?php echo site_url('bahan_baku/edit/' . $bahan->id); ?>" 
                                   class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?php echo site_url('bahan_baku/hapus/' . $bahan->id); ?>" 
                                   class="btn btn-sm btn-danger btn-delete" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

