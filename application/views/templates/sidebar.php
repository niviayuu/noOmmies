<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-header">
        <h3><i class="fas fa-lemon"> </i>noÖmmies</h3>
        <p>Sistem Inventory Manajemen <br>Kedai Jus Buah</p>
    </div>
    
    <ul class="sidebar-menu">
        <li>
            <a href="<?php echo site_url('dashboard'); ?>">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        
        <div class="menu-section-title">MASTER DATA</div>
        
        <?php if (in_array($this->session->userdata('role'), ['admin', 'owner'])): ?>
        <li>
            <a href="<?php echo site_url('supplier'); ?>">
                <i class="fas fa-shipping-fast"></i>
                <span>Supplier</span>
            </a>
        </li>
        
        <li>
            <a href="<?php echo site_url('bahan_baku'); ?>">
                <i class="fas fa-cubes"></i>
                <span>Bahan Baku</span>
            </a>
        </li>
        <?php endif; ?>
        
        <li>
            <a href="<?php echo site_url('produk_jus'); ?>">
                <i class="fas fa-wine-bottle"></i>
                <span>Produk Jus</span>
            </a>
        </li>
        
        <div class="menu-section-title">TRANSAKSI</div>
        
        <?php if (in_array($this->session->userdata('role'), ['admin', 'owner'])): ?>
        <li>
            <a href="<?php echo site_url('stok_masuk'); ?>">
                <i class="fas fa-arrow-circle-down"></i>
                <span>Stok Masuk</span>
            </a>
        </li>
        <?php endif; ?>
        
        <li>
            <a href="<?php echo site_url('penjualan'); ?>">
                <i class="fas fa-shopping-bag"></i>
                <span>Penjualan</span>
            </a>
        </li>
        
        <?php if (in_array($this->session->userdata('role'), ['admin', 'owner'])): ?>
        <li>
            <a href="<?php echo site_url('waste'); ?>">
                <i class="fas fa-trash-alt"></i>
                <span>Waste Management</span>
            </a>
        </li>
        <?php endif; ?>
        
        <div class="menu-section-title">LAPORAN</div>
        
        <li>
            <a href="<?php echo site_url('laporan/penjualan'); ?>">
                <i class="fas fa-chart-bar"></i>
                <span>Lap. Penjualan</span>
            </a>
        </li>
        
        <li>
            <a href="<?php echo site_url('laporan/stok'); ?>">
                <i class="fas fa-warehouse"></i>
                <span>Lap. Stok</span>
            </a>
        </li>
        
        <li>
            <a href="<?php echo site_url('bahan_baku/stok_menipis'); ?>">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Stok Menipis</span>
            </a>
        </li>
        
        <li>
            <a href="<?php echo site_url('bahan_baku/mendekati_expired'); ?>">
                <i class="fas fa-hourglass-half"></i>
                <span>Mendekati Expired</span>
            </a>
        </li>
        
        <?php if (in_array($this->session->userdata('role'), ['admin', 'owner'])): ?>
        <li>
            <a href="<?php echo site_url('laporan/pembelian'); ?>">
                <i class="fas fa-receipt"></i>
                <span>Lap. Pembelian</span>
            </a>
        </li>
        
        <li>
            <a href="<?php echo site_url('laporan/waste'); ?>">
                <i class="fas fa-chart-bar"></i>
                <span>Lap. Waste</span>
            </a>
        </li>
        <?php endif; ?>
        
        <div class="menu-section-title">LAINNYA</div>
        
        <li>
            <a href="<?php echo site_url('notifikasi'); ?>">
                <i class="fas fa-bell"></i>
                <span>Notifikasi</span>
                <?php if (isset($unread_count) && $unread_count > 0): ?>
                <span class="badge badge-danger"><?php echo $unread_count; ?></span>
                <?php endif; ?>
            </a>
        </li>
        
        <?php if (in_array($this->session->userdata('role'), ['admin', 'owner'])): ?>
        <li>
            <a href="<?php echo site_url('users'); ?>">
                <i class="fas fa-user-cog"></i>
                <span>Manajemen User</span>
            </a>
        </li>
        <?php endif; ?>
        
        <li>
            <a href="<?php echo site_url('users/profile'); ?>">
                <i class="fas fa-user-circle"></i>
                <span>Profil Saya</span>
            </a>
        </li>
        
        <li>
            <a href="#" onclick="showLogoutModal(); return false;">
                <i class="fas fa-power-off"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</div>

<!-- Simple Logout Modal -->
<div id="logoutModal" class="modal-overlay" style="display: none;">
    <div class="modal-container">
        <div class="modal-header">
            <h4>Konfirmasi Logout</h4>
        </div>
        <div class="modal-body">
            <p>Apakah Anda yakin ingin keluar dari sistem?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="hideLogoutModal()">
                Batal
            </button>
            <button type="button" class="btn btn-danger" onclick="confirmLogout()">
                Logout
            </button>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="top-header">
        <div>
            <button id="sidebar-toggle" class="btn btn-sm" style="margin-right: 10px;">
                <i class="fas fa-align-left"></i>
            </button>
            <span class="page-title"><?php echo isset($title) ? $title : 'Dashboard'; ?></span>
        </div>
        
        <div class="header-actions">
            <div class="notification-icon">
                <a href="<?php echo site_url('notifikasi'); ?>">
                    <i class="fas fa-bell" style="font-size: 20px; color: #333;"></i>
                    <?php if (isset($unread_count) && $unread_count > 0): ?>
                    <span class="notification-badge"><?php echo $unread_count; ?></span>
                    <?php endif; ?>
                </a>
            </div>
            
            <div class="user-info">
                <div class="user-avatar">
                    <?php echo strtoupper(substr($this->session->userdata('nama_lengkap'), 0, 2)); ?>
                </div>
                <div>
                    <div style="font-weight: 600; font-size: 14px;">
                        <?php echo $this->session->userdata('nama_lengkap'); ?>
                    </div>
                    <div style="font-size: 12px; color: #6c757d;">
                        <?php echo ucfirst($this->session->userdata('role')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="content-wrapper">
        <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <?php echo $this->session->flashdata('success'); ?>
        </div>
        <?php endif; ?>
        
        <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo $this->session->flashdata('error'); ?>
        </div>
        <?php endif; ?>
        
        <?php if ($this->session->flashdata('warning')): ?>
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            <?php echo $this->session->flashdata('warning'); ?>
        </div>
        <?php endif; ?>
        
        <?php if ($this->session->flashdata('info')): ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            <?php echo $this->session->flashdata('info'); ?>
        </div>
        <?php endif; ?>

