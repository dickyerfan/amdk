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
                                <div class="form-group">
                                    <select name="id_jenis_barang" id="id_jenis_barang" class="form-select">
                                        <option value="">Pilih Barang</option>
                                        <?php foreach ($nama_barang as $row) : ?>
                                            <option value="<?= $row->id_jenis_barang ?>"><?= $row->nama_barang_jadi ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('id_jenis_barang'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="date" class="form-control" id="tanggal_ban_ops" name="tanggal_ban_ops" placeholder="Masukan Jumlah" value="<?= set_value('tanggal_ban_ops'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('tanggal_ban_ops'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="jumlah_ban_ops" name="jumlah_ban_ops" placeholder="Masukan Jumlah" value="<?= set_value('jumlah_ban_ops'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('jumlah_ban_ops'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="jenis_ban_ops" id="jenis_ban_ops" class="form-control select2">
                                        <option value="">Pilih Jenis Kegiatan</option>
                                        <option value="operasional">operasional</option>
                                        <option value="bantuan">bantuan</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('jenis_ban_ops'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="nama_ban_ops" name="nama_ban_ops" placeholder="Masukan Nama Kegiatan" value="<?= set_value('nama_ban_ops'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('nama_ban_ops'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukan Keterangan" value="<?= set_value('keterangan'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('keterangan'); ?></small>
                                </div>
                            </div>
                        </div>
                        <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </main>