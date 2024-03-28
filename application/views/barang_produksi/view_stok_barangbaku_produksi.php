<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <!-- <form action="<?= base_url('barang_produksi/barang_baku_produksi'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="date" name="tanggal" class="form-control">
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>
                        <div class="navbar-nav ms-auto">
                            <?php if ($this->session->userdata('upk_bagian') != 'admin') : ?>
                                <a href="#"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Ambil Barang Baku</button></a>
                            <?php endif; ?>
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
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" id="example2" style="font-size: 1rem;">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nama Barang</th>
                                            <th class="text-center">Satuan</th>
                                            <th class="text-center">Stok Awal</th>
                                            <th class="text-center">Barang Masuk</th>
                                            <th class="text-center">Barang Keluar</th>
                                            <th class="text-center">Barang Rusak</th>
                                            <th class="text-center">Stok Akhir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($stok_barangbaku_produksi as $row) :
                                            // $stok_awal = 0;
                                            $stok_akhir = $row->jumlah_stok_awal + $row->jumlah_masuk - $row->jumlah_keluar - $row->jumlah_rusak;
                                        ?>

                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><?= ucwords($row->nama_barang_baku); ?></td>
                                                <td><?= $row->satuan; ?></td>
                                                <td class="text-end"><?= number_format($row->jumlah_stok_awal, 0, ',', '.'); ?></td>
                                                <td class="text-end"><?= number_format($row->jumlah_masuk, 0, ',', '.'); ?></td>
                                                <td class="text-end"><?= number_format($row->jumlah_keluar, 0, ',', '.'); ?></td>
                                                <td class="text-end"><?= number_format($row->jumlah_rusak, 0, ',', '.'); ?></td>
                                                <td class="text-end"><?= number_format($stok_akhir, 0, ',', '.'); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>