<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <form action="<?= base_url('keuangan/laporan_ban_ops'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="date" name="tanggal" class="form-control">
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>
                        <div class="navbar-nav ms-2">
                            <a href="<?= base_url('keuangan/laporan_ban_ops') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Lap Operasional</button></a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('keuangan/laporan_ban_ops/exportpdf_ban') ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
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
                    <div class="table-responsive">
                        <table id="example" class="table table-hover table-striped table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 0.8rem;">
                            <thead>
                                <tr class="text-center" style="vertical-align: middle;">
                                    <th class="text-center">No</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Nama</th>
                                    <?php foreach ($jenis_produk as $jenis) : ?>
                                        <th class="text-center" style="vertical-align: middle;">
                                            <?php
                                            switch ($jenis->nama_barang_jadi) {
                                                case 'galon 19l':
                                                    echo 'Galon 19l';
                                                    break;
                                                case 'gelas 220ml ijen':
                                                    echo '220 Ijen Biru';
                                                    break;
                                                case 'gelas 220ml genggong':
                                                    echo '220 Genggong';
                                                    break;
                                                case 'gelas 220ml an nujum':
                                                    echo '220 AnNujum';
                                                    break;
                                                case 'gelas 220ml syubbanq':
                                                    echo '220 SyubbanQ';
                                                    break;
                                                case 'gelas 220ml amalis':
                                                    echo '220 Amalis';
                                                    break;
                                                case 'gelas 220ml ijen merah':
                                                    echo '220 Ijen Merah';
                                                    break;
                                                case 'botol 330ml ijen':
                                                    echo '330 Ijen';
                                                    break;
                                                case 'botol 500ml ijen':
                                                    echo '500 Ijen';
                                                    break;
                                                case 'botol 500ml amalis':
                                                    echo '500 Amalis';
                                                    break;
                                                case 'botol 1500 ml ijen':
                                                    echo '1500 Ijen';
                                                    break;
                                                case 'botol 1500 ml amalis':
                                                    echo '1500 Amalis';
                                                    break;
                                                case 'galon kosong':
                                                    echo 'No Air';
                                                    break;
                                                default:
                                                    echo $jenis->nama_barang_jadi;
                                                    break;
                                            }
                                            ?>
                                        </th>
                                    <?php endforeach; ?>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($grouped_ban_ops as $row) :
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><?= date('d-m-Y', strtotime($row->tanggal_ban_ops)); ?></td>
                                        <td><?= $row->nama_ban_ops; ?></td>
                                        <?php foreach ($jenis_produk as $barang) : ?>
                                            <?php
                                            $jumlah_barang = isset($row->jumlah[$barang->nama_barang_jadi]) ? $row->jumlah[$barang->nama_barang_jadi] : ' ';
                                            $total_harga = $row->harga_ban_ops_total;
                                            ?>
                                            <td class="text-center"><?= $jumlah_barang; ?></td>
                                        <?php endforeach; ?>
                                        <td class="text-end"><?= number_format($total_harga, 0, ',', '.'); ?></td>
                                        <td><?= $row->keterangan ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="text-center" style="vertical-align: middle;">
                                    <th class="text-center" colspan="3">Jumlah</th>
                                    <?php foreach ($jenis_produk as $barang) : ?>
                                        <?php
                                        $total_jumlah_barang = 0;
                                        $total_semua_harga = 0;

                                        foreach ($grouped_ban_ops as $row) {
                                            $jumlah_barang = isset($row->jumlah[$barang->nama_barang_jadi]) ? $row->jumlah[$barang->nama_barang_jadi] : 0;
                                            $total_jumlah_barang += $jumlah_barang;
                                            $total_semua_harga += $row->harga_ban_ops_total;
                                        }
                                        ?>
                                        <th class="text-center" style="vertical-align: middle;"><?= $total_jumlah_barang; ?></th>
                                    <?php endforeach; ?>
                                    <th class="text-center" style="vertical-align: middle;"><?= number_format($total_semua_harga, 0, ',', '.'); ?></th>
                                    <th class="text-center"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>