<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenis_barang extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_barang');
        $this->load->library('form_validation');
        if ($this->session->userdata('level') != 'Admin') {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> Anda harus login sebagai Admin...
                      </div>'
            );
            redirect('auth');
        }
    }
    public function index()
    {
        $data['title'] = 'Data Jenis Barang';
        $data['jenis_barang'] = $this->Model_barang->get_all_data('jenis_barang');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('manager/view_jenis_barang', $data);
        $this->load->view('templates/footer');
    }

    public function upload()
    {

        $this->form_validation->set_rules('nama_barang_jadi', 'Nama Barang', 'required|trim');
        $this->form_validation->set_rules('jenis_barang', 'Jenis Barang', 'required|trim');
        $this->form_validation->set_message('required', '%s masih kosong');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Tambah Jenis Barang';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('manager/view_tambah_jenis_barang', $data);
            $this->load->view('templates/footer');
        } else {
            $data['nama_barang_jadi'] = $this->input->post('nama_barang_jadi', true);
            $data['jenis_barang'] = $this->input->post('jenis_barang', true);
            $data['input_jenis_barang'] = $this->session->userdata('nama_lengkap');

            $this->Model_barang->upload('jenis_barang', $data);
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Jenis barang baru berhasil di simpan
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>'
            );
            redirect('manager/jenis_barang');
        }
    }

    public function edit($id_jenis_barang)
    {
        $data['title'] = 'Update Jenis Barang';
        $data['edit_jenis'] = $this->Model_barang->get_id('jenis_barang', 'id_jenis_barang', $id_jenis_barang);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('manager/view_edit_jenis_barang', $data);
        $this->load->view('templates/footer');
    }

    public function update()
    {
        $data = [
            'nama_barang_jadi' => $this->input->post('nama_barang_jadi', true),
            'jenis_barang' => $this->input->post('jenis_barang', true),
            'input_jenis_barang' => $this->session->userdata('nama_lengkap')
        ];
        $this->Model_barang->update('jenis_barang', 'id_jenis_barang', $data);
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Sukses,</strong> Data barang berhasil di update
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                  </div>'
        );
        redirect('manager/jenis_barang');
    }

    public function hapus($id_jenis_barang)
    {
        $this->Model_barang->hapus('jenis_barang', 'id_jenis_barang', $id_jenis_barang);
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Sukses,</strong> Data jenis barang berhasil di hapus
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                  </div>'
        );
        redirect('manager/jenis_barang');
    }
}
