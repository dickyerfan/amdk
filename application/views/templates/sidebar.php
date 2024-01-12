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
                            <a class="nav-link" href="<?= base_url('manager/produk') ?>" style="font-size: 0.8rem;">Daftar Produk</a>
                            <a class="nav-link" href="<?= base_url('manager/jenis_barang') ?>" style="font-size: 0.8rem;">Daftar Barang</a>
                            <a class="nav-link" href="<?= base_url('manager/harga') ?>" style="font-size: 0.8rem;">Daftar Harga</a>
                            <a class="nav-link" href="<?= base_url('user/admin') ?>" style="font-size: 0.8rem;">Daftar User</a>
                            <a class="nav-link" href="<?= base_url('manager/pegawai') ?>" style="font-size: 0.8rem;">Daftar Pegawai PDAM</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#baku" aria-expanded="false" aria-controls="baku">
                        <div class="sb-nav-link-icon"><i class="fa-fw fa fa-solid fa-box"></i></div>
                        <div style="font-size: 0.8rem;"> Barang Baku</div>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="baku" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="<?= base_url('barang_baku/stok_barang_baku') ?>" style="font-size: 0.8rem;">Stok Barang Baku</a>
                            <a class="nav-link" href="<?= base_url('barang_baku/stok_awal') ?>" style="font-size: 0.8rem;">Data Stok Awal</a>
                            <a class="nav-link" href="<?= base_url('barang_baku/barang_masuk') ?>" style="font-size: 0.8rem;">Barang Masuk</a>
                            <a class="nav-link" href="<?= base_url('barang_baku/barang_keluar') ?>" style="font-size: 0.8rem;">Barang Keluar</a>
                            <a class="nav-link" href="<?= base_url('barang_baku/barang_rusak') ?>" style="font-size: 0.8rem;">Barang Rusak</a>
                            <a class="nav-link" href="<?= base_url('barang_baku/laporan_harian') ?>" style="font-size: 0.8rem;">Laporan Harian</a>
                            <a class="nav-link" href="<?= base_url('barang_baku/laporan_bulanan') ?>" style="font-size: 0.8rem;">Laporan Bulanan</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#produksi" aria-expanded="false" aria-controls="produksi">
                        <div class="sb-nav-link-icon"><i class="fa-fw fa fa-solid fa-dolly"></i></div>
                        <div style="font-size: 0.8rem;"> Barang Produksi</div>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="produksi" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="<?= base_url('barang_produksi/barang_baku_produksi') ?>" style="font-size: 0.8rem;">Stok Gudang Produksi</a>
                            <a class="nav-link" href="<?= base_url('barang_produksi/permintaan_barang_baku') ?>" style="font-size: 0.8rem;">Permintaan Barang Baku</a>
                            <a class="nav-link" href="<?= base_url('barang_produksi/barang_keluar') ?>" style="font-size: 0.8rem;">Barang Baku Keluar</a>
                            <a class="nav-link" href="<?= base_url('barang_produksi/barang_rusak') ?>" style="font-size: 0.8rem;">Barang Baku Rusak</a>
                            <a class="nav-link" href="<?= base_url('barang_produksi/pengembalian_galon') ?>" style="font-size: 0.8rem;">Pengembalian Galon</a>
                            <a class="nav-link" href="<?= base_url('barang_produksi/barang_jadi') ?>" style="font-size: 0.8rem;">Produksi Barang Jadi</a>
                            <a class="nav-link" href="<?= base_url('barang_produksi/laporan_produksi') ?>" style="font-size: 0.8rem;">Laporan Produksi</a>

                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#jadi" aria-expanded="false" aria-controls="jadi">
                        <div class="sb-nav-link-icon"><i class="fa-fw fa fa-solid fa-box-archive"></i></div>
                        <div style="font-size: 0.8rem;"> Barang Jadi</div>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="jadi" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="<?= base_url('barang_jadi/stok_barang_jadi') ?>" style="font-size: 0.8rem;">Stok Barang Jadi</a>
                            <a class="nav-link" href="<?= base_url('barang_jadi/stok_awal_jadi') ?>" style="font-size: 0.8rem;">Data Stok Awal</a>
                            <a class="nav-link" href="<?= base_url('barang_jadi/barang_masuk') ?>" style="font-size: 0.8rem;">Barang Masuk</a>
                            <a class="nav-link" href="<?= base_url('barang_jadi/barang_keluar') ?>" style="font-size: 0.8rem;">Barang Keluar</a>
                            <a class="nav-link" href="<?= base_url('barang_jadi/barang_rusak') ?>" style="font-size: 0.8rem;">Barang Rusak</a>
                            <a class="nav-link" href="<?= base_url('barang_jadi/bon_barang_baku') ?>" style="font-size: 0.8rem;">Bon Barang Baku</a>
                            <a class="nav-link" href="<?= base_url('barang_jadi/rutin_karyawan') ?>" style="font-size: 0.8rem;">Daftar Rutin Karyawan</a>
                            <a class="nav-link" href="<?= base_url('barang_jadi/ambil_rutin_karyawan') ?>" style="font-size: 0.8rem;">Ambil Rutin Karyawan</a>
                            <a class="nav-link" href="<?= base_url('barang_jadi/laporan_barang_jadi') ?>" style="font-size: 0.8rem;">Laporan Barang Jadi</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pasar" aria-expanded="false" aria-controls="pasar">
                        <div class="sb-nav-link-icon"><i class="fa-fw fa fa-solid fa-truck-fast"></i></div>
                        <div style="font-size: 0.8rem;"> Pemasaran</div>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="pasar" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="<?= base_url('pemasaran/pelanggan') ?>" style="font-size: 0.8rem;">Daftar Pelanggan</a>
                            <a class="nav-link" href="<?= base_url('pemasaran/pemesanan') ?>" style="font-size: 0.8rem;">Pemesanan</a>
                            <a class="nav-link" href="<?= base_url('pemasaran/pemesanan/daftar_kiriman') ?>" style="font-size: 0.8rem;">Daftar Pengiriman</a>
                            <a class="nav-link" href="<?= base_url('pemasaran/laporan_penjualan') ?>" style="font-size: 0.8rem;">Laporan Penjualan</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#uang" aria-expanded="false" aria-controls="uang">
                        <div class="sb-nav-link-icon"><i class="fa-fw fa-solid fa-sack-dollar"></i></div>
                        <div style="font-size: 0.8rem;"> Keuangan</div>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="uang" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="<?= base_url('keuangan/penjualan') ?>" style="font-size: 0.8rem;">Daftar Penjualan</a>
                            <a class="nav-link" href="<?= base_url('keuangan/penerimaan') ?>" style="font-size: 0.8rem;">Daftar Penerimaan</a>
                            <a class="nav-link" href="<?= base_url('keuangan/piutang') ?>" style="font-size: 0.8rem;">Daftar Piutang</a>
                            <a class="nav-link" href="<?= base_url('keuangan/ban_ops') ?>" style="font-size: 0.8rem;">Bantuan/Operasional</a>
                            <a class="nav-link" href="<?= base_url('keuangan/pengambilan_air') ?>" style="font-size: 0.8rem;">Pengambilan Air</a>
                            <a class="nav-link" href="<?= base_url('keuangan/karyawan_produksi') ?>" style="font-size: 0.8rem;">Daftar Karyawan Produksi</a>
                            <a class="nav-link" href="<?= base_url('keuangan/karyawan_produksi/absensi_karyawan') ?>" style="font-size: 0.8rem;">Absensi Karyawan Produksi</a>
                            <a class="nav-link" href="<?= base_url('keuangan/karyawan_produksi/honor_karyawan') ?>" style="font-size: 0.8rem;">Honor Karyawan Produksi</a>
                            <a class="nav-link" href="<?= base_url('keuangan/laporan_penerimaan') ?>" style="font-size: 0.8rem;">Laporan Penerimaan</a>
                            <a class="nav-link" href="<?= base_url('keuangan/laporan_keuangan') ?>" style="font-size: 0.8rem;">Laporan Keuangan</a>
                            <a class="nav-link" href="<?= base_url('keuangan/laporan_rutin_karyawan') ?>" style="font-size: 0.8rem;">Laporan Pembelian Karyawan</a>
                            <a class="nav-link" href="<?= base_url('keuangan/laporan_ban_ops') ?>" style="font-size: 0.8rem;">Laporan Bantuan/Operasional</a>
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