<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_karyawan');
        $this->load->library('form_validation');
        if ($this->session->userdata('level') != 'Admin') {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = "Daftar Karyawan AMDK Ijen Water";
        $data['karyawan'] = $this->Model_karyawan->get_karyawan();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('manager/view_karyawan', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['title'] = "Tambah Data Karyawan";

        $this->form_validation->set_rules('nama_karyawan', 'Nama Karyawan', 'required|trim');
        $this->form_validation->set_rules('nik_karyawan', 'NIK Karyawan', 'trim|is_unique[karyawan.nik_karyawan]');
        $this->form_validation->set_rules('bagian', 'Bagian', 'required|trim');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required|trim');
        $this->form_validation->set_rules('jenkel', 'Jenis Kelamin', 'required|trim');

        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('is_unique', '%s Sudah terdaftar, Ganti yang lain');


        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('manager/view_tambah_karyawan', $data);
            $this->load->view('templates/footer');
        } else {
            $data['user'] = $this->Model_karyawan->tambahData();
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Karyawan berhasil di tambah
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/karyawan');
        }
    }

    public function edit($id_karyawan)
    {
        $data['title'] = "Form Edit User";
        $data['edit_karyawan'] = $this->db->get_where('karyawan', ['id_karyawan' => $id_karyawan])->row();
        // $data['data_karyawan'] = $this->Model_karyawan->get_karyawan();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('manager/view_edit_karyawan', $data);
        $this->load->view('templates/footer');
    }

    public function update()
    {
        $this->Model_karyawan->updateData();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/karyawan');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Karyawan berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/karyawan');
        }
    }

    public function hapus($id_karyawan)
    {
        $this->Model_karyawan->hapusData($id_karyawan);
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Sukses,</strong> Data berhasil di hapus
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                  </div>'
        );
        redirect('manager/karyawan');
    }
}
