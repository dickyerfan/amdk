<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('manager/barang_baku_untuk_produksi'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('manager/barang_baku_untuk_produksi/update') ?>" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-md-4 mb-3">
                                <div class="form-group mb-3">
                                    <div class="form-group">
                                        <label for="id_jenis_barang" class="mb-2">Nama Barang Jadi</label>
                                        <input type="hidden" class="form-control" id="id_barang_baku_produksi" name="id_barang_baku_produksi" value="<?= $edit_stok->id_barang_baku_produksi; ?>">
                                        <input type="text" class="form-control" id="id_jenis_barang" name="id_jenis_barang" placeholder="Masukan nama barang jadi" value="<?= $edit_stok->nama_barang_jadi; ?>" disabled>
                                        <small class="form-text text-danger pl-3"><?= form_error('id_jenis_barang'); ?></small>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="form-group">
                                        <label for="id_barang_baku" class="mb-2">Nama Barang Baku</label>
                                        <!-- <input type="text" class="form-control" id="id_barang_baku" name="id_barang_baku" placeholder="Masukan nama barang baku" value="<?= $edit_stok->nama_barang_baku; ?>"> -->
                                        <select class="form-control select2" id="id_barang_baku" name="id_barang_baku">
                                            <?php foreach ($barang_baku_list as $barang_baku) : ?>
                                                <option value="<?= $barang_baku->id_barang_baku ?>" <?= ($barang_baku->id_barang_baku == $edit_stok->id_barang_baku) ? 'selected' : '' ?>>
                                                    <?= $barang_baku->nama_barang_baku ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <small class="form-text text-danger pl-3"><?= form_error('id_barang_baku'); ?></small>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="jumlah_keluar_baku" class="mb-2">Jumlah Barang Baku</label>
                                    <input type="number" class="form-control" id="jumlah_keluar_baku" name="jumlah_keluar_baku" placeholder="Masukan NIK Karyawan" value="<?= $edit_stok->jumlah_keluar_baku; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('jumlah_keluar_baku'); ?></small>
                                </div>
                                <div class="text-center">
                                    <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-edit"></i> update</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </main>