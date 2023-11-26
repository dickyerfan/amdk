<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <!-- <div class="navbar-nav">
                            <a href="<?= base_url('rkap/usulan_inves/export_pdf') ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
                        </div> -->
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
                        <div class="col-lg-6 text-center">
                            <h5><?= strtoupper($title); ?></h5>
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
                                                        echo 'Operasional';
                                                    } ?>
                                                </td>
                                                <td><?= $row->nama_mobil; ?></td>
                                                <!-- <td></td> -->
                                                <td><?= $row->status_nota == 1 ? '<span class="btn btn-primary btn-sm" style="font-size: 0.7rem;">Setor</span>' : '<span class="btn btn-danger btn-sm" style="font-size: 0.7rem;">Belum</span>'; ?></td>
                                                <td><?= $row->status_bayar == 1 ? '<span class="btn btn-primary btn-sm" style="font-size: 0.7rem;">Lunas</span>' : '<span class="btn btn-danger btn-sm" style="font-size: 0.7rem;">Belum</span>'; ?></td>
                                                <td>
                                                    <a href="<?= $row->id_mobil == null ? base_url('pemasaran/pemesanan/pilih_mobil/') : "javascript:void(0)" ?><?= $row->id_pemesanan; ?>"><i class="fas fa-truck text-success" data-bs-toggle="tooltip" data-bs-placement="top" title="klik untuk pilih Mobil"></i></a>
                                                    <a href="<?= $row->status_nota == 0 ? base_url('pemasaran/pemesanan/upload_nota/') : "javascript:void(0)" ?><?= $row->id_pemesanan ?>"><i class="fa-solid fa-square-poll-horizontal text-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="klik untuk upload nota"></i></a>
                                                    <a href="<?= base_url('pemasaran/pemesanan/detail/') ?><?= $row->id_pemesanan ?>"><i class="fa-solid fa-circle-info text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="klik lihat detail pemesanan"></i></a>
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