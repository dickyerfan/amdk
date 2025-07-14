<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Piutang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_piutang');
        $this->load->model('Model_setting');
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
            $this->session->unset_userdata('tanggal');
            $data['pesan'] = $this->Model_piutang->get_all();
            $bulan_lap = '';
            $tahun_lap = '';
        } else {
            $bulan = substr($tanggal, 5, 2);
            $tahun = substr($tanggal, 0, 4);
            $data['pesan'] = $this->Model_piutang->get_bulan_tahun($bulan, $tahun);
            $bulan_lap = $bulan;
            $tahun_lap = $tahun;
            $this->session->set_userdata('tanggal', $tanggal);
        }

        $data['bulan_lap'] = $bulan_lap;
        $data['tahun_lap'] = $tahun_lap;

        // if (!empty($tanggal)) {
        //     $this->session->set_userdata('tanggal', $tanggal); // Simpan tanggal ke session jika diperlukan
        // }
        $data['title'] = 'Daftar Piutang AMDK';
        $data['produk'] = $this->Model_piutang->get_produk();
        $data['pelanggan'] = $this->Model_piutang->get_pelanggan();

        $deadline_time = $this->Model_setting->get_deadline_time();
        $deadline_timestamp = strtotime($deadline_time);
        $data['deadline_time'] = date('H:i', $deadline_timestamp);

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_piutang', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_piutang', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
    }

    // public function export_bulan_all()
    // {
    //     $tanggal = $this->session->userdata('tanggal');
    //     if (empty($tanggal)) {
    //         $data['pesan'] = $this->Model_piutang->get_all();
    //         $bulan_lap = '';
    //         $tahun_lap = '';
    //         $data['tanggal_hari_ini'] = 'Semua Data';
    //     } else {
    //         $bulan = substr($tanggal, 5, 2);
    //         $tahun = substr($tanggal, 0, 4);
    //         $data['pesan'] = $this->Model_piutang->get_bulan_tahun($bulan, $tahun);
    //         $bulan_lap = $bulan;
    //         $tahun_lap = $tahun;
    //         $data['tanggal_hari_ini'] = $tanggal;
    //     }

    //     $data['bulan_lap'] = $bulan_lap;
    //     $data['tahun_lap'] = $tahun_lap;

    //     $data['title'] = 'Daftar Piutang AMDK';
    //     $data['produk'] = $this->Model_piutang->get_produk();
    //     $data['pelanggan'] = $this->Model_piutang->get_pelanggan();
    //     $data['manager'] = $this->Model_laporan->get_manager();

    //     $this->pdf->setPaper('folio', 'portrait');

    //     $this->pdf->filename = "daftar_piutang_bulan_all.pdf";
    //     $this->pdf->generate('keuangan/daftar_piutang_bulan_all_pdf', $data);
    // }

    public function export_bulan_all()
    {
        $tanggal = $this->session->userdata('tanggal');
        if (empty($tanggal)) {
            $data['pesan'] = $this->Model_piutang->get_all();
            $bulan_lap = '';
            $tahun_lap = '';
            $data['tanggal_hari_ini'] = 'Semua Piutang';
        } else {
            $bulan = substr($tanggal, 5, 2);
            $tahun = substr($tanggal, 0, 4);
            $data['pesan'] = $this->Model_piutang->get_bulan_tahun($bulan, $tahun);
            $bulan_lap = $bulan;
            $tahun_lap = $tahun;
            $data['tanggal_hari_ini'] = $tanggal;
        }

        $data['bulan_lap'] = $bulan_lap;
        $data['tahun_lap'] = $tahun_lap;
        $data['title'] = 'Daftar Piutang AMDK';
        $data['produk'] = $this->Model_piutang->get_produk();
        $data['pelanggan'] = $this->Model_piutang->get_pelanggan();
        $data['manager'] = $this->Model_laporan->get_manager();
        $data['uang'] = $this->Model_laporan->get_uang();

        $this->pdf->setPaper('folio', 'portrait');
        $this->pdf->filename = "daftar_piutang_bulan_all.pdf";
        $this->pdf->generate('keuangan/daftar_piutang_bulan_all_pdf', $data);
    }

    public function rangking_piutang()
    {
        $data['title'] = 'Rangking Piutang Pelanggan';
        $data['rangking'] = $this->Model_piutang->get_rangking_piutang();
        $data['total_piutang'] = $this->Model_piutang->get_total_piutang();

        $data['detail_piutang'] = [];
        foreach ($data['rangking'] as $r) {
            $data['detail_piutang'][$r->id_pelanggan] = $this->Model_piutang->get_detail_piutang_by_pelanggan($r->id_pelanggan);
        }

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_rangking_piutang', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_rangking_piutang', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
    }

    public function export_rangking()
    {
        $data['title'] = 'Rangking Piutang Pelanggan';
        $data['rangking'] = $this->Model_piutang->get_rangking_piutang();
        $data['total_piutang'] = $this->Model_piutang->get_total_piutang();

        $data['detail_piutang'] = [];
        foreach ($data['rangking'] as $r) {
            $data['detail_piutang'][$r->id_pelanggan] = $this->Model_piutang->get_detail_piutang_by_pelanggan($r->id_pelanggan);
        }
        $data['manager'] = $this->Model_laporan->get_manager();
        $data['uang'] = $this->Model_laporan->get_uang();

        $this->pdf->setPaper('folio', 'portrait');
        $this->pdf->filename = "rangking_piutang.pdf";
        $this->pdf->generate('keuangan/rangking_piutang_pdf', $data);
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
        $data['title'] = 'Daftar Piutang Pertanggal AMDK';
        $data['pesan'] = $this->Model_piutang->get_by_date($tanggal);
        $data['produk'] = $this->Model_piutang->get_produk();
        $data['pelanggan'] = $this->Model_piutang->get_pelanggan();
        $data['tanggal_hari_ini'] = $this->input->get('tanggal');

        $deadline_time = $this->Model_setting->get_deadline_time();
        $deadline_timestamp = strtotime($deadline_time);
        $data['deadline_time'] = date('H:i', $deadline_timestamp);

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_piutang_pertanggal', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_piutang_pertanggal', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function export_tanggal()
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

        $data['title'] = 'Daftar Piutang Pertanggal AMDK';
        $data['pesan'] = $this->Model_piutang->get_by_date($tanggal);
        $data['produk'] = $this->Model_piutang->get_produk();
        $data['pelanggan'] = $this->Model_piutang->get_pelanggan();
        $data['tanggal_hari_ini'] = $tanggal;
        $data['manager'] = $this->Model_laporan->get_manager();
        $data['uang'] = $this->Model_laporan->get_uang();

        $this->pdf->setPaper('folio', 'portrait');

        $this->pdf->filename = "daftar_piutang_tanggal_per {$tanggal}.pdf";
        $this->pdf->generate('keuangan/daftar_piutang_pertanggal_pdf', $data);
    }

    public function nama_produk()
    {
        $id_produk = $this->input->post('id_produk');
        $data['title'] = 'Daftar Piutang AMDK Berdasarkan Produk';
        $data['nama_produk'] = $this->Model_piutang->get_by_produk($id_produk);
        $data['produk'] = $this->Model_piutang->get_produk();
        $data['pelanggan'] = $this->Model_piutang->get_pelanggan();

        $deadline_time = $this->Model_setting->get_deadline_time();
        $deadline_timestamp = strtotime($deadline_time);
        $data['deadline_time'] = date('H:i', $deadline_timestamp);

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_piutang_perproduk', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_piutang_perproduk', $data);
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

        $deadline_time = $this->Model_setting->get_deadline_time();
        $deadline_timestamp = strtotime($deadline_time);
        $data['deadline_time'] = date('H:i', $deadline_timestamp);

        if (!empty($id_pelanggan)) {
            $this->session->set_userdata('id_pelanggan', $id_pelanggan);
        }

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_piutang_perpelanggan', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_piutang_perpelanggan', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function export_pelanggan()
    {
        $tanggal = $this->session->userdata('tanggal');
        if (empty($tanggal)) {
            $bulan_lap = '';
            $tahun_lap = '';
        } else {
            $bulan = substr($tanggal, 5, 2);
            $tahun = substr($tanggal, 0, 4);
            $bulan_lap = $bulan;
            $tahun_lap = $tahun;
        }

        $data['tanggal_hari_ini'] = $tanggal;
        $id_pelanggan = $this->session->userdata('id_pelanggan');
        $data['title'] = 'Daftar Piutang AMDK Berdasarkan Nama Pelanggan';
        $data['nama_pelanggan'] = $this->Model_piutang->get_by_pelanggan($id_pelanggan);
        $data['produk'] = $this->Model_piutang->get_produk();
        // $data['pelanggan'] = $this->Model_piutang->get_pelanggan();
        $data['manager'] = $this->Model_laporan->get_manager();
        $data['uang'] = $this->Model_laporan->get_uang();

        $this->pdf->setPaper('folio', 'portrait');

        $this->pdf->filename = "daftar_piutang_pelanggan.pdf";
        $this->pdf->generate('keuangan/daftar_piutang_pelanggan_pdf', $data);
    }

    public function pilih_lunas($id_pemesanan)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = $this->session->userdata('tanggal');
        $this->form_validation->set_rules('status_bayar', 'Status bayar', 'required|trim');
        // $this->form_validation->set_rules('tanggal_bayar', 'Tanggal bayar', 'required|trim');
        $this->form_validation->set_message('required', '%s harus pilih');

        if ($this->form_validation->run() == false) {
            $data['lunas'] = $this->Model_piutang->get_lunas($id_pemesanan);
            $data['title'] = 'Form Pelunasan';
            if ($this->session->userdata('level') == 'Admin') {
                $this->load->view('templates/header', $data);
                $this->load->view('templates/navbar');
                $this->load->view('templates/sidebar');
                $this->load->view('keuangan/view_pilih_lunas_piutang', $data);
                $this->load->view('templates/footer');
            } else {
                $this->load->view('templates/pengguna/header', $data);
                $this->load->view('templates/pengguna/navbar_uang');
                $this->load->view('templates/pengguna/sidebar_uang');
                $this->load->view('keuangan/view_pilih_lunas_piutang', $data);
                $this->load->view('templates/pengguna/footer_uang');
            }
        } else {

            $data['status_bayar'] = $this->input->post('status_bayar');
            $data['status_pesan'] = 0;
            $data['input_bayar'] = $this->session->userdata('nama_lengkap');
            // ini untuk production
            $data['tanggal_bayar'] = date('Y-m-d H:i:s');
            // ini hanya untuk input data
            // $data['tanggal_bayar'] = $this->input->post('tanggal_bayar');

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

            $this->Model_piutang->update('pemesanan', $data, $id_pemesanan);
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
                // $alamat = 'keuangan/piutang?tanggal=' . $tanggal;
                // redirect($alamat);
                redirect('keuangan/piutang');
            } else {
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>Sukses,</strong> Barang lunas dibayar
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                          </div>'
                );
                // $alamat = 'keuangan/piutang?tanggal=' . $tanggal;
                // redirect($alamat);
                redirect('keuangan/piutang');
            }
        }
    }
}
