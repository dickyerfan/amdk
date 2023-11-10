<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('keuangan/pengambilan_air'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="date" class="form-control" id="tanggal_ambil_air" name="tanggal_ambil_air" placeholder="Masukan Area Pelanggan" value="<?= set_value('tanggal_ambil_air'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('tanggal_ambil_air'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="id_karyawan" id="id_karyawan" class="form-control select2">
                                        <option value="">Pilih Petugas/Driver</option>
                                        <?php foreach ($karyawan as $row) : ?>
                                            <option value="<?= $row->id_karyawan; ?>"><?= $row->nama_karyawan; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('id_karyawan'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="waktu" name="waktu" placeholder="contoh : 09:00" value="<?= set_value('waktu'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('waktu'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="stand_meter" name="stand_meter" placeholder="Masukan Stand Meter" value="<?= set_value('stand_meter'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('stand_meter'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="bbm" name="bbm" placeholder="Masukan jumlah bbm" value="<?= set_value('bbm'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('bbm'); ?></small>
                                </div>
                            </div>
                        </div>
                        <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </main>