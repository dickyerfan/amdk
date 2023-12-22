<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('barang_produksi/barang_jadi') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                    Jumlah Galon Kembali <?= date('d-m-Y'); ?> : <?= $jumlah_kembali; ?> Galon
                </div>
                <div class="card-body">
                    <form class="user" action="" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label for="tanggal_barang_jadi">Tanggal Barang Jadi :</label>
                                    <input type="date" class="form-control" id="tanggal_barang_jadi" name="tanggal_barang_jadi" value="<?= set_value('tanggal_barang_jadi'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('tanggal_barang_jadi'); ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="form-check mb-2">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <input type="text" name="id_jenis_barang" value="Galon 19 liter" class="form-control mb-2" disabled>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" name="jumlah_barang_jadi" class="form-control mb-2" placeholder="Masukan Jumlah Produksi Galon">
                                            <small class="form-text text-danger pl-3"><?= form_error('jumlah_barang_jadi'); ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-12 text-center">
                                <button class="neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>