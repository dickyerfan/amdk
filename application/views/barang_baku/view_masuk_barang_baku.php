<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('barang_baku/barang_masuk') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form class="user" action="" method="POST" enctype="multipart/form-data">
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label for="id_barang_baku">Nama Barang Baku :</label>
                                    <select name="id_barang_baku" class="form-select select2">
                                        <option value=""></option>
                                        <?php foreach ($nama_barang as $row) : ?>
                                            <option value="<?= $row->id_barang_baku ?>"><?= $row->nama_barang_baku; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('id_barang_baku'); ?></small>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="jumlah_masuk">Jumlah Barang Masuk :</label>
                                    <input type="number" step="1" class="form-control" id="jumlah_masuk" name="jumlah_masuk" value="<?= set_value('jumlah_masuk'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('jumlah_masuk'); ?></small>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="tanggal_masuk">Tanggal Barang Masuk :</label>
                                    <input type="date" step="1" class="form-control" id="tanggal_masuk" name="tanggal_masuk" value="<?= set_value('tanggal_masuk'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('tanggal_masuk'); ?></small>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="bukti_masuk_sj">Bukti Transaksi :</label>
                                    <input type="file" class="form-control" id="bukti_masuk_sj" name="bukti_masuk_sj" value="<?= set_value('bukti_masuk_sj'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('bukti_masuk_sj'); ?></small>
                                    <!-- <small class="form-text text-danger pl-3">Sertakan foto pendukung jika dibutuhkan</small> -->
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