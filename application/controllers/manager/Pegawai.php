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
        $data['title'] = 'Daftar Karyawan PDAM Bondowoso';
        $data['karyawan'] = $this->Model_pegawai->getAll();

        $data['kartotal'] = $this->db->get_where('pegawai', ['aktif' => '1'])->num_rows();
        $data['kartetap'] = $this->db->get_where('pegawai', [
            'status_pegawai' => 'Karyawan Tetap',
            'aktif' => '1',
        ])->num_rows();
        $data['karkontrak'] = $this->db->get_where('pegawai', [
            'status_pegawai' => 'Karyawan Kontrak',
            'aktif' => '1',
        ])->num_rows();
        $data['karhonorer'] = $this->db->get_where('pegawai', [
            'status_pegawai' => 'Karyawan Honorer',
            'aktif' => '1',
        ])->num_rows();
        $data['karpurna'] = $this->db->get_where('pegawai', [
            'aktif' => '0',
        ])->num_rows();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('manager/pegawai/view_pegawai_dashboard', $data);
        $this->load->view('templates/footer');
    }
    public function tambah()
    {
        $data['title'] = 'Form Tambah Karyawan';
        $data['bagian'] = $this->db->get('bagian')->result();
        $data['subag'] = $this->db->get('subag')->result();
        $data['jabatan'] = $this->db->get('jabatan')->result();
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('nik', 'NIK', 'is_unique[karyawan.nik]');
        $this->form_validation->set_rules('no_hp', 'NO HP', 'trim|min_length[10]');
        $this->form_validation->set_rules('agama', 'Agama', 'required|trim');
        $this->form_validation->set_rules('tmp_lahir', 'Tempat Lahir', 'required|trim');
        $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required|trim');
        // $this->form_validation->set_rules('tgl_masuk', 'Tanggal Masuk', 'required|trim');
        $this->form_validation->set_rules('id_bagian', 'Bagian', 'required|trim');
        $this->form_validation->set_rules('id_subag', 'Sub Bagian', 'required|trim');
        $this->form_validation->set_rules('id_jabatan', 'Jabatan', 'required|trim');
        $this->form_validation->set_rules('status_pegawai', 'Status Pegawai', 'required|trim');
        $this->form_validation->set_rules('jenkel', 'Jenis Kelamin', 'required|trim');
        $this->form_validation->set_message('required', '%s harus di isi');
        $this->form_validation->set_message('is_unique', '%s sudah terdaftar');
        $this->form_validation->set_message('min_length', '%s Minimal 10 digit');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('manager/pegawai/view_tambah_pegawai', $data);
            $this->load->view('templates/footer');
        } else {
            $data['karyawan'] = $this->Model_pegawai->tambahData();
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Karyawan berhasil di tambah
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/pegawai');
        }
    }

    public function edit($id)
    {
        $data['title'] = 'Form Edit Karyawan';
        $data['karyawan'] = $this->Model_pegawai->getIdKaryawan($id);
        $data['bagian'] = $this->db->get('bagian')->result();
        $data['subag'] = $this->db->get('subag')->result();
        $data['jabatan'] = $this->db->get('jabatan')->result();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('manager/pegawai/view_edit_pegawai', $data);
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
                        <strong>Sukses,</strong> Data Karyawan berhasil di update
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
                    <strong>Sukses,</strong> Data Karyawan berhasil di hapus
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                  </div>'
        );
        redirect('manager/pegawai');
    }

    public function detail($id)
    {
        $data['title'] = 'Detail Karyawan';
        $data['karyawan'] = $this->Model_pegawai->getdetail($id);
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('manager/pegawai/view_detail_pegawai', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar_pengguna');
            $this->load->view('manager/pegawai/view_detail_pegawai', $data);
            $this->load->view('templates/footer');
        }
    }
}
