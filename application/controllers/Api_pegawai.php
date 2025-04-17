<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api_pegawai extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_pegawai');
    }

    public function index()
    {
        $data['karyawan'] = $this->Model_pegawai->getAll();

        $data['kartotal'] = $this->db->get_where('pegawai', ['aktif' => '1'])->num_rows();
        $data['kartetap'] = $this->db->get_where('pegawai', [
            'status_pegawai' => 'Karyawan Tetap',
            'aktif' => '1',
        ])->num_rows();
        $data['karkontrak'] = $this->db->get_where('pegawai', [
            'status_pegawai' => 'Karyawan Kontrak',
            'aktif' => '1',
        ])->num_rows();
        $data['karhonorer'] = $this->db->get_where('pegawai', [
            'status_pegawai' => 'Karyawan Honorer',
            'aktif' => '1',
        ])->num_rows();
        $data['karpurna'] = $this->db->get_where('pegawai', [
            'aktif' => '0',
        ])->num_rows();

        $data['karyawanTetap'] = $this->Model_pegawai->getKaryawanTetap();
        $data['karyawanKontrak'] = $this->Model_pegawai->getKaryawanKontrak();
        $data['karyawanHonorer'] = $this->Model_pegawai->getKaryawanHonorer();
        $data['karyawanPurna'] = $this->Model_pegawai->getKaryawanPurna();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function detail($id)
    {
        $karyawan = $this->Model_pegawai->getdetail($id);
        if ($karyawan) {
            echo json_encode($karyawan);
        } else {
            echo json_encode(['error' => 'Data karyawan tidak ditemukan']);
        }
    }

    // public function create()
    // {
    //     $data = json_decode(file_get_contents('php://input'), true);
    //     if ($data) {
    //         $this->Model_pegawai->tambahDataApi($data);
    //         echo json_encode(['status' => 'success']);
    //     } else {
    //         echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
    //     }
    // }

    // public function update($id)
    // {
    //     $data = json_decode(file_get_contents('php://input'), true);
    //     if ($data) {
    //         $this->Model_pegawai->updateDataApi($id, $data);
    //         echo json_encode(['status' => 'success']);
    //     } else {
    //         echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
    //     }
    // }

    // public function delete($id)
    // {
    //     $this->Model_pegawai->hapusData($id);
    //     echo json_encode(['status' => 'success']);
    // }
}
