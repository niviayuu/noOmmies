<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-shipping-fast"></i> Data Supplier</h3>
        <a href="<?php echo site_url('supplier/tambah'); ?>" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Tambah Supplier
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Supplier</th>
                        <th>Alamat</th>
                        <th>No HP</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($suppliers as $supplier): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $supplier->nama_supplier; ?></td>
                        <td><?php echo $supplier->alamat ?: '-'; ?></td>
                        <td><?php echo $supplier->no_hp; ?></td>
                        <td><?php echo $supplier->email ?: '-'; ?></td>
                        <td>
                            <?php if ($supplier->status == 'active'): ?>
                            <span class="badge badge-success">Aktif</span>
                            <?php else: ?>
                            <span class="badge badge-secondary">Tidak Aktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="display: flex; gap: 5px; align-items: center;">
                                <a href="<?php echo site_url('supplier/detail/' . $supplier->id); ?>" class="btn btn-sm btn-info" title="Detail">
                                    <i class="fas fa-search-plus"></i>
                                </a>
                                <a href="<?php echo site_url('supplier/edit/' . $supplier->id); ?>" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?php echo site_url('supplier/hapus/' . $supplier->id); ?>" class="btn btn-sm btn-danger btn-delete" title="Hapus">
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

