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
            font-size: 0.5rem;
            padding: 1.5px 1px;
        }

        .judul p {

            margin-bottom: 5px;
            font-size: 0.7rem;
        }
    </style>

</head>

<body>
    <div class="judul">
        <p class="fw-bold my-0 text-center"><?= strtoupper($title); ?></p>
        <?php
        if (empty($bulan_lap)) {
            $bulan_lap = date('m');
            $tahun_lap = date('Y');
        }

        $bulanJudul = [
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

        $bulan_lap = strtr($bulan_lap, $bulanJudul);

        $tanggal = $this->session->userdata('tanggal_honor');
        if (empty($tanggal)) {
            $bulan = date('m');
            $tahun = date('Y');
            $bulanLap = date('m');
            $tahunLap = date('Y');
        } else {
            list($tahun, $bulan, $hari) = explode('-', $tanggal);
            list($tahunLap, $bulanLap, $hariLap) = explode('-', $tanggal);
            $bulan = str_pad($bulan, 2, '0', STR_PAD_LEFT);
        }
        ?>
        <p class="mu-0 text-center">Bulan : <?= $bulan_lap . ' ' . $tahun_lap; ?></p>
    </div>

    <table class="table tableUtama">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Nama</th>
                <?php
                // Hitung jumlah hari dalam bulan dan tahun yang dipilih
                $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

                // Membuat header tanggal
                for ($i = 1; $i <= $jumlah_hari; $i++) {
                    echo "<th class='text-center'>{$i}</th>";
                }
                ?>
                <th class="text-center">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // kode untuk mendapatkan jumlah total rupiah perhari
            $total_honor_keseluruhan = [];
            foreach (range(1, $jumlah_hari) as $i) {
                $total = 0;
                foreach ($data_jenis_barang as $barang) {
                    $tanggal = sprintf('%04d-%02d-%02d', $tahun, $bulan, $i);
                    if (isset($barang['barang_jadi'][$tanggal])) {
                        $total += $barang['barang_jadi'][$tanggal];
                    }
                }
                $total_honor_keseluruhan[$i] = $total;
            }
            // kode untuk mendapatkan jumlah karyawan yang masuk perhari
            $total_per_tanggal = []; // Tambah baris ini untuk menyimpan nilai total per tanggal
            foreach (range(1, $jumlah_hari) as $i) {
                $total = 0;
                foreach ($absensi_karyawan as $karyawan) {
                    $tanggal = sprintf('%04d-%02d-%02d', $tahun, $bulan, $i);
                    if (isset($karyawan['absen_karyawan_produksi'][$tanggal]) && $karyawan['absen_karyawan_produksi'][$tanggal] == '1') {
                        $total += $karyawan['absen_karyawan_produksi'][$tanggal];
                    }
                }
                $total_per_tanggal[$i] = $total;
            }
            $no = 1;
            foreach ($absensi_karyawan as $karyawan) : ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= $karyawan['nama_karyawan_produksi']; ?></td>
                    <?php
                    $total_hadir = 0;
                    $total_honor = 0;
                    foreach (range(1, $jumlah_hari) as $i) {
                        $tanggal = sprintf('%04d-%02d-%02d', $tahun, $bulan, $i);
                        $honor = 0;
                        if (isset($total_per_tanggal[$i]) && $total_per_tanggal[$i] != 0) {
                            $honor = $total_honor_keseluruhan[$i] / $total_per_tanggal[$i];
                        }
                        $absensi_status = isset($karyawan['absen_karyawan_produksi'][$tanggal]) ? $honor : '0';
                        $honor_karProd = round($absensi_status);
                        $total_honor += round($absensi_status);
                        echo "<td class='text-end'>" . number_format($honor_karProd, 0, ',', '.') . "</td>";
                    }
                    ?>
                    <th class="text-end"><?= number_format($total_honor, 0, ',', '.'); ?></th>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td>Jumlah Hadir</td>
                <?php
                $total_absen_keseluruhan = 0;
                foreach (range(1, $jumlah_hari) as $i) {
                    $total = 0;
                    foreach ($absensi_karyawan as $karyawan) {
                        $tanggal = sprintf('%04d-%02d-%02d', $tahun, $bulan, $i);
                        if (isset($karyawan['absen_karyawan_produksi'][$tanggal]) && $karyawan['absen_karyawan_produksi'][$tanggal] == '1') {
                            // $total++;
                            $total += $karyawan['absen_karyawan_produksi'][$tanggal];
                            $total_absen_keseluruhan += $karyawan['absen_karyawan_produksi'][$tanggal];
                        }
                    }
                    echo "<th class='text-center'>{$total}</th>";
                }
                ?>
                <?php
                $total_honor_keseluruhan = 0;
                foreach (range(1, $jumlah_hari) as $i) {
                    $total = 0;
                    foreach ($data_jenis_barang as $barang) {
                        $tanggal = sprintf('%04d-%02d-%02d', $tahun, $bulan, $i);
                        if (isset($barang['barang_jadi'][$tanggal])) {
                            $total += $barang['barang_jadi'][$tanggal];
                            $total_honor_keseluruhan += $barang['barang_jadi'][$tanggal];
                        }
                    }
                }
                ?>
                <th class='text-end'><?= number_format($total_honor_keseluruhan, 0, ',', '.'); ?></th>
            </tr>
        </tfoot>
    </table>
    <table class="table tableUtama">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Nama Barang</th>
                <?php

                // Hitung jumlah hari dalam bulan dan tahun yang dipilih
                $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

                // Membuat header tanggal
                for ($i = 1; $i <= $jumlah_hari; $i++) {
                    echo "<th class='text-center'>{$i}</th>";
                }
                ?>
                <th class="text-center">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $nama_barang_mapping = [
                'galon 19l' => 'Galon',
                'gelas 220ml ijen' => 'Ijen 220',
                'gelas 220ml genggong' => 'Genggong 220',
                'gelas 220ml an nujum' => 'An Nujum 220',
                'gelas 220ml syubbanq' => 'SyubbanQ 220',
                'gelas 220ml amalis' => 'Amalis 220',
                'gelas 220ml ijen merah' => 'Ijen Mrh 220',
                'botol 330ml ijen' => 'Ijen 330',
                'botol 500ml ijen' => 'Ijen 500',
                'botol 500ml amalis' => 'Amalis 500',
                'botol 1500ml ijen' => 'Ijen 1500',
                'botol 1500ml amalis' => 'Amalis 1500'

            ];

            $no = 1;
            foreach ($data_jenis_barang as $barang) : ?>

                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <!-- <td><?= $barang['nama_barang_jadi']; ?></td> -->
                    <td><?= $nama_barang_mapping[$barang['nama_barang_jadi']] ?? $barang['nama_barang_jadi']; ?></td>
                    <?php
                    $total_honor = 0;
                    foreach (range(1, $jumlah_hari) as $i) {
                        $tanggal = sprintf('%04d-%02d-%02d', $tahun, $bulan, $i);
                        $jumlah_honor = isset($barang['barang_jadi'][$tanggal]) ? $barang['barang_jadi'][$tanggal] : '0';
                        echo "<td class='text-end'>" . number_format($jumlah_honor, 0, ',', '.') . "</td>";
                        // Menghitung total hadir
                        if ($jumlah_honor) {
                            $total_honor += $jumlah_honor;
                        }
                    }
                    ?>
                    <th class="text-end"><?= number_format($total_honor, 0, ',', '.'); ?></th>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td class="fw-bold">Jumlah Total</td>
                <?php
                $total_honor_keseluruhan = 0;
                foreach (range(1, $jumlah_hari) as $i) {
                    $total = 0;
                    foreach ($data_jenis_barang as $barang) {
                        $tanggal = sprintf('%04d-%02d-%02d', $tahun, $bulan, $i);
                        if (isset($barang['barang_jadi'][$tanggal])) {
                            $total += $barang['barang_jadi'][$tanggal];
                            $total_honor_keseluruhan += $barang['barang_jadi'][$tanggal];
                        }
                    }
                    echo "<td class='text-end fw-bold'>" . number_format($total, 0, ',', '.') . "</td>";
                }
                ?>
                <td class='text-end fw-bold'><?= number_format($total_honor_keseluruhan, 0, ',', '.'); ?></td>
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