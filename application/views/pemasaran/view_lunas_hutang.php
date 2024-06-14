<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('pemasaran/setoran_hutang'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="hidden" name="id_pemesanan" id="id_pemesanan" value="<?= $upload_nota->id_pemesanan; ?>">
                                <!-- <input type="hidden" name="id_pelanggan" id="id_pelanggan" value="<?= $upload_nota->id_pelanggan; ?>">
                                <input type="hidden" name="tanggal_pesan" id="tanggal_pesan" value="<?= $upload_nota->tanggal_pesan; ?>"> -->
                                <div class="form-group">
                                    <label for="status_setoran_driver">Jenis Pelunasan :</label>
                                    <select name="status_setoran_driver" id="status_setoran_driver" class="form-control select2">
                                        <option value="">Pilih Jenis Pelunasan</option>
                                        <option value="1">Lunas</option>
                                        <option value="0">Hutang</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('status_setoran_driver'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label for="tgl_setoran_driver">Tanggal Setor :</label>
                                    <input type="date" class="form-control" id="tgl_setoran_driver" name="tgl_setoran_driver" value="<?= set_value('tgl_setoran_driver'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('tgl_setoran_driver'); ?></small>
                                </div>
                            </div>
                        </div>
                        <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-edit"></i> Update</button>
                    </form>
                </div>
            </div>
        </div>
    </main>