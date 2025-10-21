<?php $this->load->view('templates/header'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-search-plus"></i> Detail Penjualan
                    </h3>
                    <div class="card-tools">
                        <a href="<?= base_url('penjualan') ?>" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-circle-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($penjualan)): ?>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Informasi Penjualan</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>No. Transaksi:</strong></td>
                                        <td><?= $penjualan->no_transaksi ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal:</strong></td>
                                        <td><?= date('d/m/Y H:i', strtotime($penjualan->tanggal_transaksi)) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Customer:</strong></td>
                                        <td><?= $penjualan->nama_pembeli ?: 'Walk-in Customer' ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Metode Pembayaran:</strong></td>
                                        <td><?= ucfirst($penjualan->metode_pembayaran) ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Keterangan:</strong></td>
                                        <td><?= $penjualan->keterangan ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5>Ringkasan</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Total Item:</strong></td>
                                        <td><?= count($detail_penjualan) ?> produk</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Harga:</strong></td>
                                        <td><strong>Rp <?= number_format($penjualan->total_harga, 0, ',', '.') ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td><span class="badge badge-success">Selesai</span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <hr>

                        <h5>Detail Produk</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Produk</th>
                                        <th>Jumlah</th>
                                        <th>Harga Satuan</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($detail_penjualan)): ?>
                                        <?php foreach ($detail_penjualan as $index => $detail): ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= $detail->nama_produk ?></td>
                                                <td><?= $detail->jumlah ?></td>
                                                <td>Rp <?= number_format($detail->harga_satuan, 0, ',', '.') ?></td>
                                                <td>Rp <?= number_format($detail->subtotal, 0, ',', '.') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada detail produk</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4">Total</th>
                                        <th>Rp <?= number_format($penjualan->total_harga, 0, ',', '.') ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="mt-3">
                            <button onclick="window.print()" class="btn btn-primary">
                                <i class="fas fa-print"></i> Cetak
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Data penjualan tidak ditemukan
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .card-header, .card-tools, .btn {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>

<?php $this->load->view('templates/footer'); ?>