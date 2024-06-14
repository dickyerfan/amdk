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
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="tanggal_pesan">Tanggal Pesan :</label>
                                        <input type="date" class="form-control" id="tanggal_pesan" name="tanggal_pesan" placeholder="Masukan Tanggal Pesan" value="<?= set_value('tanggal_pesan'); ?>">
                                        <small class="form-text text-danger pl-3"><?= form_error('tanggal_pesan'); ?></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label for="id_pelanggan">Nama Pelanggan :</label>
                                    <select name="id_pelanggan" id="id_pelanggan" class="form-control select2">
                                        <option value="">Pilih pelanggan</option>
                                        <?php foreach ($pelanggan as $row) :  ?>
                                            <!-- <option value="<?= $row->id_pelanggan ?>"><?= $row->nama_pelanggan; ?></option> -->
                                            <option value="<?= $row->id_pelanggan ?>" data-tarif="<?= $row->tarif ?>"><?= $row->nama_pelanggan; ?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('id_pelanggan'); ?></small>
                                </div>
                                <!-- <small class="text-danger">(tambahkan di daftar pelanggan, Jika tidak ditemukan nama pelanggan)</small> -->
                                <small><a href="<?= base_url('pemasaran/pelanggan/tambah') ?>" style="text-decoration: none;">(tambahkan pelanggan, Jika tidak ditemukan nama pelanggan)</a> </small>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label for="jenis_pesanan">Jenis Pesanan :</label>
                                    <select name="jenis_pesanan" id="jenis_pesanan" class="form-control select2">
                                        <option value="">Pilih Jenis Pesanan</option>
                                        <option value="1">Kunjungan Rutin</option>
                                        <option value="2 ">Pesanan Langsung</option>
                                        <!-- <option value="3 ">Karyawan</option>
                                        <option value="4 ">Operasional</option> -->
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('jenis_pesanan'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label for="status_setoran_driver">Jenis Pelunasan :</label>
                                    <select name="status_setoran_driver" id="status_setoran_driver" class="form-control select2">
                                        <option value="">Pilih Jenis Pelunasan</option>
                                        <option value="1">Lunas</option>
                                        <option value="0">Hutang</option>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('status_setoran_driver'); ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="form-check mb-2">
                                    <div class="row">
                                        <?php $index = 0; ?>
                                        <?php foreach ($nama_barang as $jenis) : ?>
                                            <div class="col-lg-4">
                                                <input type="checkbox" name="id_jenis_barang[<?= $jenis->id_produk; ?>]" value="<?= $jenis->id_produk; ?>">
                                                <?= strtoupper($jenis->nama_produk); ?>
                                                <small class="form-text text-danger pl-3"><?= form_error('id_jenis_barang'); ?></small>
                                                <input type="number" name="jumlah_pesan[<?= $jenis->id_produk; ?>]" class="form-control mb-2">
                                                <small class="form-text text-danger pl-3"><?= form_error('jumlah_pesan'); ?></small>
                                            </div>
                                            <?php if ($index % 3 == 2 || $index == count($nama_barang) - 1) : ?>
                                    </div>
                                    <div class="row">
                                    <?php endif; ?>

                                    <?php $index++; ?>
                                <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-md-12 text-center">
                                    <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-save"></i> Simpan</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </main>