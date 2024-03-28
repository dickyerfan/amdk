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
                            <a href="<?= base_url('keuangan/lebaran') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
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
                                $tahun_lap = date('Y');
                            }

                            ?>
                            <h5>Tahun : <?= $tahun_lap; ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center mb-2">
                        <div class="col-lg-3">
                            <?php
                            $total_harga = 0;
                            $total_barang = 0;
                            foreach ($lebaran as $row) {
                                $total_harga += $row->harga_lebaran;
                                $total_barang += $row->jumlah_barang * $row->jumlah_orang;
                            }; ?>

                            <div class="card mb-1">
                                <div class="card-header text-center">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="text-start">Jumlah Barang</td>
                                            <td class="text-end"><?= $total_barang; ?> Dus</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="card mb-1">
                                <div class="card-header text-center">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="text-start">Total Harus Dibayar </td>
                                            <td>
                                                Rp.
                                            </td>
                                            <td class="text-end"><?= number_format($total_harga, 0, ',', '.'); ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="card mb-1">
                                <div class="card-header text-center">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="text-start">Total Sudah Dibayar </td>
                                            <td>
                                                Rp.
                                            </td>
                                            <?php if (!empty($lunas_bayar) && isset($lunas_bayar[0]->total_bayar)) : ?>
                                                <td class="text-end"><?= number_format($lunas_bayar[0]->total_bayar, 0, ',', '.'); ?></td>
                                            <?php else : ?>
                                                <td class="text-end">Data tidak tersedia</td>
                                            <?php endif; ?>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="card mb-1">
                                <div class="card-header text-center">
                                    <form action="<?= base_url('keuangan/lebaran/bayar') ?>" method="post">
                                        <button type="submit" class="btn btn-secondary btn-sm mt-2">Pelunasan Lebaran</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>