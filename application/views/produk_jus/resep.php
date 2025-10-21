<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-clipboard-list"></i> Resep: <?php echo $produk->nama_produk; ?>
        </h3>
        <a href="<?php echo site_url('produk_jus'); ?>" class="btn btn-secondary" style="margin-left: 10px;">
            <i class="fas fa-arrow-circle-left"></i> Kembali
        </a>
    </div>
    <div class="card-body">
        <!-- Product Info -->
        <div style="padding: 15px; background: #f8f9fa; border-radius: 6px; margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h4 style="margin: 0; color: var(--dark-color);"><?php echo $produk->nama_produk; ?></h4>
                    <p style="margin: 5px 0 0; color: #6c757d;">
                        <?php echo ucfirst($produk->kategori); ?> - <?php echo ucfirst($produk->ukuran); ?> - 
                        <strong>Rp <?php echo number_format($produk->harga, 0, ',', '.'); ?></strong>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Add Recipe Form -->
        <div class="card" style="margin-bottom: 30px; background: #e7f3ff; border: 1px solid #b3d9ff;">
            <div class="card-header" style="background: #cce5ff;">
                <h4 style="margin: 0; color: var(--dark-color);">
                    <i class="fas fa-plus-circle"></i> Tambah Bahan ke Resep
                </h4>
            </div>
            <div class="card-body">
                <?php echo form_open('produk_jus/tambah_resep/' . $produk->id); ?>
                <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: 15px; align-items: end;">
                    <div class="form-group" style="margin: 0;">
                        <label class="form-label">Bahan <span style="color: red;">*</span></label>
                        <select name="bahan_id" class="form-control" required>
                            <option value="">-- Pilih Bahan --</option>
                            <?php foreach ($bahan_list as $id => $nama): ?>
                            <option value="<?php echo $id; ?>"><?php echo $nama; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group" style="margin: 0;">
                        <label class="form-label">Jumlah <span style="color: red;">*</span></label>
                        <input type="number" name="jumlah" class="form-control" 
                               step="0.01" min="0" required placeholder="100">
                    </div>
                    
                    <div class="form-group" style="margin: 0;">
                        <label class="form-label">Satuan <span style="color: red;">*</span></label>
                        <select name="satuan" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="kg">Kg</option>
                            <option value="gram">Gram</option>
                            <option value="liter">Liter</option>
                            <option value="ml">ML</option>
                            <option value="pcs">Pcs</option>
                            <option value="pack">Pack</option>
                        </select>
                    </div>
                    
                    <div class="form-group" style="margin: 0;">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" placeholder="Optional">
                    </div>
                    
                    <div>
                        <button type="submit" class="btn btn-success" style="white-space: nowrap;">
                            <i class="fas fa-plus-circle"></i> Tambah
                        </button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
        
        <!-- Recipe List -->
        <h4 style="margin-bottom: 15px; color: var(--dark-color);">
            <i class="fas fa-list-alt"></i> Daftar Bahan dalam Resep
        </h4>
        
        <?php if (!empty($resep)): ?>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr style="background: #f8f9fa;">
                        <th style="padding: 12px;">No</th>
                        <th style="padding: 12px;">Nama Bahan</th>
                        <th style="padding: 12px; text-align: right;">Jumlah</th>
                        <th style="padding: 12px;">Satuan</th>
                        <th style="padding: 12px;">Stok Tersedia</th>
                        <th style="padding: 12px;">Keterangan</th>
                        <th style="padding: 12px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($resep as $item): ?>
                    <tr>
                        <td style="padding: 12px;"><?php echo $no++; ?></td>
                        <td style="padding: 12px;"><strong><?php echo $item->nama_bahan; ?></strong></td>
                        <td style="padding: 12px; text-align: right;"><?php echo $item->jumlah; ?></td>
                        <td style="padding: 12px;"><?php echo strtoupper($item->satuan); ?></td>
                        <td style="padding: 12px;">
                            <?php 
                            $cukup = $item->stok >= $item->jumlah;
                            $color = $cukup ? 'green' : 'red';
                            ?>
                            <span style="color: <?php echo $color; ?>; font-weight: bold;">
                                <?php echo $item->stok . ' ' . strtoupper($item->satuan); ?>
                            </span>
                            <?php if (!$cukup): ?>
                            <span class="badge badge-danger" style="margin-left: 5px;">Kurang</span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 12px;"><?php echo $item->keterangan ?: '-'; ?></td>
                        <td style="padding: 12px; text-align: center;">
                            <a href="<?php echo site_url('produk_jus/hapus_resep/' . $item->id . '/' . $produk->id); ?>" 
                               class="btn btn-sm btn-danger btn-delete" title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Summary -->
        <div style="margin-top: 20px; padding: 15px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 6px;">
            <strong><i class="fas fa-check-circle"></i> Total Bahan:</strong> 
            <?php echo count($resep); ?> item
        </div>
        
        <?php else: ?>
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            Belum ada bahan dalam resep. Gunakan form di atas untuk menambahkan bahan.
        </div>
        <?php endif; ?>
    </div>
</div>

