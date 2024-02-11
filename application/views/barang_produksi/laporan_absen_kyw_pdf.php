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
            font-size: 0.6rem;
            padding: 1.5px 3px;
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

        $tanggal = $this->session->userdata('tanggal');
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
                <th>Nama Karyawan</th>
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
            $no = 1;
            foreach ($absensi_karyawan as $karyawan) : ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= $karyawan['nama_karyawan_produksi']; ?></td>
                    <?php
                    $total_hadir = 0;
                    foreach (range(1, $jumlah_hari) as $i) {
                        $tanggal = sprintf('%04d-%02d-%02d', $tahun, $bulan, $i);
                        $absensi_status = isset($karyawan['absen_karyawan_produksi'][$tanggal]) ? $karyawan['absen_karyawan_produksi'][$tanggal] : '0';
                        echo "<td class='text-center'>{$absensi_status}</td>";
                        // Menghitung total hadir
                        if ($absensi_status == '1') {
                            $total_hadir++;
                        }
                    }
                    ?>
                    <th class="text-center"><?= $total_hadir; ?></th>
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
                <th class='text-center'><?= $total_absen_keseluruhan ?></th>
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
            $no = 1;
            foreach ($data_jenis_barang as $barang) : ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= $barang['nama_barang_jadi']; ?></td>
                    <?php
                    $total_barang = 0;
                    foreach (range(1, $jumlah_hari) as $i) {
                        $tanggal = sprintf('%04d-%02d-%02d', $tahun, $bulan, $i);
                        $jumlah_barang = isset($barang['barang_jadi'][$tanggal]) ? $barang['barang_jadi'][$tanggal] : '0';
                        echo "<td class='text-center'>" . number_format($jumlah_barang, 0, ',', '.') . "</td>";
                        // Menghitung total hadir
                        if ($jumlah_barang) {
                            $total_barang += $jumlah_barang;
                        }
                    }
                    ?>
                    <th class="text-center"><?= number_format($total_barang, 0, ',', '.'); ?></th>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td>Jumlah Total</td>
                <?php
                $total_barang_keseluruhan = 0;
                foreach (range(1, $jumlah_hari) as $i) {
                    $total = 0;
                    foreach ($data_jenis_barang as $barang) {
                        $tanggal = sprintf('%04d-%02d-%02d', $tahun, $bulan, $i);
                        if (isset($barang['barang_jadi'][$tanggal])) {
                            $total += $barang['barang_jadi'][$tanggal];
                            $total_barang_keseluruhan += $barang['barang_jadi'][$tanggal];
                        }
                    }
                    echo "<th class='text-center'>" . number_format($total, 0, ',', '.') . "</th>";
                }
                ?>
                <th class='text-center'><?= number_format($total_barang_keseluruhan, 0, ',', '.'); ?></th>
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

    $nik_produksi = $produksi->nik_karyawan;
    if ($nik_produksi) {
        $nik_produksi = sprintf('%03s %02s %03s', substr($nik_produksi, 0, 3), substr($nik_produksi, 3, 2), substr($nik_produksi, 5));
    } else {
        $nik_produksi = '';
    }
    ?>

    <div style="font-size: 0.8rem;">
        <p style="width: 50%; float: left; text-align:center; margin-bottom: 1px;">Mengetahui</p>
        <p style="width: 50%; float: right;text-align:center; margin-bottom: 1px;">Dibuat Oleh :</p>
        <div style="clear: both;"></div>
        <p style="width: 50%; float: left; text-align:center;">Manager AMDK</p>
        <p style="width: 50%; float: right;text-align:center;">Bagian Produksi</p>
        <div style="clear: both; margin-bottom:40px;"></div>
        <u style="width: 50%; float: left; text-align:center; margin-bottom: 1px;"><?= strtoupper($manager->nama_karyawan); ?></u>
        <u style="width: 50%; float: right;text-align:center; margin-bottom: 1px;"><?= strtoupper($produksi->nama_karyawan); ?></u>
        <div style="clear: both;"></div>
        <p style="width: 50%; float: left; text-align:center;">NIK. <?= $nik_manager; ?></p>
        <p style="width: 50%; float: right;text-align:center;">NIK. <?= $nik_produksi; ?></p>
        <div style="clear: both;"></div>
    </div>

    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>