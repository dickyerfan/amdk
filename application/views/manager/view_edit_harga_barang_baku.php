<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('manager/harga_barang_baku'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('manager/harga_barang_baku/update') ?>" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="id_harga" name="id_harga" value="<?= $edit_harga->id_harga; ?>">
                                        <label for="id_barang_baku" class="mb-2">Jenis Barang :</label>
                                        <select name="id_barang_baku" id="id_barang_baku" class="form-control select2">
                                            <option value="">Pilih Produk</option>
                                            <?php foreach ($harga_barang_baku as $row) :  ?>
                                                <option value="<?= $row->id_barang_baku ?>" <?= ($row->id_barang_baku == $edit_harga->id_barang_baku) ? 'selected' : ''; ?>><?= $row->nama_barang_baku; ?></option>
                                            <?php endforeach;  ?>
                                        </select>
                                        <small class="form-text text-danger pl-3"><?= form_error('id_barang_baku'); ?></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="harga" class="mb-2">Harga :</label>
                                    <input type="number" class="form-control" id="harga" name="harga" placeholder="Masukan Harga" value="<?= $edit_harga->harga; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('harga'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="tanggal_berlaku" class="mb-2">Tanggal Berlaku :</label>
                                    <input type="date" class="form-control" id="tanggal_berlaku" name="tanggal_berlaku" value="<?= isset($edit_harga->tanggal_berlaku) ? $edit_harga->tanggal_berlaku : ''; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('tanggal_berlaku'); ?></small>
                                </div>
                            </div>
                        </div>
                        <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-edit"></i> update</button>
                    </form>
                </div>
            </div>
        </div>
    </main>