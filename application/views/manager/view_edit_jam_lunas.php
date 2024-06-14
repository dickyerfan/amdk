<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('manager/jam_lunas'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('manager/jam_lunas/update') ?>" method="POST">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" id="id_jam_lunas" name="id_jam_lunas" value="<?= $edit_jam_lunas->id_jam_lunas; ?>">
                                    <label for="jam_setting" class="mb-2 fw-bold">Jam Pelunasan :</label>
                                    <input type="text" class="form-control" id="jam_setting" name="jam_setting" placeholder="Masukan jam_setting" value="<?= $edit_jam_lunas->jam_setting; ?>" style="font-size: 2rem;">
                                    <small class="form-text text-danger pl-3"><?= form_error('jam_setting'); ?></small>
                                </div>
                            </div>
                        </div>
                        <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-edit"></i> Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </main>