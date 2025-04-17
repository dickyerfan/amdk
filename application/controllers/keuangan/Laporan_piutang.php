<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_piutang extends CI_Controller
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
        if (empty($tanggal)) {
            // Kosongkan session saat semua piutang dipilih
            $this->session->unset_userdata('session_perbulan');
            $data['data_piutang'] = $this->Model_laporan->get_piutang_all();
            $bulan_lap = '';
            $tahun_lap = '';
        } else {
            $bulan = substr($tanggal, 5, 2);
            $tahun = substr($tanggal, 0, 4);
            $data['data_piutang'] = $this->Model_laporan->get_piutang_bulan($bulan, $tahun);
            $bulan_lap = $bulan;
            $tahun_lap = $tahun;
            $this->session->set_userdata('session_perbulan', $tanggal);
        }
        $data['bulan_lap'] = $bulan_lap;
        $data['tahun_lap'] = $tahun_lap;

        $data['title'] = 'Laporan Piutang AMDK';
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_laporan_piutang', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_laporan_piutang', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
    }

    public function exportpdf()
    {

        $tanggal = $this->session->userdata('session_perbulan');

        if (empty($tanggal)) {
            $data['data_piutang'] = $this->Model_laporan->get_piutang_all();
            $bulan_lap = '';
            $tahun_lap = '';
        } else {
            $bulan = substr($tanggal, 5, 2);
            $tahun = substr($tanggal, 0, 4);
            $data['data_piutang'] = $this->Model_laporan->get_piutang_bulan($bulan, $tahun);
            $bulan_lap = $bulan;
            $tahun_lap = $tahun;
        }
        $data['bulan_lap'] = $bulan_lap;
        $data['tahun_lap'] = $tahun_lap;

        $data['title'] = 'Laporan Piutang AMDK';

        $data['manager'] = $this->Model_laporan->get_manager();
        $data['uang'] = $this->Model_laporan->get_uang();

        $this->pdf->setPaper('folio', 'portrait');

        if (!empty($bulan_lap) && !empty($tahun_lap)) {
            $this->pdf->filename = "Lap_piutang_perbulan-{$bulan_lap}-{$tahun_lap}.pdf";
        } else {
            $this->pdf->filename = "Lap_piutang_perbulan.pdf";
        }
        $this->pdf->generate('keuangan/laporan_piutang_perbulan_pdf', $data);
    }

    public function piutang_pertahun()
    {
        $tahun = $this->input->get('tahun');
        if (empty($tahun)) {
            // Kosongkan session saat semua piutang dipilih
            $this->session->unset_userdata('session_pertahun');
            $data['data_piutang'] = $this->Model_laporan->get_piutang_all();
            $tahun_lap = '';
        } else {
            $tahun = substr($tahun, 0, 4);
            $data['data_piutang'] = $this->Model_laporan->get_piutang_tahun($tahun);
            $tahun_lap = $tahun;
            $this->session->set_userdata('session_pertahun', $tahun);
        }
        $data['tahun_lap'] = $tahun_lap;


        $data['title'] = 'Laporan Piutang AMDK';
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_laporan_piutang_pertahun', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_laporan_piutang_pertahun', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
    }

    public function exportpdf_pertahun()
    {

        $tahun = $this->session->userdata('session_pertahun');

        if (empty($tahun)) {
            $data['data_piutang'] = $this->Model_laporan->get_piutang_all();
            $tahun_lap = '';
        } else {
            $tahun = substr($tahun, 0, 4);
            $data['data_piutang'] = $this->Model_laporan->get_piutang_tahun($tahun);
            $tahun_lap = $tahun;
        }
        $data['tahun_lap'] = $tahun_lap;

        $data['title'] = 'Laporan Piutang AMDK';

        $data['manager'] = $this->Model_laporan->get_manager();
        $data['uang'] = $this->Model_laporan->get_uang();

        $this->pdf->setPaper('folio', 'portrait');

        if (!empty($tahun_lap)) {
            $this->pdf->filename = "Lap_piutang_pertahun-{$tahun_lap}.pdf";
        } else {
            $this->pdf->filename = "Lap_piutang_pertahun.pdf";
        }
        $this->pdf->generate('keuangan/laporan_piutang_pertahun_pdf', $data);
    }

    public function piutang_samden()
    {
        $samden = $this->input->get('samden');
        if (empty($samden)) {
            // Kosongkan session saat semua piutang dipilih
            $this->session->unset_userdata('session_samden');
            $data['data_piutang'] = $this->Model_laporan->get_piutang_all();
            $samden_lap = '';
        } else {
            $data['data_piutang'] = $this->Model_laporan->get_piutang_samden($samden);
            $samden_lap = $samden;
            $this->session->set_userdata('session_samden', $samden);
        }
        $data['samden_lap'] = $samden_lap;

        $data['title'] = 'Laporan Piutang AMDK';
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_laporan_piutang_persamden', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_laporan_piutang_persamden', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
    }

    public function exportpdf_samden()
    {

        $samden = $this->session->userdata('session_samden');
        if (empty($samden)) {
            $data['data_piutang'] = $this->Model_laporan->get_piutang_all();
            $samden_lap = '';
        } else {
            $data['data_piutang'] = $this->Model_laporan->get_piutang_samden($samden);
            $samden_lap = $samden;
        }
        $data['samden_lap'] = $samden_lap;

        $data['title'] = 'Laporan Piutang AMDK';

        $data['manager'] = $this->Model_laporan->get_manager();
        $data['uang'] = $this->Model_laporan->get_uang();

        $this->pdf->setPaper('folio', 'portrait');

        if (!empty($samden_lap)) {
            $this->pdf->filename = "Lap_piutang_sampai_dengan-{$samden_lap}.pdf";
        } else {
            $this->pdf->filename = "Lap_piutang_sampai_dengan.pdf";
        }
        $this->pdf->generate('keuangan/laporan_piutang_sampai_dengan_pdf', $data);
    }

    public function umur_piutang()
    {
        $tanggal_sekarang = date('Y-m-d');
        $data['data_piutang'] = $this->Model_laporan->get_piutang_umur($tanggal_sekarang);

        $total_barang_1_bulan = 0;
        $total_piutang_1_bulan = 0;
        $total_barang_2_bulan = 0;
        $total_piutang_2_bulan = 0;
        $total_barang_3_bulan = 0;
        $total_piutang_3_bulan = 0;
        $total_barang_4_bulan = 0;
        $total_piutang_4_bulan = 0;
        $total_barang_5_bulan = 0;
        $total_piutang_5_bulan = 0;
        $total_barang_6_bulan = 0;
        $total_piutang_6_bulan = 0;
        $total_barang_7_bulan = 0;
        $total_piutang_7_bulan = 0;
        $total_barang_8_bulan = 0;
        $total_piutang_8_bulan = 0;
        $total_barang_9_bulan = 0;
        $total_piutang_9_bulan = 0;
        $total_barang_10_bulan = 0;
        $total_piutang_10_bulan = 0;
        $total_barang_11_bulan = 0;
        $total_piutang_11_bulan = 0;
        $total_barang_12_bulan = 0;
        $total_piutang_12_bulan = 0;
        $total_barang_1_tahun_keatas = 0;
        $total_piutang_1_tahun_keatas = 0;

        foreach ($data['data_piutang'] as $piutang) {
            $total_barang_1_bulan += $piutang->total_barang_1_bulan;
            $total_piutang_1_bulan += $piutang->total_piutang_1_bulan;
            $total_barang_2_bulan += $piutang->total_barang_2_bulan;
            $total_piutang_2_bulan += $piutang->total_piutang_2_bulan;
            $total_barang_3_bulan += $piutang->total_barang_3_bulan;
            $total_piutang_3_bulan += $piutang->total_piutang_3_bulan;
            $total_barang_4_bulan += $piutang->total_barang_4_bulan;
            $total_piutang_4_bulan += $piutang->total_piutang_4_bulan;
            $total_barang_5_bulan += $piutang->total_barang_5_bulan;
            $total_piutang_5_bulan += $piutang->total_piutang_5_bulan;
            $total_barang_6_bulan += $piutang->total_barang_6_bulan;
            $total_piutang_6_bulan += $piutang->total_piutang_6_bulan;
            $total_barang_7_bulan += $piutang->total_barang_7_bulan;
            $total_piutang_7_bulan += $piutang->total_piutang_7_bulan;
            $total_barang_8_bulan += $piutang->total_barang_8_bulan;
            $total_piutang_8_bulan += $piutang->total_piutang_8_bulan;
            $total_barang_9_bulan += $piutang->total_barang_9_bulan;
            $total_piutang_9_bulan += $piutang->total_piutang_9_bulan;
            $total_barang_10_bulan += $piutang->total_barang_10_bulan;
            $total_piutang_10_bulan += $piutang->total_piutang_10_bulan;
            $total_barang_11_bulan += $piutang->total_barang_11_bulan;
            $total_piutang_11_bulan += $piutang->total_piutang_11_bulan;
            $total_barang_12_bulan += $piutang->total_barang_12_bulan;
            $total_piutang_12_bulan += $piutang->total_piutang_12_bulan;
            $total_barang_1_tahun_keatas += $piutang->total_barang_1_tahun_keatas;
            $total_piutang_1_tahun_keatas += $piutang->total_piutang_1_tahun_keatas;
        }

        $data['total_barang_1_bulan'] = $total_barang_1_bulan;
        $data['total_piutang_1_bulan'] = $total_piutang_1_bulan;
        $data['total_barang_2_bulan'] = $total_barang_2_bulan;
        $data['total_piutang_2_bulan'] = $total_piutang_2_bulan;
        $data['total_barang_3_bulan'] = $total_barang_3_bulan;
        $data['total_piutang_3_bulan'] = $total_piutang_3_bulan;
        $data['total_barang_4_bulan'] = $total_barang_4_bulan;
        $data['total_piutang_4_bulan'] = $total_piutang_4_bulan;
        $data['total_barang_5_bulan'] = $total_barang_5_bulan;
        $data['total_piutang_5_bulan'] = $total_piutang_5_bulan;
        $data['total_barang_6_bulan'] = $total_barang_6_bulan;
        $data['total_piutang_6_bulan'] = $total_piutang_6_bulan;
        $data['total_barang_7_to_12_bulan'] = $total_barang_7_bulan + $total_barang_8_bulan + $total_barang_9_bulan + $total_barang_10_bulan + $total_barang_11_bulan + $total_barang_12_bulan;
        $data['total_piutang_7_to_12_bulan'] = $total_piutang_7_bulan + $total_piutang_8_bulan + $total_piutang_9_bulan + $total_piutang_10_bulan + $total_piutang_11_bulan + $total_piutang_12_bulan;
        $data['total_barang_1_tahun_keatas'] = $total_barang_1_tahun_keatas;
        $data['total_piutang_1_tahun_keatas'] = $total_piutang_1_tahun_keatas;
        $data['total_barang'] = $total_barang_1_bulan + $total_barang_2_bulan + $total_barang_3_bulan + $total_barang_4_bulan + $total_barang_5_bulan + $total_barang_6_bulan + $total_barang_7_bulan + $total_barang_8_bulan + $total_barang_9_bulan + $total_barang_10_bulan + $total_barang_11_bulan + $total_barang_12_bulan + $total_barang_1_tahun_keatas;
        $data['total_piutang'] = $total_piutang_1_bulan + $total_piutang_2_bulan + $total_piutang_3_bulan + $total_piutang_4_bulan + $total_piutang_5_bulan + $total_piutang_6_bulan + $total_piutang_7_bulan + $total_piutang_8_bulan + $total_piutang_9_bulan + $total_piutang_10_bulan + $total_piutang_11_bulan + $total_piutang_12_bulan + $total_piutang_1_tahun_keatas;

        $data['title'] = 'Laporan Umur Piutang AMDK';
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_laporan_piutang_umur', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_laporan_piutang_umur', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
    }

    public function exportpdf_umur()
    {
        $tanggal_sekarang = date('Y-m-d');
        $data['data_piutang'] = $this->Model_laporan->get_piutang_umur($tanggal_sekarang);

        $total_barang_1_bulan = 0;
        $total_piutang_1_bulan = 0;
        $total_barang_2_bulan = 0;
        $total_piutang_2_bulan = 0;
        $total_barang_3_bulan = 0;
        $total_piutang_3_bulan = 0;
        $total_barang_4_bulan = 0;
        $total_piutang_4_bulan = 0;
        $total_barang_5_bulan = 0;
        $total_piutang_5_bulan = 0;
        $total_barang_6_bulan = 0;
        $total_piutang_6_bulan = 0;
        $total_barang_7_bulan = 0;
        $total_piutang_7_bulan = 0;
        $total_barang_8_bulan = 0;
        $total_piutang_8_bulan = 0;
        $total_barang_9_bulan = 0;
        $total_piutang_9_bulan = 0;
        $total_barang_10_bulan = 0;
        $total_piutang_10_bulan = 0;
        $total_barang_11_bulan = 0;
        $total_piutang_11_bulan = 0;
        $total_barang_12_bulan = 0;
        $total_piutang_12_bulan = 0;
        $total_barang_1_tahun_keatas = 0;
        $total_piutang_1_tahun_keatas = 0;

        foreach ($data['data_piutang'] as $piutang) {
            $total_barang_1_bulan += $piutang->total_barang_1_bulan;
            $total_piutang_1_bulan += $piutang->total_piutang_1_bulan;
            $total_barang_2_bulan += $piutang->total_barang_2_bulan;
            $total_piutang_2_bulan += $piutang->total_piutang_2_bulan;
            $total_barang_3_bulan += $piutang->total_barang_3_bulan;
            $total_piutang_3_bulan += $piutang->total_piutang_3_bulan;
            $total_barang_4_bulan += $piutang->total_barang_4_bulan;
            $total_piutang_4_bulan += $piutang->total_piutang_4_bulan;
            $total_barang_5_bulan += $piutang->total_barang_5_bulan;
            $total_piutang_5_bulan += $piutang->total_piutang_5_bulan;
            $total_barang_6_bulan += $piutang->total_barang_6_bulan;
            $total_piutang_6_bulan += $piutang->total_piutang_6_bulan;
            $total_barang_7_bulan += $piutang->total_barang_7_bulan;
            $total_piutang_7_bulan += $piutang->total_piutang_7_bulan;
            $total_barang_8_bulan += $piutang->total_barang_8_bulan;
            $total_piutang_8_bulan += $piutang->total_piutang_8_bulan;
            $total_barang_9_bulan += $piutang->total_barang_9_bulan;
            $total_piutang_9_bulan += $piutang->total_piutang_9_bulan;
            $total_barang_10_bulan += $piutang->total_barang_10_bulan;
            $total_piutang_10_bulan += $piutang->total_piutang_10_bulan;
            $total_barang_11_bulan += $piutang->total_barang_11_bulan;
            $total_piutang_11_bulan += $piutang->total_piutang_11_bulan;
            $total_barang_12_bulan += $piutang->total_barang_12_bulan;
            $total_piutang_12_bulan += $piutang->total_piutang_12_bulan;
            $total_barang_1_tahun_keatas += $piutang->total_barang_1_tahun_keatas;
            $total_piutang_1_tahun_keatas += $piutang->total_piutang_1_tahun_keatas;
        }

        $data['total_barang_1_bulan'] = $total_barang_1_bulan;
        $data['total_piutang_1_bulan'] = $total_piutang_1_bulan;
        $data['total_barang_2_bulan'] = $total_barang_2_bulan;
        $data['total_piutang_2_bulan'] = $total_piutang_2_bulan;
        $data['total_barang_3_bulan'] = $total_barang_3_bulan;
        $data['total_piutang_3_bulan'] = $total_piutang_3_bulan;
        $data['total_barang_4_bulan'] = $total_barang_4_bulan;
        $data['total_piutang_4_bulan'] = $total_piutang_4_bulan;
        $data['total_barang_5_bulan'] = $total_barang_5_bulan;
        $data['total_piutang_5_bulan'] = $total_piutang_5_bulan;
        $data['total_barang_6_bulan'] = $total_barang_6_bulan;
        $data['total_piutang_6_bulan'] = $total_piutang_6_bulan;
        $data['total_barang_7_to_12_bulan'] = $total_barang_7_bulan + $total_barang_8_bulan + $total_barang_9_bulan + $total_barang_10_bulan + $total_barang_11_bulan + $total_barang_12_bulan;
        $data['total_piutang_7_to_12_bulan'] = $total_piutang_7_bulan + $total_piutang_8_bulan + $total_piutang_9_bulan + $total_piutang_10_bulan + $total_piutang_11_bulan + $total_piutang_12_bulan;
        $data['total_barang_1_tahun_keatas'] = $total_barang_1_tahun_keatas;
        $data['total_piutang_1_tahun_keatas'] = $total_piutang_1_tahun_keatas;
        $data['total_barang'] = $total_barang_1_bulan + $total_barang_2_bulan + $total_barang_3_bulan + $total_barang_4_bulan + $total_barang_5_bulan + $total_barang_6_bulan + $total_barang_7_bulan + $total_barang_8_bulan + $total_barang_9_bulan + $total_barang_10_bulan + $total_barang_11_bulan + $total_barang_12_bulan + $total_barang_1_tahun_keatas;
        $data['total_piutang'] = $total_piutang_1_bulan + $total_piutang_2_bulan + $total_piutang_3_bulan + $total_piutang_4_bulan + $total_piutang_5_bulan + $total_piutang_6_bulan + $total_piutang_7_bulan + $total_piutang_8_bulan + $total_piutang_9_bulan + $total_piutang_10_bulan + $total_piutang_11_bulan + $total_piutang_12_bulan + $total_piutang_1_tahun_keatas;
        $data['title'] = 'Laporan Umur Piutang AMDK';

        $data['manager'] = $this->Model_laporan->get_manager();
        $data['uang'] = $this->Model_laporan->get_uang();

        $this->pdf->setPaper('folio', 'landscape');
        $this->pdf->filename = "Lap_umur_piutang_per-{$tanggal_sekarang}.pdf";

        $this->pdf->generate('keuangan/laporan_umur_piutang_pdf', $data);
    }
}
