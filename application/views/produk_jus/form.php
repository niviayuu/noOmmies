<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-<?php echo isset($produk) ? 'edit' : 'plus-circle'; ?>"></i>
            <?php echo isset($produk) ? 'Edit' : 'Tambah'; ?> Produk Jus
        </h3>
    </div>
    <div class="card-body">
        <?php echo form_open(isset($produk) ? 'produk_jus/edit/' . $produk->id : 'produk_jus/tambah'); ?>
        
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <div class="form-group">
                <label class="form-label"><i class="fas fa-wine-bottle"></i> Nama Produk <span style="color: red;">*</span></label>
                <input type="text" name="nama_produk" class="form-control" 
                       value="<?php echo isset($produk) ? $produk->nama_produk : set_value('nama_produk'); ?>" 
                       placeholder="Contoh: Jus Jeruk Segar" required>
                <?php echo form_error('nama_produk', '<small class="text-danger">', '</small>'); ?>
            </div>
            
            <div class="form-group">
                <label class="form-label"><i class="fas fa-tags"></i> Kategori <span style="color: red;">*</span></label>
                <select name="kategori" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="juice" <?php echo (isset($produk) && $produk->kategori == 'juice') ? 'selected' : ''; ?>>Juice</option>
                    <option value="smoothie" <?php echo (isset($produk) && $produk->kategori == 'smoothie') ? 'selected' : ''; ?>>Smoothie</option>
                    <option value="milkshake" <?php echo (isset($produk) && $produk->kategori == 'milkshake') ? 'selected' : ''; ?>>Milkshake</option>
                    <option value="blend" <?php echo (isset($produk) && $produk->kategori == 'blend') ? 'selected' : ''; ?>>Blend</option>
                </select>
                <?php echo form_error('kategori', '<small class="text-danger">', '</small>'); ?>
            </div>
            
            <div class="form-group">
                <label class="form-label"><i class="fas fa-expand-arrows-alt"></i> Ukuran <span style="color: red;">*</span></label>
                <select name="ukuran" class="form-control" required>
                    <option value="">-- Pilih Ukuran --</option>
                    <option value="small" <?php echo (isset($produk) && $produk->ukuran == 'small') ? 'selected' : ''; ?>>Small</option>
                    <option value="medium" <?php echo (isset($produk) && $produk->ukuran == 'medium') ? 'selected' : ''; ?>>Medium</option>
                    <option value="large" <?php echo (isset($produk) && $produk->ukuran == 'large') ? 'selected' : ''; ?>>Large</option>
                </select>
                <?php echo form_error('ukuran', '<small class="text-danger">', '</small>'); ?>
            </div>
            
            <div class="form-group">
                <label class="form-label"><i class="fas fa-dollar-sign"></i> Harga <span style="color: red;">*</span></label>
                <input type="number" name="harga" class="form-control" 
                       value="<?php echo isset($produk) ? $produk->harga : set_value('harga'); ?>" 
                       step="500" min="0" required
                       placeholder="15000">
                <small style="color: #6c757d;">Dalam Rupiah</small>
                <?php echo form_error('harga', '<small class="text-danger">', '</small>'); ?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="form-label"><i class="fas fa-align-left"></i> Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3" 
                      placeholder="Deskripsi produk (opsional)"><?php echo isset($produk) ? $produk->deskripsi : set_value('deskripsi'); ?></textarea>
        </div>
        
        <?php if (isset($produk)): ?>
        <div class="form-group">
            <label class="form-label"><i class="fas fa-toggle-on"></i> Status</label>
            <select name="status" class="form-control" required>
                <option value="active" <?php echo (isset($produk->status) && $produk->status == 'active') ? 'selected' : ''; ?>>Aktif</option>
                <option value="inactive" <?php echo (isset($produk->status) && $produk->status == 'inactive') ? 'selected' : ''; ?>>Tidak Aktif</option>
            </select>
        </div>
        <?php endif; ?>
        
        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-check-circle"></i> Simpan
            </button>
            <a href="<?php echo site_url('produk_jus'); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-circle-left"></i> Kembali
            </a>
        </div>
        
        <?php echo form_close(); ?>
    </div>
</div>

