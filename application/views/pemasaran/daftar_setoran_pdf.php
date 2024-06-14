<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMDK | Daftar Pengiriman</title>
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
            font-size: 0.6rem;
            padding: 1.5px 3px;
        }

        .judul p {
            margin-bottom: 5px;
            font-size: 0.7rem;
            font-family: Arial, Helvetica, sans-serif;
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
        <p class="my-0 text-center fw-bold"><?= strtoupper($title); ?></p>
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
        <p class="my-0 text-center fw-bold"><?= $tanggal_hari_ini; ?></p>
    </div>
    <table class="table tableUtama">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Nama Pelanggan</th>
                <th class="text-center">Alamat</th>
                <th class="text-center">Jenis Barang</th>
                <th class="text-center">Jumlah</th>
                <th class="text-center">Harga</th>
                <th class="text-center">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $total_setoran_driver = 0;
            foreach ($setoran_driver as $row) :
                $total_setoran_driver = $row->total_setoran_driver;
            ?>
                <tr class="text-center">
                    <td><?= $no++ ?></td>
                    <td><?= date('d-m-y', strtotime($row->tanggal_pesan)); ?></td>
                    <td class="text-start"><?= ucwords(strtolower($row->nama_pelanggan)); ?></td>
                    <td class="text-start"><?= ucwords(strtolower($row->alamat_pelanggan)); ?></td>
                    <td class="text-start"><?= $row->nama_produk; ?></td>
                    <td class="text-end"><?= number_format($row->jumlah_pesan, 0, ',', '.'); ?></td>
                    <td class="text-end"><?= number_format($row->harga_barang, 0, ',', '.'); ?></td>
                    <td class="text-end"><?= number_format($row->total_harga, 0, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="7" class="text-end">Jumlah</th>
                <th class="text-end"><?= number_format($total_setoran_driver, 0, ',', '.'); ?></th>
            </tr>
        </tfoot>
    </table>

    <div style="font-size: 0.8rem;" class="tandaTangan">
        <p style="width: 50%; float: left; text-align:center; margin-bottom: 1px;"></p>
        <p style="width: 50%; float: right;text-align:center; margin-bottom: 1px;">Bondowoso, <?= $tanggal_hari_ini;  ?></p>
        <div style="clear: both;"></div>
        <div style="clear: both;"></div>
        <p style="width: 50%; float: right;text-align:center;">Petugas Setor</p>
        <p style="width: 50%; float: right;text-align:center;">Petugas Penerima</p>
        <div style="clear: both; margin-bottom:30px;"></div>
        <u style="width: 50%; float: right;text-align:center; margin-bottom: 1px;"><?= $petugas_setor; ?></u>
        <u style="width: 50%; float: right;text-align:center; margin-bottom: 1px;">____________</u>
        <div style="clear: both;"></div>
    </div>

    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>