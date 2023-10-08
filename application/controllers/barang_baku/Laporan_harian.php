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
            redirect('auth');
        }
    }

    public function index()
    {
        $tanggal = $this->input->post('tanggal');
        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
        }

        $data['title'] = 'Laporan Harian Barang Baku';
        $data['tanggal_hari_ini'] = $this->input->post('tanggal');
        $data['lap_harian'] = $this->Model_laporan->getdata_harian($tanggal);

        if ($this->session->userdata('upk_bagian') == 'admin') {
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