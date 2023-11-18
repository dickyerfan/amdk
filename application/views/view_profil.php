<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid mt-2">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card shadow my-5 border-0">
                        <div class="card-header bg-success ">
                            <h2 class="text-white text-center text-uppercase fw-bold"><?= $title; ?></h2>
                        </div>
                        <div class="card-body">
                            <!-- <img src="..." class="card-img-top"> -->
                            <h5 class="card-title">Nama : <?= $this->session->userdata('nama_lengkap'); ?></h5>
                            <h5 class="card-title">NIK : <?= $this->session->userdata('nik_karyawan'); ?></h5>
                            <h5 class="card-title">Bagian : <?= $this->session->userdata('nama_pengguna'); ?></h5>
                            <h5 class="card-title">Status : <?= ucfirst($this->session->userdata('level')); ?></h5>
                            <h5 class="card-text">Keterangan :</h5>
                            <!-- <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus officiis maiores dolorum minima. Aliquam nostrum culpa vel, et architecto soluta, ipsum delectus incidunt a exercitationem ipsam beatae inventore! Provident, aut?</p> -->
                        </div>
                        <div class="card-footer">
                            <a href="<?php
                                        if ($this->session->userdata('level') == 'Admin') {
                                            echo base_url('dashboard');
                                        } else if ($this->session->userdata('upk_bagian') == 'baku') {
                                            echo base_url('barang_baku/baku');
                                        } else if ($this->session->userdata('upk_bagian') == 'jadi') {
                                            echo base_url('barang_jadi/jadi');
                                        } else if ($this->session->userdata('upk_bagian') == 'produksi') {
                                            echo base_url('barang_produksi/produksi');
                                        } else if ($this->session->userdata('upk_bagian') == 'pasar') {
                                            echo base_url('pemasaran/pasar');
                                        } else if ($this->session->userdata('upk_bagian') == 'uang') {
                                            echo base_url('keuangan/uang');
                                        } else if ($this->session->userdata('upk_bagian') == 'kontrol') {
                                            echo base_url('q_control/kontrol');
                                        }

                                        ?>" class="btn btn-primary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>