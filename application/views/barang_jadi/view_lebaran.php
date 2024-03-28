<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <form id="form_tanggal" action="<?= base_url('barang_jadi/lebaran'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="submit" value="Pilih Tahun" class="neumorphic-button">
                                <input type="date" id="tanggal" name="tanggal" class="form-control" style="margin-left: 10px;">
                            </div>
                        </form>
                        <div class="navbar-nav ms-auto">
                            <?php if ($this->session->userdata('upk_bagian') != 'admin') : ?>
                                <a href="<?= base_url('barang_jadi/lebaran/tambah') ?>"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Tambah Inputan</button></a>
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
                            <?php
                            if (empty($bulan_lap)) {
                                $tahun_lap = date('Y');
                            }
                            ?>
                            <h5>Tahun : <?= $tahun_lap; ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" id="example">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Uraian</th>
                                            <th class="text-center">Jumlah Orang</th>
                                            <th class="text-center">Nama Barang</th>
                                            <th class="text-center">Jumlah Satuan</th>
                                            <th class="text-center">Jumlah total</th>
                                            <th class="text-center">Rupiah</th>
                                            <th class="text-center">Input Oleh</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $total = 0;
                                        foreach ($lebaran as $row) :
                                            $jumlah_total = $row->jumlah_orang * $row->jumlah_barang;
                                            $total += $jumlah_total;
                                        ?>
                                            <tr class="text-center">
                                                <td><?= $no++ ?></td>
                                                <td class="text-start"><?= $row->nama_pelanggan; ?></td>
                                                <td><?= $row->jumlah_orang; ?></td>
                                                <td class="text-start"><?= strtoupper($row->nama_produk); ?></td>
                                                <td><?= $row->jumlah_barang; ?></td>
                                                <td><?= $jumlah_total; ?></td>
                                                <td class="text-end"><?= number_format($row->harga_lebaran, 0, ',', '.'); ?></td>
                                                <td><?= $row->input_lebaran; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <!-- <tr>
                                            <th colspan="4" class="text-center">Total</th>
                                            <th class="text-center"><?= $row->total_barang; ?></th>
                                            <th class="text-center"><?= $total; ?></th>
                                            <th class="text-end"><?= number_format($row->total_harga, 0, ',', '.'); ?></th>
                                            <th></th>
                                        </tr> -->

                                        <?php if (empty($lebaran)) : ?>
                                            <tr>
                                                <td colspan="8" class="text-center"></td>
                                            </tr>
                                        <?php else : ?>
                                            <?php foreach ($lebaran as $row) :
                                            ?>
                                            <?php endforeach; ?>
                                            <tr>
                                                <th colspan="4" class="text-center">Total</th>
                                                <?php if (!empty($row->total_barang)) : ?>
                                                    <th class="text-center"><?= $row->total_barang; ?></th>
                                                <?php else : ?>
                                                    <th class="text-center">0</th>
                                                <?php endif; ?>
                                                <th class="text-center"><?= $total; ?></th>
                                                <?php if (!empty($row->total_harga)) : ?>
                                                    <th class="text-end"><?= number_format($row->total_harga, 0, ',', '.'); ?></th>
                                                <?php else : ?>
                                                    <th class="text-end">0</th>
                                                <?php endif; ?>
                                                <th></th>
                                            </tr>
                                        <?php endif; ?>

                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>