<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMDK | Laporan Harian</title>
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
            padding: 5 3px;
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
        <p class="my-0 text-center"><?= strtoupper($title); ?></p>
        <?php if (empty($tanggal_hari_ini)) {
            // Jika kosong atau null, atur nilainya menjadi tanggal hari ini
            $tanggal_hari_ini = date("Y-m-d"); // Format tanggal "YYYY-MM-DD"
        }
        // Ubah format tanggal ke bahasa Indonesia
        setlocale(LC_TIME, 'id_ID');
        $tanggal_hari_ini = strftime('%e %B %Y', strtotime($tanggal_hari_ini));
        // Ubah nama bulan menjadi bahasa Indonesia
        $bulan = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember',
        ];
        $tanggal_hari_ini = strtr($tanggal_hari_ini, $bulan);

        ?>
        <p class="mu-0 text-center">Per Tanggal <?= $tanggal_hari_ini; ?></p>
    </div>
    <table class="table tableUtama">
        <thead>
            <tr class="text-center">
                <th class="text-center">No</th>
                <th class="text-center">Nama Barang</th>
                <th class="text-center">Satuan</th>
                <th class="text-center">Stok Awal</th>
                <!-- <th class="text-center">Barang Masuk</th>
                <th class="text-center">Barang Keluar</th>
                <th class="text-center">Barang Rusak</th> -->
                <th class="text-center">Stok Akhir</th>
                <th class="text-center">Stok Fisik</th>
                <th class="text-center">Selisih</th>
                <th class="text-center">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($lap_harian as $row) :
                $stok_awal = $row->jumlah_stok_awal + $row->jumlah_masuk_kemaren - $row->jumlah_keluar_kemaren - $row->jumlah_rusak_kemaren;
                $stok_akhir = $row->jumlah_stok_awal + $row->jumlah_masuk - $row->jumlah_keluar - $row->jumlah_rusak;
            ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= ucwords($row->nama_barang_baku); ?></td>
                    <td><?= $row->satuan; ?></td>
                    <td class="text-end"><?= number_format($stok_awal, 0, ',', '.'); ?></td>
                    <!-- <td class="text-end"><?= number_format($row->jumlah_masuk_sekarang, 0, ',', '.'); ?></td>
                    <td class="text-end"><?= number_format($row->jumlah_keluar_sekarang, 0, ',', '.'); ?></td>
                    <td class="text-end"><?= number_format($row->jumlah_rusak_sekarang, 0, ',', '.'); ?></td> -->
                    <td class="text-end"><?= number_format($stok_akhir, 0, ',', '.'); ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
        <p style="width: 50%; float: right;text-align:center; margin-bottom: 1px;">Bondowoso, <?= $tanggal_hari_ini ?></p>
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
    </div>

    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>