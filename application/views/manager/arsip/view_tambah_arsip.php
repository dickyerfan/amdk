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
                            <!-- <a href="<?= base_url('arsip') ?>" class="neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</a> -->
                            <a href="<?= base_url('manager/arsip'); ?>"><button class="neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="card bg-light shadow text-dark">
                        <div class="card-body">
                            <form action="<?= base_url('manager/arsip/tambah') ?>" method="POST" enctype="multipart/form-data">
                                <div class="row justify-content-center mb-1">
                                    <div class="col-md-6">
                                        <div class="form-group mb-1">
                                            <label for="" class="form-label">Nama File :</label>
                                            <input type="file" name="nama_file" class="form-control" required>
                                            <small class="form-text text-danger pl-3"><?= form_error('nama_file'); ?></small>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="" class="form-label">Jenis Dokumen :</label>
                                            <select name="jenis" id="" class="form-select">
                                                <option value="">Pilih...</option>
                                                <option value="Surat Keputusan">Surat Keputusan</option>
                                                <option value="Peraturan">Peraturan</option>
                                                <option value="Berkas Kerja">Berkas Kerja</option>
                                                <option value="Dokumen">Dokumen</option>
                                            </select>
                                            <small class="form-text text-danger pl-3"><?= form_error('jenis'); ?></small>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="" class="form-label">Nama Dokumen :</label>
                                            <input type="text" name="nama_dokumen" class="form-control" value="<?= set_value('nama_dokumen'); ?>">
                                            <small class="form-text text-danger pl-3"><?= form_error('nama_dokumen'); ?></small>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="" class="form-label">Tahun :</label>
                                            <input type="text" name="tahun" class="form-control" value="<?= set_value('tahun'); ?>">
                                            <small class="form-text text-danger pl-3"><?= form_error('tahun'); ?></small>
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="" class="form-label">Tanggal Dokumen :</label>
                                            <input type="date" name="tgl_dokumen" class="form-control" value="<?= set_value('tgl_dokumen'); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- <div class="form-group mb-1">
                                            <label for="" class="form-label">Tanggal Upload :</label>
                                            <input type="date" name="tgl_upload" class="form-control" value="<?= set_value('tgl_upload'); ?>">
                                            <small class="form-text text-danger pl-3"><?= form_error('tgl_upload'); ?></small>
                                        </div> -->
                                        <div class="form-group mb-1">
                                            <label for="" class="form-label">Tentang :</label>
                                            <!-- <input type="text" name="tentang" class="form-control" required> -->
                                            <textarea name="tentang" id="" rows="5" class="form-control"><?= set_value('tentang'); ?></textarea>
                                            <small class="form-text text-danger pl-3"><?= form_error('tentang'); ?></small>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="" class="form-label">Keterangan :</label>
                                            <!-- <input type="text" name="keterangan" class="form-control"> -->
                                            <textarea name="keterangan" id="" rows="5" class="form-control"></textarea>
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