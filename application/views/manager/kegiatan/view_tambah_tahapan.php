<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-1">
            <div class="card border-0">
                <div class="card-header shadow">
                    <div class="row title">
                        <div class="col-9">
                            <!-- <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a> -->
                        </div>
                        <div class="col-3">
                            <a href="<?= base_url('manager/kegiatan'); ?>"><button class="neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card bg-light shadow text-dark">
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label>Judul Tahapan</label>
                                    <input type="text" name="judul_tahapan" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Deskripsi</label>
                                    <textarea name="deskripsi_tahapan" class="form-control"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label>Tanggal</label>
                                    <input type="date" name="tanggal" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Foto (bisa lebih dari satu)</label>
                                    <input type="file" name="foto[]" class="form-control" multiple>
                                </div>
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <a href="<?= site_url('kegiatan/detail/' . $id_kegiatan) ?>" class="btn btn-secondary">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>