<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('manager/harga_barang_baku'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body ">
                    <form class="user" action="" method="POST">
                        <div class="row-md-6">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <select name="id_barang_baku" id="id_barang_baku" class="form-control select2">
                                        <option value="">Pilih Barang Baku</option>
                                        <?php foreach ($harga_barang_baku as $row) :  ?>
                                            <option value="<?= $row->id_barang_baku ?>"><?= $row->nama_barang_baku; ?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('id_barang_baku'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <input type="number" set="100" class="form-control" id="harga" name="harga" placeholder="Masukan Harga" value="<?= set_value('harga'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('harga'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <input type="date" set="100" class="form-control" id="tanggal_berlaku" name="tanggal_berlaku" placeholder="Masukan tanggal_berlaku" value="<?= set_value('tanggal_berlaku'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('tanggal_berlaku'); ?></small>
                                </div>
                            </div>
                        </div>
                        <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </main>