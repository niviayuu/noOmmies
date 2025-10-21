<div class="card">
    <div class="card-header" style="background: #f8d7da;">
        <h3 class="card-title" style="color: #721c24;">
            <i class="fas fa-hourglass-half"></i> Bahan Mendekati Expired
        </h3>
        <a href="<?php echo site_url('bahan_baku'); ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-circle-left"></i> Kembali
        </a>
    </div>
    <div class="card-body">
        <?php if (!empty($bahan_list)): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            Ditemukan <strong><?php echo count($bahan_list); ?></strong> bahan yang akan expired dalam 7 hari ke depan.
            Segera gunakan atau buang!
        </div>
        
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Bahan</th>
                        <th>Supplier</th>
                        <th>Tanggal Expired</th>
                        <th>Hari Tersisa</th>
                        <th>Stok</th>
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
                        <td><?php echo date('d M Y', strtotime($bahan->tanggal_expired)); ?></td>
                        <td>
                            <?php 
                            $color = $bahan->hari_tersisa <= 1 ? 'red' : ($bahan->hari_tersisa <= 3 ? 'orange' : '#856404');
                            ?>
                            <span style="color: <?php echo $color; ?>; font-weight: bold;">
                                <?php echo $bahan->hari_tersisa; ?> hari
                            </span>
                        </td>
                        <td><?php echo $bahan->stok . ' ' . $bahan->satuan; ?></td>
                        <td>
                            <?php if ($bahan->hari_tersisa <= 1): ?>
                                <span class="badge badge-danger">Segera Expired!</span>
                            <?php elseif ($bahan->hari_tersisa <= 3): ?>
                                <span class="badge badge-danger">Kritis</span>
                            <?php else: ?>
                                <span class="badge badge-warning">Mendekati Expired</span>
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
            Tidak ada bahan yang mendekati expired. Semua bahan masih aman!
        </div>
        <?php endif; ?>
    </div>
</div>

