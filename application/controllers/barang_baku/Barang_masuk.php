<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_masuk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_barang_baku');
        if (!$this->session->userdata('nama_pengguna')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = 'Transaksi Barang Masuk';
        $data['barang_masuk'] = $this->Model_barang_baku->getbarang_masuk();
        if ($this->session->userdata('upk_bagian') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_baku/view_stok_barangbaku', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar_baku');
            $this->load->view('barang_baku/view_barang_masuk', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function upload()
    {
        $data['title'] = 'Tambah Barang Baku';
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar');
        $this->load->view('templates/pengguna/sidebar_baku');
        $this->load->view('barang_baku/tambah_barangbaku', $data);
        $this->load->view('templates/pengguna/footer');
    }
}
