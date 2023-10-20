<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('manager/karyawan/tambah'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-plus"></i> Tambah Karyawan</button></a>
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
                                    <th>Nama Karyawan</th>
                                    <th>N I K</th>
                                    <th>Jabatan</th>
                                    <th>Bagian</th>
                                    <th>J.Kelamin</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($karyawan as $row) :
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $row->nama_karyawan ?></td>
                                        <td><?= $row->nik_karyawan ?></td>
                                        <td><?= $row->jabatan ?></td>
                                        <td><?= $row->bagian ?></td>
                                        <td class="text-center"><?= $row->jenkel ?></td>
                                        <td class="text-center"><?= $row->status == 1 ? 'Aktif' : 'Non Aktif' ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url(); ?>manager/karyawan/edit/<?= $row->id_karyawan; ?>"><span class="btn btn-primary btn-sm"><i class="fas fa-fw fa-edit"></i> Edit</span></a>
                                            <a href="<?= base_url(); ?>manager/karyawan/hapus/<?= $row->id_karyawan; ?>" class="btn btn-danger btn-sm"><i class="fas fa-fw fa-trash"></i> Hapus</a>
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