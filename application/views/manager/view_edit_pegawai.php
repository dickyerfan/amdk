<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('manager/pegawai'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('manager/pegawai/update') ?>" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="id" name="id" value="<?= $edit_pegawai->id; ?>">
                                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan nama karyawan" value="<?= $edit_pegawai->nama; ?>">
                                        <small class="form-text text-danger pl-3"><?= form_error('nama'); ?></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="id_bagian" id="id-Bagian" class="form-select">
                                        <?php foreach ($bagian as $row) :  ?>
                                            <option value="<?= $row->id_bagian ?>" <?= ($row->id_bagian == $edit_pegawai->id_bagian) ? 'selected' : ''; ?>><?= $row->nama_bagian; ?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('id_bagian'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukan alamat Karyawan" value="<?= $edit_pegawai->alamat; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('alamat'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukan NIK Karyawan" value="<?= $edit_pegawai->nik; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('nik'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="agama" name="agama" placeholder="Masukan agama Karyawan" value="<?= $edit_pegawai->agama; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('agama'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="status_pegawai" id="status_pegawai" class="form-select">
                                        <option value="">Pilih Status Pegawai</option>
                                        <option value="Karyawan Tetap" <?= $edit_pegawai->status_pegawai == 'Karyawan Tetap' ? 'selected' : '' ?>>Karyawan Tetap</option>
                                        <option value="Karyawan Kontrak" <?= $edit_pegawai->status_pegawai == 'Karyawan Kontrak' ? 'selected' : '' ?>>Karyawan Kontrak</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('jabatan'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Masukan no hp Karyawan" value="<?= $edit_pegawai->no_hp; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('no_hp'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="jenkel" id="jenkel" class="form-select">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki" <?= $edit_pegawai->jenkel == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                                        <option value="Perempuan" <?= $edit_pegawai->jenkel == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('jabatan'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="aktif" id="aktif" class="form-select">
                                        <option value="">Pilih Status Aktif</option>
                                        <option value="1" <?= $edit_pegawai->aktif == '1' ? 'selected' : '' ?>>Aktif</option>
                                        <option value="0" <?= $edit_pegawai->aktif == '0' ? 'selected' : '' ?>>Purna</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('aktif'); ?></small>
                                </div>
                            </div>

                        </div>
                        <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-edit"></i> update</button>
                    </form>
                </div>
            </div>
        </div>
    </main>