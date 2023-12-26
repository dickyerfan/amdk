<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_keluar extends CI_Controller
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
        $this->session->set_userdata('tanggal_keluar', $tanggal);
        $data['bulan_lap'] = $bulan;
        $data['tahun_lap'] = $tahun;

        $data['title'] = 'Transaksi Barang Keluar';
        // $data['barang_keluar'] = $this->Model_barang_baku->getbarang_keluar($bulan, $tahun);
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_baku/view_barang_keluar', $data);
            $this->load->view('templates/pengguna/footer_baku');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_baku');
            $this->load->view('templates/pengguna/sidebar_baku');
            $this->load->view('barang_baku/view_barang_keluar', $data);
            $this->load->view('templates/pengguna/footer_baku');
        }
    }

    function get_permintaan_barang()
    {
        $tanggal = $this->session->userdata('tanggal_keluar');

        $bulan = substr($tanggal, 5, 2);
        $tahun = substr($tanggal, 0, 4);

        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
            $bulan = date('m');
            $tahun = date('Y');
        }
        $data = $this->Model_barang_baku->get_permintaan_barang($bulan, $tahun);
        echo json_encode($data);
    }

    public function update_status_keluar()
    {
        $id_keluar_baku = $this->input->post('id_keluar_baku');

        // Lakukan pembaruan status_keluar ke 1 di tabel keluar_baku
        $data_keluar = [
            'status_keluar' => 1,
            'status_produksi' => 0
        ];
        $this->db->where('id_keluar_baku', $id_keluar_baku);
        $result_keluar = $this->db->update('keluar_baku', $data_keluar);

        // Jika pembaruan tabel keluar_baku berhasil
        if ($result_keluar) {
            // Jika bagian adalah barang jadi, tambahkan data ke tabel barang_baku_jadi
            $this->db->where('id_keluar_baku', $id_keluar_baku);
            $query_keluar = $this->db->get('keluar_baku');
            $data_keluar_baku = $query_keluar->row_array();
            if ($data_keluar_baku['bagian'] === 'jadi') {

                $data_baku_jadi = [
                    'id_barang_baku' => $data_keluar_baku['id_barang_baku'],
                    'jumlah_masuk' => $data_keluar_baku['jumlah_keluar'],
                    'jumlah_akhir' => $data_keluar_baku['jumlah_keluar'],
                    'tanggal_order' => $data_keluar_baku['tanggal_keluar'],
                    'status_baku_jadi' => $data_keluar_baku['status_keluar'],
                    'input_status_baku_jadi' => $data_keluar_baku['input_status_keluar'],
                    'kode_barang' => $data_keluar_baku['kode_barang']
                ];

                $result_baku_jadi = $this->db->insert('barang_baku_jadi', $data_baku_jadi);

                if ($result_baku_jadi) {
                    $response['success'] = true;
                    $response['inserted_data'] = $data_keluar_baku;
                } else {
                    $response['success'] = false;
                    $response['error'] = 'Gagal menambahkan data ke tabel barang_baku_jadi';
                }
            } else {
                $response['success'] = true;
                $response['message'] = 'Data tidak ditambahkan karena bukan bagian barang jadi';
            }
        } else {
            $response['success'] = false;
            $response['error'] = 'Gagal memperbarui status_keluar di tabel keluar_baku';
        }

        echo json_encode($response);
    }

    // public function update_status_keluar()
    // {
    //     $id_keluar_baku = $this->input->post('id_keluar_baku');

    //     // Lakukan pembaruan status_keluar ke 1 di tabel keluar_baku
    //     $data_keluar = [
    //         'status_keluar' => 1,
    //         'status_produksi' => 0
    //     ];
    //     $this->db->where('id_keluar_baku', $id_keluar_baku);
    //     $result_keluar = $this->db->update('keluar_baku', $data_keluar);

    //     // Jika pembaruan tabel keluar_baku berhasil
    //     if ($result_keluar) {
    //         // Jika bagian adalah produksi, tambahkan data ke tabel baku_produksi
    //         $this->db->where('id_keluar_baku', $id_keluar_baku);
    //         $query_keluar = $this->db->get('keluar_baku');
    //         $data_keluar_baku = $query_keluar->row_array();
    //         if ($data_keluar_baku['bagian'] === 'produksi') {

    //             $data_baku_produksi = [
    //                 'id_keluar_baku' => $data_keluar_baku['id_keluar_baku'],
    //                 'id_barang_baku' => $data_keluar_baku['id_barang_baku'],
    //                 'jumlah_keluar' => $data_keluar_baku['jumlah_keluar'],
    //                 'tanggal_keluar' => $data_keluar_baku['tanggal_keluar'],
    //                 'input_status_keluar' => $data_keluar_baku['input_status_keluar'],
    //                 'bukti_keluar_gd' => $data_keluar_baku['bukti_keluar_gd'],
    //                 'bagian' => $data_keluar_baku['bagian']
    //             ];

    //             $result_baku_produksi = $this->db->insert('baku_produksi', $data_baku_produksi);

    //             if ($result_baku_produksi) {
    //                 $response['success'] = true;
    //                 $response['inserted_data'] = $data_keluar_baku;
    //             } else {
    //                 $response['success'] = false;
    //                 $response['error'] = 'Gagal menambahkan data ke tabel baku_produksi';
    //             }
    //         } else {
    //             $response['success'] = true;
    //             $response['message'] = 'Data tidak ditambahkan karena bukan bagian produksi';
    //         }
    //     } else {
    //         $response['success'] = false;
    //         $response['error'] = 'Gagal memperbarui status_keluar di tabel keluar_baku';
    //     }

    //     echo json_encode($response);
    // }



    public function detail_status_keluar($id_keluar_baku)
    {
        $data['detail_barang_keluar'] = $this->Model_barang_baku->get_detail_barang_keluar($id_keluar_baku);
        $data['title'] = 'Detail Barang Baku';

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_baku/view_detail_keluar_barang_baku', $data);
            $this->load->view('templates/pengguna/footer_baku');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_baku');
            $this->load->view('templates/pengguna/sidebar_baku');
            $this->load->view('barang_baku/view_detail_keluar_barang_baku', $data);
            $this->load->view('templates/pengguna/footer_baku');
        }
    }

    public function cek_status_permintaan_barang()
    {
        $this->db->select('*');
        $this->db->from('keluar_baku');
        $this->db->where('status_keluar', 0);
        $result = $this->db->get()->result();

        if ($result) {
            $response['success'] = true;
        } else {
            $response['success'] = false;
        }

        echo json_encode($response);
    }
}
