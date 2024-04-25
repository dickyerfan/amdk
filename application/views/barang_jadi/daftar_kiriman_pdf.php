<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMDK | Daftar Pengiriman</title>
    <link href="<?= base_url(); ?>assets/datatables/bootstrap5/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        main {
            font-size: 0.8rem;
        }

        .header p {
            margin: 0;
            font-size: 0.7rem;
            /* Menghilangkan margin pada teks */
        }

        .tandaTangan p {
            font-size: 0.7rem;
        }

        .header img {
            margin-right: 10px;
        }

        hr {
            height: 1px;
            background-color: black !important;
            margin-top: 2px;
            width: 200px;
        }

        .tableUtama,
        .tableUtama thead,
        .tableUtama tr,
        .tableUtama th,
        .tableUtama td {
            border: 1px solid black;
            font-size: 0.5rem;
            padding: 1.5px 3px;
        }

        .judul p {

            margin-bottom: 5px;
            font-size: 0.7rem;
        }
    </style>

</head>

<body>
    <!-- <div class="header">
        <table>
            <tbody class="text_center">
                <tr>
                    <td width="10%">
                        <img src="<?= base_url('assets/img/logo_ijen.png'); ?>" alt="Logo" width="40">
                    </td>
                    <td>
                        <p>PDAM Kabupaten Bondowoso</p>
                        <p>IJEN WATER</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
    </div> -->
    <div class="card-body">
        <div class="row justify-content-center mb-2">
            <div class="col-lg-6 text-center">
                <h5><?= strtoupper($title); ?></h5>
                <?php if (empty($tanggal_hari_ini)) {
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
                <h5><?= $tanggal_hari_ini; ?></h5>
            </div>
        </div>

        <div class="row justify-content-center mb-2">
            <div class="col-lg-7">
                <?php foreach ($total_pesanan as $row) : ?>
                    <div class="card">
                        <div class="card-header text-center">
                            <h5>Total Pengiriman hari ini : <?= $row->total_pesanan == null ? '0' : $row->total_pesanan; ?> barang</h5>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="row justify-content-center">
            <?php if ($daftar_kiriman) : ?>
                <?php foreach ($daftar_kiriman as $mobil) : ?>
                    <div class="col-lg-7">
                        <div class="card mb-2">
                            <div class="card-header">
                                <h5>Mobil : <?= $mobil->nama_mobil; ?> / <?= $mobil->plat_nomor; ?></h5>
                            </div>
                            <div class="card-body">
                                <h5 class="card-text">Daftar Barang :</h5>
                                <div class="table-responsive">
                                    <table class="table table-borderless table-sm">
                                        <thead>
                                            <tr>
                                                <th>Nama Barang</th>
                                                <th></th>
                                                <th>Jumlah</th>
                                                <th>Jenis</th>
                                                <th>Jam</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($mobil->jenis_barang as $barang) : ?>
                                                <tr>
                                                    <td width="40%">
                                                        - <?= ucwords($barang->nama_barang_jadi); ?>
                                                    </td>
                                                    <td>:</td>
                                                    <td>
                                                        <?= $barang->jumlah_pesan; ?>
                                                    </td>
                                                    <td width="30%">
                                                        <?php
                                                        switch ($barang->jenis_pesanan) {
                                                            case 1:
                                                                echo "Kunjungan Rutin";
                                                                break;
                                                            case 2:
                                                                echo "Pesanan Langsung";
                                                                break;
                                                            case 3:
                                                                echo "Bantuan/operasional";
                                                                break;
                                                            case 4:
                                                                echo "Karyawan";
                                                                break;
                                                            default:
                                                                echo "Tidak ada jenis pesanan";
                                                                break;
                                                        }
                                                        $barang->jenis_pesanan;
                                                        ?>
                                                    </td>
                                                    <td><?= $barang->jam_mobil; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <table>
                                        <tbody>
                                            <tr class="fw-bold">
                                                <td width="40%">Total Barang pengiriman Jam 1</td>
                                                <td> :</td>
                                                <td width="20%"><?= $mobil->total_jam_1; ?></td>
                                            </tr>
                                            <tr class="fw-bold">
                                                <td width="40%">Total Barang pengiriman Jam 2</td>
                                                <td> :</td>
                                                <td width="20%"><?= $mobil->total_jam_2; ?></td>
                                            </tr>
                                            <tr class="fw-bold">
                                                <td width="40%">Total Barang pengiriman Jam 3</td>
                                                <td> :</td>
                                                <td width="20%"><?= $mobil->total_jam_3; ?></td>
                                            </tr>

                                            <tr class="fw-bold">
                                                <td>Total semua Barang</td>
                                                <td>:</td>
                                                <td><?= $mobil->total_pemesanan; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-muted">
                                Tanggal Pesan : <?= date('d-m-Y', strtotime($mobil->tanggal_pesan)); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <div class="btn btn-danger shadow">Belum ada data pemesanan yang tersedia.</div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>