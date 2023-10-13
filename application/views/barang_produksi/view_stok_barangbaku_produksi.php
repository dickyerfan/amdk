<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <!-- <div class="navbar-nav">
                            <a href="<?= base_url('rkap/usulan_inves/export_pdf') ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
                        </div> -->
                        <!-- <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('barang_baku/stok_barang_baku/upload') ?>"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Tambah Barang</button></a>
                        </div> -->
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
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <table class="table table-sm table-bordered" id="example" style="font-size: 1rem;">
                                <thead>
                                    <tr class="text-center">
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama Barang</th>
                                        <th class="text-center">Satuan</th>
                                        <th class="text-center">Jumlah Brg Baku</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($stok_barangbaku_produksi as $row) :
                                    ?>

                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= ucwords($row->nama_barang_baku); ?></td>
                                            <td><?= $row->satuan; ?></td>
                                            <td class="text-end"><?= number_format($row->jumlah_keluar, 0, ',', '.'); ?></td>
                                            <td></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>