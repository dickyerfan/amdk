<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('barang_baku/stok_barang_baku') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
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
                                    <label for="nama_barang_baku">Nama Barang Baku :</label>
                                    <input type="text" class="form-control" id="nama_barang_baku" name="nama_barang_baku" value="<?= set_value('nama_barang_baku'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('nama_barang_baku'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="kode_barang">Kode Barang :</label>
                                    <input type="text" class="form-control" id="kode_barang" name="kode_barang" value="<?= set_value('kode_barang'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('kode_barang'); ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="id_satuan">Satuan :</label>
                                    <select name="id_satuan" id="id_satuan" class="form-select">
                                        <option value="">Pilih Satuan</option>
                                        <?php foreach ($satuan as $row) : ?>
                                            <option value="<?= $row->id_satuan; ?>"><?= $row->satuan; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('id_satuan'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="id_jenis_barang">Jenis Barang :</label>
                                    <select name="id_jenis_barang" id="id_jenis_barang" class="form-select">
                                        <option value="">Pilih Jenis Barang</option>
                                        <?php foreach ($jenis_barang as $row) : ?>
                                            <option value="<?= $row->id_jenis_barang; ?>"><?= $row->nama_barang_jadi; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('id_jenis_barang'); ?></small>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row justify-content-center mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tgl_stok_awal">Tanggal Stok Awal :</label>
                                    <input type="date" class="form-control" id="tgl_stok_awal" name="tgl_stok_awal" value="<?= set_value('tgl_stok_awal'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('tgl_stok_awal'); ?></small>
                                </div>
                            </div>
                        </div> -->
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