<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rutin_karyawan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_rutin_karyawan');
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
        if ($level_pengguna != 'Admin' && $upk_bagian != 'jadi') {
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
        $tanggal = $this->input->get('tanggal');
        $bulan = substr($tanggal, 5, 2);
        $tahun = substr($tanggal, 0, 4);

        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
            $bulan = date('m');
            $tahun = date('Y');
        }
        $data['bulan_lap'] = $bulan;
        $data['tahun_lap'] = $tahun;

        if (!empty($tanggal)) {
            $this->session->set_userdata('tanggal', $tanggal); // Simpan tanggal ke session jika diperlukan
        }

        $data['title'] = 'Daftar Rutin Karyawan PDAM';
        $data['rutin'] = $this->Model_rutin_karyawan->get_all();
        if ($this->session->userdata('upk_bagian') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_jadi/view_rutin_karyawan', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_jadi');
            $this->load->view('templates/pengguna/sidebar_jadi');
            $this->load->view('barang_jadi/view_rutin_karyawan', $data);
            $this->load->view('templates/pengguna/footer_jadi');
        }
    }

    public function tambah()
    {
        $data['title'] = "Tambah Daftar Rutin Karyawan";

        $this->form_validation->set_rules('id_bagian', 'Bagian', 'required|trim');
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('no_hp', 'No HP', 'required|trim|numeric');

        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('numeric', '%s harus di tulis angka');
        // $this->form_validation->set_message('is_unique', '%s Sudah terdaftar, Ganti yang lain');

        if ($this->form_validation->run() == false) {
            $data['bagian'] = $this->db->get('bagian')->result();
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_jadi');
            $this->load->view('templates/pengguna/sidebar_jadi');
            $this->load->view('barang_jadi/view_tambah_rutin_karyawan', $data);
            $this->load->view('templates/pengguna/footer_jadi');
        } else {
            $data['user'] = $this->Model_rutin_karyawan->tambahData();
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data rutin karyawan Baru berhasil di tambah
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('barang_jadi/rutin_karyawan');
        }
    }

    public function edit($id_rutin)
    {
        $data['title'] = "Form Edit Rutin Karyawan";
        $data['edit_rutin'] = $this->db->get_where('rutin_pegawai', ['id_rutin' => $id_rutin])->row();
        $data['bagian'] = $this->db->get('bagian')->result();
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar_jadi');
        $this->load->view('templates/pengguna/sidebar_jadi');
        $this->load->view('barang_jadi/view_edit_rutin_karyawan', $data);
        $this->load->view('templates/pengguna/footer_jadi');
    }

    public function update()
    {
        $this->Model_rutin_karyawan->updateData();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('barang_jadi/rutin_karyawan');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Rutin Karyawan berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('barang_jadi/rutin_karyawan');
        }
    }

    public function hapus($id_rutin)
    {
        $this->Model_rutin_karyawan->hapusData($id_rutin);
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Sukses,</strong> Data Rutin Karyawan berhasil di hapus
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                  </div>'
        );
        redirect('barang_jadi/rutin_karyawan');
    }
}
