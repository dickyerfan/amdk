<div id="layoutSidenav_content" class="latar">
    <main>
        <div class="container-fluid px-2 mt-2">
            <div class="card">
                <div class="card-header shadow">
                    <a class="fw-bold text-dark" style="text-decoration:none;"><?= strtoupper($title) ?></a>
                    <a href="<?= base_url('barang_produksi/karyawan_produksi/tambah_absen'); ?>">
                        <button class="neumorphic-button float-end">
                            <i class="fas fa-plus"></i> Input Absen
                        </button>
                    </a>
                </div>
                <div class="p-2">
                    <?= $this->session->flashdata('info'); ?>
                    <?= $this->session->unset_userdata('info'); ?>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-auto">
                            <?php
                            $uniqueDates = array_unique(array_column($absen_karProd, 'tanggal')); // ini fungsinya untuk memilih 1 tanggal saja yang tampil
                            $uniqueDates = array_filter($uniqueDates, function ($date) {
                                return $date !== '1970-01-01' && strtotime($date) > 0;
                            });
                            sort($uniqueDates);
                            ?>
                            <table class="table table-bordered table-sm" style="font-size: 0.8rem;">
                                <thead>
                                    <tr>
                                        <th>Nama Karyawan</th>
                                        <?php foreach ($uniqueDates as $tanggal) : ?>
                                            <th><?= date('d', strtotime($tanggal)); ?></th>
                                        <?php endforeach; ?>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data_karyawan as $namaKaryawan => $absen) : ?>
                                        <tr>
                                            <td><?= $namaKaryawan; ?></td>
                                            <?php $totalHadir = 0; ?>
                                            <?php foreach ($uniqueDates as $tanggal) : ?>
                                                <?php
                                                $hadir = isset($absen[$tanggal]) ? $absen[$tanggal] : '0';
                                                $totalHadir += intval($hadir);
                                                echo '<td>' . $hadir . '</td>';
                                                ?>
                                            <?php endforeach; ?>
                                            <td class="text-center"><?= $totalHadir; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>Jumlah Hadir</td>
                                        <?php foreach ($uniqueDates as $tanggal) : ?>
                                            <?php
                                            $totalHadir = 0;
                                            foreach ($data_karyawan as $absen) {
                                                $hadir = isset($absen[$tanggal]) ? $absen[$tanggal] : '0';
                                                $totalHadir += intval($hadir);
                                            }
                                            echo '<td>' . $totalHadir . '</td>';
                                            ?>
                                        <?php endforeach; ?>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto">
                            <p>Total Hasil Produksi</p>
                            <?php
                            $uniqueDates = array_unique(array_column($produksi_barang, 'tanggal_barang_jadi')); // ini fungsinya untuk memilih 1 tanggal saja yang tampil
                            $uniqueDates = array_filter($uniqueDates, function ($date) {
                                return $date !== '1970-01-01' && strtotime($date) > 0;
                            });
                            sort($uniqueDates);
                            ?>
                            <table class="table table-bordered table-sm" style="font-size: 0.8rem;">
                                <thead>
                                    <tr>
                                        <th>Jenis Barang Jadi</th>
                                        <?php foreach ($uniqueDates as $tanggal) : ?>
                                            <th><?= date('d', strtotime($tanggal)); ?></th>
                                        <?php endforeach; ?>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data_jenis_barang as $jenisBarang => $jumlah_barang) : ?>
                                        <tr>
                                            <td><?= $jenisBarang; ?></td>
                                            <?php $totalJumlah = 0; ?>
                                            <?php foreach ($uniqueDates as $tanggal) : ?>
                                                <?php
                                                $jumlah = isset($jumlah_barang[$tanggal]) ? $jumlah_barang[$tanggal] : '0';
                                                $totalJumlah += intval($jumlah);
                                                echo '<td>' . $jumlah . '</td>';
                                                ?>
                                            <?php endforeach; ?>
                                            <td class="text-center"><?= $totalJumlah; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>Jumlah</td>
                                        <?php foreach ($uniqueDates as $tanggal) : ?>
                                            <?php
                                            $totalHadir = 0;
                                            foreach ($data_jenis_barang as $jumlah_barang) {
                                                $hadir = isset($jumlah_barang[$tanggal]) ? $jumlah_barang[$tanggal] : '0';
                                                $totalHadir += intval($hadir);
                                            }
                                            echo '<td>' . $totalHadir . '</td>';
                                            ?>
                                        <?php endforeach; ?>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>