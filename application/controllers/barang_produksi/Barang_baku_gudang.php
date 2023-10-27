<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_baku_gudang extends CI_Controller
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
        $data['title'] = 'Stock Barang Baku Gudang';
        $data['stok_barang'] = $this->Model_barang_baku->getdata();
        if ($this->session->userdata('upk_bagian') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_baku/view_stok_barangbaku', $data);
            $this->load->view('templates/footer');
        } else {

            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_produksi');
            $this->load->view('templates/pengguna/sidebar_produksi');
            $this->load->view('barang_produksi/view_stok_barangbaku_gudang', $data);
            $this->load->view('templates/pengguna/footer_produksi');
        }
    }
}
