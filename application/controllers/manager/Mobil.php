<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mobil extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_mobil');
        $this->load->library('form_validation');
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
        $data['title'] = "Daftar Armada Mobil AMDK Ijen Water";
        $data['mobil'] = $this->Model_mobil->get_mobil();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('manager/view_mobil', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['title'] = "Tambah Data Mobil";
        $data['p_jawab'] = $this->Model_mobil->get_karyawan();
        $this->form_validation->set_rules('nama_mobil', 'Nama Mobil', 'required|trim');
        $this->form_validation->set_rules('plat_nomor', 'Plat Nomor', 'trim|is_unique[mobil.plat_nomor]');
        $this->form_validation->set_rules('jenis_mobil', 'Jenis Mobil', 'required|trim');
        $this->form_validation->set_rules('id_karyawan', 'Nama Karyawan', 'required|trim');

        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('is_unique', '%s Sudah terdaftar, Ganti yang lain');


        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('manager/view_tambah_mobil', $data);
            $this->load->view('templates/footer');
        } else {
            $data['user'] = $this->Model_mobil->tambahData();
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Mobil berhasil di tambah
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/mobil');
        }
    }

    public function edit($id_mobil)
    {
        $data['title'] = "Form Edit Mobil";
        $data['edit_mobil'] = $this->db->get_where('mobil', ['id_mobil' => $id_mobil])->row();
        $data['p_jawab'] = $this->Model_mobil->get_karyawan();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('manager/view_edit_mobil', $data);
        $this->load->view('templates/footer');
    }

    public function update()
    {
        $this->Model_mobil->updateData();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/mobil');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Mobil berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/mobil');
        }
    }

    public function hapus($id_mobil)
    {
        $this->Model_mobil->hapusData($id_mobil);
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Sukses,</strong> Data Mobil berhasil di hapus
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                  </div>'
        );
        redirect('manager/mobil');
    }
}
