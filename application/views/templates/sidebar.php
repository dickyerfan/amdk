<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <a class="nav-link" href="#!">
                        <div style="font-size: 0.8rem;" class="fw-bold"><?= strtoupper($this->session->userdata('nama_pengguna')); ?></div>
                    </a>
                    <a class="nav-link" href="<?= base_url('dashboard') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-fw fas fa-tachometer-alt"></i></div>
                        <div style="font-size: 0.8rem;"> Dashboard</div>
                    </a>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#master_data" aria-expanded="false" aria-controls="master_data">
                        <div class="sb-nav-link-icon"><i class="fa-fw fa fa-users"></i></div>
                        <div style="font-size: 0.8rem;"> Master Data</div>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="master_data" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="<?= base_url('manager/karyawan') ?>" style="font-size: 0.8rem;">Daftar Karyawan</a>
                            <a class="nav-link" href="<?= base_url('manager/mobil') ?>" style="font-size: 0.8rem;">Daftar Mobil</a>
                            <a class="nav-link" href="<?= base_url('manager/harga') ?>" style="font-size: 0.8rem;">Daftar Harga</a>
                            <a class="nav-link" href="<?= base_url('user/admin') ?>" style="font-size: 0.8rem;">Daftar User</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#baku" aria-expanded="false" aria-controls="baku">
                        <div class="sb-nav-link-icon"><i class="fa-fw fa fa-file-invoice"></i></div>
                        <div style="font-size: 0.8rem;"> Barang Baku</div>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="baku" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="<?= base_url('barang_baku/stok_barang_baku') ?>" style="font-size: 0.8rem;">Stok Barang Baku</a>
                            <a class="nav-link" href="<?= base_url('barang_baku/laporan_harian') ?>" style="font-size: 0.8rem;">Laporan Harian</a>
                            <a class="nav-link" href="<?= base_url('barang_baku/laporan_bulanan') ?>" style="font-size: 0.8rem;">Laporan Bulanan</a>
                            <a class="nav-link" href="<?= base_url('barang_baku/barang_masuk') ?>" style="font-size: 0.8rem;">Barang Masuk</a>
                            <a class="nav-link" href="<?= base_url('barang_baku/barang_keluar') ?>" style="font-size: 0.8rem;">Barang Keluar</a>
                            <a class="nav-link" href="<?= base_url('barang_baku/barang_rusak') ?>" style="font-size: 0.8rem;">Barang Rusak</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#produksi" aria-expanded="false" aria-controls="produksi">
                        <div class="sb-nav-link-icon"><i class="fa-fw fa fa-file-invoice"></i></div>
                        <div style="font-size: 0.8rem;"> Barang Produksi</div>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="produksi" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="<?= base_url('barang_produksi/barang_baku_produksi') ?>" style="font-size: 0.8rem;">Stok Gudang Produksi</a>
                            <a class="nav-link" href="<?= base_url('barang_produksi/permintaan_barang_baku') ?>" style="font-size: 0.8rem;">Permintaan Barang Baku</a>
                            <a class="nav-link" href="<?= base_url('barang_produksi/barang_keluar') ?>" style="font-size: 0.8rem;">Barang Jadi</a>
                            <a class="nav-link" href="<?= base_url('barang_produksi/barang_rusak') ?>" style="font-size: 0.8rem;">Barang Rusak</a>
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Transaksi Barang Lain</a>
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
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pasar" aria-expanded="false" aria-controls="pasar">
                        <div class="sb-nav-link-icon"><i class="fa-fw fa fa-file-invoice"></i></div>
                        <div style="font-size: 0.8rem;"> Pemasaran</div>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="pasar" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Stok Gudang Jadi</a>
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Transaksi Barang Produksi</a>
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Transaksi Pengirimanan</a>
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Transaksi Barang Rusak</a>
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Tambah Kardus</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#uang" aria-expanded="false" aria-controls="uang">
                        <div class="sb-nav-link-icon"><i class="fa-fw fa fa-file-invoice"></i></div>
                        <div style="font-size: 0.8rem;"> Keuangan</div>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="uang" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Stok Gudang Jadi</a>
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Transaksi Barang Produksi</a>
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Transaksi Pengirimanan</a>
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Transaksi Barang Rusak</a>
                            <a class="nav-link" href="#" style="font-size: 0.8rem;">Tambah Kardus</a>
                        </nav>
                    </div>
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