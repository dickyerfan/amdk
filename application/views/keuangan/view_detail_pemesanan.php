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
                            <a href="<?= base_url('keuangan/penjualan') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
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
                    <div class="card p-2">
                        <div class="row justify-content-center">
                            <?php foreach ($detail_pemesanan as $row) : ?>
                                <div class="col-lg-7">
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td>Status Bayar</td>
                                                    <td> : </td>
                                                    <td><?= $row->status_bayar == 0 ? '<span class="btn btn-danger btn-sm">Belum Lunas</span>' : '<span class="btn btn-primary btn-sm">Sudah Lunas</span>'; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Status Setor Bank</td>
                                                    <td> : </td>
                                                    <td><?= $row->status_setor == 0 ? '<span class="btn btn-danger btn-sm me-5">Belum setor</span>' : '<span class="btn btn-success btn-sm">Sudah Setor</span>'; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Nama Pelanggan</td>
                                                    <td> : </td>
                                                    <td><?= $row->nama_pelanggan; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Alamat Pelanggan</td>
                                                    <td> : </td>
                                                    <td><?= $row->alamat_pelanggan; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Jenis Pesanan</td>
                                                    <td> : </td>
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
                                                </tr>
                                                <tr>
                                                    <td>Nama Barang</td>
                                                    <td> : </td>
                                                    <td><?= strtoupper($row->nama_produk); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Jumlah Barang</td>
                                                    <td> : </td>
                                                    <td><?= $row->jumlah_pesan; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Total Harga</td>
                                                    <td> : </td>
                                                    <td>Rp. <?= number_format($row->total_harga, 0, ',', '.'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Tarif</td>
                                                    <td> : </td>
                                                    <td><?= $row->tarif; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Tanggal Transaksi</td>
                                                    <td> : </td>
                                                    <td><?= $row->tanggal_pesan; ?></td>
                                                </tr>

                                                <tr>
                                                    <td>Input Pesanan</td>
                                                    <td> : </td>
                                                    <td><?= $row->input_pesan; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Jenis Mobil</td>
                                                    <td> : </td>
                                                    <td><?= $row->nama_mobil == null ? 'Belum Masuk Mobil' : $row->nama_mobil; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Input Bayar</td>
                                                    <td> : </td>
                                                    <td><?= $row->input_update == null ? '-' : $row->input_update; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Tanggal Setor</td>
                                                    <td> : </td>
                                                    <td><?= $row->tanggal_update; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Penerima Uang</td>
                                                    <td> : </td>
                                                    <td><?= $row->input_bayar == null ? '-' : $row->input_bayar; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Tanggal Bayar</td>
                                                    <td> : </td>
                                                    <td><?= $row->tanggal_bayar; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Ptgs Setor Bank</td>
                                                    <td> : </td>
                                                    <td><?= $row->input_setor == null ? '-' : $row->input_setor; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Tanggal setor</td>
                                                    <td> : </td>
                                                    <td><?= $row->tanggal_setor; ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="card-body">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td class="text-center">Bukti Pembayaran</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <?php if ($row->status_nota == 0 && $row->status_bayar == 1 && $row->input_bayar == 'Administrator') : ?>
                                                        <div class="card bg-light shadow text-dark">
                                                            <div class="card-body">
                                                                <div class="d-flex justify-content-start align-items-center">
                                                                    <img src="<?= base_url('assets/img/ijen.png'); ?>" alt="Logo" style="width: 50px; height: auto; margin-right: 50px;">
                                                                    <div>
                                                                        <h4 class="mb-1">IJEN WATER</h4>
                                                                        <h6 class="mb-1">PDAM Bondowoso</h6>
                                                                    </div>
                                                                    <!-- <small class="text-muted">Nomor: <?= $row->id_pemesanan; ?></small> -->
                                                                </div>
                                                                <hr>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <p class="mb-2"><strong>Nama Pelanggan:</strong></p>
                                                                        <p><?= $row->nama_pelanggan; ?></p>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <p class="mb-2"><strong>Tanggal Transaksi:</strong></p>
                                                                        <p><?= $row->tanggal_pesan; ?></p>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <p class="mb-2"><strong>Nama Produk:</strong></p>
                                                                        <p><?= $row->nama_produk; ?></p>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <p class="mb-2"><strong>Jumlah Pesanan:</strong></p>
                                                                        <p><?= $row->jumlah_pesan; ?></p>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <p class="mb-2"><strong>Total Harga:</strong></p>
                                                                        <p>Rp. <?= number_format($row->total_harga, 0, ',', '.'); ?></p>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <p class="mb-2"><strong>Petugas :</strong></p>
                                                                        <p><?= $row->input_pesan; ?></p>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <span class="btn btn-danger ">LUNAS</span>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <div class="text-center">
                                                                    <p class="mb-0">Terima kasih atas pembayaran Anda</p>
                                                                    <p>Ijen Water <?= date('d-m-Y', strtotime($row->tanggal_pesan)); ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php elseif ($row->status_nota == 0 && $row->status_bayar == 0) : ?>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <h5>Belum ada Nota Pembayaran</h5>
                                                            </div>
                                                        </div>
                                                    <?php else : ?>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <img src="<?= base_url('uploads/pasar/nota/' . $row->nota_beli); ?>" alt="Nota Pembelian" style="width: 100%;">
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                    <!-- <img src="<?= base_url('uploads/pasar/nota/' . $row->nota_beli); ?>" alt="" style="width: 100%;"> -->
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td class="text-center">Bukti Setor</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <img src="<?= base_url('uploads/uang/nota/' . $row->nota_setor); ?>" alt="" style="width: 100%;">
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>