<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <form action="<?= base_url('barang_produksi/barang_jadi'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="date" name="tanggal" class="form-control">
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>
                        <div class="navbar-nav ms-auto">
                            <?php if ($this->session->userdata('upk_bagian') != 'admin') : ?>
                                <a href="<?= base_url('barang_produksi/barang_jadi/upload_galon') ?>"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Proses Galon</button></a>
                            <?php endif; ?>
                        </div>
                        <div class="navbar-nav ms-2">
                            <?php if ($this->session->userdata('upk_bagian') != 'admin') : ?>
                                <a href="<?= base_url('barang_produksi/barang_jadi/upload') ?>"><button class="float-end neumorphic-button"><i class="fas fa-plus"></i> Proses Barang Jadi</button></a>
                            <?php endif; ?>
                        </div>
                    </nav>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center mb-2">
                        <div class="col-lg-6 text-center">
                            <h6><?= strtoupper($title); ?></h6>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <table class="table table-sm table-bordered" id="example">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Nama Barang</th>
                                        <th class="text-center">Jenis Barang</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-center">Input Oleh</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($barang_jadi as $row) : ?>
                                        <tr class="text-center">
                                            <td><?= $no++ ?></td>
                                            <td><?= date('d-m-y', strtotime($row->tanggal_barang_jadi)); ?></td>
                                            <td class="text-start"><?= $row->nama_barang_jadi; ?></td>
                                            <td class="text-start"><?= $row->jenis_barang; ?></td>
                                            <td><?= number_format($row->jumlah_barang_jadi, 0, ',', '.'); ?></td>
                                            <td><?= $row->input_status_barang_jadi; ?></td>
                                            <td><?= $row->status_barang_jadi == 0 ? 'Milik Produksi' : 'Milik Barang jadi' ?></td>
                                            <td>
                                                <?php if ($row->status_barang_produksi == 0) : ?>
                                                    <a href="#" onclick="showAlert(<?= $row->id_barang_jadi ?>)"><span class="neumorphic-button text-primary btn-sm"><i class="fa-solid fa-circle-info text-primary"></i> Proses</span></a>
                                                <?php endif; ?>
                                                <?php if ($row->status_barang_produksi == 1) : ?>
                                                    <a href="#"><span class="neumorphic-button text-success btn-sm"><i class="fa-solid fa-circle-info text-success"></i> Selesai</span></a>
                                                <?php endif; ?>

                                                <script>
                                                    function showAlert(id_barang_jadi) {
                                                        Swal.fire({
                                                            title: 'Konfirmasi',
                                                            text: 'Apakah Anda yakin ingin memproses?',
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonColor: '#3085d6',
                                                            cancelButtonColor: '#d33',
                                                            confirmButtonText: 'Ya, Proses!'
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                // Redirect atau jalankan proses sesuai kebutuhan
                                                                window.location.href = '<?= base_url('barang_produksi/barang_jadi/proses_jadi/') ?>' + id_barang_jadi;
                                                            }
                                                        });
                                                    }
                                                </script>
                                            </td>
                                            <!-- <td>
                                                <?php if ($row->status_barang_jadi == 0) : ?>
                                                    <a href="<?= base_url('barang_produksi/barang_jadi/proses_jadi/') ?><?= $row->id_barang_jadi ?>"><span class="neumorphic-button text-primary btn-sm"><i class="fa-solid fa-circle-info text-primary"></i> Proses</span></a>
                                                <?php endif; ?>
                                                <?php if ($row->status_barang_jadi == 1) : ?>
                                                    <a href="#"><span class="neumorphic-button text-success btn-sm"><i class="fa-solid fa-circle-info text-success"></i> Selesai</span></a>
                                                <?php endif; ?>
                                            </td> -->
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>