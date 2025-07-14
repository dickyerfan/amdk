<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <div class="navbar-nav ms-start">
                            <a href="<?= base_url('keuangan/penerimaan_kas/export_kas_pdf') ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
                        </div>
                        <div class="navbar-nav ms-end">
                            <a href="<?= base_url('keuangan/penerimaan_kas'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-reply"></i> Kembali</button></a>
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
                            <?php if (empty($tanggal_hari_ini)) {
                                // Jika kosong atau null, atur nilainya menjadi tanggal hari ini
                                $tanggal_hari_ini = date("Y-m-d"); // Format tanggal "YYYY-MM-DD"
                            }
                            // Ubah format tanggal ke bahasa Indonesia
                            setlocale(LC_TIME, 'id_ID');
                            $tanggal_hari_ini = strftime('%e %B %Y', strtotime($tanggal_hari_ini));
                            // Ubah nama bulan menjadi bahasa Indonesia
                            $bulan = [
                                'January' => 'Januari',
                                'February' => 'Februari',
                                'March' => 'Maret',
                                'April' => 'April',
                                'May' => 'Mei',
                                'June' => 'Juni',
                                'July' => 'Juli',
                                'August' => 'Agustus',
                                'September' => 'September',
                                'October' => 'Oktober',
                                'November' => 'November',
                                'December' => 'Desember',
                            ];

                            $tanggal_hari_ini = strtr($tanggal_hari_ini, $bulan);

                            ?>
                            <h5><?= $tanggal_hari_ini; ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" style="font-size: 0.8rem;">
                                    <thead class="bg-secondary text-white text-center">
                                        <tr>
                                            <th rowspan="2" class="align-middle">No</th>
                                            <th rowspan="2" class="align-middle">Nama</th>
                                            <th colspan="2">220 ml</th>
                                            <th colspan="2">330 ml</th>
                                            <th colspan="2">500 ml</th>
                                            <th colspan="2">1500 ml</th>
                                            <th colspan="2">Galon 19</th>
                                            <th colspan="2">Non Air</th>
                                            <th rowspan="2" class="align-middle">Jumlah</th>
                                        </tr>
                                        <tr>
                                            <th>Jml</th>
                                            <th>Rp</th>
                                            <th>Jml</th>
                                            <th>Rp</th>
                                            <th>Jml</th>
                                            <th>Rp</th>
                                            <th>Jml</th>
                                            <th>Rp</th>
                                            <th>Jml</th>
                                            <th>Rp</th>
                                            <th>Jml</th>
                                            <th>Rp</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $total_all = 0;
                                        foreach ($grouped_data as $nama => $produk) :
                                            $total_all += $produk['total'];
                                        ?>
                                            <tr class="text-end">
                                                <td class="text-center"><?= $no++; ?></td>
                                                <td class="text-start"><?= $nama; ?></td>
                                                <td><?= $produk['220ml']['jumlah']; ?></td>
                                                <td><?= number_format($produk['220ml']['rupiah'], 0, ',', '.'); ?></td>
                                                <td><?= $produk['330ml']['jumlah']; ?></td>
                                                <td><?= number_format($produk['330ml']['rupiah'], 0, ',', '.'); ?></td>
                                                <td><?= $produk['500ml']['jumlah']; ?></td>
                                                <td><?= number_format($produk['500ml']['rupiah'], 0, ',', '.'); ?></td>
                                                <td><?= $produk['1500ml']['jumlah']; ?></td>
                                                <td><?= number_format($produk['1500ml']['rupiah'], 0, ',', '.'); ?></td>
                                                <td><?= $produk['galon 19']['jumlah']; ?></td>
                                                <td><?= number_format($produk['galon 19']['rupiah'], 0, ',', '.'); ?></td>
                                                <td><?= $produk['galon kosong']['jumlah']; ?></td>
                                                <td><?= number_format($produk['galon kosong']['rupiah'], 0, ',', '.'); ?></td>
                                                <td><?= number_format($produk['total'], 0, ',', '.'); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot class="bg-light text-end fw-bold">
                                        <tr>
                                            <td colspan="2" class="text-end">Jumlah</td>
                                            <td><?= $total_produk['220ml']['jumlah']; ?></td>
                                            <td><?= number_format($total_produk['220ml']['rupiah'], 0, ',', '.'); ?></td>
                                            <td><?= $total_produk['330ml']['jumlah']; ?></td>
                                            <td><?= number_format($total_produk['330ml']['rupiah'], 0, ',', '.'); ?></td>
                                            <td><?= $total_produk['500ml']['jumlah']; ?></td>
                                            <td><?= number_format($total_produk['500ml']['rupiah'], 0, ',', '.'); ?></td>
                                            <td><?= $total_produk['1500ml']['jumlah']; ?></td>
                                            <td><?= number_format($total_produk['1500ml']['rupiah'], 0, ',', '.'); ?></td>
                                            <td><?= $total_produk['galon 19']['jumlah']; ?></td>
                                            <td><?= number_format($total_produk['galon 19']['rupiah'], 0, ',', '.'); ?></td>
                                            <td><?= $total_produk['galon kosong']['jumlah']; ?></td>
                                            <td><?= number_format($total_produk['galon kosong']['rupiah'], 0, ',', '.'); ?></td>
                                            <td><?= number_format($total_semua, 0, ',', '.'); ?></td>
                                        </tr>
                                    </tfoot>

                                    <!-- <tfoot class="bg-light text-end fw-bold">
                                        <tr>
                                            <td colspan="14" class="text-end">Jumlah</td>
                                            <td><?= number_format($total_all, 0, ',', '.'); ?></td>
                                        </tr>
                                    </tfoot> -->
                                </table>

                                <!-- <table id="example" class="table table-hover table-striped table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 0.8rem;">
                                    <thead>
                                        <tr class="bg-secondary">
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nama Pelanggan</th>
                                            <th class="text-center">Jenis Barang</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-center">Harga</th>
                                            <th class="text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($detail_terima as $row) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no++; ?></td>
                                                <td><?= $row->nama_pelanggan; ?></td>
                                                <td><?= $row->nama_produk; ?></td>
                                                <td class="text-end"><?= number_format($row->jumlah_pesan, 0, ',', '.'); ?></td>
                                                <td class="text-end"><?= number_format($row->harga_barang, 0, ',', '.'); ?></td>
                                                <td class="text-end"><?= number_format($row->total_harga, 0, ',', '.'); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5" class="text-end">Jumlah</th>
                                            <th class="text-end"><?= number_format($total_penerimaan, 0, ',', '.'); ?></th>
                                        </tr>
                                    </tfoot>
                                </table> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>