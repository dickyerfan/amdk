<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemesanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_pemesanan');
        // if (!$this->session->userdata('nama_pengguna')) {
        //     redirect('auth');
        // }
        if ($this->session->userdata('upk_bagian') != 'pasar') {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> Anda harus login sebagai Admin Pemasaran...
                      </div>'
            );
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = 'Daftar Pemesanan Barang';
        $data['pesan'] = $this->Model_pemesanan->get_all();
        if ($this->session->userdata('upk_bagian') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('pemasaran/view_pemesanan', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_pasar');
            $this->load->view('templates/pengguna/sidebar_pasar');
            $this->load->view('pemasaran/view_pemesanan', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function upload()
    {
        $this->form_validation->set_rules('id_jenis_barang', 'Nama Barang', 'required|trim');
        $this->form_validation->set_rules('id_pelanggan', 'Nama Pelanggan', 'required|trim');
        // $this->form_validation->set_rules('id_mobil', 'Nama Mobil', 'required|trim');
        $this->form_validation->set_rules('tanggal_pesan', 'Tanggal Pesan', 'required|trim');
        $this->form_validation->set_rules('jenis_pesanan', 'Jenis Pesanan', 'required|trim');
        $this->form_validation->set_rules('jumlah_pesan', 'Jumlah Pesan', 'required|trim|numeric');
        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('numeric', '%s harus berupa angka');


        if ($this->form_validation->run() == false) {
            $data['title'] = 'Transaksi Pemesanan Barang';
            $data['nama_barang'] = $this->Model_pemesanan->get_produk();
            $data['pelanggan'] = $this->Model_pemesanan->get_pelanggan();

            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_pasar');
            $this->load->view('templates/pengguna/sidebar_pasar');
            $this->load->view('pemasaran/view_tambah_pemesanan', $data);
            $this->load->view('templates/pengguna/footer');
        } else {
            $data['id_jenis_barang'] = $this->input->post('id_jenis_barang');
            $data['id_pelanggan'] = $this->input->post('id_pelanggan');
            $data['id_mobil'] = null;
            $data['tanggal_pesan'] = $this->input->post('tanggal_pesan');
            $data['jenis_pesanan'] = $this->input->post('jenis_pesanan');
            $data['jumlah_pesan'] = $this->input->post('jumlah_pesan');
            $data['input_pesan'] = $this->session->userdata('nama_lengkap');

            $tarif = $this->Model_pemesanan->getTarifByIdPelanggan($data['id_pelanggan']);

            // Ambil harga dari jenis barang yang dipilih
            $harga_barang = $this->Model_pemesanan->getHargaByJenisBarang($data['id_jenis_barang'], $tarif);
            $harga = $harga_barang->harga;

            // Hitung total harga
            $data['harga_barang'] = $harga;
            $data['total_harga'] = $harga * $data['jumlah_pesan'];

            $this->Model_pemesanan->upload('pemesanan', $data);
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Pesanan baru berhasil di tambah
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('pemasaran/pemesanan');
        }
    }

    public function pilih_mobil($id_pemesanan)
    {
        $this->form_validation->set_rules('id_mobil', 'Nama Mobil', 'required|trim');
        $this->form_validation->set_message('required', '%s masih kosong');

        if ($this->form_validation->run() == false) {
            // $data['mobil'] = $this->Model_pemesanan->get_id_masuk_baku($id_pemesanan);
            $data['mobil'] = $this->Model_pemesanan->get_mobil();
            $data['title'] = 'Form Pilih Mobil';
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_pasar');
            $this->load->view('templates/pengguna/sidebar_pasar');
            $this->load->view('pemasaran/view_pilih_mobil', $data);
            $this->load->view('templates/pengguna/footer');
        } else {

            $data['id_mobil'] = $this->input->post('id_mobil');
            $this->Model_pemesanan->update('pemesanan', $data, $id_pemesanan);

            // Dapatkan data untuk penyisipan ke tabel keluar_jadi
            $data_pemesanan = $this->Model_pemesanan->get_id_masuk_baku($id_pemesanan);
            $data_keluar_jadi = array(
                'id_jenis_barang' => $data_pemesanan->id_jenis_barang,
                'jumlah_keluar' => $data_pemesanan->jumlah_pesan,
                'tanggal_keluar' => $data_pemesanan->tanggal_pesan,
                'jumlah_akhir' => $data_pemesanan->jumlah_pesan,
                'jenis_pesanan' => $data_pemesanan->jenis_pesanan,
                'input_status_keluar' => $this->session->userdata('nama_lengkap')
            );

            // Sisipkan data ke dalam tabel keluar_jadi
            $this->Model_pemesanan->tambah_keluar_jadi('keluar_jadi', $data_keluar_jadi);


            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> data Mobil berhasil di tambah
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('pemasaran/pemesanan');
        }
    }

    public function detail_masuk($id_masuk_baku)
    {
        $data['detail_barang_masuk'] = $this->Model_barang_baku->get_detail_barang_masuk($id_masuk_baku);
        $data['title'] = 'Detail Barang Baku';
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar');
        $this->load->view('templates/pengguna/sidebar_baku');
        $this->load->view('barang_baku/view_detail_masuk_barang_baku', $data);
        $this->load->view('templates/pengguna/footer');
    }
}
