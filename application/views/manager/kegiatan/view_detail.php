<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('manager/kegiatan'); ?>"><button class="neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <h2><?= $kegiatan->nama_kegiatan ?></h2>
                            <!-- <p><?= $kegiatan->deskripsi ?></p> -->
                            <h5><strong>Ketua Tim :</strong> <?= $kegiatan->ketua_tim ?></h5>

                            <div class="d-flex justify-content-between mb-3">
                                <h4>Tahapan Kegiatan</h4>
                                <a href="<?= site_url('manager/kegiatan/tambah_tahapan/' . $kegiatan->id) ?>" class="btn btn-primary">+ Tambah Tahapan</a>
                            </div>

                            <?php foreach ($tahapan as $t) : ?>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5><?= $t->judul_tahapan ?> <small class="text-muted">(<?= $t->tanggal ?>)</small></h5>
                                        <p><?= $t->deskripsi_tahapan ?></p>
                                        <?php if (!empty($t->foto)) : ?>
                                            <div class="d-flex flex-wrap">
                                                <?php foreach ($t->foto as $f) : ?>
                                                    <img src="<?= base_url('uploads/tahapan/' . $f->nama_file) ?>" class="img-thumbnail me-2 mb-2" style="width:150px">
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <!-- <div class="card shadow p-4">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Jenis Arsip</td>
                                            <td> : </td>
                                            <td class="fw-bold text-primary text-uppercase"><?= $detail_arsip->jenis; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Tahun</td>
                                            <td> : </td>
                                            <td class="fw-bold"><?= $detail_arsip->tahun; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Nama Arsip</td>
                                            <td> : </td>
                                            <td class="fw-bold"><?= $detail_arsip->nama_dokumen; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Tentang</td>
                                            <td> : </td>
                                            <td class="fw-bold"><?= $detail_arsip->tentang; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Dokumen</td>
                                            <td> : </td>
                                            <td class="fw-bold"><?= $detail_arsip->tgl_dokumen; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Upload </td>
                                            <td> : </td>
                                            <td class="fw-bold"><?= $detail_arsip->tgl_upload; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Keterangan</td>
                                            <td> : </td>
                                            <td class="fw-bold"><?= $detail_arsip->keterangan; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>