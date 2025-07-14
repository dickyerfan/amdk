<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penerimaan_kas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_laporan');
        $this->load->model('Model_penerimaan');
        if (!$this->session->userdata('nama_pengguna')) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> Anda harus login untuk akses halaman ini...
                      </div>'
            );
            redirect('auth');
        }

        $level_pengguna = $this->session->userdata('level');
        $upk_bagian = $this->session->userdata('upk_bagian');
        if ($level_pengguna != 'Admin' && $upk_bagian != 'kas') {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Maaf,</strong> Anda tidak memiliki hak akses untuk halaman ini...
                  </div>'
            );
            redirect('auth');
        }
    }

    public function index()
    {
        $data['nama_barang'] = $this->Model_laporan->get_nama_barang();
        $data['lap_terima'] = $this->Model_laporan->get_penerimaan();
        $data['jml_barang'] = $this->Model_laporan->get_jumlah_barang();
        $data['title'] = 'Rekap Laporan Penerimaan AMDK';

        $lap_terima = array();
        $tanggal_array = array();
        foreach ($data['lap_terima'] as $row) {
            $id_jenis_barang = $row->id_jenis_barang;
            $tanggal_lengkap = $row->tanggal_setor;
            $tanggal = date("Y-m-d", strtotime($tanggal_lengkap));
            $lap_terima[$id_jenis_barang]['nama_produk'] = $row->nama_produk;

            if (isset($lap_terima[$id_jenis_barang]['pemesanan'][$tanggal])) {
                $lap_terima[$id_jenis_barang]['pemesanan'][$tanggal] += $row->total_harga;
            } else {
                $lap_terima[$id_jenis_barang]['pemesanan'][$tanggal] = $row->total_harga;
            }

            $tanggal_array[] = $tanggal;
        }
        $data['lap_terima'] = $lap_terima;

        $data['tanggal_array'] = array_unique($tanggal_array);

        // Get the selected month and year, or provide default values
        $selectedMonth = $this->input->get('tanggal');
        if (empty($selectedMonth)) {
            $selectedMonth = date('Y-m'); // Use the current month as default
        }
        // Extract the year and month from the selected date
        list($year, $month) = explode('-', $selectedMonth);

        // Get the number of days in the selected month
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        // Generate an array of date strings for the entire month
        $dateRange = [];
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = "$year-$month-" . sprintf("%02d", $day);
            $dateRange[] = $date;
        }
        // Pass the date range to the view
        $data['dateRange'] = $dateRange;
        $this->session->set_userdata('bulan_exportpdf', $selectedMonth);

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_laporan_penerimaan_kas', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_kas');
            $this->load->view('templates/pengguna/sidebar_kas');
            $this->load->view('keuangan/view_laporan_penerimaan_kas', $data);
            $this->load->view('templates/pengguna/footer_kas');
        }
    }

    public function exportpdf()
    {

        $data['nama_barang'] = $this->Model_laporan->get_nama_barang();
        $data['lap_terima'] = $this->Model_laporan->get_penerimaan();
        $data['jml_barang'] = $this->Model_laporan->get_jumlah_barang();
        $data['title'] = 'Rekap Laporan Penerimaan AMDK';

        $lap_terima = array();
        $tanggal_array = array();
        foreach ($data['lap_terima'] as $row) {
            $id_jenis_barang = $row->id_jenis_barang;
            $tanggal_lengkap = $row->tanggal_setor;
            $tanggal = date("Y-m-d", strtotime($tanggal_lengkap));
            $lap_terima[$id_jenis_barang]['nama_produk'] = $row->nama_produk;

            if (isset($lap_terima[$id_jenis_barang]['pemesanan'][$tanggal])) {
                $lap_terima[$id_jenis_barang]['pemesanan'][$tanggal] += $row->total_harga;
            } else {
                $lap_terima[$id_jenis_barang]['pemesanan'][$tanggal] = $row->total_harga;
            }

            $tanggal_array[] = $tanggal;
        }
        $data['lap_terima'] = $lap_terima;

        $data['tanggal_array'] = array_unique($tanggal_array);


        // Get the selected month and year, or provide default values
        $selectedMonth = $this->session->userdata('bulan_exportpdf');
        if (empty($selectedMonth)) {
            $selectedMonth = date('Y-m'); // Use the current month as default
        }
        // Extract the year and month from the selected date
        list($year, $month) = explode('-', $selectedMonth);

        // Get the number of days in the selected month
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        // Generate an array of date strings for the entire month
        $dateRange = [];
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = "$year-$month-" . sprintf("%02d", $day);
            $dateRange[] = $date;
        }
        // Pass the date range to the view
        $data['dateRange'] = $dateRange;

        $tanggal = $this->session->userdata('bulan_exportpdf');
        $bulan = substr($tanggal, 5, 2);
        $tahun = substr($tanggal, 0, 4);

        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
            $bulan = date('m');
            $tahun = date('Y');
        }

        $data['bulan_lap'] = $bulan;
        $data['tahun_lap'] = $tahun;
        $data['manager'] = $this->Model_laporan->get_manager();
        $data['uang'] = $this->Model_laporan->get_uang();

        // Set paper size and orientation
        $this->pdf->setPaper('folio', 'landscape');

        // $this->pdf->filename = "Potensi Sr.pdf";
        $this->pdf->filename = "Lap_penerimaan_kas_amdk-{$bulan}-{$tahun}.pdf";
        $this->pdf->generate('keuangan/laporan_penerimaan_kas_pdf', $data);
    }

    public function detail_kas()
    {
        $data['title'] = 'Detail Laporan Penerimaan AMDK';
        $tanggal_kas = $this->uri->segment(4);
        $data['detail_terima'] = $this->Model_penerimaan->get_terima_kas($tanggal_kas);
        $data['tanggal_hari_ini'] = $tanggal_kas;

        $grouped_data = [];
        $total_produk = [
            '220ml' => ['jumlah' => 0, 'rupiah' => 0],
            '330ml' => ['jumlah' => 0, 'rupiah' => 0],
            '500ml' => ['jumlah' => 0, 'rupiah' => 0],
            '1500ml' => ['jumlah' => 0, 'rupiah' => 0],
            'galon 19' => ['jumlah' => 0, 'rupiah' => 0],
            'galon kosong' => ['jumlah' => 0, 'rupiah' => 0],
        ];
        $total_semua = 0;

        foreach ($data['detail_terima'] as $item) {
            $nama = $item->nama_pelanggan;
            $produk = strtolower($item->nama_produk);

            if (!isset($grouped_data[$nama])) {
                $grouped_data[$nama] = [
                    '220ml' => ['jumlah' => 0, 'rupiah' => 0],
                    '330ml' => ['jumlah' => 0, 'rupiah' => 0],
                    '500ml' => ['jumlah' => 0, 'rupiah' => 0],
                    '1500ml' => ['jumlah' => 0, 'rupiah' => 0],
                    'galon 19' => ['jumlah' => 0, 'rupiah' => 0],
                    'galon kosong' => ['jumlah' => 0, 'rupiah' => 0],
                    'total' => 0,
                ];
            }

            // Map produk dari nama_produk ke key di array
            $map_nama = [
                'gelas 220ml ijen' => '220ml',
                'gelas 220ml genggong' => '220ml',
                'gelas 220ml an nujum' => '220ml',
                'gelas 220ml syubbanq' => '220ml',
                'gelas 220ml amalis' => '220ml',
                'gelas 220ml ijen merah' => '220ml',
                'botol 330ml ijen' => '330ml',
                'botol 330ml genggong' => '330ml',
                'botol 500ml ijen' => '500ml',
                'botol 500ml amalis' => '500ml',
                'botol 500ml genggong' => '500ml',
                'botol 1500ml ijen' => '1500ml',
                'botol 1500ml amalis' => '1500ml',
                'galon 19l' => 'galon 19',
                'galon kosong' => 'galon kosong',
            ];

            if (isset($map_nama[$produk])) {
                $key = $map_nama[$produk];
                $grouped_data[$nama][$key]['jumlah'] += $item->jumlah_pesan;
                $grouped_data[$nama][$key]['rupiah'] += $item->total_harga;
                $grouped_data[$nama]['total'] += $item->total_harga;

                // Tambahkan juga ke total per produk
                $total_produk[$key]['jumlah'] += $item->jumlah_pesan;
                $total_produk[$key]['rupiah'] += $item->total_harga;

                // Total semua
                $total_semua += $item->total_harga;
            }
        }

        $data['total_produk'] = $total_produk;
        $data['total_semua'] = $total_semua;
        $data['grouped_data'] = $grouped_data;
        $this->session->set_userdata('export_kas_pdf', $tanggal_kas);

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_detail_penerimaan_kas', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_kas');
            $this->load->view('templates/pengguna/sidebar_kas');
            $this->load->view('keuangan/view_detail_penerimaan_kas', $data);
            $this->load->view('templates/pengguna/footer_kas');
        }
    }

    public function export_kas_pdf()
    {
        $data['title'] = 'Laporan Penerimaan AMDK';
        $tanggal_kas = $this->session->userdata('export_kas_pdf');
        $data['detail_terima'] = $this->Model_penerimaan->get_terima_kas($tanggal_kas);
        $data['tanggal_hari_ini'] = $tanggal_kas;

        $grouped_data = [];
        $total_produk = [
            '220ml' => ['jumlah' => 0, 'rupiah' => 0],
            '330ml' => ['jumlah' => 0, 'rupiah' => 0],
            '500ml' => ['jumlah' => 0, 'rupiah' => 0],
            '1500ml' => ['jumlah' => 0, 'rupiah' => 0],
            'galon 19' => ['jumlah' => 0, 'rupiah' => 0],
            'galon kosong' => ['jumlah' => 0, 'rupiah' => 0],
        ];
        $total_semua = 0;

        foreach ($data['detail_terima'] as $item) {
            $nama = $item->nama_pelanggan;
            $produk = strtolower($item->nama_produk);

            if (!isset($grouped_data[$nama])) {
                $grouped_data[$nama] = [
                    '220ml' => ['jumlah' => 0, 'rupiah' => 0],
                    '330ml' => ['jumlah' => 0, 'rupiah' => 0],
                    '500ml' => ['jumlah' => 0, 'rupiah' => 0],
                    '1500ml' => ['jumlah' => 0, 'rupiah' => 0],
                    'galon 19' => ['jumlah' => 0, 'rupiah' => 0],
                    'galon kosong' => ['jumlah' => 0, 'rupiah' => 0],
                    'total' => 0,
                ];
            }

            // Map produk dari nama_produk ke key di array
            $map_nama = [
                'gelas 220ml ijen' => '220ml',
                'gelas 220ml genggong' => '220ml',
                'gelas 220ml an nujum' => '220ml',
                'gelas 220ml syubbanq' => '220ml',
                'gelas 220ml amalis' => '220ml',
                'gelas 220ml ijen merah' => '220ml',
                'botol 330ml ijen' => '330ml',
                'botol 330ml genggong' => '330ml',
                'botol 500ml ijen' => '500ml',
                'botol 500ml amalis' => '500ml',
                'botol 500ml genggong' => '500ml',
                'botol 1500ml ijen' => '1500ml',
                'botol 1500ml amalis' => '1500ml',
                'galon 19l' => 'galon 19',
                'galon kosong' => 'galon kosong',
            ];

            if (isset($map_nama[$produk])) {
                $key = $map_nama[$produk];
                $grouped_data[$nama][$key]['jumlah'] += $item->jumlah_pesan;
                $grouped_data[$nama][$key]['rupiah'] += $item->total_harga;
                $grouped_data[$nama]['total'] += $item->total_harga;

                // Tambahkan juga ke total per produk
                $total_produk[$key]['jumlah'] += $item->jumlah_pesan;
                $total_produk[$key]['rupiah'] += $item->total_harga;

                // Total semua
                $total_semua += $item->total_harga;
            }
        }

        $data['total_produk'] = $total_produk;
        $data['total_semua'] = $total_semua;
        $data['grouped_data'] = $grouped_data;

        $tanggal = $this->session->userdata('bulan_exportpdf');
        $bulan = substr($tanggal, 5, 2);
        $tahun = substr($tanggal, 0, 4);

        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
            $bulan = date('m');
            $tahun = date('Y');
        }

        $data['bulan_lap'] = $bulan;
        $data['tahun_lap'] = $tahun;
        $data['manager'] = $this->Model_laporan->get_manager();
        $data['uang'] = $this->Model_laporan->get_uang();

        // Set paper size and orientation
        $this->pdf->setPaper('folio', 'portrait');

        // $this->pdf->filename = "Potensi Sr.pdf";
        $this->pdf->filename = "Lap_detail_penerimaan_kas_amdk-{$tanggal}.pdf";
        $this->pdf->generate('keuangan/laporan_penerimaan_kas_detail_pdf', $data);
    }
}
