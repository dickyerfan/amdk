<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <form id="umur_piutang" action="<?= base_url('keuangan/laporan_piutang/umur_piutang'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="submit" value="Umur Piutang" class="neumorphic-button">
                                <input type="hidden" id="umur_piutang" name="umur_piutang" class="form-control" style="margin-left: 10px;">
                            </div>
                        </form>
                        <form id="semua_piutang" action="<?= base_url('keuangan/laporan_piutang'); ?>" method="get">
                            <div style="display: flex; align-items: center;" class="ms-2">
                                <input type="submit" value="Semua Piutang" class="neumorphic-button">
                                <input type="hidden" id="semua_piutang" name="semua_piutang" class="form-control" style="margin-left: 10px;">
                            </div>
                        </form>
                        <form id="form_tanggal" action="<?= base_url('keuangan/laporan_piutang'); ?>" method="get">
                            <div style="display: flex; align-items: center;" class="ms-2">
                                <input type="submit" value="Pilih Perbulan" class="neumorphic-button">
                                <input type="date" id="tanggal" name="tanggal" class="form-control" style="margin-left: 10px;">
                            </div>
                        </form>
                        <form id="form_tahun" action="<?= base_url('keuangan/laporan_piutang/piutang_pertahun'); ?>" method="get">
                            <div style="display: flex; align-items: center;" class="ms-2">
                                <input type="submit" value="Pilih pertahun" class="neumorphic-button">
                                <!-- <input type="date" id="tahun" name="tahun" class="form-control" style="margin-left: 10px;"> -->
                                <select id="tahun" name="tahun" class="form-control" style="margin-left: 10px;">
                                    <?php
                                    $currentYear = date("Y");
                                    for ($year = $currentYear; $year >= 2020; $year--) {
                                        echo "<option value='$year'>$year</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </form>
                        <form id="form_samden" action="<?= base_url('keuangan/laporan_piutang/piutang_samden'); ?>" method="get">
                            <div style="display: flex; align-items: center;" class="ms-2">
                                <input type="submit" value="sampai/dengan" class="neumorphic-button">
                                <input type="date" id="samden" name="samden" class="form-control" style="margin-left: 10px;">
                            </div>
                        </form>
                        <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('keuangan/laporan_piutang/exportpdf_pertahun') ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
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
                            <div class="col-lg-12">
                                <div>
                                    <p class="my-0 text-center"><?= strtoupper($title) ?></p>
                                    <?php
                                    $tahun = $this->input->get('tahun');

                                    if (empty($tahun)) {
                                    ?>
                                        <p class="mu-0 text-center">Semua Piutang</p>
                                    <?php
                                    } else {
                                        $tahunLap = $tahun;
                                    ?>
                                        <p class="mu-0 text-center">Tahun : <?= $tahunLap ?></p>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" style="font-size: 0.9rem;">
                                    <thead>
                                        <tr class="text-center fw-bold">
                                            <td>No</td>
                                            <td>Nama Produk</td>
                                            <td>Satuan</td>
                                            <td>Jumlah Produk</td>
                                            <td>Jumlah Piutang</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $jumlah_total_piutang = 0;
                                        $jumlah_barang = 0;
                                        foreach ($data_piutang as $piutang) :
                                            $jumlah_total_piutang += $piutang->total_piutang;
                                            $jumlah_barang += $piutang->total_barang;
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><?= $piutang->nama_produk; ?></td>
                                                <td class="text-center">Dus</td>
                                                <td class="text-center"><?= number_format($piutang->total_barang, 0, ',', '.'); ?></td>
                                                <td class="text-center"><?= number_format($piutang->total_piutang, 0, ',', '.'); ?></td>

                                            </tr>
                                        <?php endforeach; ?>
                                        <tr class=" fw-bold">
                                            <td colspan="3" class="text-center">Jumlah</td>
                                            <td class="text-center"><?= number_format($jumlah_barang, 0, ',', '.')  ?></td>
                                            <td class="text-center"><?= number_format($jumlah_total_piutang, 0, ',', '.')  ?></td>
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