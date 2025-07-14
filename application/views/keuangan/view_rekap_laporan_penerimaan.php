<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <form method="get" action="<?= base_url('keuangan/laporan_penerimaan/rekap_tahunan') ?>">
                            <div style="display: flex; align-items: center;">
                                <input type="number" name="tahun" value="<?= $tahun ?>" class="form-control">
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>
                        <div class="navbar-nav ms-2">
                            <a href="<?= base_url('keuangan/laporan_penerimaan') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Kembali</button></a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('keuangan/laporan_penerimaan/export_rekap_tahunan') ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
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
                                            <th rowspan="2">Bulan</th>
                                            <?php foreach ($produk_list as $produk) : ?>
                                                <th colspan="2"><?= $produk ?></th>
                                            <?php endforeach; ?>
                                            <th colspan="2">Total</th>
                                        </tr>
                                        <tr class="text-center">
                                            <?php foreach ($produk_list as $produk) : ?>
                                                <th>Jumlah</th>
                                                <th>Rp</th>
                                            <?php endforeach; ?>
                                            <th>Jumlah</th>
                                            <th>Rp</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total_jumlah_all = 0;
                                        $total_harga_all = 0;
                                        for ($bulan = 1; $bulan <= 12; $bulan++) :
                                            $namaBulan = DateTime::createFromFormat('!m', $bulan)->format('F');
                                            echo "<tr><td>$namaBulan</td>";
                                            $total_jumlah_bulan = 0;
                                            $total_harga_bulan = 0;

                                            foreach ($produk_list as $produk) :
                                                $jumlah = $rekap[$bulan][$produk]['jumlah'] ?? 0;
                                                $harga = $rekap[$bulan][$produk]['harga'] ?? 0;

                                                echo "<td class='text-end'>" . number_format($jumlah) . "</td>";
                                                echo "<td class='text-end'>" . number_format($harga, 0, ',', '.') . "</td>";

                                                $total_jumlah_bulan += $jumlah;
                                                $total_harga_bulan += $harga;
                                            endforeach;

                                            $total_jumlah_all += $total_jumlah_bulan;
                                            $total_harga_all += $total_harga_bulan;

                                            echo "<td class='text-end fw-bold'>" . number_format($total_jumlah_bulan) . "</td>";
                                            echo "<td class='text-end fw-bold'>" . number_format($total_harga_bulan, 0, ',', '.') . "</td>";
                                            echo "</tr>";
                                        endfor;
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Total</th>
                                            <?php foreach ($produk_list as $produk) :
                                                $jumlah_total = 0;
                                                $harga_total = 0;
                                                for ($bulan = 1; $bulan <= 12; $bulan++) {
                                                    $jumlah_total += $rekap[$bulan][$produk]['jumlah'] ?? 0;
                                                    $harga_total += $rekap[$bulan][$produk]['harga'] ?? 0;
                                                }
                                                echo "<th class='text-end'>" . number_format($jumlah_total) . "</th>";
                                                echo "<th class='text-end'>" . number_format($harga_total, 0, ',', '.') . "</th>";
                                            endforeach; ?>
                                            <th class="text-end fw-bold"><?= number_format($total_jumlah_all) ?></th>
                                            <th class="text-end fw-bold"><?= number_format($total_harga_all, 0, ',', '.') ?></th>
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