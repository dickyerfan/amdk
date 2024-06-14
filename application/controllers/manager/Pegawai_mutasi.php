<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai_mutasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_pegawai');
        $this->load->library('form_validation');
        if (!$this->session->userdata('nama_pengguna')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = 'Mutasi Karyawan';
        $data['karyawan'] = $this->Model_pegawai->getAll();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('manager/pegawai/view_pegawai_mutasi', $data);
        $this->load->view('templates/footer');
    }

    public function edit($id)
    {
        $data['title'] = 'Form Mutasi Karyawan';
        $data['karyawan'] = $this->Model_pegawai->getIdKaryawan($id);
        $data['bagian'] = $this->db->get('bagian')->result();
        $data['subag'] = $this->db->get('subag')->result();
        $data['jabatan'] = $this->db->get('jabatan')->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('manager/pegawai/view_edit_pegawai_mutasi', $data);
        $this->load->view('templates/footer');
    }

    public function update()
    {
        $this->Model_pegawai->updateDataMutasi();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('karyawan/karyawan_mutasi');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Karyawan berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/pegawai_mutasi');
        }
    }

    public function purna($id)
    {
        $data['title'] = 'Form Purna Karyawan';
        $data['karyawan'] = $this->Model_pegawai->getIdKaryawan($id);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('manager/pegawai/view_purna_pegawai_mutasi', $data);
        $this->load->view('templates/footer');
    }

    public function purnaUpdate()
    {
        $this->Model_pegawai->updateDataPurna();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/pegawai_mutasi');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Karyawan berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/pegawai_mutasi');
        }
    }
}
