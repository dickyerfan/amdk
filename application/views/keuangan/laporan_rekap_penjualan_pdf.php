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
                <th>Bulan</th>
                <?php foreach ($produk_list_total as $produk) : ?>
                    <th><?= $produk ?></th>
                <?php endforeach; ?>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $grand_total_produk_total = [];
            for ($bulan_total = 1; $bulan_total <= 12; $bulan_total++) :
                $bulanNama = DateTime::createFromFormat('!m', $bulan_total)->format('F');
                $total_bulan_total = 0;
                echo "<tr><td>$bulanNama</td>";
                foreach ($produk_list_total as $produk) :
                    $jumlah_total = isset($rekap_total[$bulan_total][$produk]) ? $rekap_total[$bulan_total][$produk] : 0;
                    echo '<td class="text-end">' . number_format($jumlah_total, 0, ',', '.') . '</td>';
                    $total_bulan_total += $jumlah_total;

                    if (!isset($grand_total_produk_total[$produk])) {
                        $grand_total_produk_total[$produk] = 0;
                    }
                    $grand_total_produk_total[$produk] += $jumlah_total;
                endforeach;
                echo '<td class="text-end fw-bold">' . number_format($total_bulan_total, 0, ',', '.') . '</td>';
                echo '</tr>';
            endfor;
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <?php foreach ($produk_list_total as $produk) : ?>
                    <th class="text-end"><?= number_format($grand_total_produk_total[$produk] ?? 0, 0, ',', '.') ?></th>
                <?php endforeach; ?>
                <th class="text-end fw-bold"><?= number_format(array_sum($grand_total_produk_total), 0, ',', '.') ?></th>
            </tr>
        </tfoot>
    </table>
    <div class="judul">
        <p class="fw-bold my-2 text-center"><?= strtoupper($title_1); ?></p>
    </div>
    <table class="table tableUtama">
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
    <div class="judul">
        <p class="fw-bold my-2 text-center"><?= strtoupper($title_2); ?></p>
    </div>
    <table class="table tableUtama">
        <thead>
            <tr class="text-center align-middle">
                <th>Bulan</th>
                <?php foreach ($produk_list_piutang as $produk) : ?>
                    <th><?= $produk ?></th>
                <?php endforeach; ?>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $grand_total_produk_piutang = [];
            for ($bulan_piutang = 1; $bulan_piutang <= 12; $bulan_piutang++) :
                $bulanNama = DateTime::createFromFormat('!m', $bulan_piutang)->format('F');
                $total_bulan_piutang = 0;
                echo "<tr><td>$bulanNama</td>";
                foreach ($produk_list_piutang as $produk) :
                    $jumlah_piutang = isset($rekap_piutang[$bulan_piutang][$produk]) ? $rekap_piutang[$bulan_piutang][$produk] : 0;
                    echo '<td class="text-end">' . number_format($jumlah_piutang, 0, ',', '.') . '</td>';
                    $total_bulan_piutang += $jumlah_piutang;

                    if (!isset($grand_total_produk_piutang[$produk])) {
                        $grand_total_produk_piutang[$produk] = 0;
                    }
                    $grand_total_produk_piutang[$produk] += $jumlah_piutang;
                endforeach;
                echo '<td class="text-end fw-bold">' . number_format($total_bulan_piutang, 0, ',', '.') . '</td>';
                echo '</tr>';
            endfor;
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <?php foreach ($produk_list_piutang as $produk) : ?>
                    <th class="text-end"><?= number_format($grand_total_produk_piutang[$produk] ?? 0, 0, ',', '.') ?></th>
                <?php endforeach; ?>
                <th class="text-end fw-bold"><?= number_format(array_sum($grand_total_produk_piutang), 0, ',', '.') ?></th>
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