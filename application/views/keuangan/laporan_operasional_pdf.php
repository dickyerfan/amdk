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
        <p class="mu-0 text-center">Bulan : <?= $bulan_lap . ' ' . $tahun_lap; ?></p>
    </div>
    <table class="table tableUtama">
        <thead>
            <tr class="text-center" style="vertical-align: middle;">
                <th class="text-center">No</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Nama</th>
                <?php foreach ($jenis_produk as $jenis) : ?>
                    <th class="text-center" style="vertical-align: middle;">
                        <?php
                        switch ($jenis->nama_barang_jadi) {
                            case 'galon 19l':
                                echo 'Galon 19l';
                                break;
                            case 'gelas 220ml ijen':
                                echo '220 Ijen Biru';
                                break;
                            case 'gelas 220ml genggong':
                                echo '220 Genggong';
                                break;
                            case 'gelas 220ml an nujum':
                                echo '220 AnNujum';
                                break;
                            case 'gelas 220ml syubbanq':
                                echo '220 SyubbanQ';
                                break;
                            case 'gelas 220ml amalis':
                                echo '220 Amalis';
                                break;
                            case 'gelas 220ml ijen merah':
                                echo '220 Ijen Merah';
                                break;
                            case 'botol 330ml ijen':
                                echo '330 Ijen';
                                break;
                            case 'botol 500ml ijen':
                                echo '500 Ijen';
                                break;
                            case 'botol 500ml amalis':
                                echo '500 Amalis';
                                break;
                            case 'botol 1500ml ijen':
                                echo '1500 Ijen';
                                break;
                            case 'botol 1500ml amalis':
                                echo '1500 Amalis';
                                break;
                            case 'galon kosong':
                                echo 'No Air';
                                break;
                            case 'botol 330ml genggong':
                                echo '330 Genggong';
                                break;
                            case 'botol 500ml genggong':
                                echo '500 Genggong';
                                break;
                            default:
                                echo $jenis->nama_barang_jadi;
                                break;
                        }
                        ?>
                    </th>
                <?php endforeach; ?>
                <th class="text-center">Total</th>
                <th class="text-center">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($grouped_ban_ops as $row) :
            ?>
                <tr>
                    <td class="text-center"><?= $no++; ?></td>
                    <td><?= date('d-m-Y', strtotime($row->tanggal_ban_ops)); ?></td>
                    <td><?= $row->nama_pelanggan; ?></td>
                    <?php foreach ($jenis_produk as $barang) : ?>
                        <?php
                        $jumlah_barang = isset($row->jumlah[$barang->nama_barang_jadi]) ? $row->jumlah[$barang->nama_barang_jadi] : ' ';
                        $total_harga = $row->harga_ban_ops_total;
                        ?>
                        <td class="text-center"><?= $jumlah_barang; ?></td>
                    <?php endforeach; ?>
                    <td class="text-end"><?= number_format($total_harga, 0, ',', '.'); ?></td>
                    <td><?= $row->keterangan ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="text-center" style="vertical-align: middle;">
                <th class="text-center" colspan="3">Jumlah</th>
                <?php foreach ($jenis_produk as $barang) : ?>
                    <?php
                    $total_jumlah_barang = 0;
                    $total_semua_harga = 0;

                    foreach ($grouped_ban_ops as $row) {
                        $jumlah_barang = isset($row->jumlah[$barang->nama_barang_jadi]) ? $row->jumlah[$barang->nama_barang_jadi] : 0;
                        $total_jumlah_barang += $jumlah_barang;
                        $total_semua_harga += $row->harga_ban_ops_total;
                    }
                    ?>
                    <th class="text-center" style="vertical-align: middle;"><?= $total_jumlah_barang; ?></th>
                <?php endforeach; ?>
                <th class="text-center" style="vertical-align: middle;"><?= number_format($total_semua_harga, 0, ',', '.'); ?></th>
                <th class="text-center"></th>
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
        <p style="width: 50%; float: right;text-align:center; margin-bottom: 1px;">Dibuat Oleh :</p>
        <div style="clear: both;"></div>
        <p style="width: 50%; float: left; text-align:center;">Manager AMDK</p>
        <p style="width: 50%; float: right;text-align:center;">Kabag Administrasi & Keuangan</p>
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