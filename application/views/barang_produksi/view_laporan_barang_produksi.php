<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <form action="<?= base_url('barang_produksi/laporan_produksi'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="date" name="tanggal" class="form-control">
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>
                        <div class="navbar-nav ms-2">
                            <a href="<?= base_url('barang_produksi/laporan_produksi/rekap_tahunan') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"> Rekap Tahunan</button></a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('barang_produksi/laporan_produksi/exportpdf') ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
                        </div>
                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
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
                                <table class="table table-sm table-bordered" style="font-size: 0.7rem;">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>