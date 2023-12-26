<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('barang_jadi/rutin_karyawan'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-md-5 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan Nama Karyawan" value="<?= set_value('nama'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('nama'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-5 mb-3">
                                <div class="form-group">
                                    <select name="id_bagian" id="id_bagian" class="form-select">
                                        <option value="">Pilih Bagian</option>
                                        <?php foreach ($bagian as $row) :  ?>
                                            <option value="<?= $row->id_bagian ?>"><?= $row->nama_bagian; ?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('id_bagian'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-5 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukan alamat Karyawan" value="<?= set_value('alamat'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('alamat'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-5 mb-3">
                                <div class="form-group">
                                    <input type="number" class="form-control" id="no_hp" name="no_hp" placeholder="Masukan Telpon Karyawan" value="<?= set_value('no_hp'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('no_hp'); ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <label for="galon">Galon</label>
                                    <input type="text" class="form-control" id="galon" name="galon" value="<?= set_value('galon'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('galon'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <label for="gelas">Gelas</label>
                                    <input type="text" class="form-control" id="gelas" name="gelas" value="<?= set_value('gelas'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('gelas'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <label for="btl330">Botol 330</label>
                                    <input type="text" class="form-control" id="btl330" name="btl330" value="<?= set_value('btl330'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('btl330'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <label for="btl500">Botol 500</label>
                                    <input type="text" class="form-control" id="btl500" name="btl500" value="<?= set_value('btl500'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('btl500'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <label for="btl1500">Botol 1500</label>
                                    <input type="text" class="form-control" id="btl1500" name="btl1500" value="<?= set_value('btl1500'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('btl1500'); ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-save"></i> Tambah Karyawan Baru</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>