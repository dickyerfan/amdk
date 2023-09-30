<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <!-- <div class="navbar-nav">
                            <a href="<?= base_url('rkap/usulan_inves/export_pdf') ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
                        </div> -->
                        <div class="navbar-nav ms-auto">
                            <a href="#tambahData" data-bs-toggle="modal"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Permintaan Barang</button></a>
                        </div>
                    </nav>
                </div>
                <div class="p-1">
                    <!-- <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?> -->
                    <p id="pesan2" style="color: red;"></p>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-center">
                            <h5><?= strtoupper($title); ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <table class="table table-sm table-bordered" id="example">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Kode Barang</th>
                                        <th class="text-center">Nama Barang</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-center">Input Oleh</th>
                                        <!-- <th class="text-center">Status</th> -->
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="show_data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- awal modal tambah barang -->
        <div class="modal fade" id="tambahData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title">Form Permintaan Barang</h5>
                    </div>
                    <div class="modal-body">
                        <p id="pesan" style="color: red;"></p>
                        <form action="" method="POST">
                            <table class="table table-borderless">
                                <tr>
                                    <td>Nama Barang</td>
                                    <td class="text-center"> :</td>
                                    <td class="text-center"></td>
                                    <td>
                                        <select name="id_barang_baku" id="id_barang_baku" class="form-select select2">
                                            <option value="">Pilih Barang</option>
                                            <?php foreach ($nama_barang as $row) : ?>
                                                <option value="<?= $row->id_barang_baku ?>"><?= $row->nama_barang_baku ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <!-- <input type="text" name="id_barang_baku" id="id_barang_baku" placeholder="Nama Barang" class="form-control"> -->
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td>Kode Barang</td>
                                    <td class="text-center"> :</td>
                                    <td class="text-center"></td>
                                    <td><input type="text" name="kode_barang" id="kode_barang" placeholder="Kode Barang" class="form-control"></td>
                                </tr> -->
                                <tr>
                                    <td>Jumlah Barang</td>
                                    <td class="text-center"> :</td>
                                    <td class="text-center"></td>
                                    <td><input type="text" name="jumlah_keluar" id="jumlah_keluar" placeholder="Jumlah Barang" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>Tanggal Input</td>
                                    <td class="text-center"> :</td>
                                    <td class="text-center"></td>
                                    <td><input type="date" name="tanggal_keluar" id="tanggal_keluar" placeholder="Tanggal Input" class="form-control"></td>
                                </tr>
                                <tr class="text-center">
                                    <td colspan="4">
                                        <button type="button" id="btn-tambah" class="btn btn-primary" onclick="tambahData()">Tambah Data</button>
                                        <button type="button" data-bs-dismiss="modal" class="btn btn-secondary" onclick="batalData()">Batal</button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- akhir modal tambah barang -->

        <!-- awal modal update barang -->
        <div class="modal fade" id="ubahData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title">Form Update Barang</h5>
                    </div>
                    <div class="modal-body">
                        <p id="pesan" style="color: red;"></p>
                        <form action="" method="POST">
                            <table class="table table-borderless">
                                <tr>
                                    <input type="hidden" name="id_keluar_baku" id="id_keluar_baku" value="">
                                    <td>Nama Barang</td>
                                    <td class="text-center"> :</td>
                                    <td class="text-center"></td>
                                    <td>
                                        <select name="id_barang_bakuUp" id="id_barang_baku" class="form-select">
                                            <!-- <option value="">Pilih Barang</option> -->
                                            <?php foreach ($nama_barang as $row) : ?>
                                                <option value="<?= $row->id_barang_baku ?>" <?= $row->id_barang_baku == $id_barang ? 'selected' : '' ?>><?= $row->nama_barang_baku ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kode Barang</td>
                                    <td class="text-center"> :</td>
                                    <td class="text-center"></td>
                                    <td><input type="text" name="kode_barangUp" id="kode_barang" placeholder="Kode Barang" class="form-control" value=""></td>
                                </tr>
                                <tr>
                                    <td>Jumlah Barang</td>
                                    <td class="text-center"> :</td>
                                    <td class="text-center"></td>
                                    <td><input type="text" name="jumlah_keluarUp" id="jumlah_keluar" placeholder="Jumlah Barang" class="form-control" value=""></td>
                                </tr>
                                <tr>
                                    <td>Tanggal Input</td>
                                    <td class="text-center"> :</td>
                                    <td class="text-center"></td>
                                    <td><input type="date" name="tanggal_keluarUp" id="tanggal_keluar" placeholder="Tanggal Input" class="form-control" value=""></td>
                                </tr>
                                <tr class="text-center">
                                    <td colspan="4">
                                        <button type="button" id="btn-tambah" class="btn btn-primary" onclick="ubahData()">Update Data</button>
                                        <button type="button" data-bs-dismiss="modal" class="btn btn-secondary" onclick="batalData()">Batal</button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- akhir modal update barang -->
    </main>