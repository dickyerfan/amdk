<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ban_ops extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_ban_ops');
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
        if ($level_pengguna != 'Admin' && $upk_bagian != 'uang') {
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
            $this->session->set_userdata('tanggal', $tanggal);
        }

        $data['title'] = 'Daftar Bantuan / Operasional AMDK';
        $data['ban_ops'] = $this->Model_ban_ops->get_ban_ops($bulan, $tahun);
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_ban_ops', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_ban_ops', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
    }

    public function tambah()
    {
        $data['title'] = "Tambah Data Bantuan / Operasional";

        // $this->form_validation->set_rules('id_jenis_barang', 'Jenis Barang', 'required|trim');
        $this->form_validation->set_rules('id_jenis_barang', 'Jenis Barang', 'callback_check_checkbox');
        $this->form_validation->set_rules('jumlah_ban_ops', 'Jumlah', 'callback_check_jumlah_ban_ops');
        $this->form_validation->set_rules('jenis_ban_ops', 'Jenis', 'required|trim');
        $this->form_validation->set_rules('id_pelanggan', 'Nama Pelanggan', 'required|trim');
        $this->form_validation->set_rules('tanggal_ban_ops', 'Tanggal', 'required|trim');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required|trim');

        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('numeric', '%s harus di tulis angka');

        if ($this->form_validation->run() == false) {
            $data['jenis_barang'] = $this->Model_ban_ops->get_nama_barang();
            $data['mobil'] = $this->db->get('mobil')->result();
            $data['pelanggan'] = $this->Model_ban_ops->get_pelanggan();
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_tambah_ban_ops', $data);
            $this->load->view('templates/pengguna/footer_uang');
        } else {
            $data['user'] = $this->Model_ban_ops->tambahData();

            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Bantuan/Operasional Baru berhasil di tambah
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('keuangan/ban_ops');
        }

        if ($this->form_validation->run('check_jumlah_ban_ops') == false) {
            echo validation_errors(); // Tampilkan pesan kesalahan jika ada
        }
    }

    public function check_checkbox()
    {
        // Ambil data dari $_POST
        $id_jenis_barang = $this->input->post('id_jenis_barang');

        // Periksa apakah setidaknya satu checkbox dipilih
        if (!empty($id_jenis_barang)) {
            return true; // Setidaknya satu checkbox dipilih
        } else {
            $this->form_validation->set_message('check_checkbox', 'Pilih setidaknya satu barang.');
            return false; // Tidak ada checkbox yang dipilih
        }
    }

    public function check_jumlah_ban_ops()
    {
        // Ambil data dari $_POST
        $jumlah_ban_ops = $this->input->post('jumlah_ban_ops');

        // Periksa apakah setidaknya satu elemen pada $jumlah_ban_ops tidak kosong
        if (is_array($jumlah_ban_ops) && count(array_filter($jumlah_ban_ops)) > 0) {
            return true; // Setidaknya satu elemen pada $jumlah_ban_ops tidak kosong
        } else {
            $this->form_validation->set_message('check_jumlah_ban_ops', 'Isi jumlah barang.');
            return false; // Semua elemen pada $jumlah_ban_ops kosong
        }
    }

    public function edit($id_pelanggan)
    {
        $data['title'] = "Form Edit Pelanggan";
        $data['edit_pelanggan'] = $this->db->get_where('pelanggan', ['id_pelanggan' => $id_pelanggan])->row();
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar_uang');
        $this->load->view('templates/pengguna/sidebar_uang');
        $this->load->view('keuangan/view_edit_pelanggan', $data);
        $this->load->view('templates/pengguna/footer_uang');
    }

    public function update()
    {
        $this->Model_ban_ops->updateData();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('keuangan/ban_ops');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Pelanggan berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('keuangan/ban_ops');
        }
    }

    public function hapus($id_pelanggan)
    {
        $this->Model_ban_ops->hapusData($id_pelanggan);
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Sukses,</strong> Data Pelanggan berhasil di hapus
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                  </div>'
        );
        redirect('keuangan/ban_ops');
    }
}
