<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_bulanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_laporan');
        if (!$this->session->userdata('nama_pengguna')) {
            redirect('auth');
        }
    }

    public function index()
    {
        // $bulan = $this->input->get('bulan');
        // $tahun = $this->input->get('tahun');

        // if (empty($bulan) and empty($tahun)) {
        //     $bulan = date('m');
        //     $tahun = date('Y');
        // }
        // $data['bulan_lap'] = $this->input->get('bulan');
        // $data['tahun_lap'] = $this->input->get('tahun');

        $tanggal = $this->input->post('tanggal');

        $data['bulan_lap'] = substr($tanggal, 5, 2);
        $data['tahun_lap'] = substr($tanggal, 0, 4);
        $data['title'] = 'Laporan Bulanan Barang Baku';
        $data['lap_bulanan'] = $this->Model_laporan->getdata_bulanan($tanggal);
        if ($this->session->userdata('upk_bagian') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_baku/view_laporan_bulanan', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_baku');
            $this->load->view('templates/pengguna/sidebar_baku');
            $this->load->view('barang_baku/view_laporan_bulanan', $data);
            $this->load->view('templates/pengguna/footer_baku');
        }
    }
}
