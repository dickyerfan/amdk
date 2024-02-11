<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <form action="<?= base_url('barang_jadi/barang_keluar'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="date" name="tanggal" class="form-control">
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>
                        <!-- <div class="navbar-nav ms-auto">
                            <?php if ($this->session->userdata('upk_bagian') != 'admin') : ?>
                                <a href="<?= base_url('barang_jadi/barang_masuk/upload') ?>"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Proses Barang Jadi</button></a>
                            <?php endif; ?>
                        </div> -->
                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <!-- <div class="row justify-content-center mb-2">
                        <div class="col-lg-6 text-center">
                            <h6><?= strtoupper($title); ?></h6>
                        </div>
                    </div> -->
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
                                <table class="table table-sm table-bordered" id="example" style="font-size: 0.8rem;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">Nama Barang</th>
                                            <!-- <th class="text-center">Jenis Barang</th> -->
                                            <th class="text-center">Jml Keluar</th>
                                            <th class="text-center">Jml Kembali</th>
                                            <th class="text-center">Jml Akhir</th>
                                            <th class="text-center">Petugas Order</th>
                                            <th class="text-center">Mobil</th>
                                            <th class="text-center">Jenis Pesanan</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($barang_keluar as $row) :
                                        ?>
                                            <tr class="text-center">
                                                <td><?= $no++ ?></td>
                                                <td><?= date('d-m-y', strtotime($row->tanggal_keluar)); ?></td>
                                                <td class="text-start"><?= $row->nama_produk; ?></td>
                                                <!-- <td class="text-start"><?= $row->jenis_produk; ?></td> -->
                                                <td><?= number_format($row->jumlah_keluar, 0, ',', '.'); ?></td>
                                                <td><?= number_format($row->jumlah_kembali, 0, ',', '.'); ?></td>
                                                <td><?= number_format($row->jumlah_akhir, 0, ',', '.'); ?></td>
                                                <td><?= $row->input_status_keluar; ?></td>
                                                <td><?= $row->nama_mobil; ?></td>
                                                <td>
                                                    <?php
                                                    if ($row->jenis_pesanan == 1) {
                                                        echo 'Kunjungan Rutin';
                                                    } elseif ($row->jenis_pesanan == 2) {
                                                        echo 'Pesanan Langsung';
                                                    } elseif ($row->jenis_pesanan == 3) {
                                                        echo 'Karyawan';
                                                    } else {
                                                        echo 'Operasional/Bantuan';
                                                    } ?>
                                                </td>
                                                <td><?= $row->status_keluar == 1 ? '<span class="btn btn-primary btn-sm" style="font-size: 0.7rem;">Keluar</span>' : '<span class="btn btn-danger btn-sm" style="font-size: 0.7rem;">Belum</span>'; ?>
                                                </td>
                                                <td>
                                                    <a href="<?= ($row->status_kembali == 0) ? base_url('barang_jadi/barang_keluar/barang_kembali/') : "javascript:void(0)" ?><?= $row->id_keluar_jadi; ?>"><i class="fas fa-box text-success me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="klik input barang kembali"></i></a>
                                                    <!-- <a href="<?= ($row->status_kembali == 0 && $row->status_keluar == 0) ? base_url('barang_jadi/barang_keluar/barang_kembali/') : "javascript:void(0)" ?><?= $row->id_keluar_jadi; ?>"><i class="fas fa-box text-success me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="klik input barang kembali"></i></a> -->
                                                    <a href="<?= $row->status_keluar == 0 ? "javascript:void(0)" : "javascript:void(0)" ?>" onclick="<?= $row->status_keluar == 0 ? "tampilkanKonfirmasi(" . $row->id_keluar_jadi . ")" : "" ?>">
                                                        <i class="fas fa-circle-check" data-bs-toggle="tooltip" data-bs-placement="top" title="klik untuk terima permintaan barang"></i>
                                                    </a>
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