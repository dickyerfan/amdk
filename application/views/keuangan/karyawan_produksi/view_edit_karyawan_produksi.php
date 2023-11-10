<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('keuangan/karyawan_produksi'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('keuangan/karyawan_produksi/update') ?>" method="POST">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="id_karyawan_produksi" name="id_karyawan_produksi" value="<?= $edit_karyawan_produksi->id_karyawan_produksi; ?>">
                                        <input type="text" class="form-control" id="nama_karyawan_produksi" name="nama_karyawan_produksi" placeholder="Masukan nama karyawan" value="<?= $edit_karyawan_produksi->nama_karyawan_produksi; ?>">
                                        <small class="form-text text-danger pl-3"><?= form_error('nama_karyawan_produksi'); ?></small>
                                    </div>
                                    <small class="form-text text-danger pl-3"><?= form_error('nama_karyawan_produksi'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <select name="jenkel" id="jenkel" class="form-control">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki" <?= $edit_karyawan_produksi->jenkel == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                                        <option value="Perempuan" <?= $edit_karyawan_produksi->jenkel == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('jabatan'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <select name="status" id="status" class="form-control">
                                        <option value="">Pilih Status</option>
                                        <option value="1" <?= $edit_karyawan_produksi->status == '1' ? 'selected' : '' ?>>Aktif</option>
                                        <option value="0" <?= $edit_karyawan_produksi->status == '0' ? 'selected' : '' ?>>Non Aktif</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('status'); ?></small>
                                </div>
                            </div>

                        </div>
                        <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-edit"></i> update</button>
                    </form>
                </div>
            </div>
        </div>
    </main>