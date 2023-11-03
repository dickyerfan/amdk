<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('pemasaran/pelanggan'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('pemasaran/pelanggan/update') ?>" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" id="id_pelanggan" name="id_pelanggan" value="<?= $edit_pelanggan->id_pelanggan; ?>">
                                    <input type="text" class="form-control" id="area_pelanggan" name="area_pelanggan" placeholder="Masukan Area Pelanggan" value="<?= $edit_pelanggan->area_pelanggan; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('area_pelanggan'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="gol_pelanggan" id="gol_pelanggan" class="form-control select2">
                                        <!-- <option value="">Pilih Golongan pelanggan</option> -->
                                        <option value="Perorangan" <?= $edit_pelanggan->gol_pelanggan == 'PERORANGAN' ? 'selected' : '' ?>>Perorangan</option>
                                        <option value="Instansi" <?= $edit_pelanggan->gol_pelanggan == 'INSTANSI' ? 'selected' : '' ?>>Instansi</option>
                                        <option value="Mitra" <?= $edit_pelanggan->gol_pelanggan == 'MITRA' ? 'selected' : '' ?>>Mitra</option>
                                        <option value="Retail" <?= $edit_pelanggan->gol_pelanggan == 'RETAIL' ? 'selected' : '' ?>>Retail</option>
                                        <option value="Maklon" <?= $edit_pelanggan->gol_pelanggan == 'MAKLON' ? 'selected' : '' ?>>Maklon</option>
                                        <option value="Distributor" <?= $edit_pelanggan->gol_pelanggan == 'DISTRIBUTOR' ? 'selected' : '' ?>>Distributor</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('gol_pelanggan'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" placeholder="Masukan Nama Pelanggan" value="<?= $edit_pelanggan->nama_pelanggan; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('nama_pelanggan'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="alamat_pelanggan" name="alamat_pelanggan" placeholder="Masukan alamat Pelanggan" value="<?= $edit_pelanggan->alamat_pelanggan; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('alamat_pelanggan'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="number" class="form-control" id="telpon_pelanggan" name="telpon_pelanggan" placeholder="Masukan Telpon Pelanggan" value="<?= $edit_pelanggan->telpon_pelanggan; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('telpon_pelanggan'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="ket" name="ket" placeholder="Masukan Keterangan" value="<?= $edit_pelanggan->ket; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('ket'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="tarif" id="tarif" class="form-control select2">
                                        <!-- <option value="">Pilih Tarif</option> -->
                                        <option value="UMUM" <?= $edit_pelanggan->tarif == 'UMUM' ? 'selected' : '' ?>>Umum</option>
                                        <option value="RETAIL" <?= $edit_pelanggan->tarif == 'RETAIL' ? 'selected' : '' ?>>Retail</option>
                                        <option value="SEMIGROSIR" <?= $edit_pelanggan->tarif == 'SEMIGROSIR' ? 'selected' : '' ?>>Semi_grosir</option>
                                        <option value="GROSIR" <?= $edit_pelanggan->tarif == 'GROSIR' ? 'selected' : '' ?>>Grosir</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('tarif'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="aktif" id="aktif" class="form-control select2">
                                        <!-- <option value="">Pilih Status Aktif</option> -->
                                        <option value="1" <?= $edit_pelanggan->aktif == '1' ? 'selected' : '' ?>>Aktif</option>
                                        <option value="0" <?= $edit_pelanggan->aktif == '0' ? 'selected' : '' ?>>Non Aktif</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('aktif'); ?></small>
                                </div>
                            </div>
                        </div>
                        <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </main>