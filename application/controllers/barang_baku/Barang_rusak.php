<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_rusak extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_barang_baku');
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
        $data['bulan_lap'] = $bulan;
        $data['tahun_lap'] = $tahun;
        $data['title'] = 'Berita Acara Barang Rusak';
        $data['barang_rusak'] = $this->Model_barang_baku->getbarang_rusak($bulan, $tahun);
        if ($this->session->userdata('upk_bagian') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_baku/view_barang_rusak', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_baku');
            $this->load->view('templates/pengguna/sidebar_baku');
            $this->load->view('barang_baku/view_barang_rusak', $data);
            $this->load->view('templates/pengguna/footer_baku');
        }
    }

    public function upload()
    {
        $this->form_validation->set_rules('id_barang_baku', 'Nama Barang Baku', 'required|trim');
        $this->form_validation->set_rules('jumlah_rusak_baku', 'Jumlah Rusak', 'required|trim|numeric');
        $this->form_validation->set_rules('tanggal_rusak_baku', 'Tanggal Rusak', 'required|trim');
        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('numeric', '%s harus berupa angka');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Transaksi Rusak Barang Baku';
            $data['nama_barang'] = $this->Model_barang_baku->get_nama_barang();
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_baku');
            $this->load->view('templates/pengguna/sidebar_baku');
            $this->load->view('barang_baku/view_rusak_barang_baku', $data);
            $this->load->view('templates/pengguna/footer_baku');
        } else {
            // Cek apakah ada file yang diupload
            if (!empty($_FILES['bukti_rusak_baku']['name'])) {
                // Mendapatkan tanggal dari input form
                $tanggal_rusak_baku = $this->input->post('tanggal_rusak_baku', true);

                // Membuat nama file sesuai dengan tanggal
                $file_name = date('Y-m-d', strtotime($tanggal_rusak_baku)) . '.jpg';

                // Menyimpan file dengan nama yang sesuai
                $config['upload_path']   = './uploads/baku/rusak/';
                $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config['max_size']      = 1000;
                $config['file_name']     = $file_name;
                $config['overwrite']     = true; // Mengizinkan penggantian file yang ada dengan nama yang sama

                $this->load->library('upload', $config);
                if ($this->upload->do_upload('bukti_rusak_baku')) {
                    // Isi data selain file yang diupload
                    $data['id_barang_baku'] = (int) $this->input->post('id_barang_baku', true);
                    $data['jumlah_rusak_baku'] = $this->input->post('jumlah_rusak_baku', true);
                    $data['tanggal_rusak_baku'] = $tanggal_rusak_baku;
                    $data['input_status_rusak_baku'] = $this->session->userdata('nama_lengkap');
                    $data['bukti_rusak_baku'] = $file_name; // Simpan nama file dalam database
                    $data['keterangan'] = $this->input->post('keterangan', true);


                    // Simpan data ke dalam database
                    $this->db->insert('rusak_baku', $data);

                    $this->session->set_flashdata(
                        'info',
                        '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                                <strong>Sukses,</strong> Transaksi Barang Baku Rusak berhasil di simpan
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                </button>
                            </div>'
                    );
                    redirect('barang_baku/barang_rusak');
                } else {
                    // Jika proses upload gagal
                    $error_msg = $this->upload->display_errors();
                    $this->session->set_flashdata('info', $error_msg);
                    redirect('barang_baku/barang_rusak');
                }
            } else {
                // Tampilkan pesan kesalahan jika tidak ada file yang diunggah
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Gagal,</strong> Silakan masukkan file foto barang rusak
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>'
                );
                redirect('barang_bakyu/barang_rusak');
            }
        }
    }

    public function detail_rusak($id_rusak_baku)
    {
        $data['detail_barang_rusak'] = $this->Model_barang_baku->get_detail_barang_rusak($id_rusak_baku);
        $data['title'] = 'Detail Barang Rusak';
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar');
        $this->load->view('templates/pengguna/sidebar_baku');
        $this->load->view('barang_baku/view_detail_rusak_barang_baku', $data);
        $this->load->view('templates/pengguna/footer');
    }
}
