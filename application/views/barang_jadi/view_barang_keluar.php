<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <form action="<?= base_url('barang_jadi/barang_keluar'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="date" name="tanggal" class="form-control">
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>
                        <!-- <div class="navbar-nav ms-auto">
                            <?php if ($this->session->userdata('upk_bagian') != 'admin') : ?>
                                <a href="<?= base_url('barang_jadi/barang_masuk/upload') ?>"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Proses Barang Jadi</button></a>
                            <?php endif; ?>
                        </div> -->
                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center mb-2">
                        <div class="col-lg-6 text-center">
                            <h6><?= strtoupper($title); ?></h6>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <table class="table table-sm table-bordered" id="example">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Nama Barang</th>
                                        <th class="text-center">Jenis Barang</th>
                                        <th class="text-center">Jumlah Keluar</th>
                                        <th class="text-center">Jumlah Kembali</th>
                                        <th class="text-center">Jumlah Akhir</th>
                                        <th class="text-center">Input Oleh</th>
                                        <th class="text-center">Jenis Pesanan</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($barang_keluar as $row) :

                                    ?>
                                        <tr class="text-center">
                                            <td><?= $no++ ?></td>
                                            <td><?= $row->tanggal_keluar; ?></td>
                                            <td class="text-start"><?= $row->nama_produk; ?></td>
                                            <td class="text-start"><?= $row->jenis_produk; ?></td>
                                            <td><?= number_format($row->jumlah_keluar, 0, ',', '.'); ?></td>
                                            <td><?= number_format($row->jumlah_kembali, 0, ',', '.'); ?></td>
                                            <td><?= number_format($row->jumlah_akhir, 0, ',', '.'); ?></td>
                                            <td><?= $row->input_status_keluar; ?></td>
                                            <td><?= $row->jenis_pesanan; ?></td>
                                            <td>
                                                <a href="<?= $row->status_kembali == 0 ? base_url('barang_jadi/barang_keluar/barang_kembali/') : "javascript:void(0)" ?><?= $row->id_keluar_jadi; ?>"><span class="neumorphic-button text-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="klik input barang kembali"><i class="fas fa-box text-success"></i></span></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>