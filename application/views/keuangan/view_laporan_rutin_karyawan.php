<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <form action="<?= base_url('keuangan/laporan_rutin_karyawan'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="date" name="tanggal" class="form-control">
                                <input type="submit" value="Tampilkan Data" style="margin-left: 10px;" class="neumorphic-button">
                            </div>
                        </form>
                        <div class="navbar-nav ms-2">
                            <a href="<?= base_url('keuangan/laporan_rutin_karyawan/exportpdf') ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
                        </div>
                        <div class="navbar-nav ms-2">
                            <?php if ($this->session->userdata('nama_pengguna') != 'Wakil Manager' && $this->session->userdata('nama_pengguna') != 'Manager') : ?>
                                <a href="<?= base_url('keuangan/laporan_rutin_karyawan/input_terima_karyawan') ?>" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-rupiah-sign"></i> Input Penerimaan Karyawan</button></a>
                            <?php endif; ?>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <form action="<?= base_url('keuangan/laporan_rutin_karyawan/download'); ?>" method="post">
                                <input type="hidden" name="tanggal" value="<?= date('Y-m-d'); ?>" />
                                <?php if ($this->session->userdata('nama_pengguna') != 'Wakil Manager' && $this->session->userdata('nama_pengguna') != 'Manager') : ?>
                                    <button class="neumorphic-button float-end" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Klik Untuk Download Daftar Rutin Karyawan" id="ambil_data" type="submit" name="ambil_data"><i class="fas fa-fw fa-download"></i>
                                        Download Daftar Rutin Karyawan</button>
                                <?php endif; ?>
                            </form>
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
                            <?php
                            if (empty($bulan_lap)) {
                                $bulan_lap = date('m');
                                $tahun_lap = date('Y');
                            }

                            $bulan = [
                                '01' => 'Januari',
                                '02' => 'Februari',
                                '03' => 'Maret',
                                '04' => 'April',
                                '05' => 'Mei',
                                '06' => 'Juni',
                                '07' => 'Juli',
                                '08' => 'Agustus',
                                '09' => 'September',
                                '10' => 'Oktober',
                                '11' => 'November',
                                '12' => 'Desember',
                            ];

                            $bulan_lap = strtr($bulan_lap, $bulan);

                            ?>
                            <h5>Bulan : <?= $bulan_lap . ' ' . $tahun_lap; ?></h5>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="example" class="table table-hover table-striped table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 0.8rem;">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Bagian</th>
                                    <th class="text-center">Nama Karyawan</th>
                                    <th class="text-center">Galon</th>
                                    <th class="text-center">Gelas 220</th>
                                    <th class="text-center">Botol 330</th>
                                    <th class="text-center">Botol 500</th>
                                    <th class="text-center">Botol 1500</th>
                                    <th class="text-center">Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $total_galon = $total_gelas = $total_btl330 = $total_btl500 = $total_btl1500 = $total_nominal = 0;
                                foreach ($rutin as $row) :
                                    $total_galon += $row->galon;
                                    $total_gelas += $row->gelas;
                                    $total_btl330 += $row->btl330;
                                    $total_btl500 += $row->btl500;
                                    $total_btl1500 += $row->btl1500;
                                    $total_nominal += $row->nominal;
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><?= $row->nama_bagian; ?></td>
                                        <td><?= $row->nama; ?></td>
                                        <td class="text-center"><?= $row->galon == 0 ? '' : $row->galon; ?></td>
                                        <td class="text-center"><?= $row->gelas == 0 ? '' : $row->gelas; ?></td>
                                        <td class="text-center"><?= $row->btl330 == 0 ? '' : $row->btl330; ?></td>
                                        <td class="text-center"><?= $row->btl500 == 0 ? '' : $row->btl500; ?></td>
                                        <td class="text-center"><?= $row->btl1500 == 0 ? '' : $row->btl1500; ?></td>
                                        <td class="text-end"><?= number_format($row->nominal, 0, ',', '.'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Jumlah</td>
                                    <td class="text-center fw-bold"><?= $total_galon; ?></td>
                                    <td class="text-center fw-bold"><?= $total_gelas; ?></td>
                                    <td class="text-center fw-bold"><?= $total_btl330; ?></td>
                                    <td class="text-center fw-bold"><?= $total_btl500; ?></td>
                                    <td class="text-center fw-bold"><?= $total_btl1500; ?></td>
                                    <td class="text-end fw-bold"><?= number_format($total_nominal, 0, ',', '.'); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>