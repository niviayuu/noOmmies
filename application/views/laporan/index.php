<?php $this->load->view('templates/header'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                        <h3 class="card-title">Menu Laporan</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h5>Laporan Penjualan</h5>
                                    <p>Laporan penjualan berdasarkan periode</p>
                                    <a href="<?= base_url('laporan/penjualan') ?>" class="btn btn-light">
                                        Lihat Laporan
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h5>Laporan Pembelian</h5>
                                    <p>Laporan pembelian bahan baku</p>
                                    <a href="<?= base_url('laporan/pembelian') ?>" class="btn btn-light">
                                        Lihat Laporan
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h5>Laporan Stok</h5>
                                    <p>Laporan kondisi stok bahan baku</p>
                                    <a href="<?= base_url('laporan/stok') ?>" class="btn btn-light">
                                        Lihat Laporan
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h5>Laporan Harian</h5>
                                    <p>Laporan penjualan harian</p>
                                    <a href="<?= base_url('laporan/harian') ?>" class="btn btn-light">
                                        Lihat Laporan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('templates/footer'); ?>
