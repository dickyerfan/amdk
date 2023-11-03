<?php
defined('BASEPATH') or exit('No direct script access allowed');

class uang extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        if ($this->session->userdata('upk_bagian') != 'uang') {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> Anda harus login sebagai Admin Keuangan...
                      </div>'
            );
            redirect('auth');
        }
    }
    public function index()
    {
        $data['title'] = 'Dashboard';
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar_uang');
        $this->load->view('templates/pengguna/sidebar_uang');
        $this->load->view('keuangan/view_dashboard_keuangan', $data);
        $this->load->view('templates/pengguna/footer');
    }
}
