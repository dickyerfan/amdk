<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <form id="form_bulan" action="<?= base_url('keuangan/piutang'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="submit" value="Per bulan" class="neumorphic-button">
                                <input type="month" id="bulan" name="tanggal" class="form-control" style="margin-left: 5px;">
                            </div>
                        </form>
                        <div class="navbar-nav me-auto ms-2">
                            <form id="form_tanggal" action="<?= base_url('keuangan/piutang/pertanggal'); ?>" method="get">
                                <div style="display: flex; align-items: center;">
                                    <input type="submit" value="per tanggal" class="neumorphic-button">
                                    <input type="date" id="tanggal" name="tanggal" class="form-control" style="margin-left: 5px;">
                                </div>
                            </form>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('keuangan/piutang/export_bulan_all') ?>" target="_blank"><button class="float-end neumorphic-button"> Cetak Piutang</button></a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('keuangan/piutang') ?>"><button class="float-end neumorphic-button"> Semua Piutang</button></a>
                        </div>
                        <div class="navbar-nav ms-2">
                            <form id="form_produk" action="<?= base_url('keuangan/piutang/nama_produk'); ?>" method="post">
                                <div style="display: flex; align-items: center;">
                                    <select name="id_produk" id="id_produk" class="form-control select2" style="width:150px;">
                                        <option value="">Jenis Produk</option>
                                        <?php foreach ($produk as $row) :  ?>
                                            <option value="<?= $row->id_produk ?>"><?= $row->nama_produk; ?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                    <!-- <input type="submit" value="Pilih" style="margin-left: 10px;" class="neumorphic-button"> -->
                                </div>
                            </form>
                        </div>
                        <div class="navbar-nav ms-2">
                            <form id="form_pelanggan" action="<?= base_url('keuangan/piutang/nama_pelanggan'); ?>" method="post">
                                <div style="display: flex; align-items: center;">
                                    <select name="id_pelanggan" id="id_pelanggan" class="form-control select2" style="width:150px;">
                                        <option value="">Pelanggan</option>
                                        <?php foreach ($pelanggan as $row) :  ?>
                                            <option value="<?= $row->id_pelanggan ?>"><?= $row->nama_pelanggan; ?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                    <!-- <input type="submit" value="Pilih" style="margin-left: 10px;" class="neumorphic-button"> -->
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
                            <!-- <?php
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
                            <h5>Bulan : <?= $bulan_lap . ' ' . $tahun_lap; ?></h5> -->
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" id="example" style="font-size: 0.8rem;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <!-- <th class="text-center">Tgl Bayar</th> -->
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
                                                    $jam = time();
                                                    $current_time = date('H:i', $jam);
                                                    // Tentukan batas waktu jam 14:00
                                                    // $deadline_time = strtotime('14:00');
                                                    // Cek apakah sudah lewat jam 14:00 
                                                    $can_click = $current_time < $deadline_time;
                                                    if ($row->status_bayar == 1 && $row->status_nota == 1) {
                                                        $onclick = "Swal.fire('Peringatan', 'Barang sudah lunas.', 'warning');";
                                                    } else if ($row->status_nota == 0) {
                                                        $onclick = "Swal.fire('Peringatan', 'Maaf, Bagian pemasaran belum setor uangnya.', 'warning');";
                                                    } else if (!$can_click) {
                                                        $onclick = "Swal.fire('Peringatan', 'Maaf, waktu pelunasan sudah lewat jam 14:00 WIB', 'warning');";
                                                    } else if ($this->session->userdata('level') == "Admin") {
                                                        $onclick = "Swal.fire('Peringatan', 'Admin tidak bisa proses.', 'warning');";
                                                    } else {
                                                        $onclick = "window.location.href='" . base_url('keuangan/piutang/pilih_lunas/') . $row->id_pemesanan . "';";
                                                    }
                                                    ?>
                                                    <button onclick="<?= $onclick; ?>" class="btn btn-secondary btn-sm" style="font-size: 0.7rem;">Klik Lunas</button>
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
        </div>
    </main>