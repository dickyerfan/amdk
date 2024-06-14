<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <a class="nav-link" href="#!">
                        <!-- <div class="sb-nav-link-icon"><i class="fa-fw fas fa-wallet"></i></div> -->
                        <div style="font-size: 0.8rem;" class="fw-bold"><?= strtoupper($this->session->userdata('nama_pengguna')); ?></div>
                    </a>
                    <a class="nav-link" href="<?= base_url('barang_jadi/jadi') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-fw fas fa-tachometer-alt"></i></div>
                        <div style="font-size: 0.8rem;"> Dashboard</div>
                    </a>

                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#transaksi" aria-expanded="false" aria-controls="transaksi">
                        <div class="sb-nav-link-icon"><i class="fa-fw fa fa-cart-shopping"></i></div>
                        <div style="font-size: 0.8rem;"> Transaksi</div>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="transaksi" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="<?= base_url('barang_jadi/stok_barang_jadi') ?>" style="font-size: 0.8rem;">Stok Barang Jadi</a>
                            <!-- <a class="nav-link" href="<?= base_url('barang_jadi/stok_awal_jadi') ?>" style="font-size: 0.8rem;">Stok Awal</a> -->
                            <a class="nav-link" href="<?= base_url('barang_jadi/barang_masuk') ?>" style="font-size: 0.8rem;">Barang Masuk</a>
                            <a class="nav-link" href="<?= base_url('barang_jadi/barang_keluar') ?>" style="font-size: 0.8rem;">Barang Keluar</a>
                            <a class="nav-link" href="<?= base_url('barang_jadi/barang_rusak') ?>" style="font-size: 0.8rem;">Barang Rusak</a>
                            <a class="nav-link" href="<?= base_url('barang_jadi/bon_barang_baku') ?>" style="font-size: 0.8rem;">Bon Barang Baku</a>
                            <a class="nav-link" href="<?= base_url('barang_jadi/pemesanan') ?>" style="font-size: 0.8rem;">Daftar Pemesanan</a>
                        </nav>
                    </div>
                    <a class="nav-link" href="<?= base_url('barang_jadi/daftar_kiriman') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-fw fas fa-truck"></i></div>
                        <div style="font-size: 0.8rem;"> Daftar Kiriman</div>
                    </a>

                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#rutin" aria-expanded="false" aria-controls="rutin">
                        <div class="sb-nav-link-icon"><i class="fa-fw fa fa-user"></i></div>
                        <div style="font-size: 0.8rem;">Rutin Karyawan</div>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="rutin" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="<?= base_url('barang_jadi/rutin_karyawan') ?>" style="font-size: 0.8rem;">Daftar Rutin Karyawan</a>
                            <a class="nav-link" href="<?= base_url('barang_jadi/ambil_rutin_karyawan') ?>" style="font-size: 0.8rem;">Ambil Rutin Karyawan</a>
                            <a class="nav-link" href="<?= base_url('barang_jadi/data_karyawan_keu') ?>" style="font-size: 0.8rem;">Data Kyw untuk Keuangan</a>
                            <a class="nav-link" href="<?= base_url('barang_jadi/tanda_terima_kyw') ?>" style="font-size: 0.8rem;">Tanda Terima Karyawan</a>
                            <a class="nav-link" href="<?= base_url('barang_jadi/lebaran') ?>" style="font-size: 0.8rem;">Bingkisan Lebaran</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#laporan" aria-expanded="false" aria-controls="laporan">
                        <div class="sb-nav-link-icon"><i class="fa-fw fa fa-file-invoice"></i></div>
                        <div style="font-size: 0.8rem;"> Laporan</div>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="laporan" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="<?= base_url('barang_jadi/laporan_barang_jadi') ?>" style="font-size: 0.8rem;">Laporan Barang Jadi</a>
                            <!-- <a class="nav-link" href="" style="font-size: 0.8rem;">Laporan Bulanan</a> -->
                        </nav>
                    </div>

                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                        <div class="sb-nav-link-icon"><i class="fa-fw fas fa-sign-out-alt"></i></div>
                        <div style="font-size: 0.8rem;"> Logout</div>
                    </a>

                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small" style="font-size: 0.7rem;">Anda Login sebagai :</div>
                <div class="small" style="font-size: 0.7rem;">Admin <?= $this->session->userdata('nama_pengguna'); ?></div>
            </div>
        </nav>
    </div>