<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_bulanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_laporan');
        if (!$this->session->userdata('nama_pengguna')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = 'Laporan Bulanan Barang Baku';
        $data['lap_bulanan'] = $this->Model_laporan->getdata_bulanan();
        if ($this->session->userdata('upk_bagian') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_baku/view_laporan_bulanan', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar');
            $this->load->view('templates/pengguna/sidebar_baku');
            $this->load->view('barang_baku/view_laporan_bulanan', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }
}
