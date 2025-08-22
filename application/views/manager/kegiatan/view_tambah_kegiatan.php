<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-1">
            <div class="card border-0">
                <div class="card-header shadow">
                    <div class="row title">
                        <div class="col-9">
                            <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                        </div>
                        <div class="col-3">
                            <a href="<?= base_url('manager/kegiatan'); ?>"><button class="neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card bg-light shadow text-dark">
                        <div class="card-body">
                            <form action="<?= base_url('manager/kegiatan/tambah') ?>" method="POST">
                                <div class="row justify-content-center mb-1">
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label for="nama_kegiatan" class="form-label">Nama Kegiatan :</label>
                                            <input type="text" name="nama_kegiatan" class="form-control" required>
                                            <small class="form-text text-danger pl-3"><?= form_error('nama_kegiatan'); ?></small>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="deskripsi" class="form-label">Deskripsi :</label>
                                            <textarea name="deskripsi" id="deskripsi" class="form-control"></textarea>
                                            <small class="form-text text-danger pl-3"><?= form_error('deskripsi'); ?></small>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="ketua_tim" class="form-label">Ketua Tim :</label>
                                            <input type="text" name="ketua_tim" class="form-control" required>
                                            <small class="form-text text-danger pl-3"><?= form_error('ketua_tim'); ?></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center mb-1">
                                    <div class="col-md-4">
                                        <div class="d-grid gap-2">
                                            <button type="submit" name="add_post" id="tombol_pilih" class="neumorphic-button">Upload File</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>