<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('pemasaran/pemesanan'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('pemasaran/pemesanan/update_nota') ?>" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="hidden" name="id_pemesanan" id="id_pemesanan" value="<?= $upload_nota->id_pemesanan; ?>">
                                <input type="hidden" name="id_pelanggan" id="id_pelanggan" value="<?= $upload_nota->id_pelanggan; ?>">
                                <input type="hidden" name="tanggal_pesan" id="tanggal_pesan" value="<?= $upload_nota->tanggal_pesan; ?>">
                                <div class="form-group">
                                    <label for="nota_beli">Nota Pembelian :</label>
                                    <input type="file" class="form-control" id="nota_beli" name="nota_beli" value="<?= set_value('nota_beli'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('nota_beli'); ?></small>
                                </div>
                            </div>
                        </div>
                        <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-edit"></i> Update</button>
                    </form>
                </div>
            </div>
        </div>
    </main>