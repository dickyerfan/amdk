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

        $data['title'] = 'Daftar Bingkisan Lebaran';
        $lebaran = $this->Model_lebaran->get_lebaran_keu($bulan, $tahun);
        $jenis_produk = $this->Model_lebaran->get_nama_barang();

        // Mengelompokkan data berdasarkan nama dan tanggal
        $grouped_lebaran = [];
        foreach ($lebaran as $row) {
            $key = $row->nama_pelanggan;
            if (!isset($grouped_lebaran[$key])) {
                $grouped_lebaran[$key] = (object)[
                    'nama_pelanggan' => $row->nama_pelanggan,
                    'jumlah' => [],
                    'harga_lebaran_total' => 0,
                    'keterangan' => $row->keterangan,
                ];
            }
            $grouped_lebaran[$key]->harga_lebaran_total += $row->harga_lebaran; // Menambahkan total harga
            $grouped_lebaran[$key]->jumlah[$row->nama_produk] = $row->jumlah_barang * $row->jumlah_orang;
        }
        $data['grouped_lebaran'] = $grouped_lebaran;
        $data['jenis_produk'] = $jenis_produk;


        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_lebaran', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_lebaran', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
    }


    public function pelunasan()
    {
        $tanggal = $this->session->userdata('tanggal');
        $bulan = substr($tanggal, 5, 2);
        $tahun = substr($tanggal, 0, 4);

        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
            $bulan = date('m');
            $tahun = date('Y');
        }

        $data['bulan_lap'] = $bulan;
        $data['tahun_lap'] = $tahun;
        $data['title'] = 'Input Penerimaaan Bingkisan Lebaran';
        $data['lebaran'] = $this->Model_lebaran->get_lebaran($tahun);
        $data['lunas_bayar'] = $this->Model_lebaran->get_lebaran_lunas($tahun);

        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar_uang');
        $this->load->view('templates/pengguna/sidebar_uang');
        $this->load->view('keuangan/view_input_terima_lebaran', $data);
        $this->load->view('templates/pengguna/footer_uang');
    }

    public function bayar()
    {
        $tanggal = $this->session->userdata('tanggal');
        $tahun = substr($tanggal, 0, 4);

        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
            $tahun = date('Y');
        }
        $total_bayar = $this->Model_lebaran->get_lebaran($tahun)[0]->total_harga;
        $total_lunas = $this->Model_lebaran->get_lebaran_lunas($tahun)[0]->total_bayar;

        if ($total_bayar == $total_lunas) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> Total lebaran sudah dibayar. Anda tidak dapat melakukan pelunasan lagi
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('keuangan/lebaran');
        } else {
            $this->Model_lebaran->update_lunas($tahun);

            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>Sukses,</strong> Data bingkisan lebaran berhasil di bayar
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                          </div>'
            );
            redirect('keuangan/lebaran');
        }
    }
}
