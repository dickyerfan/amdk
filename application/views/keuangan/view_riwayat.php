<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card mb-1">
                <div class="card-header shadow">
                    <!-- <nav class="navbar navbar-light bg-light">
                        <form id="form_tanggal" action="<?= base_url('keuangan/penerimaan'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="submit" value="Pilih Tanggal" class="neumorphic-button">
                                <input type="date" id="tanggal" name="tanggal" class="form-control" style="margin-left: 5px;">
                            </div>
                        </form>
                        <div class="navbar-nav ms-auto">
                            <?php if (!empty($pesan) && isset($pesan[0])) : ?>
                                <?php if ($this->session->userdata('upk_bagian') == 'uang' or $this->session->userdata('nama_pengguna') == 'Wakil Manager') : ?>
                                    <a href="<?= $pesan[0]->status_setor == 0 ? base_url('keuangan/penerimaan/setor_bank') : "javascript:void(0)"; ?>">
                                        <button class="float-end neumorphic-button"><i class="fas fa-bank"></i> Setor Bank</button>
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </nav> -->
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <!-- <div class="row">
                        <div class="col-md-2">
                            <div class=" neumorphic-button">
                                <?php
                                if (!empty($pesan) && isset($pesan[0])) {
                                    if ($pesan[0]->status_setor == 1) {
                                        echo "<span class='text-center fw-bold text-primary'>Sudah Setor </span>";
                                    } else {
                                        echo "<span class='text-center fw-bold text-danger'>Belum Setor </span>";
                                    }
                                } else {
                                    echo "<span class='text-center fw-bold text-success'>Belum ada Penerimaan</span>";
                                }
                                ?>
                            </div>
                        </div>
                    </div> -->
                    <div class="row justify-content-center mb-2">
                        <div class="col-lg-6 text-center">
                            <h5><?= strtoupper($title); ?></h5>
                            <!-- <?php if (empty($tanggal_hari_ini)) {
                                // Jika kosong atau null, atur nilainya menjadi tanggal hari ini
                                $tanggal_hari_ini = date("Y-m-d"); // Format tanggal "YYYY-MM-DD"
                            }
                            // Ubah format tanggal ke bahasa Indonesia
                            setlocale(LC_TIME, 'id_ID');
                            $tanggal_hari_ini = strftime('%e %B %Y', strtotime($tanggal_hari_ini));
                            // Ubah nama bulan menjadi bahasa Indonesia
                            $bulan = [
                                'January' => 'Januari',
                                'February' => 'Februari',
                                'March' => 'Maret',
                                'April' => 'April',
                                'May' => 'Mei',
                                'June' => 'Juni',
                                'July' => 'Juli',
                                'August' => 'Agustus',
                                'September' => 'September',
                                'October' => 'Oktober',
                                'November' => 'November',
                                'December' => 'Desember',
                            ];
                            $tanggal_hari_ini = strtr($tanggal_hari_ini, $bulan);
                            ?>
                            <h5><?= $tanggal_hari_ini; ?></h5> -->
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" id="example" style="font-size: 0.8rem;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nama Pelanggan</th>
                                            <th class="text-center">Alamat Pelanggan</th>
                                            <!-- <th class="text-center">Telpon Pelanggan</th> -->
                                            <th class="text-center">Tarif</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($riwayat as $row) :
                                        ?>
                                            <tr class="text-center">
                                                <td><?= $no++ ?></td>
                                                <td class="text-start"><?= $row->nama_pelanggan; ?></td>
                                                <td class="text-start"><?= $row->alamat_pelanggan; ?></td>
                                                <!-- <td class="text-start"><?= $row->telpon_pelanggan; ?></td> -->
                                                <td class="text-start"><?= $row->tarif; ?></td>
                                                <td class="text-center">
                                                    <a href="<?= base_url('keuangan/riwayat_pembelian/detail/') ?><?= $row->id_pelanggan ?>"><span class="neumorphic-button text-primary btn-sm"><i class="fa-solid fa-circle-info text-primary"></i> Detail</span></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <!-- <tfoot>
                                        <tr>
                                            <th colspan="7" class="text-end">Jumlah</th>
                                            <th class="text-end"><?= number_format($total_penerimaan, 0, ',', '.'); ?></th>
                                        </tr>
                                    </tfoot> -->
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>