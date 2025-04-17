<?php
defined('BASEPATH') or exit('No direct script access allowed');

class harga_barang_baku extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_harga');
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
        $data['title'] = "Daftar Harga Barang Baku Ijen Water";
        $data['harga'] = $this->Model_harga->get_harga_barang_baku();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('manager/view_harga_barang_baku', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['title'] = "Tambah Daftar Harga Barang Baku";
        $data['harga_barang_baku'] = $this->Model_harga->get_barang_baku();
        $this->form_validation->set_rules('id_barang_baku', 'Nama Barang Baku', 'required|trim');
        $this->form_validation->set_rules('harga', 'Harga', 'required|trim');
        $this->form_validation->set_rules('tanggal_berlaku', 'Tanggal Berlaku', 'required|trim');

        $this->form_validation->set_message('required', '%s masih kosong');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('manager/view_tambah_harga_barang_baku', $data);
            $this->load->view('templates/footer');
        } else {
            $data['user'] = $this->Model_harga->tambah_harga_barang_baku();
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Daftar harga barang baku baru berhasil di tambah
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/harga_barang_baku');
        }
    }

    public function edit($id_harga)
    {
        $data['title'] = "Form Edit harga_barang_baku";
        $data['edit_harga'] = $this->db->get_where('harga_barang_baku', ['id_harga' => $id_harga])->row();
        $data['harga_barang_baku'] = $this->Model_harga->get_barang_baku();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('manager/view_edit_harga_barang_baku', $data);
        $this->load->view('templates/footer');
    }

    public function update()
    {
        $this->Model_harga->update_harga_barang_baku();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/harga_barang_baku');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Daftar harga barang baku berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/harga_barang_baku');
        }
    }

    public function hapus_harga_barang_baku($id_harga)
    {
        $this->Model_harga->hapus_harga_barang_baku($id_harga);
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Sukses,</strong> Daftar harga barang baku berhasil di hapus
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                  </div>'
        );
        redirect('manager/harga_barang_baku');
    }
}
