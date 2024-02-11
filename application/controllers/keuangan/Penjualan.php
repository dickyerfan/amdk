<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_penjualan');
        $this->load->model('Model_pemesanan');
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
            $this->session->set_userdata('tanggal', $tanggal); // Simpan tanggal ke session jika diperlukan
        }

        $data['tanggal_hari_ini'] = $this->input->get('tanggal');
        $data['title'] = 'Daftar Penjualan Barang';
        $data['pesan'] = $this->Model_penjualan->get_all($tanggal);
        // $data['pesan'] = $this->Model_penjualan->get_all($bulan, $tahun);
        if ($this->session->userdata('level') == 'Admin') {
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
            $this->load->view('templates/pengguna/footer_uang');
        }
    }

    public function pilih_lunas($id_pemesanan)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->form_validation->set_rules('status_bayar', 'Status bayar', 'required|trim');
        $this->form_validation->set_rules('tanggal_bayar', 'Tanggal bayar', 'required|trim');
        $this->form_validation->set_message('required', '%s harus pilih');

        if ($this->form_validation->run() == false) {
            $data['lunas'] = $this->Model_penjualan->get_lunas($id_pemesanan);
            $data['title'] = 'Form Pelunasan';
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_pilih_lunas', $data);
            $this->load->view('templates/pengguna/footer_uang');
        } else {

            $data['status_bayar'] = $this->input->post('status_bayar');
            $data['status_pesan'] = 0;
            $data['input_bayar'] = $this->session->userdata('nama_lengkap');
            // $data['tanggal_bayar'] = date('Y-m-d H:i:s');
            $data['tanggal_bayar'] = $this->input->post('tanggal_bayar');

            // Periksa bulan dan tahun antara tanggal_pesan dan tanggal_bayar
            $bulan_tahun_pesan = date('Y-m', strtotime($this->db->get_where('pemesanan', ['id_pemesanan' => $id_pemesanan])->row()->tanggal_pesan));
            $bulan_tahun_bayar = date('Y-m', strtotime($data['tanggal_bayar']));

            if ($bulan_tahun_bayar > $bulan_tahun_pesan) {
                // Jika bulan dan tahun tanggal_bayar lebih besar dari tanggal_pesan, update status_piutang tetap 1
                $data['status_piutang'] = 1;
            } else {
                // Jika bulan dan tahun tanggal_bayar sama atau lebih kecil dari tanggal_pesan, status_piutang menjadi 0
                $data['status_piutang'] = 0;
            }

            $this->Model_penjualan->update('pemesanan', $data, $id_pemesanan);
            $cek_lunas = $this->db->get_where('pemesanan', ['id_pemesanan' => $id_pemesanan])->row();
            if ($cek_lunas->status_bayar == 0) {
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

    public function detail($id_pemesanan)
    {
        $data['detail_pemesanan'] = $this->Model_pemesanan->get_detail_pemesanan($id_pemesanan);
        $data['title'] = 'Detail Penjualan Barang';
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar_uang');
        $this->load->view('templates/pengguna/sidebar_uang');
        $this->load->view('keuangan/view_detail_pemesanan', $data);
        $this->load->view('templates/pengguna/footer_uang');
    }

    public function cek_status_pesanan()
    {
        $this->db->select('*');
        $this->db->from('pemesanan');
        $this->db->where('status_pesan', 1);
        $result = $this->db->get()->result();

        if ($result) {
            $response['success'] = true;
        } else {
            $response['success'] = false;
        }

        echo json_encode($response);
    }

    // public function update_status_pesan()
    // {
    //     $data = [
    //         'status_pesan' => 0
    //     ];
    //     $this->db->update('pemesanan', $data);
    //     redirect('keuangan/penjualan');
    // }
}
