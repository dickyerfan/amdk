<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <!-- <div class="navbar-nav">
                            <a href="<?= base_url('rkap/usulan_inves/export_pdf') ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
                        </div> -->
                        <div class="navbar-nav ms-auto">
                            <?php if ($this->session->userdata('upk_bagian') != 'admin') : ?>
                                <a href="<?= base_url('barang_baku/stok_barang_baku/upload') ?>"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Tambah Barang</button></a>
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
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <table class="table table-sm table-bordered" id="example" style="font-size: 1rem;">
                                <thead>
                                    <tr class="text-center">
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama Barang</th>
                                        <th class="text-center">Satuan</th>
                                        <!-- <th class="text-center">Kode Barang</th>
                                        <th class="text-center">Tanggal Stok Awal</th> -->
                                        <th class="text-center">Stok Awal</th>
                                        <th class="text-center">Barang Masuk</th>
                                        <th class="text-center">Barang Keluar</th>
                                        <th class="text-center">Barang Rusak</th>
                                        <th class="text-center">Stok Akhir</th>
                                        <th class="text-center">Stok / Pak</th>
                                        <th class="text-center">Minim Stok</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($stok_barang as $row) :
                                        $stok_akhir = $row->jumlah_stok_awal + $row->jumlah_masuk - $row->jumlah_keluar - $row->jumlah_rusak;
                                        $sisa_stok = $stok_akhir / $row->isi_stok_minimum;
                                        $stok_minimum = $row->jumlah_stok_minimum;
                                    ?>

                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= ucwords($row->nama_barang_baku); ?></td>
                                            <td><?= $row->satuan; ?></td>
                                            <!-- <td><?= $row->kode_barang; ?></td>
                                            <td class="text-center"><?= $row->tanggal_stok_awal_baku; ?></td> -->
                                            <td class="text-end"><?= number_format($row->jumlah_stok_awal, 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($row->jumlah_masuk, 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($row->jumlah_keluar, 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($row->jumlah_rusak, 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($stok_akhir, 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= round($sisa_stok); ?></td>
                                            <td class="text-end"><?= $stok_minimum; ?></td>
                                            <td class="text-center"><?= $stok_minimum < $sisa_stok ? '<span class="btn btn-success btn-sm">Cukup</span>' : '<span class="btn btn-danger btn-sm">Kurang</span>'; ?></td>
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