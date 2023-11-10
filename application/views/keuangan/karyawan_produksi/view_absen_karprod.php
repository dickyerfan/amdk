<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">

                    <nav class="navbar navbar-light bg-light">
                        <form action="<?= base_url('keuangan/karyawan_produksi/absensi_karyawan'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="date" name="tanggal" class="form-control">
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>
                        <div class="navbar-nav me-2">
                            <a href="#" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('keuangan/karyawan_produksi/tambah_absen'); ?>">
                                <button class="neumorphic-button float-end">
                                    <i class="fas fa-plus"></i> Input Absen
                                </button>
                            </a>
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
                            <div>
                                <p class="my-0 text-center"><?= strtoupper($title) ?></p>
                                <?php
                                $tanggal = $this->input->get('tanggal');
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
                                                    echo "<td class='text-center'>{$jumlah_barang}</td>";
                                                    // Menghitung total hadir
                                                    if ($jumlah_barang) {
                                                        $total_barang += $jumlah_barang;
                                                    }
                                                }
                                                ?>
                                                <th class="text-center"><?= $total_barang; ?></th>
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
                                                echo "<th class='text-center'>{$total}</th>";
                                            }
                                            ?>
                                            <th class='text-center'><?= $total_barang_keseluruhan ?></th>
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