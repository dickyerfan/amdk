<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('barang_produksi/barang_keluar') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form class="user" action="" method="POST">
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="id_barang_baku">Nama Barang Baku :</label>
                                    <select name="id_barang_baku" id="id_barang_baku" class="form-select">
                                        <option value="">Pilih Barang</option>
                                        <?php foreach ($nama_barang as $row) : ?>
                                            <option value="<?= $row->id_barang_baku ?>"><?= $row->nama_barang_baku ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('id_barang_baku'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tanggal_keluar_baku">Tanggal Keluar :</label>
                                    <input type="date" class="form-control" id="tanggal_keluar_baku" name="tanggal_keluar_baku" value="<?= set_value('tanggal_keluar_baku'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('tanggal_keluar_baku'); ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="id_jenis_barang">Jenis Barang :</label>
                                    <select name="id_jenis_barang" id="id_jenis_barang" class="form-select">
                                        <option value="">Pilih Jenis Barang</option>
                                        <?php foreach ($jenis_barang as $row) : ?>
                                            <option value="<?= $row->id_jenis_barang ?>"><?= $row->nama_barang_jadi ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('id_jenis_barang'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jumlah_keluar_baku">Jumlah Barang :</label>
                                    <input type="text" class="form-control" id="jumlah_keluar_baku" name="jumlah_keluar_baku" value="<?= set_value('jumlah_keluar_baku'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('jumlah_keluar_baku'); ?></small>
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