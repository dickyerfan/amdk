<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('keuangan/penerimaan') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="container mt-2">
                    <div class="row justify-content-center">
                        <div class="col-md-5 neumorphic-button">
                            <div class="card-body text-center">
                                <?php
                                if (!empty($pesan)) {
                                    $totalPenerimaan = $pesan[0]->total_penerimaan;
                                    echo "<h4 class='card-title text-primary'>Total Penerimaan tanggal " . date('d-m-Y', strtotime($tanggal_setor))  . "</h4>";
                                    echo "<h5 class='card-text text-primary fs-4'>Rp. " . number_format($totalPenerimaan, 0, ',', '.') . "</h5>";
                                } else {
                                    echo "<h5 class='card-text text-danger fs-4'>Hari ini belum ada data penerimaan</h5>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body mt-3">
                    <form class="user" action="<?= base_url('keuangan/penerimaan/update_nota_setor') ?>" method="POST" enctype="multipart/form-data">
                        <div class="row justify-content-center">
                            <div class="col-md-5">
                                <div class="form-group mb-4">
                                    <label for="tanggal_setor" class="mb-3">Tanggal Setor :</label>
                                    <input type="hidden" class="form-control" id="tanggal_bayar" name="tanggal_bayar" value="<?= $tanggal_setor ?>">
                                    <input type="datetime-local" class="form-control" id="tanggal_setor" name="tanggal_setor" value="<?= set_value('tanggal_setor', date('Y-m-d')); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('tanggal_setor'); ?></small>
                                </div>
                                <div class="form-group mb-5">
                                    <label for="nota_setor" class="mb-3">Bukti Transaksi :</label>
                                    <input type="file" class="form-control" id="nota_setor" name="nota_setor" value="<?= set_value('nota_setor'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('nota_setor'); ?></small>
                                    <!-- <small class="form-text text-danger pl-3">Sertakan foto pendukung jika dibutuhkan</small> -->
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center mb-5">
                            <div class="col-md-12 text-center">
                                <button class="neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>