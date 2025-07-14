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
        <hr class="my-1">
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
            <p class="mb-1"><?= strtoupper($title); ?></p>
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
            <p class="mb-1"><?= $tanggal_hari_ini; ?></p>
        </div>
    </div>
    <table class="table tableUtama">
        <thead class="bg-secondary text-white text-center">
            <tr>
                <th rowspan="2" class="align-middle">No</th>
                <th rowspan="2" class="align-middle">Nama</th>
                <th colspan="2">220 ml</th>
                <th colspan="2">330 ml</th>
                <th colspan="2">500 ml</th>
                <th colspan="2">1500 ml</th>
                <th colspan="2">Galon 19</th>
                <th colspan="2">Non Air</th>
                <th rowspan="2" class="align-middle">Jumlah</th>
            </tr>
            <tr>
                <th>Jml</th>
                <th>Rp</th>
                <th>Jml</th>
                <th>Rp</th>
                <th>Jml</th>
                <th>Rp</th>
                <th>Jml</th>
                <th>Rp</th>
                <th>Jml</th>
                <th>Rp</th>
                <th>Jml</th>
                <th>Rp</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $total_all = 0;
            foreach ($grouped_data as $nama => $produk) :
                $total_all += $produk['total'];
            ?>
                <tr class="text-end">
                    <td class="text-center"><?= $no++; ?></td>
                    <td class="text-start"><?= $nama; ?></td>
                    <td><?= $produk['220ml']['jumlah']; ?></td>
                    <td><?= number_format($produk['220ml']['rupiah'], 0, ',', '.'); ?></td>
                    <td><?= $produk['330ml']['jumlah']; ?></td>
                    <td><?= number_format($produk['330ml']['rupiah'], 0, ',', '.'); ?></td>
                    <td><?= $produk['500ml']['jumlah']; ?></td>
                    <td><?= number_format($produk['500ml']['rupiah'], 0, ',', '.'); ?></td>
                    <td><?= $produk['1500ml']['jumlah']; ?></td>
                    <td><?= number_format($produk['1500ml']['rupiah'], 0, ',', '.'); ?></td>
                    <td><?= $produk['galon 19']['jumlah']; ?></td>
                    <td><?= number_format($produk['galon 19']['rupiah'], 0, ',', '.'); ?></td>
                    <td><?= $produk['galon kosong']['jumlah']; ?></td>
                    <td><?= number_format($produk['galon kosong']['rupiah'], 0, ',', '.'); ?></td>
                    <td><?= number_format($produk['total'], 0, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot class="bg-light text-end fw-bold">
            <tr>
                <td colspan="2" class="text-end">Jumlah</td>
                <td><?= $total_produk['220ml']['jumlah']; ?></td>
                <td><?= number_format($total_produk['220ml']['rupiah'], 0, ',', '.'); ?></td>
                <td><?= $total_produk['330ml']['jumlah']; ?></td>
                <td><?= number_format($total_produk['330ml']['rupiah'], 0, ',', '.'); ?></td>
                <td><?= $total_produk['500ml']['jumlah']; ?></td>
                <td><?= number_format($total_produk['500ml']['rupiah'], 0, ',', '.'); ?></td>
                <td><?= $total_produk['1500ml']['jumlah']; ?></td>
                <td><?= number_format($total_produk['1500ml']['rupiah'], 0, ',', '.'); ?></td>
                <td><?= $total_produk['galon 19']['jumlah']; ?></td>
                <td><?= number_format($total_produk['galon 19']['rupiah'], 0, ',', '.'); ?></td>
                <td><?= $total_produk['galon kosong']['jumlah']; ?></td>
                <td><?= number_format($total_produk['galon kosong']['rupiah'], 0, ',', '.'); ?></td>
                <td><?= number_format($total_semua, 0, ',', '.'); ?></td>
            </tr>
        </tfoot>
    </table>

    <!-- <?php
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
    </div> -->

    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>