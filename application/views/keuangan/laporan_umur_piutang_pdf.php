<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMDK | <?=$title;?></title>
    <link href="<?= base_url(); ?>assets/datatables/bootstrap5/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        main {
            font-size: 0.8rem;
        }

        .header p {
            margin: 0;
            font-size: 0.7rem;
            /* Menghilangkan margin pada teks */
        }

        .tandaTangan p {
            font-size: 0.7rem;
        }

        .header img {
            margin-right: 10px;
        }

        hr {
            height: 1px;
            background-color: black !important;
            margin-top: 2px;
            width: 200px;
        }

        .tableUtama,
        .tableUtama thead,
        .tableUtama tr,
        .tableUtama th,
        .tableUtama td {
            border: 1px solid black;
            font-size: 0.5rem;
            padding: 1.5px 3px;
        }

        .judul p {

            margin-bottom: 5px;
            font-size: 0.7rem;
        }
    </style>

</head>

<body>
    <div class="header">
        <table>
            <tbody class="text_center">
                <tr>
                    <td width="10%">
                        <img src="<?= base_url('assets/img/logo_ijen.png'); ?>" alt="Logo" width="40">
                    </td>
                    <td>
                        <p>PDAM Kabupaten Bondowoso</p>
                        <p>IJEN WATER</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
    </div>
    <div class="judul">
        <p class="fw-bold my-0 text-center"><?= strtoupper($title); ?></p>
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
    <table class="table tableUtama">
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

    <?php
    $nik_manager = $manager->nik_karyawan;
    if ($nik_manager) {
        $nik_manager =  sprintf('%03s %02s %03s', substr($nik_manager, 0, 3), substr($nik_manager, 3, 2), substr($nik_manager, 5));
    } else {
        $nik_manager = '';
    }

    $nik_uang = $uang->nik_karyawan;
    if ($nik_uang) {
        $nik_uang = sprintf('%03s %02s %03s', substr($nik_uang, 0, 3), substr($nik_uang, 3, 2), substr($nik_uang, 5));
    } else {
        $nik_uang = '';
    }
    ?>

    <div style="font-size: 0.8rem;">
        <p style="width: 50%; float: left; text-align:center; margin-bottom: 1px;">Mengetahui</p>
        <p style="width: 50%; float: right;text-align:center; margin-bottom: 1px;">Dibuat Oleh :</p>
        <div style="clear: both;"></div>
        <p style="width: 50%; float: left; text-align:center;">Manager AMDK</p>
        <p style="width: 50%; float: right;text-align:center;">Bagian Administrasi & Keuangan</p>
        <div style="clear: both; margin-bottom:40px;"></div>
        <u style="width: 50%; float: left; text-align:center; margin-bottom: 1px;"><?= strtoupper($manager->nama_karyawan); ?></u>
        <u style="width: 50%; float: right;text-align:center; margin-bottom: 1px;"><?= strtoupper($uang->nama_karyawan); ?></u>
        <div style="clear: both;"></div>
        <p style="width: 50%; float: left; text-align:center;">NIK. <?= $nik_manager; ?></p>
        <p style="width: 50%; float: right;text-align:center;">NIK. <?= $nik_uang; ?></p>
        <div style="clear: both;"></div>
    </div>

    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>