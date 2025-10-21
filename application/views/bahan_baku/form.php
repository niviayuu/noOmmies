<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-<?php echo isset($bahan) ? 'edit' : 'plus-circle'; ?>"></i>
            <?php echo isset($bahan) ? 'Edit' : 'Tambah'; ?> Bahan Baku
        </h3>
    </div>
    <div class="card-body">
        <?php echo form_open(isset($bahan) ? 'bahan_baku/edit/' . $bahan->id : 'bahan_baku/tambah'); ?>
        
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <div class="form-group">
                <label class="form-label"><i class="fas fa-cubes"></i> Nama Bahan <span style="color: red;">*</span></label>
                <input type="text" name="nama_bahan" class="form-control" 
                       value="<?php echo isset($bahan) ? $bahan->nama_bahan : set_value('nama_bahan'); ?>" 
                       placeholder="Contoh: Buah Jeruk" required>
                <?php echo form_error('nama_bahan', '<small class="text-danger">', '</small>'); ?>
            </div>
            
            <div class="form-group">
                <label class="form-label"><i class="fas fa-shipping-fast"></i> Supplier</label>
                <select name="supplier_id" class="form-control">
                    <option value="">-- Pilih Supplier --</option>
                    <?php foreach ($suppliers as $id => $nama): ?>
                    <option value="<?php echo $id; ?>" 
                            <?php echo (isset($bahan) && $bahan->supplier_id == $id) ? 'selected' : ''; ?>>
                        <?php echo $nama; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label"><i class="fas fa-balance-scale"></i> Satuan <span style="color: red;">*</span></label>
                <select name="satuan" class="form-control" required>
                    <option value="">-- Pilih Satuan --</option>
                    <option value="kg" <?php echo (isset($bahan) && $bahan->satuan == 'kg') ? 'selected' : ''; ?>>Kilogram (kg)</option>
                    <option value="gram" <?php echo (isset($bahan) && $bahan->satuan == 'gram') ? 'selected' : ''; ?>>Gram</option>
                    <option value="liter" <?php echo (isset($bahan) && $bahan->satuan == 'liter') ? 'selected' : ''; ?>>Liter</option>
                    <option value="ml" <?php echo (isset($bahan) && $bahan->satuan == 'ml') ? 'selected' : ''; ?>>Mililiter (ml)</option>
                    <option value="pcs" <?php echo (isset($bahan) && $bahan->satuan == 'pcs') ? 'selected' : ''; ?>>Pieces (pcs)</option>
                    <option value="pack" <?php echo (isset($bahan) && $bahan->satuan == 'pack') ? 'selected' : ''; ?>>Pack</option>
                </select>
                <?php echo form_error('satuan', '<small class="text-danger">', '</small>'); ?>
            </div>
            
            <?php if (!isset($bahan)): ?>
            <div class="form-group">
                <label class="form-label"><i class="fas fa-boxes"></i> Stok Awal</label>
                <input type="number" name="stok" class="form-control" 
                       value="<?php echo set_value('stok', 0); ?>" 
                       step="0.01" min="0"
                       placeholder="0">
                <small style="color: #6c757d;">Kosongkan jika 0</small>
            </div>
            <?php endif; ?>
            
            <div class="form-group">
                <label class="form-label"><i class="fas fa-exclamation-triangle"></i> Stok Minimum <span style="color: red;">*</span></label>
                <input type="number" name="stok_minimum" class="form-control" 
                       value="<?php echo isset($bahan) ? $bahan->stok_minimum : set_value('stok_minimum', 10); ?>" 
                       step="0.01" min="0" required
                       placeholder="10">
                <small style="color: #6c757d;">Batas minimum stok untuk notifikasi</small>
                <?php echo form_error('stok_minimum', '<small class="text-danger">', '</small>'); ?>
            </div>
            
            <div class="form-group">
                <label class="form-label"><i class="fas fa-dollar-sign"></i> Harga Satuan</label>
                <input type="number" name="harga_satuan" class="form-control" 
                       value="<?php echo isset($bahan) ? $bahan->harga_satuan : set_value('harga_satuan', 0); ?>" 
                       step="0.01" min="0"
                       placeholder="0">
                <small style="color: #6c757d;">Dalam Rupiah</small>
            </div>
            
            <div class="form-group">
                <label class="form-label"><i class="fas fa-calendar-times"></i> Tanggal Expired</label>
                <input type="date" name="tanggal_expired" class="form-control" 
                       value="<?php echo isset($bahan) ? $bahan->tanggal_expired : set_value('tanggal_expired'); ?>">
                <small style="color: #6c757d;">Kosongkan jika tidak ada expired</small>
            </div>
        </div>
        
        <div class="form-group">
            <label class="form-label"><i class="fas fa-align-left"></i> Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3" 
                      placeholder="Keterangan tambahan (opsional)"><?php echo isset($bahan) ? $bahan->keterangan : set_value('keterangan'); ?></textarea>
        </div>
        
        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-check-circle"></i> Simpan
            </button>
            <a href="<?php echo site_url('bahan_baku'); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-circle-left"></i> Kembali
            </a>
        </div>
        
        <?php echo form_close(); ?>
    </div>
</div>

