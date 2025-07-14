<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_keuangan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_laporan');
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
        if ($level_pengguna != 'Admin' && $upk_bagian != 'uang') {
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
        $data['lunas'] = $this->Model_laporan->get_lunas();
        $data['piutang'] = $this->Model_laporan->get_piutang();
        $data['title'] = 'Laporan Keuangan AMDK';

        $lunas = array();
        $tanggal_array = array();
        foreach ($data['lunas'] as $row) {
            $id_jenis_barang = $row->id_jenis_barang;
            $tanggal = $row->tanggal_pesan;
            $lunas[$id_jenis_barang]['nama_produk'] = $row->nama_produk;
            $lunas[$id_jenis_barang]['pemesanan'][$tanggal] = $row->total_harga;
            $tanggal_array[] = $tanggal;
        }

        $data['lunas'] = $lunas;

        $piutang = array();
        $tanggal_array = array();
        foreach ($data['piutang'] as $row) {
            $id_jenis_barang = $row->id_jenis_barang;
            $tanggal = $row->tanggal_pesan;
            $piutang[$id_jenis_barang]['nama_produk'] = $row->nama_produk;
            $piutang[$id_jenis_barang]['pemesanan'][$tanggal] = $row->total_harga;
            $tanggal_array[] = $tanggal;
        }

        $data['piutang'] = $piutang;
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
            $this->load->view('keuangan/view_laporan_keuangan', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_laporan_keuangan', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
    }

    public function exportpdf()
    {

        $data['nama_barang'] = $this->Model_laporan->get_nama_barang();
        $data['lunas'] = $this->Model_laporan->get_lunas();
        $data['piutang'] = $this->Model_laporan->get_piutang();
        $data['title'] = 'Laporan Keuangan AMDK';

        $lunas = array();
        $tanggal_array = array();
        foreach ($data['lunas'] as $row) {
            $id_jenis_barang = $row->id_jenis_barang;
            $tanggal = $row->tanggal_pesan;
            $lunas[$id_jenis_barang]['nama_produk'] = $row->nama_produk;
            $lunas[$id_jenis_barang]['pemesanan'][$tanggal] = $row->total_harga;
            $tanggal_array[] = $tanggal;
        }

        $data['lunas'] = $lunas;

        $piutang = array();
        $tanggal_array = array();
        foreach ($data['piutang'] as $row) {
            $id_jenis_barang = $row->id_jenis_barang;
            $tanggal = $row->tanggal_pesan;
            $piutang[$id_jenis_barang]['nama_produk'] = $row->nama_produk;
            $piutang[$id_jenis_barang]['pemesanan'][$tanggal] = $row->total_harga;
            $tanggal_array[] = $tanggal;
        }

        $data['piutang'] = $piutang;
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
        $this->pdf->filename = "LapBulanan-{$bulan}-{$tahun}.pdf";
        $this->pdf->generate('keuangan/laporan_keuangan_pdf', $data);
    }

    public function rekap_tahunan()
    {
        $tahun = $this->input->get('tahun');
        if (empty($tahun)) {
            $tahun = date('Y');
        }

        $rekap_data_total = $this->Model_laporan->get_rekap_tahunan_lap_penjualan_total($tahun);
        $produk_list_total = [];
        $rekap_total = [];

        foreach ($rekap_data_total as $row) {
            $bulan_total = (int)$row->bulan;
            $produk_total = $row->jenis_produk;
            $jumlah_total = $row->total_harga;

            if (!in_array($produk_total, $produk_list_total)) {
                $produk_list_total[] = $produk_total;
            }

            if (!isset($rekap_total[$bulan_total][$produk_total])) {
                $rekap_total[$bulan_total][$produk_total] = 0;
            }
            $rekap_total[$bulan_total][$produk_total] += $jumlah_total;
        }

        $data['title'] = "Rekap Penjualan Tahun $tahun";
        $data['produk_list_total'] = $produk_list_total;
        $data['rekap_total'] = $rekap_total;

        $rekap_data = $this->Model_laporan->get_rekap_tahunan_lap_penjualan($tahun);
        $produk_list = [];
        $rekap = [];

        foreach ($rekap_data as $row) {
            $bulan = (int)$row->bulan;
            $produk = $row->jenis_produk;
            $jumlah = $row->total_harga;

            if (!in_array($produk, $produk_list)) {
                $produk_list[] = $produk;
            }

            if (!isset($rekap[$bulan][$produk])) {
                $rekap[$bulan][$produk] = 0;
            }
            $rekap[$bulan][$produk] += $jumlah;
        }

        $data['title_1'] = "Rekap Penjualan Tahun (Status Lunas) $tahun";
        $data['tahun'] = $tahun;
        $data['produk_list'] = $produk_list;
        $data['rekap'] = $rekap;

        $rekap_data_piutang = $this->Model_laporan->get_rekap_tahunan_lap_penjualan_piutang($tahun);
        $produk_list_piutang = [];
        $rekap_piutang = [];

        foreach ($rekap_data_piutang as $row) {
            $bulan_piutang = (int)$row->bulan;
            $produk_piutang = $row->jenis_produk;
            $jumlah_piutang = $row->total_harga;

            if (!in_array($produk_piutang, $produk_list_piutang)) {
                $produk_list_piutang[] = $produk_piutang;
            }

            if (!isset($rekap_piutang[$bulan_piutang][$produk_piutang])) {
                $rekap_piutang[$bulan_piutang][$produk_piutang] = 0;
            }
            $rekap_piutang[$bulan_piutang][$produk_piutang] += $jumlah_piutang;
        }

        $data['title_2'] = "Rekap Penjualan Tahun (Status Piutang) $tahun";
        $data['produk_list_piutang'] = $produk_list_piutang;
        $data['rekap_piutang'] = $rekap_piutang;

        $this->session->set_userdata('tahun_rekap_penjualan', $tahun);

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_rekap_laporan_keuangan', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_rekap_laporan_keuangan', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
    }
    public function export_rekap_tahunan()
    {
        $tahun = $this->session->userdata('tahun_rekap_penjualan');
        $rekap_data_total = $this->Model_laporan->get_rekap_tahunan_lap_penjualan_total($tahun);
        $produk_list_total = [];
        $rekap_total = [];

        foreach ($rekap_data_total as $row) {
            $bulan_total = (int)$row->bulan;
            $produk_total = $row->jenis_produk;
            $jumlah_total = $row->total_harga;

            if (!in_array($produk_total, $produk_list_total)) {
                $produk_list_total[] = $produk_total;
            }

            if (!isset($rekap_total[$bulan_total][$produk_total])) {
                $rekap_total[$bulan_total][$produk_total] = 0;
            }
            $rekap_total[$bulan_total][$produk_total] += $jumlah_total;
        }

        $data['title'] = "Rekap Penjualan Tahun $tahun";
        $data['produk_list_total'] = $produk_list_total;
        $data['rekap_total'] = $rekap_total;

        $rekap_data = $this->Model_laporan->get_rekap_tahunan_lap_penjualan($tahun);
        $produk_list = [];
        $rekap = [];

        foreach ($rekap_data as $row) {
            $bulan = (int)$row->bulan;
            $produk = $row->jenis_produk;
            $jumlah = $row->total_harga;

            if (!in_array($produk, $produk_list)) {
                $produk_list[] = $produk;
            }

            if (!isset($rekap[$bulan][$produk])) {
                $rekap[$bulan][$produk] = 0;
            }
            $rekap[$bulan][$produk] += $jumlah;
        }

        $data['title_1'] = "Rekap Penjualan Tahun (Status Lunas) $tahun";
        $data['tahun'] = $tahun;
        $data['produk_list'] = $produk_list;
        $data['rekap'] = $rekap;

        $rekap_data_piutang = $this->Model_laporan->get_rekap_tahunan_lap_penjualan_piutang($tahun);
        $produk_list_piutang = [];
        $rekap_piutang = [];

        foreach ($rekap_data_piutang as $row) {
            $bulan_piutang = (int)$row->bulan;
            $produk_piutang = $row->jenis_produk;
            $jumlah_piutang = $row->total_harga;

            if (!in_array($produk_piutang, $produk_list_piutang)) {
                $produk_list_piutang[] = $produk_piutang;
            }

            if (!isset($rekap_piutang[$bulan_piutang][$produk_piutang])) {
                $rekap_piutang[$bulan_piutang][$produk_piutang] = 0;
            }
            $rekap_piutang[$bulan_piutang][$produk_piutang] += $jumlah_piutang;
        }

        $data['title_2'] = "Rekap Penjualan Tahun (Status Piutang) $tahun";
        $data['produk_list_piutang'] = $produk_list_piutang;
        $data['rekap_piutang'] = $rekap_piutang;
        $data['manager'] = $this->Model_laporan->get_manager();
        $data['uang'] = $this->Model_laporan->get_uang();

        $this->pdf->setPaper('folio', 'portrait');

        $this->pdf->filename = "LapRekapPenjualan-{$tahun}.pdf";
        $this->pdf->generate('keuangan/laporan_rekap_penjualan_pdf', $data);
    }
}
