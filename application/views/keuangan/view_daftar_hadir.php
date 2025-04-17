<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <form id="form_tanggal" action="<?= base_url('keuangan/daftar_gaji_produksi/daftar_hadir'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="submit" value="Pilih Tanggal" class="neumorphic-button">
                                
                                <!-- Input untuk tanggal mulai -->
                                <label for="tanggal_mulai" style="margin-left: 10px;">Dari:</label>
                                <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="form-control" style="margin-left: 5px;">
                                
                                <!-- Input untuk tanggal selesai -->
                                <label for="tanggal_selesai" style="margin-left: 10px;">Sampai:</label>
                                <input type="date" id="tanggal_selesai" name="tanggal_selesai" class="form-control" style="margin-left: 5px;">
                            </div>
                        </form>
                        <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('keuangan/daftar_gaji_produksi') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                        </div>
                        <div class="navbar-nav ms-2">
                            <a href="<?= base_url('keuangan/daftar_gaji_produksi/ekspor_daftar_hadir') ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
                        </div>
                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- <div>
                                <p class="my-0 text-center fw-bold"><?= strtoupper($title) ?></p>
                                <?php
                                $tanggal = $this->input->get('tanggal_honor');
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
                                <p class="mu-0 text-center">Periode : <?= $bulanLap[$bulan] . ' ' . $tahunLap ?></p>
                            </div> -->
                            <div>
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
                                    echo '<p class="my-0 text-center">Periode : '.$tanggalAwal.' ' . $bulanLap[$bulanAwal] . ' - '.$tanggalAkhir.' ' . $bulanLap[$bulanAkhir] . ' ' . $tahunAwal . '</p>';
                                } else {
                                    // Jika tahun berbeda, tampilkan tahun untuk masing-masing bulan
                                    echo '<p class="my-0 text-center">Periode : ' .$tanggalAwal.' '. $bulanLap[$bulanAwal] . ' ' . $tahunAwal . ' - '.$tanggalAkhir.' ' . $bulanLap[$bulanAkhir] . ' ' . $tahunAkhir . '</p>';
                                }
                                ?>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" style="font-size: 0.8rem;">
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
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <p>Total Hasil Produksi</p>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" style="font-size: 0.8rem;">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>