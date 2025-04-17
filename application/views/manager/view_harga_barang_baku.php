<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('manager/harga_barang_baku/tambah'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-plus"></i> Tambah Harga</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-hover table-striped table-bordered table-sm" width="100%" cellspacing="0">
                            <thead>
                                <tr class="bg-secondary">
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nama Barang</th>
                                    <th class="text-center">Harga</th>
                                    <th class="text-center">Tanggal Berlaku</th>
                                    <th class="text-center">Input harga</th>
                                    <th class="text-center">Tgl Update</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($harga as $row) :
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><?= $row->nama_barang_baku; ?></td>
                                        <td class="text-end"><?= number_format($row->harga, 0, ',', '.'); ?></td>
                                        <td class="text-center"><?= $row->tanggal_berlaku; ?></td>
                                        <td class="text-center"><?= $row->input_harga_barang_baku; ?></td>
                                        <td class="text-center"><?= $row->tanggal_input; ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url(); ?>manager/harga_barang_baku/edit/<?= $row->id_harga; ?>"><span class="btn btn-primary btn-sm"><i class="fas fa-fw fa-edit"></i> Edit</span></a>
                                            <?php if ($this->session->userdata('nama_pengguna') == 'administrator') : ?>
                                                <a href="<?= base_url(); ?>manager/harga_barang_baku/hapus/<?= $row->id_harga; ?>" class="btn btn-danger btn-sm tombolHapus"><i class="fas fa-fw fa-trash"></i> Hapus</a>
                                            <?php endif; ?>
                                            <!-- <a href="<?= base_url(); ?>manager/harga_barang_baku/hapus/<?= $row->id_harga; ?>" class="btn btn-danger btn-sm"><i class="fas fa-fw fa-trash"></i> Hapus</a> -->
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