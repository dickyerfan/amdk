<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <form action="<?= base_url('barang_produksi/pengembalian_galon'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="date" name="tanggal" class="form-control">
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>
                        <div class="navbar-nav ms-auto">
                            <?php if ($this->session->userdata('upk_bagian') != 'admin') : ?>
                                <a href="<?= base_url('barang_produksi/pengembalian_galon/upload') ?>"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Tambah Galon Kembali</button></a>
                            <?php endif; ?>
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
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <table class="table table-sm table-bordered" id="example">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Jmlh Kembali</th>
                                        <th class="text-center">Jmlh Baru</th>
                                        <th class="text-center">Jmlh Produksi</th>
                                        <th class="text-center">Jmlh Rusak</th>
                                        <th class="text-center">Jmlh Akhir</th>
                                        <th class="text-center">Input Oleh</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($galon as $row) : ?>
                                        <tr class="text-center">
                                            <td><?= $no++ ?></td>
                                            <td><?= date('d-m-Y', strtotime($row->tanggal_kembali)); ?></td>
                                            <td><?= number_format($row->jumlah_kembali, 0, ',', '.'); ?></td>
                                            <td><?= number_format($row->jumlah_baru, 0, ',', '.'); ?></td>
                                            <td><?= number_format($row->jumlah_produksi, 0, ',', '.'); ?></td>
                                            <td><?= number_format($row->jumlah_rusak, 0, ',', '.'); ?></td>
                                            <td><?= number_format($row->jumlah_akhir, 0, ',', '.'); ?></td>
                                            <td><?= $row->input_status_kembali; ?></td>
                                            <td>
                                                <a href="<?= base_url('barang_produksi/pengembalian_galon/detail/') ?><?= $row->id_galon_kembali ?>"><span class="neumorphic-button text-primary btn-sm"><i class="fa-solid fa-circle-info text-primary"></i> Detail</span></a>
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