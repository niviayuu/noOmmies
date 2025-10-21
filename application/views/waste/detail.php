<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-trash-alt"></i> Detail Waste
        </h3>
        <div class="card-tools">
            <div style="display: flex; gap: 5px; align-items: center;">
                <a href="<?= base_url('waste/edit/' . $waste->id) ?>" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <?php if ($waste->status == 'pending'): ?>
                    <a href="<?= base_url('waste/approve/' . $waste->id) ?>" 
                       class="btn btn-success btn-sm"
                       onclick="return confirm('Setujui waste ini?')">
                        <i class="fas fa-check"></i> Setujui
                    </a>
                    <a href="<?= base_url('waste/reject/' . $waste->id) ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Tolak waste ini?')">
                        <i class="fas fa-times"></i> Tolak
                    </a>
                <?php endif; ?>
                <a href="<?= base_url('waste/disposal/' . $waste->id) ?>" class="btn btn-info btn-sm">
                    <i class="fas fa-recycle"></i> Disposal
                </a>
                <a href="<?= base_url('waste') ?>" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <!-- Informasi Waste -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle"></i> Informasi Waste
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong><i class="fas fa-calendar"></i> Tanggal Waste:</strong></td>
                                        <td><?= date('d F Y', strtotime($waste->tanggal_waste)) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong><i class="fas fa-tags"></i> Kategori:</strong></td>
                                        <td>
                                            <span class="badge badge-secondary"><?= $waste->nama_kategori ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong><i class="fas fa-tag"></i> Nama Item:</strong></td>
                                        <td><?= $waste->nama_item ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong><i class="fas fa-balance-scale"></i> Jumlah:</strong></td>
                                        <td><?= number_format($waste->jumlah_waste, 2) ?> <?= $waste->satuan ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong><i class="fas fa-dollar-sign"></i> Harga/Satuan:</strong></td>
                                        <td>Rp <?= number_format($waste->harga_per_satuan, 0, ',', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong><i class="fas fa-calculator"></i> Total Nilai:</strong></td>
                                        <td>
                                            <span class="text-danger font-weight-bold">
                                                Rp <?= number_format($waste->total_nilai_waste, 0, ',', '.') ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong><i class="fas fa-info-circle"></i> Status:</strong></td>
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
                                    <tr>
                                        <td><strong><i class="fas fa-user"></i> Dibuat Oleh:</strong></td>
                                        <td><?= $waste->created_by_name ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6><i class="fas fa-comment-alt"></i> Alasan Waste:</h6>
                                <div class="alert alert-light">
                                    <?= nl2br($waste->alasan_waste) ?>
                                </div>
                            </div>
                        </div>

                        <?php if ($waste->approved_by_name): ?>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong><i class="fas fa-user-check"></i> Disetujui Oleh:</strong></td>
                                            <td><?= $waste->approved_by_name ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong><i class="fas fa-clock"></i> Tanggal Disetujui:</strong></td>
                                            <td><?= date('d F Y H:i', strtotime($waste->approved_at)) ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Riwayat Disposal -->
                <?php if (!empty($disposal_records)): ?>
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-recycle"></i> Riwayat Disposal
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Tanggal Disposal</th>
                                            <th>Metode</th>
                                            <th>Lokasi</th>
                                            <th>Penerima</th>
                                            <th>Catatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($disposal_records as $disposal): ?>
                                            <tr>
                                                <td><?= date('d/m/Y', strtotime($disposal->tanggal_disposal)) ?></td>
                                                <td>
                                                    <?php
                                                    $metode_labels = array(
                                                        'dibuang' => 'Dibuang',
                                                        'didaur_ulang' => 'Didaur Ulang',
                                                        'dijual' => 'Dijual',
                                                        'disedekahkan' => 'Disedekahkan'
                                                    );
                                                    ?>
                                                    <span class="badge badge-info">
                                                        <?= $metode_labels[$disposal->metode_disposal] ?>
                                                    </span>
                                                </td>
                                                <td><?= $disposal->lokasi_disposal ?: '-' ?></td>
                                                <td>
                                                    <?php if ($disposal->nama_penerima): ?>
                                                        <?= $disposal->nama_penerima ?>
                                                        <?php if ($disposal->kontak_penerima): ?>
                                                            <br><small class="text-muted"><?= $disposal->kontak_penerima ?></small>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= $disposal->catatan_disposal ?: '-' ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="col-md-4">
                <!-- Status Card -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-pie"></i> Status Waste
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        <?php if ($waste->status == 'pending'): ?>
                            <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                            <h5 class="text-warning">Pending</h5>
                            <p class="text-muted">Menunggu persetujuan</p>
                        <?php elseif ($waste->status == 'approved'): ?>
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h5 class="text-success">Disetujui</h5>
                            <p class="text-muted">Waste telah disetujui</p>
                        <?php else: ?>
                            <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>
                            <h5 class="text-danger">Ditolak</h5>
                            <p class="text-muted">Waste ditolak</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bolt"></i> Quick Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <?php if ($waste->status == 'pending'): ?>
                                <a href="<?= base_url('waste/approve/' . $waste->id) ?>" 
                                   class="btn btn-success btn-sm"
                                   onclick="return confirm('Setujui waste ini?')">
                                    <i class="fas fa-check"></i> Setujui Waste
                                </a>
                                <a href="<?= base_url('waste/reject/' . $waste->id) ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Tolak waste ini?')">
                                    <i class="fas fa-times"></i> Tolak Waste
                                </a>
                            <?php endif; ?>
                            
                            <a href="<?= base_url('waste/disposal/' . $waste->id) ?>" class="btn btn-info btn-sm">
                                <i class="fas fa-recycle"></i> Tambah Disposal
                            </a>
                            
                            <a href="<?= base_url('waste/edit/' . $waste->id) ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit Waste
                            </a>
                            
                            <a href="<?= base_url('waste/hapus/' . $waste->id) ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Hapus waste ini?')">
                                <i class="fas fa-trash"></i> Hapus Waste
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Informasi Tambahan -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info"></i> Informasi Tambahan
                        </h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td><strong>ID Waste:</strong></td>
                                <td>#<?= str_pad($waste->id, 4, '0', STR_PAD_LEFT) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Dibuat:</strong></td>
                                <td><?= date('d/m/Y H:i', strtotime($waste->created_at)) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Terakhir Update:</strong></td>
                                <td><?= date('d/m/Y H:i', strtotime($waste->updated_at)) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
