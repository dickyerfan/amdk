<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai_tetap extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_pegawai');
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
        if ($this->session->userdata('level') != 'Admin') {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> Anda harus login sebagai Manager...
                      </div>'
            );
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = 'Daftar Karyawan Tetap';
        $data['karyawanTetap'] = $this->Model_pegawai->getKaryawanTetap();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('manager/pegawai/view_pegawai_tetap', $data);
        $this->load->view('templates/footer');
    }
}
