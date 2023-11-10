<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengambilan_air extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_ambil_air');
        $this->load->model('Model_laporan');
        if (!$this->session->userdata('nama_pengguna')) {
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
        $this->session->set_userdata('$tanggal_lap', $tanggal);

        $data['title'] = 'Daftar Pengambilan Air Baku';
        $data['ambil_air'] = $this->Model_ambil_air->get_ambil_air($bulan, $tahun);
        if ($this->session->userdata('upk_bagian') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_ambil_air', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_ambil_air', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function tambah()
    {
        $data['title'] = "Form Pengambilan Air Baku AMDK";
        $data['karyawan'] = $this->Model_ambil_air->get_karyawan();
        $this->form_validation->set_rules('tanggal_ambil_air', 'Tanggal', 'required|trim');
        $this->form_validation->set_rules('id_karyawan', 'Nama Karyawan', 'required|trim');
        $this->form_validation->set_rules('stand_meter', 'Stand Meter', 'required|trim|numeric');
        $this->form_validation->set_rules('bbm', 'BBM', 'trim|numeric');

        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('numeric', '%s harus di tulis angka');

        $waktu = $this->input->post('waktu', true);

        if (preg_match('/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/', $waktu)) {
            // Format waktu benar, lanjutkan penyimpanan
            $data['waktu'] = $waktu;
        } else {
            // Format waktu tidak valid
            $this->form_validation->set_message('valid_time_format', 'Format waktu tidak valid (HH:MM:SS).');
            $this->form_validation->set_rules('waktu', 'Waktu', 'callback_valid_time_format');
        }

        $harga_solar = 6500;
        $ket = 0;
        $bbm = intval($this->input->post('bbm', true));
        if (!empty($bbm)) {
            $ket = $bbm / $harga_solar;
            $data['ket'] = round($ket, 0);
        }

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_tambah_ambil_air', $data);
            $this->load->view('templates/pengguna/footer');
        } else {
            $data = [
                'tanggal_ambil_air' => $this->input->post('tanggal_ambil_air', true),
                'id_karyawan' => $this->input->post('id_karyawan', true),
                'waktu' => $data['waktu'],
                'stand_meter' => $this->input->post('stand_meter', true),
                'bbm' => $this->input->post('bbm', true),
                'ket' => $data['ket'],
                'input_truk_tangki' =>  $this->session->userdata('nama_lengkap')
            ];
            $data['user'] = $this->Model_ambil_air->tambahData($data);
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data pengambilan air baru berhasil di tambah
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('keuangan/pengambilan_air');
        }
    }

    public function edit($id_pelanggan)
    {
        $data['title'] = "Form Edit Pelanggan";
        $data['edit_pelanggan'] = $this->db->get_where('pelanggan', ['id_pelanggan' => $id_pelanggan])->row();
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar_uang');
        $this->load->view('templates/pengguna/sidebar_uang');
        $this->load->view('keuangan/view_edit_pelanggan', $data);
        $this->load->view('templates/pengguna/footer');
    }

    public function update()
    {
        $this->Model_ambil_air->updateData();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('keuangan/pengambilan_air');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Pelanggan berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('keuangan/pengambilan_air');
        }
    }

    public function hapus($id_pelanggan)
    {
        $this->Model_ambil_air->hapusData($id_pelanggan);
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Sukses,</strong> Data Pelanggan berhasil di hapus
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                  </div>'
        );
        redirect('keuangan/pengambilan_air');
    }
    public function exportpdf()
    {
        $tanggal = $this->session->userdata('$tanggal_lap');
        $bulan = substr($tanggal, 5, 2);
        $tahun = substr($tanggal, 0, 4);

        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
            $bulan = date('m');
            $tahun = date('Y');
        }
        $data['title'] = 'Laporan Pengambilan Air Baku AMDK';
        $data['ambil_air'] = $this->Model_ambil_air->get_ambil_air($bulan, $tahun);

        $data['bulan_lap'] = $bulan;
        $data['tahun_lap'] = $tahun;
        $data['manager'] = $this->Model_laporan->get_manager();
        $data['uang'] = $this->Model_laporan->get_uang();

        // Set paper size and orientation
        $this->pdf->setPaper('folio', 'portrait');

        // $this->pdf->filename = "Potensi Sr.pdf";
        $this->pdf->filename = "Lap_ambil_air-{$bulan}-{$tahun}.pdf";
        $this->pdf->generate('keuangan/laporan_pengambilan_air_pdf', $data);
    }
}
