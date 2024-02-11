<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <form action="<?= base_url('pemasaran/pemesanan'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="date" name="tanggal" class="form-control">
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>
                        <div class="navbar-nav ms-auto">
                            <?php if ($this->session->userdata('upk_bagian') != 'admin') : ?>
                                <a href="<?= base_url('pemasaran/pemesanan/upload') ?>"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Input Pemesanan</button></a>
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
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" id="example2" style="font-size: 0.8rem;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">Nama Pelanggan</th>
                                            <th class="text-center">Alamat</th>
                                            <th class="text-center">Jenis Barang</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-center">Harga</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Jenis pesanan</th>
                                            <th class="text-center">Mobil</th>
                                            <th class="text-center">Nota</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($pesan as $row) : ?>
                                            <tr class="text-center">
                                                <td><?= $no++ ?></td>
                                                <td><?= date('d-m-y', strtotime($row->tanggal_pesan)); ?></td>
                                                <td class="text-start"><?= ucwords(strtolower($row->nama_pelanggan)); ?></td>
                                                <td class="text-start"><?= ucwords(strtolower($row->alamat_pelanggan)); ?></td>
                                                <td class="text-start"><?= $row->nama_produk; ?></td>
                                                <td class="text-end"><?= number_format($row->jumlah_pesan, 0, ',', '.'); ?></td>
                                                <td class="text-end"><?= number_format($row->harga_barang, 0, ',', '.'); ?></td>
                                                <td class="text-end"><?= number_format($row->total_harga, 0, ',', '.'); ?></td>
                                                <td>
                                                    <?php
                                                    if ($row->jenis_pesanan == 1) {
                                                        echo 'Kunjungan Rutin';
                                                    } elseif ($row->jenis_pesanan == 2) {
                                                        echo 'Pesanan Langsung';
                                                    } elseif ($row->jenis_pesanan == 3) {
                                                        echo 'Karyawan';
                                                    } else {
                                                        echo 'Bantuan / Operasional';
                                                    } ?>
                                                    <!-- <?= $row->jenis_pesanan == 1 ? 'Kunjungan Rutin' : 'Pesanan Langsung'; ?> -->
                                                </td>
                                                <td><?= $row->nama_mobil; ?></td>
                                                <!-- <td></td> -->
                                                <td><?= $row->status_nota == 1 ? '<span class="btn btn-primary btn-sm" style="font-size: 0.7rem;">Setor</span>' : '<span class="btn btn-danger btn-sm" style="font-size: 0.7rem;">Belum</span>'; ?></td>
                                                <td><?= $row->status_bayar == 1 ? '<span class="btn btn-primary btn-sm" style="font-size: 0.7rem;">Lunas</span>' : '<span class="btn btn-danger btn-sm" style="font-size: 0.7rem;">Belum</span>'; ?></td>
                                                <!-- <td>
                                                    <a href="<?= $row->id_mobil == null ? base_url('pemasaran/pemesanan/pilih_mobil/') : "javascript:Swal.fire('Mobil Sudah Di pilih', '', 'warning');" ?><?= $row->id_pemesanan; ?>"><i class="fas fa-truck text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="klik untuk pilih Mobil"></i></a>
                                                    <a href="<?= ($row->status_nota == 1 || $row->id_mobil == null) ? "javascript:Swal.fire('Nota tidak bisa di input', '', 'warning');"  : base_url('pemasaran/pemesanan/upload_nota/') ?><?= $row->id_pemesanan . '/' . $row->id_pelanggan . '/' . $row->tanggal_pesan; ?>"><i class="fa-solid fa-square-poll-horizontal text-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="klik untuk upload nota"></i></a>
                                                    <a href="<?= base_url('pemasaran/pemesanan/detail/') ?><?= $row->id_pemesanan ?>"><i class="fa-solid fa-circle-info text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="klik lihat detail pemesanan"></i></a>
                                                </td> -->
                                                <td>
                                                    <a href="<?= ($row->id_mobil != null) ? "javascript:void(0);" : base_url('pemasaran/pemesanan/pilih_mobil/') . $row->id_pemesanan; ?>" onclick="<?= ($row->id_mobil != null) ? "Swal.fire('Mobil Sudah Dipilih', '', 'warning'); return false;" : '' ?>"><i class="fas fa-truck text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="klik untuk pilih Mobil"></i></a>
                                                    <a href="<?= ($row->status_nota == 1 || $row->id_mobil == null) ? "javascript:void(0);" : base_url('pemasaran/pemesanan/upload_nota/') . $row->id_pemesanan . '/' . $row->id_pelanggan . '/' . $row->tanggal_pesan; ?>" onclick="<?= ($row->status_nota == 1 || $row->id_mobil == null) ? "Swal.fire('Nota tidak bisa di input', '', 'warning'); return false;" : '' ?>"><i class="fa-solid fa-square-poll-horizontal text-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="klik untuk upload nota"></i></a>
                                                    <a href="<?= base_url('pemasaran/pemesanan/detail/') . $row->id_pemesanan ?>"><i class="fa-solid fa-circle-info text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="klik lihat detail pemesanan"></i></a>
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