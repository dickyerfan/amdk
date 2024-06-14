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
        <?php
        if (empty($tanggal_hari_ini) || $tanggal_hari_ini == 'Semua Piutang') {
            // Jika kosong atau nilainya adalah 'Semua Piutang', gunakan 'Semua Data Piutang'
            $tanggal_hari_ini = 'Semua Data Piutang';
        } else {
            // Ubah format tanggal ke bahasa Indonesia
            setlocale(LC_TIME, 'id_ID');
            $tanggal_hari_ini = strftime('%B %Y', strtotime($tanggal_hari_ini));
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
        }
        ?>
        <p class="my-0 text-center fw-bold mb-2"><?= $tanggal_hari_ini; ?></p>
    </div>
    <table class="table tableUtama">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Tgl Order</th>
                <th class="text-center">Jenis Barang</th>
                <th class="text-center">Nama Pelanggan</th>
                <th class="text-center">Mobil</th>
                <th class="text-center">Input Order</th>
                <th class="text-center">Jumlah</th>
                <th class="text-center">Harga</th>
                <th class="text-center">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $total_piutang = 0;
            foreach ($pesan as $row) :
                $tanggal_bayar = date('d-m-y', strtotime($row->tanggal_bayar));
                $total_piutang = $row->total_piutang;
            ?>
                <tr class="text-center">
                    <td><?= $no++ ?></td>
                    <td><?= date('d-m-y', strtotime($row->tanggal_pesan)); ?></td>
                    <td class="text-start"><?= $row->nama_produk; ?></td>
                    <td class="text-start"><?= ucwords(strtolower($row->nama_pelanggan)); ?></td>
                    <td class="text-start"><?= ucwords(strtolower($row->nama_mobil)); ?></td>
                    <td class="text-start"><?= ucwords(strtolower($row->input_pesan)); ?></td>
                    <td class="text-end"><?= number_format($row->jumlah_pesan, 0, ',', '.'); ?></td>
                    <td class="text-end"><?= number_format($row->harga_barang, 0, ',', '.'); ?></td>
                    <td class="text-end"><?= number_format($row->total_harga, 0, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="8" class="text-end">Jumlah</th>
                <th class="text-end"><?= number_format($total_piutang, 0, ',', '.'); ?></th>
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
    ?>

    <div style="font-size: 0.8rem;" class="tandaTangan">
        <p style="width: 50%; float: right;text-align:center; margin-bottom: 1px;">Bondowoso, <?= $tanggal_hari_ini == 'Semua Piutang' ? $tanggal_hari_ini : date('d-m-Y');  ?></p>
        <div style="clear: both;"></div>
        <p style="width: 50%; float: right;text-align:center;">Manager AMDK</p>
        <div style="clear: both; margin-bottom:30px;"></div>
        <u style="width: 50%; float: right; text-align:center; margin-bottom: 1px;"><?= $manager->nama_karyawan; ?></u>
        <div style="clear: both;"></div>
        <p style="width: 50%; float: right; text-align:center;">NIK. <?= $nik_manager; ?></p>
        <div style="clear: both;"></div>
    </div>

    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>