<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_keluar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_barang_produksi');
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
        if ($level_pengguna != 'Admin' && $upk_bagian != 'produksi') {
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
        $data['title'] = 'Transaksi Barang Baku Keluar';
        $data['barang_keluar'] = $this->Model_barang_produksi->getbarang_keluar($bulan, $tahun);
        if ($this->session->userdata('upk_bagian') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_produksi/view_barang_keluar', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_produksi');
            $this->load->view('templates/pengguna/sidebar_produksi');
            $this->load->view('barang_produksi/view_barang_keluar', $data);
            $this->load->view('templates/pengguna/footer_produksi');
        }
    }

    public function upload()
    {
        $this->form_validation->set_rules('id_barang_baku', 'Nama Barang Baku', 'required|trim');
        $this->form_validation->set_rules('id_jenis_barang', 'Jenis Barang', 'required|trim');
        $this->form_validation->set_rules('jumlah_keluar_baku', 'Jumlah barang', 'required|trim|numeric');
        $this->form_validation->set_rules('tanggal_keluar_baku', 'Tanggal', 'required|trim');
        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('numeric', '%s harus berupa angka');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Form Tambah Barang Baku lainnya';
            $data['nama_barang'] = $this->Model_barang_produksi->get_nama_barang();
            $data['jenis_barang'] = $this->Model_barang_produksi->get_jenis_barang();
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_produksi');
            $this->load->view('templates/pengguna/sidebar_produksi');
            $this->load->view('barang_produksi/view_tambah_transaksi_lain', $data);
            $this->load->view('templates/pengguna/footer_produksi');
        } else {
            $id_jenis_barang = $this->input->post('id_jenis_barang');
            $id_barang_baku = $this->input->post('id_barang_baku');
            $jumlah_keluar_baku = $this->input->post('jumlah_keluar_baku');
            $tanggal_keluar_baku = $this->input->post('tanggal_keluar_baku');

            $data = array(
                'id_jenis_barang' => $id_jenis_barang,
                'id_barang_baku' => $id_barang_baku,
                'jumlah_keluar_baku' => $jumlah_keluar_baku,
                'tanggal_keluar_baku' => $tanggal_keluar_baku,
                'input_keluar_baku' => $this->session->userdata('nama_lengkap')
            );
            $this->Model_barang_produksi->upload_barang_lainnya($data);

            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                                            <strong>Sukses,</strong> Transaksi Barang lainnya berhasil di simpan
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                            </button>
                                        </div>'
            );
            redirect('barang_produksi/barang_keluar');
        }
    }


    // public function upload2()
    // {
    //     $this->form_validation->set_rules('id_jenis_barang', 'Jenis Barang', 'required|trim');
    //     $this->form_validation->set_rules('id_barang_baku', 'Nama Barang Baku', 'required|trim');
    //     $this->form_validation->set_rules('jumlah_keluar_baku', 'Jumlah barang', 'required|trim|numeric');
    //     $this->form_validation->set_rules('tanggal_keluar_baku', 'Tanggal', 'required|trim');
    //     $this->form_validation->set_message('required', '%s masih kosong');
    //     $this->form_validation->set_message('numeric', '%s harus berupa angka');

    //     if ($this->form_validation->run() == false) {
    //         $data['title'] = 'Transaksi Barang Rusak';
    //         $data['nama_barang'] = $this->Model_barang_produksi->get_nama_barang();
    //         $this->load->view('templates/pengguna/header', $data);
    //         $this->load->view('templates/pengguna/navbar_produksi');
    //         $this->load->view('templates/pengguna/sidebar_produksi');
    //         $this->load->view('barang_produksi/view_tambah_transaksi_lain', $data);
    //         $this->load->view('templates/pengguna/footer_produksi');
    //     } else {
    //         // Cek apakah ada file yang diupload
    //         if (!empty($_FILES['bukti_rusak_produksi']['name'])) {
    //             // Mendapatkan tanggal dari input form
    //             $tanggal_rusak_produksi = $this->input->post('tanggal_rusak_produksi', true);

    //             // Membuat nama file sesuai dengan tanggal
    //             $file_name = date('Y-m-d', strtotime($tanggal_rusak_produksi)) . '.jpg';

    //             // Menyimpan file dengan nama yang sesuai
    //             $config['upload_path']   = './uploads/produksi/rusak/';
    //             $config['allowed_types'] = 'jpg|jpeg|png|pdf';
    //             $config['max_size']      = 1000;
    //             $config['file_name']     = $file_name;
    //             $config['overwrite']     = true; // Mengizinkan penggantian file yang ada dengan nama yang sama

    //             $this->load->library('upload', $config);
    //             if ($this->upload->do_upload('bukti_rusak_produksi')) {
    //                 // Isi data selain file yang diupload
    //                 $data['id_barang_baku'] = (int) $this->input->post('id_barang_baku', true);
    //                 $data['jumlah_rusak_produksi'] = $this->input->post('jumlah_rusak_produksi', true);
    //                 $data['tanggal_rusak_produksi'] = $tanggal_rusak_produksi;
    //                 $data['input_status_rusak_produksi'] = $this->session->userdata('nama_lengkap');
    //                 $data['bukti_rusak_produksi'] = $file_name; // Simpan nama file dalam database
    //                 $data['keterangan'] = $this->input->post('keterangan', true);


    //                 // Simpan data ke dalam database
    //                 $this->db->insert('rusak_produksi', $data);

    //                 $this->session->set_flashdata(
    //                     'info',
    //                     '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    //                             <strong>Sukses,</strong> Transaksi Barang Rusak berhasil di simpan
    //                             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                             </button>
    //                         </div>'
    //                 );
    //                 redirect('barang_produksi/barang_rusak');
    //             } else {
    //                 // Jika proses upload gagal
    //                 $error_msg = $this->upload->display_errors();
    //                 $this->session->set_flashdata('info', $error_msg);
    //                 redirect('barang_produksi/barang_rusak');
    //             }
    //         }
    //     }
    // }

    public function detail_keluar($id_jenis_barang, $tanggal)
    {
        $data['detail_barang_keluar'] = $this->Model_barang_produksi->get_detail_barang_keluar($id_jenis_barang, $tanggal);
        $data['title'] = 'Detail Barang Baku';
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar_produksi');
        $this->load->view('templates/pengguna/sidebar_produksi');
        $this->load->view('barang_produksi/view_detail_keluar_barang_produksi', $data);
        $this->load->view('templates/pengguna/footer_produksi');
    }
}