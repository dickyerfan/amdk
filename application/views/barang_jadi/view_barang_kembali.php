<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('barang_jadi/barang_keluar'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-md-5 mb-3">
                                <div class="card">
                                    <div class="card-header">
                                        Keterangan Barang :
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">Nama Barang : <?= strtoupper($nama_barang_jadi); ?></li>
                                        <li class="list-group-item">Jumlah Barang : <?= strtoupper($jumlah_keluar); ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-5 mb-3">
                                <div class="form-group">
                                    <input type="text" name="jumlah_kembali" id="jumlah_kembali" class="form-control" placeholder="Masukkan jumlah barang kembali">
                                    <small class="form-text text-danger pl-3"><?= form_error('jumlah_kembali'); ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-5 mb-3 text-center">
                                <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>