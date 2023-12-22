<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('keuangan/ban_ops'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group mb-3">
                                    <div class="mb-2">Tanggal Order :</div>
                                    <input type="date" class="form-control" id="tanggal_ban_ops" name="tanggal_ban_ops" placeholder="Masukan Jumlah" value="<?= set_value('tanggal_ban_ops'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('tanggal_ban_ops'); ?></small>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="mb-2">Jenis Kegiatan :</div>
                                    <select name="jenis_ban_ops" id="jenis_ban_ops" class="form-control select2">
                                        <option value="">Pilih Jenis Kegiatan</option>
                                        <option value="operasional">operasional</option>
                                        <option value="bantuan">bantuan</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('jenis_ban_ops'); ?></small>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="mb-2">Nama Kegiatan :</div>
                                    <input type="text" class="form-control" id="nama_ban_ops" name="nama_ban_ops" placeholder="Masukan Nama Kegiatan" value="<?= set_value('nama_ban_ops'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('nama_ban_ops'); ?></small>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="mb-2">Keterangan :</div>
                                    <textarea class="form-control" name="keterangan" id="keterangan" cols="20" rows="7"><?= set_value('keterangan'); ?></textarea>
                                    <!-- <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukan Keterangan" value="<?= set_value('keterangan'); ?>"> -->
                                    <small class="form-text text-danger pl-3"><?= form_error('keterangan'); ?></small>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="mb-2">Pilih Mobil :</div>
                                    <select name="id_mobil" id="id_mobil" class="form-control select2">
                                        <!-- <option value="">Pilih Mobil</option> -->
                                        <?php foreach ($mobil as $row) : ?>
                                            <option value="<?= $row->id_mobil; ?>"><?= $row->nama_mobil; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('id_mobil'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-check mb-2">
                                    <div class="mb-2">Pilih Jenis Barang & Jumlah :</div>
                                    <!-- <label>Jenis Barang</label> -->
                                    <?php foreach ($jenis_barang as $jenis) : ?>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="checkbox" name="id_jenis_barang[<?= $jenis->id_jenis_barang; ?>]" value="<?= $jenis->id_jenis_barang; ?>">
                                                <?= $jenis->nama_barang_jadi; ?>
                                                <small class="form-text text-danger pl-3"><?= form_error('id_jenis_barang'); ?></small>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="number" name="jumlah_ban_ops[<?= $jenis->id_jenis_barang; ?>]" class="form-control mb-2" placeholder="Masukan Jumlah <?= $jenis->nama_barang_jadi ?>">
                                                <small class="form-text text-danger pl-3"><?= form_error('jumlah_ban_ops'); ?></small>
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