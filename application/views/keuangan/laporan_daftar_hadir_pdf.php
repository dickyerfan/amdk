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
        <p class="fw-bold my-0 text-center"><?= strtoupper($title); ?></p>
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
                                    echo '<p class="my-0 text-center mb-2">Periode : '.$tanggalAwal.' ' . $bulanLap[$bulanAwal] . ' - '.$tanggalAkhir.' ' . $bulanLap[$bulanAkhir] . ' ' . $tahunAwal . '</p>';
                                } else {
                                    // Jika tahun berbeda, tampilkan tahun untuk masing-masing bulan
                                    echo '<p class="my-0 text-center mb-2">Periode : ' .$tanggalAwal.' '. $bulanLap[$bulanAwal] . ' ' . $tahunAwal . ' - '.$tanggalAkhir.' ' . $bulanLap[$bulanAkhir] . ' ' . $tahunAkhir . '</p>';
                                }
                                ?>
    </div>

    <table class="table tableUtama">
    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Nama</th>
                                            <?php
                                            // Menggunakan DatePeriod untuk menghitung jumlah hari dalam rentang tanggal
                                            $dateInterval = new DateInterval('P1D'); // Interval satu hari
                                            $datePeriod = new DatePeriod($start_date, $dateInterval, $end_date->modify('+1 day')); // Tambah satu hari untuk menyertakan tanggal akhir

                                            // Membuat header tanggal
                                            foreach ($datePeriod as $date) {
                                                $tanggal = $date->format('d'); // Ambil hari dari tanggal
                                                echo "<th class='text-center'>{$tanggal}</th>";
                                            }
                                            ?>
                                            <th class="text-center">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($absensi_karyawan as $karyawan) : 
                                            $jumlah_hadir = 0; // Inisialisasi jumlah hadir
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><?= $karyawan['nama_karyawan_produksi'] ?></td>
                                                <?php
                                                // Loop untuk setiap tanggal di rentang yang telah diatur
                                                foreach ($datePeriod as $date) {
                                                    $tanggal = $date->format('Y-m-d'); // Format ke Y-m-d
                                                    $status = isset($karyawan['absen_karyawan_produksi'][$tanggal]) 
                                                            ? $karyawan['absen_karyawan_produksi'][$tanggal] 
                                                            : '0';
                                                    // Tampilkan status hadir
                                                    echo "<td class='text-center'>{$status}</td>";

                                                    // Hitung jumlah hadir
                                                    if ($status === 'Hadir') {
                                                        $jumlah_hadir++;
                                                    }
                                                }
                                                ?>
                                                <td class="text-center"><?= $jumlah_hadir ?></td> <!-- Tampilkan jumlah hadir -->
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td>Jumlah Hadir</td>
                                            <?php
                                            $total_absen_keseluruhan = 0; // Inisialisasi total keseluruhan

                                            // Loop untuk menghitung total kehadiran per hari untuk semua karyawan
                                            foreach ($datePeriod as $date) {
                                                $tanggal = $date->format('Y-m-d');
                                                $total_hadir_harian = 0;

                                                // Loop untuk menghitung jumlah hadir setiap karyawan pada tanggal tertentu
                                                foreach ($absensi_karyawan as $karyawan) {
                                                    if (isset($karyawan['absen_karyawan_produksi'][$tanggal]) && $karyawan['absen_karyawan_produksi'][$tanggal] == '1') {
                                                        $total_hadir_harian += 1; // Tambahkan jika status kehadiran adalah '1'
                                                        $total_absen_keseluruhan += 1; // Tambahkan ke total keseluruhan
                                                    }
                                                }
                                                // Tampilkan total hadir untuk hari tertentu di kolom
                                                echo "<th class='text-center'>{$total_hadir_harian}</th>";
                                            }
                                            
                                            // Tampilkan total keseluruhan
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
                // Membuat header tanggal berdasarkan $datePeriod
                foreach ($datePeriod as $date) {
                    echo "<th class='text-center'>{$date->format('j')}</th>";
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
                                                <td><?= $nama_barang_mapping[$barang['nama_barang_jadi']] ?? $barang['nama_barang_jadi']; ?></td>
                                                <?php
                                                $total_honor = 0;
                                                foreach ($datePeriod as $date) {
                                                    $tanggal = $date->format('Y-m-d');
                                                    $jumlah_honor = isset($barang['barang_jadi'][$tanggal]) ? $barang['barang_jadi'][$tanggal] : '0';
                                                    echo "<td class='text-end'>" . number_format($jumlah_honor, 0, ',', '.') . "</td>";
                                                    // Menghitung total produksi
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
                                            foreach ($datePeriod as $date) {
                                                $tanggal = $date->format('Y-m-d');
                                                $total = 0;

                                                foreach ($data_jenis_barang as $barang) {
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
        <p style="width: 50%; float: right;text-align:center; margin-bottom: 1px;">Dibuat Oleh,</p>
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