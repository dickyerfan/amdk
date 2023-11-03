<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('manager/harga'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('manager/harga/update') ?>" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="id_harga" name="id_harga" value="<?= $edit_harga->id_harga; ?>">
                                        <select name="id_jenis_barang" id="id_jenis_barang" class="form-control select2">
                                            <option value="">Pilih Jenis Barang</option>
                                            <?php foreach ($barang as $row) :  ?>
                                                <option value="<?= $row->id_jenis_barang ?>" <?= ($row->id_jenis_barang == $edit_harga->id_jenis_barang) ? 'selected' : ''; ?>><?= $row->nama_barang_jadi; ?></option>
                                            <?php endforeach;  ?>
                                        </select>
                                        <small class="form-text text-danger pl-3"><?= form_error('id_jenis_barang'); ?></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="jenis_harga" id="jenis_harga" class="form-control">
                                        <option value="">Pilih Jenis Harga</option>
                                        <option value="UMUM" <?= $edit_harga->jenis_harga == 'UMUM' ? 'selected' : '' ?>>Umum</option>
                                        <option value="RETAIL" <?= $edit_harga->jenis_harga == 'RETAIL' ? 'selected' : '' ?>>Retail</option>
                                        <option value="SEMIGROSIR" <?= $edit_harga->jenis_harga == 'SEMIGROSIR' ? 'selected' : '' ?>>Semi Grosir</option>
                                        <option value="GROSIR" <?= $edit_harga->jenis_harga == 'GROSIR' ? 'selected' : '' ?>>Grosir</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('jenis_harga'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="number" class="form-control" id="harga" name="harga" placeholder="Masukan Harga" value="<?= $edit_harga->harga; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('harga'); ?></small>
                                </div>
                            </div>
                        </div>
                        <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-edit"></i> update</button>
                    </form>
                </div>
            </div>
        </div>
    </main>