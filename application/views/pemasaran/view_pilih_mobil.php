<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('pemasaran/pemesanan'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="id_mobil" id="id_mobil" class="form-control select2">
                                        <option value="">Pilih Mobil</option>
                                        <?php foreach ($mobil as $row) :  ?>
                                            <option value="<?= $row->id_mobil ?>"><?= $row->nama_mobil; ?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('id_mobil'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="jam_mobil" id="jam_mobil" class="form-control select2">
                                        <option value="">Pilih Jam Mobil</option>
                                        <option value="1">Kiriman Pertama</option>
                                        <option value="2">Kiriman Ke dua</option>
                                        <option value="3">Kiriman ke tiga</option>
                                        <!-- <option value="4">Kiriman ke empat</option> -->
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('jam_mobil'); ?></small>
                                </div>
                            </div>
                        </div>
                        <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </main>