<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Piutang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_piutang');
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
        if ($level_pengguna != 'Admin' && $upk_bagian != 'pasar') {
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
        if (empty($tanggal)) {
            $data['pesan'] = $this->Model_piutang->get_all();
            $bulan_lap = '';
            $tahun_lap = '';
        } else {
            $bulan = substr($tanggal, 5, 2);
            $tahun = substr($tanggal, 0, 4);
            $data['pesan'] = $this->Model_piutang->get_bulan_tahun($bulan, $tahun);
            $bulan_lap = $bulan;
            $tahun_lap = $tahun;
        }

        $data['bulan_lap'] = $bulan_lap;
        $data['tahun_lap'] = $tahun_lap;

        if (!empty($tanggal)) {
            $this->session->set_userdata('tanggal', $tanggal); // Simpan tanggal ke session jika diperlukan
        }
        $data['produk'] = $this->Model_piutang->get_produk();
        $data['pelanggan'] = $this->Model_piutang->get_pelanggan();
        $data['title'] = 'Daftar Piutang AMDK';
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('pemasaran/view_piutang', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_pasar');
            $this->load->view('templates/pengguna/sidebar_pasar');
            $this->load->view('pemasaran/view_piutang', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function pertanggal()
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
        $data['title'] = 'Daftar Piutang AMDK';
        $data['pesan'] = $this->Model_piutang->get_by_date($tanggal);
        $data['produk'] = $this->Model_piutang->get_produk();
        $data['pelanggan'] = $this->Model_piutang->get_pelanggan();
        $data['tanggal_hari_ini'] = $this->input->get('tanggal');
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('pemasaran/view_piutang_pertanggal', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_pasar');
            $this->load->view('templates/pengguna/sidebar_pasar');
            $this->load->view('pemasaran/view_piutang_pertanggal', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function nama_produk()
    {
        $id_produk = $this->input->post('id_produk');
        $data['title'] = 'Daftar Piutang AMDK Berdasarkan Produk';
        $data['nama_produk'] = $this->Model_piutang->get_by_produk($id_produk);
        $data['produk'] = $this->Model_piutang->get_produk();
        $data['pelanggan'] = $this->Model_piutang->get_pelanggan();

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('pemasaran/view_piutang_perproduk', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_pasar');
            $this->load->view('templates/pengguna/sidebar_pasar');
            $this->load->view('pemasaran/view_piutang_perproduk', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function nama_pelanggan()
    {
        $id_pelanggan = $this->input->post('id_pelanggan');
        $data['title'] = 'Daftar Piutang AMDK Berdasarkan Nama Pelanggan';
        $data['nama_pelanggan'] = $this->Model_piutang->get_by_pelanggan($id_pelanggan);
        $data['produk'] = $this->Model_piutang->get_produk();
        $data['pelanggan'] = $this->Model_piutang->get_pelanggan();

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('pemasaran/view_piutang_perpelanggan', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_pasar');
            $this->load->view('templates/pengguna/sidebar_pasar');
            $this->load->view('pemasaran/view_piutang_perpelanggan', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function upload_nota($id_pemesanan)
    {
        $data['upload_nota'] = $this->Model_piutang->get_id_pemesanan($id_pemesanan);
        $data['title'] = 'Form Upload Nota Pembelian';
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar_pasar');
        $this->load->view('templates/pengguna/sidebar_pasar');
        $this->load->view('pemasaran/view_tambah_nota_piutang', $data);
        $this->load->view('templates/pengguna/footer');
    }


    public function update_nota()
    {
        $tanggal = $this->session->userdata('tanggal');
        date_default_timezone_set('Asia/Jakarta');
        if (!empty($_FILES['nota_beli']['name'])) {

            // Lakukan proses upload file
            $config['upload_path']   = './uploads/pasar/nota/';
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['max_size']      = 1000;
            $config['overwrite']     = true; // Mengizinkan penggantian file yang ada dengan nama yang sama

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('nota_beli')) {
                $data_upload = $this->upload->data();
                $data['nota_beli'] = $data_upload['file_name'];
                $data['id_pemesanan'] = $this->input->post('id_pemesanan');
                $data['id_pelanggan'] = $this->input->post('id_pelanggan');
                $data['tanggal_pesan'] = $this->input->post('tanggal_pesan');
            } else {
                // Jika proses upload gagal
                $error_msg = $this->upload->display_errors();
                $this->session->set_flashdata('info', $error_msg);
                redirect('pemasaran/piutang');
            }

            // Isi data selain file yang diupload
            $data['input_update'] = $this->session->userdata('nama_lengkap');
            // $data['tanggal_update'] = date('Y-m-d H:i:s'); 
            $data['tanggal_update'] = $this->input->post('tanggal_update');
            $data['status_nota'] = 1;
            $data['status_pesan'] = 1;

            // Simpan data ke dalam database
            $this->Model_piutang->update_nota($data);
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>Sukses,</strong> Nota Pembelian berhasil di upload
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            $alamat = 'pemasaran/piutang?tanggal=' . $tanggal;
            redirect($alamat);
            // redirect('pemasaran/piutang');
        } else {
            // Tampilkan pesan kesalahan jika tidak ada file yang diunggah
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal,</strong> Silakan masukkan bukti nota pembayaran
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            $alamat = 'pemasaran/piutang?tanggal=' . $tanggal;
            redirect($alamat);
            // redirect('pemasaran/piutang');
        }
    }
}
