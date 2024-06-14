<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <!-- <form action="<?= base_url('pemasaran/pemesanan/daftar_kiriman'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="date" name="tanggal" class="form-control">
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form> -->
                        <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('keuangan/laporan_ban_ops') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
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
                            <h5>Bulan : <?= $bulan_lap . ' ' . $tahun_lap; ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center mb-2">
                        <!-- <div class="col-lg-3">
                            <?php
                            $total_galon = $total_gelas = $total_btl330 = $total_btl500 = $total_btl1500 = 0;
                            foreach ($rutin as $row) {
                                $total_galon += $row->galon;
                                $total_gelas += $row->gelas;
                                $total_btl330 += $row->btl330;
                                $total_btl500 += $row->btl500;
                                $total_btl1500 += $row->btl1500;
                            }; ?>

                            <div class="card mb-1">
                                <div class="card-header text-center">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="text-start">Jumlah Galon 19l</td>
                                            <td class="text-end"><?= $total_galon; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="card mb-1">
                                <div class="card-header text-center">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="text-start">Jumlah Gelas 220ml</td>
                                            <td class="text-end"><?= $total_gelas; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="card mb-1">
                                <div class="card-header text-center">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="text-start">Jumlah Botol 330ml</td>
                                            <td class="text-end"><?= $total_btl330; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="card mb-1">
                                <div class="card-header text-center">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="text-start">Jumlah Botol 500ml</td>
                                            <td class="text-end"><?= $total_btl500; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="card mb-1">
                                <div class="card-header text-center">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="text-start">Jumlah Botol 1500ml</td>
                                            <td class="text-end"><?= $total_btl1500; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div> -->
                        <!-- <div class="col-lg-2">
                            <?php
                            $total_galon = $total_gelas = $total_btl330 = $total_btl500 = $total_btl1500 = $total_nominal = 0;
                            foreach ($rutin as $row) {
                                $total_galon += $row->galon * 11000; //jika ada perubahan tarif harus di setting manual
                                $total_gelas += $row->gelas * 15000;
                                $total_btl330 += $row->btl330 * 33000;
                                $total_btl500 += $row->btl500 * 35000;
                                $total_btl1500 += $row->btl1500 * 38000;
                                $total_nominal += $row->nominal;
                            }; ?>

                            <div class="card mb-1">
                                <div class="card-header text-center">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td>Rp. </td>
                                            <td class="text-end"><?= number_format($total_galon, 0, ',', '.'); ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="card mb-1">
                                <div class="card-header text-center">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td>Rp. </td>
                                            <td class="text-end"><?= number_format($total_gelas, 0, ',', '.'); ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="card mb-1">
                                <div class="card-header text-center">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td>Rp. </td>
                                            <td class="text-end"><?= number_format($total_btl330, 0, ',', '.'); ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="card mb-1">
                                <div class="card-header text-center">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td>Rp. </td>
                                            <td class="text-end"><?= number_format($total_btl500, 0, ',', '.'); ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="card mb-1">
                                <div class="card-header text-center">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td>Rp. </td>
                                            <td class="text-end"><?= number_format($total_btl1500, 0, ',', '.'); ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div> -->
                        <?php
                        $total_ban_ops = 0;
                        foreach ($ban_ops as $row) {
                            $total_ban_ops = $row->total_ban_ops;
                        }
                        ?>
                        <div class="col-lg-3">
                            <div class="card mb-1">
                                <div class="card-header text-center">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="text-start">Total Harus Disetor </td>
                                            <td>
                                                Rp.
                                            </td>
                                            <td class="text-end"><?= number_format($total_ban_ops, 0, ',', '.'); ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="card mb-1">
                                <div class="card-header text-center">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="text-start">Total Penerimaan</td>
                                            <td>
                                                Rp.
                                            </td>
                                            <?php if (!empty($pesan_ban_ops) && isset($pesan_ban_ops[0]->total_penerimaan)) : ?>
                                                <td class="text-end"><?= number_format($pesan_ban_ops[0]->total_penerimaan, 0, ',', '.'); ?></td>
                                            <?php else : ?>
                                                <td class="text-end">Data tidak tersedia</td>
                                            <?php endif; ?>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="card mb-1">
                                <div class="card-header text-center">
                                    <form action="<?= base_url('keuangan/laporan_ban_ops/setor') ?>" method="post" enctype="multipart/form-data">
                                        <button type="submit" class="btn btn-secondary btn-sm mt-2">Bayar Penerimaan Operasional / Bantuan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>