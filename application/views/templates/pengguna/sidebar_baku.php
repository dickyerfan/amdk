<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav ustadz">
                    <!-- <a class="nav-link" href="<?= base_url('publik') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-fw fas fa-wallet"></i></div>
                        Beranda
                    </a> -->
                    <a class="nav-link" href="<?= base_url('barang_baku/baku') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-fw fas fa-tachometer-alt"></i></div>
                        <div style="font-size: 0.8rem;"> Dashboard</div>
                    </a>

                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#baku" aria-expanded="false" aria-controls="baku">
                        <div class="sb-nav-link-icon"><i class="fa-fw fa fa-warehouse"></i></div>
                        <div style="font-size: 0.8rem;"> Barang Baku</div>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="baku" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="<?= base_url('barang_baku/stok_barang_baku') ?>" style="font-size: 0.8rem;">Stok Barang Baku</a>
                            <a class="nav-link" href="<?= base_url('barang_baku/stok_awal') ?>" style="font-size: 0.8rem;">Data Stok Awal</a>
                            <a class="nav-link" href="<?= base_url('jenis_barang') ?>" style="font-size: 0.8rem;">Jenis Barang</a>
                            <a class="nav-link" href="<?= base_url('satuan') ?>" style="font-size: 0.8rem;">Satuan</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#transaksi" aria-expanded="false" aria-controls="transaksi">
                        <div class="sb-nav-link-icon"><i class="fa-fw fa fa-cart-shopping"></i></div>
                        <div style="font-size: 0.8rem;"> Transaksi</div>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="transaksi" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="<?= base_url('barang_baku/barang_masuk') ?>" style="font-size: 0.8rem;">Barang Masuk</a>
                            <a class="nav-link" href="<?= base_url('barang_baku/barang_keluar') ?>" style="font-size: 0.8rem;">Barang Keluar</a>
                            <a class="nav-link" href="<?= base_url('barang_baku/barang_rusak') ?>" style="font-size: 0.8rem;">Barang Rusak</a>
                        </nav>
                    </div>

                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#laporan" aria-expanded="false" aria-controls="laporan">
                        <div class="sb-nav-link-icon"><i class="fa-fw fa fa-file-invoice"></i></div>
                        <div style="font-size: 0.8rem;"> Laporan</div>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="laporan" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Lapoan Harian</a>
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Laporan Bulanan</a>
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Barang Masuk</a>
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Barang Keluar</a>
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Barang Rusak</a>
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