<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('manager/mobil'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
                </div>
                <div class="card-body">
                    <form class="user" action="" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="nama_mobil" name="nama_mobil" placeholder="Masukan Nama Mobil" value="<?= set_value('nama_mobil'); ?>">
                                        <small class="form-text text-danger pl-3"><?= form_error('nama_mobil'); ?></small>
                                    </div>
                                    <small class="form-text text-danger pl-3"><?= form_error('nama_mobil'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="jenis_mobil" name="jenis_mobil" placeholder="Masukan Jenis Mobil" value="<?= set_value('jenis_mobil'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('jenis_mobil'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="plat_nomor" name="plat_nomor" placeholder="Masukan Plat Nomor" value="<?= set_value('plat_nomor'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('plat_nomor'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="id_karyawan" id="id_karyawan" class="form-control select2">
                                        <option value="">Pilih Penanggung Jawab</option>
                                        <?php foreach ($p_jawab as $row) :  ?>
                                            <option value="<?= $row->id_karyawan ?>"><?= $row->nama_karyawan; ?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('id_karyawan'); ?></small>
                                </div>
                            </div>

                        </div>
                        <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </main>