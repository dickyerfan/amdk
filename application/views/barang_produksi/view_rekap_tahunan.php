<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <form method="get" action="<?= base_url('barang_produksi/laporan_produksi/rekap_tahunan') ?>">
                            <div style="display: flex; align-items: center;">
                                <input type="number" name="tahun" value="<?= $tahun ?>" class="form-control">
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>
                        <div class="navbar-nav ms-2">
                            <a href="<?= base_url('barang_produksi/laporan_produksi') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Kembali</button></a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('barang_produksi/laporan_produksi/export_rekap_tahunan') ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
                        </div>
                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div>
                                <p class="my-2 text-center"><?= strtoupper($title) ?></p>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" style="font-size: 0.7rem;">
                                    <thead>
                                        <tr class="text-center align-middle">
                                            <th>Bulan</th>
                                            <?php foreach ($produk_list as $produk) : ?>
                                                <th><?= $produk ?></th>
                                            <?php endforeach; ?>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $grand_total_produk = [];
                                        for ($bulan = 1; $bulan <= 12; $bulan++) :
                                            $bulanNama = DateTime::createFromFormat('!m', $bulan)->format('F');
                                            $total_bulan = 0;
                                            echo "<tr><td>$bulanNama</td>";
                                            foreach ($produk_list as $produk) :
                                                $jumlah = isset($rekap[$bulan][$produk]) ? $rekap[$bulan][$produk] : 0;
                                                echo '<td class="text-end">' . number_format($jumlah, 0, ',', '.') . '</td>';
                                                $total_bulan += $jumlah;

                                                if (!isset($grand_total_produk[$produk])) {
                                                    $grand_total_produk[$produk] = 0;
                                                }
                                                $grand_total_produk[$produk] += $jumlah;
                                            endforeach;
                                            echo '<td class="text-end fw-bold">' . number_format($total_bulan, 0, ',', '.') . '</td>';
                                            echo '</tr>';
                                        endfor;
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Total</th>
                                            <?php foreach ($produk_list as $produk) : ?>
                                                <th class="text-end"><?= number_format($grand_total_produk[$produk] ?? 0, 0, ',', '.') ?></th>
                                            <?php endforeach; ?>
                                            <th class="text-end fw-bold"><?= number_format(array_sum($grand_total_produk), 0, ',', '.') ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>