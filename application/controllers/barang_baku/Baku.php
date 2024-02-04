<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Baku extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_dashboard');
        if ($this->session->userdata('upk_bagian') != 'baku') {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> Anda harus login sebagai Admin Barang Baku...
                      </div>'
            );
            redirect('auth');
        }
    }
    public function index()
    {
        $tanggal = date('Y-m-d');
        $data['produksi'] = $this->Model_dashboard->get_barang_jadi_dashboard($tanggal);
        $data['penjualan'] = $this->Model_dashboard->get_penjualan_dashboard($tanggal);
        $data['title'] = 'Dashboard';
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar_baku');
        $this->load->view('templates/pengguna/sidebar_baku');
        $this->load->view('baku/view_dashboard_baku', $data);
        $this->load->view('templates/pengguna/footer_baku');
    }
}
