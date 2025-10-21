<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-trash-alt"></i> Data Waste</h3>
        <a href="<?php echo site_url('waste/tambah'); ?>" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Tambah Waste
        </a>
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Nama Item</th>
                        <th>Jumlah</th>
                        <th>Total Nilai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($waste_records as $waste): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($waste->tanggal_waste)); ?></td>
                        <td>
                            <span class="badge badge-secondary"><?php echo $waste->nama_kategori; ?></span>
                        </td>
                        <td><?php echo $waste->nama_item; ?></td>
                        <td><?php echo number_format($waste->jumlah_waste, 2) . ' ' . $waste->satuan; ?></td>
                        <td>Rp <?php echo number_format($waste->total_nilai_waste, 0, ',', '.'); ?></td>
                        <td>
                            <?php if ($waste->status == 'pending'): ?>
                            <span class="badge badge-warning">Pending</span>
                            <?php elseif ($waste->status == 'approved'): ?>
                            <span class="badge badge-success">Disetujui</span>
                            <?php else: ?>
                            <span class="badge badge-danger">Ditolak</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="display: flex; gap: 5px; align-items: center;">
                                <a href="<?php echo site_url('waste/detail/' . $waste->id); ?>" class="btn btn-sm btn-info" title="Detail">
                                    <i class="fas fa-search-plus"></i>
                                </a>
                                <a href="<?php echo site_url('waste/edit/' . $waste->id); ?>" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?php echo site_url('waste/hapus/' . $waste->id); ?>" class="btn btn-sm btn-danger btn-delete" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
