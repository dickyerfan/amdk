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
            font-size: 0.7rem;
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
        <p class="my-0 text-center"><?= strtoupper($title) ?></p>
                        <?php
                        $tanggal = $tanggal_judul;
                        if (empty($tanggal)) {
                            $bulan = date('m');
                            $tahun = date('Y');
                            $bulanLap = date('m');
                            $tahunLap = date('Y');
                        } else {
                            list($tahunLap, $bulanLap, $hariLap) = explode('-', $tanggal);
                            $bulan = str_pad($bulanLap, 2, '0', STR_PAD_LEFT);
                        }
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
                        <p class="mu-0 text-center">Bulan : <?= $bulanLap[$bulan] . ' ' . $tahunLap ?></p>
    </div>
    <table class="table tableUtama">
    <thead>
        <tr class="bg-secondary text-center">
                                    <th>Tanggal</th>
                                    <th>Satuan</th>
                                    <th>Pembelian Air</th>
                                    <th>Pemakaian Air</th>
                                    <!-- <th>Air Terbuang</th> -->
                                    <th>Sisa Air</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($dateRange as $tanggal) : ?>
                                    <tr>
                                        <td class="text-center"><?= date('d-m-Y', strtotime($tanggal)) ?></td>
                                        <td class="text-center">Liter</td>
                                        <?php
                                        $total_pembelian_air = 0;
                                        $tanggal_ditemukan = false;

                                        foreach ($ambil_air as $row) : ?>
                                            <?php if (date('Y-m-d', strtotime($row->tanggal_ambil_air)) == $tanggal) : ?>
                                                <td class="text-center"><?= number_format($row->jumlah_air, 0, ',', '.'); ?></td>
                                                <?php $total_pembelian_air += $row->jumlah_air; ?>
                                                <?php $tanggal_ditemukan = true; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>

                                        <?php if (!$tanggal_ditemukan) : ?>
                                            <!-- Jika tanggal tidak ditemukan, isi kolom pembelian air dengan 0 -->
                                            <td class="text-center">0</td>
                                        <?php endif; ?>

                                        <?php
                                        $total_produksi_air = 0;
                                        $tanggal_ditemukan = false;

                                        foreach ($produksi_air as $row) : ?>
                                            <?php if (date('Y-m-d', strtotime($row->tanggal_barang_jadi)) == $tanggal) : ?>
                                                <td class="text-center"><?= number_format(round($row->jumlah_liter, 2), 2, ',', '.'); ?></td>
                                                <?php $tanggal_ditemukan = true; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>

                                        <?php if (!$tanggal_ditemukan) : ?>
                                            <!-- Jika tanggal tidak ditemukan, isi kolom pembelian air dengan 0 -->
                                            <td class="text-center">0</td>
                                        <?php endif; ?>
                                        <!-- <td></td> -->
                                        <td class="text-end"></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="fw-bold">Jumlah Bulan ini</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <!-- <td></td> -->
                                </tr>
                                <tr>
                                    <td colspan="2" class="fw-bold">Liter</td>
                                    <?php
                                    $total_pembelian_bulan_ini = 0;
                                    $total_pemakaian_air = 0;
                                    $total_air_terbuang = 0;
                                    $total_sisa_air = 0;

                                    foreach ($dateRange as $tanggal) : ?>
                                        <?php
                                        $tanggal_ditemukan = false;

                                        foreach ($ambil_air as $row) : ?>
                                            <?php if (date('Y-m-d', strtotime($row->tanggal_ambil_air)) == $tanggal) : ?>
                                                <?php $total_pembelian_bulan_ini += $row->jumlah_air; ?>
                                                <?php $tanggal_ditemukan = true; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>

                                        <?php
                                        $tanggal_ditemukan_produksi = false;

                                        foreach ($produksi_air as $row) : ?>
                                            <?php if (date('Y-m-d', strtotime($row->tanggal_barang_jadi)) == $tanggal) : ?>
                                                <?php $total_pemakaian_air += round($row->jumlah_liter, 2); ?>
                                                <?php $tanggal_ditemukan_produksi = true; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>

                                        <?php if (!$tanggal_ditemukan_produksi) : ?>
                                            <?php $total_pemakaian_air += 0; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <?php
                                    $total_pembelian = $total_pembelian_bulan_ini;
                                    $total_pemakaian = $total_pemakaian_air;
                                    $total_sisa_air_liter = $total_pembelian - $total_pemakaian;
                                    ?>

                                    <td class="text-center"><?= number_format($total_pembelian_bulan_ini, 2, ',', '.'); ?></td>
                                    <td class="text-center"><?= number_format($total_pemakaian_air, 2, ',', '.'); ?></td>
                                    <!-- <td class="text-center"><?= number_format($total_air_terbuang, 2, ',', '.'); ?></td> -->
                                    <td class="text-end"><?= number_format($total_sisa_air_liter, 2, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <?php
                                    $total_pembelian = $total_pembelian_bulan_ini / 1000;
                                    $total_pemakaian = $total_pemakaian_air / 1000;
                                    $total_sisa_air_kubik = $total_pembelian - $total_pemakaian;
                                    ?>
                                    <td colspan="2" class="fw-bold">Meter Kubik</td>
                                    <td class="text-center"><?= number_format($total_pembelian, 2, ',', '.'); ?></td>
                                    <td class="text-center"><?= number_format($total_pemakaian, 2, ',', '.'); ?></td>
                                    <!-- <td class="text-center"><?= number_format($total_air_terbuang, 2, ',', '.'); ?></td> -->
                                    <td class="text-end"><?= number_format($total_sisa_air_kubik, 2, ',', '.'); ?></td>
                                </tr>

                            </tfoot>
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
        <p style="width: 50%; float: right;text-align:center; margin-bottom: 1px;">Bondowoso, <?=$hariLap.' '. $bulanLap[$bulan] . ' ' . $tahunLap ?></p>
        <div style="clear: both;"></div>
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