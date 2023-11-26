<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <form action="<?= base_url('barang_produksi/permintaan_barang_baku'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="date" name="tanggal" class="form-control">
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>
                        <div class="navbar-nav ms-auto">
                            <?php if ($this->session->userdata('upk_bagian') != 'admin') : ?>
                                <a href="<?= base_url('barang_produksi/permintaan_barang_baku/upload') ?>"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Permintaan Barang</button></a>
                            <?php endif; ?>
                        </div>
                        <!-- <div class="navbar-nav ms-auto">
                            <?php if ($this->session->userdata('upk_bagian') != 'admin') : ?>
                                <a href="#tambahData" data-bs-toggle="modal"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Permintaan Barang</button></a>
                            <?php endif; ?>
                        </div> -->
                    </nav>
                </div>
                <div class="p-1">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
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
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <table class="table table-sm table-bordered" id="example">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Kode Barang</th>
                                        <th class="text-center">Nama Barang</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-center">Input Oleh</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($barang_baku as $row) :
                                    ?>
                                        <tr class="text-center">
                                            <td><?= $no++ ?></td>
                                            <td><?= $row->tanggal_keluar; ?></td>
                                            <td><?= $row->kode_barang; ?></td>
                                            <td class="text-start"><?= $row->nama_barang_baku; ?></td>
                                            <td><?= number_format($row->jumlah_keluar, 0, ',', '.'); ?></td>
                                            <td><?= $row->input_status_keluar; ?></td>
                                            <td>
                                                <?= $row->status_keluar == 0 ? '<span class="neumorphic-button text-success">Milik Barang Baku</span>' : '<span class="neumorphic-button text-primary">Milik Barang Produksi</span>' ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>