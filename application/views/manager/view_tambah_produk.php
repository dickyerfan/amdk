<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('manager/produk'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="nama_produk" name="nama_produk" placeholder="Masukan nama produk" value="<?= set_value('nama_produk'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('nama_produk'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="jenis_produk" id="jenis_produk" class="form-control select2">
                                        <option value="">Pilih Produk</option>
                                        <option value="galon 19l">galon 19l</option>
                                        <option value="gelas 220ml">gelas 220ml</option>
                                        <option value="botol 250ml">botol 250ml</option>
                                        <option value="botol 330ml">botol 330ml</option>
                                        <option value="botol 500ml">botol 500ml</option>
                                        <option value="botol 1500ml">botol 1500ml</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('jenis_produk'); ?></small>
                                </div>
                            </div>

                        </div>
                        <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </main>