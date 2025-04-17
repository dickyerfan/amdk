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
            font-size: 0.8rem;
            padding: 10px 1px;
        }

        .judul p {

            margin-bottom: 5px;
            font-size: 0.9rem;
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
        <!-- <?php
        if (empty($tanggal)) {
            $bulan = date('m');
            $tahun = date('Y');
        } 
        ?> -->
    </div>

    <table class="table tableUtama">
    <thead>
        <tr>
         <th class="text-center">No</th>
         <th class="text-center">Nama</th>
                <?php
                 $dateInterval = new DateInterval('P1D'); // Interval satu hari
                 $datePeriod = new DatePeriod($start_date, $dateInterval, $end_date->modify('+1 day'));
                ?>
        <th class="text-center">Jumlah (Rp)</th>
        <th class="text-center">Pph (Rp)</th>
        <th class="text-center">Terima (Rp)</th>
        <th class="text-center">Tanda Tangan Karyawan</th>
        </tr>
    </thead>
                                    <tbody>
                                        <?php
                                        // Kode untuk mendapatkan jumlah total rupiah per hari
                                        $total_honor_keseluruhan = [];
                                        
                                        // Menggunakan DatePeriod untuk menghitung total honor per hari berdasarkan rentang tanggal
                                        foreach ($datePeriod as $date) {
                                            $tanggal = $date->format('Y-m-d'); // Format tanggal
                                            $total = 0;
                                            foreach ($data_jenis_barang as $barang) {
                                                if (isset($barang['barang_jadi'][$tanggal])) {
                                                    $total += $barang['barang_jadi'][$tanggal];
                                                }
                                            }
                                            $total_honor_keseluruhan[$tanggal] = $total; // Simpan total per tanggal
                                        }

                                        $total_per_tanggal = []; // Tambah baris ini untuk menyimpan nilai total per tanggal

                                        // Menggunakan DatePeriod untuk menghitung total kehadiran per hari
                                        foreach ($datePeriod as $date) {
                                            $tanggal = $date->format('Y-m-d'); // Format tanggal
                                            $total = 0;
                                            foreach ($absensi_karyawan as $karyawan) {
                                                if (isset($karyawan['absen_karyawan_produksi'][$tanggal]) && $karyawan['absen_karyawan_produksi'][$tanggal] == '1') {
                                                    $total += 1; // Hitung kehadiran
                                                }
                                            }
                                            $total_per_tanggal[$tanggal] = $total; // Simpan total per tanggal
                                        }

                                        $no = 1;
                                        $ttd = 1;
                                        foreach ($absensi_karyawan as $karyawan) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no++; ?></td>
                                                <td><?= $karyawan['nama_karyawan_produksi']; ?></td>
                                                <?php
                                                $total_honor = 0;
                                                foreach ($datePeriod as $date) {
                                                    $tanggal = $date->format('Y-m-d'); // Format tanggal
                                                    $honor = 0;

                                                    // Cek apakah total per tanggal ada dan tidak sama dengan 0 sebelum melakukan pembagian
                                                    if (isset($total_per_tanggal[$tanggal]) && $total_per_tanggal[$tanggal] != 0) {

                                                        $honor = $total_honor_keseluruhan[$tanggal] / $total_per_tanggal[$tanggal];
                                                    }
                                                    $absensi_status = isset($karyawan['absen_karyawan_produksi'][$tanggal]) ? $honor : '0';
                                                    $total_honor += round($absensi_status); // Akumulasi total honor
                                                }
                                                ?>
                                                <td class="text-end"><?= number_format($total_honor, 0, ',', '.'); ?></td>
                                                <td></td>
                                                <th class="text-end"><?= number_format($total_honor, 0, ',', '.'); ?></th>
                                                <td class="<?= ($ttd % 2 == 0) ? 'text-center' : 'ps-2'; ?>">
                                                    <?= $ttd++;?>.
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td>Jumlah</td>
                                            <?php
                                            $total_absen_keseluruhan = 0;
                                            
                                            // Menggunakan DatePeriod untuk menghitung total kehadiran
                                            foreach ($datePeriod as $date) {
                                                $tanggal = $date->format('Y-m-d'); // Format tanggal
                                                $total = 0;
                                                foreach ($absensi_karyawan as $karyawan) {
                                                    if (isset($karyawan['absen_karyawan_produksi'][$tanggal]) && $karyawan['absen_karyawan_produksi'][$tanggal] == '1') {
                                                        $total++; // Hitung kehadiran
                                                    }
                                                }
                                                $total_absen_keseluruhan += $total; // Akumulasi total kehadiran
                                            }
                                            ?>
                                            <?php
                                            $total_honor_keseluruhan = 0;
                                            // Menggunakan DatePeriod untuk menghitung total honor
                                            foreach ($datePeriod as $date) {
                                                $tanggal = $date->format('Y-m-d'); // Format tanggal
                                                foreach ($data_jenis_barang as $barang) {
                                                    if (isset($barang['barang_jadi'][$tanggal])) {
                                                        $total_honor_keseluruhan += $barang['barang_jadi'][$tanggal]; // Akumulasi total honor
                                                    }
                                                }
                                            }
                                            ?>
                                            <td class='text-end'><?= number_format($total_honor_keseluruhan, 0, ',', '.'); ?></td>
                                            <td></td>
                                            <th class='text-end'><?= number_format($total_honor_keseluruhan, 0, ',', '.'); ?></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
    </table>

    <?php
    $nik_direktur = $direktur->nik_karyawan;
    if ($nik_direktur) {
        $nik_direktur =  sprintf('%03s %02s %03s', substr($nik_direktur, 0, 3), substr($nik_direktur, 3, 2), substr($nik_direktur, 5));
    } else {
        $nik_direktur = '';
    }
    $nik_kabag = $kabag->nik_karyawan;
    if ($nik_kabag) {
        $nik_kabag =  sprintf('%03s %02s %03s', substr($nik_kabag, 0, 3), substr($nik_kabag, 3, 2), substr($nik_kabag, 5));
    } else {
        $nik_kabag = '';
    }
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
        <p style="width: 50%; float: left; text-align:center; margin-bottom: 1px;">Diperiksa Oleh,</p>
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
        <p style="width: 100%; float: left; text-align:center; margin-bottom: 2px;">Menyetujui</p>
        <div style="clear: both;"></div>
        <p style="width: 50%; float: left; text-align:center; margin-bottom: 1px;">Direktur</p>
        <p style="width: 50%; float: right;text-align:center; margin-bottom: 1px;">Kabag Keuangan</p>
        <div style="clear: both;"></div>
        <p style="width: 50%; float: left; text-align:center; margin-bottom: 1px;">PDAM Kab. Bondowoso</p>
        <div style="clear: both; margin-bottom:50px;"></div>
        <u style="width: 50%; float: left; text-align:center; margin-bottom: 1px;"><?= strtoupper($direktur->nama_karyawan); ?></u>
        <u style="width: 50%; float: right;text-align:center; margin-bottom: 1px;"><?= strtoupper($kabag->nama_karyawan); ?></u>
        <div style="clear: both;"></div>
        <p style="width: 50%; float: right;text-align:center;">NIK. <?= $nik_kabag; ?></p>
        <div style="clear: both;"></div>
    </div>

    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>