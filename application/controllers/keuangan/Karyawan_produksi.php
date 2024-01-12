<?php

use PhpParser\Node\Expr\Isset_;

defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan_produksi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_karyawan_produksi');
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
        $data['title'] = "Daftar Karyawan Produksi AMDK Ijen Water";
        $data['karyawan'] = $this->Model_karyawan_produksi->get_karyawan();

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/karyawan_produksi/view_karyawan_produksi', $data);
            $this->load->view('templates/pengguna/footer_produksi');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang', $data);
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/karyawan_produksi/view_karyawan_produksi', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
    }

    public function tambah()
    {
        $data['title'] = "Tambah Data Karyawan Produksi";

        $this->form_validation->set_rules('nama_karyawan_produksi', 'Nama Karyawan', 'required|trim|is_unique[karyawan_produksi.nama_karyawan_produksi]');
        $this->form_validation->set_rules('jenkel', 'Jenis Kelamin', 'required|trim');

        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('is_unique', '%s Sudah terdaftar, Ganti yang lain');


        if ($this->form_validation->run() == false) {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang', $data);
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/karyawan_produksi/view_tambah_karyawan_produksi', $data);
            $this->load->view('templates/pengguna/footer_uang');
        } else {
            $data['user'] = $this->Model_karyawan_produksi->tambahData();
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Karyawan Produksi baru berhasil di tambah
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('keuangan/karyawan_produksi');
        }
    }

    public function edit($id_karyawan_produksi)
    {
        $data['title'] = "Form Edit Karyawan Produksi";
        $data['edit_karyawan_produksi'] = $this->db->get_where('karyawan_produksi', ['id_karyawan_produksi' => $id_karyawan_produksi])->row();
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar_uang', $data);
        $this->load->view('templates/pengguna/sidebar_uang');
        $this->load->view('keuangan/karyawan_produksi/view_edit_karyawan_produksi', $data);
        $this->load->view('templates/pengguna/footer_uang');
    }

    public function update()
    {
        $this->Model_karyawan_produksi->updateData();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('keuangan/karyawan_produksi');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Karyawan Produksi berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('keuangan/karyawan_produksi');
        }
    }

    public function hapus($id_karyawan_produksi)
    {
        $this->Model_karyawan_produksi->hapusData($id_karyawan_produksi);
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Sukses,</strong> Data Karyawan Produksi berhasil di hapus
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                  </div>'
        );
        redirect('keuangan/karyawan_produksi');
    }

    public function absensi_karyawan()
    {
        $data['title'] = "Absensi Karyawan Produksi AMDK Ijen Water";
        $data['absen_karProd'] = $this->Model_karyawan_produksi->get_absen_karprod();
        $data['produksi_barang'] = $this->Model_karyawan_produksi->get_jenis_barang();


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
            $data_jenis_barang[$row->id_jenis_barang]['barang_jadi'][$tanggal] = $row->jumlah_barang_jadi;
        }

        $data['data_jenis_barang'] = $data_jenis_barang;
        $data['absensi_karyawan'] = $absensi_karyawan;

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/karyawan_produksi/view_absen_karprod', $data);
            $this->load->view('templates/pengguna/footer_produksi');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang', $data);
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/karyawan_produksi/view_absen_karprod', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
    }

    public function tambah_absen()
    {
        $data['title'] = "Input Absen Karyawan Produksi AMDK Ijen Water";

        $this->form_validation->set_rules('tanggal', 'tanggal', 'required|trim|is_unique[absen_karyawan_produksi.tanggal]');
        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('is_unique', '%s Sudah terdaftar, Ganti tanggal yang lain');

        if ($this->form_validation->run() == false) {
            $data['karyawan'] = $this->Model_karyawan_produksi->get_karyawan_produksi();
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang', $data);
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/karyawan_produksi/view_tambah_absen_karprod', $data);
            $this->load->view('templates/pengguna/footer_uang');
        } else {
            $tanggal = $this->input->post('tanggal');
            $karyawan = $this->input->post('karyawan');

            if (empty($karyawan)) {
                // Tidak ada karyawan yang dicentang, masukkan absensi dengan status 0 untuk semua karyawan
                $karyawan = $this->Model_karyawan_produksi->get_karyawan_produksi();
                foreach ($karyawan as $karyawan_produksi) {
                    $data = array(
                        'id_karyawan_produksi' => $karyawan_produksi['id_karyawan_produksi'],
                        'tanggal' => $tanggal,
                        'status_absen' => 0 // Kode status absen 0 untuk "tidak hadir"
                    );
                    $this->Model_karyawan_produksi->tambah_absen_karProd($data);
                }
            } else {
                // Ada karyawan yang dicentang, masukkan absensi dengan status 1
                foreach ($karyawan as $id_karyawan_produksi) {
                    $data = array(
                        'id_karyawan_produksi' => $id_karyawan_produksi,
                        'tanggal' => $tanggal,
                        'status_absen' => 1 // Kode status absen 1 untuk "hadir"
                    );
                    $this->Model_karyawan_produksi->tambah_absen_karProd($data);
                }
            }

            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Absensi Karyawan Produksi berhasil di tambah
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('keuangan/karyawan_produksi/absensi_karyawan');
        }
    }

    public function honor_karyawan()
    {
        $data['title'] = "Uraian Biaya Produksi AMDK Ijen Water";
        $data['absen_karProd'] = $this->Model_karyawan_produksi->get_absen_karprod();
        $data['produksi_barang'] = $this->Model_karyawan_produksi->get_jenis_barang();

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

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/karyawan_produksi/view_honor_karprod', $data);
            $this->load->view('templates/pengguna/footer_produksi');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang', $data);
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/karyawan_produksi/view_honor_karprod', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
    }
}
