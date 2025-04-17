<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                        <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('manager/jenis_barang/upload') ?>"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Tambah Jenis Barang</button></a>
                        </div>
                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
<<<<<<< HEAD
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <table class="table table-sm table-bordered" id="example">
                                <thead>
                                    <tr class="bg-secondary text-center">
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama Barang</th>
                                        <th class="text-center">Jenis Barang</th>
                                        <th class="text-center">Input/update Oleh</th>
                                        <th class="text-center">Tgl Input/update</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($jenis_barang as $row) : ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $row->nama_barang_jadi; ?></td>
                                            <td><?= $row->jenis_barang; ?></td>
                                            <td><?= $row->input_jenis_barang; ?></td>
                                            <td><?= $row->tgl_input_jenis_barang; ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url('manager/jenis_barang/edit/') ?><?= $row->id_jenis_barang ?>"><span class="btn btn-primary btn-sm">Edit <i class="fas fa-edit"></i></span></a>
                                                <?php if ($this->session->userdata('nama_pengguna') == 'administrator') : ?>
                                                    <a href="<?= base_url('manager/jenis_barang/hapus/') ?><?= $row->id_jenis_barang ?>" class="tombolHapus"><span class="btn btn-danger btn-sm">Hapus <i class="fas fa-trash"></i></span></a>
                                                <?php endif; ?>
                                                <!-- <a href="<?= base_url('manager/jenis_barang/hapus/') ?><?= $row->id_jenis_barang ?>" class="tombolHapus"><span class="btn btn-danger btn-sm">Hapus <i class="fas fa-trash"></i></span></a> -->
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
=======
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" id="example">
                            <thead>
                                <tr class="bg-secondary text-center">
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nama Barang</th>
                                    <th class="text-center">Jenis Barang</th>
                                    <th class="text-center">Input/update Oleh</th>
                                    <th class="text-center">Tgl Input/update</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($jenis_barang as $row) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $row->nama_barang_jadi; ?></td>
                                        <td><?= $row->jenis_barang; ?></td>
                                        <td><?= $row->input_jenis_barang; ?></td>
                                        <td><?= $row->tgl_input_jenis_barang; ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url('manager/jenis_barang/edit/') ?><?= $row->id_jenis_barang ?>"><span class="btn btn-primary btn-sm">Edit <i class="fas fa-edit"></i></span></a>
                                            <?php if ($this->session->userdata('nama_pengguna') == 'administrator') : ?>
                                                <a href="<?= base_url('manager/jenis_barang/hapus/') ?><?= $row->id_jenis_barang ?>" class="tombolHapus"><span class="btn btn-danger btn-sm">Hapus <i class="fas fa-trash"></i></span></a>
                                            <?php endif; ?>
                                            <!-- <a href="<?= base_url('manager/jenis_barang/hapus/') ?><?= $row->id_jenis_barang ?>" class="tombolHapus"><span class="btn btn-danger btn-sm">Hapus <i class="fas fa-trash"></i></span></a> -->
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
>>>>>>> e9c10cc920a48ccd746593ce5035ca967e8640bb
                    </div>
                </div>
            </div>
        </div>
    </main>