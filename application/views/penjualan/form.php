<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-plus-circle"></i> Tambah Penjualan Baru
        </h3>
    </div>
    <div class="card-body">
        <form id="penjualanForm">
            <div class="form-group">
                <label class="form-label"><i class="fas fa-calendar-alt"></i> Tanggal Penjualan <span style="color: red;">*</span></label>
                <input type="datetime-local" class="form-control" id="tanggal_penjualan" name="tanggal_penjualan" required>
            </div>
            
            <div class="form-group">
                <label class="form-label"><i class="fas fa-user"></i> Nama Customer <span style="color: red;">*</span></label>
                <input type="text" class="form-control" id="nama_customer" name="nama_customer" 
                       placeholder="Masukkan nama customer" required>
            </div>
            
            <div class="form-group">
                <label class="form-label"><i class="fas fa-phone"></i> No. HP</label>
                <input type="text" class="form-control" id="no_hp" name="no_hp" 
                       placeholder="Masukkan nomor HP">
            </div>
            
            <div class="form-group">
                <label class="form-label"><i class="fas fa-map-marker-alt"></i> Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3" 
                          placeholder="Masukkan alamat lengkap"></textarea>
            </div>

            <hr>
            <h5 style="margin-bottom: 20px;"><i class="fas fa-list-alt"></i> Detail Produk</h5>
            
            <div class="form-group">
                <label class="form-label"><i class="fas fa-wine-bottle"></i> Pilih Produk</label>
                <select class="form-control" id="produk_id" name="produk_id">
                    <option value="">-- Pilih Produk --</option>
                    <?php if (!empty($produk_jus)): ?>
                        <?php foreach ($produk_jus as $produk): ?>
                            <option value="<?php echo $produk->id; ?>" data-harga="<?php echo $produk->harga; ?>">
                                <?php echo $produk->nama_produk; ?> - Rp <?php echo number_format($produk->harga, 0, ',', '.'); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-hashtag"></i> Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" min="1" value="1">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-dollar-sign"></i> Harga Satuan</label>
                        <input type="text" class="form-control" id="harga_satuan" name="harga_satuan" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">&nbsp;</label>
                        <button type="button" class="btn btn-success btn-block" id="tambahItem">
                            <i class="fas fa-plus-circle"></i> Tambah Item
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="detailTable">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="detailBody">
                        <!-- Detail items akan ditambahkan di sini -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Total</th>
                            <th id="totalHarga">Rp 0</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-check-circle"></i> Simpan Penjualan
                </button>
                <a href="<?php echo site_url('penjualan'); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-circle-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    let detailItems = [];
    let totalHarga = 0;

    // Update harga satuan saat produk dipilih
    $('#produk_id').change(function() {
        let selectedOption = $(this).find('option:selected');
        let harga = selectedOption.data('harga');
        $('#harga_satuan').val(harga ? 'Rp ' + harga.toLocaleString('id-ID') : '');
    });

    // Tambah item ke detail
    $('#tambahItem').click(function() {
        let produkId = $('#produk_id').val();
        let produkNama = $('#produk_id option:selected').text();
        let jumlah = parseInt($('#jumlah').val());
        let hargaSatuan = parseInt($('#produk_id option:selected').data('harga'));

        if (!produkId || !jumlah || !hargaSatuan) {
            alert('Mohon lengkapi semua field');
            return;
        }

        let subtotal = jumlah * hargaSatuan;
        
        let item = {
            produk_id: produkId,
            nama_produk: produkNama,
            jumlah: jumlah,
            harga_satuan: hargaSatuan,
            subtotal: subtotal
        };

        detailItems.push(item);
        updateDetailTable();
        resetForm();
    });

    function updateDetailTable() {
        let html = '';
        totalHarga = 0;

        detailItems.forEach(function(item, index) {
            totalHarga += item.subtotal;
            html += `
                <tr>
                    <td>${item.nama_produk}</td>
                    <td>${item.jumlah}</td>
                    <td>Rp ${item.harga_satuan.toLocaleString('id-ID')}</td>
                    <td>Rp ${item.subtotal.toLocaleString('id-ID')}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="hapusItem(${index})">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            `;
        });

        $('#detailBody').html(html);
        $('#totalHarga').text('Rp ' + totalHarga.toLocaleString('id-ID'));
    }

    function resetForm() {
        $('#produk_id').val('');
        $('#jumlah').val(1);
        $('#harga_satuan').val('');
    }

    window.hapusItem = function(index) {
        detailItems.splice(index, 1);
        updateDetailTable();
    };

    // Submit form
    $('#penjualanForm').submit(function(e) {
        e.preventDefault();

        if (detailItems.length === 0) {
            alert('Mohon tambahkan minimal satu item');
            return;
        }

        let formData = {
            tanggal_penjualan: $('#tanggal_penjualan').val(),
            nama_customer: $('#nama_customer').val(),
            no_hp: $('#no_hp').val(),
            alamat: $('#alamat').val(),
            detail_items: detailItems
        };

        $.ajax({
            url: '<?php echo site_url("penjualan/simpan"); ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Penjualan berhasil disimpan');
                    window.location.href = '<?php echo site_url("penjualan"); ?>';
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat menyimpan data');
            }
        });
    });

    // Set tanggal sekarang
    let now = new Date();
    let datetime = now.getFullYear() + '-' + 
                   String(now.getMonth() + 1).padStart(2, '0') + '-' + 
                   String(now.getDate()).padStart(2, '0') + 'T' + 
                   String(now.getHours()).padStart(2, '0') + ':' + 
                   String(now.getMinutes()).padStart(2, '0');
    $('#tanggal_penjualan').val(datetime);
});
</script>