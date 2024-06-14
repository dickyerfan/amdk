<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('manager/stok_awal_baku_produksi') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form class="user" action="" method="POST" enctype="multipart/form-data">
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label for="id_barang_baku">Nama Barang Baku :</label>
                                    <select name="id_barang_baku" class="form-select">
                                        <option value=""></option>
                                        <?php foreach ($nama_barang as $row) : ?>
                                            <option value="<?= $row->id_barang_baku ?>"><?= $row->nama_barang_baku; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('id_barang_baku'); ?></small>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="jumlah_stok_awal_baku">Jumlah Stok Awal :</label>
                                    <input type="number" step="1" class="form-control" id="jumlah_stok_awal_baku" name="jumlah_stok_awal_baku" value="<?= set_value('jumlah_stok_awal_baku'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('jumlah_stok_awal_baku'); ?></small>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="tanggal_stok_awal_baku">Tanggal Stok Awal :</label>
                                    <input type="date" class="form-control" id="tanggal_stok_awal_baku" name="tanggal_stok_awal_baku" value="<?= set_value('tanggal_stok_awal_baku'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('tanggal_stok_awal_baku'); ?></small>
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