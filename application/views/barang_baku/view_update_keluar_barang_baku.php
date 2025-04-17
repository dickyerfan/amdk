<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <!-- <div class="navbar-nav">
                            <a href="<?= base_url('barang_baku/barang_keluar/terima_barang') ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-download"></i> Terima Barang</button></a>
                        </div> -->
                        <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('barang_baku/barang_keluar') ?>"><button class="float-end neumorphic-button"><i class="fas fa-arrow-left"></i> Kembali</button></a>
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
                            <h5><?= strtoupper($title); ?></h5>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="responsive">
                                <table class="table table-sm table-bordered" id="example">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="text-center">No</th>
                                            <th class="text-center">Tgl Transaksi</th>
                                            <th class="text-center">Kode Barang</th>
                                            <th class="text-center">Nama Barang</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($detail_barang_keluar as $row) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no++; ?></td>
                                                <td class="text-center"><?= date('d-m-Y', strtotime($row->tanggal_keluar)); ?></td>
                                                <td><?= $row->kode_barang; ?></td>
                                                <td><?= $row->nama_barang_baku; ?></td>
                                                <td class="text-end"><?= number_format($row->jumlah_keluar, 0, ',', '.'); ?></td>
                                                <td class="text-center"><?= $row->status_keluar == 0 ? 'Belum' : 'Sudah' ?></td>
                                                <td class="text-center">
                                                    <?php if ($row->status_keluar == 0) : ?>
                                                        <a href="<?= base_url('barang_baku/barang_keluar/update_status_keluar_tanggal_sama/' . $row->tanggal_keluar . '/' . $row->bagian) ?>"><span class="neumorphic-button text-primary btn-sm"><i class="fa-solid fa-circle-info text-primary"></i> Proses</span></a>
                                                        <!-- <a href="#" onclick="showAlert(<?= $row->id_keluar_baku ?>)"><span class="neumorphic-button text-primary btn-sm"><i class="fa-solid fa-circle-info text-primary"></i> Proses</span></a> -->
                                                    <?php endif; ?>
                                                    <?php if ($row->status_keluar == 1) : ?>
                                                        <a href="#"><span class="neumorphic-button text-success btn-sm"><i class="fa-solid fa-circle-info text-success"></i> Selesai</span></a>
                                                    <?php endif; ?>

                                                    <script>
                                                        function showAlert(id_keluar_baku) {
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
                                                                    window.location.href = '<?= base_url('barang_baku/barang_keluar/update_status_keluar_tanggal_sama/') ?>' + id_keluar_baku;
                                                                }
                                                            });
                                                        }
                                                    </script>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <form class="user" action="<?= base_url('barang_baku/barang_keluar/terima_barang/') . $row->tanggal_keluar . '/' . $row->bagian ?>" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <input type="hidden" name="tanggal_keluar" id="tanggal_keluar" value="<?= $row->tanggal_keluar; ?>">
                                        <div class="form-group">
                                            <label for="bukti_keluar_gd" class="mb-2">Bukti Pemesanan Barang Baku :</label>
                                            <input type="file" accept="image/*" capture="camera" class="form-control" id="bukti_keluar_gd" name="bukti_keluar_gd" value="<?= set_value('bukti_keluar_gd'); ?>">
                                            <small class="form-text text-danger pl-3"><?= form_error('bukti_keluar_gd'); ?></small>
                                        </div>
                                    </div>
                                </div>
                                <button class="neumorphic-button mt-2" name="tambah" type="submit"><i class="fas fa-edit"></i> Update Barang Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>