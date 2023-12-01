<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <a class="nav-link" href="#!">
                        <!-- <div class="sb-nav-link-icon"><i class="fa-fw fas fa-wallet"></i></div> -->
                        <div style="font-size: 0.8rem;" class="fw-bold"><?= strtoupper($this->session->userdata('nama_pengguna')); ?></div>
                    </a>
                    <a class="nav-link" href="<?= base_url('pemasaran/pasar') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-fw fas fa-tachometer-alt"></i></div>
                        <div style="font-size: 0.8rem;"> Dashboard</div>
                    </a>
                    <a class="nav-link" href="<?= base_url('pemasaran/stok_barang_jadi') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-fw fas fa-warehouse"></i></div>
                        <div style="font-size: 0.8rem;"> Stok Barang Jadi</div>
                    </a>

                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#transaksi" aria-expanded="false" aria-controls="transaksi">
                        <div class="sb-nav-link-icon"><i class="fa-fw fa fa-cart-shopping"></i></div>
                        <div style="font-size: 0.8rem;"> Transaksi</div>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="transaksi" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="<?= base_url('pemasaran/pelanggan') ?>" style="font-size: 0.8rem;">Daftar Pelanggan</a>
                            <a class="nav-link" href="<?= base_url('pemasaran/pemesanan') ?>" style="font-size: 0.8rem;">Pemesanan</a>
                            <a class="nav-link" href="<?= base_url('pemasaran/pemesanan/daftar_kiriman') ?>" style="font-size: 0.8rem;">Daftar Pengiriman</a>
                            <a class="nav-link" href="<?= base_url('pemasaran/pemesanan/barang_karyawan') ?>" style="font-size: 0.8rem;">Daftar Barang Karyawan</a>
                        </nav>
                    </div>

                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#laporan" aria-expanded="false" aria-controls="laporan">
                        <div class="sb-nav-link-icon"><i class="fa-fw fa fa-file-invoice"></i></div>
                        <div style="font-size: 0.8rem;"> Laporan</div>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="laporan" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="<?= base_url('pemasaran/laporan_penjualan') ?>" style="font-size: 0.8rem;">Laporan Bulanan</a>
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