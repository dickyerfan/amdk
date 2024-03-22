<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penerimaan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_penerimaan');
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
        $data['title'] = 'Daftar Penerimaan Kas AMDK';
        $data['pesan'] = $this->Model_penerimaan->get_all($tanggal);
        // $data['pesan'] = $this->Model_penerimaan->get_all($bulan, $tahun);
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_penerimaan', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_penerimaan', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
    }

    public function setor_bank()
    {
        $tanggal_setor = $this->session->userdata('tanggal');
        $data['title'] = 'Form upload bukti setor bank';
        $data['pesan'] = $this->Model_penerimaan->get_all($tanggal_setor);
        $data['tanggal_setor'] = $tanggal_setor;

        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar_uang');
        $this->load->view('templates/pengguna/sidebar_uang');
        $this->load->view('keuangan/view_setor_bank', $data);
        $this->load->view('templates/pengguna/footer_uang');
    }

    public function update_nota_setor()
    {
        date_default_timezone_set('Asia/Jakarta');
        if (!empty($_FILES['nota_setor']['name'])) {

            // Lakukan proses upload file
            $config['upload_path']   = './uploads/uang/nota/';
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['max_size']      = 1000;
            $config['overwrite']     = true; // Mengizinkan penggantian file yang ada dengan nama yang sama

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('nota_setor')) {
                $data_upload = $this->upload->data();
                $data['nota_setor'] = $data_upload['file_name'];
                $data['tanggal_bayar'] = $this->input->post('tanggal_bayar');

                // Isi data selain file yang diupload
                $data['input_setor'] = $this->session->userdata('nama_lengkap');
                $data['tanggal_setor'] = $this->input->post('tanggal_setor'); // ini untuk entri data saja
                // $data['tanggal_setor'] = date('Y-m-d H:i:s'); // ini yang akan di gunakan aplikasi real
                $data['status_setor'] = 1;
                // Simpan data ke dalam database
                $this->Model_penerimaan->update_nota($data);
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>Sukses,</strong> Nota Setor Bank berhasil di upload
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
                );
                redirect('keuangan/penerimaan');
            } else {
                // Jika proses upload gagal
                $error_msg = $this->upload->display_errors();
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal,</strong> Upload Nota setor Bank
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
                </div>'
                );
                redirect('keuangan/penerimaan');
            }
        } else {
            // Tampilkan pesan kesalahan jika tidak ada file yang diunggah
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal,</strong> Silakan masukkan bukti nota Setor Bank
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('keuangan/penerimaan');
        }
    }
}
