<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('manager/karyawan'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('manager/karyawan/update') ?>" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="id_karyawan" name="id_karyawan" value="<?= $edit_karyawan->id_karyawan; ?>">
                                        <input type="text" class="form-control" id="nama_karyawan" name="nama_karyawan" placeholder="Masukan nama karyawan" value="<?= $edit_karyawan->nama_karyawan; ?>">
                                        <small class="form-text text-danger pl-3"><?= form_error('nama_karyawan'); ?></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="nik_karyawan" name="nik_karyawan" placeholder="Masukan NIK Karyawan" value="<?= $edit_karyawan->nik_karyawan; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('nik_karyawan'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="bagian" id="bagian" class="form-control">
                                        <option value="">Pilih Bagian</option>
                                        <option value="Manager" <?= $edit_karyawan->bagian == 'Manager' ? 'selected' : '' ?>>Manager</option>
                                        <option value="Barang Baku" <?= $edit_karyawan->bagian == 'Barang Baku' ? 'selected' : '' ?>>Barang Baku</option>
                                        <option value="Produksi" <?= $edit_karyawan->bagian == 'Produksi' ? 'selected' : '' ?>>Produksi</option>
                                        <option value="Barang Jadi" <?= $edit_karyawan->bagian == 'Barang Jadi' ? 'selected' : '' ?>>Barang Jadi</option>
                                        <option value="Pemasaran" <?= $edit_karyawan->bagian == 'Pemasaran' ? 'selected' : '' ?>>Pemasaran</option>
                                        <option value="Keuangan" <?= $edit_karyawan->bagian == 'Keuangan' ? 'selected' : '' ?>>Keuangan</option>
                                        <option value="Quality Control" <?= $edit_karyawan->bagian == 'Quality Control' ? 'selected' : '' ?>>Quality Control</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('bagian'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="jabatan" id="jabatan" class="form-control">
                                        <option value="">Pilih Jabatan</option>
                                        <option value="Manager" <?= $edit_karyawan->jabatan == 'Manager' ? 'selected' : '' ?>>Manager</option>
                                        <option value="Kabag" <?= $edit_karyawan->jabatan == 'Kabag' ? 'selected' : '' ?>>Kabag</option>
                                        <option value="Staf" <?= $edit_karyawan->jabatan == 'Staf' ? 'selected' : '' ?>>Staf</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('jabatan'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="jenis_kerja" id="jenis_kerja" class="form-control">
                                        <option value="">Pilih Jenis Pekerjaan</option>
                                        <option value="Manager" <?= $edit_karyawan->jenis_kerja == 'Manager' ? 'selected' : '' ?>>Manager</option>
                                        <option value="Administrasi" <?= $edit_karyawan->jenis_kerja == 'Administrasi' ? 'selected' : '' ?>>Administrasi</option>
                                        <option value="Driver" <?= $edit_karyawan->jenis_kerja == 'Driver' ? 'selected' : '' ?>>Driver</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('jabatan'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="jenkel" id="jenkel" class="form-control">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki" <?= $edit_karyawan->jenkel == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                                        <option value="Perempuan" <?= $edit_karyawan->jenkel == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('jenkel'); ?></small>
                                </div>
                            </div>

                        </div>
                        <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-edit"></i> update</button>
                    </form>
                </div>
            </div>
        </div>
    </main>