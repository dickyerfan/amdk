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
        <p class="fw-bold my-0 text-center"><?= strtoupper($title); ?></p>
        <?php if (!empty($tahun_lap)) : ?>

            <p class="mu-0 text-center">Tahun : <?= $tahun_lap; ?></p>
        <?php else : ?>
            <p class="mu-0 text-center">Semua Piutang</p>
        <?php endif; ?>
    </div>
    <table class="table tableUtama">
        <thead>
            <tr class="text-center fw-bold">
                <td>No</td>
                <td>Nama Produk</td>
                <td>Satuan</td>
                <td>Jumlah Produk</td>
                <td>Jumlah Piutang</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $jumlah_total_piutang = 0;
            $jumlah_barang = 0;
            foreach ($data_piutang as $piutang) :
                $jumlah_total_piutang += $piutang->total_piutang;
                $jumlah_barang += $piutang->total_barang;
            ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= $piutang->nama_produk; ?></td>
                    <td class="text-center">Dus</td>
                    <td class="text-center"><?= number_format($piutang->total_barang, 0, ',', '.'); ?></td>
                    <td class="text-center"><?= number_format($piutang->total_piutang, 0, ',', '.'); ?></td>

                </tr>
            <?php endforeach; ?>
            <tr class=" fw-bold">
                <td colspan="3" class="text-center">Jumlah</td>
                <td class="text-center"><?= number_format($jumlah_barang, 0, ',', '.')  ?></td>
                <td class="text-center"><?= number_format($jumlah_total_piutang, 0, ',', '.')  ?></td>
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