<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('barang_baku/barang_keluar') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                        </div>
                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center mb-2">
                        <div class="col-lg-6 text-center">
                            <h5><?= strtoupper($title); ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" id="example">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="text-center">No</th>
                                            <th class="text-center">Tgl Transaksi</th>
                                            <th class="text-center">Kode Barang</th>
                                            <th class="text-center">Nama Barang</th>
                                            <th class="text-center">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($detail_barang_keluar as $row) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no++; ?></td>
                                                <td class="text-center"><?= date('d-m-Y', strtotime($row->tanggal_keluar)); ?></td>
                                                <td><?= $row->kode_barang; ?></td>
                                                <td><?= $row->nama_barang_baku; ?></td>
                                                <td class="text-end"><?= number_format($row->jumlah_keluar, 0, ',', '.'); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <form class="user" action="<?= base_url('barang_baku/barang_keluar/terima_barang_tgl_sama/') . $row->tanggal_keluar . '/' . $row->bagian ?>" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <input type="hidden" name="tanggal_keluar" id="tanggal_keluar" value="<?= $row->tanggal_keluar; ?>">
                                            <div class="form-group">
                                                <label for="bukti_keluar_gd" class="mb-2">Bukti Pemesanan Barang Baku :</label>
                                                <input type="file" class="form-control" id="bukti_keluar_gd" name="bukti_keluar_gd" value="<?= set_value('bukti_keluar_gd'); ?>">
                                                <small class="form-text text-danger pl-3"><?= form_error('bukti_keluar_gd'); ?></small>
                                            </div>
                                        </div>
                                    </div>
                                    <button class=" neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-edit"></i> Update Barang Keluar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>