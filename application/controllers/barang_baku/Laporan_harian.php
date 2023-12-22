<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_harian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_laporan');
        date_default_timezone_set('Asia/Jakarta');

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
        if ($level_pengguna != 'Admin' && $upk_bagian != 'baku') {
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
            $tanggal = date('Y-m-d');
        }

        $this->session->set_userdata('tanggal_exportpdf', $tanggal);

        $data['title'] = 'Laporan Harian Barang Baku';
        $data['tanggal_hari_ini'] = $this->input->get('tanggal');
        $data['lap_harian'] = $this->Model_laporan->getdata_harian($tanggal);

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_baku/view_laporan_harian', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_baku');
            $this->load->view('templates/pengguna/sidebar_baku');
            $this->load->view('barang_baku/view_laporan_harian', $data);
            $this->load->view('templates/pengguna/footer_baku');
        }
    }

    public function exportpdf()
    {
        $tanggal = $this->session->userdata('tanggal_exportpdf');
        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
        }

        $data['title'] = 'Laporan Harian Barang Baku';
        $data['manager'] = $this->Model_laporan->get_manager();
        $data['baku'] = $this->Model_laporan->get_baku();
        $data['tanggal_hari_ini'] = $tanggal;
        $data['lap_harian'] = $this->Model_laporan->getdata_harian($tanggal);

        // Set paper size and orientation
        $this->pdf->setPaper('A4', 'portrait');

        // $this->pdf->filename = "Potensi Sr.pdf";
        $this->pdf->filename = "LapHarianBaku-{$tanggal}.pdf";
        $this->pdf->generate('barang_baku/laporan_harian_pdf', $data);
    }

    public function stok_awal_harian()
    {
        $stok_awal = $this->Model_laporan->get_stok_akhir_kemaren();

        $tanggal_hari_ini = date('Y-m-d');

        foreach ($stok_awal as $row) {
            $data = array(
                'id_barang_baku' => $row['id_barang_baku'],
                'tanggal_stok_harian' => $tanggal_hari_ini,
                'jumlah_stok_harian' => $row['jumlah_stok_harian'],
                'input_stok_harian' => $this->session->userdata('nama_lengkap')
            );
            $this->Model_laporan->upload_stok_awal($data);
        }
        redirect('barang_baku/laporan_harian');
    }
}
