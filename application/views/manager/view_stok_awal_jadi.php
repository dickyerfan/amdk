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
                            <a href="<?= base_url('manager/stok_awal_jadi/upload') ?>"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Tambah Stok Awal</button></a>
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
                                <table class="table table-sm table-bordered" id="example2">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Tanggal Stok Awal</th>
                                            <th class="text-center">Nama Barang</th>
                                            <th class="text-center">Jumlah Stok</th>
                                            <th class="text-center">Petugas Input</th>
                                            <th class="text-center">Tgl Input/Update</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($stok_barang_jadi as $row) : ?>
                                            <tr class="text-center">
                                                <td><?= $no++ ?></td>
                                                <td><?= date('d-m-Y', strtotime($row->tanggal_stok_awal_jadi)); ?></td>
                                                <td class="text-start"><?= $row->nama_barang_jadi; ?></td>
                                                <td><?= number_format($row->jumlah_stok_awal_jadi, 0, ',', '.'); ?></td>
                                                <td><?= $row->input_status_stok_awal_jadi; ?></td>
                                                <td><?= $row->tgl_input_stok_awal_jadi; ?></td>
                                                <td>
                                                    <a href="<?= $this->session->userdata('level') == 'Admin' ? base_url('manager/stok_awal_jadi/edit/') : "javascript:void(0)" ?><?= $row->id_stok_awal_jadi; ?>"><i class="fas fa-edit text-success"></i></a>
                                                    <!-- <a href="<?= base_url('manager/stok_awal_jadi/detail/') ?><?= $row->id_masuk_baku ?>"><i class="fa-solid fa-circle-info text-primary"></i></a>
                                                <a href="<?= base_url('manager/stok_awal_jadi/hapus/') ?><?= $row->id_masuk_baku ?>" class="hapus-link"><i class="fas fa-trash text-danger"></i></a> -->
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
        </div>
    </main>