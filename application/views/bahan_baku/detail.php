<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-search-plus"></i> Detail Bahan Baku</h3>
        <div>
            <a href="<?php echo site_url('bahan_baku/edit/' . $bahan->id); ?>" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="<?php echo site_url('bahan_baku'); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-circle-left"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 30px;">
            <div>
                <h4 style="margin-bottom: 20px; color: var(--dark-color);">Informasi Bahan</h4>
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 150px; padding: 10px; font-weight: 600;">Nama Bahan</td>
                        <td style="padding: 10px;"><?php echo $bahan->nama_bahan; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; font-weight: 600;">Supplier</td>
                        <td style="padding: 10px;"><?php echo $bahan->nama_supplier ?: '-'; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; font-weight: 600;">Satuan</td>
                        <td style="padding: 10px;"><?php echo strtoupper($bahan->satuan); ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; font-weight: 600;">Keterangan</td>
                        <td style="padding: 10px;"><?php echo $bahan->keterangan ?: '-'; ?></td>
                    </tr>
                </table>
            </div>
            
            <div>
                <h4 style="margin-bottom: 20px; color: var(--dark-color);">Informasi Stok</h4>
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 150px; padding: 10px; font-weight: 600;">Stok Saat Ini</td>
                        <td style="padding: 10px;">
                            <span style="font-size: 18px; font-weight: bold; color: var(--primary-color);">
                                <?php echo $bahan->stok . ' ' . $bahan->satuan; ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; font-weight: 600;">Stok Minimum</td>
                        <td style="padding: 10px;"><?php echo $bahan->stok_minimum . ' ' . $bahan->satuan; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; font-weight: 600;">Harga Satuan</td>
                        <td style="padding: 10px;">Rp <?php echo number_format($bahan->harga_satuan ?? 0, 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; font-weight: 600;">Tanggal Expired</td>
                        <td style="padding: 10px;">
                            <?php if ($bahan->tanggal_expired): ?>
                                <?php echo date('d M Y', strtotime($bahan->tanggal_expired)); ?>
                                <?php 
                                $exp_date = strtotime($bahan->tanggal_expired);
                                $today = strtotime(date('Y-m-d'));
                                $diff_days = floor(($exp_date - $today) / (60 * 60 * 24));
                                
                                if ($diff_days < 0) {
                                    echo '<span class="badge badge-danger">Sudah Expired</span>';
                                } elseif ($diff_days <= 3) {
                                    echo '<span class="badge badge-danger">Segera Expired (' . $diff_days . ' hari)</span>';
                                } elseif ($diff_days <= 7) {
                                    echo '<span class="badge badge-warning">Mendekati Expired (' . $diff_days . ' hari)</span>';
                                }
                                ?>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; font-weight: 600;">Status Stok</td>
                        <td style="padding: 10px;">
                            <?php if ($bahan->stok <= $bahan->stok_minimum): ?>
                                <span class="badge badge-danger">Stok Menipis</span>
                            <?php elseif ($bahan->stok <= ($bahan->stok_minimum * 2)): ?>
                                <span class="badge badge-warning">Perlu Perhatian</span>
                            <?php else: ?>
                                <span class="badge badge-success">Stok Aman</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #dee2e6;">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 150px; padding: 10px; font-weight: 600;">Dibuat Pada</td>
                    <td style="padding: 10px;"><?php echo date('d M Y H:i', strtotime($bahan->created_at)); ?></td>
                </tr>
                <tr>
                    <td style="padding: 10px; font-weight: 600;">Terakhir Diupdate</td>
                    <td style="padding: 10px;"><?php echo date('d M Y H:i', strtotime($bahan->updated_at)); ?></td>
                </tr>
            </table>
        </div>
        
        <?php if (!empty($stok_history)): ?>
        <div style="margin-top: 30px;">
            <h4 style="margin-bottom: 15px; color: var(--dark-color);">
                <i class="fas fa-clock-rotate-left"></i> Riwayat Stok Masuk
            </h4>
            <div class="table-responsive">
                <table style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Supplier</th>
                            <th style="text-align: right;">Jumlah</th>
                            <th style="text-align: right;">Harga</th>
                            <th style="text-align: right;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stok_history as $history): ?>
                        <tr>
                            <td><?php echo date('d M Y', strtotime($history->tanggal_masuk)); ?></td>
                            <td><?php echo $history->nama_supplier ?: '-'; ?></td>
                            <td style="text-align: right;"><?php echo $history->jumlah; ?></td>
                            <td style="text-align: right;">Rp <?php echo number_format($history->harga_satuan ?? 0, 0, ',', '.'); ?></td>
                            <td style="text-align: right;">Rp <?php echo number_format($history->total_harga ?? 0, 0, ',', '.'); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

