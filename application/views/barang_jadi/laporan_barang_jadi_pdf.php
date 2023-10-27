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

        .header p,
        .judul p {
            margin: 0;
            /* Menghilangkan margin pada teks */
        }

        .header img {
            margin-right: 10px;
        }

        hr {
            height: 1px;
            background-color: black !important;
        }

        .tableUtama,
        .tableUtama thead,
        .tableUtama tr,
        .tableUtama th,
        .tableUtama td {
            border: 1px solid black;
            font-size: 0.7rem;
            padding: 3px 3px;
        }

        .judul {
            text-align: center;
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
        <p class="fw-bold"><?= strtoupper($title); ?></p>
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
        <p><?= $bulan_lap . ' ' . $tahun_lap; ?></p>
    </div>
    <table class="table tableUtama">
        <thead>
            <tr>
                <td>No</td>
                <td class="text-center">Tanggal</td> <!-- Date column -->
                <?php foreach ($nama_barang as $jenis) : ?>
                    <td class="text-center"><?= $jenis; ?></td>
                <?php endforeach; ?>
                <td class="text-center">Jumlah</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($dateRange as $tanggal) : ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td class="text-center" style="width: 70px;"><?= date('d-m-Y', strtotime($tanggal)) ?></td>
                    <?php
                    $total = 0;
                    foreach ($nama_barang as $jenis) : ?>
                        <td class="text-center">
                            <?php
                            // Cari nama barang yang cocok di $data_jenis_barang
                            $found = false;
                            foreach ($data_jenis_barang as $barang) {
                                if ($barang['nama_barang_jadi'] == $jenis) {
                                    $found = true;
                                    if (isset($barang['barang_jadi'][$tanggal])) {
                                        echo $barang['barang_jadi'][$tanggal];
                                        $jumlah_barang = $barang['barang_jadi'][$tanggal];
                                        $total += $jumlah_barang;
                                    } else {
                                        echo '0'; // Display 0 if no data for this date and product
                                    }
                                    break;
                                }
                            }
                            // Jika tidak ditemukan, munculkan '0'
                            if (!$found) {
                                echo '0';
                            }
                            ?>
                        </td>
                    <?php endforeach; ?>
                    <td class="text-center"><?= $total ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td>Jumlah</td>
                <?php
                $totalSemua = 0;
                foreach ($nama_barang as $jenis) : ?>
                    <td class="text-center">
                        <?php
                        $totalPerJenis = 0;
                        foreach ($dateRange as $tanggal) {
                            $totalPerJenisTanggal = 0;
                            foreach ($data_jenis_barang as $barang) {
                                if ($barang['nama_barang_jadi'] == $jenis) {
                                    if (isset($barang['barang_jadi'][$tanggal])) {
                                        $jumlah_barang = $barang['barang_jadi'][$tanggal];
                                        $totalPerJenisTanggal += $jumlah_barang;
                                        $totalSemua += $jumlah_barang; // Tambahkan ke total semua di sini
                                    }
                                }
                            }
                            $totalPerJenis += $totalPerJenisTanggal;
                        }
                        echo $totalPerJenis;
                        ?>
                    </td>
                <?php endforeach; ?>
                <td class='text-center'><?= $totalSemua ?></td>
            </tr>
        </tfoot>

    </table>

    <div style="font-size: 0.8rem;">
        <p style="width: 50%; float: left; text-align:center; margin-bottom: 1px;">Mengetahui</p>
        <p style="width: 50%; float: right;text-align:center; margin-bottom: 1px;">Dibuat Oleh :</p>
        <div style="clear: both;"></div>
        <p style="width: 50%; float: left; text-align:center;">Manager</p>
        <p style="width: 50%; float: right;text-align:center;">Petugas Barang Baku</p>
        <div style="clear: both; margin-bottom:40px;"></div>
        <u style="width: 50%; float: left; text-align:center; margin-bottom: 1px;"><?= $manager->nama_karyawan; ?></u>
        <u style="width: 50%; float: right;text-align:center; margin-bottom: 1px;"><?= $baku->nama_karyawan; ?></u>
        <div style="clear: both;"></div>
        <p style="width: 50%; float: left; text-align:center;"><?= $manager->nik_karyawan; ?></p>
        <p style="width: 50%; float: right;text-align:center;"><?= $baku->nik_karyawan; ?></p>
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