<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark logo">
    <!-- Navbar Brand-->
    <img src="<?= base_url('assets/img/ijen.png') ?>" class="navbar-brand ms-3 me-3" style="width:30px ;">
    <a class="navbar-brand title mt-2" href="<?= base_url('dashboard') ?>">
        <h6>S I A A P <br> Ijen Water</h6>
    </a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
        </div>
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ml-auto me-4">
        <li class="nav-item dropdown">
            <a class="nav-link" href="#" id="bellDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-bell" id="bellIcon"></i>
            </a>
            <ul class="dropdown-menu" aria-labelledby="bellDropdown" id="pesanan_baru" style="display: none;">
                <!-- <li><a href="#" class="dropdown-item" style="font-size: 0.8rem;">ada pesan baru</a></li> -->
                <li><a href="<?= base_url('keuangan/piutang') ?>" class="dropdown-item" style="font-size: 0.8rem;">ada penyetoran baru</a></li>
            </ul>
        </li>
    </ul>
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle fw-bold ustadz" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.8rem;"><?= ucfirst($this->session->userdata('nama_lengkap')); ?></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="<?= base_url('password') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-unlock-keyhole fa-fw"></i> Ganti Password</a></li>
                <li><a class="dropdown-item" href="<?= base_url('password/profil') ?>" style="font-size: 0.8rem;"><i class="fa-solid fa-id-card fa-fw"></i> Profil</a></li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item" href="#!" data-bs-toggle="modal" data-bs-target="#logoutModal" style="font-size: 0.8rem;"><i class="fa-solid fa-right-from-bracket fa-fw"></i> Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>