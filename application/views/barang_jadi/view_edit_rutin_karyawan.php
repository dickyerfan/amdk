<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('barang_jadi/rutin_karyawan'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('barang_jadi/rutin_karyawan/update') ?>" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-md-5 mb-3">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" id="id_rutin" name="id_rutin" value="<?= $edit_rutin->id_rutin; ?>">
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan Nama Karyawan" value="<?= $edit_rutin->nama; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('nama'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-5 mb-3">
                                <div class="form-group">
                                    <select name="id_bagian" id="id_bagian" class="form-select">
                                        <?php foreach ($bagian as $row) :  ?>
                                            <option value="<?= $row->id_bagian ?>" <?= ($row->id_bagian == $edit_rutin->id_bagian) ? 'selected' : ''; ?>><?= $row->nama_bagian; ?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukan alamat Karyawan" value="<?= $edit_rutin->alamat; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('alamat'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-5 mb-3">
                                <div class="form-group">
                                    <input type="number" class="form-control" id="no_hp" name="no_hp" placeholder="Masukan Telpon Karyawan" value="<?= $edit_rutin->no_hp; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('no_hp'); ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <div for="galon" style="text-align: center;">Galon</div>
                                    <input type="text" class="form-control" id="galon" name="galon" value="<?= $edit_rutin->galon; ?>" style="text-align: center;">
                                    <small class="form-text text-danger pl-3"><?= form_error('galon'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <div for="gelas" style="text-align: center;">Gelas</div>
                                    <input type="text" class="form-control" id="gelas" name="gelas" value="<?= $edit_rutin->gelas; ?>" style="text-align: center;">
                                    <small class="form-text text-danger pl-3"><?= form_error('gelas'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <div for="btl330" style="text-align: center;">Botol 330</div>
                                    <input type="text" class="form-control" id="btl330" name="btl330" value="<?= $edit_rutin->btl330; ?>" style="text-align: center;">
                                    <small class="form-text text-danger pl-3"><?= form_error('btl330'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <div for="btl500" style="text-align: center;">Botol 500</div>
                                    <input type="text" class="form-control" id="btl500" name="btl500" value="<?= $edit_rutin->btl500; ?>" style="text-align: center;">
                                    <small class="form-text text-danger pl-3"><?= form_error('btl500'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <div for="btl1500" style="text-align: center;">Botol 1500</div>
                                    <input type="text" class="form-control" id="btl1500" name="btl1500" value="<?= $edit_rutin->btl1500; ?>" style="text-align: center;">
                                    <small class="form-text text-danger pl-3"><?= form_error('btl1500'); ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-edit"></i> Update Rutin Karyawan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>