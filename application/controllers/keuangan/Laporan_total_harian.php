<?php

use PhpParser\Node\Stmt\Foreach_;

defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_total_harian extends CI_Controller
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

        $bulan_lalu = $bulan - 1;
        $tahun_lalu = $tahun;
        if ($bulan == 1) {
            $bulan_lalu = 12;
            $tahun_lalu = $tahun - 1;
        }

        if (!empty($tanggal)) {
            $this->session->set_userdata('tanggal_total_harian', $tanggal);
        }

        $data['title'] = 'Total Laporan Harian AMDK';
        $data['data_produksi'] = $this->Model_laporan->get_barang_produksi_lap($bulan, $tahun);
        $data['data_terjual'] = $this->Model_laporan->get_terjual($bulan, $tahun);
        $data['data_lunas'] = $this->Model_laporan->get_lunas_lap($bulan, $tahun);
        $data['data_piutang'] = $this->Model_laporan->get_piutang_lap($bulan, $tahun);
        $data['data_penerimaan'] = $this->Model_laporan->get_penerimaan_lap($bulan, $tahun);
        $data['data_penerimaan_lalu'] = $this->Model_laporan->get_penerimaan_lap_lalu($bulan_lalu, $tahun_lalu);
        $data['data_baku_terima'] = $this->Model_laporan->get_baku_terima_lap($bulan, $tahun);
        $data['data_baku_pakai'] = $this->Model_laporan->get_baku_pakai_lap($bulan, $tahun);
        $data['data_air_produksi_lap'] = $this->Model_laporan->get_air_produksi_lap($bulan, $tahun);
        $data['data_air_pakai_lap'] = $this->Model_laporan->get_air_pakai_lap($bulan, $tahun);

        // $data_barang = array_merge($data['data_baku_terima'], $data['data_baku_pakai']);
        // $data['data_barang'] = $data_barang;

        // $jumlah_total = 0;
        // foreach ($data['data_penerimaan'] as $row) {
        //     $jumlah_total += $row->total_terima;
        // }
        // $data['total_penerimaan'] = $jumlah_total;

        $jumlah_total = 0;
        foreach ($data['data_penerimaan_lalu'] as $row) {
            $jumlah_total += $row->total_terima_lalu;
        }
        $data['total_penerimaan_lalu'] = $jumlah_total;

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_laporan_total_harian', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_laporan_total_harian', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
    }

    public function exportpdf()
    {

        $tanggal = $this->session->userdata('tanggal_total_harian');

        if (empty($tanggal)) {
            $tanggal = $this->input->get('tanggal');
        }
        $bulan = substr($tanggal, 5, 2);
        $tahun = substr($tanggal, 0, 4);

        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
            $bulan = date('m');
            $tahun = date('Y');
        }
        $data['bulan_lap'] = $bulan;
        $data['tahun_lap'] = $tahun;

        $bulan_lalu = $bulan - 1;
        $tahun_lalu = $tahun;
        if ($bulan == 1) {
            $bulan_lalu = 12;
            $tahun_lalu = $tahun - 1;
        }

        $data['title'] = 'Total Laporan Harian AMDK';
        $data['data_produksi'] = $this->Model_laporan->get_barang_produksi_lap($bulan, $tahun);
        $data['data_terjual'] = $this->Model_laporan->get_terjual($bulan, $tahun);
        $data['data_lunas'] = $this->Model_laporan->get_lunas_lap($bulan, $tahun);
        $data['data_piutang'] = $this->Model_laporan->get_piutang_lap($bulan, $tahun);
        $data['data_penerimaan'] = $this->Model_laporan->get_penerimaan_lap($bulan, $tahun);
        $data['data_penerimaan_lalu'] = $this->Model_laporan->get_penerimaan_lap_lalu($bulan_lalu, $tahun_lalu);
        $data['data_baku_terima'] = $this->Model_laporan->get_baku_terima_lap($bulan, $tahun);
        $data['data_baku_pakai'] = $this->Model_laporan->get_baku_pakai_lap($bulan, $tahun);
        $data['data_air_produksi_lap'] = $this->Model_laporan->get_air_produksi_lap($bulan, $tahun);
        $data['data_air_pakai_lap'] = $this->Model_laporan->get_air_pakai_lap($bulan, $tahun);

        // $data_barang = array_merge($data['data_baku_terima'], $data['data_baku_pakai']);
        // $data['data_barang'] = $data_barang;

        $data['bulan_lap'] = $bulan;
        $data['tahun_lap'] = $tahun;
        $data['manager'] = $this->Model_laporan->get_manager();
        $data['uang'] = $this->Model_laporan->get_uang();

        $jumlah_total = 0;
        foreach ($data['data_penerimaan_lalu'] as $row) {
            $jumlah_total += $row->total_terima_lalu;
        }
        $data['total_penerimaan_lalu'] = $jumlah_total;

        // Set paper size and orientation
        $this->pdf->setPaper('folio', 'portrait');

        // $this->pdf->filename = "Potensi Sr.pdf";
        $this->pdf->filename = "Lap_total_harian-{$bulan}-{$tahun}.pdf";
        $this->pdf->generate('keuangan/laporan_total_harian_pdf', $data);
    }
}
