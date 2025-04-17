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
        <hr>
    </div>
    <div class="judul">
        <p class="my-0 text-center fw-bold"><?= strtoupper($title) ?></p>
        <?php
        // Mendapatkan nama bulan untuk tanggal awal dan akhir
        $tanggalAwal = $start_date->format('d');
        $bulanAwal = $start_date->format('m');
        $tahunAwal = $start_date->format('Y');
        $tanggalAkhir = $end_date->format('d');
        $bulanAkhir = $end_date->format('m');
        $tahunAkhir = $end_date->format('Y');

        // Daftar bulan
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

        // Menampilkan periode
        if ($tahunAwal === $tahunAkhir) {
            // Jika tahun sama, hanya tampilkan tahun sekali
            echo '<p class="my-0 text-center">Periode : ' . $tanggalAwal . ' ' . $bulanLap[$bulanAwal] . ' - ' . $tanggalAkhir . ' ' . $bulanLap[$bulanAkhir] . ' ' . $tahunAwal . '</p>';
        } else {
            // Jika tahun berbeda, tampilkan tahun untuk masing-masing bulan
            echo '<p class="my-0 text-center">Periode : ' . $tanggalAwal . ' ' . $bulanLap[$bulanAwal] . ' ' . $tahunAwal . ' - ' . $tanggalAkhir . ' ' . $bulanLap[$bulanAkhir] . ' ' . $tahunAkhir . '</p>';
        }
        ?>
    </div>
    <table class="table tableUtama">
        <thead>
            <tr class="bg-secondary text-center">
                <th>No</th>
                <th>Hari</th>
                <th>Tanggal Ambil</th>
                <th>Nama Petugas</th>
                <th>Jam</th>
                <th>Stand Meter</th>
                <th>BBM</th>
                <th>Ket</th>
            </tr>
        </thead>
        <tbody>
            <?php
            function ganti_hari($day)
            {
                $days = array(
                    'Sunday' => 'Minggu',
                    'Monday' => 'Senin',
                    'Tuesday' => 'Selasa',
                    'Wednesday' => 'Rabu',
                    'Thursday' => 'Kamis',
                    'Friday' => 'Jumat',
                    'Saturday' => 'Sabtu'
                );

                return $days[$day];
            }
            $no = 1;
            foreach ($ambil_air as $row) :
                setlocale(LC_TIME, 'id_ID');
                $tanggal_hari_ini = strftime('%e %B %Y', strtotime($row->tanggal_ambil_air));
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

                $hari = date('l', strtotime($row->tanggal_ambil_air));
                $hari_indo = ganti_hari($hari);

            ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td class="text-center"><?= $hari_indo; ?></td>
                    <td><?= $tanggal_hari_ini; ?></td>
                    <td><?= $row->nama_karyawan; ?></td>
                    <td class="text-center"><?= $row->waktu; ?></td>
                    <td class="text-center"><?= $row->stand_meter; ?></td>
                    <td class="text-center"><?= number_format($row->bbm, 0, ',', '.'); ?></td>
                    <td class="text-center"><?= $row->ket == true ? $row->ket . ' liter' : ''; ?></td>
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
    </div>

    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>