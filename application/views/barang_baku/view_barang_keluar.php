<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <!-- <div class="navbar-nav">
                            <a href="<?= base_url('rkap/usulan_inves/export_pdf') ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
                        </div> -->
                        <!-- <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('barang_baku/barang_keluar/upload') ?>"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Tambah Barang</button></a>
                        </div> -->
                        <!-- <form action="<?= base_url('barang_baku/barang_keluar'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="date" name="tanggal" class="form-control">
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form> -->
                        <form action="<?= base_url('barang_baku/barang_keluar'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="date" name="tanggal" class="form-control">
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>
                    </nav>
                </div>
                <div class="p-1">
                    <p id="pesan2" style="color: red;"></p>
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
                                        <th class="text-center">Tgl Transaksi</th>
                                        <th class="text-center">No Nota</th>
                                        <th class="text-center">Pemohon</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <!-- <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Tgl Transaksi</th>
                                        <th class="text-center">Kode Barang</th>
                                        <th class="text-center">No Nota</th>
                                        <th class="text-center">Nama Barang</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-center">Pemohon</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead> -->
                                <!-- <tbody id="show_data"> -->
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $prev_tanggal = null;
                                    $prev_bagian = null;
                                    foreach ($barang_keluar as $row) :
                                        if ($prev_tanggal !== $row->tanggal_keluar || $prev_bagian !== $row->bagian) {
                                    ?>
                                            <tr class="text-center">
                                                <td><?= $no++ ?></td>
                                                <td><?= date('d-m-Y', strtotime($row->tanggal_keluar)); ?></td>
                                                <td><?= $row->no_nota; ?></td>
                                                <td><?= $row->input_status_keluar; ?></td>
                                                <td class="text-center">
                                                    <?= $row->status_keluar == 0 ? '<span class="btn btn-primary btn-sm">Menunggu</span>'  : ($row->bagian === 'produksi' ? '<span class="btn btn-success btn-sm">Stok Produksi</span>' : '<span class="btn btn-warning btn-sm">Stok Brg Jadi</span>'); ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                    if ($row->status_keluar == 0) {
                                                        $updateUrl = base_url('barang_baku/barang_keluar/update_status_keluar/') . $row->tanggal_keluar . '/' . $row->bagian;
                                                        $tolakUrl = base_url('barang_produksi/permintaan_barang_baku/tolak_pesanan/') . $row->tanggal_keluar . '/' . $row->bagian;
                                                        echo '<a href="' . $updateUrl . '" style="text-decoration: none;"><span class="btn btn-primary btn-sm">Terima</span></a>' . ' <a href="' . $tolakUrl . '" style="text-decoration: none;"><span class="btn btn-success btn-sm">Tolak</span></a>';
                                                    } else {
                                                        $detailUrl = base_url('barang_baku/barang_keluar/detail_status_keluar/') . $row->tanggal_keluar . '/' . $row->bagian;
                                                        echo '<a href="' . $detailUrl . '"><span class="neumorphic-button btn-sm">Detail</span></a>';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                    <?php
                                            $prev_tanggal = $row->tanggal_keluar;
                                            $prev_bagian = $row->bagian;
                                        }
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>