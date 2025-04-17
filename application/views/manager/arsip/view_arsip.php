<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <!-- <div class="card-header card-primary shadow">
                    <h5 class="card-title"><?= $title ?></h5>
                    <a href="<?= base_url('arsip/tambah'); ?>"><button class="btn btn-primary btn-sm float-end"><i class="fas fa-plus"></i> Tambah Data</button></a>
                </div> -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-1">
                            <div class="card border-0 bg-danger shadow">
                                <div class="card-body bg-light cardEffect border-start border-danger border-5 rounded" data-bs-toggle="modal" data-bs-target="#eska">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <a href="#" class="text-decoration-none fw-bold text-dark text-uppercase" style="font-size: 0.8rem;">
                                                Surat Keputusan</a>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $sk ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-file-alt fa-2x text-gray-300" style="color:red;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-1">
                            <div class="card border-0 bg-success shadow">
                                <div class="card-body bg-light cardEffect border-start border-success border-5 rounded" data-bs-toggle="modal" data-bs-target="#peraturan">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <a href="#" class="text-decoration-none fw-bold text-dark text-uppercase" style="font-size: 0.8rem;">
                                                Peraturan</a>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $per ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-file-alt fa-2x text-gray-300" style="color:green;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-1">
                            <div class="card border-0 bg-warning shadow">
                                <div class="card-body bg-light cardEffect border-start border-warning border-5 rounded" data-bs-toggle="modal" data-bs-target="#berker">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <a href="#" class="text-decoration-none fw-bold text-dark text-uppercase" style="font-size: 0.8rem;">
                                                Berkas Kerja</a>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $bk ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-file-alt fa-2x text-gray-300" style="color:goldenrod;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-1">
                            <div class="card border-0 bg-primary shadow">
                                <div class="card-body bg-light cardEffect border-start border-primary border-5 rounded" data-bs-toggle="modal" data-bs-target="#dokumen">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <a href="#" class="text-decoration-none fw-bold text-dark text-uppercase" style="font-size: 0.8rem;">
                                                Dokumen</a>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $dk ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-file-alt fa-2x text-gray-300" style="color:blue;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <!-- <a href="<?= $this->session->userdata('level') == 'Admin' ? base_url('manager/arsip/tambah') : '#'; ?>"><button class="float-end neumorphic-button" data-bs-toggle="tooltip" title="Hanya Admin yang bisa upload data"><span><i class="fas fa-plus"></i> Upload File</span></button></a> -->
                    <a href="<?= base_url('manager/arsip/tambah') ?>"><button class="float-end neumorphic-button"><span><i class="fas fa-plus"></i> Upload File</span></button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="font-size: 0.7rem;">
                        <table id="example" class="table table-hover table-striped table-bordered table-sm" width="100%" cellspacing="0">
                            <thead>
                                <tr class="bg-secondary">
                                    <th class="text-center">No</th>
                                    <th class="text-center" width="10%">Action</th>
                                    <th class="text-center">Jenis</th>
                                    <th class="text-center">Nama Dokumen</th>
                                    <th class="text-center">Tentang</th>
                                    <th class="text-center">Tahun</th>
                                    <!-- <th class="text-center">Tgl Dokumen</th>
                                    <th class="text-center">Tgl Upload</th> -->
                                    <!-- <th class="text-center" width="8%">Download</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($arsip as $row) :
                                ?>
                                    <tr>
                                        <td class="text-center"><small><?= $no++ ?></small></td>
                                        <td class="text-center">
                                            <a href="<?= $this->session->userdata('level') == 'Admin' ? base_url('manager/arsip/edit/' . $row->id_arsip) : '#' ?>"><i class=" fas fa-fw fa-edit" data-bs-toggle="tooltip" title="Klik untuk Edit Data"></i></a>
                                            <a href="<?= $this->session->userdata('level') == 'Admin' ? base_url('manager/arsip/hapus/' . $row->id_arsip) : '#' ?>" class="tombolHapus"><i class="fas fa-fw fa-trash" style="color: red;" data-bs-toggle="tooltip" title="Klik untuk Hapus Data"></i></a>
                                            <a href="<?= base_url('manager/arsip/detail/') ?><?= $row->id_arsip; ?>"><i class="fas fa-fw fa-circle-info" style="color: black;" data-bs-toggle="tooltip" title="Klik untuk lihat Detail Data"></i></a>
                                            <a href="<?= base_url('manager/arsip/download/') ?><?= $row->id_arsip; ?>"> <i class="fas fa-download" style="text-decoration:none; color:green;" data-bs-toggle="tooltip" title="Klik untuk Download Data"></i></a>
                                            <a href="<?= base_url('manager/arsip/baca/') ?><?= $row->id_arsip; ?>" target="_blank"><i class="fas fa-book-open" style="text-decoration:none; color:orange;" data-bs-toggle="tooltip" title="Klik untuk Baca Data"></i> </a>
                                        </td>
                                        <td><?= $row->jenis ?></td>
                                        <td><?= $row->nama_dokumen ?></td>
                                        <td><?= $row->tentang ?></td>
                                        <td class="text-center"><?= $row->tahun ?></td>
                                        <!-- <td><?= $row->tgl_dokumen ?></td>
                                        <td><?= $row->tgl_upload ?></td> -->
                                        <!-- <td class="text-center">
                                            <a href="<?= base_url('arsip/download/') ?><?= $row->id_arsip; ?>"> <i class="fas fa-download" style="text-decoration:none; color:green;"></i></a>
                                            <a href="<?= base_url('arsip/baca/') ?><?= $row->id_arsip; ?>" target="_blank"><i class="fas fa-book-open" style="text-decoration:none; color:orange;"></i> </a>
                                        </td> -->
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Eska-->
        <div class="modal fade" id="eska" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header border-start border-danger border-5">
                        <h5 class="modal-title" id="exampleModalLabel">Daftar Surat Keputusan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php
                        $numOfCols = 4;
                        $rowCount = 0;
                        $bootstrapColWidth = 12 / $numOfCols;
                        ?>
                        <div class="row justify-content-center">
                            <?php foreach ($daftarEska as $row) : ?>
                                <div class="col-xl-<?= $bootstrapColWidth; ?> mb-1">
                                    <h6 style="font-size: 0.7rem;"><?= $row->nama_dokumen ?></h6>
                                </div>
                            <?php
                                $rowCount++;
                                if ($rowCount % $numOfCols == 0) echo '</div><div class="row">';
                            endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Peraturan-->
        <div class="modal fade" id="peraturan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header border-start border-success border-5">
                        <h5 class="modal-title" id="exampleModalLabel">Daftar Peraturan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php
                        $numOfCols = 4;
                        $rowCount = 0;
                        $bootstrapColWidth = 12 / $numOfCols;
                        ?>
                        <div class="row justify-content-center">
                            <?php foreach ($daftarPer as $row) : ?>
                                <div class="col-xl-<?= $bootstrapColWidth; ?> mb-1">
                                    <h6 style="font-size: 0.7rem;"><?= $row->nama_dokumen ?></h6>
                                </div>
                            <?php
                                $rowCount++;
                                if ($rowCount % $numOfCols == 0) echo '</div><div class="row">';
                            endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Berker-->
        <div class="modal fade" id="berker" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header border-start border-warning border-5">
                        <h5 class="modal-title" id="exampleModalLabel">Daftar Berkas Kerja</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php
                        $numOfCols = 4;
                        $rowCount = 0;
                        $bootstrapColWidth = 12 / $numOfCols;
                        ?>
                        <div class="row justify-content-center">
                            <?php foreach ($daftarBer as $row) : ?>
                                <div class="col-xl-<?= $bootstrapColWidth; ?> mb-1">
                                    <h6 style="font-size: 0.7rem;"><?= $row->nama_dokumen ?></h6>
                                </div>
                            <?php
                                $rowCount++;
                                if ($rowCount % $numOfCols == 0) echo '</div><div class="row">';
                            endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Dokumen-->
        <div class="modal fade" id="dokumen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header border-start border-primary border-5">
                        <h5 class="modal-title" id="exampleModalLabel">Daftar Dokumen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php
                        $numOfCols = 4;
                        $rowCount = 0;
                        $bootstrapColWidth = 12 / $numOfCols;
                        ?>
                        <div class="row justify-content-center">
                            <?php foreach ($daftarDok as $row) : ?>
                                <div class="col-xl-<?= $bootstrapColWidth; ?> mb-1">
                                    <h6 style="font-size: 0.7rem;"><?= $row->nama_dokumen ?></h6>
                                </div>
                            <?php
                                $rowCount++;
                                if ($rowCount % $numOfCols == 0) echo '</div><div class="row">';
                            endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>