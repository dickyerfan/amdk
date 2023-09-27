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
            $this->load->view('templates/pengguna/navbar');
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

    public function upload()
    {
        $id_barang_baku = $this->input->post('id_barang_baku', true);
        $kode_barang = $this->input->post('kode_barang', true);
        $jumlah_keluar = $this->input->post('jumlah_keluar', true);
        $tanggal_keluar = $this->input->post('tanggal_keluar', true);
        $created_by = $this->session->userdata('nama_lengkap');

        if ($id_barang_baku == '') {
            $result['pesan'] = "Nama Barang harus di pilih";
        } elseif ($kode_barang == '') {
            $result['pesan'] = "Kode Barang harus di isi";
        } elseif ($jumlah_keluar == '') {
            $result['pesan'] = "Jumlah Barang harus  ";
        } elseif ($tanggal_keluar == '') {
            $result['pesan'] = "tanggal harus di isi";
        } else {
            $result['pesan'] = "";

            $data = [
                'id_barang_baku' => $id_barang_baku,
                'kode_barang' => $kode_barang,
                'jumlah_keluar' => $jumlah_keluar,
                'tanggal_keluar' => $tanggal_keluar,
                'created_by' => $created_by
            ];

            $this->Model_barang_produksi->tambahData($data);
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
