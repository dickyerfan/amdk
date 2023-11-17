<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stok_barang_jadi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_barang_jadi');
        // if (!$this->session->userdata('nama_pengguna')) {
        //     redirect('auth');
        // }
        if ($this->session->userdata('upk_bagian') != 'jadi') {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> Anda harus login sebagai Admin Barang Jadi...
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

        $data['title'] = 'Stock Barang Jadi';
        $data['tanggal_hari_ini'] = $this->input->get('tanggal');
        $data['stok_barang'] = $this->Model_barang_jadi->getdata($tanggal);
        if ($this->session->userdata('upk_bagian') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_jadi/view_stok_barang_jadi', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_jadi');
            $this->load->view('templates/pengguna/sidebar_jadi');
            $this->load->view('barang_jadi/view_stok_barang_jadi', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    // public function upload()
    // {
    //     $this->form_validation->set_rules('nama_barang_baku', 'Nama Barang Baku', 'required|trim|is_unique[barang_baku.nama_barang_baku]');
    //     $this->form_validation->set_rules('id_satuan', 'Nama Satuan', 'required|trim');
    //     $this->form_validation->set_rules('id_jenis_barang', 'Jenis Barang', 'required|trim');
    //     $this->form_validation->set_rules('kode_barang', 'Kode Barang', 'required|trim');
    //     $this->form_validation->set_message('required', '%s masih kosong');
    //     $this->form_validation->set_message('is_unique', '%s sudah terdaftar');

    //     if ($this->form_validation->run() == false) {
    //         $data['title'] = 'Tambah Barang Baku';
    //         $data['satuan'] = $this->Model_barang_jadi->get_satuan();
    //         $data['jenis_barang'] = $this->Model_barang_jadi->get_jenis_barang();
    //         $this->load->view('templates/pengguna/header', $data);
    //         $this->load->view('templates/pengguna/navbar_baku');
    //         $this->load->view('templates/pengguna/sidebar_baku');
    //         $this->load->view('barang_baku/view_tambah_barang_baku', $data);
    //         $this->load->view('templates/pengguna/footer_baku');
    //     } else {

    //         $data['nama_barang_baku'] = $this->input->post('nama_barang_baku', true);
    //         $data['id_satuan'] = $this->input->post('id_satuan', true);
    //         $data['id_jenis_barang'] = $this->input->post('id_jenis_barang', true);
    //         $data['kode_barang'] = $this->input->post('kode_barang');
    //         $data['input_barang_baku'] = $this->session->userdata('nama_lengkap');

    //         $this->Model_barang_jadi->upload('barang_baku', $data);
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    //                     <strong>Sukses,</strong> Data barang baku berhasil di simpan
    //                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                     </button>
    //                 </div>'
    //         );
    //         redirect('barang_baku/stok_barang_baku');
    //     }
    // }
}
