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
                        <span class="title">Selamat Datang <?= $this->session->userdata('nama_lengkap'); ?> di Aplikasi AMDK Bondowoso</span>
                    </marquee>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <img src="<?= base_url('assets/img/ijenWater/carousel5.jpg') ?>" alt="Produk Ijenwater" style="width: 70%;">
                </div>
                <!-- <div class="card-body d-flex align-items-center justify-content-center">
                    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="<?= base_url('assets/img/ijenWater/carousel5.jpg') ?>" alt="Slide 1" class="d-block mx-auto" style="max-width: 70%;">
                            </div>
                            <div class="carousel-item">
                                <img src="<?= base_url('assets/img/ijenWater/carousel2.jpg') ?>" alt="Slide 2" class="d-block mx-auto" style="max-width: 70%;">
                            </div>
                            <div class="carousel-item">
                                <img src="<?= base_url('assets/img/ijenWater/carousel3.jpg') ?>" alt="Slide 3" class="d-block mx-auto" style="max-width: 70%;">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExample" role="button" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExample" role="button" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </a>
                    </div>
                </div> -->
            </div>
        </div>
    </main>