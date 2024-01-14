<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('barang_produksi/pengembalian_galon') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form class="user" action="" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label for="tanggal_kembali">Tanggal Kembali :</label>
                                    <?php
                                    // Set tanggal hari ini
                                    $today = date('Y-m-d');
                                    ?>
                                    <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" value="<?= set_value('tanggal_kembali', $today); ?>">
                                    <!-- <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" value="<?= set_value('tanggal_kembali', $today); ?>" min="<?= $today; ?>" max="<?= $today; ?>"> -->
                                    <small class="form-text text-danger pl-3"><?= form_error('tanggal_kembali'); ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="form-check mb-2">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <input type="text" name="id_jenis_barang" value="Galon Pengembalian" class="form-control mb-2" disabled>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" name="jumlah_kembali" class="form-control mb-2" placeholder="Masukan Jumlah Galon Kembali">
                                            <small class="form-text text-danger pl-3"><?= form_error('jumlah_kembali'); ?></small>
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