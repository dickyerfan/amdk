<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_ban_ops extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_laporan');
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
            $this->session->set_userdata('tanggal_ops', $tanggal);
        }

        $data['title'] = 'Laporan Operasional AMDK';
        // Ambil data dari model
        $ban_ops = $this->Model_laporan->get_ops($bulan, $tahun);
        $jenis_produk = $this->Model_laporan->get_jenis_produk();

        // Mengelompokkan data berdasarkan nama dan tanggal
        $grouped_ban_ops = [];
        foreach ($ban_ops as $row) {
            $key = $row->nama_ban_ops . $row->tanggal_ban_ops;
            if (!isset($grouped_ban_ops[$key])) {
                $grouped_ban_ops[$key] = (object)[
                    'nama_ban_ops' => $row->nama_ban_ops,
                    'tanggal_ban_ops' => $row->tanggal_ban_ops,
                    'jumlah' => [],
                    'harga_ban_ops_total' => 0,
                    'keterangan' => $row->keterangan,
                ];
            }
            $grouped_ban_ops[$key]->harga_ban_ops_total += $row->harga_ban_ops; // Menambahkan total harga
            $grouped_ban_ops[$key]->jumlah[$row->nama_barang_jadi] = $row->jumlah_ban_ops;
        }
        $data['grouped_ban_ops'] = $grouped_ban_ops;
        $data['jenis_produk'] = $jenis_produk;
        if ($this->session->userdata('upk_bagian') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_laporan_ops', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_laporan_ops', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
    }

    public function exportpdf_ops()
    {
        $tanggal = $this->session->userdata('tanggal_ops');
        $bulan = substr($tanggal, 5, 2);
        $tahun = substr($tanggal, 0, 4);

        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
            $bulan = date('m');
            $tahun = date('Y');
        }
        $data['bulan_lap'] = $bulan;
        $data['tahun_lap'] = $tahun;
        $data['title'] = 'Laporan Operasional AMDK';
        // Ambil data dari model
        $ban_ops = $this->Model_laporan->get_ops($bulan, $tahun);
        $jenis_produk = $this->Model_laporan->get_jenis_produk();

        // Mengelompokkan data berdasarkan nama dan tanggal
        $grouped_ban_ops = [];
        foreach ($ban_ops as $row) {
            $key = $row->nama_ban_ops . $row->tanggal_ban_ops;
            if (!isset($grouped_ban_ops[$key])) {
                $grouped_ban_ops[$key] = (object)[
                    'nama_ban_ops' => $row->nama_ban_ops,
                    'tanggal_ban_ops' => $row->tanggal_ban_ops,
                    'jumlah' => [],
                    'harga_ban_ops_total' => 0,
                    'keterangan' => $row->keterangan,
                ];
            }
            $grouped_ban_ops[$key]->harga_ban_ops_total += $row->harga_ban_ops;
            $grouped_ban_ops[$key]->jumlah[$row->nama_barang_jadi] = $row->jumlah_ban_ops;
        }
        $data['grouped_ban_ops'] = $grouped_ban_ops;
        $data['jenis_produk'] = $jenis_produk;

        $data['bulan_lap'] = $bulan;
        $data['tahun_lap'] = $tahun;
        $data['manager'] = $this->Model_laporan->get_manager();
        $data['uang'] = $this->Model_laporan->get_uang();

        $this->pdf->setPaper('folio', 'landscape');
        $this->pdf->filename = "LapOps-{$bulan}-{$tahun}.pdf";
        $this->pdf->generate('keuangan/laporan_operasional_pdf', $data);
    }

    public function lap_ban()
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
            $this->session->set_userdata('tanggal_ban', $tanggal);
        }

        $data['title'] = 'Laporan Bantuan AMDK';
        // Ambil data dari model
        $ban_ops = $this->Model_laporan->get_ban($bulan, $tahun);
        $jenis_produk = $this->Model_laporan->get_jenis_produk();

        // Mengelompokkan data berdasarkan nama dan tanggal
        $grouped_ban_ops = [];
        foreach ($ban_ops as $row) {
            $key = $row->nama_ban_ops . $row->tanggal_ban_ops;
            if (!isset($grouped_ban_ops[$key])) {
                $grouped_ban_ops[$key] = (object)[
                    'nama_ban_ops' => $row->nama_ban_ops,
                    'tanggal_ban_ops' => $row->tanggal_ban_ops,
                    'jumlah' => [],
                    'harga_ban_ops_total' => 0,
                    'keterangan' => $row->keterangan,
                ];
            }
            $grouped_ban_ops[$key]->harga_ban_ops_total += $row->harga_ban_ops; // Menambahkan total harga
            $grouped_ban_ops[$key]->jumlah[$row->nama_barang_jadi] = $row->jumlah_ban_ops;
        }
        $data['grouped_ban_ops'] = $grouped_ban_ops;
        $data['jenis_produk'] = $jenis_produk;
        if ($this->session->userdata('upk_bagian') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_laporan_ban', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_laporan_ban', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
    }

    public function exportpdf_ban()
    {
        $tanggal = $this->session->userdata('tanggal_ban');
        $bulan = substr($tanggal, 5, 2);
        $tahun = substr($tanggal, 0, 4);

        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
            $bulan = date('m');
            $tahun = date('Y');
        }
        $data['bulan_lap'] = $bulan;
        $data['tahun_lap'] = $tahun;
        $data['title'] = 'Laporan Operasional AMDK';
        // Ambil data dari model
        $ban_ops = $this->Model_laporan->get_ban($bulan, $tahun);
        $jenis_produk = $this->Model_laporan->get_jenis_produk();

        // Mengelompokkan data berdasarkan nama dan tanggal
        $grouped_ban_ops = [];
        foreach ($ban_ops as $row) {
            $key = $row->nama_ban_ops . $row->tanggal_ban_ops;
            if (!isset($grouped_ban_ops[$key])) {
                $grouped_ban_ops[$key] = (object)[
                    'nama_ban_ops' => $row->nama_ban_ops,
                    'tanggal_ban_ops' => $row->tanggal_ban_ops,
                    'jumlah' => [],
                    'harga_ban_ops_total' => 0,
                    'keterangan' => $row->keterangan,
                ];
            }
            $grouped_ban_ops[$key]->harga_ban_ops_total += $row->harga_ban_ops;
            $grouped_ban_ops[$key]->jumlah[$row->nama_barang_jadi] = $row->jumlah_ban_ops;
        }
        $data['grouped_ban_ops'] = $grouped_ban_ops;
        $data['jenis_produk'] = $jenis_produk;

        $data['bulan_lap'] = $bulan;
        $data['tahun_lap'] = $tahun;
        $data['manager'] = $this->Model_laporan->get_manager();
        $data['uang'] = $this->Model_laporan->get_uang();

        $this->pdf->setPaper('folio', 'landscape');
        $this->pdf->filename = "LapBan-{$bulan}-{$tahun}.pdf";
        $this->pdf->generate('keuangan/laporan_bantuan_pdf', $data);
    }
}
