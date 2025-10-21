<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Inventory Management Kedai Jus Buah</title>
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
        }
        
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-header i {
            font-size: 60px;
            color: #FF6B35;
            margin-bottom: 10px;
        }
        
        .login-header h2 {
            color: #2C3E50;
            margin: 10px 0;
        }
        
        .login-header p {
            color: #6c757d;
            font-size: 14px;
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
        
        .btn-login {
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
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(255, 107, 53, 0.4);
        }
        
        .login-footer {
            text-align: center;
            margin-top: 20px;
        }
        
        .login-footer a {
            color: #FF6B35;
            text-decoration: none;
        }
        
        .alert {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
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
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <i class="fas fa-lemon"></i>
            <h2>noÖmmies</h2>
            <p>Sistem Inventory Management Kedai Jus Buah</p>
        </div>
        
        <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success modern-alert">
            <div class="alert-content">
                <div class="alert-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="alert-message">
                    <h6 class="alert-title">Berhasil!</h6>
                    <p class="alert-text"><?php echo $this->session->flashdata('success'); ?></p>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger modern-alert">
            <div class="alert-content">
                <div class="alert-icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div class="alert-message">
                    <h6 class="alert-title">Error!</h6>
                    <p class="alert-text"><?php echo $this->session->flashdata('error'); ?></p>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <?php echo form_open('auth/login'); ?>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email" required autofocus>
                <?php echo form_error('email', '<small class="text-danger">', '</small>'); ?>
            </div>
            
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                <?php echo form_error('password', '<small class="text-danger">', '</small>'); ?>
            </div>
            
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> LOGIN
            </button>
        <?php echo form_close(); ?>
        
        <div class="login-footer">
            <p>Belum punya akun? <a href="<?php echo site_url('auth/register'); ?>">Daftar di sini</a></p>
            <p style="margin-top: 20px; font-size: 12px; color: #6c757d;">
                Default: email: <strong>admin@kedaijus.com</strong>, password: <strong>password</strong>
            </p>
        </div>
    </div>
</body>
</html>

