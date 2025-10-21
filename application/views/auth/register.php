<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem Inventory Management UMKM Kedai Buah Jus</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #FF6B35 0%, #F7931E 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        
        .register-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 500px;
        }
        
        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .register-header i {
            font-size: 50px;
            color: #FF6B35;
            margin-bottom: 10px;
        }
        
        .register-header h2 {
            color: #2C3E50;
            margin: 10px 0;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #2C3E50;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #FF6B35;
        }
        
        .btn-register {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #FF6B35 0%, #F7931E 100%);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(255, 107, 53, 0.4);
        }
        
        .register-footer {
            text-align: center;
            margin-top: 20px;
        }
        
        .register-footer a {
            color: #FF6B35;
            text-decoration: none;
        }
        
        .alert {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .text-danger {
            color: #dc3545;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <i class="fas fa-user-plus"></i>
            <h2>REGISTRASI</h2>
            <p>Daftar Akun Baru</p>
        </div>
        
        <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo $this->session->flashdata('error'); ?>
        </div>
        <?php endif; ?>
        
        <?php echo form_open('auth/register'); ?>
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap" value="<?php echo set_value('nama_lengkap'); ?>" required>
                <?php echo form_error('nama_lengkap', '<small class="text-danger">', '</small>'); ?>
            </div>
            
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email" value="<?php echo set_value('email'); ?>" required>
                <?php echo form_error('email', '<small class="text-danger">', '</small>'); ?>
            </div>
            
            <div class="form-group">
                <label class="form-label">No HP</label>
                <input type="text" name="no_hp" class="form-control" placeholder="Masukkan nomor HP" value="<?php echo set_value('no_hp'); ?>" required>
                <?php echo form_error('no_hp', '<small class="text-danger">', '</small>'); ?>
            </div>
            
            <div class="form-group">
                <label class="form-label">Role</label>
                <select name="role" class="form-control" required>
                    <option value="">Pilih Role</option>
                    <option value="admin" <?php echo set_select('role', 'admin'); ?>>Admin</option>
                    <option value="owner" <?php echo set_select('role', 'owner'); ?>>Owner</option>
                    <option value="karyawan" <?php echo set_select('role', 'karyawan'); ?>>Karyawan</option>
                </select>
                <?php echo form_error('role', '<small class="text-danger">', '</small>'); ?>
            </div>
            
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                <?php echo form_error('password', '<small class="text-danger">', '</small>'); ?>
            </div>
            
            <div class="form-group">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirm" class="form-control" placeholder="Ulangi password" required>
                <?php echo form_error('password_confirm', '<small class="text-danger">', '</small>'); ?>
            </div>
            
            <button type="submit" class="btn-register">
                <i class="fas fa-user-plus"></i> DAFTAR
            </button>
        <?php echo form_close(); ?>
        
        <div class="register-footer">
            <p>Sudah punya akun? <a href="<?php echo site_url('auth/login'); ?>">Login di sini</a></p>
            <p style="margin-top: 10px; font-size: 12px; color: #6c757d;">
                <i class="fas fa-info-circle"></i> Akun akan langsung aktif setelah registrasi
            </p>
        </div>
    </div>
</body>
</html>

