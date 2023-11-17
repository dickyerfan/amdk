<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('barang_jadi/barang_rusak') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
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
                                    <label for="id_jenis_barang">Nama Barang Rusak :</label>
                                    <select name="id_jenis_barang" class="form-select select2">
                                        <option value=""></option>
                                        <?php foreach ($nama_barang as $row) : ?>
                                            <option value="<?= $row->id_jenis_barang ?>"><?= $row->nama_barang_jadi; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('id_jenis_barang'); ?></small>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="jumlah_rusak_jadi">Jumlah Barang Rusak :</label>
                                    <input type="number" step="1" class="form-control" id="jumlah_rusak_jadi" name="jumlah_rusak_jadi" value="<?= set_value('jumlah_rusak_jadi'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('jumlah_rusak_jadi'); ?></small>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="tanggal_rusak_jadi">Tanggal Barang rusak :</label>
                                    <input type="date" step="1" class="form-control" id="tanggal_rusak_jadi" name="tanggal_rusak_jadi" value="<?= set_value('tanggal_rusak_jadi'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('tanggal_rusak_jadi'); ?></small>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="bukti_rusak_jadi">Bukti Transaksi :</label>
                                    <input type="file" class="form-control" id="bukti_rusak_jadi" name="bukti_rusak_jadi" value="<?= set_value('bukti_rusak_jadi'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('bukti_rusak_jadi'); ?></small>
                                    <!-- <small class="form-text text-danger pl-3">Sertakan foto pendukung jika dibutuhkan</small> -->
                                </div>
                                <div class="form-group mb-2">
                                    <label for="keterangan">Keterangan :</label>
                                    <!-- <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?= set_value('keterangan'); ?>"> -->
                                    <textarea name="keterangan" id="keterangan" cols="30" rows="6" class="form-control"><?= set_value('keterangan'); ?></textarea>
                                    <small class="form-text text-danger pl-3"><?= form_error('keterangan'); ?></small>
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