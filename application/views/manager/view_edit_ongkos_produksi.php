<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('manager/ongkos_produksi'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('manager/ongkos_produksi/update') ?>" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="id_ongkos_produksi" name="id_ongkos_produksi" value="<?= $edit_ongkos_produksi->id_ongkos_produksi; ?>">
                                        <label for="id_jenis_barang" class="mb-2">Jenis Barang :</label>
                                        <select name="id_jenis_barang" id="id_jenis_barang" class="form-control select2">
                                            <option value="">Pilih Produk</option>
                                            <?php foreach ($barang as $row) :  ?>
                                                <option value="<?= $row->id_produk ?>" <?= ($row->id_produk == $edit_ongkos_produksi->id_jenis_barang) ? 'selected' : ''; ?>><?= $row->nama_produk; ?></option>
                                            <?php endforeach;  ?>
                                        </select>
                                        <small class="form-text text-danger pl-3"><?= form_error('id_produk'); ?></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="ongkos_per_unit" class="mb-2">Ongkos Produksi :</label>
                                    <input type="number" class="form-control" id="ongkos_per_unit" name="ongkos_per_unit" placeholder="Masukan Ongkos Produksi" value="<?= $edit_ongkos_produksi->ongkos_per_unit; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('ongkos_per_unit'); ?></small>
                                </div>
                            </div>
                        </div>
                        <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-edit"></i> update</button>
                    </form>
                </div>
            </div>
        </div>
    </main>