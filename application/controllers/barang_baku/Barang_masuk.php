<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_masuk extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_barang_baku');

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
        if ($level_pengguna != 'Admin' && $upk_bagian != 'baku') {
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

        $data['title'] = 'Transaksi Barang Masuk';
        $data['barang_masuk'] = $this->Model_barang_baku->getbarang_masuk($bulan, $tahun);
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_baku/view_barang_masuk', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_baku');
            $this->load->view('templates/pengguna/sidebar_baku');
            $this->load->view('barang_baku/view_barang_masuk', $data);
            $this->load->view('templates/pengguna/footer_baku');
        }
    }

    public function upload()
    {
        $this->form_validation->set_rules('id_barang_baku', 'Nama Barang Baku', 'required|trim');
        $this->form_validation->set_rules('jumlah_masuk', 'Jumlah Masuk', 'required|trim|numeric');
        $this->form_validation->set_rules('tanggal_masuk', 'Tanggal Masuk', 'required|trim');
        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('numeric', '%s harus berupa angka');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Transaksi Masuk Barang Baku';
            $data['nama_barang'] = $this->Model_barang_baku->get_nama_barang();
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_baku');
            $this->load->view('templates/pengguna/sidebar_baku');
            $this->load->view('barang_baku/view_masuk_barang_baku', $data);
            $this->load->view('templates/pengguna/footer_baku');
        } else {
            // Cek apakah ada file yang diupload
            if (!empty($_FILES['bukti_masuk_sj']['name'])) {
                // Mendapatkan tanggal dari input form
                $tanggal_masuk = $this->input->post('tanggal_masuk', true);

                // Membuat nama file sesuai dengan tanggal
                $file_name = date('Y-m-d', strtotime($tanggal_masuk)) . '.jpg';

                // Menyimpan file dengan nama yang sesuai
                $config['upload_path']   = './uploads/baku/masuk/';
                $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config['max_size']      = 1000;
                $config['file_name']     = $file_name;
                $config['overwrite']     = true; // Mengizinkan penggantian file yang ada dengan nama yang sama

                $this->load->library('upload', $config);
                if ($this->upload->do_upload('bukti_masuk_sj')) {
                    // Isi data selain file yang diupload
                    $data['id_barang_baku'] = (int) $this->input->post('id_barang_baku', true);
                    $data['jumlah_masuk'] = $this->input->post('jumlah_masuk', true);
                    $data['tanggal_masuk'] = $tanggal_masuk;
                    $data['input_status_masuk'] = $this->session->userdata('nama_lengkap');
                    $data['bukti_masuk_sj'] = $file_name; // Simpan nama file dalam database


                    // Simpan data ke dalam database
                    $this->db->insert('masuk_baku', $data);

                    $this->session->set_flashdata(
                        'info',
                        '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                                <strong>Sukses,</strong> Transaksi Barang Baku Masuk berhasil di simpan
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                </button>
                            </div>'
                    );
                    redirect('barang_baku/barang_masuk');
                } else {
                    // Jika proses upload gagal
                    $error_msg = $this->upload->display_errors();
                    $this->session->set_flashdata('info', $error_msg);
                    redirect('barang_baku/barang_masuk');
                }
            } else {
                // Tampilkan pesan kesalahan jika tidak ada file yang diunggah
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Gagal,</strong> Silakan masukkan bukti transaksi 
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>'
                );
                redirect('barang_baku/barang_masuk');
            }
        }
    }
    // public function upload()
    // {
    //     $this->form_validation->set_rules('id_barang_baku', 'Nama Barang Baku', 'required|trim');
    //     $this->form_validation->set_rules('jumlah_masuk', 'Jumlah Masuk', 'required|trim');
    //     $this->form_validation->set_rules('tanggal_masuk', 'Tanggal Masuk', 'required|trim');
    //     $this->form_validation->set_message('required', '%s masih kosong');
    //     $this->form_validation->set_message('numeric', '%s harus berupa angka');

    //     if ($this->form_validation->run() == false) {
    //         $data['title'] = 'Transaksi Masuk Barang Baku';
    //         $data['nama_barang'] = $this->Model_barang_baku->get_nama_barang();
    //         $this->load->view('templates/pengguna/header', $data);
    //         $this->load->view('templates/pengguna/navbar');
    //         $this->load->view('templates/pengguna/sidebar_baku');
    //         $this->load->view('barang_baku/masuk_barang_baku', $data);
    //         $this->load->view('templates/pengguna/footer');
    //     } else {
    //         // Cek apakah ada file yang diupload
    //         if (!empty($_FILES['bukti_masuk_sj']['name'])) {
    //             // Lakukan proses upload file
    //             $config['upload_path']   = './uploads/';
    //             $config['allowed_types'] = 'jpg|jpeg|png|pdf';
    //             $config['max_size']      = 1000;
    //             $this->load->library('upload', $config);
    //             if ($this->upload->do_upload('bukti_masuk_sj')) {
    //                 $data_upload = $this->upload->data();
    //                 $data['bukti_masuk_sj'] = $data_upload['file_name'];
    //             } else {
    //                 // Jika proses upload gagal
    //                 $error_msg = $this->upload->display_errors();
    //                 $this->session->set_flashdata('info', $error_msg);
    //                 redirect('barang_baku/barang_masuk');
    //             }
    //         }
    //         // Isi data selain file yang diupload
    //         $data['id_barang_baku'] = (int) $this->input->post('id_barang_baku', true);
    //         $data['jumlah_masuk'] = $this->input->post('jumlah_masuk', true);
    //         $data['tanggal_masuk'] = $this->input->post('tanggal_masuk', true);
    //         $data['input_status_masuk'] = $this->session->userdata('nama_lengkap');

    //         // Simpan data ke dalam database
    //         $this->db->insert('masuk_baku', $data);
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    //                     <strong>Sukses,</strong> Transaksi Barang Baku Masuk berhasil di simpan
    //                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                     </button>
    //                 </div>'
    //         );
    //         redirect('barang_baku/barang_masuk');
    //     }
    // }

    public function edit_masuk($id_masuk_baku)
    {
        $data['masuk_baku'] = $this->Model_barang_baku->get_id_masuk_baku($id_masuk_baku);
        $data['title'] = 'Edit Masuk Barang Baku';
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar');
        $this->load->view('templates/pengguna/sidebar_baku');
        $this->load->view('barang_baku/view_edit_masuk_barang_baku', $data);
        $this->load->view('templates/pengguna/footer');
    }

    public function update_masuk()
    {
        date_default_timezone_set('Asia/Jakarta');
        if (!empty($_FILES['bukti_masuk_gd']['name'])) {

            // Lakukan proses upload file
            $config['upload_path']   = './uploads/baku/masuk/';
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['max_size']      = 1000;
            $config['overwrite']     = true; // Mengizinkan penggantian file yang ada dengan nama yang sama

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('bukti_masuk_gd')) {
                $data_upload = $this->upload->data();
                $data['bukti_masuk_gd'] = $data_upload['file_name'];
                $data['id_masuk_baku'] = $this->input->post('id_masuk_baku');
            } else {
                // Jika proses upload gagal
                $error_msg = $this->upload->display_errors();
                $this->session->set_flashdata('info', $error_msg);
                redirect('barang_baku/barang_masuk');
            }

            // Isi data selain file yang diupload
            $data['input_status_masuk'] = $this->session->userdata('nama_lengkap');
            $data['tgl_update_masuk'] = date('Y-m-d H:i:s');
            $data['status_masuk'] = 1;

            // Simpan data ke dalam database
            $this->Model_barang_baku->update_masuk($data);
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>Sukses,</strong> Transaksi Barang Baku Masuk berhasil di update
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('barang_baku/barang_masuk');
        } else {
            // Tampilkan pesan kesalahan jika tidak ada file yang diunggah
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal,</strong> Silakan masukkan bukti transaksi gudang
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('barang_baku/barang_masuk');
        }
    }

    public function detail_masuk($id_masuk_baku)
    {
        $data['detail_barang_masuk'] = $this->Model_barang_baku->get_detail_barang_masuk($id_masuk_baku);
        $data['title'] = 'Detail Barang Baku';
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar');
        $this->load->view('templates/pengguna/sidebar_baku');
        $this->load->view('barang_baku/view_detail_masuk_barang_baku', $data);
        $this->load->view('templates/pengguna/footer');
    }
}
