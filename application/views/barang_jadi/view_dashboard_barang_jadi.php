<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <?= $this->session->flashdata('info'); ?>
            <?= $this->session->unset_userdata('info'); ?>
            <div class="card border-0">
                <div class="card-header shadow text-light" style="background: linear-gradient(
                                            45deg,
                                            rgba(0, 0, 0, 0.9),
                                            rgba(0, 0, 0, 0.7) 100%
                                            )">
                    <!-- <h4 class="card-title"><?= strtoupper($title) ?></h4> -->
                    <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                        <span class="title">Selamat Datang <?= $this->session->userdata('nama_lengkap'); ?> di Sistem Aplikasi AMDK PDAM Bondowoso</span>
                    </marquee>
                </div>
                <div class="card-body ">
                    <!-- <img src="<?= base_url('assets/img/ijenWater/carousel5.jpg') ?>" alt="Produk Ijenwater" style="width: 70%;"> -->
                    <div class="row justify-content-center">
                        <div class="col-auto">
                            <div class="shadow cardEffect text-center text-primary fw-bold text-uppercase bg-light border-primary border-start border-end border-3 rounded mb-3 p-2">Hasil Produksi Hari Ini <br><?= date('d-m-Y') ?></div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <?php
                        foreach ($stok_barang as $row) :
                        ?>
                            <div class="col-xl-2 mb-4">
                                <div class="card border-0 bg-primary shadow">
                                    <div class="card-body bg-light cardEffect border-start border-primary border-5 rounded">
                                        <div class="row">
                                            <div class="col-auto">
                                                <a href="#" class="text-decoration-none fw-bold text-light">
                                                    <h6 class="text-primary text-uppercase" style="font-size: 0.7rem;"><?= $row->nama_barang_jadi ?></h6>
                                                    <h6 class="text-primary"><?= $row->total; ?></h6>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-auto">
                            <div class="text-center text-success fw-bold text-uppercase bg-light border-success border-start border-end border-3 rounded mb-3 p-2">Hasil Penjualan Hari Ini</div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <?php
                        foreach ($stok_barang as $row) :
                        ?>
                            <div class="col-xl-2 mb-4">
                                <div class="card border-0 bg-success shadow">
                                    <div class="card-body bg-light cardEffect border-start border-success border-5 rounded">
                                        <div class="row">
                                            <div class="col-auto">
                                                <a href="#" class="text-decoration-none fw-bold text-light">
                                                    <h6 class="text-success text-uppercase" style="font-size: 0.7rem;"><?= $row->nama_barang_jadi ?></h6>
                                                    <h6 class="text-success"><?= $row->total; ?></h6>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-auto">
                            <div class="text-center text-warning fw-bold text-uppercase bg-light border-warning border-start border-end border-3 rounded mb-3 p-2">Hasil Penerimaan Hari Ini</div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <?php
                        foreach ($stok_barang as $row) :
                        ?>
                            <div class="col-xl-2 mb-4">
                                <div class="card border-0 bg-warning shadow">
                                    <div class="card-body bg-light cardEffect border-start border-warning border-5 rounded">
                                        <div class="row">
                                            <div class="col-auto">
                                                <a href="#" class="text-decoration-none fw-bold text-light">
                                                    <h6 class="text-warning text-uppercase" style="font-size: 0.7rem;"><?= $row->nama_barang_jadi ?></h6>
                                                    <h6 class="text-warning"><?= $row->total; ?></h6>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>