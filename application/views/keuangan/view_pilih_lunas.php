<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('keuangan/penjualan'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <div class="form-control"><?= $lunas[0]->nama_pelanggan; ?> </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-control"><?= $lunas[0]->jumlah_pesan ?> <?= $lunas[0]->nama_produk ?></div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col">
                                            <div class="form-control fs-2">Rp. <?= number_format($lunas[0]->total_harga, 0, ',', '.'); ?> ,-</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <select name="status_bayar" id="status_bayar" class="form-control select2">
                                                <option value="">Pilih Status</option>
                                                <option value="0" <?= $lunas == 0 ? 'selected' : '' ?>>Belum Lunas</option>
                                                <option value="1" <?= $lunas == 1 ? 'selected' : '' ?>>Lunas</option>
                                            </select>
                                            <small class="form-text text-danger pl-3"><?= form_error('status_bayar'); ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-credit-card"></i> Bayar</button>
                    </form>
                </div>
            </div>
        </div>
    </main>