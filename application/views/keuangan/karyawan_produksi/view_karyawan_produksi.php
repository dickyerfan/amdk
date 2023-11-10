<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('keuangan/karyawan_produksi/tambah'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-plus"></i> Tambah Karyawan</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-hover table-striped table-bordered table-sm" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nama Karyawan</th>
                                    <th class="text-center">J.Kelamin</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Input/Update Oleh</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($karyawan as $row) :
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $row->nama_karyawan_produksi ?></td>
                                        <td class="text-center"><?= $row->jenkel ?></td>
                                        <td class="text-center"><?= $row->status == 1 ? 'Aktif' : 'Non Aktif' ?></td>
                                        <td class="text-center"><?= $row->input_karyawan_produksi ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url(); ?>keuangan/karyawan_produksi/edit/<?= $row->id_karyawan_produksi; ?>"><span class="neumorphic-button btn-sm"><i class="fas fa-fw fa-edit"></i> Edit</span></a>
                                            <a href="<?= base_url(); ?>keuangan/karyawan_produksi/hapus/<?= $row->id_karyawan_produksi; ?>" class="neumorphic-button btn-sm tombolHapus" style="text-decoration: none; color:red;"><i class="fas fa-fw fa-trash"></i> Hapus</a>
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