<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('keuangan/piutang') ?>"><button class="float-end neumorphic-button">Kembali ke Semua Piutang</button></a>
                        </div>
                        <div class="navbar-nav ms-2">
                            <a href="<?= base_url('keuangan/piutang/export_rangking') ?>" target="_blank"><button class="float-end neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Cetak Rangking Piutang</button></a>
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
                            $tanggal_hari_ini = date("Y-m-d");
                            $jam_hari_ini = date("H:i:s");
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
                            <h5>Per Tanggal : <?= $tanggal_hari_ini . ' - ' . $jam_hari_ini; ?> WIB</h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" id="example" style="font-size: 0.8rem;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nama Pelanggan</th>
                                            <th class="text-center">Alamat Pelanggan</th>
                                            <th class="text-center">No Telpon</th>
                                            <th class="text-center">Total Piutang</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($rangking as $row) :
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td class="text-start"><?= ucwords(strtolower($row->nama_pelanggan)); ?></td>
                                                <td class="text-start"><?= ucwords(strtolower($row->alamat_pelanggan)); ?></td>
                                                <td class="text-start"><?= $row->telpon_pelanggan; ?></td>
                                                <td class="text-end"><?= number_format($row->total_piutang, 0, ',', '.') ?></td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $row->id_pelanggan ?>">
                                                        Detail
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4" style="text-align:center">Total Seluruh Piutang:</th>
                                            <th class="text-end"><?= number_format($total_piutang, 0, ',', '.') ?></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <?php foreach ($rangking as $row) : ?>
                                    <div class="modal fade" id="modalDetail<?= $row->id_pelanggan ?>" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Detail Piutang - <?= $row->nama_pelanggan ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-sm table-bordered">
                                                        <thead>
                                                            <tr class="text-center">
                                                                <th>Tanggal</th>
                                                                <th>Produk</th>
                                                                <th>Jumlah</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $total_pelanggan = 0;
                                                            foreach ($detail_piutang[$row->id_pelanggan] as $det) :
                                                                $total_pelanggan += $det->total_harga;
                                                            ?>
                                                                <tr>
                                                                    <td class="text-center"><?= date('d-m-Y', strtotime($det->tanggal_pesan)) ?></td>
                                                                    <td><?= $det->nama_produk ?></td>
                                                                    <td class="text-end"><?= number_format($det->total_harga, 0, ',', '.') ?></td>
                                                                </tr>
                                                            <?php endforeach ?>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="2" class="text-center">Total Piutang</th>
                                                                <th class="text-end"><?= number_format($total_pelanggan, 0, ',', '.') ?></th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>