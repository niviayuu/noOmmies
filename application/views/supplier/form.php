<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-<?php echo isset($supplier) ? 'edit' : 'plus-circle'; ?>"></i>
            <?php echo isset($supplier) ? 'Edit' : 'Tambah'; ?> Supplier
        </h3>
    </div>
    <div class="card-body">
        <?php echo form_open(isset($supplier) ? 'supplier/edit/' . $supplier->id : 'supplier/tambah'); ?>
        
        <div class="form-group">
            <label class="form-label"><i class="fas fa-shipping-fast"></i> Nama Supplier <span style="color: red;">*</span></label>
            <input type="text" name="nama_supplier" class="form-control" 
                   value="<?php echo isset($supplier) ? $supplier->nama_supplier : set_value('nama_supplier'); ?>" 
                   placeholder="Masukkan nama supplier" required>
            <?php echo form_error('nama_supplier', '<small class="text-danger">', '</small>'); ?>
        </div>
        
        <div class="form-group">
            <label class="form-label"><i class="fas fa-map-marker-alt"></i> Alamat</label>
            <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap"><?php echo isset($supplier) ? $supplier->alamat : set_value('alamat'); ?></textarea>
        </div>
        
        <div class="form-group">
            <label class="form-label"><i class="fas fa-phone"></i> No HP <span style="color: red;">*</span></label>
            <input type="text" name="no_hp" class="form-control" 
                   value="<?php echo isset($supplier) ? $supplier->no_hp : set_value('no_hp'); ?>" 
                   placeholder="Masukkan nomor HP" required>
            <?php echo form_error('no_hp', '<small class="text-danger">', '</small>'); ?>
        </div>
        
        <div class="form-group">
            <label class="form-label"><i class="fas fa-envelope"></i> Email</label>
            <input type="email" name="email" class="form-control" 
                   value="<?php echo isset($supplier) ? $supplier->email : set_value('email'); ?>" 
                   placeholder="Masukkan email">
        </div>
        
        <div class="form-group">
            <label class="form-label"><i class="fas fa-align-left"></i> Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3" placeholder="Keterangan tambahan"><?php echo isset($supplier) ? $supplier->keterangan : set_value('keterangan'); ?></textarea>
        </div>
        
        <?php if (isset($supplier)): ?>
        <div class="form-group">
            <label class="form-label"><i class="fas fa-toggle-on"></i> Status</label>
            <select name="status" class="form-control" required>
                <option value="active" <?php echo $supplier->status == 'active' ? 'selected' : ''; ?>>Aktif</option>
                <option value="inactive" <?php echo $supplier->status == 'inactive' ? 'selected' : ''; ?>>Tidak Aktif</option>
            </select>
        </div>
        <?php endif; ?>
        
        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-check-circle"></i> Simpan
            </button>
            <a href="<?php echo site_url('supplier'); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-circle-left"></i> Kembali
            </a>
        </div>
        
        <?php echo form_close(); ?>
    </div>
</div>

