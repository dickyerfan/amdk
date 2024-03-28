<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">

                    <nav class="navbar navbar-light bg-light">
                        <form id="form_tanggal" action="<?= base_url('barang_produksi/karyawan_produksi/honor_karyawan'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="submit" value="Pilih Bulan" class="neumorphic-button">
                                <input type="date" id="tanggal" name="tanggal_honor" class="form-control" style="margin-left: 5px;">
                            </div>
                        </form>
                        <div class="navbar-nav me-2">
                            <a href="<?= base_url('barang_produksi/karyawan_produksi/ekspor_honor_karyawan') ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
                        </div>
                        <!-- <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('barang_produksi/karyawan_produksi/tambah_absen'); ?>">
                                <button class="neumorphic-button float-end">
                                    <i class="fas fa-plus"></i> Input Absen
                                </button>
                            </a>
                        </div> -->
                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div>
                                <p class="my-0 text-center"><?= strtoupper($title) ?></p>
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
                                <p class="mu-0 text-center">Bulan : <?= $bulanLap[$bulan] . ' ' . $tahunLap ?></p>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" style="font-size: 0.8rem;">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>