<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('satuan') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('satuan/update') ?>" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <input type="hidden" name="id_satuan" id="id_satuan" value="<?= $edit_satuan->id_satuan; ?>">
                                <div class="form-group">
                                    <label for="satuan">Nama Satuan Barang :</label>
                                    <input type="text" class="form-control" id="satuan" name="satuan" value="<?= $edit_satuan->satuan; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('satuan'); ?></small>
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