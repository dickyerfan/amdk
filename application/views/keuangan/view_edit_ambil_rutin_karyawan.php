<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('keuangan/ambil_rutin_karyawan'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('keuangan/ambil_rutin_karyawan/update') ?>" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-md-5 mb-3">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" id="id_ambil_rutin" name="id_ambil_rutin" value="<?= $edit_rutin->id_ambil_rutin; ?>">
                                    <div for="nama" class="mb-2" style="text-align: center;">Nama Karyawan :</div>
                                    <input type="text" class="form-control text-center" id="nama" name="nama" value="<?= $edit_rutin->nama; ?>" disabled style="font-size: 1.5rem;">
                                    <small class="form-text text-danger pl-3"><?= form_error('nama'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-5 mb-3">
                                <div class="form-group">
                                    <div for="id_bagian" class="mb-2" style="text-align: center;">Bagian / UPK :</div>
                                    <input type="text" class="form-control text-center" id="id_bagian" name="id_bagian" value="<?= $edit_rutin->nama_bagian; ?>" disabled style="font-size: 1.5rem;">
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <div for="galon" style="text-align: center;">Galon</div>
                                    <input type="text" class="form-control text-center" id="galon" name="galon" value="<?= $edit_rutin->galon; ?>" disabled>
                                    <small class="form-text text-danger pl-3"><?= form_error('galon'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <div for="gelas" style="text-align: center;">Gelas</div>
                                    <input type="text" class="form-control text-center" id="gelas" name="gelas" value="<?= $edit_rutin->gelas; ?>" disabled>
                                    <small class="form-text text-danger pl-3"><?= form_error('gelas'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <div for="btl330" style="text-align: center;">Botol 330</div>
                                    <input type="text" class="form-control text-center" id="btl330" name="btl330" value="<?= $edit_rutin->btl330; ?>" disabled>
                                    <small class="form-text text-danger pl-3"><?= form_error('btl330'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <div for="btl500" style=" text-align: center;">Botol 500</div>
                                    <input type="text" class="form-control text-center" id="btl500" name="btl500" value="<?= $edit_rutin->btl500; ?>" disabled>
                                    <small class="form-text text-danger pl-3"><?= form_error('btl500'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <div for="btl1500" style=" text-align: center;">Botol 1500</div>
                                    <input type="text" class="form-control text-center" id="btl1500" name="btl1500" value="<?= $edit_rutin->btl1500; ?>" disabled>
                                    <small class="form-text text-danger pl-3"><?= form_error('btl1500'); ?></small>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row justify-content-center">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <div class="mb-3" style="text-align: center;">Pilih Status Ambil</div>
                                    <select name="status" id="status" class="form-control select2">
                                        <option value="1" <?= $edit_rutin->status == '1' ? 'selected' : '' ?>>Ambil</option>
                                        <option value="0" <?= $edit_rutin->status == '0' ? 'selected' : '' ?>>Belum Ambil</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('status'); ?></small>
                                </div>
                            </div>
                        </div> -->
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-dolly"></i> Ambil Rutin Karyawan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>