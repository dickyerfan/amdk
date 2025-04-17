<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <form id="form_tanggal" action="<?= base_url('keuangan/laporan_total_harian'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="submit" value="Pilih Bulan" class="neumorphic-button">
                                <input type="date" id="tanggal" name="tanggal" class="form-control" style="margin-left: 10px;">
                            </div>
                        </form>
                        <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('keuangan/laporan_total_harian/exportpdf') ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
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
                                <table class="table table-sm table-bordered" style="font-size: 0.9rem;">
                                    <thead>
                                        <tr class="text-center fw-bold">
                                            <td>No</td>
                                            <td>Uraian</td>
                                            <td>Satuan</td>
                                            <td>Beli</td>
                                            <td>Dipakai</td>
                                            <td>keterangan</td>
                                        </tr>
                                        <tr class="text-center fw-bold">
                                            <td colspan="3">Air Produksi</td>
                                            <td>Terima</td>
                                            <td>Di pakai</td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($data_air_produksi_lap as $produksi) :
                                            foreach ($data_air_pakai_lap as $pakai) {
                                            }
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td>Air Produksi</td>
                                                <td class="text-center">liter</td>
                                                <td class="text-center"><?= number_format($produksi->jumlah_air, 0, ',', '.'); ?></td>
                                                <td class="text-center"><?= number_format($pakai->jumlah_liter, 0, ',', '.'); ?></td>
                                                <td></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <thead>
                                        <tr class="text-center fw-bold">
                                            <td colspan="3">Persedian Barang</td>
                                            <td>Terima</td>
                                            <td>Di pakai</td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($data_baku_terima as $row) :
                                            $dipakai = 0;
                                            foreach ($data_baku_pakai as $pakai) {
                                                if ($pakai->id_barang_baku == $row->id_barang_baku) {
                                                    $dipakai += $pakai->total_keluar;
                                                }
                                            }
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><?= $row->nama_barang_baku; ?></td>
                                                <td class="text-center">Dus</td>
                                                <td class="text-center"><?= number_format($row->total_masuk, 0, ',', '.'); ?></td>
                                                <td class="text-center"><?= number_format($dipakai, 0, ',', '.'); ?></td>
                                                <td></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <thead>
                                        <tr class="text-center fw-bold">
                                            <td colspan="3">Barang Produksi</td>
                                            <td>Terima</td>
                                            <td>Terjual</td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $jumlah_total_produksi = 0;
                                        $jumlah_total_dipakai = 0;
                                        foreach ($data_produksi as $row) :
                                            $jumlah_total_produksi += $row->total_produksi;
                                            $dipakai = 0;
                                            foreach ($data_terjual as $terjual) {
                                                if ($terjual->id_jenis_barang == $row->id_jenis_barang) {
                                                    $dipakai += $terjual->total_pesanan;
                                                    $jumlah_total_dipakai += $dipakai;
                                                }
                                            }
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><?= $row->nama_barang_jadi; ?></td>
                                                <td class="text-center">Dus</td>
                                                <td class="text-center"><?= number_format($row->total_produksi, 0, ',', '.'); ?></td>
                                                <td class="text-center"><?= number_format($dipakai, 0, ',', '.'); ?></td>
                                                <td></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr class=" fw-bold">
                                            <td colspan="3" class="text-center">Jumlah</td>
                                            <td class="text-center"><?= number_format($jumlah_total_produksi, 0, ',', '.')  ?></td>
                                            <td class="text-center"><?= number_format($jumlah_total_dipakai, 0, ',', '.')  ?></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                    <thead>
                                        <tr class="text-center fw-bold">
                                            <td colspan="3">Penjualan Produk</td>
                                            <td>Tunai</td>
                                            <td>Piutang</td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $jumlah_total_lunas = 0;
                                        $jumlah_total_piutang = 0;
                                        foreach ($data_lunas as $lunas) :
                                            $jumlah_total_lunas += $lunas->total_lunas;
                                            $piutang = 0;
                                            foreach ($data_piutang as $row) {
                                                if ($row->id_jenis_barang == $lunas->id_jenis_barang) {
                                                    $piutang += $row->total_piutang;
                                                    $jumlah_total_piutang += $piutang;
                                                }
                                            }
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><?= $lunas->nama_produk; ?></td>
                                                <td class="text-center">Dus</td>
                                                <td class="text-center"><?= number_format($lunas->total_lunas, 0, ',', '.'); ?></td>
                                                <td class="text-center"><?= number_format($piutang, 0, ',', '.'); ?></td>
                                                <td></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr class=" fw-bold">
                                            <td colspan="3" class="text-center">Jumlah</td>
                                            <td class="text-center"><?= number_format($jumlah_total_lunas, 0, ',', '.')  ?></td>
                                            <td class="text-center"><?= number_format($jumlah_total_piutang, 0, ',', '.')  ?></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                    <thead>
                                        <tr class="text-center fw-bold">
                                            <td colspan="3">Penerimaan</td>
                                            <td>Bulan lalu</td>
                                            <td>Bulan ini</td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $jumlah_total_penerimaan = 0;
                                        $jumlah_total_penerimaan_lalu = 0;
                                        foreach ($data_penerimaan as $terima) :
                                            $jumlah_total_penerimaan += $terima->total_terima;
                                            $penerimaan_lalu = 0;
                                            foreach ($data_penerimaan_lalu as $lalu) {
                                                if ($lalu->id_produk == $terima->id_jenis_barang) {
                                                    $penerimaan_lalu += $lalu->total_terima_lalu;
                                                    $jumlah_total_penerimaan_lalu += $penerimaan_lalu;
                                                }
                                            }
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><?= $terima->nama_produk; ?></td>
                                                <td class="text-center">Dus</td>
                                                <td class="text-center"><?= number_format($penerimaan_lalu, 0, ',', '.'); ?></td>
                                                <td class="text-center"><?= number_format($terima->total_terima, 0, ',', '.'); ?></td>
                                                <td></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr class="fw-bold">
                                            <td colspan="3" class="text-center">Jumlah</td>
                                            <td class="text-center"><?= number_format($total_penerimaan_lalu, 0, ',', '.');  ?></td>
                                            <td class="text-center"><?= number_format($jumlah_total_penerimaan, 0, ',', '.');  ?></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>