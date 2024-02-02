<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <form action="<?= base_url('keuangan/laporan_pemakaian_air'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="date" name="tanggal" class="form-control">
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>
                        <div class="navbar-nav">
                            <a href="<?= base_url('keuangan/pengambilan_air/exportpdf') ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
                        </div>
                        <!-- <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('keuangan/pengambilan_air/tambah'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-plus"></i> Pengambilan air</button></a>
                        </div> -->
                    </nav>

                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
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
                        <table id="example2" class="table table-hover table-striped table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 0.8rem;">
                            <thead>
                                <tr class="bg-secondary text-center">
                                    <th>Tanggal</th>
                                    <th>Satuan</th>
                                    <th>Pembelian Air</th>
                                    <th>Pemakaian Air</th>
                                    <th>Air Terbuang</th>
                                    <th>Sisa Air</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-bold">Sisa Bulan Lalu</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-end"><?= number_format(94349, 2, ',', '.') ?></td>
                                </tr>
                                <?php
                                foreach ($dateRange as $tanggal) : ?>
                                    <tr>
                                        <td class="text-center"><?= date('d-m-Y', strtotime($tanggal)) ?></td>
                                        <td class="text-center">Liter</td>
                                        <?php
                                        $total_pembelian_air = 0;
                                        $tanggal_ditemukan = false;

                                        foreach ($ambil_air as $row) : ?>
                                            <?php if (date('Y-m-d', strtotime($row->tanggal_ambil_air)) == $tanggal) : ?>
                                                <td class="text-center"><?= number_format($row->jumlah_air, 0, ',', '.'); ?></td>
                                                <?php $total_pembelian_air += $row->jumlah_air; ?>
                                                <?php $tanggal_ditemukan = true; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>

                                        <?php if (!$tanggal_ditemukan) : ?>
                                            <!-- Jika tanggal tidak ditemukan, isi kolom pembelian air dengan 0 -->
                                            <td class="text-center">0</td>
                                        <?php endif; ?>

                                        <?php
                                        $total_produksi_air = 0;
                                        $tanggal_ditemukan = false;

                                        foreach ($produksi_air as $row) : ?>
                                            <?php if (date('Y-m-d', strtotime($row->tanggal_barang_jadi)) == $tanggal) : ?>
                                                <td class="text-center"><?= number_format(round($row->jumlah_liter, 2), 2, ',', '.'); ?></td>
                                                <?php $tanggal_ditemukan = true; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>

                                        <?php if (!$tanggal_ditemukan) : ?>
                                            <!-- Jika tanggal tidak ditemukan, isi kolom pembelian air dengan 0 -->
                                            <td class="text-center">0</td>
                                        <?php endif; ?>
                                        <td></td>
                                        <!-- <td class="text-end"><?= $total_pembelian_air; ?></td> -->
                                        <td class="text-end"></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="fw-bold">Jumlah Bulan ini</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="fw-bold">Liter</td>
                                    <?php
                                    $total_pembelian_bulan_ini = 0;
                                    $total_pemakaian_air = 0;
                                    $total_air_terbuang = 0;
                                    $total_sisa_air = 0;

                                    foreach ($dateRange as $tanggal) : ?>
                                        <?php
                                        $tanggal_ditemukan = false;

                                        foreach ($ambil_air as $row) : ?>
                                            <?php if (date('Y-m-d', strtotime($row->tanggal_ambil_air)) == $tanggal) : ?>
                                                <?php $total_pembelian_bulan_ini += $row->jumlah_air; ?>
                                                <?php $tanggal_ditemukan = true; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>

                                        <?php
                                        $tanggal_ditemukan_produksi = false;

                                        foreach ($produksi_air as $row) : ?>
                                            <?php if (date('Y-m-d', strtotime($row->tanggal_barang_jadi)) == $tanggal) : ?>
                                                <?php $total_pemakaian_air += round($row->jumlah_liter, 2); ?>
                                                <?php $tanggal_ditemukan_produksi = true; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>

                                        <?php if (!$tanggal_ditemukan_produksi) : ?>
                                            <?php $total_pemakaian_air += 0; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <?php
                                    $total_pembelian = $total_pembelian_bulan_ini;
                                    $total_pemakaian = $total_pemakaian_air;
                                    $total_sisa_air_liter = $total_pembelian - $total_pemakaian;
                                    ?>

                                    <td class="text-center"><?= number_format($total_pembelian_bulan_ini, 2, ',', '.'); ?></td>
                                    <td class="text-center"><?= number_format($total_pemakaian_air, 2, ',', '.'); ?></td>
                                    <td class="text-center"><?= number_format($total_air_terbuang, 2, ',', '.'); ?></td>
                                    <td class="text-end"><?= number_format($total_sisa_air_liter, 2, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <?php
                                    $total_pembelian = $total_pembelian_bulan_ini / 1000;
                                    $total_pemakaian = $total_pemakaian_air / 1000;
                                    $total_sisa_air_kubik = $total_pembelian - $total_pemakaian;
                                    ?>
                                    <td colspan="2" class="fw-bold">Meter Kubik</td>
                                    <td class="text-center"><?= number_format($total_pembelian, 2, ',', '.'); ?></td>
                                    <td class="text-center"><?= number_format($total_pemakaian, 2, ',', '.'); ?></td>
                                    <td class="text-center"><?= number_format($total_air_terbuang, 2, ',', '.'); ?></td>
                                    <td class="text-end"><?= number_format($total_sisa_air_kubik, 2, ',', '.'); ?></td>
                                </tr>
                                <!-- <tr>
                                    <td colspan="2" class="fw-bold">Pengiriman Truk Tangki</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr> -->
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>