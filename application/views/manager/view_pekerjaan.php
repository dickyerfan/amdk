<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header  card-primary shadow">
                    <h5 class="card-title">Dashboard Pekerjaan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-4 col-md-6 mb-2">
                            <div class="card bg-danger border-0 shadow">
                                <div class="card-body bg-light cardEffect border-start border-danger border-5 rounded">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs fw-bold text-dark text-uppercase mb-1" style="font-size: 0.8rem;">
                                                Daftar Jabatan</div>
                                            <div class="h5 mb-0 fw-bold text-gray-800" style="font-size: 0.9rem;"><?= $jabatan ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 mb-2">
                            <div class="card border-0 bg-success shadow">
                                <div class="card-body bg-light cardEffect border-start border-success border-5 rounded">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs fw-bold text-dark text-uppercase mb-1" style="font-size: 0.8rem;">
                                                Daftar Bagian</div>
                                            <div class="h5 mb-0 fw-bold text-gray-800" style="font-size: 0.9rem;"><?= $bagian; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-md fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 mb-2">
                            <div class="card border-0 bg-warning shadow">
                                <div class="card-body bg-light cardEffect border-start border-warning border-5 rounded">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs fw-bold text-dark text-uppercase mb-1" style="font-size: 0.8rem;">
                                                Daftar Sub Bagian</div>
                                            <div class="h5 mb-0 fw-bold text-gray-800" style="font-size: 0.9rem;"><?= $subag; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
            </div>
        </div>
        <div class="row g-0">
            <!-- tabel Jabatan -->
            <div class="col-lg-4">
                <div class="container-fluid px-2 mt-2">
                    <div class="card">
                        <div class="card-header card-outline card-primary shadow">
                            <a href="#"><button class="neumorphic-button float-end" data-bs-toggle="modal" data-bs-target="#inputJabatan"><i class="fas fa-plus"></i> Tambah Jabatan</button></a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-hover table-striped table-bordered table-sm" cellspacing="0" style="font-size: 0.8rem;">
                                    <thead>
                                        <tr class="bg-secondary text-center">
                                            <th>No</th>
                                            <th>Nama Jabatan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($jabatan1 as $jbt) :
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><?= $jbt->nama_jabatan ?></td>
                                                <td class="text-center">
                                                    <a href="#"><span data-bs-toggle="modal" data-bs-target="#editJabatan<?= $jbt->id_jabatan; ?>"><i class=" fas fa-fw fa-edit"></i></span></a>
                                                    <a href="<?= base_url(); ?>manager/pekerjaan/hapusJabatan/<?= $jbt->id_jabatan; ?>" class="tombolHapus" style="color: red;"><i class="fas fa-fw fa-trash"></i></a>
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
            <!-- akhir tabel Jabatan -->
            <!-- tabel Bagian -->
            <div class="col-lg-4">
                <div class="container-fluid px-2 mt-2">
                    <div class="card">
                        <div class="card-header shadow">
                            <a href="#"><button class="neumorphic-button float-end" data-bs-toggle="modal" data-bs-target="#inputBagian"><i class="fas fa-plus"></i> Tambah Bagian</button></a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example_2" class="table table-hover table-striped table-bordered table-sm" cellspacing="0" style="font-size: 0.8rem;">
                                    <thead>
                                        <tr class="bg-secondary text-center">
                                            <th>No</th>
                                            <th>Nama Bagian</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($bagian1 as $bgn) :
                                        ?>
                                            <tr>
                                                <td class="text-center"><small><?= $no++ ?></small></td>
                                                <td><?= $bgn->nama_bagian ?></td>
                                                <td class="text-center">
                                                    <a href="#"><span data-bs-toggle="modal" data-bs-target="#editBagian<?= $bgn->id_bagian; ?>"><i class=" fas fa-fw fa-edit"></i></span></a>
                                                    <a href="<?= base_url('manager/pekerjaan/hapusBagian/' . $bgn->id_bagian); ?>" class="tombolHapus" style="color: red;"><i class="fas fa-fw fa-trash"></i></a>
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
            <!-- akhir tabel Bagian -->
            <!-- tabel Subag -->
            <div class="col-lg-4">
                <div class="container-fluid px-2 mt-2">
                    <div class="card">
                        <div class="card-header card-outline card-primary shadow">
                            <a href="#"><button class="neumorphic-button float-end" data-bs-toggle="modal" data-bs-target="#inputSubag"><i class="fas fa-plus"></i> Tambah Sub Bagian</button></a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example_3" class="table table-hover table-striped table-bordered table-sm" cellspacing="0" style="font-size: 0.8rem;">
                                    <thead>
                                        <tr class="bg-secondary text-center">
                                            <th>No</th>
                                            <th>Nama Sub Bagian / UPK</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($subag1 as $sbg) :
                                        ?>
                                            <tr>
                                                <td class="text-center"><small><?= $no++ ?></small></td>
                                                <td><?= $sbg->nama_subag ?></td>
                                                <td class="text-center">
                                                    <a href="#"><span data-bs-toggle="modal" data-bs-target="#editSubag<?= $sbg->id_subag; ?>"><i class="fas fa-fw fa-edit"></i></span></a>
                                                    <a href="<?= site_url('manager/pekerjaan/hapusSubag/' . $sbg->id_subag); ?>" class="tombolHapus" style="color: red;"><i class="fas fa-fw fa-trash"></i></a>
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
            <!-- Akhir tabel Subag -->
        </div>

        <!-- Modal Input Jabatan -->
        <div class="modal fade" id="inputJabatan" tabindex="-1" aria-labelledby="exampleInputJabatan" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-uppercase" id="exampleInputJabatan">Input Jabatan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url('manager/pekerjaan/tambahJabatan') ?>" method="POST">
                            <div class="mb-2">
                                <label for="nama_jabatan">Nama Jabatan :</label>
                                <input type="text" class="form-control" id="nama_jabatan" name="nama_jabatan" placeholder="Masukan Nama Jabatan" value="<?= set_value('nama_jabatan'); ?>">
                                <small class="form-text text-danger pl-3"><?= form_error('nama_jabatan'); ?></small>
                            </div>
                            <button type="submit" class="neumorphic-button" name="inputJabatan">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal Input Jabatan -->

        <!-- Modal Edit Jabatan -->
        <?php $no = 0;
        foreach ($jabatanEdit as $row) : $no++; ?>
            <div class="row">
                <div id="editJabatan<?= $row->id_jabatan; ?>" class="modal fade" tabindex="-1" aria-labelledby="exampleEditJabatan" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="<?= base_url('manager/pekerjaan/editJabatan'); ?>" method="post">
                            <div class="modal-content">
                                <div class="modal-header bg-danger">
                                    <h5 class="modal-title text-uppercase" id="exampleEditJabatan">Edit Jabatan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" readonly value="<?= $row->id_jabatan; ?>" name="id_jabatan" class="form-control">
                                    <div class="mb-2">
                                        <label class="form-label">Nama Jabatan</label>
                                        <input type="text" name="nama_jabatan" autocomplete="off" value="<?= $row->nama_jabatan; ?>" placeholder="Masukkan Nama Jabatan" class="form-control">
                                    </div>
                                    <button type="submit" class="neumorphic-button" name="editJabatan">Update</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <!-- End Modal Edit Jabatan -->

        <!-- Modal Input Bagian -->
        <div class="modal fade" id="inputBagian" tabindex="-1" aria-labelledby="exampleInputBagian" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h5 class="modal-title text-uppercase" id="exampleInputBagian">Input Bagian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url('manager/pekerjaan/tambahBagian') ?>" method="POST">
                            <div class="mb-2">
                                <label for="nama_bagian">Nama Bagian :</label>
                                <input type="text" class="form-control" id="nama_bagian" name="nama_bagian" placeholder="Masukan Nama Bagian" value="<?= set_value('nama_bagian'); ?>">
                                <small class="form-text text-danger pl-3"><?= form_error('nama_bagian'); ?></small>
                            </div>
                            <button type="submit" class="neumorphic-button" name="inputBagian">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal Input Bagian -->

        <!-- Modal Edit Bagian -->
        <?php $no = 0;
        foreach ($bagianEdit as $row) : $no++; ?>
            <div class="row">
                <div id="editBagian<?= $row->id_bagian; ?>" class="modal fade" tabindex="-1" aria-labelledby="exampleEditBagian" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="<?= base_url('manager/pekerjaan/editBagian'); ?>" method="post">
                            <div class="modal-content">
                                <div class="modal-header bg-success">
                                    <h5 class="modal-title text-uppercase" id="exampleEditBagian">Edit Bagian</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" readonly value="<?= $row->id_bagian; ?>" name="id_bagian" class="form-control">
                                    <div class="mb-2">
                                        <label class="form-label">Nama Bagian</label>
                                        <input type="text" name="nama_bagian" autocomplete="off" value="<?= $row->nama_bagian; ?>" placeholder="Masukkan Nama Bagian" class="form-control">
                                    </div>
                                    <button type="submit" class="neumorphic-button" name="editBagian">Update</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <!-- End Modal Edit Bagian -->

        <!-- Modal Input Subag -->
        <div class="modal fade" id="inputSubag" tabindex="-1" aria-labelledby="exampleInputSubag" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title text-uppercase" id="exampleInputSubag">Input Sub Bagian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url('manager/pekerjaan/tambahSubag') ?>" method="POST">
                            <div class="mb-2">
                                <label for="nama_subag">Nama Sub Bagian :</label>
                                <input type="text" class="form-control" id="nama_subag" name="nama_subag" placeholder="Masukan Nama Subag" value="<?= set_value('nama_subag'); ?>">
                                <small class="form-text text-danger pl-3"><?= form_error('nama_subag'); ?></small>
                            </div>
                            <button type="submit" class="neumorphic-button" name="inputsubag">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal Input Subag -->

        <!-- Modal Edit Subag -->
        <?php $no = 0;
        foreach ($subagEdit as $row) : $no++; ?>
            <div class="row">
                <div id="editSubag<?= $row->id_subag; ?>" class="modal fade" tabindex="-1" aria-labelledby="exampleEditSubag" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="<?= base_url('manager/pekerjaan/editSubag'); ?>" method="post">
                            <div class="modal-content">
                                <div class="modal-header bg-warning">
                                    <h5 class="modal-title text-uppercase" id="exampleEditSubag">Edit Sub Bagian</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" readonly value="<?= $row->id_subag; ?>" name="id_subag" class="form-control">
                                    <div class="mb-2">
                                        <label class="form-label">Nama Sub Bagian</label>
                                        <input type="text" name="nama_subag" autocomplete="off" value="<?= $row->nama_subag; ?>" placeholder="Masukkan Nama Sub Bagian" class="form-control">
                                    </div>
                                    <button type="submit" class="neumorphic-button" name="editSubag">Update</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <!-- End Modal Edit Subag -->
    </main>