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
                    <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                        <span class="title">Selamat Datang <?= $this->session->userdata('nama_lengkap'); ?> di Sistem Aplikasi AMDK PDAM Bondowoso</span>
                    </marquee>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <img src="<?= base_url('assets/img/ijenWater/carousel5.jpg') ?>" alt="Produk Ijenwater" style="width: 70%;">
                </div>

            </div>
        </div>
    </main>