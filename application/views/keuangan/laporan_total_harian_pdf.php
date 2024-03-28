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
            <tr class="text-center fw-bold">
                <td>No</td>
                <td>Uraian</td>
                <td>Satuan</td>
                <td>Beli</td>
                <td>Dipakai</td>
                <td>keterangan</td>
            </tr>
            <tr class="text-center fw-bold">
                <td colspan="3">Barang Produksi</td>
                <td>Terima</td>
                <td>Terjual</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $jumlah_total_produksi = 0;
            $jumlah_total_dipakai = 0;
            foreach ($data_produksi as $row) :
                $jumlah_total_produksi += $row->total_produksi;
                $dipakai = 0;
                foreach ($data_terjual as $terjual) {
                    if ($terjual->id_jenis_barang == $row->id_jenis_barang) {
                        $dipakai += $terjual->total_pesanan;
                        $jumlah_total_dipakai += $dipakai;
                    }
                }
            ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= $row->nama_barang_jadi; ?></td>
                    <td class="text-center">Dus</td>
                    <td class="text-center"><?= number_format($row->total_produksi, 0, ',', '.'); ?></td>
                    <td class="text-center"><?= number_format($dipakai, 0, ',', '.'); ?></td>
                    <td></td>
                </tr>
            <?php endforeach; ?>
            <tr class="fw-bold">
                <td colspan="3" class="text-center">Jumlah</td>
                <td class="text-center"><?= number_format($jumlah_total_produksi, 0, ',', '.')  ?></td>
                <td class="text-center"><?= number_format($jumlah_total_dipakai, 0, ',', '.')  ?></td>
                <td></td>
            </tr>
        </tbody>
        <thead>
            <tr class="text-center fw-bold">
                <td colspan="3">Penjualan Produk</td>
                <td>Tunai</td>
                <td>Piutang</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $jumlah_total_lunas = 0;
            $jumlah_total_piutang = 0;
            foreach ($data_lunas as $lunas) :
                $jumlah_total_lunas += $lunas->total_lunas;
                $piutang = 0;
                foreach ($data_piutang as $row) {
                    if ($row->id_jenis_barang == $lunas->id_jenis_barang) {
                        $piutang += $row->total_piutang;
                        $jumlah_total_piutang += $piutang;
                    }
                }
            ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= $lunas->nama_barang_jadi; ?></td>
                    <td class="text-center">Dus</td>
                    <td class="text-center"><?= number_format($lunas->total_lunas, 0, ',', '.'); ?></td>
                    <td class="text-center"><?= number_format($piutang, 0, ',', '.'); ?></td>
                    <td></td>
                </tr>
            <?php endforeach; ?>
            <tr class="fw-bold">
                <td colspan="3" class="text-center">Jumlah</td>
                <td class="text-center"><?= number_format($jumlah_total_lunas, 0, ',', '.')  ?></td>
                <td class="text-center"><?= number_format($jumlah_total_piutang, 0, ',', '.')  ?></td>
                <td></td>
            </tr>
        </tbody>
        <thead>
            <tr class="text-center fw-bold">
                <td colspan="3">Penerimaan</td>
                <td>Bulan lalu</td>
                <td>Bulan ini</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $jumlah_total_penerimaan = 0;
            $jumlah_total_penerimaan_lalu = 0;
            foreach ($data_penerimaan as $terima) :
                $jumlah_total_penerimaan += $terima->total_terima;
                $penerimaan_lalu = 0;
                foreach ($data_penerimaan_lalu as $lalu) {
                    if ($lalu->id_produk == $terima->id_jenis_barang) {
                        $penerimaan_lalu += $lalu->total_terima_lalu;
                        $jumlah_total_penerimaan_lalu += $penerimaan_lalu;
                    }
                }
            ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= $terima->nama_produk; ?></td>
                    <td class="text-center">Dus</td>
                    <td class="text-center"><?= number_format($penerimaan_lalu, 0, ',', '.'); ?></td>
                    <td class="text-center"><?= number_format($terima->total_terima, 0, ',', '.'); ?></td>
                    <td></td>
                </tr>
            <?php endforeach; ?>
            <tr class="fw-bold">
                <td colspan="3" class="text-center">Jumlah</td>
                <td class="text-center"><?= number_format($total_penerimaan_lalu, 0, ',', '.');  ?></td>
                <td class="text-center"><?= number_format($jumlah_total_penerimaan, 0, ',', '.');  ?></td>
                <td></td>
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