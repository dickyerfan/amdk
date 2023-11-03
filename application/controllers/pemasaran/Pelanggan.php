<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelanggan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_pelanggan');
        if (!$this->session->userdata('nama_pengguna')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = 'Daftar Pelanggan AMDK';
        $data['pelanggan'] = $this->Model_pelanggan->get_pelanggan();
        if ($this->session->userdata('upk_bagian') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('pemasaran/view_pelanggan', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_pasar');
            $this->load->view('templates/pengguna/sidebar_pasar');
            $this->load->view('pemasaran/view_pelanggan', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function tambah()
    {
        $data['title'] = "Tambah Data Pelanggan AMDK";

        $this->form_validation->set_rules('area_pelanggan', 'Area Pelanggan', 'required|trim');
        $this->form_validation->set_rules('gol_pelanggan', 'golongan Pelanggan', 'required|trim');
        $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'required|trim');
        $this->form_validation->set_rules('alamat_pelanggan', 'Alamat Pelanggan', 'required|trim');
        $this->form_validation->set_rules('telpon_pelanggan', 'Telpon Pelanggan', 'required|trim|numeric');
        // $this->form_validation->set_rules('ket', 'Keterangan', 'required|trim');
        $this->form_validation->set_rules('tarif', 'Tarif', 'required|trim');

        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('is_unique', '%s Sudah terdaftar, Ganti yang lain');
        $this->form_validation->set_message('numeric', '%s harus di tulis angka');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_pasar');
            $this->load->view('templates/pengguna/sidebar_pasar');
            $this->load->view('pemasaran/view_tambah_pelanggan', $data);
            $this->load->view('templates/pengguna/footer');
        } else {
            $data['user'] = $this->Model_pelanggan->tambahData();
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Pelanggan Baru berhasil di tambah
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('pemasaran/pelanggan');
        }
    }

    public function edit($id_pelanggan)
    {
        $data['title'] = "Form Edit Pelanggan";
        $data['edit_pelanggan'] = $this->db->get_where('pelanggan', ['id_pelanggan' => $id_pelanggan])->row();
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar_pasar');
        $this->load->view('templates/pengguna/sidebar_pasar');
        $this->load->view('pemasaran/view_edit_pelanggan', $data);
        $this->load->view('templates/pengguna/footer');
    }

    public function update()
    {
        $this->Model_pelanggan->updateData();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('pemasaran/pelanggan');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Pelanggan berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('pemasaran/pelanggan');
        }
    }

    public function hapus($id_pelanggan)
    {
        $this->Model_pelanggan->hapusData($id_pelanggan);
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Sukses,</strong> Data Pelanggan berhasil di hapus
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                  </div>'
        );
        redirect('pemasaran/pelanggan');
    }
}
