<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <form action="<?= base_url('barang_jadi/lebaran'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="date" name="tanggal" class="form-control">
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>
                        <div class="navbar-nav ms-auto">
                            <?php if ($this->session->userdata('upk_bagian') != 'admin') : ?>
                                <a href="<?= base_url('barang_jadi/lebaran/tambah') ?>"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Tambah Inputan</button></a>
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
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" id="example">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Uraian</th>
                                            <th class="text-center">Jumlah Orang</th>
                                            <th class="text-center">Nama Barang</th>
                                            <th class="text-center">Jumlah Satuan</th>
                                            <th class="text-center">Jumlah total</th>
                                            <th class="text-center">Rupiah</th>
                                            <th class="text-center">Input Oleh</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $total = 0;
                                        foreach ($lebaran as $row) :
                                            $jumlah_total = $row->jumlah_orang * $row->jumlah_barang;
                                            $total += $jumlah_total;
                                        ?>
                                            <tr class="text-center">
                                                <td><?= $no++ ?></td>
                                                <td class="text-start"><?= $row->nama_pelanggan; ?></td>
                                                <td><?= $row->jumlah_orang; ?></td>
                                                <td class="text-start"><?= strtoupper($row->nama_produk); ?></td>
                                                <td><?= $row->jumlah_barang; ?></td>
                                                <td><?= $jumlah_total; ?></td>
                                                <td class="text-end"><?= number_format($row->harga_lebaran, 0, ',', '.'); ?></td>
                                                <td><?= $row->input_lebaran; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4" class="text-center">Total</th>
                                            <th class="text-center"><?= $row->total_barang; ?></th>
                                            <th class="text-center"><?= $total; ?></th>
                                            <th class="text-end"><?= number_format($row->total_harga, 0, ',', '.'); ?></th>
                                            <th></th>
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