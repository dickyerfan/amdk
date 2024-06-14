<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <!-- <a href="<?= base_url('manager/harga/tambah'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-plus"></i> Tambah Harga</button></a> -->
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <!-- <div class="table-responsive">
                        <table id="example" class="table table-hover table-striped table-bordered table-sm" width="100%" cellspacing="0">
                            <thead>
                                <tr class="bg-secondary text-center">
                                    <th>No</th>
                                    <th>Nama Setting</th>
                                    <th>Jam Setting</th>
                                    <th>Input Setting</th>
                                    <th>Tanggal Setting</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($jam_lunas as $row) :
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><?= $row->nama_setting; ?></td>
                                        <td><?= $row->jam_setting; ?></td>
                                        <td><?= $row->input_setting; ?></td>
                                        <td class="text-center"><?= $row->tanggal_setting; ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url(); ?>manager/jam_lunas/edit/<?= $row->id_jam_lunas; ?>"><span class="btn btn-primary btn-sm"><i class="fas fa-fw fa-edit"></i> Edit</span></a>
                                            <?php if ($this->session->userdata('nama_pengguna') == 'administrator') : ?>
                                                <a href="<?= base_url(); ?>manager/jam_lunas/hapus/<?= $row->id_jam_lunas; ?>" class="btn btn-danger btn-sm tombolHapus"><i class="fas fa-fw fa-trash"></i> Hapus</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div> -->

                    <div class="row justify-content-start">
                        <?php
                        foreach ($jam_lunas as $row) :
                        ?>
                            <div class="col-xl-4 mb-4">
                                <div class="card border-0 bg-success shadow">
                                    <div class="card-body bg-light border-start border-success border-5 rounded">
                                        <div class="row justify-content-center">
                                            <div class="col-auto">
                                                <h4 class="text-success text-uppercase" style="font-size: 1.2rem;">Batas Jam Pelunasan : </h4>
                                                <h6 class="text-success text-uppercase" style="font-size: 3rem;"><i class="fas fa-fw fa-clock"></i><?= $row->jam_setting; ?></h6>
                                                <a href="<?= base_url(); ?>manager/jam_lunas/edit/<?= $row->id_jam_lunas; ?>"><span class="btn btn-success border cardEffect" style="font-size: 1.2rem;"><i class="fas fa-fw fa-edit"></i> Ubah Jam Pelunasan</span></a>
                                                <h6 class="mt-2 text-success" style="font-size: .7rem;">Input : <?= $row->input_setting; ?></h6>
                                                <h6 class="mt-2 text-success" style="font-size: .7rem;">Tanggal : <?= $row->tanggal_setting; ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>