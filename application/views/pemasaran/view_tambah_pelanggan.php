<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('pemasaran/pelanggan'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="area_pelanggan" name="area_pelanggan" placeholder="Masukan Area Pelanggan" value="<?= set_value('area_pelanggan'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('area_pelanggan'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="gol_pelanggan" id="gol_pelanggan" class="form-control select2">
                                        <option value="">Pilih Golongan pelanggan</option>
                                        <option value="Perorangan">Perorangan</option>
                                        <option value="Karyawan">Karyawan</option>
                                        <option value="Instansi">Instansi</option>
                                        <option value="Mitra">Mitra</option>
                                        <option value="Retail">Retail</option>
                                        <option value="Maklon">Maklon</option>
                                        <option value="Distributor">Distributor</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('gol_pelanggan'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" placeholder="Masukan Nama Pelanggan" value="<?= set_value('nama_pelanggan'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('nama_pelanggan'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="alamat_pelanggan" name="alamat_pelanggan" placeholder="Masukan alamat Pelanggan" value="<?= set_value('alamat_pelanggan'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('alamat_pelanggan'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="number" class="form-control" id="telpon_pelanggan" name="telpon_pelanggan" placeholder="Masukan Telpon Pelanggan" value="<?= set_value('telpon_pelanggan'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('telpon_pelanggan'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="ket" name="ket" placeholder="Masukan Keterangan" value="<?= set_value('ket'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('ket'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="tarif" id="tarif" class="form-control select2">
                                        <option value="">Pilih Tarif</option>
                                        <option value="Umum">Umum</option>
                                        <option value="Retail">Retail</option>
                                        <option value="Semi Grosir">SemiGrosir</option>
                                        <option value="Grosir">Grosir</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('tarif'); ?></small>
                                </div>
                            </div>
                        </div>
                        <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </main>