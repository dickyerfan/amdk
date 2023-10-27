<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jadi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        if ($this->session->userdata('upk_bagian') != 'jadi') {
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
        // if ($this->session->userdata('upk_bagian') != 'baku') {
        //     $this->session->set_flashdata(
        //         'info',
        //         '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        //                 <strong>Maaf,</strong> Anda harus login sebagai Admin Barang Baku...
        //               </div>'
        //     );
        //     redirect('auth');
        // }

        $data['title'] = 'Dashboard';
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar_jadi');
        $this->load->view('templates/pengguna/sidebar_jadi');
        $this->load->view('barang_jadi/view_dashboard_barang_jadi', $data);
        $this->load->view('templates/pengguna/footer');
    }
}
