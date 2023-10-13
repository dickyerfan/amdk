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
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = 'Transaksi Barang Keluar';
        $data['barang_keluar'] = $this->Model_barang_baku->getbarang_keluar();
        if ($this->session->userdata('upk_bagian') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_baku/view_barang_keluar', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_baku');
            $this->load->view('templates/pengguna/sidebar_baku');
            $this->load->view('barang_baku/view_barang_keluar', $data);
            $this->load->view('templates/pengguna/footer_baku');
        }
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
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar_baku');
        $this->load->view('templates/pengguna/sidebar_baku');
        $this->load->view('barang_baku/view_detail_keluar_barang_baku', $data);
        $this->load->view('templates/pengguna/footer');
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
