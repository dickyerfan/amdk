<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('barang_produksi/permintaan_barang_baku') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form class="user" action="" method="POST" enctype="multipart/form-data">
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tanggal_keluar">Tanggal Permintaan Barang Baku :</label>
                                    <input type="date" class="form-control" id="tanggal_keluar" name="tanggal_keluar" value="<?= set_value('tanggal_keluar', date('Y-m-d')); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('tanggal_keluar'); ?></small>
                                </div>
                            </div>
                            <!-- <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bukti_keluar_gd">Foto Pendukung :</label>
                                    <input type="file" class="form-control" id="bukti_keluar_gd" name="bukti_keluar_gd" value="<?= set_value('bukti_keluar_gd'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('bukti_keluar_gd'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="no_nota">No Nota :</label>
                                    <input type="text" class="form-control" id="no_nota" name="no_nota" value="<?= set_value('no_nota'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('no_nota'); ?></small>
                                </div>
                            </div> -->
                        </div>
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-12">
                                <div class="form-check mb-2">
                                    <div class="row">
                                        <?php $index = 0; ?>
                                        <?php foreach ($nama_barang as $row) : ?>
                                            <div class="col-lg-3">
                                                <input type="checkbox" name="id_barang_baku[<?= $row->id_barang_baku; ?>]" value="<?= $row->id_barang_baku; ?>">
                                                <?= strtoupper($row->nama_barang_baku); ?>
                                                <small class="form-text text-danger pl-3"><?= form_error('id_jenis_barang'); ?></small>
                                                <input type="text" name="jumlah_keluar[<?= $row->id_barang_baku; ?>]" class="form-control mb-2">
                                                <small class="form-text text-danger pl-3"><?= form_error('jumlah_keluar'); ?></small>
                                            </div>

                                            <?php if ($index % 4 == 3 || $index == count($nama_barang) - 1) : ?>
                                    </div>
                                    <div class="row">
                                    <?php endif; ?>

                                    <?php $index++; ?>
                                <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-md-12 text-center">
                                <button class="neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>