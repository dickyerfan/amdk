<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengembalian_galon extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_barang_produksi');
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
        if ($level_pengguna != 'Admin' && $upk_bagian != 'produksi') {
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
        $data['title'] = 'Pengembalian Galon 19 liter';
        $data['galon'] = $this->Model_barang_produksi->get_galon($bulan, $tahun);
        if ($this->session->userdata('upk_bagian') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_produksi/view_galon', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_produksi');
            $this->load->view('templates/pengguna/sidebar_produksi');
            $this->load->view('barang_produksi/view_galon', $data);
            $this->load->view('templates/pengguna/footer_produksi');
        }
    }


    public function upload()
    {
        $this->form_validation->set_rules('jumlah_kembali', 'Jumlah Kembali', 'required|trim|numeric');
        $this->form_validation->set_rules('tanggal_kembali', 'Tanggal Kembali', 'required|trim|is_unique[galon_kembali.tanggal_kembali]');
        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('numeric', '%s harus berupa angka');
        $this->form_validation->set_message('is_unique', '%s sudah ada');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Form Pengembalian Galon';
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_produksi');
            $this->load->view('templates/pengguna/sidebar_produksi');
            $this->load->view('barang_produksi/view_tambah_galon_kembali', $data);
            $this->load->view('templates/pengguna/footer_produksi');
        } else {

            $data['tanggal_kembali'] = $this->input->post('tanggal_kembali', true);
            $data['jumlah_kembali'] = $this->input->post('jumlah_kembali', true);
            $data['input_status_kembali'] = $this->session->userdata('nama_lengkap');

            // Ambil data jumlah_produksi dan jumlah_rusak dari tabel galon_kembali berdasarkan tanggal_kembali
            $this->db->where('tanggal_kembali', $data['tanggal_kembali']);
            $query = $this->db->get('galon_kembali');
            $result = $query->row();

            // Hitung jumlah_akhir
            $data['jumlah_akhir'] = $data['jumlah_kembali'] - $result->jumlah_produksi - $result->jumlah_rusak;


            $this->db->insert('galon_kembali', $data);

            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>Sukses,</strong> Pengembalian galon baru berhasil di simpan
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>'
            );
            redirect('barang_produksi/pengembalian_galon');
        }
    }


    public function detail($id_galon_kembali)
    {
        $data['detail_barang_rusak'] = $this->Model_barang_produksi->get_detail_galon($id_galon_kembali);
        $data['title'] = 'Detail Pengembalian Galon';
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar_produksi');
        $this->load->view('templates/pengguna/sidebar_produksi');
        $this->load->view('barang_produksi/view_detail_galon', $data);
        $this->load->view('templates/pengguna/footer_produksi');
    }
}
