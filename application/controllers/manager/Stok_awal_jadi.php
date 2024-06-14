<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stok_awal_jadi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_barang_jadi');
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
        $data['title'] = 'Stock Awal Barang Jadi';
        $data['stok_barang_jadi'] = $this->Model_barang_jadi->getstok_awal_jadi();
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('manager/view_stok_awal_jadi', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_jadi');
            $this->load->view('templates/pengguna/sidebar_jadi');
            $this->load->view('manager/view_stok_awal_jadi', $data);
            $this->load->view('templates/pengguna/footer_jadi');
        }
    }

    public function upload()
    {
        $this->form_validation->set_rules('id_jenis_barang', 'Nama Barang', 'required|trim|is_unique[stok_awal_jadi.id_jenis_barang]');
        $this->form_validation->set_rules('jumlah_stok_awal_jadi', 'Jumlah Stok Awal', 'required|trim');
        $this->form_validation->set_rules('tanggal_stok_awal_jadi', 'Tanggal Stok Awal', 'required|trim');
        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('is_unique', '%s sudah terdaftar');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Tambah Stok Awal Barang Jadi';
            $data['nama_barang'] = $this->Model_barang_jadi->get_nama_barang();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('manager/view_tambah_stok_awal_jadi', $data);
            $this->load->view('templates/footer');
        } else {

            $data['id_jenis_barang'] = $this->input->post('id_jenis_barang', true);
            $data['jumlah_stok_awal_jadi'] = $this->input->post('jumlah_stok_awal_jadi');
            $data['tanggal_stok_awal_jadi'] = $this->input->post('tanggal_stok_awal_jadi');
            $data['input_status_stok_awal_jadi'] = $this->session->userdata('nama_lengkap');
            $data['tgl_input_stok_awal_jadi'] = date('Y-m-d H:i:s');

            $this->Model_barang_jadi->upload('stok_awal_jadi', $data);
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Stok awal barang jadi berhasil di simpan
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>'
            );
            redirect('manager/stok_awal_jadi');
        }
    }

    public function edit($id_stok_awal_jadi)
    {
        $data['title'] = "Form Edit Stok Awal Baku";
        $data['edit_stok'] = $this->Model_barang_jadi->get_id_stok_awal($id_stok_awal_jadi);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('manager/view_edit_stok_awal_jadi', $data);
        $this->load->view('templates/footer');
    }

    public function update()
    {
        $this->Model_barang_jadi->update_stok();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/stok_awal_jadi');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Stok Barang Jadi berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/stok_awal_jadi');
        }
    }
}
