<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_penjualan');
        if (!$this->session->userdata('nama_pengguna')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = 'Daftar Penjualan Barang';
        $data['pesan'] = $this->Model_penjualan->get_all();
        if ($this->session->userdata('upk_bagian') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_penjualan', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_penjualan', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    // public function upload()
    // {
    //     $this->form_validation->set_rules('id_jenis_barang', 'Nama Barang', 'required|trim');
    //     $this->form_validation->set_rules('id_pelanggan', 'Nama Pelanggan', 'required|trim');
    //     $this->form_validation->set_rules('tanggal_pesan', 'Tanggal Pesan', 'required|trim');
    //     $this->form_validation->set_rules('jumlah_pesan', 'Jumlah Pesan', 'required|trim|numeric');
    //     $this->form_validation->set_message('required', '%s masih kosong');
    //     $this->form_validation->set_message('numeric', '%s harus berupa angka');


    //     if ($this->form_validation->run() == false) {
    //         $data['title'] = 'Transaksi Pemesanan Barang';
    //         $data['nama_barang'] = $this->Model_penjualan->get_jenis_barang();
    //         $data['pelanggan'] = $this->Model_penjualan->get_pelanggan();

    //         $this->load->view('templates/pengguna/header', $data);
    //         $this->load->view('templates/pengguna/navbar_uang');
    //         $this->load->view('templates/pengguna/sidebar_uang');
    //         $this->load->view('penjualan/view_tambah_pemesanan', $data);
    //         $this->load->view('templates/pengguna/footer');
    //     } else {
    //         $data['id_jenis_barang'] = $this->input->post('id_jenis_barang');
    //         $data['id_pelanggan'] = $this->input->post('id_pelanggan');
    //         $data['id_mobil'] = null;
    //         $data['tanggal_pesan'] = $this->input->post('tanggal_pesan');
    //         $data['jumlah_pesan'] = $this->input->post('jumlah_pesan');
    //         $data['input_pesan'] = $this->session->userdata('nama_lengkap');

    //         $tarif = $this->Model_penjualan->getTarifByIdPelanggan($data['id_pelanggan']);

    //         // Ambil harga dari jenis barang yang dipilih
    //         $harga_barang = $this->Model_penjualan->getHargaByJenisBarang($data['id_jenis_barang'], $tarif);
    //         $harga = $harga_barang->harga;

    //         // Hitung total harga
    //         $data['harga_barang'] = $harga;
    //         $data['total_harga'] = $harga * $data['jumlah_pesan'];

    //         $this->Model_penjualan->upload('pemesanan', $data);
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    //                     <strong>Sukses,</strong> Data Pesanan baru berhasil di tambah
    //                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                     </button>
    //                   </div>'
    //         );
    //         redirect('penjualan/pemesanan');
    //     }
    // }

    public function pilih_lunas($id_pemesanan)
    {
        $this->form_validation->set_rules('status_bayar', 'Status bayar', 'required|trim');
        $this->form_validation->set_message('required', '%s harus pilih');

        if ($this->form_validation->run() == false) {
            $data['lunas'] = $this->Model_penjualan->get_lunas($id_pemesanan);
            $data['title'] = 'Form Pelunasan';
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_pilih_lunas', $data);
            $this->load->view('templates/pengguna/footer');
        } else {
            $data['status_bayar'] = $this->input->post('status_bayar');
            $this->Model_penjualan->update('pemesanan', $data, $id_pemesanan);
            if ($this->db->affected_rows() <= 0) {
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Maaf,</strong> pembayaran gagal, pilih lunas untuk membayar
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                          </div>'
                );
                redirect('keuangan/penjualan');
            } else {
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>Sukses,</strong> Barang lunas dibayar
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                          </div>'
                );
                redirect('keuangan/penjualan');
            }
        }
    }
}
