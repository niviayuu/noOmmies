<?php $this->load->view('templates/header'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-circle"></i> Profil Saya
                    </h3>
                </div>
                <div class="card-body">
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show modern-alert" role="alert">
                            <div class="alert-content">
                                <div class="alert-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="alert-message">
                                    <h6 class="alert-title">Berhasil!</h6>
                                    <p class="alert-text"><?= $this->session->flashdata('success') ?></p>
                                </div>
                            </div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show modern-alert" role="alert">
                            <div class="alert-content">
                                <div class="alert-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="alert-message">
                                    <h6 class="alert-title">Error!</h6>
                                    <p class="alert-text"><?= $this->session->flashdata('error') ?></p>
                                </div>
                            </div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('users/update_profile') ?>" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_lengkap">
                                        <i class="fas fa-user-circle"></i> Nama Lengkap
                                    </label>
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" 
                                           value="<?= set_value('nama_lengkap', $user->nama_lengkap) ?>" required>
                                    <?= form_error('nama_lengkap', '<small class="text-danger">', '</small>') ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">
                                        <i class="fas fa-at"></i> Email
                                    </label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?= set_value('email', $user->email) ?>" required>
                                    <?= form_error('email', '<small class="text-danger">', '</small>') ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_hp">
                                        <i class="fas fa-mobile-alt"></i> No HP
                                    </label>
                                    <input type="text" class="form-control" id="no_hp" name="no_hp" 
                                           value="<?= set_value('no_hp', $user->no_hp) ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role">
                                        <i class="fas fa-user-shield"></i> Role
                                    </label>
                                    <input type="text" class="form-control" value="<?= ucfirst($user->role) ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">
                                        <i class="fas fa-key"></i> Password Baru (kosongkan jika tidak ingin mengubah)
                                    </label>
                                    <input type="password" class="form-control" id="password" name="password">
                                    <small class="form-text text-muted">Minimal 6 karakter</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">
                                        <i class="fas fa-power-off"></i> Status
                                    </label>
                                    <input type="text" class="form-control" 
                                           value="<?= $user->status == 'active' ? 'Aktif' : 'Nonaktif' ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        <i class="fas fa-calendar-plus"></i> Tanggal Bergabung
                                    </label>
                                    <input type="text" class="form-control" 
                                           value="<?= date('d M Y H:i', strtotime($user->created_at)) ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        <i class="fas fa-calendar-check"></i> Terakhir Update
                                    </label>
                                    <input type="text" class="form-control" 
                                           value="<?= date('d M Y H:i', strtotime($user->updated_at)) ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check-circle"></i> Update Profil
                            </button>
                            <a href="<?= base_url('users') ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-circle-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>

<style>
/* Modern Alert Styles */
.modern-alert {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    padding: 20px;
    position: relative;
    overflow: hidden;
}

.modern-alert::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: currentColor;
}

.modern-alert.alert-success::before {
    background: linear-gradient(135deg, #28a745, #20c997);
}

.modern-alert.alert-danger::before {
    background: linear-gradient(135deg, #dc3545, #fd7e14);
}

.alert-content {
    display: flex;
    align-items: flex-start;
    gap: 15px;
}

.alert-icon {
    flex-shrink: 0;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    margin-top: 2px;
}

.modern-alert.alert-success .alert-icon {
    background: rgba(40, 167, 69, 0.1);
    color: #28a745;
}

.modern-alert.alert-danger .alert-icon {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

.alert-message {
    flex: 1;
}

.alert-title {
    font-weight: 600;
    font-size: 16px;
    margin-bottom: 5px;
    color: inherit;
}

.alert-text {
    margin: 0;
    font-size: 14px;
    line-height: 1.5;
    opacity: 0.9;
}

.modern-alert .close {
    position: absolute;
    top: 15px;
    right: 15px;
    background: none;
    border: none;
    font-size: 16px;
    opacity: 0.7;
    transition: opacity 0.3s ease;
    padding: 5px;
    border-radius: 4px;
}

.modern-alert .close:hover {
    opacity: 1;
    background: rgba(0, 0, 0, 0.05);
}

.modern-alert.alert-success .close {
    color: #28a745;
}

.modern-alert.alert-danger .close {
    color: #dc3545;
}

/* Animation */
.modern-alert {
    animation: slideInDown 0.5s ease-out;
}

@keyframes slideInDown {
    from {
        transform: translateY(-20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* Responsive */
@media (max-width: 768px) {
    .modern-alert {
        padding: 15px;
    }
    
    .alert-content {
        gap: 12px;
    }
    
    .alert-icon {
        width: 35px;
        height: 35px;
        font-size: 16px;
    }
    
    .alert-title {
        font-size: 15px;
    }
    
    .alert-text {
        font-size: 13px;
    }
}
</style>
