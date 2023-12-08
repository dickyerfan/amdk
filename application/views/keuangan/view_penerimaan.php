<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <form action="<?= base_url('keuangan/penerimaan'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="date" name="tanggal" class="form-control">
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>
                        <!-- <div class="navbar-nav ms-auto">
                            <?php if ($this->session->userdata('upk_bagian') != 'admin') : ?>
                                <a href="<?= base_url('keuangan/pelanggan') ?>"><button class="float-end neumorphic-button"><i class="fas fa-users"></i> Daftar Pelanggan</button></a>
                            <?php endif; ?>
                        </div> -->
                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center mb-2">
                        <!-- <div class="col-lg-6 text-center">
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
                        </div> -->
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
                            <table class="table table-sm table-bordered" id="example" style="font-size: 0.8rem;">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Tgl Bayar</th>
                                        <th class="text-center">Tgl Order</th>
                                        <th class="text-center">Jenis Barang</th>
                                        <th class="text-center">Nama Pelanggan</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $total_penerimaan = 0;
                                    foreach ($pesan as $row) :
                                        $total_penerimaan = $row->total_penerimaan;
                                    ?>
                                        <tr class="text-center">
                                            <td><?= $no++ ?></td>
                                            <td><?= date('d-m-y', strtotime($row->tanggal_bayar)); ?></td>
                                            <td><?= date('d-m-y', strtotime($row->tanggal_pesan)); ?></td>
                                            <td class="text-start"><?= $row->nama_produk; ?></td>
                                            <td class="text-start"><?= ucwords(strtolower($row->nama_pelanggan)); ?></td>
                                            <td class="text-end"><?= number_format($row->jumlah_pesan, 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($row->harga_barang, 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($row->total_harga, 0, ',', '.'); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="7" class="text-end">Jumlah</th>
                                        <th class="text-end"><?= number_format($total_penerimaan, 0, ',', '.'); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>