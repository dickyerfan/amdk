<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <form action="<?= base_url('barang_jadi/daftar_kiriman'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="date" name="tanggal" class="form-control">
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>
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

                    <div class="row justify-content-center mb-2">
                        <div class="col-lg-6">
                            <?php foreach ($total_pesanan as $row) : ?>
                                <div class="card">
                                    <div class="card-header text-center">
                                        <h5>Total Pengiriman hari ini : <?= $row->total_pesanan == null ? '0' : $row->total_pesanan; ?> barang</h5>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <?php if ($daftar_kiriman) : ?>
                            <?php foreach ($daftar_kiriman as $mobil) : ?>
                                <div class="col-lg-6">
                                    <div class="card mb-2">
                                        <div class="card-header">
                                            <h5>Mobil : <?= $mobil->nama_mobil; ?> / <?= $mobil->plat_nomor; ?></h5>
                                        </div>
                                        <div class="card-body">
                                            <!-- <h5 class="card-text">Total Jumlah Barang : <?= $mobil->total_pemesanan; ?></h5> -->
                                            <h5 class="card-text">Daftar Barang :</h5>
                                            <div class="table-responsive">
                                                <table class="table table-borderless table-sm">
                                                    <tbody>
                                                        <?php foreach ($mobil->jenis_barang as $barang) : ?>
                                                            <tr>
                                                                <td width="40%">
                                                                    - <?= ucwords($barang->nama_barang_jadi); ?>
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    <?= $barang->jumlah_pesan; ?>
                                                                </td>
                                                                <td width="30%">
                                                                    <?php
                                                                    switch ($barang->jenis_pesanan) {
                                                                        case 1:
                                                                            echo "Kunjungan Rutin";
                                                                            break;
                                                                        case 2:
                                                                            echo "Pesanan Langsung";
                                                                            break;
                                                                        case 3:
                                                                            echo "Bantuan/operasional";
                                                                            break;
                                                                        case 4:
                                                                            echo "Karyawan";
                                                                            break;
                                                                        default:
                                                                            echo "Tidak ada jenis pesanan";
                                                                            break;
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                        <tr class="fw-bold">
                                                            <td>Total Barang</td>
                                                            <td>:</td>
                                                            <td><?= $mobil->total_pemesanan; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- <li class="list-group-item">
                                                    - <?= $barang->nama_barang_jadi; ?> - <?= $barang->jumlah_pesan; ?> buah
                                                </li> -->
                                        </div>
                                        <div class="card-footer text-muted">
                                            Tanggal Pesan : <?= date('d-m-Y', strtotime($mobil->tanggal_pesan)); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="row justify-content-center">
                                <div class="col-auto">
                                    <div class="btn btn-danger shadow">Belum ada data pemesanan yang tersedia.</div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>