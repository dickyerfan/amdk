<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav ustadz">
                    <!-- <a class="nav-link" href="<?= base_url('publik') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-fw fas fa-wallet"></i></div>
                        Beranda
                    </a> -->
                    <a class="nav-link" href="<?= base_url('dashboard') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-fw fas fa-tachometer-alt"></i></div>
                        <div style="font-size: 0.8rem;"> Dashboard</div>
                    </a>

                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#baku" aria-expanded="false" aria-controls="baku">
                        <div class="sb-nav-link-icon"><i class="fa-fw fa fa-file-invoice"></i></div>
                        <div style="font-size: 0.8rem;"> Barang Baku</div>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="baku" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="<?= base_url('barang_baku/stok_barang_baku') ?>" style="font-size: 0.8rem;">Stok Barang Baku</a>
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Transaksi Masuk</a>
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Transaksi Keluar</a>
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Transaksi Barang Rusak</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#produksi" aria-expanded="false" aria-controls="produksi">
                        <div class="sb-nav-link-icon"><i class="fa-fw fa fa-file-invoice"></i></div>
                        <div style="font-size: 0.8rem;"> Barang Produksi</div>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="produksi" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Stok Gudang Produksi</a>
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Transaksi Masuk</a>
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Transaksi Keluar</a>
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Transaksi Barang Lain</a>
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Transaksi Barang Rusak</a>
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Pengembalian Galon</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#jadi" aria-expanded="false" aria-controls="jadi">
                        <div class="sb-nav-link-icon"><i class="fa-fw fa fa-file-invoice"></i></div>
                        <div style="font-size: 0.8rem;"> Barang Jadi</div>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="jadi" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Stok Gudang Jadi</a>
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Transaksi Barang Produksi</a>
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Transaksi Pengirimanan</a>
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Transaksi Barang Rusak</a>
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Tambah Kardus</a>
                        </nav>
                    </div>
                    <!-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#atur" aria-expanded="false" aria-controls="atur">
                        <div class="sb-nav-link-icon"><i class="fa-fw fa fa-laptop"></i></div>
                        <div style="font-size: 0.8rem;"> Pengaturan</div>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a> -->
                    <!-- <div class="collapse" id="atur" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="<?= base_url('admin/pengaturan') ?>" style="font-size: 0.8rem;">Aktivasi Upload/Update</a>
                            <a class="nav-link" href="<?= base_url('admin/pengaturan/aktivasiUser') ?>" style="font-size: 0.8rem;">Aktivasi User</a>
                            <a class="nav-link" href="<?= base_url('admin/pengaturan/kumpul_data') ?>" style="font-size: 0.8rem;">Cek Pengumpulan Data</a>
                        </nav>
                    </div> -->
                    <a class="nav-link" href="<?= base_url('user/admin') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-fw fas fa-user"></i></div>

                        <div style="font-size: 0.8rem;"> Data User</div>
                    </a>
                    <a class="nav-link" href="<?= base_url('backup') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-fw fas fa-database"></i></div>
                        <div style="font-size: 0.8rem;"> Back up</div>
                    </a>
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                        <div class="sb-nav-link-icon"><i class="fa-fw fas fa-sign-out-alt"></i></div>
                        <div style="font-size: 0.8rem;"> Logout</div>
                    </a>

                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small" style="font-size: 0.7rem;">Anda Login sebagai :</div>
                <div class="small" style="font-size: 0.7rem;"><?= $this->session->userdata('nama_pengguna'); ?></div>
            </div>
        </nav>
    </div>