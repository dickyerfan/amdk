<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_pemakaian_air extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_laporan');
        // $this->load->model('Model_ambil_air');
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
        $tanggal = $this->input->get('tanggal');
        if (empty($tanggal)) {
            $this->session->unset_userdata('session_tanggal');
            $tanggal = date('Y-m-d');
        }else{
            $this->session->set_userdata('session_tanggal', $tanggal);
        }
        // Tentukan rentang tanggal berdasarkan bulan yang dipilih
        $tanggal_awal = date('Y-m-01', strtotime($tanggal));
        $tanggal_akhir = date('Y-m-t', strtotime($tanggal));


        $data['ambil_air'] = $this->Model_laporan->get_ambil_air($tanggal_awal, $tanggal_akhir);
        $data['produksi_air'] = $this->Model_laporan->get_produksi_liter($tanggal_awal, $tanggal_akhir);

        $selectedMonth = $tanggal;
        if (empty($selectedMonth)) {
            $selectedMonth = date('Y-m');
        }
        list($year, $month) = explode('-', $selectedMonth);
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $dateRange = [];
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = "$year-$month-" . sprintf("%02d", $day);
            $dateRange[] = $date;
        }
        $data['dateRange'] = $dateRange;

        $data['title'] = 'Laporan Pemakaian Air AMDK';

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_laporan_pemakaian_air', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_laporan_pemakaian_air', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
    }

    public function exportpdf()
    {
        $tanggal = $this->session->userdata('session_tanggal');
        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
        }
        // Tentukan rentang tanggal berdasarkan bulan yang dipilih
        $tanggal_awal = date('Y-m-01', strtotime($tanggal));
        $tanggal_akhir = date('Y-m-t', strtotime($tanggal));


        $data['ambil_air'] = $this->Model_laporan->get_ambil_air($tanggal_awal, $tanggal_akhir);
        $data['produksi_air'] = $this->Model_laporan->get_produksi_liter($tanggal_awal, $tanggal_akhir);

        $selectedMonth = $tanggal;
        if (empty($selectedMonth)) {
            $selectedMonth = date('Y-m');
        }
        list($year, $month) = explode('-', $selectedMonth);
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $dateRange = [];
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = "$year-$month-" . sprintf("%02d", $day);
            $dateRange[] = $date;
        }
        $data['dateRange'] = $dateRange;

        $data['title'] = 'Laporan Pemakaian Air AMDK';
        $data['tanggal_judul'] = $tanggal;
        $data['manager'] = $this->Model_laporan->get_manager();
        $data['uang'] = $this->Model_laporan->get_uang();

        // Set paper size and orientation
        $this->pdf->setPaper('folio', 'portrait');
        $this->pdf->filename = "Lap_pemakaian_air.pdf";
        // $this->pdf->filename = "Lap_pemakaian_air-{$bulan}-{$tahun}.pdf";
        $this->pdf->generate('keuangan/laporan_pemakaian_air_pdf', $data);
    }

//     public function index()
// {
//     // Ambil tanggal dari GET input, jika ada
//     $tanggal = $this->input->get('tanggal');
//     if (empty($tanggal)) {
//         // Jika tidak ada tanggal dari input, ambil dari session
//         $tanggal = $this->session->userdata('session_tanggal');
//         if (empty($tanggal)) {
//             // Jika session juga kosong, set tanggal saat ini
//             $tanggal = date('Y-m-d');
//         }
//     } else {
//         // Set session dengan tanggal yang dipilih
//         $this->session->set_userdata('session_tanggal', $tanggal);
//     }

//     // Tentukan rentang tanggal berdasarkan bulan yang dipilih
//     $tanggal_awal = date('Y-m-01', strtotime($tanggal));
//     $tanggal_akhir = date('Y-m-t', strtotime($tanggal));

//     $data['ambil_air'] = $this->Model_laporan->get_ambil_air($tanggal_awal, $tanggal_akhir);
//     $data['produksi_air'] = $this->Model_laporan->get_produksi_liter($tanggal_awal, $tanggal_akhir);

//     // Tentukan rentang tanggal untuk digunakan di view
//     list($year, $month) = explode('-', $tanggal);
//     $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

//     $dateRange = [];
//     for ($day = 1; $day <= $daysInMonth; $day++) {
//         $date = "$year-$month-" . sprintf("%02d", $day);
//         $dateRange[] = $date;
//     }
//     $data['dateRange'] = $dateRange;

//     $data['title'] = 'Laporan Pemakaian Air AMDK';

//     // Cek user level untuk menampilkan template yang sesuai
//     if ($this->session->userdata('level') == 'Admin') {
//         $this->load->view('templates/header', $data);
//         $this->load->view('templates/navbar');
//         $this->load->view('templates/sidebar');
//         $this->load->view('keuangan/view_laporan_pemakaian_air', $data);
//         $this->load->view('templates/footer');
//     } else {
//         $this->load->view('templates/pengguna/header', $data);
//         $this->load->view('templates/pengguna/navbar_uang');
//         $this->load->view('templates/pengguna/sidebar_uang');
//         $this->load->view('keuangan/view_laporan_pemakaian_air', $data);
//         $this->load->view('templates/pengguna/footer_uang');
//     }
// }

// public function exportpdf()
// {
//     // Ambil tanggal dari session (yang diset saat memilih di index)
//     $tanggal = $this->session->userdata('session_tanggal');
//     if (empty($tanggal)) {
//         // Jika tidak ada session, set tanggal saat ini
//         $tanggal = date('Y-m-d');
//     }

//     // Tentukan rentang tanggal berdasarkan bulan yang dipilih
//     $tanggal_awal = date('Y-m-01', strtotime($tanggal));
//     $tanggal_akhir = date('Y-m-t', strtotime($tanggal));

//     $data['ambil_air'] = $this->Model_laporan->get_ambil_air($tanggal_awal, $tanggal_akhir);
//     $data['produksi_air'] = $this->Model_laporan->get_produksi_liter($tanggal_awal, $tanggal_akhir);

//     // Tentukan rentang tanggal untuk digunakan di PDF
//     list($year, $month) = explode('-', $tanggal);
//     $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

//     $dateRange = [];
//     for ($day = 1; $day <= $daysInMonth; $day++) {
//         $date = "$year-$month-" . sprintf("%02d", $day);
//         $dateRange[] = $date;
//     }
//     $data['dateRange'] = $dateRange;

//     $data['title'] = 'Laporan Pemakaian Air AMDK';
//     $data['manager'] = $this->Model_laporan->get_manager();
//     $data['uang'] = $this->Model_laporan->get_uang();

//     // Set paper size dan orientasi PDF
//     $this->pdf->setPaper('folio', 'portrait');
//     $this->pdf->filename = "Lap_pemakaian_air.pdf";
//     $this->pdf->generate('keuangan/laporan_pemakaian_air_pdf', $data);
// }


}
