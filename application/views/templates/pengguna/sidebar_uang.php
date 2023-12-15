<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <a class="nav-link" href="#!">
                        <!-- <div class="sb-nav-link-icon"><i class="fa-fw fas fa-wallet"></i></div> -->
                        <div style="font-size: 0.8rem;" class="fw-bold"><?= strtoupper($this->session->userdata('nama_pengguna')); ?></div>
                    </a>
                    <a class="nav-link" href="<?= base_url('keuangan/uang') ?>">
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
                            <a class="nav-link" href="<?= base_url('keuangan/pelanggan') ?>" style="font-size: 0.8rem;">Daftar Pelanggan</a>
                            <a class="nav-link" href="<?= base_url('keuangan/penjualan') ?>" style="font-size: 0.8rem;">Penjualan</a>
                            <a class="nav-link" href="<?= base_url('keuangan/ban_ops') ?>" style="font-size: 0.8rem;">Bantuan / Operasional</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#rutin" aria-expanded="false" aria-controls="rutin">
                        <div class="sb-nav-link-icon"><i class="fa-fw fa fa-user"></i></div>
                        <div style="font-size: 0.8rem;"> Daftar Rutin Karyawan</div>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="rutin" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="<?= base_url('keuangan/rutin_karyawan') ?>" style="font-size: 0.8rem;">Daftar Rutin Karyawan</a>
                            <a class="nav-link" href="<?= base_url('keuangan/ambil_rutin_karyawan') ?>" style="font-size: 0.8rem;">Ambil Rutin Karyawan</a>
                            <!-- <a class="nav-link" href="<?= base_url('keuangan/laporan_rutin_karyawan') ?>" style="font-size: 0.8rem;">Laporan Rutin Karyawan</a> -->
                        </nav>
                    </div>

                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#karyawan_produksi" aria-expanded="false" aria-controls="karyawan_produksi">
                        <div class="sb-nav-link-icon"><i class="fa-fw fas fa-users"></i></div>
                        <div style="font-size: 0.8rem;"> Karyawan Produksi</div>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="karyawan_produksi" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="<?= base_url('keuangan/karyawan_produksi') ?>" style="font-size: 0.8rem;">Daftar Karyawan Produksi</a>
                            <a class="nav-link" href="<?= base_url('keuangan/karyawan_produksi/absensi_karyawan') ?>" style="font-size: 0.8rem;">Absensi Karyawan</a>
                            <a class="nav-link" href="<?= base_url('keuangan/karyawan_produksi/honor_karyawan') ?>" style="font-size: 0.8rem;">Honor Karyawan</a>
                        </nav>
                    </div>
                    <a class="nav-link" href="<?= base_url('keuangan/pengambilan_air') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-fw fas fa-truck"></i></div>
                        <div style="font-size: 0.8rem;"> Pengambilan Air</div>
                    </a>
                    <a class="nav-link" href="<?= base_url('keuangan/penerimaan') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-fw fas fa-sack-dollar"></i></div>
                        <div style="font-size: 0.8rem;"> Daftar Penerimaan</div>
                    </a>
                    <a class="nav-link" href="<?= base_url('keuangan/piutang') ?>">
                        <div class="sb-nav-link-icon"><i class="fa-fw fas fa-comments-dollar"></i></div>
                        <div style="font-size: 0.8rem;"> Daftar Piutang</div>
                    </a>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#laporan" aria-expanded="false" aria-controls="laporan">
                        <div class="sb-nav-link-icon"><i class="fa-fw fa fa-file-invoice"></i></div>
                        <div style="font-size: 0.8rem;"> Laporan</div>
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="laporan" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="<?= base_url('keuangan/laporan_penerimaan') ?>" style="font-size: 0.8rem;">Laporan Penerimaan</a>
                            <a class="nav-link" href="<?= base_url('keuangan/laporan_keuangan') ?>" style="font-size: 0.8rem;">Laporan Bulanan</a>
                            <a class="nav-link" href="<?= base_url('keuangan/laporan_rutin_karyawan') ?>" style="font-size: 0.8rem;">Laporan Pembelian Karyawan</a>
                            <a class="nav-link" href="<?= base_url('keuangan/laporan_ban_ops') ?>" style="font-size: 0.8rem;">Laporan Bantuan/Operasional</a>
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