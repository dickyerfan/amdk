<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Satuan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_barang');
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
    }
    public function index()
    {
        $data['title'] = 'Data Satuan Barang';
        $data['satuan_baku'] = $this->Model_barang->get_all_data('satuan');
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar_baku');
        $this->load->view('templates/pengguna/sidebar_baku');
        $this->load->view('baku/view_satuan_baku', $data);
        $this->load->view('templates/pengguna/footer');
    }

    public function upload()
    {

        $this->form_validation->set_rules('satuan', 'Satuan Barang', 'required|trim');
        $this->form_validation->set_message('required', '%s masih kosong');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Tambah Satuan Barang';
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_baku');
            $this->load->view('templates/pengguna/sidebar_baku');
            $this->load->view('baku/tambah_satuan_baku', $data);
            $this->load->view('templates/pengguna/footer');
        } else {

            $data['satuan'] = $this->input->post('satuan', true);
            $data['input_satuan'] = $this->session->userdata('nama_lengkap');

            $this->Model_barang->upload('satuan', $data);
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data satuan barang berhasil di simpan
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>'
            );
            redirect('satuan');
        }
    }

    public function edit($id_satuan)
    {
        $data['title'] = 'Update Satuan Barang';
        $data['edit_satuan'] = $this->Model_barang->get_id('satuan', 'id_satuan', $id_satuan);
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar');
        $this->load->view('templates/pengguna/sidebar_baku');
        $this->load->view('baku/edit_satuan_baku', $data);
        $this->load->view('templates/pengguna/footer');
    }

    public function update()
    {
        $data = [
            'satuan' => $this->input->post('satuan', true),
        ];
        $this->Model_barang->update('satuan', 'id_satuan', $data);
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Sukses,</strong> Data satuan barang berhasil di update
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                  </div>'
        );
        redirect('satuan');
    }

    public function hapus($id_satuan)
    {
        $this->Model_barang->hapus('satuan', 'id_satuan', $id_satuan);
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Sukses,</strong> Data satuan barang berhasil di hapus
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                  </div>'
        );
        redirect('satuan');
    }
}
