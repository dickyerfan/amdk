<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <form id="form_bulan" action="<?= base_url('barang_baku/barang_masuk'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <!-- <label for="tanggal" id="tanggal_placeholder" style="font-size: 0.7rem;">Bulan & Tahun</label> -->
                                <input type="submit" value="Pilih bulan-tahun" class="neumorphic-button">
                                <input type="month" id="bulan" name="tanggal" class="form-control" style="margin-left: 5px;">
                            </div>
                        </form>

                        <div class="navbar-nav ms-auto">
                            <?php if ($this->session->userdata('upk_bagian') != 'admin') : ?>
                                <a href="<?= base_url('barang_baku/barang_masuk/upload') ?>"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Tambah Barang Masuk</button></a>
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
                                            <th class="text-center">Tanggal Transaksi</th>
                                            <!-- <th class="text-center">Kode Transaksi</th> -->
                                            <th class="text-center">Nama Barang</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-center">Petugas Penerima</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($barang_masuk as $row) : ?>
                                            <tr class="text-center">
                                                <td><?= $no++ ?></td>
                                                <td><?= date('d-m-Y', strtotime($row->tanggal_masuk)); ?></td>
                                                <!-- <td><?= $row->kode_barang_masuk; ?></td> -->
                                                <td class="text-start"><?= $row->nama_barang_baku; ?></td>
                                                <td class="text-end"><?= number_format($row->jumlah_masuk, 0, ',', '.'); ?></td>
                                                <td><?= $row->input_status_masuk; ?></td>
                                                <td><?= $row->status_masuk == 1 ? '<span class="btn btn-primary btn-sm">Selesai</span>' : '<span class="btn btn-danger btn-sm">Belum</span>'; ?></td>
                                                <td>
                                                    <a href="<?= $row->status_masuk == 0 ? base_url('barang_baku/barang_masuk/edit_masuk/') : "javascript:void(0)" ?><?= $row->id_masuk_baku; ?>"><span class="neumorphic-button text-success btn-sm"><i class="fas fa-edit text-success"></i> Proses</span></a>
                                                    <a href="<?= base_url('barang_baku/barang_masuk/detail_masuk/') ?><?= $row->id_masuk_baku ?>"><span class="neumorphic-button text-primary btn-sm"><i class="fa-solid fa-circle-info text-primary"></i> Detail</span></a>
                                                    <!-- <a href="<?= base_url('barang_baku/barang_masuk/hapus/') ?><?= $row->id_masuk_baku ?>" class="hapus-link"><i class="fas fa-trash text-danger"></i></a> -->
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
        </div>
    </main>