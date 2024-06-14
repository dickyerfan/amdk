<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <form id="form_bulan" action="<?= base_url('keuangan/daftar_penjualan'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="submit" value="pilih bulan & Tahun" class="neumorphic-button">
                                <input type="month" name="bulan" id="bulan" class="form-control" style="margin-left: 5px;">
                            </div>
                        </form>
                        <!-- <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('keuangan/daftar_penjualan/exportpdf') ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
                        </div> -->
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
                                $tanggal = $this->input->get('bulan');
                                if (empty($tanggal)) {
                                    $bulan = date('m');
                                    $tahun = date('Y');
                                    $bulanLap = date('m');
                                    $tahunLap = date('Y');
                                } else {
                                    list($tahun, $bulan) = explode('-', $tanggal);
                                    list($tahunLap, $bulanLap) = explode('-', $tanggal);
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
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" id="example" style="font-size: 0.7rem;">
                                    <thead>
                                        <tr>
                                            <th style="vertical-align: middle;">No</th>
                                            <th class="text-center" style="vertical-align: middle;">Nama Pelanggan</th>
                                            <?php foreach ($nama_barang as $jenis) : ?>
                                                <th class="text-center"><?= $jenis; ?></th>
                                            <?php endforeach; ?>
                                            <th class="text-center" style="vertical-align: middle;">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($penjualan as $id_pelanggan => $pelanggan) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <!-- <td><?= $pelanggan['nama_pelanggan'] ?></td> -->
                                                <td>
                                                    <a href="<?= base_url('keuangan/daftar_penjualan/detail_penjualan/' . $id_pelanggan) ?>" style="text-decoration: none; color:black;"><?= $pelanggan['nama_pelanggan'] ?>
                                                    </a>
                                                </td>
                                                <?php
                                                $total = 0;
                                                foreach ($nama_barang as $id_jenis_barang => $jenis) : ?>
                                                    <td class="text-center">
                                                        <?php
                                                        $jumlah_barang = isset($penjualan[$id_pelanggan]['produk'][$id_jenis_barang]) ? $penjualan[$id_pelanggan]['produk'][$id_jenis_barang] : 0;
                                                        echo number_format($jumlah_barang, 0, ',', '.');
                                                        $total += $jumlah_barang;
                                                        ?>
                                                    </td>
                                                <?php endforeach; ?>
                                                <!-- <td class="text-center"><?= number_format($total, 0, ',', '.');  ?></td> -->
                                                <td class="text-center"><?= $total;  ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td>Jumlah Total</td>
                                            <?php
                                            $totalSemua = 0;
                                            foreach ($nama_barang as $id_jenis_barang => $jenis) : ?>
                                                <td class="text-center">
                                                    <?php
                                                    $totalPerJenis = 0;
                                                    foreach ($penjualan as $id_pelanggan => $pelanggan) {
                                                        if (isset($pelanggan['produk'][$id_jenis_barang])) {
                                                            $totalPerJenis += $pelanggan['produk'][$id_jenis_barang];
                                                        }
                                                    }
                                                    $totalSemua += $totalPerJenis;
                                                    echo number_format($totalPerJenis, 0, ',', '.');
                                                    ?>
                                                </td>
                                            <?php endforeach; ?>
                                            <td class='text-center'><?= number_format($totalSemua, 0, ',', '.');  ?></td>
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