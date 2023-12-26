<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none ;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('barang_produksi/pengembalian_galon') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <!-- <?= $this->session->unset_userdata('info'); ?> -->
                </div>
                <div class="card-body">
                    <form class="user" action="" method="POST">
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <div class="form-group mb-2">
                                    <label for="tanggal_kembali">Tanggal Rusak :</label>
                                    <?php
                                    $today = date('Y-m-d');
                                    ?>
                                    <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" value="<?= set_value('tanggal_kembali', $today); ?>" min="<?= $today; ?>" max="<?= $today; ?>">
                                    <small class="form-text text-danger pl-3"><?= form_error('tanggal_kembali'); ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="form-check mb-2">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <input type="text" name="id_jenis_barang" value="Galon Pengembalian" class="form-control mb-2" disabled>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" name="jumlah_rusak" class="form-control mb-2" placeholder="Masukan Jumlah Galon Kembali yang rusak">
                                            <small class="form-text text-danger pl-3"><?= form_error('jumlah_rusak'); ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $tanggal_rusak = date('Y-m-d');
                        $this->db->where('tanggal_kembali', $tanggal_rusak);
                        $query = $this->db->get('galon_kembali');

                        if ($query->num_rows() > 0) {
                            $result = $query->row();

                            if ($result->jumlah_rusak > 0) {
                                // Menampilkan pesan kesalahan dan mengarahkan pengguna kembali
                                $this->session->set_flashdata(
                                    'info',
                                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Maaf,</strong> galon kembali yang rusak sudah di input
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>'
                                );
                                redirect('barang_produksi/pengembalian_galon');
                            } else {
                                echo '<div class="row justify-content-center">
                                <div class="col-md-12 text-center">
                                    <button class="neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-save"></i> Simpan</button>
                                </div>
                                </div>';
                            }
                        }

                        ?>

                    </form>
                </div>
            </div>
        </div>
    </main>