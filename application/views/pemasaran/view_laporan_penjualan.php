<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <form action="<?= base_url('pemasaran/laporan_penjualan'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="date" name="tanggal" class="form-control">
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>
                        <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('pemasaran/laporan_penjualan/exportpdf') ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
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
                                            <td style="vertical-align: middle;">No</td>
                                            <td class="text-center" style="vertical-align: middle;">Tanggal</td> <!-- Date column -->
                                            <?php foreach ($nama_barang as $jenis) : ?>
                                                <td class="text-center"><?= $jenis; ?></td>
                                            <?php endforeach; ?>
                                            <td class="text-center" style="vertical-align: middle;">Jumlah</td>
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
                                                $total = 0;
                                                foreach ($nama_barang as $jenis) : ?>
                                                    <td class="text-center">
                                                        <?php
                                                        // Cari nama barang yang cocok di $penjualan
                                                        $found = false;
                                                        foreach ($penjualan as $barang) {
                                                            if ($barang['nama_produk'] == $jenis) {
                                                                $found = true;
                                                                if (isset($barang['pemesanan'][$tanggal])) {
                                                                    // echo $barang['pemesanan'][$tanggal];
                                                                    $jumlah_barang = $barang['pemesanan'][$tanggal];
                                                                    echo $jumlah_barang;
                                                                    $total += $jumlah_barang;
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
                                                <td class="text-center"><?= $total ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td>Jumlah Total</td>
                                            <?php
                                            $totalSemua = 0;
                                            foreach ($nama_barang as $jenis) : ?>
                                                <td class="text-center">
                                                    <?php
                                                    $totalPerJenis = 0;
                                                    foreach ($dateRange as $tanggal) {
                                                        $totalPerJenisTanggal = 0;
                                                        foreach ($penjualan as $barang) {
                                                            if ($barang['nama_produk'] == $jenis) {
                                                                if (isset($barang['pemesanan'][$tanggal])) {
                                                                    $jumlah_barang = $barang['pemesanan'][$tanggal];
                                                                    $totalPerJenisTanggal += $jumlah_barang;
                                                                    $totalSemua += $jumlah_barang; // Tambahkan ke total semua di sini
                                                                }
                                                            }
                                                        }
                                                        $totalPerJenis += $totalPerJenisTanggal;
                                                    }
                                                    echo $totalPerJenis;
                                                    ?>
                                                </td>
                                            <?php endforeach; ?>
                                            <td class='text-center'><?= $totalSemua ?></td>
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