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
                            <a href="<?= base_url('jenis_barang/upload') ?>"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Tambah Jenis Barang</button></a>
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
                                        <th class="text-center">Jenis Barang</th>
                                        <th class="text-center">Input Oleh</th>
                                        <th class="text-center">Tgl Input</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($jenis_barang as $row) : ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $row->jenis_barang; ?></td>
                                            <td><?= $row->created_by; ?></td>
                                            <td><?= $row->created_date; ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url('jenis_barang/edit/') ?><?= $row->id_jenis_barang ?>"><span class="btn btn-success btn-sm">Edit <i class="fas fa-edit"></i></span></a>
                                                <a href="<?= base_url('jenis_barang/hapus/') ?><?= $row->id_jenis_barang ?>" class="tombolHapus"><span class="btn btn-danger btn-sm">Hapus <i class="fas fa-trash"></i></span></a>
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