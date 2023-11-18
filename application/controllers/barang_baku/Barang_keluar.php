<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_keluar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_barang_baku');

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
        if ($level_pengguna != 'Admin' && $upk_bagian != 'baku') {
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
        $this->session->set_userdata('tanggal_keluar', $tanggal);
        $data['bulan_lap'] = $bulan;
        $data['tahun_lap'] = $tahun;

        $data['title'] = 'Transaksi Barang Keluar';
        // $data['barang_keluar'] = $this->Model_barang_baku->getbarang_keluar($bulan, $tahun);
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_baku/view_barang_keluar', $data);
            $this->load->view('templates/pengguna/footer_baku');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_baku');
            $this->load->view('templates/pengguna/sidebar_baku');
            $this->load->view('barang_baku/view_barang_keluar', $data);
            $this->load->view('templates/pengguna/footer_baku');
        }
    }

    function get_permintaan_barang()
    {
        $tanggal = $this->session->userdata('tanggal_keluar');

        $bulan = substr($tanggal, 5, 2);
        $tahun = substr($tanggal, 0, 4);

        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
            $bulan = date('m');
            $tahun = date('Y');
        }
        $data = $this->Model_barang_baku->get_permintaan_barang($bulan, $tahun);
        echo json_encode($data);
    }

    public function update_status_keluar()
    {
        $id_keluar_baku = $this->input->post('id_keluar_baku');

        // Lakukan pembaruan status_keluar ke 1 di database
        $data = [
            'status_keluar' => 1,
            'status_produksi' => 0
        ];
        $this->db->where('id_keluar_baku', $id_keluar_baku);
        $this->db->update('baku_produksi', $data);
        $result = $this->db->update('keluar_baku', $data);

        if ($result) {
            $response['success'] = true;
        } else {
            $response['success'] = false;
        }

        echo json_encode($response);
    }

    public function detail_status_keluar($id_keluar_baku)
    {
        $data['detail_barang_keluar'] = $this->Model_barang_baku->get_detail_barang_keluar($id_keluar_baku);
        $data['title'] = 'Detail Barang Baku';

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_baku/view_detail_keluar_barang_baku', $data);
            $this->load->view('templates/pengguna/footer_baku');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_baku');
            $this->load->view('templates/pengguna/sidebar_baku');
            $this->load->view('barang_baku/view_detail_keluar_barang_baku', $data);
            $this->load->view('templates/pengguna/footer_baku');
        }
    }

    public function cek_status_permintaan_barang()
    {
        $this->db->select('*');
        $this->db->from('keluar_baku');
        $this->db->where('status_keluar', 0);
        $result = $this->db->get()->result();

        if ($result) {
            $response['success'] = true;
        } else {
            $response['success'] = false;
        }

        echo json_encode($response);
    }
}
