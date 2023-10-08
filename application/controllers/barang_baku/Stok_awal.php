<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stok_awal extends CI_Controller
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
        $data['title'] = 'Stock Awal Barang Baku';
        $data['stok_barang'] = $this->Model_barang_baku->getstok_awal();
        if ($this->session->userdata('upk_bagian') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_baku/view_stok_awal', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_baku');
            $this->load->view('templates/pengguna/sidebar_baku');
            $this->load->view('barang_baku/view_stok_awal', $data);
            $this->load->view('templates/pengguna/footer_baku');
        }
    }

    public function upload()
    {
        $this->form_validation->set_rules('id_barang_baku', 'Nama Barang Baku', 'required|trim|is_unique[stok_awal_baku.id_barang_baku]');
        $this->form_validation->set_rules('jumlah_stok_awal_baku', 'Jumlah Stok Awal', 'required|trim');
        $this->form_validation->set_rules('tanggal_stok_awal_baku', 'Tanggal Stok Awal', 'required|trim');
        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('is_unique', '%s sudah terdaftar');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Tambah Stok Awal';
            $data['nama_barang'] = $this->Model_barang_baku->get_nama_barang();
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_baku');
            $this->load->view('templates/pengguna/sidebar_baku');
            $this->load->view('barang_baku/view_tambah_stok_awal', $data);
            $this->load->view('templates/pengguna/footer_baku');
        } else {

            $data['id_barang_baku'] = $this->input->post('id_barang_baku', true);
            $data['jumlah_stok_awal_baku'] = $this->input->post('jumlah_stok_awal_baku');
            $data['tanggal_stok_awal_baku'] = $this->input->post('tanggal_stok_awal_baku');
            $data['input_status_stok_awal_baku'] = $this->session->userdata('nama_lengkap');

            $this->Model_barang_baku->upload('stok_awal_baku', $data);
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Stok awal barang baku berhasil di simpan
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>'
            );
            redirect('barang_baku/stok_awal');
        }
    }
}
