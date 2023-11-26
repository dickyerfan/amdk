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
                                    <select name="id_jenis_barang" id="id_jenis_barang" class="form-control select2">
                                        <option value="">Pilih Jenis Barang</option>
                                        <?php foreach ($nama_barang as $row) :  ?>
                                            <option value="<?= $row->id_produk ?>"><?= $row->nama_produk; ?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('id_jenis_barang'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="id_pelanggan" id="id_pelanggan" class="form-control select2">
                                        <option value="">Pilih pelanggan</option>
                                        <?php foreach ($pelanggan as $row) :  ?>
                                            <!-- <option value="<?= $row->id_pelanggan ?>"><?= $row->nama_pelanggan; ?></option> -->
                                            <option value="<?= $row->id_pelanggan ?>" data-tarif="<?= $row->tarif ?>"><?= $row->nama_pelanggan; ?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                    <small class="form-text text-danger pl-3"><?= form_error('id_pelanggan'); ?></small>
                                </div>
                                <small class="text-danger">(tambahkan di daftar pelanggan, Jika tidak ditemukan nama pelanggan)</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <div class="form-group">
                                        <input type="date" class="form-control" id="tanggal_pesan" name="tanggal_pesan" placeholder="Masukan Tanggal Pesan" value="<?= set_value('tanggal_pesan'); ?>">
                                        <small class="form-text text-danger pl-3"><?= form_error('tanggal_pesan'); ?></small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="number" class="form-control" id="jumlah_pesan" name="jumlah_pesan" placeholder="Masukan Jumlah Pesanan" value="<?= set_value('jumlah_pesan'); ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('jumlah_pesan'); ?></small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <select name="jenis_pesanan" id="jenis_pesanan" class="form-control select2">
                                        <option value="">Pilih Jenis Pesanan</option>
                                        <option value="1">Kunjungan Rutin</option>
                                        <option value="2 ">Pesanan Langsung</option>
                                        <option value="3 ">Karyawan</option>
                                        <option value="4 ">Operasional</option>
                                    </select>
                                    <!-- <input type="text" class="form-control" id="jenis_pesanan" name="jenis_pesanan" placeholder="Pilih Jenis Pesanan" value="<?= set_value('jenis_pesanan'); ?>"> -->
                                    <small class="form-text text-danger pl-3"><?= form_error('jenis_pesanan'); ?></small>
                                </div>
                            </div>
                        </div>
                        <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-save"></i> Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </main>