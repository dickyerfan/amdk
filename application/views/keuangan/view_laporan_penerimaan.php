<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <form id="form_tanggal" action="<?= base_url('keuangan/laporan_penerimaan'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="submit" value="Tampilkan Data" class="neumorphic-button">
                                <input type="date" id="tanggal" name="tanggal" class="form-control" style="margin-left: 10px;">
                            </div>
                        </form>
                        <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('keuangan/laporan_penerimaan/exportpdf') ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
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
                                            <td class="text-center" rowspan="2" style="vertical-align: middle;">Tanggal</td> <!-- Date column -->
                                            <?php foreach ($nama_barang as $jenis) : ?>
                                                <!-- <td class="text-center" colspan="2" style="vertical-align: middle;"><?= $jenis == 'galon kosong' ? 'Non Air' : $jenis; ?></td> -->
                                                <td class="text-center" colspan="2" style="vertical-align: middle;">
                                                    <?php
                                                    switch ($jenis) {
                                                        case 'galon 19l':
                                                            echo 'Galon 19l';
                                                            break;
                                                        case 'gelas 220ml ijen':
                                                            echo '220 Ijen Biru';
                                                            break;
                                                        case 'gelas 220ml genggong':
                                                            echo '220 Genggong';
                                                            break;
                                                        case 'gelas 220ml an nujum':
                                                            echo '220 An Nujum';
                                                            break;
                                                        case 'gelas 220ml syubbanq':
                                                            echo '220 SyubbanQ';
                                                            break;
                                                        case 'gelas 220ml amalis':
                                                            echo '220 Amalis';
                                                            break;
                                                        case 'gelas 220ml ijen merah':
                                                            echo '220 Ijen Merah';
                                                            break;
                                                        case 'botol 330ml ijen':
                                                            echo '330 Ijen';
                                                            break;
                                                        case 'botol 500ml ijen':
                                                            echo '500 Ijen';
                                                            break;
                                                        case 'botol 500ml amalis':
                                                            echo '500 Amalis';
                                                            break;
                                                        case 'botol 1500 ml ijen':
                                                            echo '1500 Ijen';
                                                            break;
                                                        case 'botol 1500 ml amalis':
                                                            echo '1500 Amalis';
                                                            break;
                                                        case 'galon kosong':
                                                            echo 'No Air';
                                                            break;
                                                        default:
                                                            echo $jenis;
                                                            break;
                                                    }
                                                    ?>
                                                </td>
                                            <?php endforeach; ?>
                                            <td class="text-center" rowspan="2" style=" vertical-align: middle;">Jumlah</td>
                                        </tr>
                                        <tr>
                                            <?php foreach ($nama_barang as $jenis) : ?>
                                                <td class="text-center">jml</td>
                                                <td class="text-center">Rupiah</td>
                                            <?php endforeach; ?>
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
                                                $total_jml_barang = 0;
                                                foreach ($nama_barang as $jenis) : ?>
                                                    <td class="text-center">
                                                        <?php
                                                        // Cari nama barang yang cocok di $jml_barang
                                                        $found = false;
                                                        foreach ($jml_barang as $barang) {
                                                            if ($barang['nama_produk'] == $jenis) {
                                                                $found = true;
                                                                if (isset($barang['pemesanan'][$tanggal])) {
                                                                    // echo $barang['pemesanan'][$tanggal];
                                                                    $jumlah_barang = $barang['pemesanan'][$tanggal];
                                                                    echo $jumlah_barang;
                                                                    $total_jml_barang += $jumlah_barang;
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
                                                    <td class="text-end">
                                                        <?php
                                                        // Cari nama barang yang cocok di $lap_terima
                                                        $found = false;
                                                        foreach ($lap_terima as $terima) {
                                                            if ($terima['nama_produk'] == $jenis) {
                                                                $found = true;
                                                                if (isset($terima['pemesanan'][$tanggal])) {
                                                                    // echo $terima['pemesanan'][$tanggal];
                                                                    $penerimaan = $terima['pemesanan'][$tanggal];
                                                                    echo number_format($penerimaan, 0, ',', '.');
                                                                    $total += $penerimaan;
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
                                                <td class="text-end"><?= number_format($total, 0, ',', '.');  ?></td>

                                                <!-- <td class="text-center"><?= $total_jml_barang; ?></td> -->
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td>Jumlah Total</td>
                                            <?php
                                            $total_penerimaaan = 0;
                                            $total_barang = 0;
                                            foreach ($nama_barang as $jenis) : ?>
                                                <td class="text-center">
                                                    <?php
                                                    $totalPerJenis = 0;
                                                    foreach ($dateRange as $tanggal) {
                                                        $totalPerJenisTanggal = 0;
                                                        foreach ($jml_barang as $barang) {
                                                            if ($barang['nama_produk'] == $jenis) {
                                                                if (isset($barang['pemesanan'][$tanggal])) {
                                                                    $jumlah_barang = $barang['pemesanan'][$tanggal];
                                                                    $totalPerJenisTanggal += $jumlah_barang;
                                                                    $total_jml_barang += $jumlah_barang; // Tambahkan ke total semua di sini
                                                                }
                                                            }
                                                        }
                                                        $totalPerJenis += $totalPerJenisTanggal;
                                                    }
                                                    echo $totalPerJenis;
                                                    ?>
                                                </td>
                                                <td class="text-end">
                                                    <?php
                                                    $totalPenerimaan = 0;
                                                    foreach ($dateRange as $tanggal) {
                                                        $totalTerimaPerJenisTanggal = 0;
                                                        foreach ($lap_terima as $terima) {
                                                            if ($terima['nama_produk'] == $jenis) {
                                                                if (isset($terima['pemesanan'][$tanggal])) {
                                                                    $jumlah_terima = $terima['pemesanan'][$tanggal];
                                                                    $totalTerimaPerJenisTanggal += $jumlah_terima;
                                                                    $total_penerimaaan += $jumlah_terima; // Tambahkan ke total semua di sini
                                                                }
                                                            }
                                                        }
                                                        $totalPenerimaan += $totalTerimaPerJenisTanggal;
                                                    }
                                                    echo number_format($totalPenerimaan, 0, ',', '.');
                                                    ?>
                                                </td>
                                            <?php endforeach; ?>

                                            <td class='text-end'><?= number_format($total_penerimaaan, 0, ',', '.'); ?></td>
                                            <!-- <td class='text-center'><?= $total_jml_barang; ?></td> -->
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