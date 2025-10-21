<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-info-circle"></i> Detail Stok Masuk</h3>
        <div>
            <a href="<?php echo site_url('stok_masuk'); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 30px;">
            <!-- Transaction Info -->
            <div>
                <h4 style="margin-bottom: 20px; color: var(--dark-color);">
                    <i class="fas fa-file-alt"></i> Informasi Transaksi
                </h4>
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 150px; padding: 10px; font-weight: 600;">Tanggal Masuk</td>
                        <td style="padding: 10px;"><?php echo date('d M Y', strtotime($stok->tanggal_masuk)); ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; font-weight: 600;">No. Faktur</td>
                        <td style="padding: 10px;"><?php echo $stok->no_faktur ?: '-'; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; font-weight: 600;">Supplier</td>
                        <td style="padding: 10px;"><?php echo $stok->nama_supplier ?: '-'; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; font-weight: 600;">Dibuat Oleh</td>
                        <td style="padding: 10px;"><?php echo $stok->nama_lengkap ?: '-'; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; font-weight: 600;">Tanggal Input</td>
                        <td style="padding: 10px;"><?php echo date('d M Y H:i', strtotime($stok->created_at)); ?></td>
                    </tr>
                </table>
            </div>
            
            <!-- Item Info -->
            <div>
                <h4 style="margin-bottom: 20px; color: var(--dark-color);">
                    <i class="fas fa-box"></i> Informasi Bahan
                </h4>
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 150px; padding: 10px; font-weight: 600;">Nama Bahan</td>
                        <td style="padding: 10px;"><strong><?php echo $stok->nama_bahan; ?></strong></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; font-weight: 600;">Jumlah Masuk</td>
                        <td style="padding: 10px;">
                            <span style="font-size: 18px; font-weight: bold; color: var(--success-color);">
                                <?php echo $stok->jumlah . ' ' . strtoupper($stok->satuan); ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; font-weight: 600;">Tanggal Expired</td>
                        <td style="padding: 10px;">
                            <?php if ($stok->tanggal_expired): ?>
                                <?php echo date('d M Y', strtotime($stok->tanggal_expired)); ?>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; font-weight: 600;">Keterangan</td>
                        <td style="padding: 10px;"><?php echo $stok->keterangan ?: '-'; ?></td>
                    </tr>
                </table>
            </div>
        </div>
        
        <!-- Financial Info -->
        <div style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #dee2e6;">
            <h4 style="margin-bottom: 20px; color: var(--dark-color);">
                <i class="fas fa-money-bill-wave"></i> Informasi Harga
            </h4>
            <table style="width: 100%; max-width: 500px;">
                <tr>
                    <td style="width: 200px; padding: 12px; font-weight: 600;">Harga Satuan</td>
                    <td style="padding: 12px; text-align: right; font-size: 16px;">
                        Rp <?php echo number_format($stok->harga_satuan, 0, ',', '.'); ?>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 12px; font-weight: 600;">Jumlah</td>
                    <td style="padding: 12px; text-align: right; font-size: 16px;">
                        <?php echo $stok->jumlah . ' ' . strtoupper($stok->satuan); ?>
                    </td>
                </tr>
                <tr style="background: #f8f9fa; font-weight: bold; border-top: 2px solid #dee2e6;">
                    <td style="padding: 15px; font-size: 18px;">TOTAL HARGA</td>
                    <td style="padding: 15px; text-align: right; font-size: 20px; color: var(--success-color);">
                        Rp <?php echo number_format($stok->total_harga, 0, ',', '.'); ?>
                    </td>
                </tr>
            </table>
        </div>
        
        <!-- Success Message -->
        <div style="margin-top: 30px; padding: 20px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 6px;">
            <h5 style="margin: 0 0 10px 0; color: #155724;">
                <i class="fas fa-check-circle"></i> Status Stok
            </h5>
            <p style="margin: 0; color: #155724;">
                Stok bahan <strong><?php echo $stok->nama_bahan; ?></strong> telah ditambahkan sebanyak 
                <strong><?php echo $stok->jumlah . ' ' . strtoupper($stok->satuan); ?></strong> pada tanggal 
                <strong><?php echo date('d M Y', strtotime($stok->tanggal_masuk)); ?></strong>
            </p>
        </div>
    </div>
</div>

