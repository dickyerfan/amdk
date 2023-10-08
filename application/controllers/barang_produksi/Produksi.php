<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produksi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        if ($this->session->userdata('upk_bagian') != 'produksi') {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> Anda harus login sebagai Admin Barang Produksi...
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
        $this->load->view('templates/pengguna/navbar_produksi');
        $this->load->view('templates/pengguna/sidebar_produksi');
        $this->load->view('barang_produksi/view_dashboard_produksi', $data);
        $this->load->view('templates/pengguna/footer');
    }
}
