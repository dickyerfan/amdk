<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('barang_jadi/lebaran'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group mb-3">
                                    <div class="mb-2">Nama :</div>
                                    <select name="id_pelanggan" id="id_pelanggan" class="form-control select2">
                                        <option value="">Pilih pelanggan</option>
                                        <?php foreach ($pelanggan as $row) :  ?>
                                            <option value="<?= $row->id_pelanggan ?>"><?= $row->nama_pelanggan; ?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('id_pelanggan'); ?></small>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="mb-2">Jumlah Orang :</div>
                                    <input type="text" class="form-control" id="jumlah_orang" name="jumlah_orang" placeholder="Masukan Jumlah" value="<?= set_value('jumlah_orang'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('jumlah_orang'); ?></small>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="mb-2">Keterangan :</div>
                                    <textarea class="form-control" name="keterangan" id="keterangan" cols="20" rows="7"><?= set_value('keterangan'); ?></textarea>
                                    <small class="form-text text-danger pl-3"><?= form_error('keterangan'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check mb-2">
                                    <div class="mb-2">Pilih Jenis Barang & Jumlah :</div>
                                    <!-- <label>Jenis Barang</label> -->
                                    <?php foreach ($jenis_barang as $jenis) : ?>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="checkbox" name="id_jenis_barang[<?= $jenis->id_produk; ?>]" value="<?= $jenis->id_produk; ?>">
                                                <?= $jenis->nama_produk; ?>
                                                <small class="form-text text-danger pl-3"><?= form_error('id_jenis_barang'); ?></small>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="number" name="jumlah_barang[<?= $jenis->id_produk; ?>]" class="form-control mb-2" placeholder="Masukan Jumlah <?= $jenis->nama_produk ?>">
                                                <small class="form-text text-danger pl-3"><?= form_error('jumlah_barang'); ?></small>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <button class=" neumorphic-button " name="tambah" type="submit"><i class="fas fa-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </main>