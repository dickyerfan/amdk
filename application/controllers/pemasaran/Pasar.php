<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pasar extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
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
        $data['title'] = 'Dashboard';
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar_pasar');
        $this->load->view('templates/pengguna/sidebar_pasar');
        $this->load->view('pemasaran/view_dashboard_pemasaran', $data);
        $this->load->view('templates/pengguna/footer');
    }
}
