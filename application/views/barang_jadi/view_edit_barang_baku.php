<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('barang_jadi/bon_barang_baku') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <form class="user" action="<?= base_url('barang_jadi/bon_barang_baku/update') ?>" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label for="id_barang_baku_jadi">Nama Barang Jadi :</label>
                                    <input type="hidden" class="form-control" id="id_barang_baku_jadi" name="id_barang_baku_jadi" value="<?= $edit_baku_jadi->id_barang_baku_jadi; ?>">
                                    <select name="id_barang_baku" class="form-select">
                                        <option value=""></option>
                                        <?php foreach ($nama_barang as $row) : ?>
                                            <option value="<?= $row->id_barang_baku ?>" <?= ($row->id_barang_baku == $edit_baku_jadi->id_barang_baku) ? 'selected' : ''; ?>><?= $row->nama_barang_baku; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('id_jenis_barang'); ?></small>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="jumlah_keluar">Jumlah Barang di ambil:</label>
                                    <input type="number" step="1" class="form-control" id="jumlah_keluar" name="jumlah_keluar" value="<?= $edit_baku_jadi->jumlah_keluar; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('jumlah_keluar'); ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-12 text-center">
                                <button class="neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>