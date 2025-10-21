<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-wine-bottle"></i> Data Produk Jus</h3>
        <?php if ($this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'owner'): ?>
        <a href="<?php echo site_url('produk_jus/tambah'); ?>" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Tambah Produk
        </a>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Ukuran</th>
                        <th>Harga</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($products as $produk): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td>
                            <strong><?php echo $produk->nama_produk; ?></strong>
                        </td>
                        <td>
                            <span class="badge badge-info">
                                <?php echo ucfirst($produk->kategori); ?>
                            </span>
                        </td>
                        <td><?php echo ucfirst($produk->ukuran); ?></td>
                        <td style="font-weight: bold; color: var(--success-color);">
                            Rp <?php echo number_format($produk->harga, 0, ',', '.'); ?>
                        </td>
                        <td><?php echo $produk->deskripsi ? substr($produk->deskripsi, 0, 50) . '...' : '-'; ?></td>
                        <td>
                            <?php if (isset($produk->status) && $produk->status == 'active'): ?>
                            <span class="badge badge-success">Aktif</span>
                            <?php else: ?>
                            <span class="badge badge-secondary">Tidak Aktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="display: flex; gap: 5px; align-items: center;">
                                <a href="<?php echo site_url('produk_jus/detail/' . $produk->id); ?>" 
                                   class="btn btn-sm btn-info" title="Detail">
                                    <i class="fas fa-search-plus"></i>
                                </a>
                                <?php if ($this->session->userdata('role') == 'admin' || $this->session->userdata('role') == 'owner'): ?>
                                <a href="<?php echo site_url('produk_jus/resep/' . $produk->id); ?>" 
                                   class="btn btn-sm btn-success" title="Resep">
                                    <i class="fas fa-clipboard-list"></i> Resep
                                </a>
                                <a href="<?php echo site_url('produk_jus/edit/' . $produk->id); ?>" 
                                   class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?php echo site_url('produk_jus/hapus/' . $produk->id); ?>" 
                                   class="btn btn-sm btn-danger btn-delete" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

