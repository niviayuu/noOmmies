<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-user-plus"></i> <?= isset($user) ? 'Edit User' : 'Tambah User Baru' ?>
        </h3>
        <div class="card-tools">
            <a href="<?= base_url('users') ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-circle-left"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php if (validation_errors()): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i>
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
                <i class="fas fa-check-circle"></i>
                <strong>Berhasil!</strong> <?= $this->session->flashdata('success') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-times-circle"></i>
                <strong>Error!</strong> <?= $this->session->flashdata('error') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?= form_open(isset($user) ? 'users/update/' . $user->id : 'users/tambah', array('class' => 'needs-validation', 'novalidate' => '')) ?>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nama_lengkap" class="form-label">
                        <i class="fas fa-user-circle"></i> Nama Lengkap <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           class="form-control <?= form_error('nama_lengkap') ? 'is-invalid' : '' ?>" 
                           id="nama_lengkap" 
                           name="nama_lengkap" 
                           value="<?= set_value('nama_lengkap', isset($user) ? $user->nama_lengkap : '') ?>" 
                           placeholder="Masukkan nama lengkap"
                           required>
                    <div class="invalid-feedback">
                        <?= form_error('nama_lengkap') ?: 'Nama lengkap harus diisi' ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-at"></i> Email <span class="text-danger">*</span>
                    </label>
                    <input type="email" 
                           class="form-control <?= form_error('email') ? 'is-invalid' : '' ?>" 
                           id="email" 
                           name="email" 
                           value="<?= set_value('email', isset($user) ? $user->email : '') ?>" 
                           placeholder="Masukkan email"
                           required>
                    <div class="invalid-feedback">
                        <?= form_error('email') ?: 'Email harus diisi dan valid' ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="fas fa-key"></i> Password <?= !isset($user) ? '<span class="text-danger">*</span>' : '<small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small>' ?>
                    </label>
                    <input type="password" 
                           class="form-control <?= form_error('password') ? 'is-invalid' : '' ?>" 
                           id="password" 
                           name="password" 
                           placeholder="<?= isset($user) ? 'Masukkan password baru' : 'Masukkan password' ?>"
                           <?= !isset($user) ? 'required' : '' ?>>
                    <div class="invalid-feedback">
                        <?= form_error('password') ?: 'Password harus diisi minimal 6 karakter' ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="no_hp" class="form-label">
                        <i class="fas fa-mobile-alt"></i> No. HP
                    </label>
                    <input type="tel" 
                           class="form-control <?= form_error('no_hp') ? 'is-invalid' : '' ?>" 
                           id="no_hp" 
                           name="no_hp" 
                           value="<?= set_value('no_hp', isset($user) ? $user->no_hp : '') ?>" 
                           placeholder="Masukkan nomor HP">
                    <div class="invalid-feedback">
                        <?= form_error('no_hp') ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="role" class="form-label">
                        <i class="fas fa-user-shield"></i> Role <span class="text-danger">*</span>
                    </label>
                    <select class="form-control <?= form_error('role') ? 'is-invalid' : '' ?>" 
                            id="role" 
                            name="role" 
                            required>
                        <option value="">Pilih Role</option>
                        <option value="admin" <?= set_select('role', 'admin', isset($user) && $user->role == 'admin') ?>>Admin</option>
                        <option value="owner" <?= set_select('role', 'owner', isset($user) && $user->role == 'owner') ?>>Owner</option>
                        <option value="karyawan" <?= set_select('role', 'karyawan', isset($user) && $user->role == 'karyawan') ?>>Karyawan</option>
                    </select>
                    <div class="invalid-feedback">
                        <?= form_error('role') ?: 'Role harus dipilih' ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="status" class="form-label">
                        <i class="fas fa-power-off"></i> Status <span class="text-danger">*</span>
                    </label>
                    <select class="form-control <?= form_error('status') ? 'is-invalid' : '' ?>" 
                            id="status" 
                            name="status" 
                            required>
                        <option value="">Pilih Status</option>
                        <option value="active" <?= set_select('status', 'active', isset($user) && $user->status == 'active') ?>>Aktif</option>
                        <option value="inactive" <?= set_select('status', 'inactive', isset($user) && $user->status == 'inactive') ?>>Nonaktif</option>
                    </select>
                    <div class="invalid-feedback">
                        <?= form_error('status') ?: 'Status harus dipilih' ?>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        
        <div class="form-group text-right">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-check-circle"></i> <?= isset($user) ? 'Update User' : 'Simpan User' ?>
            </button>
            <a href="<?= base_url('users') ?>" class="btn btn-secondary">
                <i class="fas fa-times-circle"></i> Batal
            </a>
        </div>

        <?= form_close() ?>
    </div>
</div>

<script>
// Bootstrap form validation
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

// Auto-dismiss alerts
setTimeout(function() {
    $('.alert').fadeOut('slow');
}, 5000);
</script>
