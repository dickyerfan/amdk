<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('manager/pegawai/tambah'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-plus"></i> Tambah Pegawai</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-hover table-striped table-bordered table-sm" width="100%" cellspacing="0">
                            <thead>
                                <tr class="bg-secondary text-center">
                                    <th>No</th>
                                    <th>Bagian</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Status</th>
                                    <th>Status KYW</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($pegawai as $row) :
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $row->nama_bagian; ?></td>
                                        <td><?= $row->nama; ?></td>
                                        <td><?= $row->alamat; ?></td>
                                        <td><?= $row->aktif == 1 ? 'Aktif' : 'Purna'; ?></td>
                                        <td><?= $row->status_pegawai; ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url(); ?>manager/pegawai/edit/<?= $row->id; ?>"><span class="btn btn-primary btn-sm"><i class="fas fa-fw fa-edit"></i> Edit</span></a>
                                            <a href="<?= base_url(); ?>manager/pegawai/hapus/<?= $row->id; ?>" class="btn btn-danger btn-sm"><i class="fas fa-fw fa-trash"></i> Hapus</a>
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