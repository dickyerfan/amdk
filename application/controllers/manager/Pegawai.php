<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_pegawai');
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
        $data['title'] = "Daftar Karyawan AMDK Ijen Water";
        $data['pegawai'] = $this->Model_pegawai->get_pegawai();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('manager/view_pegawai', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['title'] = "Tambah Data Pegawai PDAM";

        $this->form_validation->set_rules('id_bagian', 'bagian', 'required|trim');
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('agama', 'Agama', 'required|trim');
        $this->form_validation->set_rules('jenkel', 'Jenis Kelamin', 'required|trim');

        $this->form_validation->set_message('required', '%s masih kosong');
        // $this->form_validation->set_message('is_unique', '%s Sudah terdaftar, Ganti yang lain');
        // $this->form_validation->set_message('numeric', '%s harus di input angka');


        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('manager/view_tambah_pegawai', $data);
            $this->load->view('templates/footer');
        } else {
            $data['user'] = $this->Model_pegawai->tambahData();
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Pegawai Baru berhasil di tambahkan
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/pegawai');
        }
    }

    public function edit($id)
    {
        $data['title'] = "Form Edit User";
        // $data['edit_pegawai'] = $this->db->get_where('pegawai', ['id' => $id])->row();
        $data['edit_pegawai'] = $this->Model_pegawai->getIdAdmin($id);
        $data['bagian'] = $this->Model_pegawai->get_bagian();
        // $data['data_karyawan'] = $this->Model_karyawan->get_karyawan();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('manager/view_edit_pegawai', $data);
        $this->load->view('templates/footer');
    }

    public function update()
    {
        $this->Model_pegawai->updateData();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/pegawai');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Pegawai berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/pegawai');
        }
    }

    public function hapus($id)
    {
        $this->Model_pegawai->hapusData($id);
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Sukses,</strong> Data Pegawai berhasil di hapus
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                  </div>'
        );
        redirect('manager/pegawai');
    }
}
