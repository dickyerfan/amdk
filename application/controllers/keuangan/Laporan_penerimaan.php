<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_penerimaan extends CI_Controller
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
        $data['lap_terima'] = $this->Model_laporan->get_penerimaan();
        $data['jml_barang'] = $this->Model_laporan->get_jumlah_barang();
        $data['title'] = 'Rekap Laporan Penerimaan AMDK';

        $lap_terima = array();
        $tanggal_array = array();
        foreach ($data['lap_terima'] as $row) {
            $id_jenis_barang = $row->id_jenis_barang;
            $tanggal = $row->tanggal_bayar;
            $tanggal = date("Y-m-d", strtotime($tanggal));
            $lap_terima[$id_jenis_barang]['nama_produk'] = $row->nama_produk;
            $lap_terima[$id_jenis_barang]['pemesanan'][$tanggal] = $row->total_harga;
            $tanggal_array[] = $tanggal;
        }
        $data['lap_terima'] = $lap_terima;

        $jml_barang = array();
        $tanggal_array = array();
        foreach ($data['jml_barang'] as $row) {
            $id_jenis_barang = $row->id_jenis_barang;
            $tanggal = $row->tanggal_bayar;
            $tanggal = date("Y-m-d", strtotime($tanggal));
            $jml_barang[$id_jenis_barang]['nama_produk'] = $row->nama_produk;
            $jml_barang[$id_jenis_barang]['pemesanan'][$tanggal] = $row->total_barang;
            $tanggal_array[] = $tanggal;
        }
        $data['jml_barang'] = $jml_barang;


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

        if ($this->session->userdata('upk_bagian') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_laporan_penerimaan', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_laporan_penerimaan', $data);
            $this->load->view('templates/pengguna/footer');
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
}
