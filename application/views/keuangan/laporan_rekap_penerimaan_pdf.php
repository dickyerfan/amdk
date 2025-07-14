<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMDK | <?= $title; ?></title>
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
        <p class="fw-bold my-2 text-center"><?= strtoupper($title); ?></p>
    </div>
    <table class="table tableUtama">
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
        <p style="width: 50%; float: right;text-align:center; margin-bottom: 1px;">Dibuat Oleh,</p>
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