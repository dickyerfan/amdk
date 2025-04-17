<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <nav class="navbar navbar-light bg-light">
                        <form action="<?= base_url('keuangan/pengambilan_air'); ?>" method="get">
                            <div style="display: flex; align-items: center;">
                                <input type="submit" value="Pilih Tanggal" class="neumorphic-button">

                                <!-- Input untuk tanggal mulai -->
                                <label for="tanggal_mulai" style="margin-left: 10px;">Dari:</label>
                                <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="form-control" style="margin-left: 5px;">

                                <!-- Input untuk tanggal selesai -->
                                <label for="tanggal_selesai" style="margin-left: 10px;">Sampai:</label>
                                <input type="date" id="tanggal_selesai" name="tanggal_selesai" class="form-control" style="margin-left: 5px;">
                            </div>
                        </form>
                        <div class="navbar-nav ms-2">
                            <a href="<?= base_url('keuangan/pengambilan_air/exportpdf') ?>" target="_blank" style="font-size: 0.8rem; color:black;"><button class="neumorphic-button"><i class="fa-solid fa-file-pdf"></i> Export PDF</button></a>
                        </div>
                        <div class="navbar-nav ms-auto">
                            <a href="<?= base_url('keuangan/pengambilan_air/tambah'); ?>"><button class=" neumorphic-button float-end"><i class="fas fa-plus"></i> Pengambilan air</button></a>
                        </div>
                    </nav>

                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <!-- <div class="form-group mb-1">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" id="searchInput" class="form-control" placeholder="Cari data pelanggan...">
                            </div>
                        </div>
                    </div> -->
                    <!-- <div>
                        <p class="my-0 text-center"><?= strtoupper($title) ?></p>
                        <?php
                        $tanggal = $this->input->get('tanggal');
                        if (empty($tanggal)) {
                            $bulan = date('m');
                            $tahun = date('Y');
                            $bulanLap = date('m');
                            $tahunLap = date('Y');
                        } else {
                            list($tahun, $bulan, $hari) = explode('-', $tanggal);
                            list($tahunLap, $bulanLap, $hariLap) = explode('-', $tanggal);
                            $bulan = str_pad($bulan, 2, '0', STR_PAD_LEFT);
                        }
                        $bulanLap = [
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
                        ?>
                        <p class="mu-0 text-center">Bulan : <?= $bulanLap[$bulan] . ' ' . $tahunLap ?></p>
                    </div> -->
                    <div>
                        <p class="my-0 text-center fw-bold"><?= strtoupper($title) ?></p>
                        <?php
                        // Mendapatkan nama bulan untuk tanggal awal dan akhir
                        $tanggalAwal = $start_date->format('d');
                        $bulanAwal = $start_date->format('m');
                        $tahunAwal = $start_date->format('Y');
                        $tanggalAkhir = $end_date->format('d');
                        $bulanAkhir = $end_date->format('m');
                        $tahunAkhir = $end_date->format('Y');

                        // Daftar bulan
                        $bulanLap = [
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

                        // Menampilkan periode
                        if ($tahunAwal === $tahunAkhir) {
                            // Jika tahun sama, hanya tampilkan tahun sekali
                            echo '<p class="my-0 text-center">Periode : ' . $tanggalAwal . ' ' . $bulanLap[$bulanAwal] . ' - ' . $tanggalAkhir . ' ' . $bulanLap[$bulanAkhir] . ' ' . $tahunAwal . '</p>';
                        } else {
                            // Jika tahun berbeda, tampilkan tahun untuk masing-masing bulan
                            echo '<p class="my-0 text-center">Periode : ' . $tanggalAwal . ' ' . $bulanLap[$bulanAwal] . ' ' . $tahunAwal . ' - ' . $tanggalAkhir . ' ' . $bulanLap[$bulanAkhir] . ' ' . $tahunAkhir . '</p>';
                        }
                        ?>
                    </div>
                    <div class="table-responsive">
                        <table id="example2" class="table table-hover table-striped table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 0.8rem;">
                            <thead>
                                <tr class="bg-secondary text-center">
                                    <th>No</th>
                                    <th>Hari</th>
                                    <th>Tanggal Ambil</th>
                                    <th>Nama Petugas</th>
                                    <th>Waktu</th>
                                    <th>Stand Awal</th>
                                    <th>Stand Akhir</th>
                                    <th>BBM</th>
                                    <th>Ket</th>
                                    <th>Input/update Oleh</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                function ganti_hari($day)
                                {
                                    $days = array(
                                        'Sunday' => 'Minggu',
                                        'Monday' => 'Senin',
                                        'Tuesday' => 'Selasa',
                                        'Wednesday' => 'Rabu',
                                        'Thursday' => 'Kamis',
                                        'Friday' => 'Jumat',
                                        'Saturday' => 'Sabtu'
                                    );

                                    return $days[$day];
                                }
                                $no = 1;
                                foreach ($ambil_air as $row) :
                                    setlocale(LC_TIME, 'id_ID');
                                    $tanggal_hari_ini = strftime('%e %B %Y', strtotime($row->tanggal_ambil_air));
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

                                    $hari = date('l', strtotime($row->tanggal_ambil_air));
                                    $hari_indo = ganti_hari($hari);

                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td class="text-center"><?= $hari_indo; ?></td>
                                        <td><?= $tanggal_hari_ini; ?></td>
                                        <td><?= $row->nama_karyawan; ?></td>
                                        <td class="text-center"><?= $row->waktu; ?></td>
                                        <td class="text-center"><?= $row->stand_lalu; ?></td>
                                        <td class="text-center"><?= $row->stand_meter; ?></td>
                                        <td class="text-center"><?= number_format($row->bbm, 0, ',', '.'); ?></td>
                                        <td class="text-center"><?= $row->ket == true ? $row->ket . ' liter' : ''; ?></td>
                                        <td class="text-center"><?= $row->input_truk_tangki; ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url(); ?>keuangan/pengambilan_air/edit/<?= $row->id_truk; ?>"><i class="fas fa-fw fa-edit" style="color: green;"></i></a>
                                            <a href="<?= base_url(); ?>keuangan/pengambilan_air/hapus/<?= $row->id_truk; ?>" class="tombolHapus"><i class=" fas fa-fw fa-trash" style="color:red;"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>