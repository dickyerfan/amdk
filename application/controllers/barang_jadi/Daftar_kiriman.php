<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Daftar_kiriman extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_barang_jadi');
        $this->load->model('Model_pemesanan');

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
        if ($level_pengguna != 'Admin' && $upk_bagian != 'jadi') {
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
        $data['tanggal_hari_ini'] = $this->input->get('tanggal');
        $data['daftar_kiriman'] = $this->Model_pemesanan->get_daftar_kiriman($tanggal);
        $data['total_pesanan'] = $this->Model_pemesanan->get_all_pesanan($tanggal);
        $data['title'] = 'Daftar Pengiriman Barang';

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_jadi/view_daftar_pengiriman', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_jadi');
            $this->load->view('templates/pengguna/sidebar_jadi');
            $this->load->view('barang_jadi/view_daftar_pengiriman', $data);
            $this->load->view('templates/pengguna/footer_jadi');
        }
    }

    public function exportpdf()
    {
        $tanggal = $this->session->userdata('tanggal_exportpdf');
        $data['tanggal_hari_ini'] = $tanggal;
        $data['daftar_kiriman'] = $this->Model_pemesanan->get_daftar_kiriman($tanggal);
        $data['total_pesanan'] = $this->Model_pemesanan->get_all_pesanan($tanggal);
        $data['title'] = 'Daftar Pengiriman Barang';
        // Set paper size and orientation
        $this->pdf->setPaper('folio', 'portrait');

        // $this->pdf->filename = "Potensi Sr.pdf";
        $this->pdf->filename = "daftar_kiriman.pdf";
        $this->pdf->generate('barang_jadi/daftar_kiriman_pdf', $data);
    }
}
