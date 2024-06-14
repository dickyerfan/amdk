<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('manager/stok_awal_jadi'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('manager/stok_awal_jadi/update') ?>" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-md-6 mb-3">
                                <div class="form-group mb-3">
                                    <div class="form-group">
                                        <label for="id_stok_awal_jadi" class="mb-2">Nama Barang</label>
                                        <input type="hidden" class="form-control" id="id_stok_awal_jadi" name="id_stok_awal_jadi" value="<?= $edit_stok->id_stok_awal_jadi; ?>">
                                        <input type="text" class="form-control" id="id_stok_awal_jadi" name="id_stok_awal_jadi" placeholder="Masukan nama barang baku" value="<?= $edit_stok->nama_barang_jadi; ?>" disabled>
                                        <small class="form-text text-danger pl-3"><?= form_error('id_stok_awal_jadi'); ?></small>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="jumlah_stok_awal_jadi" class="mb-2">Jumlah Barang</label>
                                    <input type="number" class="form-control" id="jumlah_stok_awal_jadi" name="jumlah_stok_awal_jadi" placeholder="Masukan NIK Karyawan" value="<?= $edit_stok->jumlah_stok_awal_jadi; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('jumlah_stok_awal_jadi'); ?></small>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="tanggal_stok_awal_jadi" class="mb-2">Tanggal Input</label>
                                    <input type="date" class="form-control" id="tanggal_stok_awal_jadi" name="tanggal_stok_awal_jadi" placeholder="Masukan NIK Karyawan" value="<?= $edit_stok->tanggal_stok_awal_jadi; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('tanggal_stok_awal_jadi'); ?></small>
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