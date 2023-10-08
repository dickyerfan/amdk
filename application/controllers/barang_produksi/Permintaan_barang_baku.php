<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permintaan_barang_baku extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_barang_produksi');
        if (!$this->session->userdata('nama_pengguna')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = 'Permintaan Barang Baku';
        $id_keluar_baku = $this->input->post('id_keluar_baku');
        $data['nama_barang'] = $this->Model_barang_produksi->get_nama_barang();
        $data['id_barang'] = $this->Model_barang_produksi->get_Id_Barang_edit($id_keluar_baku);
        if ($this->session->userdata('upk_bagian') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_produksi/view_permintaan_baku', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_produksi');
            $this->load->view('templates/pengguna/sidebar_produksi');
            $this->load->view('barang_produksi/view_permintaan_baku', $data);
            $this->load->view('templates/pengguna/footer_produksi');
        }
    }

    function getDataBarang()
    {
        $data = $this->Model_barang_produksi->getbarang_keluar();
        echo json_encode($data);
    }

    // public function upload()
    // {
    //     $id_barang_baku = $this->input->post('id_barang_baku', true);
    //     $jumlah_keluar = $this->input->post('jumlah_keluar', true);
    //     $tanggal_keluar = $this->input->post('tanggal_keluar', true);
    //     $bukti_keluar_gd = $this->input->post('bukti_keluar_gd', true);
    //     $input_status_keluar = $this->session->userdata('nama_lengkap');

    //     if ($id_barang_baku == '') {
    //         $result['pesan'] = "Nama Barang harus di pilih";
    //     } elseif ($jumlah_keluar == '') {
    //         $result['pesan'] = "Jumlah Barang harus  ";
    //     } elseif ($tanggal_keluar == '') {
    //         $result['pesan'] = "tanggal harus di isi";
    //     } elseif ($bukti_keluar_gd == '') {
    //         $result['pesan'] = "foto harus di isi";
    //     } else {
    //         $result['pesan'] = "";

    //         if (!empty($_FILES['bukti_keluar_gd']['name'])) {
    //             // Lakukan proses upload file
    //             $config['upload_path']   = './uploads/keluar/';
    //             $config['allowed_types'] = 'jpg|jpeg|png|pdf';
    //             $config['max_size']      = 1000;
    //             $this->load->library('upload', $config);
    //             if ($this->upload->do_upload('bukti_keluar_gd')) {
    //                 $data_upload = $this->upload->data();
    //                 $data['bukti_keluar_gd'] = $data_upload['file_name'];
    //             } else {
    //                 // Jika proses upload gagal
    //                 $error_msg = $this->upload->display_errors();
    //                 $this->session->set_flashdata('info', $error_msg);
    //                 redirect('barang_baku/barang_masuk');
    //             }
    //         }

    //         $data = [
    //             'id_barang_baku' => $id_barang_baku,
    //             // 'kode_barang' => $kode_barang,
    //             'jumlah_keluar' => $jumlah_keluar,
    //             'tanggal_keluar' => $tanggal_keluar,
    //             // 'bukti_keluar_gd' => $bukti_keluar_gd,
    //             'input_status_keluar' => $input_status_keluar
    //         ];

    //         $this->Model_barang_produksi->tambahData($data);
    //     }
    //     echo json_encode($result);
    // }

    public function upload()
    {
        $id_barang_baku = $this->input->post('id_barang_baku', true);
        $jumlah_keluar = $this->input->post('jumlah_keluar', true);
        $tanggal_keluar = $this->input->post('tanggal_keluar', true);
        $input_status_keluar = $this->session->userdata('nama_lengkap');

        // Validasi data input
        if ($id_barang_baku == '') {
            $result['pesan'] = "Nama Barang harus di pilih";
        } elseif ($jumlah_keluar == '') {
            $result['pesan'] = "Jumlah Barang harus diisi";
        } elseif ($tanggal_keluar == '') {
            $result['pesan'] = "Tanggal harus di isi";
        } else {
            $file_name = date('Y-m-d', strtotime($tanggal_keluar)) . '.jpg';
            // Konfigurasi upload
            $config['upload_path'] = './uploads/baku/keluar/';
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['max_size'] = 1000;
            $config['file_name']     = $file_name;
            $config['overwrite']     = true; // Mengizinkan penggantian file yang ada dengan nama yang sama

            $this->load->library('upload', $config);

            // Cek apakah pengunggahan file berhasil
            if (!$this->upload->do_upload('bukti_keluar_gd')) {
                $error_msg = $this->upload->display_errors();
                $result['pesan'] = $error_msg;
            } else {
                // Jika pengunggahan file berhasil, simpan data ke dalam database
                $data_upload = $this->upload->data();
                $bukti_keluar_gd = $file_name;

                $data = [
                    'id_barang_baku' => $id_barang_baku,
                    'jumlah_keluar' => $jumlah_keluar,
                    'tanggal_keluar' => $tanggal_keluar,
                    'bukti_keluar_gd' => $bukti_keluar_gd,
                    'input_status_keluar' => $input_status_keluar
                ];

                $inserted = $this->Model_barang_produksi->tambahData($data);

                if ($inserted) {
                    $result['pesan'] = '';
                } else {
                    $result['pesan'] = 'Gagal menyimpan data ke database.';
                }
            }
        }

        echo json_encode($result);
    }


    public function ambil_id_barang()
    {
        $id_keluar_baku = $this->input->post('id_keluar_baku');
        $where = array('id_keluar_baku' => $id_keluar_baku);
        $dataBarang = $this->Model_barang_produksi->get_Id_Barang('keluar_baku', $where)->result();
        echo json_encode($dataBarang);
    }

    public function update()
    {
        $id_keluar_baku = $this->input->post('id_keluar_baku', true);
        $id_barang_baku = $this->input->post('id_barang_baku', true);
        $kode_barang = $this->input->post('kode_barang', true);
        $jumlah_keluar = $this->input->post('jumlah_keluar', true);
        $tanggal_keluar = $this->input->post('tanggal_keluar', true);
        $created_by = $this->session->userdata('nama_lengkap');

        if ($id_barang_baku == '') {
            $result['pesan'] = "Nama Barang belum dipilih";
        } elseif ($kode_barang == '') {
            $result['pesan'] = "Kode Barang harus diisi";
        } elseif ($jumlah_keluar == '') {
            $result['pesan'] = "Jumlah Barang harus diisi";
        } elseif ($tanggal_keluar == '') {
            $result['pesan'] = "Tanggal harus diisi";
        } else {
            $where = array('id_keluar_baku' => $id_keluar_baku);
            $data = [
                'id_barang_baku' => $id_barang_baku,
                'kode_barang' => $kode_barang,
                'jumlah_keluar' => $jumlah_keluar,
                'tanggal_keluar' => $tanggal_keluar,
                'created_by' => $created_by
            ];
            $this->Model_barang_produksi->update_Barang($where, $data, 'keluar_baku');
            if ($this->db->affected_rows() <= 0) {
                $result['pesan'] = "Tidak ada update";
            } else {
                $result['pesan'] = "";
            }
        }
        echo json_encode($result);
    }

    public function hapus()
    {
        $id_keluar_baku = $this->input->post('id_keluar_baku');
        $hapus = $this->Model_barang_produksi->hapusData($id_keluar_baku);

        if ($hapus) {
            $response = array('status' => true, 'pesan' => 'Data berhasil dihapus.');
        } else {
            $response = array('status' => false, 'pesan' => 'Data gagal dihapus.');
        }

        echo json_encode($response);
    }
}
