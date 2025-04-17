<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('keuangan/pelanggan/tambah'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-plus"></i> Tambah Pelanggan</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="form-group mb-1">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" id="searchInput" class="form-control" placeholder="Cari data pelanggan...">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="example2" class="table table-hover table-striped table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 0.8rem;">
                            <thead>
                                <tr class="bg-secondary text-center">
                                    <th>No</th>
                                    <th>Area Pelanggan</th>
                                    <th>Gol Pelanggan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Alamat Pelanggan</th>
                                    <th>Telpon Pelanggan</th>
                                    <th>Keterangan</th>
                                    <th>Tarif</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($pelanggan as $row) :
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $row->area_pelanggan ?></td>
                                        <td><?= $row->gol_pelanggan ?></td>
                                        <td><?= $row->nama_pelanggan ?></td>
                                        <td><?= $row->alamat_pelanggan ?></td>
                                        <td class="text-end"><?= $row->telpon_pelanggan ?></td>
                                        <td><?= $row->ket ?></td>
                                        <td class="text-center"><?= $row->tarif ?></td>
                                        <td class="text-center"><?= $row->aktif == 1 ? 'Aktif' : 'Non Aktif' ?></td>
                                        <td class="text-center">
                                            <?php if ($this->session->userdata('level') == 'Admin') : ?>
                                                <a href="<?= base_url(); ?>pemasaran/pelanggan/edit/<?= $row->id_pelanggan; ?>"><i class="fas fa-fw fa-edit" style="color: green;"></i></a>
                                            <?php else : ?>
                                                <a href="#" class="fas fa-fw fa-edit" style="color: black;"></a>
                                            <?php endif; ?>
                                            <?php if ($this->session->userdata('level') == 'Admin') : ?>
                                                <a href="<?= base_url(); ?>pemasaran/pelanggan/hapus/<?= $row->id_pelanggan; ?>" class="tombolHapus"><i class=" fas fa-fw fa-trash" style="color:red;"></i></a>
                                            <?php else : ?>
                                                <a href="#" class="fas fa-fw fa-trash" style="color: black;"></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>