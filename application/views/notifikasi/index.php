<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-bell"></i> Notifikasi
        </h3>
        <div class="card-tools">
            <button onclick="markAllAsRead()" class="btn btn-success">
                <i class="fas fa-check-double"></i> Tandai Semua Dibaca
            </button>
        </div>
    </div>
    <div class="card-body">
        <!-- Filter Notifikasi -->
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="btn-group" role="group">
                    <a href="<?php echo site_url('notifikasi'); ?>" class="btn btn-outline-primary <?php echo !$this->input->get('status') ? 'active' : ''; ?>">
                        <i class="fas fa-list"></i> Semua (<?php echo count($notifications); ?>)
                    </a>
                    <a href="<?php echo site_url('notifikasi?status=unread'); ?>" class="btn btn-outline-warning <?php echo $this->input->get('status') == 'unread' ? 'active' : ''; ?>">
                        <i class="fas fa-exclamation-circle"></i> Belum Dibaca (<?php echo $unread_count; ?>)
                    </a>
                    <a href="<?php echo site_url('notifikasi?status=read'); ?>" class="btn btn-outline-success <?php echo $this->input->get('status') == 'read' ? 'active' : ''; ?>">
                        <i class="fas fa-check-circle"></i> Sudah Dibaca (<?php echo count($notifications) - $unread_count; ?>)
                    </a>
                </div>
            </div>
        </div>

        <!-- Ringkasan -->
        <div class="row mb-4" style="display: flex; gap: 15px;">
            <div class="col-md-3" style="flex: 1;">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-bell fa-2x mr-3"></i>
                            <div>
                                <h6 class="mb-0">Total Notifikasi</h6>
                                <h4 class="mb-0"><?php echo count($notifications); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3" style="flex: 1;">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-circle fa-2x mr-3"></i>
                            <div>
                                <h6 class="mb-0">Belum Dibaca</h6>
                                <h4 class="mb-0"><?php echo $unread_count; ?></h4>
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
                                <h6 class="mb-0">Sudah Dibaca</h6>
                                <h4 class="mb-0"><?php echo count($notifications) - $unread_count; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3" style="flex: 1;">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar-day fa-2x mr-3"></i>
                            <div>
                                <h6 class="mb-0">Hari Ini</h6>
                                <h4 class="mb-0">
                                    <?php 
                                    $today_count = 0;
                                    foreach ($notifications as $notif) {
                                        if (date('Y-m-d', strtotime($notif->created_at)) == date('Y-m-d')) {
                                            $today_count++;
                                        }
                                    }
                                    echo $today_count;
                                    ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Notifikasi -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tipe</th>
                        <th>Pesan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($notifications)): ?>
                        <?php $no = 1; foreach ($notifications as $notif): ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td>
                                    <span class="badge badge-<?php echo $notif->tipe == 'stok_menipis' ? 'warning' : ($notif->tipe == 'expired' ? 'danger' : 'info'); ?>">
                                        <?php echo ucfirst(str_replace('_', ' ', $notif->tipe)); ?>
                                    </span>
                                </td>
                                <td><?php echo $notif->pesan; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($notif->created_at)); ?></td>
                                <td>
                                    <?php if ($notif->status == 'unread'): ?>
                                        <span class="badge badge-warning">Belum Dibaca</span>
                                    <?php else: ?>
                                        <span class="badge badge-success">Sudah Dibaca</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($notif->status == 'unread'): ?>
                                        <button onclick="markAsRead(<?php echo $notif->id; ?>)" class="btn btn-sm btn-success" title="Tandai Dibaca">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    <?php endif; ?>
                                    <button onclick="deleteNotification(<?php echo $notif->id; ?>)" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-bell fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Tidak ada notifikasi</h5>
                                <p class="text-muted">Belum ada notifikasi dalam sistem</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function markAsRead(id) {
    if (!confirm('Tandai notifikasi sebagai dibaca?')) {
        return;
    }
    
    $.ajax({
        url: '<?php echo site_url("notifikasi/mark_read/"); ?>' + id,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert('Notifikasi ditandai sebagai dibaca');
                location.reload();
            } else {
                alert('Gagal menandai sebagai dibaca');
            }
        },
        error: function() {
            alert('Terjadi kesalahan');
        }
    });
}

function markAllAsRead() {
    if (!confirm('Tandai semua notifikasi sebagai dibaca?')) {
        return;
    }
    
    $.ajax({
        url: '<?php echo site_url("notifikasi/mark_all_read"); ?>',
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert('Semua notifikasi ditandai sebagai dibaca');
                location.reload();
            } else {
                alert('Gagal menandai semua sebagai dibaca');
            }
        },
        error: function() {
            alert('Terjadi kesalahan');
        }
    });
}

function deleteNotification(id) {
    if (!confirm('Hapus notifikasi ini?')) {
        return;
    }
    
    $.ajax({
        url: '<?php echo site_url("notifikasi/hapus/"); ?>' + id,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert('Notifikasi dihapus');
                location.reload();
            } else {
                alert('Gagal menghapus notifikasi');
            }
        },
        error: function() {
            alert('Terjadi kesalahan');
        }
    });
}
</script>
