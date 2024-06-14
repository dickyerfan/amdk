<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <!-- <a href="<?= base_url('karyawan/karyawan_dashboard/tambah'); ?>"><button class="btn btn-primary btn-sm float-end" style="background: #f0f0f0; border: none; border-radius: 20px; box-shadow: 2px 2px 2px #eee, inset 8px 8px 8px #ffffff, inset -8px -8px 8px #cbced1; color: #333;font-size: 1rem; padding: .3rem .7rem; font-size:.7rem" onMouseOver="this.style.backgroundColor='#cbced1'" onMouseOut="this.style.backgroundColor='#ffffff'"><i class="fas fa-plus"></i> Tambah Karyawan</button></a> -->
                    <a href="<?= base_url('manager/pegawai/tambah'); ?>"><button class="neumorphic-button float-end"><span><i class="fas fa-plus"></i> Tambah Karyawan</span></button></a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-1">
                            <div class="card bg-danger border-0 shadow">
                                <div class="card-body bg-light cardEffect border-start border-danger border-5 rounded">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <a href="<?= base_url('manager/pegawai_tetap') ?>" class="text-decoration-none fw-bold text-dark text-uppercase" style="font-size: 0.8rem;">
                                                Karyawan Tetap</a>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800"><?= $kartetap ?></div>
                                            <!-- <a href="<?= base_url('karyawan/karyawan_tetap') ?>" class="text-decoration-none text-light fst-italic"><small>Detail</small></a> -->
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-1">
                            <div class="card bg-success border-0 shadow">
                                <div class="card-body bg-light cardEffect border-start border-success border-5 rounded">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <a href="<?= base_url('manager/pegawai_kontrak') ?>" class="text-decoration-none fw-bold text-dark text-uppercase" style="font-size: 0.8rem;">
                                                Karyawan Kontrak</a>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800"><?= $karkontrak; ?></div>
                                            <!-- <a href="<?= base_url('karyawan/karyawan_kontrak') ?>" class="text-decoration-none text-light fst-italic"><small>Detail</small></a> -->
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-1">
                            <div class="card bg-warning border-0 shadow">
                                <div class="card-body bg-light cardEffect border-start border-warning border-5 rounded">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <a href="<?= base_url('manager/pegawai_honorer') ?>" class="text-decoration-none fw-bold text-dark text-uppercase" style="font-size: 0.8rem;">
                                                Karyawan Honorer</a>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800"><?= $karhonorer; ?></div>
                                            <!-- <a href="<?= base_url('karyawan/karyawan_honorer') ?>" class="text-decoration-none text-light fst-italic"><small>Detail</small></a> -->
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-xl-3 col-md-6 mb-1">
                            <div class="card bg-secondary border-0 shadow">
                                <div class="card-body bg-light cardEffect border-start border-secondary border-5 rounded">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <a href="<?= base_url('karyawan/karyawan_purna') ?>" class="text-decoration-none fw-bold text-dark text-uppercase" style="font-size: 0.8rem;">
                                                Daftar Karyawan Purna</a>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800"><?= $karpurna; ?></div>
                                            <a href="<?= base_url('karyawan/karyawan_purna') ?>" class="text-decoration-none text-light fst-italic"><small>Detail</small></a>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-md fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="col-xl-3 col-md-6 mb-1">
                            <div class="card bg-primary border-0 shadow">
                                <div class="card-body bg-light cardEffect border-start border-primary border-5 rounded">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <a href="#" class="text-decoration-none fw-bold text-dark text-uppercase" style="font-size: 0.8rem;">
                                                Total Karyawan</a>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800"><?= $kartotal; ?></div>
                                            <!-- <a href="<?= base_url('karyawan/karyawan_dashboard') ?>" class="text-decoration-none text-light fst-italic"><small>Detail</small></a> -->
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row justify-content-center">
                        <div class="col-xl-6 col-md-6 mb-1">
                            <div class="card bg-primary border-0 shadow">
                                <div class="card-body bg-light cardEffect border-start border-primary border-5 rounded">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <a href="<?= base_url('karyawan/karyawan_semua') ?>" class="text-decoration-none fw-bold text-dark text-uppercase" style="font-size: 0.8rem;">
                                                Daftar Karyawan Total</a>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $kartotal; ?></div>
                                            <a href="<?= base_url('karyawan/karyawan_semua') ?>" class="text-decoration-none text-light fst-italic"><small>Detail</small></a>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
            <div class="card">
                <!-- <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('karyawan/karyawan_semua/tambah'); ?>"><button class="btn btn-primary btn-sm float-end" style="background: #f0f0f0; border: none; border-radius: 20px; box-shadow: 2px 2px 2px #eee, inset 8px 8px 8px #ffffff, inset -8px -8px 8px #cbced1; color: #333;font-size: 1rem; padding: .3rem .7rem; font-size:.7rem" onMouseOver="this.style.backgroundColor='#cbced1'" onMouseOut="this.style.backgroundColor='#ffffff'"><i class="fas fa-plus"></i> Tambah Karyawan</button></a>
                </div> -->
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="font-size: 0.7rem;">
                        <table id="example" class="table table-hover table-striped table-bordered table-sm" width="100%" cellspacing="0">
                            <thead>
                                <tr class="bg-secondary text-center">
                                    <th>No</th>
                                    <th>Action</th>
                                    <th>Nama Lengkap</th>
                                    <th>Nik</th>
                                    <th>Bagian</th>
                                    <th>SubBag</th>
                                    <th>Jabatan</th>
                                    <th>Alamat</th>
                                    <th>Agama</th>
                                    <th>Status Karyawan</th>
                                    <th>No HP</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tempat lahir</th>
                                    <th>Tanggal lahir</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Umur</th>
                                    <th>Aktif</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($karyawan as $row) :
                                ?>
                                    <?php
                                    $tanggalLahir = ubahNamaBulan($row->tgl_lahir);
                                    $tanggalMasuk = ubahNamaBulan($row->tgl_masuk);

                                    $tgl_lahir = new DateTime($row->tgl_lahir);
                                    $tgl_skrng = new DateTime();
                                    $umur = $tgl_skrng->diff($tgl_lahir)->y;
                                    ?>
                                    <tr>
                                        <td class="text-center"><small><?= $no++ ?></small></td>
                                        <td class="text-center">
                                            <a href="<?= base_url(); ?>manager/pegawai/edit/<?= $row->id; ?>"><i class="fas fa-fw fa-edit" data-bs-toggle="tooltip" title="Klik untuk Edit Data"></i></a>
                                            <a href="<?= site_url('manager/pegawai/hapus/' . $row->id); ?>" style="color: red;" class="tombolHapus"><i class="fas fa-fw fa-trash" data-bs-toggle="tooltip" title="Klik untuk Hapus Data"></i></a>
                                            <a href="<?= site_url('manager/pegawai/detail/' . $row->id); ?>" style="color: green;" data-bs-toggle="tooltip" title="Klik untuk Detail Data"><i class="fa-solid fa-circle-info"></i></a>
                                        </td>
                                        <td><?= $row->nama ?></td>
                                        <td><?= $row->nik ?></td>
                                        <td><?= $row->nama_bagian ?></td>
                                        <td><?= $row->nama_subag ?></td>
                                        <td class="text-center"><?= $row->nama_jabatan ?></td>
                                        <td><?= $row->alamat ?></td>
                                        <td><?= $row->agama ?></td>
                                        <td><?= $row->status_pegawai ?></td>
                                        <td><?= $row->no_hp ?></td>
                                        <td><?= $row->jenkel ?></td>
                                        <td><?= $row->tmp_lahir ?></td>
                                        <td><?= $tanggalLahir ?></td>
                                        <td><?= $tanggalMasuk == '30 November -0001' ? '-' : $tanggalMasuk ?></td>
                                        <td class="text-center"><?= $umur ?></td>
                                        <td><?= $row->aktif == 1 ? 'Aktif' : 'Purna' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>