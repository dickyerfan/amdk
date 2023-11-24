<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stok_barang_jadi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_barang_jadi');
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
        if ($level_pengguna != 'Admin' && $upk_bagian != 'pasar') {
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

        $data['title'] = 'Stock Barang Jadi';
        $data['tanggal_hari_ini'] = $this->input->get('tanggal');
        $data['stok_barang'] = $this->Model_barang_jadi->getdata($tanggal);
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar_pasar');
        $this->load->view('templates/pengguna/sidebar_pasar');
        $this->load->view('barang_jadi/view_stok_barang_jadi', $data);
        $this->load->view('templates/pengguna/footer');
    }
}
