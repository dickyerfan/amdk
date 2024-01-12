<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('barang_baku/stok_awal'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('barang_baku/stok_awal/update') ?>" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-md-6 mb-3">
                                <div class="form-group mb-3">
                                    <div class="form-group">
                                        <label for="id_stok_awal_baku" class="mb-2">Nama Barang Baku</label>
                                        <input type="hidden" class="form-control" id="id_stok_awal_baku" name="id_stok_awal_baku" value="<?= $edit_stok->id_stok_awal_baku; ?>">
                                        <input type="text" class="form-control" id="id_barang_baku" name="id_barang_baku" placeholder="Masukan nama barang baku" value="<?= $edit_stok->nama_barang_baku; ?>" disabled>
                                        <small class="form-text text-danger pl-3"><?= form_error('id_barang_baku'); ?></small>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="jumlah_stok_awal_baku" class="mb-2">Jumlah Barang Baku</label>
                                    <input type="number" class="form-control" id="jumlah_stok_awal_baku" name="jumlah_stok_awal_baku" placeholder="Masukan NIK Karyawan" value="<?= $edit_stok->jumlah_stok_awal_baku; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('jumlah_stok_awal_baku'); ?></small>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="tanggal_stok_awal_baku" class="mb-2">Tanggal Input</label>
                                    <input type="date" class="form-control" id="tanggal_stok_awal_baku" name="tanggal_stok_awal_baku" placeholder="Masukan NIK Karyawan" value="<?= $edit_stok->tanggal_stok_awal_baku; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('tanggal_stok_awal_baku'); ?></small>
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