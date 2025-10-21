<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-info-circle"></i> Detail Supplier</h3>
        <div style="display: flex; gap: 8px; align-items: center;">
            <a href="<?php echo site_url('supplier/edit/' . $supplier->id); ?>" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="<?php echo site_url('supplier'); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <table style="width: 100%;">
            <tr>
                <td style="width: 200px; padding: 10px; font-weight: 600;">Nama Supplier</td>
                <td style="padding: 10px;"><?php echo $supplier->nama_supplier; ?></td>
            </tr>
            <tr>
                <td style="padding: 10px; font-weight: 600;">Alamat</td>
                <td style="padding: 10px;"><?php echo $supplier->alamat ?: '-'; ?></td>
            </tr>
            <tr>
                <td style="padding: 10px; font-weight: 600;">No HP</td>
                <td style="padding: 10px;"><?php echo $supplier->no_hp; ?></td>
            </tr>
            <tr>
                <td style="padding: 10px; font-weight: 600;">Email</td>
                <td style="padding: 10px;"><?php echo $supplier->email ?: '-'; ?></td>
            </tr>
            <tr>
                <td style="padding: 10px; font-weight: 600;">Keterangan</td>
                <td style="padding: 10px;"><?php echo $supplier->keterangan ?: '-'; ?></td>
            </tr>
            <tr>
                <td style="padding: 10px; font-weight: 600;">Status</td>
                <td style="padding: 10px;">
                    <?php if ($supplier->status == 'active'): ?>
                    <span class="badge badge-success">Aktif</span>
                    <?php else: ?>
                    <span class="badge badge-secondary">Tidak Aktif</span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px; font-weight: 600;">Dibuat Pada</td>
                <td style="padding: 10px;"><?php echo date('d M Y H:i', strtotime($supplier->created_at)); ?></td>
            </tr>
            <tr>
                <td style="padding: 10px; font-weight: 600;">Terakhir Diupdate</td>
                <td style="padding: 10px;"><?php echo date('d M Y H:i', strtotime($supplier->updated_at)); ?></td>
            </tr>
        </table>
    </div>
</div>

