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
            font-size: 0.8rem;
            padding: 0 3px;
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
                        <img src="<?= base_url('assets/img/logo_ijen.png'); ?>" alt="Logo" width="30">
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
        $tanggal = $tanggal_lap;
        if (empty($tanggal)) {
            $hari = date('d');
            $bulan = date('m');
            $tahun = date('Y');
            $bulanLap = date('m');
            $tahunLap = date('Y');
        } else {
            $tanggalParts = explode('-', $tanggal);
            $tahun = (count($tanggalParts) > 0) ? $tanggalParts[0] : date('Y');
            $bulan = (count($tanggalParts) > 1) ? $tanggalParts[1] : date('m');
            $hari = (count($tanggalParts) > 2) ? $tanggalParts[2] : date('d');

            $hariLap = (count($tanggalParts) > 2) ? $tanggalParts[2] : date('d');
            $bulanLap = (count($tanggalParts) > 1) ? $tanggalParts[1] : date('m');
            $tahunLap = (count($tanggalParts) > 0) ? $tanggalParts[0] : date('Y');
            $bulan = str_pad($bulan, 2, '0', STR_PAD_LEFT);
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
            <tr class="text-center">
                <th class="text-center">No</th>
                <th class="text-center">Nama Barang</th>
                <th class="text-center">Satuan</th>
                <th class="text-center">Stok Awal</th>
                <th class="text-center">Barang Masuk</th>
                <th class="text-center">Barang Keluar</th>
                <th class="text-center">Barang Rusak</th>
                <th class="text-center">Stok Akhir</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($lap_bulanan as $row) :
                $stok_awal = $row->jumlah_stok_awal + $row->jumlah_masuk_kemaren - $row->jumlah_keluar_kemaren - $row->jumlah_rusak_kemaren;
                $stok_akhir = $row->jumlah_stok_awal + $row->jumlah_masuk - $row->jumlah_keluar - $row->jumlah_rusak;
            ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= $row->nama_barang_baku; ?></td>
                    <td><?= $row->satuan; ?></td>
                    <td class="text-end"><?= number_format($stok_awal, 0, ',', '.'); ?></td>
                    <td class="text-end"><?= number_format($row->jumlah_masuk_sekarang, 0, ',', '.'); ?></td>
                    <td class="text-end"><?= number_format($row->jumlah_keluar_sekarang, 0, ',', '.'); ?></td>
                    <td class="text-end"><?= number_format($row->jumlah_rusak_sekarang, 0, ',', '.'); ?></td>
                    <td class="text-end"><?= number_format($stok_akhir, 0, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
    $nik_manager = $manager->nik_karyawan;
    if ($nik_manager) {
        $nik_manager =  sprintf('%03s %02s %03s', substr($nik_manager, 0, 3), substr($nik_manager, 3, 2), substr($nik_manager, 5));
    } else {
        $nik_manager = '';
    }

    $nik_baku = $baku->nik_karyawan;
    if ($nik_baku) {
        $nik_baku = sprintf('%03s %02s %03s', substr($nik_baku, 0, 3), substr($nik_baku, 3, 2), substr($nik_baku, 5));
    } else {
        $nik_baku = '';
    }
    ?>

    <div style="font-size: 0.8rem;" class="tandaTangan">
        <p style="width: 50%; float: left; text-align:center; margin-bottom: 1px;"></p>
        <p style="width: 50%; float: right;text-align:center; margin-bottom: 1px;">Bondowoso, <?= $hariLap . ' ' . $bulanLap[$bulan] . ' ' . $tahunLap ?></p>
        <div style="clear: both;"></div>
        <p style="width: 50%; float: left; text-align:center; margin-bottom: 1px;">Mengetahui</p>
        <p style="width: 50%; float: right;text-align:center; margin-bottom: 1px;">Dibuat Oleh :</p>
        <div style="clear: both;"></div>
        <p style="width: 50%; float: left; text-align:center;">Manager AMDK</p>
        <p style="width: 50%; float: right;text-align:center;">Petugas Barang Baku</p>
        <div style="clear: both; margin-bottom:40px;"></div>
        <u style="width: 50%; float: left; text-align:center; margin-bottom: 1px;"><?= $manager->nama_karyawan; ?></u>
        <u style="width: 50%; float: right;text-align:center; margin-bottom: 1px;"><?= $baku->nama_karyawan; ?></u>
        <div style="clear: both;"></div>
        <p style="width: 50%; float: left; text-align:center;">NIK. <?= $nik_manager; ?></p>
        <p style="width: 50%; float: right;text-align:center;">NIK. <?= $nik_baku; ?></p>
        <div style="clear: both;"></div>
        <!-- <?php if ($manager) : ?>
            <p style="width: 50%; float: left; text-align: center;"><?= $manager->nama_karyawan; ?></p>
        <?php else : ?>
            <p style="width: 50%; float: left; text-align: center;">-</p>
        <?php endif; ?> -->
    </div>

    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>