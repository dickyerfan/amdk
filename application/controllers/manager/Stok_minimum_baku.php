<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stok_minimum_baku extends CI_Controller
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
        $data['title'] = 'Stock Minimum Barang Baku';
        $data['stok_minimum'] = $this->Model_barang_baku->getstok_minimum_baku();
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('manager/view_stok_minimum_baku', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_produksi');
            $this->load->view('templates/pengguna/sidebar_produksi');
            $this->load->view('manager/view_stok_minimum_baku', $data);
            $this->load->view('templates/pengguna/footer_produksi');
        }
    }

    public function upload()
    {
        $this->form_validation->set_rules('id_barang_baku', 'Nama Barang Baku', 'required|trim');
        $this->form_validation->set_rules('id_satuan', 'Nama Satuan', 'required|trim');
        $this->form_validation->set_rules('isi_stok_minimum', 'Isi Stok Minimum', 'required|trim|numeric');
        $this->form_validation->set_rules('jumlah_stok_minimum', 'Jumlah Stok Awal', 'required|trim|numeric');
        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('numeric', '%s harus di isi angka');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Tambah Stok Mininum Barang Baku';
            $data['nama_barang'] = $this->Model_barang_baku->get_nama_barang();
            $data['nama_satuan'] = $this->Model_barang_baku->get_nama_satuan();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('manager/view_tambah_stok_minimum_baku', $data);
            $this->load->view('templates/footer');
        } else {
            $data['id_barang_baku'] = $this->input->post('id_barang_baku');
            $data['id_satuan'] = $this->input->post('id_satuan');
            $data['isi_stok_minimum'] = $this->input->post('isi_stok_minimum');
            $data['jumlah_stok_minimum'] = $this->input->post('jumlah_stok_minimum');
            $data['input_status_stok_minimum'] = $this->session->userdata('nama_lengkap');
            $data['tgl_input_stok_minimum'] = date('Y-m-d H:i:s');

            $this->Model_barang_baku->upload('stok_minimum', $data);
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Stok minimum barang baku berhasil di simpan
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>'
            );
            redirect('manager/stok_minimum_baku');
        }
    }

    public function edit($id_stok_minimum)
    {
        $data['title'] = "Form Edit Stok minimum Barang Baku";
        $data['edit_stok'] = $this->Model_barang_baku->get_id_stok_minimum($id_stok_minimum);
        $data['daftar_satuan'] = $this->Model_barang_baku->get_all_satuan();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('manager/view_edit_stok_minimum_baku', $data);
        $this->load->view('templates/footer');
    }

    public function update()
    {
        $this->Model_barang_baku->update_stok_minimum();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/stok_minimum_baku');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Stok Barang Baku Minimum berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/stok_minimum_baku');
        }
    }
}
