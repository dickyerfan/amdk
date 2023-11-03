<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Harga extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_harga');
        $this->load->library('form_validation');
        if ($this->session->userdata('level') != 'Admin') {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = "Daftar Harga Produk Ijen Water";
        $data['harga'] = $this->Model_harga->get_harga();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('manager/view_harga', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['title'] = "Tambah Daftar Harga";
        $data['barang'] = $this->Model_harga->get_jenis_barang();
        $this->form_validation->set_rules('id_jenis_barang', 'Jenis Barang', 'required|trim');
        $this->form_validation->set_rules('jenis_harga', 'Jenis Harga', 'required|trim');
        $this->form_validation->set_rules('harga', 'harga', 'required|trim');

        $this->form_validation->set_message('required', '%s masih kosong');
        // $this->form_validation->set_message('is_unique', '%s Sudah terdaftar, Ganti yang lain');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('manager/view_tambah_harga', $data);
            $this->load->view('templates/footer');
        } else {
            $data['user'] = $this->Model_harga->tambahData();
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Daftar harga baru berhasil di tambah
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/harga');
        }
    }

    public function edit($id_harga)
    {
        $data['title'] = "Form Edit harga";
        $data['edit_harga'] = $this->db->get_where('harga', ['id_harga' => $id_harga])->row();
        $data['barang'] = $this->Model_harga->get_jenis_barang();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('manager/view_edit_harga', $data);
        $this->load->view('templates/footer');
    }

    public function update()
    {
        $this->Model_harga->updateData();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/harga');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Daftar harga berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/harga');
        }
    }

    public function hapus($id_mobil)
    {
        $this->Model_harga->hapusData($id_mobil);
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Sukses,</strong> Daftar harga berhasil di hapus
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                  </div>'
        );
        redirect('manager/harga');
    }
}
