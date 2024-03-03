<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('pemasaran/pemesanan'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <?php foreach ($edit_jumlah_pesanan as $row) : ?>
                                        <label for="jumlah_pesan" class="mb-2"> Nama Pelanggan : <?= strtoupper($row->nama_pelanggan); ?></label><br>
                                        <label for="jumlah_pesan" class="mb-2">Nama Produk : <?= strtoupper($row->nama_produk); ?></label><br>
                                        <label for="jumlah_pesan" class="mb-2">Jumlah Pesanan :</label>
                                        <input type="hidden" name="id_pelanggan" class=" form-control" value="<?= $row->id_pelanggan ?>">
                                        <input type="hidden" name="id_jenis_barang" class=" form-control" value="<?= $row->id_jenis_barang ?>">
                                        <input type="number" name="jumlah_pesan" class=" form-control" value="<?= $row->jumlah_pesan ?>">
                                    <?php endforeach; ?>
                                    <small class="form-text text-danger pl-3"><?= form_error('jumlah_pesan'); ?></small>
                                </div>
                            </div>
                        </div>
                        <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-edit"></i> Update</button>
                    </form>
                </div>
            </div>
        </div>
    </main>