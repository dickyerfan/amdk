<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('user/admin'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="nama_pengguna" id="nama_pengguna" class="form-control select2">
                                        <option value="">Pilih Nama Pengguna</option>
                                        <option value="Barang Baku">Barang Baku</option>
                                        <option value="Barang Produksi">Barang Produksi</option>
                                        <option value="Barang Jadi">Barang Jadi</option>
                                        <option value="Pemasaran">Pemasaran</option>
                                        <option value="Keuangan	">Keuangan </option>
                                        <option value="Quality Control	">Quality Control </option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('nama_pengguna'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="nama_lengkap" id="nama_lengkap" class="form-control select2">
                                        <option value="">Pilih Nama Karyawan</option>
                                        <?php foreach ($data_karyawan as $row) : ?>
                                            <option value="<?= $row->nama_karyawan; ?>"><?= $row->nama_karyawan; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <!-- <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Masukan nama lengkap" value="<?= set_value('nama_lengkap'); ?>"> -->
                                    <small class="form-text text-danger pl-3"><?= form_error('nama_lengkap'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="upk_bagian" id="upk_bagian" class="form-control select2">
                                        <option value="">Pilih Bagian</option>
                                        <option value="baku">baku</option>
                                        <option value="produksi">produksi</option>
                                        <option value="jadi">jadi</option>
                                        <option value="pasar">pasar</option>
                                        <option value="uang">uang</option>
                                        <option value="contro">control</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('upk_bagian'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukan password" value="<?= set_value('password'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('password'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="nik_karyawan" name="nik_karyawan" placeholder="Masukan NIK Karyawan" value="<?= set_value('nik_karyawan'); ?>">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="level" id="level" class="form-control">
                                        <option value="Admin">Admin</option>
                                        <option value="Pengguna" selected>Pengguna</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </main>