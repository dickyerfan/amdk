<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('manager/stok_minimum_baku'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('manager/stok_minimum_baku/update') ?>" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-md-6 mb-3">
                                <div class="form-group mb-3">
                                    <div class="form-group">
                                        <label for="id_stok_minimum" class="mb-2">Nama Barang Baku</label>
                                        <input type="hidden" class="form-control" id="id_stok_minimum" name="id_stok_minimum" value="<?= $edit_stok->id_stok_minimum; ?>">
                                        <input type="text" class="form-control" id="id_barang_baku" name="id_barang_baku" placeholder="Masukan nama barang baku" value="<?= $edit_stok->nama_barang_baku; ?>" disabled>
                                        <small class="form-text text-danger pl-3"><?= form_error('id_barang_baku'); ?></small>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="form-group">
                                        <label for="id_satuan" class="mb-2">Nama Satuan</label>
                                        <select class="form-control select2" id="id_satuan" name="id_satuan">
                                            <?php foreach ($daftar_satuan as $row) : ?>
                                                <option value="<?= $row->id_satuan ?>" <?= ($row->id_satuan == $edit_stok->id_satuan) ? 'selected' : '' ?>>
                                                    <?= $row->satuan ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <small class="form-text text-danger pl-3"><?= form_error('id_satuan'); ?></small>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="isi_stok_minimum" class="mb-2">Isi Stok Minimum</label>
                                    <input type="number" class="form-control" id="isi_stok_minimum" name="isi_stok_minimum" placeholder="Masukan Isi Minimum" value="<?= $edit_stok->isi_stok_minimum; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('isi_stok_minimum'); ?></small>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="jumlah_stok_minimum" class="mb-2">Jumlah Stok Minimum</label>
                                    <input type="number" class="form-control" id="jumlah_stok_minimum" name="jumlah_stok_minimum" placeholder="Masukan Isi Minimum" value="<?= $edit_stok->jumlah_stok_minimum; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('jumlah_stok_minimum'); ?></small>
                                </div>
                                <div class="text-center">
                                    <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-edit"></i> update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>