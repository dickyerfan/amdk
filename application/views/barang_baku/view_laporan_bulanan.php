<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <form id="form_tanggal" action="<?= base_url('barang_baku/laporan_bulanan'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="submit" value="Pilih Bulan" class="neumorphic-button">
                                <input type="date" id="tanggal" name="tanggal" class="form-control" style="margin-left: 5px;">
                            </div>
                        </form>
                        <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('barang_baku/laporan_bulanan/exportpdf') ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
                        </div>
                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center mb-2">
                        <div class="col-lg-6 text-center">
                            <h5><?= strtoupper($title); ?></h5>
                            <?php
                            if (empty($bulan_lap)) {
                                $bulan_lap = date('m');
                                $tahun_lap = date('Y');
                            }

                            $bulan = [
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

                            $bulan_lap = strtr($bulan_lap, $bulan);

                            ?>
                            <h5><?= $bulan_lap . ' ' . $tahun_lap; ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" id="example2" style="font-size: 1rem;">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nama Barang</th>
                                            <th class="text-center">Satuan</th>
                                            <th class="text-center">Stok Awal</th>
                                            <th class="text-center">Barang Masuk</th>
                                            <th class="text-center">Barang Keluar</th>
                                            <th class="text-center">Barang Rusak</th>
                                            <th class="text-center">Stok Akhir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($lap_bulanan as $row) :
                                            $stok_awal = $row->jumlah_stok_awal + $row->jumlah_masuk_kemaren - $row->jumlah_keluar_kemaren - $row->jumlah_rusak_kemaren;
                                            $stok_akhir = $row->jumlah_stok_awal + $row->jumlah_masuk - $row->jumlah_keluar - $row->jumlah_rusak;
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><?= $row->nama_barang_baku; ?></td>
                                                <td><?= $row->satuan; ?></td>
                                                <td class="text-end"><?= number_format($stok_awal, 0, ',', '.'); ?></td>
                                                <td class="text-end"><?= number_format($row->jumlah_masuk_sekarang, 0, ',', '.'); ?></td>
                                                <td class="text-end"><?= number_format($row->jumlah_keluar_sekarang, 0, ',', '.'); ?></td>
                                                <td class="text-end"><?= number_format($row->jumlah_rusak_sekarang, 0, ',', '.'); ?></td>
                                                <td class="text-end"><?= number_format($stok_akhir, 0, ',', '.'); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>