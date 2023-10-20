<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('user/admin'); ?>"><button class="btn btn-primary btn-sm float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('user/admin/update') ?>" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="id" id="id" value="<?= $user->id ?>">
                                <div class="form-group">
                                    <label for="nama_pengguna">Nama Pengguna :</label>
                                    <!-- <input type="text" class="form-control" id="nama_pengguna" name="nama_pengguna" value="<?= $user->nama_pengguna; ?>"> -->
                                    <select name="nama_pengguna" id="nama_pengguna" class="form-control select2">
                                        <option value="">Pilih Nama Pengguna</option>
                                        <option value="Manager" <?= $user->nama_pengguna == "Manager" ? 'selected' : '' ?>>Manager</option>
                                        <option value="Barang Baku" <?= $user->nama_pengguna == "Barang Baku" ? 'selected' : '' ?>>Barang Baku</option>
                                        <option value="Barang Produksi" <?= $user->nama_pengguna == "Barang Produksi" ? 'selected' : '' ?>>Barang Produksi</option>
                                        <option value="Barang Jadi" <?= $user->nama_pengguna == "Barang Jadi" ? 'selected' : '' ?>>Barang Jadi</option>
                                        <option value="Pemasaran" <?= $user->nama_pengguna == "Pemasaran" ? 'selected' : '' ?>>Pemasaran</option>
                                        <option value="Keuangan" <?= $user->nama_pengguna == "Keuangan" ? 'selected' : '' ?>>Keuangan </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_lengkap">Nama Lengkap :</label>
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= $user->nama_lengkap; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="upk_bagian">Bagian :</label>
                                    <!-- <input type="text" class="form-control" id="upk_bagian" name="upk_bagian" value="<?= $user->upk_bagian; ?>"> -->
                                    <select name="upk_bagian" id="upk_bagian" class="form-control select2">
                                        <option value="">Pilih Bagian</option>
                                        <option value="admin" <?= $user->upk_bagian == "admin" ? 'selected' : '' ?>>admin</option>
                                        <option value="baku" <?= $user->upk_bagian == "baku" ? 'selected' : '' ?>>baku</option>
                                        <option value="produksi" <?= $user->upk_bagian == "produksi" ? 'selected' : '' ?>>produksi</option>
                                        <option value="jadi" <?= $user->upk_bagian == "jadi" ? 'selected' : '' ?>>jadi</option>
                                        <option value="pasar" <?= $user->upk_bagian == "pasar" ? 'selected' : '' ?>>pasar</option>
                                        <option value="uang" <?= $user->upk_bagian == "uang" ? 'selected' : '' ?>>uang </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Nik Karyawan">Nik Karyawan :</label>
                                    <input type="text" class="form-control" id="nik_karyawan" name="nik_karyawan" value="<?= $user->nik_karyawan; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="level">Level :</label>
                                    <select name="level" id="level" class="form-control">
                                        <option value="Admin" <?= $user->level == 'Admin' ? 'selected' : '' ?>>Admin</option>
                                        <option value="Pengguna" <?= $user->level == 'Pengguna' ? 'selected' : '' ?>>Pengguna</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-sm mt-2" name="tambah" type="submit"><i class="fas fa-save"></i> Update</button>
                    </form>
                </div>
            </div>
        </div>
    </main>