<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('barang_baku/barang_masuk') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('barang_baku/barang_masuk/update_masuk') ?>" method="POST" enctype="multipart/form-data">
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <input type="hidden" name="id_masuk_baku" id="id_masuk_baku" value="<?= $masuk_baku->id_masuk_baku; ?>">
                                <div class="form-group mb-2">
                                    <label for="bukti_masuk_gd">Bukti Transaksi Gudang :</label>
                                    <input type="file" class="form-control" id="bukti_masuk_gd" name="bukti_masuk_gd" value="<?= set_value('bukti_masuk_gd'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('bukti_masuk_gd'); ?></small>
                                    <small class="form-text text-danger pl-3">Bukti Penerimaan Barang dari Gudang</small>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-12 text-center">
                                <button class="neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-edit"></i> Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>