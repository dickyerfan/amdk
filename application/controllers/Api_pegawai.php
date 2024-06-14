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
        $data = $this->Model_pegawai->getAll();
        echo json_encode($data);
    }

    public function view($id)
    {
        $data = $this->Model_pegawai->getdetail($id);
        echo json_encode($data);
    }

    public function create()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($data) {
            $this->Model_pegawai->tambahDataApi($data);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
        }
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($data) {
            $this->Model_pegawai->updateDataApi($id, $data);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
        }
    }

    public function delete($id)
    {
        $this->Model_pegawai->hapusData($id);
        echo json_encode(['status' => 'success']);
    }
}
