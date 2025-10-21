<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-recycle"></i> Tambah Disposal Waste
        </h3>
        <div class="card-tools">
            <a href="<?= base_url('waste/detail/' . $waste->id) ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-circle-left"></i> Kembali ke Detail
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

        <!-- Informasi Waste -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle"></i> Informasi Waste
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td><strong>Nama Item:</strong></td>
                                <td><?= $waste->nama_item ?></td>
                            </tr>
                            <tr>
                                <td><strong>Kategori:</strong></td>
                                <td><span class="badge badge-secondary"><?= $waste->nama_kategori ?></span></td>
                            </tr>
                            <tr>
                                <td><strong>Jumlah:</strong></td>
                                <td><?= number_format($waste->jumlah_waste, 2) ?> <?= $waste->satuan ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td><strong>Tanggal Waste:</strong></td>
                                <td><?= date('d/m/Y', strtotime($waste->tanggal_waste)) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Total Nilai:</strong></td>
                                <td><span class="text-danger font-weight-bold">Rp <?= number_format($waste->total_nilai_waste, 0, ',', '.') ?></span></td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    <?php if ($waste->status == 'pending'): ?>
                                        <span class="badge badge-warning">Pending</span>
                                    <?php elseif ($waste->status == 'approved'): ?>
                                        <span class="badge badge-success">Disetujui</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Ditolak</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <?= form_open('waste/disposal/' . $waste->id, array('class' => 'needs-validation', 'novalidate' => '')) ?>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tanggal_disposal" class="form-label">
                        <i class="fas fa-calendar-days"></i> Tanggal Disposal <span class="text-danger">*</span>
                    </label>
                    <input type="date" 
                           class="form-control <?= form_error('tanggal_disposal') ? 'is-invalid' : '' ?>" 
                           id="tanggal_disposal" 
                           name="tanggal_disposal" 
                           value="<?= set_value('tanggal_disposal', date('Y-m-d')) ?>" 
                           required>
                    <div class="invalid-feedback">
                        <?= form_error('tanggal_disposal') ?: 'Tanggal disposal harus diisi' ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="metode_disposal" class="form-label">
                        <i class="fas fa-recycle"></i> Metode Disposal <span class="text-danger">*</span>
                    </label>
                    <select class="form-control <?= form_error('metode_disposal') ? 'is-invalid' : '' ?>" 
                            id="metode_disposal" 
                            name="metode_disposal" 
                            required>
                        <option value="">Pilih Metode Disposal</option>
                        <option value="dibuang" <?= set_select('metode_disposal', 'dibuang') ?>>Dibuang</option>
                        <option value="didaur_ulang" <?= set_select('metode_disposal', 'didaur_ulang') ?>>Didaur Ulang</option>
                        <option value="dijual" <?= set_select('metode_disposal', 'dijual') ?>>Dijual</option>
                        <option value="disedekahkan" <?= set_select('metode_disposal', 'disedekahkan') ?>>Disedekahkan</option>
                    </select>
                    <div class="invalid-feedback">
                        <?= form_error('metode_disposal') ?: 'Metode disposal harus dipilih' ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="lokasi_disposal" class="form-label">
                        <i class="fas fa-map-marker-alt"></i> Lokasi Disposal
                    </label>
                    <input type="text" 
                           class="form-control" 
                           id="lokasi_disposal" 
                           name="lokasi_disposal" 
                           value="<?= set_value('lokasi_disposal') ?>" 
                           placeholder="Masukkan lokasi disposal">
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nama_penerima" class="form-label">
                        <i class="fas fa-user"></i> Nama Penerima
                    </label>
                    <input type="text" 
                           class="form-control" 
                           id="nama_penerima" 
                           name="nama_penerima" 
                           value="<?= set_value('nama_penerima') ?>" 
                           placeholder="Masukkan nama penerima">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="kontak_penerima" class="form-label">
                        <i class="fas fa-phone"></i> Kontak Penerima
                    </label>
                    <input type="text" 
                           class="form-control" 
                           id="kontak_penerima" 
                           name="kontak_penerima" 
                           value="<?= set_value('kontak_penerima') ?>" 
                           placeholder="Masukkan kontak penerima">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="catatan_disposal" class="form-label">
                <i class="fas fa-comment-dots"></i> Catatan Disposal
            </label>
            <textarea class="form-control" 
                      id="catatan_disposal" 
                      name="catatan_disposal" 
                      rows="4" 
                      placeholder="Masukkan catatan tambahan tentang disposal..."><?= set_value('catatan_disposal') ?></textarea>
        </div>

        <hr>
        
        <div class="form-group text-right">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-floppy-disk"></i> Simpan Disposal
            </button>
            <a href="<?= base_url('waste/detail/' . $waste->id) ?>" class="btn btn-secondary">
                <i class="fas fa-xmark"></i> Batal
            </a>
        </div>

        <?= form_close() ?>
    </div>
</div>

<script>
$(document).ready(function() {
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
