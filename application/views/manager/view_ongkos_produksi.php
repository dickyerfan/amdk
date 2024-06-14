<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('manager/ongkos_produksi/tambah'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-plus"></i> Tambah Ongkos Produksi</button></a>
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
                                    <th>Nama Barang</th>
                                    <th>Ongkos Produksi</th>
                                    <th>Input Ongkos</th>
                                    <th>Tgl Update</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($ongkos_produksi as $row) :
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><?= $row->nama_produk; ?></td>
                                        <td class="text-end"><?= number_format($row->ongkos_per_unit, 0, ',', '.'); ?></td>
                                        <td class="text-center"><?= $row->input_ongkos; ?></td>
                                        <td class="text-center"><?= $row->tanggal_input_ongkos; ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url(); ?>manager/ongkos_produksi/edit/<?= $row->id_ongkos_produksi; ?>"><span class="btn btn-primary btn-sm"><i class="fas fa-fw fa-edit"></i> Edit</span></a>
                                            <?php if ($this->session->userdata('nama_pengguna') == 'administrator') : ?>
                                                <a href="<?= base_url(); ?>manager/ongkos_produksi/hapus/<?= $row->id_ongkos_produksi; ?>" class="btn btn-danger btn-sm tombolHapus"><i class="fas fa-fw fa-trash"></i> Hapus</a>
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