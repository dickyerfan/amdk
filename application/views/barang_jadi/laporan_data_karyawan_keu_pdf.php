<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMDK | Laporan Bulanan</title>
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
            font-size: 1rem;
            padding: 4px 3px;
        }

        .judul p {

            margin-bottom: 5px;
            font-size: 0.7rem;
        }

        .tableKedua,
        .tableKedua thead,
        .tableKedua tr,
        .tableKedua th,
        .tableKedua td {
            width: 50%;
            border: 1px solid black;
            font-size: 1rem;
            padding: 3px 3px;
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
        <p class="fw-bold my-0 text-center" style="font-size: 1rem;"><?= strtoupper($title); ?></p>
        <?php
        if (empty($bulan_lap)) {
            $bulan_lap = date('m');
            $tahun_lap = date('Y');
        }

        $bulan = [
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

        $bulan_lap = strtr($bulan_lap, $bulan);

        ?>
        <p class="mu-0 text-center" style="font-size: 1rem;">Bulan : <?= $bulan_lap . ' ' . $tahun_lap; ?></p>
    </div>
    <table class="table tableUtama">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Bagian</th>
                <th class="text-center">Nama Karyawan</th>
                <th class="text-center">Galon</th>
                <th class="text-center">Gelas 220</th>
                <th class="text-center">Botol 330</th>
                <th class="text-center">Botol 500</th>
                <th class="text-center">Botol 1500</th>
                <th class="text-center">Nominal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $total_galon = $total_gelas = $total_btl330 = $total_btl500 = $total_btl1500 = $total_nominal = 0;
            $harga_galon = 11000;
            $harga_220 = 15000;
            $harga_330 = 33000;
            $harga_500 = 35000;
            $harga_1500 = 38000;
            foreach ($rutin as $row) :
                $total_galon += $row->galon;
                $total_gelas += $row->gelas;
                $total_btl330 += $row->btl330;
                $total_btl500 += $row->btl500;
                $total_btl1500 += $row->btl1500;
                $total_nominal += $row->nominal;
            ?>
                <tr>
                    <td class="text-center"><?= $no++; ?></td>
                    <td><?= $row->nama_bagian; ?></td>
                    <td><?= $row->nama; ?></td>
                    <td class="text-center"><?= $row->galon == 0 ? '' : $row->galon; ?></td>
                    <td class="text-center"><?= $row->gelas == 0 ? '' : $row->gelas; ?></td>
                    <td class="text-center"><?= $row->btl330 == 0 ? '' : $row->btl330; ?></td>
                    <td class="text-center"><?= $row->btl500 == 0 ? '' : $row->btl500; ?></td>
                    <td class="text-center"><?= $row->btl1500 == 0 ? '' : $row->btl1500; ?></td>
                    <td class="text-end"><?= number_format($row->nominal, 0, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-end fw-bold">Jumlah</td>
                <td class="text-center fw-bold"><?= $total_galon; ?></td>
                <td class="text-center fw-bold"><?= $total_gelas; ?></td>
                <td class="text-center fw-bold"><?= $total_btl330; ?></td>
                <td class="text-center fw-bold"><?= $total_btl500; ?></td>
                <td class="text-center fw-bold"><?= $total_btl1500; ?></td>
                <td class="text-end fw-bold"><?= number_format($total_nominal, 0, ',', '.'); ?></td>
            </tr>
        </tfoot>
    </table>
    <table class="table tableKedua">
        <tr>
            <td>Galon</td>
            <td class="text-end fw-bold"></td>
            <td></td>
        </tr>
        <tr>
            <td>Air Galon</td>
            <td class="text-end fw-bold"><?= $total_galon; ?></td>
            <td class="text-end fw-bold"><?= number_format($total_galon * $harga_galon, 0, ',', '.'); ?></td>
        </tr>
        <tr>
            <td>Gelas 220 ml</td>
            <td class="text-end fw-bold"><?= $total_gelas; ?></td>
            <td class="text-end fw-bold"><?= number_format($total_gelas * $harga_220, 0, ',', '.'); ?></td>
        </tr>
        <tr>
            <td>Botol 330 ml</td>
            <td class="text-end fw-bold"><?= $total_btl330; ?></td>
            <td class="text-end fw-bold"><?= number_format($total_btl330 * $harga_330, 0, ',', '.'); ?></td>
        </tr>
        <tr>
            <td>Botol 500 ml</td>
            <td class="text-end fw-bold"><?= $total_btl500; ?></td>
            <td class="text-end fw-bold"><?= number_format($total_btl500 * $harga_500, 0, ',', '.'); ?></td>
        </tr>
        <tr>
            <td>Botol 1500 ml</td>
            <td class="text-end fw-bold"><?= $total_btl1500; ?></td>
            <td class="text-end fw-bold"><?= number_format($total_btl1500 * $harga_1500, 0, ',', '.'); ?></td>
        </tr>
        <tr>
            <td colspan="2" class="text-center fw-bold">Jumlah Total</td>
            <td class="text-end fw-bold"><?= number_format($total_nominal, 0, ',', '.'); ?></td>
        </tr>
    </table>

    <?php
    $nik_manager = $manager->nik_karyawan;
    if ($nik_manager) {
        $nik_manager =  sprintf('%03s %02s %03s', substr($nik_manager, 0, 3), substr($nik_manager, 3, 2), substr($nik_manager, 5));
    } else {
        $nik_manager = '';
    }

    $nik_jadi = $jadi->nik_karyawan;
    if ($nik_jadi) {
        $nik_jadi = sprintf('%03s %02s %03s', substr($nik_jadi, 0, 3), substr($nik_jadi, 3, 2), substr($nik_jadi, 5));
    } else {
        $nik_jadi = '';
    }
    ?>

    <div style="font-size: 0.8rem;">
        <p style="width: 50%; float: left; text-align:center; margin-bottom: 1px;"></p>
        <p style="width: 50%; float: right;text-align:center; margin-bottom: 1px;">Bondowoso, <?= $bulan_lap . ' ' . $tahun_lap; ?></p>
        <div style="clear: both;"></div>
        <p style="width: 50%; float: left; text-align:center; margin-bottom: 1px;">Mengetahui</p>
        <p style="width: 50%; float: right;text-align:center; margin-bottom: 1px;">Dibuat Oleh :</p>
        <div style="clear: both;"></div>
        <p style="width: 50%; float: left; text-align:center;">Manager AMDK</p>
        <p style="width: 50%; float: right;text-align:center;">Bagian Barang Jadi</p>
        <div style="clear: both; margin-bottom:40px;"></div>
        <u style="width: 50%; float: left; text-align:center; margin-bottom: 1px;"><?= strtoupper($manager->nama_karyawan); ?></u>
        <u style="width: 50%; float: right;text-align:center; margin-bottom: 1px;"><?= strtoupper($jadi->nama_karyawan); ?></u>
        <div style="clear: both;"></div>
        <p style="width: 50%; float: left; text-align:center;">NIK. <?= $nik_manager; ?></p>
        <p style="width: 50%; float: right;text-align:center;">NIK. <?= $nik_jadi; ?></p>
        <div style="clear: both;"></div>
    </div>

    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>