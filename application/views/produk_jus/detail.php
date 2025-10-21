<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-search-plus"></i> Detail Produk</h3>
        <div style="display: flex; gap: 8px; align-items: center;">
            <a href="<?php echo site_url('produk_jus/resep/' . $produk->id); ?>" class="btn btn-success">
                <i class="fas fa-clipboard-list"></i> Kelola Resep
            </a>
            <a href="<?php echo site_url('produk_jus/edit/' . $produk->id); ?>" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="<?php echo site_url('produk_jus'); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-circle-left"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px;">
            <!-- Product Image -->
            <div style="text-align: center;">
                <div style="font-size: 120px; color: var(--primary-color); margin-bottom: 20px;">
                    <i class="fas fa-wine-bottle"></i>
                </div>
                <h3 style="color: var(--dark-color);"><?php echo $produk->nama_produk; ?></h3>
                <p style="color: #6c757d; margin: 10px 0;">
                    <?php echo ucfirst($produk->kategori); ?> - <?php echo ucfirst($produk->ukuran); ?>
                </p>
                <h2 style="color: var(--success-color); margin: 20px 0;">
                    Rp <?php echo number_format($produk->harga, 0, ',', '.'); ?>
                </h2>
                <?php if (isset($produk->status)): ?>
                <p>
                    <?php if ($produk->status == 'active'): ?>
                    <span class="badge badge-success" style="font-size: 14px; padding: 8px 15px;">Produk Aktif</span>
                    <?php else: ?>
                    <span class="badge badge-secondary" style="font-size: 14px; padding: 8px 15px;">Tidak Aktif</span>
                    <?php endif; ?>
                </p>
                <?php endif; ?>
            </div>
            
            <!-- Product Info -->
            <div>
                <h4 style="margin-bottom: 20px; color: var(--dark-color);">
                    <i class="fas fa-info-circle"></i> Informasi Produk
                </h4>
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 150px; padding: 10px; font-weight: 600;">Nama Produk</td>
                        <td style="padding: 10px;"><?php echo $produk->nama_produk; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; font-weight: 600;">Kategori</td>
                        <td style="padding: 10px;">
                            <span class="badge badge-info"><?php echo ucfirst($produk->kategori); ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; font-weight: 600;">Ukuran</td>
                        <td style="padding: 10px;"><?php echo ucfirst($produk->ukuran); ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; font-weight: 600;">Harga</td>
                        <td style="padding: 10px; font-size: 18px; font-weight: bold; color: var(--success-color);">
                            Rp <?php echo number_format($produk->harga, 0, ',', '.'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; font-weight: 600;">Deskripsi</td>
                        <td style="padding: 10px;"><?php echo $produk->deskripsi ?: '-'; ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; font-weight: 600;">Dibuat Pada</td>
                        <td style="padding: 10px;"><?php echo date('d M Y H:i', strtotime($produk->created_at)); ?></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; font-weight: 600;">Terakhir Diupdate</td>
                        <td style="padding: 10px;"><?php echo date('d M Y H:i', strtotime($produk->updated_at)); ?></td>
                    </tr>
                </table>
            </div>
        </div>
        
        <!-- Recipe Section -->
        <?php if (!empty($produk->resep)): ?>
        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #dee2e6;">
            <h4 style="margin-bottom: 20px; color: var(--dark-color);">
                <i class="fas fa-clipboard-list"></i> Resep / Komposisi Bahan
            </h4>
            <div class="table-responsive">
                <table style="width: 100%;">
                    <thead>
                        <tr style="background: #f8f9fa;">
                            <th style="padding: 12px;">No</th>
                            <th style="padding: 12px;">Nama Bahan</th>
                            <th style="padding: 12px; text-align: right;">Jumlah</th>
                            <th style="padding: 12px;">Satuan</th>
                            <th style="padding: 12px;">Stok Tersedia</th>
                            <th style="padding: 12px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($produk->resep as $resep): ?>
                        <tr>
                            <td style="padding: 12px;"><?php echo $no++; ?></td>
                            <td style="padding: 12px;"><strong><?php echo $resep->nama_bahan; ?></strong></td>
                            <td style="padding: 12px; text-align: right;"><?php echo $resep->jumlah; ?></td>
                            <td style="padding: 12px;"><?php echo strtoupper($resep->satuan); ?></td>
                            <td style="padding: 12px;"><?php echo $resep->stok . ' ' . strtoupper($resep->satuan); ?></td>
                            <td style="padding: 12px;">
                                <?php if ($resep->stok >= $resep->jumlah): ?>
                                <span class="badge badge-success">Tersedia</span>
                                <?php else: ?>
                                <span class="badge badge-danger">Stok Kurang</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php else: ?>
        <div style="margin-top: 30px; padding: 20px; background: #fff3cd; border: 1px solid #ffc107; border-radius: 6px;">
            <i class="fas fa-exclamation-triangle" style="color: #856404;"></i>
            <strong>Resep belum diatur!</strong> 
            <a href="<?php echo site_url('produk_jus/resep/' . $produk->id); ?>">Klik di sini untuk menambahkan resep</a>
        </div>
        <?php endif; ?>
    </div>
</div>

