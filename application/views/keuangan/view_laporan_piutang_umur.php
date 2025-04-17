<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <form id="umur_piutang" action="<?= base_url('keuangan/laporan_piutang/umur_piutang'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="submit" value="Umur Piutang" class="neumorphic-button">
                                <input type="hidden" id="umur_piutang" name="umur_piutang" class="form-control" style="margin-left: 10px;">
                            </div>
                        </form>
                        <form id="semua_piutang" action="<?= base_url('keuangan/laporan_piutang'); ?>" method="get">
                            <div style="display: flex; align-items: center;" class="ms-2">
                                <input type="submit" value="Semua Piutang" class="neumorphic-button">
                                <input type="hidden" id="semua_piutang" name="semua_piutang" class="form-control" style="margin-left: 10px;">
                            </div>
                        </form>
                        <form id="form_tanggal" action="<?= base_url('keuangan/laporan_piutang'); ?>" method="get">
                            <div style="display: flex; align-items: center;" class="ms-2">
                                <input type="submit" value="Pilih Perbulan" class="neumorphic-button">
                                <input type="date" id="tanggal" name="tanggal" class="form-control" style="margin-left: 10px;">
                            </div>
                        </form>
                        <form id="form_tahun" action="<?= base_url('keuangan/laporan_piutang/piutang_pertahun'); ?>" method="get">
                            <div style="display: flex; align-items: center;" class="ms-2">
                                <input type="submit" value="Pilih pertahun" class="neumorphic-button">
                                <!-- <input type="date" id="tahun" name="tahun" class="form-control" style="margin-left: 10px;"> -->
                                <select id="tahun" name="tahun" class="form-control" style="margin-left: 10px;">
                                    <?php
                                    $currentYear = date("Y");
                                    for ($year = $currentYear; $year >= 2020; $year--) {
                                        echo "<option value='$year'>$year</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </form>
                        <form id="form_samden" action="<?= base_url('keuangan/laporan_piutang/piutang_samden'); ?>" method="get">
                            <div style="display: flex; align-items: center;" class="ms-2">
                                <input type="submit" value="sampai/dengan" class="neumorphic-button">
                                <input type="date" id="samden" name="samden" class="form-control" style="margin-left: 10px;">
                            </div>
                        </form>
                        <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('keuangan/laporan_piutang/exportpdf_umur') ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
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
                            <div class="col-lg-12">
                                <div>
                                    <p class="my-0 text-center mb-2 fw-bold"><?= strtoupper($title) ?></p>
                                    <?php
                                    $tanggal = date('Y-m-d');
                                        list($tahun, $bulan, $hari) = explode('-', $tanggal);
                                        list($tahunLap, $bulanLap, $hariLap) = explode('-', $tanggal);
                                        $bulan = str_pad($bulan, 2, '0', STR_PAD_LEFT);
                                        $bulanLap = [
                                            '01' => 'Januari',
                                            '02' => 'Februari',
                                            '03' => 'Maret',
                                            '04' => 'April',
                                            '05' => 'Mei',
                                            '06' => 'Juni',
                                            '07' => 'Juli',
                                            '08' => 'Agustus',
                                            '09' => 'September',
                                            '10' => 'Oktober',
                                            '11' => 'November',
                                            '12' => 'Desember',
                                        ];
                                    ?>
                                        <p class="mu-0 text-center fw-bold">Per : <?=$hariLap.' '. $bulanLap[$bulan] . ' ' . $tahunLap ?></p>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" style="font-size: 0.9rem;">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="vertical-align: middle;" class="text-center">Nama Produk</th>
                                            <th colspan="2" class="text-center">1 Bulan</th>
                                            <th colspan="2" class="text-center">2 Bulan</th>
                                            <th colspan="2" class="text-center">3 Bulan</th>
                                            <th colspan="2" class="text-center">4 Bulan</th>
                                            <th colspan="2" class="text-center">5 Bulan</th>
                                            <th colspan="2" class="text-center">6 Bulan</th>
                                            <th colspan="2" class="text-center">7 Bulan s/d 1 Tahun</th>
                                            <th colspan="2" class="text-center">1 Tahun ke Atas</th>
                                            <th colspan="2" class="text-center">Jumlah</th>
                                        </tr>
                                        <tr class="text-center">
                                            <th>Pcs</th>
                                            <th>Rupiah</th>
                                            <th>Pcs</th>
                                            <th>Rupiah</th>
                                            <th>Pcs</th>
                                            <th>Rupiah</th>
                                            <th>Pcs</th>
                                            <th>Rupiah</th>
                                            <th>Pcs</th>
                                            <th>Rupiah</th>
                                            <th>Pcs</th>
                                            <th>Rupiah</th>
                                            <th>Pcs</th>
                                            <th>Rupiah</th>
                                            <th>Pcs</th>
                                            <th>Rupiah</th>
                                            <th>Pcs</th>
                                            <th>Rupiah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data_piutang as $piutang): 
                                            $total_barang_7_12_bulan = $piutang->total_barang_7_bulan + $piutang->total_barang_8_bulan + $piutang->total_barang_9_bulan + $piutang->total_barang_10_bulan + $piutang->total_barang_11_bulan + $piutang->total_barang_12_bulan;

                                            $total_piutang_7_12_bulan = $piutang->total_piutang_7_bulan + $piutang->total_piutang_8_bulan + $piutang->total_piutang_9_bulan + $piutang->total_piutang_10_bulan + $piutang->total_piutang_11_bulan + $piutang->total_piutang_12_bulan;

                                            $jumlah_barang = $piutang->total_barang_1_bulan + $piutang->total_barang_2_bulan + $piutang->total_barang_3_bulan + $piutang->total_barang_4_bulan + $piutang->total_barang_5_bulan + $piutang->total_barang_6_bulan + $total_barang_7_12_bulan + $piutang->total_barang_1_tahun_keatas;

                                            $jumlah_piutang = $piutang->total_piutang_1_bulan + $piutang->total_piutang_2_bulan + $piutang->total_piutang_3_bulan + $piutang->total_piutang_4_bulan + $piutang->total_piutang_5_bulan + $piutang->total_piutang_6_bulan + $total_piutang_7_12_bulan + $piutang->total_piutang_1_tahun_keatas;
                                            ?>
                                        <tr>
                                            <td><?= $piutang->nama_produk ?></td>
                                            <td class="text-end">
                                                <?= number_format($piutang->total_barang_1_bulan, 0, ',', '.') ?> 
                                            </td>
                                            <td class="text-end">
                                                <?= number_format($piutang->total_piutang_1_bulan, 0, ',', '.') ?>
                                            </td>
                                            <td class="text-end">
                                                <?= number_format($piutang->total_barang_2_bulan, 0, ',', '.') ?> 
                                            </td>
                                            <td class="text-end">
                                                <?= number_format($piutang->total_piutang_2_bulan, 0, ',', '.') ?>
                                            </td>
                                            <td class="text-end">
                                                <?= number_format($piutang->total_barang_3_bulan, 0, ',', '.') ?> 
                                            </td>
                                            <td class="text-end">
                                                <?= number_format($piutang->total_piutang_3_bulan, 0, ',', '.') ?>
                                            </td>
                                            <td class="text-end">
                                                <?= number_format($piutang->total_barang_4_bulan, 0, ',', '.') ?> 
                                            </td>
                                            <td class="text-end">
                                                <?= number_format($piutang->total_piutang_4_bulan, 0, ',', '.') ?>
                                            </td>
                                            <td class="text-end">
                                                <?= number_format($piutang->total_barang_5_bulan, 0, ',', '.') ?> 
                                            </td>
                                            <td class="text-end">
                                                <?= number_format($piutang->total_piutang_5_bulan, 0, ',', '.') ?>
                                            </td>
                                            <td class="text-end">
                                                <?= number_format($piutang->total_barang_6_bulan, 0, ',', '.') ?> 
                                            </td>
                                            <td class="text-end">
                                                <?= number_format($piutang->total_piutang_6_bulan, 0, ',', '.') ?>
                                            </td>
                                            <td class="text-end">
                                                <?= number_format($total_barang_7_12_bulan, 0, ',', '.') ?> 
                                            </td>
                                            <td class="text-end">
                                                <?= number_format($total_piutang_7_12_bulan, 0, ',', '.') ?>
                                            </td>
                                            <td class="text-end">
                                                <?= number_format($piutang->total_barang_1_tahun_keatas, 0, ',', '.') ?> 
                                            </td>
                                            <td class="text-end">
                                                <?= number_format($piutang->total_piutang_1_tahun_keatas, 0, ',', '.') ?>
                                            </td>
                                            <td class="text-end">
                                                <?= number_format($jumlah_barang, 0, ',', '.') ?>
                                            </td>
                                            <td class="text-end">
                                                <?= number_format($jumlah_piutang, 0, ',', '.') ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td><strong>Jumlah</strong></td>
                                            <td class="text-end"><strong><?= number_format($total_barang_1_bulan, 0, ',', '.') ?></strong></td>
                                            <td class="text-end"><strong><?= number_format($total_piutang_1_bulan, 0, ',', '.') ?></strong></td>
                                            <td class="text-end"><strong><?= number_format($total_barang_2_bulan, 0, ',', '.') ?></strong></td>
                                            <td class="text-end"><strong><?= number_format($total_piutang_2_bulan, 0, ',', '.') ?></strong></td>
                                            <td class="text-end"><strong><?= number_format($total_barang_3_bulan, 0, ',', '.') ?></strong></td>
                                            <td class="text-end"><strong><?= number_format($total_piutang_3_bulan, 0, ',', '.') ?></strong></td>
                                            <td class="text-end"><strong><?= number_format($total_barang_4_bulan, 0, ',', '.') ?></strong></td>
                                            <td class="text-end"><strong><?= number_format($total_piutang_4_bulan, 0, ',', '.') ?></strong></td>
                                            <td class="text-end"><strong><?= number_format($total_barang_5_bulan, 0, ',', '.') ?></strong></td>
                                            <td class="text-end"><strong><?= number_format($total_piutang_5_bulan, 0, ',', '.') ?></strong></td>
                                            <td class="text-end"><strong><?= number_format($total_barang_6_bulan, 0, ',', '.') ?></strong></td>
                                            <td class="text-end"><strong><?= number_format($total_piutang_6_bulan, 0, ',', '.') ?></strong></td>
                                            <td class="text-end"><strong><?= number_format($total_barang_7_to_12_bulan, 0, ',', '.') ?></strong></td>
                                            <td class="text-end"><strong><?= number_format($total_piutang_7_to_12_bulan, 0, ',', '.') ?></strong></td>
                                            <td class="text-end"><strong><?= number_format($total_barang_1_tahun_keatas, 0, ',', '.') ?></strong></td>
                                            <td class="text-end"><strong><?= number_format($total_piutang_1_tahun_keatas, 0, ',', '.') ?></strong></td>
                                            <td class="text-end"><strong><?= number_format($total_barang, 0, ',', '.') ?></strong></td>
                                            <td class="text-end"><strong><?= number_format($total_piutang, 0, ',', '.') ?></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>