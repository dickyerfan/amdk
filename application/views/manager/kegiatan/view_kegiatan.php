<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <!-- <div class="card-header card-primary shadow">
                    <h5 class="card-title"><?= $title ?></h5>
                    <a href="<?= base_url('arsip/tambah'); ?>"><button class="btn btn-primary btn-sm float-end"><i class="fas fa-plus"></i> Tambah Data</button></a>
                </div> -->
            </div>
            <div class="card">
                <div class="card-header card-outline card-primary shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('manager/kegiatan/tambah') ?>"><button class="float-end neumorphic-button"><span><i class="fas fa-plus"></i> Upload File</span></button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="font-size: 1 rem;">
                        <table id="example" class="table table-hover table-striped table-bordered table-sm" width="100%" cellspacing="0">
                            <thead>
                                <tr class="bg-secondary">
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nama Kegiatan</th>
                                    <th class="text-center">Ketua Tim</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($kegiatan as $k) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $k->nama_kegiatan ?></td>
                                        <td><?= $k->ketua_tim ?></td>
                                        <td class="text-center">
                                            <a href="<?= site_url('manager/kegiatan/detail/' . $k->id) ?>"><button class="btn btn-primary btn-sm"><i class="fas fa-info-circle"></i> Detail</button> </a>
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