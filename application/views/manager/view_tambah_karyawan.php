<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('manager/karyawan'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="nama_karyawan" name="nama_karyawan" placeholder="Masukan nama karyawan" value="<?= set_value('nama_karyawan'); ?>">
                                        <small class="form-text text-danger pl-3"><?= form_error('nama_karyawan'); ?></small>
                                    </div>
                                    <small class="form-text text-danger pl-3"><?= form_error('nama_karyawan'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="nik_karyawan" name="nik_karyawan" placeholder="Masukan NIK Karyawan" value="<?= set_value('nik_karyawan'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('nik_karyawan'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="bagian" id="bagian" class="form-control select2">
                                        <option value="">Pilih Bagian</option>
                                        <option value="Manager">Manager</option>
                                        <option value="Barang Baku">Barang Baku</option>
                                        <option value="Produksi">Produksi</option>
                                        <option value="Barang Jadi">Barang Jadi</option>
                                        <option value="Pemasaran">Pemasaran</option>
                                        <option value="Keuangan">Keuangan</option>
                                        <option value="Quality Control">Quality Control</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('bagian'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="jabatan" id="jabatan" class="form-control select2">
                                        <option value="">Pilih Jabatan</option>
                                        <option value="Manager">Manager</option>
                                        <option value="Kabag">Kabag</option>
                                        <option value="Staf">Staf</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('jabatan'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="jenis_kerja" id="jenis_kerja" class="form-control select2">
                                        <option value="">Pilih Jenis Pekerjaan</option>
                                        <option value="Manager">Manager</option>
                                        <option value="Administrasi">Administrasi</option>
                                        <option value="Driver">Driver</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('jenis_kerja'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="jenkel" id="jenkel" class="form-control">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('jabatan'); ?></small>
                                </div>
                            </div>

                        </div>
                        <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </main>