<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('keuangan/karyawan_produksi/absensi_karyawan'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <!-- <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div> -->
                <div class="card-body">
                    <div class="row ms-4">
                        <div class="col-auto">
                            <form method="post" action="">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-6"><label for="tanggal">Tanggal Absen:</label></div>
                                        <div class="col-lg-6"><input type="date" class="form-control" name="tanggal"></div>
                                    </div>
                                    <small class="form-text text-danger pl-3"><?= form_error('tanggal'); ?></small>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-6"><label for="karyawan">Daftar Karyawan:</label></div>
                                        <div class="col-lg-6">
                                            <?php foreach ($karyawan as $karyawan_produksi) { ?>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="karyawan[]" value="<?php echo $karyawan_produksi['id_karyawan_produksi']; ?>">
                                                    <label class="form-check-label"><?php echo $karyawan_produksi['nama_karyawan_produksi']; ?></label>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6"></div>
                                    <div class="col-lg-6"> <button type="submit" class="btn btn-primary">Simpan</button></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>