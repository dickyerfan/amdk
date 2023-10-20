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
                            <?php if ($this->session->userdata('upk_bagian') != 'admin') : ?>
                                <a href="<?= base_url('barang_baku/barang_rusak/upload') ?>"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Tambah Barang Rusak</button></a>
                            <?php endif; ?>
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
                            <table class="table table-sm table-bordered" id="example">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Tanggal Rusak</th>
                                        <th class="text-center">Nama Barang</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-center">Keterangan</th>
                                        <th class="text-center">Input Oleh</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($barang_rusak as $row) : ?>
                                        <tr class="text-center">
                                            <td><?= $no++ ?></td>
                                            <td><?= $row->tanggal_rusak_baku; ?></td>
                                            <td class="text-start"><?= $row->nama_barang_baku; ?></td>
                                            <td><?= number_format($row->jumlah_rusak_baku, 0, ',', '.'); ?></td>
                                            <td><?= $row->keterangan; ?></td>
                                            <td><?= $row->input_status_rusak_baku; ?></td>
                                            <td>
                                                <a href="<?= base_url('barang_baku/barang_rusak/detail_rusak/') ?><?= $row->id_rusak_baku ?>"><span class="neumorphic-button text-primary btn-sm"><i class="fa-solid fa-circle-info text-primary"></i> Detail</span></a>
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