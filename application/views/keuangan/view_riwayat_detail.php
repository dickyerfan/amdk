<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <div class="navbar-nav ms-start">
                            <!-- <a href="<?=base_url('keuangan/riwayat_pembelian/ekspor')?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a> -->
                        </div>
                        <div class="navbar-nav  ms-end">
                            <a href="<?= base_url('keuangan/riwayat_pembelian'); ?>"><button class=" neumorphic-button"><i class="fas fa-reply"></i> Kembali</button></a>
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
                            <?php 
                            foreach ($detail_pelanggan as $row) :
                            ?>
                            <h5><?= strtoupper($row->nama_pelanggan); ?></h5>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" id="example" style="font-size: 0.8rem;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Tanggal Pesan</th>
                                            <th class="text-center">Tanggal Bayar</th>
                                            <th class="text-center">Nama Barang</th>
                                            <th class="text-center">Jumlah Pesanan</th>
                                            <th class="text-center">Harga Barang</th>
                                            <th class="text-center">Total Harga</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($detail_riwayat as $row) :
                                        ?>
                                            <tr class="text-center">
                                                <td><?= $no++ ?></td>
                                                <td class="text-center"><?= $row->tanggal_pesan; ?></td>
                                                <td class="text-center"><?= $row->tanggal_bayar; ?></td>
                                                <td class="text-start"><?= $row->nama_produk;?></td>
                                                <td class="text-center"><?= $row->jumlah_pesan; ?></td>
                                                <td class="text-end"><?= $row->harga_barang; ?></td>
                                                <td class="text-end"><?= $row->total_harga; ?></td>
                                                <td class="text-center"> 
                                                    <?= $row->status_bayar == 1 ? '<span class="btn btn-primary btn-sm">Lunas</span>':'<span class="btn btn-danger btn-sm">Hutang</span>' ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <!-- <tfoot>
                                        <tr>
                                            <th colspan="7" class="text-end">Jumlah</th>
                                            <th class="text-end"><?= number_format($total_penerimaan, 0, ',', '.'); ?></th>
                                        </tr>
                                    </tfoot> -->
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>