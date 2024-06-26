<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setoran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_setoran');
        date_default_timezone_set('Asia/Jakarta');
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
        $bulan = substr($tanggal, 5, 2);
        $tahun = substr($tanggal, 0, 4);

        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
            $bulan = date('m');
            $tahun = date('Y');
        }
        $data['bulan_lap'] = $bulan;
        $data['tahun_lap'] = $tahun;

        if (!empty($tanggal)) {
            $this->session->set_userdata('tanggal', $tanggal); // Simpan tanggal ke session jika diperlukan
        }
        $data['tanggal_hari_ini'] = $this->input->get('tanggal');
        $data['title'] = 'Daftar Semua Setoran Penjualan';
        $data['pesan'] = $this->Model_setoran->get_setoran($tanggal);
        $data['driver'] = $this->Model_setoran->get_driver();
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('pemasaran/view_setoran', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_pasar');
            $this->load->view('templates/pengguna/sidebar_pasar');
            $this->load->view('pemasaran/view_setoran', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function nama_driver()
    {
        $tanggal = $this->input->get('tanggal');
        $nama_driver = $this->input->get('driver');
        $bulan = substr($tanggal, 5, 2);
        $tahun = substr($tanggal, 0, 4);

        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
            $bulan = date('m');
            $tahun = date('Y');
        }
        $data['bulan_lap'] = $bulan;
        $data['tahun_lap'] = $tahun;

        if (!empty($tanggal)) {
            $this->session->set_userdata('tanggal', $tanggal);
        }
        if (!empty($nama_driver)) {
            $this->session->userdata('driver', $nama_driver);
        }

        $data['tanggal_hari_ini'] = $tanggal;
        $data['title'] = 'Daftar Setoran Penjualan : ' . $nama_driver;
        $data['driver'] = $this->Model_setoran->get_driver();
        $data['setoran_driver'] = $this->Model_setoran->get_setoran_by_driver($tanggal, $nama_driver);

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('pemasaran/view_setoran_driver', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_pasar');
            $this->load->view('templates/pengguna/sidebar_pasar');
            $this->load->view('pemasaran/view_setoran_driver', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function exportpdf()
    {
        $tanggal = $this->session->userdata('tanggal');
        $nama_driver = $this->input->get('driver');
        $bulan = substr($tanggal, 5, 2);
        $tahun = substr($tanggal, 0, 4);

        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
            $bulan = date('m');
            $tahun = date('Y');
        }
        $data['bulan_lap'] = $bulan;
        $data['tahun_lap'] = $tahun;


        $data['tanggal_hari_ini'] = $tanggal;
        $data['title'] = 'Daftar Setoran Penjualan : ' . $nama_driver;
        $data['petugas_setor'] = $nama_driver;
        $data['driver'] = $this->Model_setoran->get_driver();
        $data['setoran_driver'] = $this->Model_setoran->get_setoran_by_driver($tanggal, $nama_driver);

        $this->pdf->setPaper('folio', 'portrait');

        $this->pdf->filename = "daftar_setoran.pdf";
        $this->pdf->generate('pemasaran/daftar_setoran_pdf', $data);
    }
}
