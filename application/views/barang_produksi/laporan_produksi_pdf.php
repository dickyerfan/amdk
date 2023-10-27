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
            <tr>
                <td rowspan="2" style="vertical-align: middle;">No</td>
                <td rowspan="2" class="text-center" style="vertical-align: middle;">Tanggal</td> <!-- Date column -->
                <?php foreach ($nama_barang as $jenis) : ?>
                    <td colspan="2" class="text-center"><?= $jenis; ?></td>
                <?php endforeach; ?>
                <td colspan="2" class="text-center" style="vertical-align: middle;">Jumlah</td>
            </tr>
            <tr class="text-center">
                <?php foreach ($nama_barang as $jenis) : ?>
                    <td>bh</td>
                    <td>ltr</td>
                <?php endforeach; ?>
                <td>bh</td>
                <td>ltr</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($dateRange as $tanggal) : ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td class="text-center"><?= date('d-m-Y', strtotime($tanggal)) ?></td>
                    <?php
                    $totalSatuan = 0;
                    $totalLiter = 0;
                    foreach ($nama_barang as $jenis) : ?>
                        <td class="text-center">
                            <?php
                            // Cari nama barang yang cocok di $jumlah_satuan
                            $found = false;
                            foreach ($jumlah_satuan as $barang) {
                                if ($barang['nama_barang_jadi'] == $jenis) {
                                    $found = true;
                                    if (isset($barang['barang_jadi'][$tanggal])) {
                                        echo number_format($barang['barang_jadi'][$tanggal], 0, ',', '.');
                                        $jumlah_barang = $barang['barang_jadi'][$tanggal];
                                        $totalSatuan += $jumlah_barang;
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
                        <td class="text-center">
                            <?php
                            // Cari nama barang yang cocok di $jumlah_liter
                            $found = false;
                            foreach ($jumlah_liter as $barang) {
                                if ($barang['nama_barang_jadi'] == $jenis) {
                                    $found = true;
                                    if (isset($barang['barang_jadi'][$tanggal])) {
                                        echo number_format($barang['barang_jadi'][$tanggal], 0, ',', '.');
                                        $jumlah_barang = $barang['barang_jadi'][$tanggal];
                                        $totalLiter += $jumlah_barang;
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
                    <td class="text-center"><?= number_format($totalSatuan, 0, ',', '.')  ?></td>
                    <td class="text-center"><?= number_format($totalLiter, 0, ',', '.')  ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td>Jumlah Satuan</td>
                <?php
                $totalSatuan = 0;
                $totalLiter = 0;
                foreach ($nama_barang as $jenis) : ?>
                    <td class="text-center">
                        <?php
                        $totalPerJenis = 0;
                        foreach ($dateRange as $tanggal) {
                            $totalPerJenisTanggal = 0;
                            foreach ($jumlah_satuan as $barang) {
                                if ($barang['nama_barang_jadi'] == $jenis) {
                                    if (isset($barang['barang_jadi'][$tanggal])) {
                                        $jumlah_barang = $barang['barang_jadi'][$tanggal];
                                        $totalPerJenisTanggal += $jumlah_barang;
                                        $totalSatuan += $jumlah_barang; // Tambahkan ke total semua di sini
                                    }
                                }
                            }
                            $totalPerJenis += $totalPerJenisTanggal;
                        }
                        echo number_format($totalPerJenis, 0, ',', '.');
                        ?>
                    </td>
                    <td class="text-center">
                        <?php
                        $totalPerJenis = 0;
                        foreach ($dateRange as $tanggal) {
                            $totalPerJenisTanggal = 0;
                            foreach ($jumlah_liter as $barang) {
                                if ($barang['nama_barang_jadi'] == $jenis) {
                                    if (isset($barang['barang_jadi'][$tanggal])) {
                                        $jumlah_barang = $barang['barang_jadi'][$tanggal];
                                        $totalPerJenisTanggal += $jumlah_barang;
                                        $totalLiter += $jumlah_barang; // Tambahkan ke total semua di sini
                                    }
                                }
                            }
                            $totalPerJenis += $totalPerJenisTanggal;
                        }
                        echo number_format($totalPerJenis, 0, ',', '.');
                        ?>
                    </td>
                <?php endforeach; ?>
                <td class='text-center'><?= number_format($totalSatuan, 0, ',', '.')  ?></td>
                <td class='text-center'><?= number_format($totalLiter, 0, ',', '.')  ?></td>
            </tr>
        </tfoot>
    </table>

    <div style="font-size: 0.8rem;" class="tandaTangan">
        <p style="width: 50%; float: left; text-align:center; margin-bottom: 1px;"></p>
        <p style="width: 50%; float: right;text-align:center; margin-bottom: 1px;">Bondowoso, <?= $hariLap . ' ' . $bulanLap[$bulan] . ' ' . $tahunLap ?></p>
        <div style="clear: both;"></div>
        <p style="width: 50%; float: left; text-align:center; margin-bottom: 1px;">Mengetahui/Menyetujui</p>
        <p style="width: 50%; float: right;text-align:center; margin-bottom: 1px;">Dibuat Oleh :</p>
        <div style="clear: both;"></div>
        <p style="width: 50%; float: left; text-align:center;">Manager AMDK</p>
        <p style="width: 50%; float: right;text-align:center;">Petugas Barang Produksi</p>
        <div style="clear: both; margin-bottom:30px;"></div>
        <u style="width: 50%; float: left; text-align:center; margin-bottom: 1px;"><?= $manager->nama_karyawan; ?></u>
        <u style="width: 50%; float: right;text-align:center; margin-bottom: 1px;"><?= $produksi->nama_karyawan; ?></u>
        <div style="clear: both;"></div>
        <p style="width: 50%; float: left; text-align:center;">NIK <?= $manager->nik_karyawan; ?></p>
        <p style="width: 50%; float: right;text-align:center;">NIK <?= $produksi->nik_karyawan; ?></p>
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