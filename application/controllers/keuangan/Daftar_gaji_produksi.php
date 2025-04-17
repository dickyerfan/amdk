<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Daftar_gaji_produksi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_karyawan_produksi');
        $this->load->model('Model_laporan');
        $this->load->library('form_validation');
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
        $tanggal_mulai = $this->input->get('tanggal_mulai');
        $tanggal_selesai = $this->input->get('tanggal_selesai');
    
        if (!$tanggal_mulai || !$tanggal_selesai) {
            // Beri nilai default sebelum mengambil data
            $tanggal_mulai = date('Y-m-01'); // tanggal 1 di bulan ini
            $tanggal_selesai = date('Y-m-t'); // tanggal terakhir di bulan ini
        }
    
        if (!empty($tanggal_mulai) || !empty($tanggal_selesai)) {
            $this->session->set_userdata('tanggal_mulai', $tanggal_mulai);
            $this->session->set_userdata('tanggal_selesai', $tanggal_selesai);
        }
    
        // Menghitung tanggal mulai dan selesai
        $start_date = new DateTime($tanggal_mulai);
        $end_date = new DateTime($tanggal_selesai);
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
    
        // Menghitung jumlah hari
        $jumlah_hari = $end_date->diff($start_date)->days + 1; // +1 untuk menghitung hari terakhir
    
        $data['title'] = "Daftar Gaji Karyawan Produksi AMDK Ijen Water";
        $data['absen_karProd'] = $this->Model_karyawan_produksi->get_gaji_produksi($tanggal_mulai, $tanggal_selesai);
        $data['produksi_barang'] = $this->Model_karyawan_produksi->get_jenis_barang_gaji($tanggal_mulai, $tanggal_selesai);
    
        $absensi_karyawan = array();
        foreach ($data['absen_karProd'] as $row) {
            if (!isset($absensi_karyawan[$row->id_karyawan_produksi])) {
                $absensi_karyawan[$row->id_karyawan_produksi]['nama_karyawan_produksi'] = $row->nama_karyawan_produksi;
            }
            $tanggal = $row->tanggal;
            $absensi_karyawan[$row->id_karyawan_produksi]['absen_karyawan_produksi'][$tanggal] = $row->status_absen;
        }
    
        // Data produksi barang per tanggal
        $data_jenis_barang = array();
        foreach ($data['produksi_barang'] as $row) {
            if (!isset($data_jenis_barang[$row->id_jenis_barang])) {
                $data_jenis_barang[$row->id_jenis_barang]['nama_barang_jadi'] = $row->nama_barang_jadi;
            }
            $tanggal = $row->tanggal_barang_jadi;
            $ongkos = $row->ongkos_per_unit;
            $data_jenis_barang[$row->id_jenis_barang]['barang_jadi'][$tanggal] = $row->jumlah_barang_jadi * $ongkos;
        }
    
        $data['data_jenis_barang'] = $data_jenis_barang;
        $data['absensi_karyawan'] = $absensi_karyawan;
    
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_gaji_produksi', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang', $data);
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_gaji_produksi', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
    }
    
    public function daftar_hadir()
    {
        $tanggal_mulai = $this->input->get('tanggal_mulai');
        $tanggal_selesai = $this->input->get('tanggal_selesai');
    
        if (!$tanggal_mulai || !$tanggal_selesai) {
            // Beri nilai default sebelum mengambil data
            $tanggal_mulai = date('Y-m-01'); // tanggal 1 di bulan ini
            $tanggal_selesai = date('Y-m-t'); // tanggal terakhir di bulan ini
        }
    
        if (!empty($tanggal_mulai) || !empty($tanggal_selesai)) {
            $this->session->set_userdata('tanggal_mulai', $tanggal_mulai);
            $this->session->set_userdata('tanggal_selesai', $tanggal_selesai);
        }
    
        // Menghitung tanggal mulai dan selesai
        $start_date = new DateTime($tanggal_mulai);
        $end_date = new DateTime($tanggal_selesai);
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
    
        // Menghitung jumlah hari
        $data['jumlah_hari'] = $end_date->diff($start_date)->days + 1; // +1 untuk menghitung hari terakhir
    
        $data['title'] = "Daftar Hadir Karyawan Produksi AMDK Ijen Water";
        $data['absen_karProd'] = $this->Model_karyawan_produksi->get_daftar_hadir($tanggal_mulai, $tanggal_selesai);
        $data['produksi_barang'] = $this->Model_karyawan_produksi->get_jenis_barang_gaji($tanggal_mulai, $tanggal_selesai);
    
        $absensi_karyawan = array();
        foreach ($data['absen_karProd'] as $row) {
            if (!isset($absensi_karyawan[$row->id_karyawan_produksi])) {
                $absensi_karyawan[$row->id_karyawan_produksi]['nama_karyawan_produksi'] = $row->nama_karyawan_produksi;
            }
            $tanggal = $row->tanggal;
            $absensi_karyawan[$row->id_karyawan_produksi]['absen_karyawan_produksi'][$tanggal] = $row->status_absen;
        }
    
        // Data produksi barang per tanggal
        $data_jenis_barang = array();
        foreach ($data['produksi_barang'] as $row) {
            if (!isset($data_jenis_barang[$row->id_jenis_barang])) {
                $data_jenis_barang[$row->id_jenis_barang]['nama_barang_jadi'] = $row->nama_barang_jadi;
            }
            $tanggal = $row->tanggal_barang_jadi;
            $data_jenis_barang[$row->id_jenis_barang]['barang_jadi'][$tanggal] = $row->jumlah_barang_jadi;
        }
    
        $data['data_jenis_barang'] = $data_jenis_barang;
        $data['absensi_karyawan'] = $absensi_karyawan;
    
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_daftar_hadir', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang', $data);
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_daftar_hadir', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
    }

    public function ekspor_daftar_hadir()
    {
        $tanggal_mulai = $this->session->userdata('tanggal_mulai');
        $tanggal_selesai = $this->session->userdata('tanggal_selesai');

        if (!$tanggal_mulai || !$tanggal_selesai) {
            // Beri nilai default sebelum mengambil data
            $tanggal_mulai = date('Y-m-01'); // tanggal 1 di bulan ini
            $tanggal_selesai = date('Y-m-t'); // tanggal terakhir di bulan ini
        }
        // Menghitung tanggal mulai dan selesai
        $start_date = new DateTime($tanggal_mulai);
        $end_date = new DateTime($tanggal_selesai);
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
    
        // Menghitung jumlah hari
        $data['jumlah_hari'] = $end_date->diff($start_date)->days + 1; // +1 untuk menghitung hari terakhir
    
        $data['title'] = "Daftar Hadir Karyawan Produksi AMDK Ijen Water";
        $data['absen_karProd'] = $this->Model_karyawan_produksi->get_daftar_hadir($tanggal_mulai, $tanggal_selesai);
        $data['produksi_barang'] = $this->Model_karyawan_produksi->get_jenis_barang_gaji($tanggal_mulai, $tanggal_selesai);
    
        $absensi_karyawan = array();
        foreach ($data['absen_karProd'] as $row) {
            if (!isset($absensi_karyawan[$row->id_karyawan_produksi])) {
                $absensi_karyawan[$row->id_karyawan_produksi]['nama_karyawan_produksi'] = $row->nama_karyawan_produksi;
            }
            $tanggal = $row->tanggal;
            $absensi_karyawan[$row->id_karyawan_produksi]['absen_karyawan_produksi'][$tanggal] = $row->status_absen;
        }
    
        // Data produksi barang per tanggal
        $data_jenis_barang = array();
        foreach ($data['produksi_barang'] as $row) {
            if (!isset($data_jenis_barang[$row->id_jenis_barang])) {
                $data_jenis_barang[$row->id_jenis_barang]['nama_barang_jadi'] = $row->nama_barang_jadi;
            }
            $tanggal = $row->tanggal_barang_jadi;
            $data_jenis_barang[$row->id_jenis_barang]['barang_jadi'][$tanggal] = $row->jumlah_barang_jadi;
        }
    
        $data['data_jenis_barang'] = $data_jenis_barang;
        $data['absensi_karyawan'] = $absensi_karyawan;
        $data['manager'] = $this->Model_laporan->get_manager();
        $data['uang'] = $this->Model_laporan->get_uang();

        // Set paper size and orientation
        $this->pdf->setPaper('folio', 'landscape');

        $this->pdf->filename = "LapAbsenKywProd-{$tanggal_mulai}-{$tanggal_selesai}.pdf";
        $this->pdf->generate('keuangan/laporan_daftar_hadir_pdf', $data);
    }


    public function ekspor_gaji_karyawan_produksi()
    {
        $tanggal_mulai = $this->session->userdata('tanggal_mulai');
        $tanggal_selesai = $this->session->userdata('tanggal_selesai');

        if (!$tanggal_mulai || !$tanggal_selesai) {
            // Beri nilai default sebelum mengambil data
            $tanggal_mulai = date('Y-m-01'); // tanggal 1 di bulan ini
            $tanggal_selesai = date('Y-m-t'); // tanggal terakhir di bulan ini
        }


        // Menghitung tanggal mulai dan selesai
        $start_date = new DateTime($tanggal_mulai);
        $end_date = new DateTime($tanggal_selesai);
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        // Menghitung jumlah hari
        $jumlah_hari = $end_date->diff($start_date)->days + 1; // +1 untuk menghitung hari terakhir

        $data['title'] = "Daftar Gaji Karyawan Produksi AMDK Ijen Water";
        $data['absen_karProd'] = $this->Model_karyawan_produksi->get_gaji_produksi($tanggal_mulai, $tanggal_selesai);
        $data['produksi_barang'] = $this->Model_karyawan_produksi->get_jenis_barang_gaji($tanggal_mulai, $tanggal_selesai);

        $absensi_karyawan = array();
        foreach ($data['absen_karProd'] as $row) {
            if (!isset($absensi_karyawan[$row->id_karyawan_produksi])) {
                $absensi_karyawan[$row->id_karyawan_produksi]['nama_karyawan_produksi'] = $row->nama_karyawan_produksi;
            }
            $tanggal = $row->tanggal;
            $absensi_karyawan[$row->id_karyawan_produksi]['absen_karyawan_produksi'][$tanggal] = $row->status_absen;
        }

        $data_jenis_barang = array();
        foreach ($data['produksi_barang'] as $row) {
            if (!isset($data_jenis_barang[$row->id_jenis_barang])) {
                $data_jenis_barang[$row->id_jenis_barang]['nama_barang_jadi'] = $row->nama_barang_jadi;
            }
            $tanggal = $row->tanggal_barang_jadi;
            $ongkos = $row->ongkos_per_unit;
            $data_jenis_barang[$row->id_jenis_barang]['barang_jadi'][$tanggal] = $row->jumlah_barang_jadi * $ongkos;
        }

        $data['data_jenis_barang'] = $data_jenis_barang;
        $data['absensi_karyawan'] = $absensi_karyawan;
        $data['manager'] = $this->Model_laporan->get_manager();
        $data['uang'] = $this->Model_laporan->get_uang();

        // Set paper size and orientation
        $this->pdf->setPaper('folio', 'landscape');

        $this->pdf->filename = "LapGajiKywProd-{$tanggal_mulai}-{$tanggal_selesai}.pdf";
        $this->pdf->generate('keuangan/laporan_gaji_produksi_pdf', $data);
    }

    public function ekspor_tanda_terima_gaji()
    {
        $tanggal_mulai = $this->session->userdata('tanggal_mulai');
        $tanggal_selesai = $this->session->userdata('tanggal_selesai');

        if (!$tanggal_mulai || !$tanggal_selesai) {
            // Beri nilai default sebelum mengambil data
            $tanggal_mulai = date('Y-m-01'); // tanggal 1 di bulan ini
            $tanggal_selesai = date('Y-m-t'); // tanggal terakhir di bulan ini
        }

        // Menghitung tanggal mulai dan selesai
        $start_date = new DateTime($tanggal_mulai);
        $end_date = new DateTime($tanggal_selesai);
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        // Menghitung jumlah hari
        $jumlah_hari = $end_date->diff($start_date)->days + 1; // +1 untuk menghitung hari terakhir

        $data['title'] = "Tanda Terima Ongkos Produksi";
        $data['absen_karProd'] = $this->Model_karyawan_produksi->get_gaji_produksi($tanggal_mulai, $tanggal_selesai);
        $data['produksi_barang'] = $this->Model_karyawan_produksi->get_jenis_barang_gaji($tanggal_mulai, $tanggal_selesai);

        $absensi_karyawan = array();
        foreach ($data['absen_karProd'] as $row) {
            if (!isset($absensi_karyawan[$row->id_karyawan_produksi])) {
                $absensi_karyawan[$row->id_karyawan_produksi]['nama_karyawan_produksi'] = $row->nama_karyawan_produksi;
            }
            $tanggal = $row->tanggal;
            $absensi_karyawan[$row->id_karyawan_produksi]['absen_karyawan_produksi'][$tanggal] = $row->status_absen;
        }

        $data_jenis_barang = array();
        foreach ($data['produksi_barang'] as $row) {
            if (!isset($data_jenis_barang[$row->id_jenis_barang])) {
                $data_jenis_barang[$row->id_jenis_barang]['nama_barang_jadi'] = $row->nama_barang_jadi;
            }
            $tanggal = $row->tanggal_barang_jadi;
            $ongkos = $row->ongkos_per_unit;
            $data_jenis_barang[$row->id_jenis_barang]['barang_jadi'][$tanggal] = $row->jumlah_barang_jadi * $ongkos;
        }

        $data['data_jenis_barang'] = $data_jenis_barang;
        $data['absensi_karyawan'] = $absensi_karyawan;
        $data['manager'] = $this->Model_laporan->get_manager();
        $data['uang'] = $this->Model_laporan->get_uang();
        $data['direktur'] = $this->Model_laporan->get_direktur();
        $data['kabag'] = $this->Model_laporan->get_kabag();

        // Set paper size and orientation
        $this->pdf->setPaper('folio', 'portrait');

        $this->pdf->filename = "TTGajiKywProd-{$tanggal_mulai}-{$tanggal_selesai}.pdf";
        $this->pdf->generate('keuangan/tanda_terima_gaji_produksi_pdf', $data);
    }
}
