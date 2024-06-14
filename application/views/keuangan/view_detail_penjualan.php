<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('keuangan/daftar_penjualan') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                        </div>
                    </nav>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div>
                                <p class="my-0 text-center fw-bold"><?= strtoupper($title) ?></p>
                                <p class="my-0 text-center fw-bold">Nama Pelanggan : <?= $nama_pelanggan ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered" id="example" style="font-size: 0.7rem;">
                            <thead>
                                <tr>
                                    <th class="text-center" style="vertical-align: middle;">No</th>
                                    <th class="text-center" style="vertical-align: middle;">Nama Produk</th>
                                    <th class="text-center" style="vertical-align: middle;">Tanggal Pesan</th>
                                    <th class="text-center" style="vertical-align: middle;">Jumlah Pesan</th>
                                    <th class="text-center" style="vertical-align: middle;">Total Rupiah</th>
                                    <th class="text-center" style="vertical-align: middle;">Status Bayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($detail_penjualan as $detail) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td class="text-start"><?= $detail->nama_produk; ?></td>
                                        <td class="text-center"><?= date('d-m-Y', strtotime($detail->tanggal_pesan)) ?></td>
                                        <td class="text-center"><?= $detail->jumlah_pesan; ?></td>
                                        <td class="text-center"><?= number_format($detail->total_harga, 0, ',', '.'); ?></td>
                                        <td class="text-center"><?= $detail->status_bayar == 1 ? 'Lunas' : 'Hutang'; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>