<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('jenis_barang') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('jenis_barang/update') ?>" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <input type="hidden" name="id_jenis_barang" id="id_jenis_barang" value="<?= $edit_jenis->id_jenis_barang; ?>">
                                <div class="form-group">
                                    <label for="jenis_barang">Nama Jenis Barang :</label>
                                    <input type="text" class="form-control" id="jenis_barang" name="jenis_barang" value="<?= $edit_jenis->jenis_barang; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('jenis_barang'); ?></small>
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