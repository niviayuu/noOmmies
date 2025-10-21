<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-trash-can"></i> <?= isset($waste) ? 'Edit Waste' : 'Tambah Waste Baru' ?>
        </h3>
        <div class="card-tools">
            <a href="<?= base_url('waste') ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-circle-left"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php if (validation_errors()): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-triangle-exclamation"></i>
                <strong>Error!</strong> Terdapat kesalahan dalam input data:
                <ul class="mb-0 mt-2">
                    <?= validation_errors('<li>', '</li>') ?>
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-circle-check"></i>
                <strong>Berhasil!</strong> <?= $this->session->flashdata('success') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-circle-xmark"></i>
                <strong>Error!</strong> <?= $this->session->flashdata('error') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?= form_open(isset($waste) ? 'waste/edit/' . $waste->id : 'waste/tambah', array('class' => 'needs-validation', 'novalidate' => '')) ?>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tanggal_waste" class="form-label">
                        <i class="fas fa-calendar-days"></i> Tanggal Waste <span class="text-danger">*</span>
                    </label>
                    <input type="date" 
                           class="form-control <?= form_error('tanggal_waste') ? 'is-invalid' : '' ?>" 
                           id="tanggal_waste" 
                           name="tanggal_waste" 
                           value="<?= set_value('tanggal_waste', isset($waste) ? $waste->tanggal_waste : date('Y-m-d')) ?>" 
                           required>
                    <div class="invalid-feedback">
                        <?= form_error('tanggal_waste') ?: 'Tanggal waste harus diisi' ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="kategori_id" class="form-label">
                        <i class="fas fa-tags"></i> Kategori Waste <span class="text-danger">*</span>
                    </label>
                    <select class="form-control <?= form_error('kategori_id') ? 'is-invalid' : '' ?>" 
                            id="kategori_id" 
                            name="kategori_id" 
                            required>
                        <option value="">Pilih Kategori</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category->id ?>" 
                                    <?= set_select('kategori_id', $category->id, isset($waste) && $waste->kategori_id == $category->id) ?>>
                                <?= $category->nama_kategori ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">
                        <?= form_error('kategori_id') ?: 'Kategori waste harus dipilih' ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="item_type" class="form-label">
                        <i class="fas fa-list-ul"></i> Tipe Item
                    </label>
                    <select class="form-control" id="item_type" name="item_type">
                        <option value="">Pilih Tipe Item</option>
                        <option value="bahan_baku" <?= set_select('item_type', 'bahan_baku', isset($waste) && $waste->bahan_baku_id) ?>>Bahan Baku</option>
                        <option value="produk_jus" <?= set_select('item_type', 'produk_jus', isset($waste) && $waste->produk_jus_id) ?>>Produk Jus</option>
                        <option value="manual" <?= set_select('item_type', 'manual', !isset($waste) || (!$waste->bahan_baku_id && !$waste->produk_jus_id)) ?>>Manual</option>
                    </select>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group" id="item_selection" style="display: none;">
                    <label for="item_id" class="form-label">
                        <i class="fas fa-box-open"></i> Pilih Item
                    </label>
                    <select class="form-control" id="item_id" name="item_id">
                        <option value="">Pilih Item</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nama_item" class="form-label">
                        <i class="fas fa-tag"></i> Nama Item <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           class="form-control <?= form_error('nama_item') ? 'is-invalid' : '' ?>" 
                           id="nama_item" 
                           name="nama_item" 
                           value="<?= set_value('nama_item', isset($waste) ? $waste->nama_item : '') ?>" 
                           placeholder="Masukkan nama item"
                           required>
                    <div class="invalid-feedback">
                        <?= form_error('nama_item') ?: 'Nama item harus diisi' ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="form-group">
                    <label for="jumlah_waste" class="form-label">
                        <i class="fas fa-weight-hanging"></i> Jumlah Waste <span class="text-danger">*</span>
                    </label>
                    <input type="number" 
                           step="0.01"
                           class="form-control <?= form_error('jumlah_waste') ? 'is-invalid' : '' ?>" 
                           id="jumlah_waste" 
                           name="jumlah_waste" 
                           value="<?= set_value('jumlah_waste', isset($waste) ? $waste->jumlah_waste : '') ?>" 
                           placeholder="0.00"
                           required>
                    <div class="invalid-feedback">
                        <?= form_error('jumlah_waste') ?: 'Jumlah waste harus diisi' ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="form-group">
                    <label for="satuan" class="form-label">
                        <i class="fas fa-ruler-combined"></i> Satuan <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           class="form-control <?= form_error('satuan') ? 'is-invalid' : '' ?>" 
                           id="satuan" 
                           name="satuan" 
                           value="<?= set_value('satuan', isset($waste) ? $waste->satuan : '') ?>" 
                           placeholder="kg, pcs, botol"
                           required>
                    <div class="invalid-feedback">
                        <?= form_error('satuan') ?: 'Satuan harus diisi' ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="harga_per_satuan" class="form-label">
                        <i class="fas fa-money-bill-wave"></i> Harga per Satuan <span class="text-danger">*</span>
                    </label>
                    <input type="number" 
                           step="0.01"
                           class="form-control <?= form_error('harga_per_satuan') ? 'is-invalid' : '' ?>" 
                           id="harga_per_satuan" 
                           name="harga_per_satuan" 
                           value="<?= set_value('harga_per_satuan', isset($waste) ? $waste->harga_per_satuan : '') ?>" 
                           placeholder="0.00"
                           required>
                    <div class="invalid-feedback">
                        <?= form_error('harga_per_satuan') ?: 'Harga per satuan harus diisi' ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="total_nilai_waste" class="form-label">
                        <i class="fas fa-calculator"></i> Total Nilai Waste
                    </label>
                    <input type="text" 
                           class="form-control" 
                           id="total_nilai_waste" 
                           name="total_nilai_waste" 
                           value="<?= set_value('total_nilai_waste', isset($waste) ? number_format($waste->total_nilai_waste, 0, ',', '.') : '0') ?>" 
                           readonly>
                    <small class="form-text text-muted">Otomatis dihitung dari jumlah × harga per satuan</small>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="alasan_waste" class="form-label">
                <i class="fas fa-comment-dots"></i> Alasan Waste <span class="text-danger">*</span>
            </label>
            <textarea class="form-control <?= form_error('alasan_waste') ? 'is-invalid' : '' ?>" 
                      id="alasan_waste" 
                      name="alasan_waste" 
                      rows="4" 
                      placeholder="Jelaskan alasan mengapa item ini menjadi waste..."
                      required><?= set_value('alasan_waste', isset($waste) ? $waste->alasan_waste : '') ?></textarea>
            <div class="invalid-feedback">
                <?= form_error('alasan_waste') ?: 'Alasan waste harus diisi' ?>
            </div>
        </div>

        <hr>
        
        <div class="form-group text-right">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-floppy-disk"></i> <?= isset($waste) ? 'Update Waste' : 'Simpan Waste' ?>
            </button>
            <a href="<?= base_url('waste') ?>" class="btn btn-secondary">
                <i class="fas fa-xmark"></i> Batal
            </a>
        </div>

        <?= form_close() ?>
    </div>
</div>

<script>
$(document).ready(function() {
    // Calculate total value
    function calculateTotal() {
        var jumlah = parseFloat($('#jumlah_waste').val()) || 0;
        var harga = parseFloat($('#harga_per_satuan').val()) || 0;
        var total = jumlah * harga;
        $('#total_nilai_waste').val(total.toLocaleString('id-ID'));
    }

    $('#jumlah_waste, #harga_per_satuan').on('input', calculateTotal);

    // Item type change handler
    $('#item_type').on('change', function() {
        var type = $(this).val();
        var itemSelect = $('#item_id');
        var itemSelection = $('#item_selection');
        
        if (type === 'bahan_baku' || type === 'produk_jus') {
            itemSelection.show();
            itemSelect.empty().append('<option value="">Pilih Item</option>');
            
            if (type === 'bahan_baku') {
                <?php foreach ($bahan_baku as $bahan): ?>
                    itemSelect.append('<option value="<?= $bahan->id ?>" data-nama="<?= $bahan->nama_bahan ?>" data-satuan="<?= $bahan->satuan ?>" data-harga="<?= $bahan->harga_satuan ?>"><?= $bahan->nama_bahan ?></option>');
                <?php endforeach; ?>
            } else if (type === 'produk_jus') {
                <?php foreach ($produk_jus as $produk): ?>
                    itemSelect.append('<option value="<?= $produk->id ?>" data-nama="<?= $produk->nama_produk ?>" data-satuan="botol" data-harga="<?= $produk->harga_jual ?>"><?= $produk->nama_produk ?></option>');
                <?php endforeach; ?>
            }
        } else {
            itemSelection.hide();
            $('#nama_item, #satuan, #harga_per_satuan').prop('readonly', false);
        }
    });

    // Item selection change handler
    $('#item_id').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        if (selectedOption.val()) {
            $('#nama_item').val(selectedOption.data('nama')).prop('readonly', true);
            $('#satuan').val(selectedOption.data('satuan')).prop('readonly', true);
            $('#harga_per_satuan').val(selectedOption.data('harga')).prop('readonly', true);
            calculateTotal();
        }
    });

    // Initialize form validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
});
</script>
