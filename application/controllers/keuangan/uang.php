<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Uang extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_dashboard');
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
        $tanggal = date('Y-m-d');
        $data['produksi'] = $this->Model_dashboard->get_barang_jadi_dashboard($tanggal);
        $data['penjualan'] = $this->Model_dashboard->get_penjualan_dashboard($tanggal);
        $data['title'] = 'Dashboard';
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar_uang');
        $this->load->view('templates/pengguna/sidebar_uang');
        $this->load->view('keuangan/view_dashboard_keuangan', $data);
        $this->load->view('templates/pengguna/footer_uang');
    }
}
