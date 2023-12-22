<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_barang_jadi extends CI_Controller
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
        if ($level_pengguna != 'Admin' && $upk_bagian != 'jadi') {
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
        $data['nama_barang'] = $this->Model_laporan->get_nama_barang_jadi();
        $data['produksi_barang'] = $this->Model_laporan->get_jenis_barang_jadi();
        $data['title'] = 'Laporan Tanda Terima Hasil produksi';


        $data_jenis_barang = array();
        $tanggal_array = array();
        foreach ($data['produksi_barang'] as $row) {
            $id_jenis_barang = $row->id_jenis_barang;
            $tanggal = $row->tanggal_barang_jadi;
            $data_jenis_barang[$id_jenis_barang]['nama_barang_jadi'] = $row->nama_barang_jadi;
            $data_jenis_barang[$id_jenis_barang]['barang_jadi'][$tanggal] = $row->jumlah_barang_jadi;
            $tanggal_array[] = $tanggal;
        }

        $data['data_jenis_barang'] = $data_jenis_barang;
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
            $this->load->view('barang_jadi/view_laporan_barang_jadi', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_jadi');
            $this->load->view('templates/pengguna/sidebar_jadi');
            $this->load->view('barang_jadi/view_laporan_barang_jadi', $data);
            $this->load->view('templates/pengguna/footer_jadi');
        }
    }

    public function exportpdf()
    {

        $data['nama_barang'] = $this->Model_laporan->get_nama_barang();
        $data['produksi_barang'] = $this->Model_laporan->get_jenis_barang();
        $data['title'] = 'Laporan Tanda Terima Hasil Produksi';


        $data_jenis_barang = array();
        $tanggal_array = array();
        foreach ($data['produksi_barang'] as $row) {
            $id_jenis_barang = $row->id_jenis_barang;
            $tanggal = $row->tanggal_barang_jadi;
            $data_jenis_barang[$id_jenis_barang]['nama_barang_jadi'] = $row->nama_barang_jadi;
            $data_jenis_barang[$id_jenis_barang]['barang_jadi'][$tanggal] = $row->jumlah_barang_jadi;
            $tanggal_array[] = $tanggal;
        }

        $data['data_jenis_barang'] = $data_jenis_barang;
        $data['tanggal_array'] = array_unique($tanggal_array);


        // Get the selected month and year, or provide default values
        // $selectedMonth = $this->input->get('tanggal');
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
        $data['tanggal_lap'] = $tanggal;
        $data['bulan_lap'] = $bulan;
        $data['tahun_lap'] = $tahun;
        $data['manager'] = $this->Model_laporan->get_manager();
        $data['jadi'] = $this->Model_laporan->get_jadi();

        // Set paper size and orientation
        $this->pdf->setPaper('A4', 'landscape');

        // $this->pdf->filename = "Potensi Sr.pdf";
        $this->pdf->filename = "LapBarangJadi-{$bulan}-{$tahun}.pdf";
        $this->pdf->generate('barang_jadi/laporan_barang_jadi_pdf', $data);
    }
}
