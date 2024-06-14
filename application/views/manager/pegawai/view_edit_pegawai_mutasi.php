<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('manager/pegawai_mutasi'); ?>"><button class="btn btn-primary btn-sm float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('manager/pegawai_mutasi/update') ?>" method="POST">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="hidden" name="id" id="id" value="<?= $karyawan->id; ?>">
                                <div class="form-group">
                                    <label for="nama">Nama :</label>
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan Nama" value="<?= $karyawan->nama; ?>" disabled>
                                    <small class="form-text text-danger pl-3"><?= form_error('nama'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="alamat">Alamat :</label>
                                    <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukan Alamat" value="<?= $karyawan->alamat; ?>" disabled>
                                    <small class="form-text text-danger pl-3"><?= form_error('alamat'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nik">NIK :</label>
                                    <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukan NIK" value="<?= $karyawan->nik; ?>" disabled>
                                    <small class="form-text text-danger pl-3"><?= form_error('nik'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="id_subag">Bagian :</label>
                                    <select name="id_bagian" id="id_bagian" class="form-control select2">
                                        <option value="">-- Pilih Bagian --</option>
                                        <?php foreach ($bagian as $row) : ?>
                                            <option value="<?= $row->id_bagian ?>" <?= $karyawan->id_bagian == $row->id_bagian ? 'selected' : '' ?>><?= $row->nama_bagian ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('id_bagian'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="id_subag">Sub Bagian / UPK :</label>
                                    <select name="id_subag" id="id_subag" class="form-control select2">
                                        <option value="">-- Pilih Sub Bagian --</option>
                                        <?php foreach ($subag as $row) : ?>
                                            <option value="<?= $row->id_subag ?>" <?= $karyawan->id_subag == $row->id_subag ? 'selected' : '' ?>><?= $row->nama_subag ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('id_subag'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="id_jabatan">Jabatan :</label>
                                    <select name="id_jabatan" id="id_jabatan" class="form-control select2">
                                        <option value="">-- Pilih Jabatan --</option>
                                        <?php foreach ($jabatan as $row) : ?>
                                            <option value="<?= $row->id_jabatan ?>" <?= $karyawan->id_jabatan == $row->id_jabatan ? 'selected' : '' ?>><?= $row->nama_jabatan ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('id_jabatan'); ?></small>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-sm mt-1" name="tambah" type="submit"><i class="fas fa-edit"></i> Update</button>
                    </form>
                </div>
            </div>
        </div>
    </main>