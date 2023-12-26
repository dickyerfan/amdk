<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <div class="navbar-nav ms-auto">
                            <?php if ($this->session->userdata('upk_bagian') != 'admin') : ?>
                                <a href="<?= base_url('barang_jadi/rutin_karyawan/tambah'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-plus"></i> Tambah Rutin Karyawan</button></a>
                            <?php endif; ?>
                        </div>
                    </nav>

                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center mb-2">
                        <div class="col-lg-6 text-center">
                            <h5><?= strtoupper($title); ?></h5>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="example" class="table table-hover table-striped table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 0.8rem;">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Bagian</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Alamat</th>
                                    <th class="text-center">Galon</th>
                                    <th class="text-center">Gelas 220</th>
                                    <th class="text-center">Botol 330</th>
                                    <th class="text-center">Botol 500</th>
                                    <th class="text-center">Botol 1500</th>
                                    <th class="text-center">Nominal</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($rutin as $row) :
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><?= $row->nama_bagian; ?></td>
                                        <td><?= $row->nama; ?></td>
                                        <td><?= $row->alamat; ?></td>
                                        <td class="text-center"><?= $row->galon; ?></td>
                                        <td class="text-center"><?= $row->gelas; ?></td>
                                        <td class="text-center"><?= $row->btl330; ?></td>
                                        <td class="text-center"><?= $row->btl500; ?></td>
                                        <td class="text-center"><?= $row->btl1500; ?></td>
                                        <td class="text-end"><?= $row->nominal; ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url(); ?>barang_jadi/rutin_karyawan/edit/<?= $row->id_rutin; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="klik untuk edit jatah Karyawan"><i class="fas fa-fw fa-edit" style="color: green;"></i></a>
                                            <!-- <a href="<?= base_url(); ?>barang_jadi/rutin_karyawan/hapus/<?= $row->id_rutin; ?>" class="tombolHapus"><i class=" fas fa-fw fa-trash" style="color:red;"></i></a> -->
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