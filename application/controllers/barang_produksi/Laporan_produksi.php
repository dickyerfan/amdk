<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_produksi extends CI_Controller
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
        if ($level_pengguna != 'Admin' && $upk_bagian != 'produksi') {
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
        $data['produksi_barang'] = $this->Model_laporan->get_jenis_barang();
        $data['title'] = 'Laporan Produksi Unit AMDK';


        $jumlah_satuan = array();
        $jumlah_liter = array();
        $tanggal_array = array();
        foreach ($data['produksi_barang'] as $row) {
            $id_jenis_barang = $row->id_jenis_barang;
            $tanggal = $row->tanggal_barang_jadi;
            $jumlah_satuan[$id_jenis_barang]['nama_barang_jadi'] = $row->nama_barang_jadi;
            $jumlah_liter[$id_jenis_barang]['nama_barang_jadi'] = $row->nama_barang_jadi;
            $jumlah_satuan[$id_jenis_barang]['barang_jadi'][$tanggal] = $row->jumlah_satuan;
            $jumlah_liter[$id_jenis_barang]['barang_jadi'][$tanggal] = $row->jumlah_liter;
            $tanggal_array[] = $tanggal;
        }

        $data['jumlah_satuan'] = $jumlah_satuan;
        $data['jumlah_liter'] = $jumlah_liter;
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
            $this->load->view('barang_produksi/view_laporan_barang_produksi', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_produksi');
            $this->load->view('templates/pengguna/sidebar_produksi');
            $this->load->view('barang_produksi/view_laporan_barang_produksi', $data);
            $this->load->view('templates/pengguna/footer_produksi');
        }
    }

    public function exportpdf()
    {
        $data['nama_barang'] = $this->Model_laporan->get_nama_barang();
        $data['produksi_barang'] = $this->Model_laporan->get_jenis_barang();
        $data['title'] = 'Laporan Produksi Unit AMDK';


        $jumlah_satuan = array();
        $jumlah_liter = array();
        $tanggal_array = array();
        foreach ($data['produksi_barang'] as $row) {
            $id_jenis_barang = $row->id_jenis_barang;
            $tanggal = $row->tanggal_barang_jadi;
            $jumlah_satuan[$id_jenis_barang]['nama_barang_jadi'] = $row->nama_barang_jadi;
            $jumlah_liter[$id_jenis_barang]['nama_barang_jadi'] = $row->nama_barang_jadi;
            $jumlah_satuan[$id_jenis_barang]['barang_jadi'][$tanggal] = $row->jumlah_satuan;
            $jumlah_liter[$id_jenis_barang]['barang_jadi'][$tanggal] = $row->jumlah_liter;
            $tanggal_array[] = $tanggal;
        }

        $data['jumlah_satuan'] = $jumlah_satuan;
        $data['jumlah_liter'] = $jumlah_liter;
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
        $hari = substr($tanggal, 7, 2);
        $bulan = substr($tanggal, 5, 2);
        $tahun = substr($tanggal, 0, 4);

        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
            $hari = date('d');
            $bulan = date('m');
            $tahun = date('Y');
        }

        $data['tanggal_lap'] = $tanggal;
        $data['hari_lap'] = $hari;
        $data['bulan_lap'] = $bulan;
        $data['tahun_lap'] = $tahun;
        $data['manager'] = $this->Model_laporan->get_manager();
        $data['baku'] = $this->Model_laporan->get_baku();
        $data['produksi'] = $this->Model_laporan->get_produksi();

        // $this->load->library('Dompdf');
        // Set paper size and orientation
        $this->pdf->setPaper('folio', 'landscape');

        // $this->pdf->filename = "Potensi Sr.pdf";
        $this->pdf->filename = "LapProduksi-{$bulan}-{$tahun}.pdf";
        $this->pdf->generate('barang_produksi/laporan_produksi_pdf', $data);
    }

    // public function rekap_tahunan()
    // {
    //     $tahun = $this->input->get('tahun');
    //     if (empty($tahun)) {
    //         $tahun = date('Y');
    //     }

    //     $rekap_data = $this->Model_laporan->get_rekap_tahunan_by_jenis_produk($tahun);

    //     $produk_list = [];     // Menyimpan semua produk unik
    //     $jenis_produk_list = []; // Menyimpan semua jenis produk
    //     $rekap = [];           // Menyimpan rekap data per bulan

    //     foreach ($rekap_data as $row) {
    //         $bulan = (int)$row->bulan;
    //         $produk = $row->nama_produk;
    //         $jenis = $row->jenis_produk;
    //         $jumlah = $row->total_satuan;

    //         $produk_list[$jenis][] = $produk;
    //         $rekap[$bulan][$produk] = $jumlah;
    //     }

    //     // Hapus duplikat produk dalam tiap jenis
    //     foreach ($produk_list as $jenis => $produk_arr) {
    //         $produk_list[$jenis] = array_unique($produk_arr);
    //     }

    //     $data['title'] = "Rekap Produksi Tahun $tahun";
    //     $data['tahun'] = $tahun;
    //     $data['produk_list'] = $produk_list;
    //     $data['rekap'] = $rekap;

    //     if ($this->session->userdata('level') == 'Admin') {
    //         $this->load->view('templates/header', $data);
    //         $this->load->view('templates/navbar');
    //         $this->load->view('templates/sidebar');
    //         $this->load->view('barang_produksi/view_rekap_tahunan', $data);
    //         $this->load->view('templates/footer');
    //     } else {
    //         $this->load->view('templates/pengguna/header', $data);
    //         $this->load->view('templates/pengguna/navbar_produksi');
    //         $this->load->view('templates/pengguna/sidebar_produksi');
    //         $this->load->view('barang_produksi/view_rekap_tahunan', $data);
    //         $this->load->view('templates/pengguna/footer_produksi');
    //     }
    // }

    public function rekap_tahunan()
    {
        $tahun = $this->input->get('tahun');
        if (empty($tahun)) {
            $tahun = date('Y');
        }
        $rekap_data = $this->Model_laporan->get_rekap_tahunan_by_jenis_produk($tahun);
        $produk_list = []; // daftar kolom (jenis_produk)
        $rekap = [];       // isi data rekap per bulan

        foreach ($rekap_data as $row) {
            $bulan = (int)$row->bulan;
            $produk = $row->jenis_produk; // Gunakan jenis_produk sebagai kolom
            $jumlah = $row->total_satuan;

            if (!in_array($produk, $produk_list)) {
                $produk_list[] = $produk;
            }

            if (!isset($rekap[$bulan][$produk])) {
                $rekap[$bulan][$produk] = 0;
            }
            $rekap[$bulan][$produk] += $jumlah;
        }

        $this->session->set_userdata('tahun_export', $tahun);

        $data['title'] = "Rekap Produksi Tahun $tahun";
        $data['tahun'] = $tahun;
        $data['produk_list'] = $produk_list;
        $data['rekap'] = $rekap;

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_produksi/view_rekap_tahunan', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_produksi');
            $this->load->view('templates/pengguna/sidebar_produksi');
            $this->load->view('barang_produksi/view_rekap_tahunan', $data);
            $this->load->view('templates/pengguna/footer_produksi');
        }
    }

    public function export_rekap_tahunan()
    {
        $tahun = $this->session->userdata('tahun_export');
        $rekap_data = $this->Model_laporan->get_rekap_tahunan_by_jenis_produk($tahun);
        $produk_list = []; // daftar kolom (jenis_produk)
        $rekap = [];       // isi data rekap per bulan

        foreach ($rekap_data as $row) {
            $bulan = (int)$row->bulan;
            $produk = $row->jenis_produk; // Gunakan jenis_produk sebagai kolom
            $jumlah = $row->total_satuan;

            if (!in_array($produk, $produk_list)) {
                $produk_list[] = $produk;
            }

            if (!isset($rekap[$bulan][$produk])) {
                $rekap[$bulan][$produk] = 0;
            }
            $rekap[$bulan][$produk] += $jumlah;
        }

        $this->session->set_userdata('tahun_export', $tahun);

        $data['title'] = "Rekap Produksi Tahun $tahun";
        $data['tahun'] = $tahun;
        $data['produk_list'] = $produk_list;
        $data['rekap'] = $rekap;

        $data['manager'] = $this->Model_laporan->get_manager();
        $data['baku'] = $this->Model_laporan->get_baku();
        $data['produksi'] = $this->Model_laporan->get_produksi();

        $this->pdf->setPaper('folio', 'landscape');

        $this->pdf->filename = "rekap_produksi-{$tahun}.pdf";
        $this->pdf->generate('barang_produksi/laporan_rekap_produksi_pdf', $data);
    }
}
