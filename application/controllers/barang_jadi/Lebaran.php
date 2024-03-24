<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lebaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_lebaran');
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
            $this->session->set_userdata('tanggal', $tanggal);
        }

        $data['title'] = 'Daftar Bingkisan Hari Raya';
        $data['lebaran'] = $this->Model_lebaran->get_lebaran($bulan, $tahun);
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_jadi/view_lebaran', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_jadi');
            $this->load->view('templates/pengguna/sidebar_jadi');
            $this->load->view('barang_jadi/view_lebaran', $data);
            $this->load->view('templates/pengguna/footer_jadi');
        }
    }

    public function tambah()
    {
        $data['title'] = "Tambah Data Bingkisan Lebaran";
        $tanggal = $this->session->userdata('tanggal');
        $this->form_validation->set_rules('id_jenis_barang', 'Jenis Barang', 'callback_check_checkbox');
        $this->form_validation->set_rules('id_pelanggan', 'Nama Pelanggan', 'required|trim');
        $this->form_validation->set_rules('jumlah_barang', 'Jumlah', 'callback_check_jumlah_barang');
        $this->form_validation->set_rules('jumlah_orang', 'Jumlah', 'required|trim');

        $this->form_validation->set_message('required', '%s masih kosong');

        if ($this->form_validation->run() == false) {
            $data['jenis_barang'] = $this->Model_lebaran->get_nama_barang();
            $data['pelanggan'] = $this->Model_lebaran->get_pelanggan();
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_jadi');
            $this->load->view('templates/pengguna/sidebar_jadi');
            $this->load->view('barang_jadi/view_tambah_lebaran', $data);
            $this->load->view('templates/pengguna/footer_jadi');
        } else {
            $data['user'] = $this->Model_lebaran->tambahData();

            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Bingkisan lebaran Baru berhasil di tambah
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            // $alamat = 'keuangan/ban_ops?tanggal=' . $tanggal;
            // redirect($alamat);
            redirect('barang_jadi/lebaran');
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

    public function check_jumlah_barang()
    {
        // Ambil data dari $_POST
        $jumlah_barang = $this->input->post('jumlah_barang');

        // Periksa apakah setidaknya satu elemen pada $jumlah_barang tidak kosong
        if (is_array($jumlah_barang) && count(array_filter($jumlah_barang)) > 0) {
            return true; // Setidaknya satu elemen pada $jumlah_barang tidak kosong
        } else {
            $this->form_validation->set_message('check_jumlah_barang', 'Isi jumlah barang.');
            return false; // Semua elemen pada $jumlah_lebaran kosong
        }
    }

    // public function exportpdf()
    // {
    //     $tanggal = $this->session->userdata('tanggal');
    //     $bulan = substr($tanggal, 5, 2);
    //     $tahun = substr($tanggal, 0, 4);

    //     if (empty($tanggal)) {
    //         $tanggal = date('Y-m-d');
    //         $bulan = date('m');
    //         $tahun = date('Y');
    //     }
    //     $data['bulan_lap'] = $bulan;
    //     $data['tahun_lap'] = $tahun;
    //     $data['title'] = 'Daftar Pembelian Karyawan PDAM';
    //     $data['rutin'] = $this->Model_ambil_rutin_karyawan->get_all($bulan, $tahun);

    //     $data['bulan_lap'] = $bulan;
    //     $data['tahun_lap'] = $tahun;
    //     $data['manager'] = $this->Model_laporan->get_manager();
    //     $data['jadi'] = $this->Model_laporan->get_jadi();

    //     // Set paper size and orientation
    //     $this->pdf->setPaper('folio', 'landscape');

    //     // $this->pdf->filename = "Potensi Sr.pdf";
    //     $this->pdf->filename = "Lap_rutin_kyw_belum-{$bulan}-{$tahun}.pdf";
    //     $this->pdf->generate('barang_jadi/laporan_data_karyawan_keu_pdf', $data);
    // }
}
