<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <div class="navbar-nav ms-2">
                            <form action="<?= base_url('keuangan/piutang'); ?>" method="get">
                                <div style="display: flex; align-items: center;">
                                    <input type="date" name="tanggal" class="form-control">
                                    <input type="submit" value="Data per bulan" style="margin-left: 10px;" class="neumorphic-button">
                                </div>
                            </form>
                        </div>
                        <div class="navbar-nav me-auto ms-2">
                            <form action="<?= base_url('keuangan/piutang/pertanggal'); ?>" method="get">
                                <div style="display: flex; align-items: center;">
                                    <input type="date" name="tanggal" class="form-control">
                                    <input type="submit" value="Data per tanggal" style="margin-left: 10px;" class="neumorphic-button">
                                </div>
                            </form>
                        </div>
                        <div class="navbar-nav me-auto ms-2">
                            <a href="<?= base_url('keuangan/piutang') ?>"><button class="float-end neumorphic-button"> Semua Piutang</button></a>
                        </div>
                        <div class="navbar-nav ms-2">
                            <form action="<?= base_url('keuangan/piutang/nama_produk'); ?>" method="post">
                                <div style="display: flex; align-items: center;">
                                    <select name="id_produk" id="id_produk" class="form-control select2" style="width:150px;">
                                        <option value="">Jenis Produk</option>
                                        <?php foreach ($produk as $row) :  ?>
                                            <option value="<?= $row->id_produk ?>"><?= $row->nama_produk; ?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                    <input type="submit" value="Pilih" style="margin-left: 10px;" class="neumorphic-button">
                                </div>
                            </form>
                        </div>
                        <div class="navbar-nav ms-2">
                            <form action="<?= base_url('keuangan/piutang/nama_pelanggan'); ?>" method="post">
                                <div style="display: flex; align-items: center;">
                                    <select name="id_pelanggan" id="id_pelanggan" class="form-control select2" style="width:150px;">
                                        <option value="">Pelanggan</option>
                                        <?php foreach ($pelanggan as $row) :  ?>
                                            <option value="<?= $row->id_pelanggan ?>"><?= $row->nama_pelanggan; ?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                    <input type="submit" value="Pilih" style="margin-left: 10px;" class="neumorphic-button">
                                </div>
                            </form>
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
                            <table class="table table-sm table-bordered" id="example" style="font-size: 0.8rem;">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Tgl Order</th>
                                        <th class="text-center">Jenis Barang</th>
                                        <th class="text-center">Nama Pelanggan</th>
                                        <th class="text-center">Mobil</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center">Nota</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $total_piutang = 0;
                                    foreach ($pesan as $row) :
                                        $tanggal_bayar = date('d-m-y', strtotime($row->tanggal_bayar));
                                        $total_piutang = $row->total_piutang;
                                    ?>
                                        <tr class="text-center">
                                            <td><?= $no++ ?></td>
                                            <!-- <td><?= $row->status_bayar == 0  ? '-' : $tanggal_bayar; ?></td> -->
                                            <td><?= date('d-m-y', strtotime($row->tanggal_pesan)); ?></td>
                                            <td class="text-start"><?= $row->nama_produk; ?></td>
                                            <td class="text-start"><?= ucwords(strtolower($row->nama_pelanggan)); ?></td>
                                            <td class="text-start"><?= ucwords(strtolower($row->nama_mobil)); ?></td>
                                            <td class="text-end"><?= number_format($row->jumlah_pesan, 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($row->harga_barang, 0, ',', '.'); ?></td>
                                            <td class="text-end"><?= number_format($row->total_harga, 0, ',', '.'); ?></td>
                                            <td><?= $row->status_nota == 1 ? '<span class="btn btn-primary btn-sm" style="font-size: 0.7rem;">Ada</span>' : '<span class="btn btn-danger btn-sm" style="font-size: 0.7rem;">Belum</span>'; ?></td>
                                            <td>
                                                <?php
                                                // Ambil waktu saat ini
                                                $current_time = strtotime(date('H:i'));
                                                // Tentukan batas waktu jam 14:00
                                                $deadline_time = strtotime('23:00');
                                                // Cek apakah sudah lewat jam 14:00 
                                                $can_click = $current_time < $deadline_time;
                                                if ($row->status_bayar == 1 && $row->status_nota == 1) {
                                                    $url = "javascript:Swal.fire('Peringatan', 'Barang sudah lunas.', 'warning');";
                                                } else if ($row->status_nota == 0) {
                                                    $url = "javascript:Swal.fire('Peringatan', 'Maaf, Bagian pemasaran belum setor uangnya.', 'warning');";
                                                } else if (!$can_click) {
                                                    $url = "javascript:Swal.fire('Peringatan', 'Maaf, waktu pelunasan sudah lewat jam 14:00 WIB', 'warning');";
                                                } else {
                                                    $url = base_url('keuangan/piutang/pilih_lunas/') . $row->id_pemesanan;
                                                }
                                                ?>
                                                <a href="<?= $url; ?>" style="text-decoration: none;">
                                                    <span class="btn btn-secondary btn-sm" style="font-size: 0.7rem;">Klik Lunas</span>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="9" class="text-end">Jumlah</th>
                                        <th class="text-end"><?= number_format($total_piutang, 0, ',', '.'); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>