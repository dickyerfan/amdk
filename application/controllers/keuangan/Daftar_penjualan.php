<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Daftar_penjualan extends CI_Controller
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
        $bulan = $this->input->get('bulan');
        $tahun = '';
        if (!empty($bulan)) {
            list($tahun, $bulan) = explode('-', $bulan);
        } else {
            $bulan = date('m');
            $tahun = date('Y');
        }
        $data['nama_barang'] = $this->Model_laporan->get_nama_barang();
        $data['penjualan'] = $this->Model_laporan->get_daftar_penjualan($bulan, $tahun);
        $data['title'] = 'Daftar Penjualan Produk AMDK';

        $penjualan = array();
        foreach ($data['penjualan'] as $row) {
            $id_pelanggan = $row->id_pelanggan;
            $id_jenis_barang = $row->id_jenis_barang;
            if (!isset($penjualan[$id_pelanggan])) {
                $penjualan[$id_pelanggan] = [
                    'nama_pelanggan' => $row->nama_pelanggan,
                    'produk' => []
                ];
            }
            if (!isset($penjualan[$id_pelanggan]['produk'][$id_jenis_barang])) {
                $penjualan[$id_pelanggan]['produk'][$id_jenis_barang] = 0;
            }
            $penjualan[$id_pelanggan]['produk'][$id_jenis_barang] += $row->total_pesanan;
        }

        $data['penjualan'] = $penjualan;

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_daftar_penjualan', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_daftar_penjualan', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
    }

    public function detail_penjualan($id_pelanggan)
    {
        $detail_penjualan = $this->Model_laporan->get_detail_penjualan($id_pelanggan);
        $nama_pelanggan = '';
        if (!empty($detail_penjualan)) {
            $nama_pelanggan = $detail_penjualan[0]->nama_pelanggan;
        }
        $data['detail_penjualan'] = $detail_penjualan;
        $data['title'] = 'Detail Penjualan';
        $data['nama_pelanggan'] = $nama_pelanggan;

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_detail_penjualan', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_detail_penjualan', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
    }

    // public function exportpdf()
    // {

    //     $data['nama_barang'] = $this->Model_laporan->get_nama_barang();
    //     $data['penjualan'] = $this->Model_laporan->get_penjualan();
    //     $data['title'] = 'Daftar Penjualan Produk AMDK';

    //     $penjualan = array();
    //     $tanggal_array = array();
    //     foreach ($data['penjualan'] as $row) {
    //         $id_jenis_barang = $row->id_jenis_barang;
    //         $tanggal = $row->tanggal_pesan;
    //         $penjualan[$id_jenis_barang]['nama_produk'] = $row->nama_produk;
    //         $penjualan[$id_jenis_barang]['pemesanan'][$tanggal] = $row->total_pesanan;
    //         $tanggal_array[] = $tanggal;
    //     }

    //     $data['data_jenis_barang'] = $penjualan;
    //     $data['tanggal_array'] = array_unique($tanggal_array);


    //     // Get the selected month and year, or provide default values
    //     // $selectedMonth = $this->input->get('tanggal');
    //     $selectedMonth = $this->session->userdata('bulan_exportpdf');
    //     if (empty($selectedMonth)) {
    //         $selectedMonth = date('Y-m'); // Use the current month as default
    //     }
    //     // Extract the year and month from the selected date
    //     list($year, $month) = explode('-', $selectedMonth);

    //     // Get the number of days in the selected month
    //     $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    //     // Generate an array of date strings for the entire month
    //     $dateRange = [];
    //     for ($day = 1; $day <= $daysInMonth; $day++) {
    //         $date = "$year-$month-" . sprintf("%02d", $day);
    //         $dateRange[] = $date;
    //     }
    //     // Pass the date range to the view
    //     $data['dateRange'] = $dateRange;

    //     $tanggal = $this->session->userdata('bulan_exportpdf');
    //     $bulan = substr($tanggal, 5, 2);
    //     $tahun = substr($tanggal, 0, 4);

    //     if (empty($tanggal)) {
    //         $tanggal = date('Y-m-d');
    //         $bulan = date('m');
    //         $tahun = date('Y');
    //     }

    //     $data['bulan_lap'] = $bulan;
    //     $data['tahun_lap'] = $tahun;
    //     $data['manager'] = $this->Model_laporan->get_manager();
    //     $data['pasar'] = $this->Model_laporan->get_pasar();

    //     // Set paper size and orientation
    //     $this->pdf->setPaper('folio', 'landscape');

    //     // $this->pdf->filename = "Potensi Sr.pdf";
    //     $this->pdf->filename = "LapBulanan-{$bulan}-{$tahun}.pdf";
    //     $this->pdf->generate('pemasaran/laporan_penjualan_pdf', $data);
    // }
}
