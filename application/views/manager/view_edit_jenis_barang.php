<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('manager/jenis_barang') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('manager/jenis_barang/update') ?>" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <input type="hidden" name="id_jenis_barang" id="id_jenis_barang" value="<?= $edit_jenis->id_jenis_barang; ?>">
                                <div class="form-group">
                                    <label for="nama_barang_jadi">Nama Barang :</label>
                                    <input type="text" class="form-control" id="nama_barang_jadi" name="nama_barang_jadi" value="<?= $edit_jenis->nama_barang_jadi; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('nama_barang_jadi'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_barang">Jenis Barang :</label>
                                    <select name="jenis_barang" id="jenis_barang" class="form-control">
                                        <!-- <option value="">Pilih Jenis Produk</option> -->
                                        <option value="galon 19l" <?= $edit_jenis->jenis_barang == 'galon 19l' ? 'selected' : '' ?>>galon 19l</option>
                                        <option value="gelas 220ml" <?= $edit_jenis->jenis_barang == 'gelas 220ml' ? 'selected' : '' ?>>gelas 220ml</option>
                                        <option value="botol 330ml" <?= $edit_jenis->jenis_barang == 'botol 330ml' ? 'selected' : '' ?>>botol 330ml</option>
                                        <option value="botol 500ml" <?= $edit_jenis->jenis_barang == 'botol 500ml' ? 'selected' : '' ?>>botol 500ml</option>
                                        <option value="botol 1500ml" <?= $edit_jenis->jenis_barang == 'botol 1500ml' ? 'selected' : '' ?>>botol 1500ml</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('jenis_barang'); ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-12 text-center">
                                <button class="neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-edit"></i> Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>