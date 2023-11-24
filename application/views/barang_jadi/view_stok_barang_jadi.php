<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <form action="<?= base_url('barang_jadi/stok_barang_jadi'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="date" name="tanggal" class="form-control">
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>
                        <!-- <div class="navbar-nav ms-auto">
                            <a class="nav-link fw-bold" href="<?= base_url('barang_jadi/stok_barang_jadi/exportpdf') ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class=" neumorphic-button" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
                        </div> -->
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
                            <table class="table table-sm table-bordered" id="example2" style="font-size: 1rem;">
                                <thead>
                                    <tr class="text-center">
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama Barang</th>
                                        <th class="text-center">Stok Awal</th>
                                        <th class="text-center">Hasil Produksi</th>
                                        <th class="text-center">Barang Keluar</th>
                                        <th class="text-center">Barang Rusak</th>
                                        <th class="text-center">Stok Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $produk_sebelumnya = null;
                                    foreach ($stok_barang as $row) :
                                        // $jumlah_keluar = $row->jumlah_keluar;
                                        // $jumlah_kembali = $row->jumlah_kembali;
                                        // $jumlah_total_keluar = $jumlah_keluar - $jumlah_kembali;
                                        // $stok_akhir = $row->jumlah_stok_awal + $row->jumlah_masuk - $jumlah_total_keluar - $row->jumlah_rusak;

                                        $stok_awal = $row->jumlah_stok_awal + $row->jumlah_masuk_kemaren - $row->jumlah_akhir_kemaren - $row->jumlah_rusak_kemaren;
                                        $stok_akhir = $row->jumlah_stok_awal + $row->jumlah_masuk - $row->jumlah_akhir - $row->jumlah_rusak;



                                        if ($produk_sebelumnya !== $row->nama_barang_jadi) :
                                    ?>

                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><?= ucwords($row->nama_barang_jadi); ?></td>
                                                <td class="text-end"><?= number_format($stok_awal, 0, ',', '.'); ?></td>
                                                <td class="text-end"><?= number_format($row->jumlah_masuk_sekarang, 0, ',', '.'); ?></td>
                                                <td class="text-end"><?= number_format($row->jumlah_akhir_sekarang, 0, ',', '.'); ?></td>
                                                <td class="text-end"><?= number_format($row->jumlah_rusak_sekarang, 0, ',', '.'); ?></td>
                                                <td class="text-end"><?= number_format($stok_akhir, 0, ',', '.'); ?></td>
                                            </tr>
                                    <?php
                                            $produk_sebelumnya = $row->nama_barang_jadi;
                                        endif;
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