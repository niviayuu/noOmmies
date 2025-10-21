<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-users"></i> Manajemen User
        </h3>
        <div class="card-tools">
            <a href="<?= base_url('users/tambah') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah User
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Filter -->
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="btn-group" role="group">
                    <a href="<?= base_url('users') ?>" class="btn btn-outline-primary <?= !$this->input->get('status') ? 'active' : '' ?>">
                        <i class="fas fa-list"></i> Semua (<?= count($users) ?>)
                    </a>
                    <a href="<?= base_url('users?status=active') ?>" class="btn btn-outline-success <?= $this->input->get('status') == 'active' ? 'active' : '' ?>">
                        <i class="fas fa-check-circle"></i> Aktif (<?= count(array_filter($users, function($u) { return $u->status == 'active'; })) ?>)
                    </a>
                    <a href="<?= base_url('users?status=inactive') ?>" class="btn btn-outline-danger <?= $this->input->get('status') == 'inactive' ? 'active' : '' ?>">
                        <i class="fas fa-times-circle"></i> Nonaktif (<?= count(array_filter($users, function($u) { return $u->status == 'inactive'; })) ?>)
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                    <input type="text" id="searchUsers" class="form-control" placeholder="Cari user...">
                </div>
            </div>
        </div>

        <!-- Ringkasan -->
        <div class="row mb-4" style="display: flex; gap: 15px;">
            <div class="col-md-3" style="flex: 1;">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-users fa-2x mr-3"></i>
                            <div>
                                <h6 class="mb-0">Total User</h6>
                                <h4 class="mb-0"><?= count($users) ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3" style="flex: 1;">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle fa-2x mr-3"></i>
                            <div>
                                <h6 class="mb-0">User Aktif</h6>
                                <h4 class="mb-0"><?= count(array_filter($users, function($u) { return $u->status == 'active'; })) ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3" style="flex: 1;">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-shield fa-2x mr-3"></i>
                            <div>
                                <h6 class="mb-0">Admin</h6>
                                <h4 class="mb-0"><?= count(array_filter($users, function($u) { return $u->role == 'admin'; })) ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3" style="flex: 1;">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user fa-2x mr-3"></i>
                            <div>
                                <h6 class="mb-0">Karyawan</h6>
                                <h4 class="mb-0"><?= count(array_filter($users, function($u) { return $u->role == 'karyawan'; })) ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Users -->
        <?php if (!empty($users)): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>No HP</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $index => $user): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= $user->nama_lengkap ?></td>
                                <td><?= $user->email ?></td>
                                <td>
                                    <?php
                                    switch($user->role) {
                                        case 'admin': echo '<span class="badge badge-danger">Admin</span>'; break;
                                        case 'owner': echo '<span class="badge badge-info">Owner</span>'; break;
                                        case 'karyawan': echo '<span class="badge badge-success">Karyawan</span>'; break;
                                    }
                                    ?>
                                </td>
                                <td><?= $user->no_hp ?: '-' ?></td>
                                <td>
                                    <?php if ($user->status == 'active'): ?>
                                        <span class="badge badge-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('users/edit/' . $user->id) ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <?php if ($user->status == 'active'): ?>
                                        <a href="<?= base_url('users/deactivate/' . $user->id) ?>" class="btn btn-sm btn-secondary" onclick="return confirm('Nonaktifkan user ini?')" title="Nonaktifkan">
                                            <i class="fas fa-user-times"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= base_url('users/activate/' . $user->id) ?>" class="btn btn-sm btn-success" onclick="return confirm('Aktifkan user ini?')" title="Aktifkan">
                                            <i class="fas fa-user-check"></i>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if ($user->id != $this->session->userdata('user_id')): ?>
                                        <a href="<?= base_url('users/hapus/' . $user->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus user ini?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-4">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada user</h5>
                <p class="text-muted">Belum ada user yang terdaftar dalam sistem</p>
                <a href="<?= base_url('users/tambah') ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah User Pertama
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Simple search functionality
document.getElementById('searchUsers').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>