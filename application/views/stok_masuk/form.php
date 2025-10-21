<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-plus-circle"></i> Input Stok Masuk (Pembelian Bahan)
        </h3>
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            <strong>Info:</strong> Stok bahan akan <strong>otomatis bertambah</strong> setelah Anda menyimpan data ini.
        </div>
        
        <?php echo form_open('stok_masuk/tambah'); ?>
        
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <div class="form-group">
                <label class="form-label"><i class="fas fa-cubes"></i> Bahan Baku <span style="color: red;">*</span></label>
                <select name="bahan_id" id="bahan_id" class="form-control" required onchange="updateSatuan()">
                    <option value="">-- Pilih Bahan --</option>
                    <?php foreach ($bahan_list as $bahan): ?>
                    <option value="<?php echo $bahan->id; ?>" 
                            data-satuan="<?php echo $bahan->satuan; ?>"
                            data-harga="<?php echo $bahan->harga_satuan; ?>">
                        <?php echo $bahan->nama_bahan; ?> (Stok: <?php echo $bahan->stok . ' ' . $bahan->satuan; ?>)
                    </option>
                    <?php endforeach; ?>
                </select>
                <?php echo form_error('bahan_id', '<small class="text-danger">', '</small>'); ?>
            </div>
            
            <div class="form-group">
                <label class="form-label"><i class="fas fa-shipping-fast"></i> Supplier</label>
                <select name="supplier_id" class="form-control">
                    <option value="">-- Pilih Supplier --</option>
                    <?php foreach ($suppliers as $id => $nama): ?>
                    <option value="<?php echo $id; ?>"><?php echo $nama; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label"><i class="fas fa-hashtag"></i> Jumlah <span style="color: red;">*</span></label>
                <div style="display: flex; gap: 10px;">
                    <input type="number" name="jumlah" id="jumlah" class="form-control" 
                           step="0.01" min="0" required placeholder="100"
                           onkeyup="calculateTotal()" style="flex: 1;">
                    <input type="text" id="satuan_display" class="form-control" 
                           style="width: 80px; background: #e9ecef;" readonly placeholder="Satuan">
                </div>
                <?php echo form_error('jumlah', '<small class="text-danger">', '</small>'); ?>
            </div>
            
            <div class="form-group">
                <label class="form-label"><i class="fas fa-dollar-sign"></i> Harga Satuan <span style="color: red;">*</span></label>
                <input type="number" name="harga_satuan" id="harga_satuan" class="form-control" 
                       step="0.01" min="0" required placeholder="15000"
                       onkeyup="calculateTotal()">
                <small style="color: #6c757d;">Dalam Rupiah</small>
                <?php echo form_error('harga_satuan', '<small class="text-danger">', '</small>'); ?>
            </div>
            
            <div class="form-group">
                <label class="form-label"><i class="fas fa-calculator"></i> Total Harga</label>
                <input type="text" id="total_display" class="form-control" 
                       style="background: #e9ecef; font-weight: bold; font-size: 16px; color: var(--success-color);" 
                       readonly placeholder="Rp 0">
                <small style="color: #6c757d;">Otomatis terhitung</small>
            </div>
            
            <div class="form-group">
                <label class="form-label"><i class="fas fa-calendar-alt"></i> Tanggal Masuk <span style="color: red;">*</span></label>
                <input type="date" name="tanggal_masuk" class="form-control" 
                       value="<?php echo date('Y-m-d'); ?>" required>
                <?php echo form_error('tanggal_masuk', '<small class="text-danger">', '</small>'); ?>
            </div>
            
            <div class="form-group">
                <label class="form-label"><i class="fas fa-calendar-times"></i> Tanggal Expired</label>
                <input type="date" name="tanggal_expired" class="form-control">
                <small style="color: #6c757d;">Kosongkan jika tidak ada expired</small>
            </div>
            
            <div class="form-group">
                <label class="form-label"><i class="fas fa-file-invoice"></i> No. Faktur/Invoice</label>
                <input type="text" name="no_faktur" class="form-control" 
                       placeholder="INV-001">
            </div>
        </div>
        
        <div class="form-group">
            <label class="form-label"><i class="fas fa-align-left"></i> Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3" 
                      placeholder="Keterangan tambahan (opsional)"></textarea>
        </div>
        
        <div style="margin-top: 20px; padding: 20px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 6px;">
            <h5 style="margin: 0 0 10px 0; color: #155724;">
                <i class="fas fa-check-circle"></i> Ringkasan Pembelian
            </h5>
            <div id="summary" style="color: #155724;">
                Pilih bahan dan isi jumlah untuk melihat ringkasan
            </div>
        </div>
        
        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-success" style="font-size: 14px; padding: 8px 20px;">
                <i class="fas fa-check-circle"></i> SIMPAN & UPDATE STOK
            </button>
            <a href="<?php echo site_url('stok_masuk'); ?>" class="btn btn-secondary" style="padding: 8px 20px;">
                <i class="fas fa-arrow-circle-left"></i> Kembali
            </a>
        </div>
        
        <?php echo form_close(); ?>
    </div>
</div>

<script>
function updateSatuan() {
    const select = document.getElementById('bahan_id');
    const option = select.options[select.selectedIndex];
    const satuan = option.getAttribute('data-satuan');
    const harga = option.getAttribute('data-harga');
    
    document.getElementById('satuan_display').value = satuan ? satuan.toUpperCase() : '';
    
    if (harga && harga > 0) {
        document.getElementById('harga_satuan').value = harga;
        calculateTotal();
    }
}

function calculateTotal() {
    const jumlah = parseFloat(document.getElementById('jumlah').value) || 0;
    const harga = parseFloat(document.getElementById('harga_satuan').value) || 0;
    const total = jumlah * harga;
    
    document.getElementById('total_display').value = 'Rp ' + total.toLocaleString('id-ID');
    
    // Update summary
    const select = document.getElementById('bahan_id');
    const option = select.options[select.selectedIndex];
    const namaBahan = option.text.split(' (')[0];
    const satuan = option.getAttribute('data-satuan') || '';
    
    if (jumlah > 0 && harga > 0 && namaBahan) {
        document.getElementById('summary').innerHTML = `
            <strong>Bahan:</strong> ${namaBahan}<br>
            <strong>Jumlah:</strong> ${jumlah} ${satuan.toUpperCase()}<br>
            <strong>Harga Satuan:</strong> Rp ${harga.toLocaleString('id-ID')}<br>
            <strong style="font-size: 18px; color: #0c5460;">Total: Rp ${total.toLocaleString('id-ID')}</strong>
        `;
    }
}
</script>

