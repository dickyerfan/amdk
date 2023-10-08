<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stok_barang_baku extends CI_Controller
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
        $data['title'] = 'Stock Barang Baku';
        $data['stok_barang'] = $this->Model_barang_baku->getdata();
        if ($this->session->userdata('upk_bagian') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_baku/view_stok_barangbaku', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_baku');
            $this->load->view('templates/pengguna/sidebar_baku');
            $this->load->view('barang_baku/view_stok_barangbaku', $data);
            $this->load->view('templates/pengguna/footer_baku');
        }
    }

    public function upload()
    {
        $this->form_validation->set_rules('nama_barang_baku', 'Nama Barang Baku', 'required|trim|is_unique[barang_baku.nama_barang_baku]');
        $this->form_validation->set_rules('id_satuan', 'Nama Satuan', 'required|trim');
        $this->form_validation->set_rules('id_jenis_barang', 'Jenis Barang', 'required|trim');
        // $this->form_validation->set_rules('stok_awal', 'Stok Awal', 'required|trim|numeric');
        $this->form_validation->set_rules('kode_barang', 'Kode Barang', 'required|trim');
        $this->form_validation->set_message('required', '%s masih kosong');
        // $this->form_validation->set_message('numeric', '%s harus di isi angka');
        $this->form_validation->set_message('is_unique', '%s sudah terdaftar');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Tambah Barang Baku';
            $data['satuan'] = $this->Model_barang_baku->get_satuan();
            $data['jenis_barang'] = $this->Model_barang_baku->get_jenis_barang();
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_baku');
            $this->load->view('templates/pengguna/sidebar_baku');
            $this->load->view('barang_baku/view_tambah_barang_baku', $data);
            $this->load->view('templates/pengguna/footer_baku');
        } else {
            // $nama_barang = $this->input->post('nama_barang_baku', true);
            // $nama_barang = preg_replace("/[^a-zA-Z0-9\s]/", '', $nama_barang); // Hapus karakter non-huruf, non-angka, dan non-spasi
            // $nama_barang = explode(' ', $nama_barang); // Pisahkan kata-kata dalam nama barang
            // $kode_barang = '';

            // foreach ($nama_barang as $kata) {
            //     if (is_numeric($kata)) {
            //         $kode_barang .= $kata;
            //     } else {
            //         $kode_barang .= substr($kata, 0, 3); // Ambil tiga huruf pertama dari setiap kata
            //     }
            // }

            // $kode_barang = strtolower($kode_barang); // Ubah kode barang menjadi huruf kecil


            $data['nama_barang_baku'] = $this->input->post('nama_barang_baku', true);
            $data['id_satuan'] = $this->input->post('id_satuan', true);
            $data['id_jenis_barang'] = $this->input->post('id_jenis_barang', true);
            $data['kode_barang'] = $this->input->post('kode_barang');
            // $data['stok_awal'] = $this->input->post('stok_awal', true);
            // $data['tgl_stok_awal'] = $this->input->post('tgl_stok_awal', true);
            $data['input_barang_baku'] = $this->session->userdata('nama_lengkap');

            $this->Model_barang_baku->upload('barang_baku', $data);
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data barang baku berhasil di simpan
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>'
            );
            redirect('barang_baku/stok_barang_baku');
        }
    }
}
