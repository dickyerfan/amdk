<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('manager/pegawai_mutasi'); ?>"><button class="btn btn-primary btn-sm float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('manager/pegawai_mutasi/purnaUpdate') ?>" method="POST">
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
                                    <label for="aktif">Purna Kerja :</label>
                                    <select name="aktif" id="aktif" class="form-control select2">
                                        <option value="">-- Pilih Purna --</option>
                                        <option value="1" <?= $karyawan->aktif == '1' ? 'selected' : '' ?>>Aktif</option>
                                        <option value="0" <?= $karyawan->aktif == '0' ? 'selected' : '' ?>>Purna</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('id_bagian'); ?></small>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-sm mt-1" name="tambah" type="submit"><i class="fas fa-edit"></i> Update</button>
                    </form>
                </div>
            </div>
        </div>
    </main>