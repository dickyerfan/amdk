<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelanggan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_pelanggan');
        $this->load->library('form_validation');
        header('Access-Control-Allow-Origin: *'); // Allow all origins
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
    }

    public function index()
    {

        $data['pelanggan'] = $this->Model_pelanggan->get_pelanggan();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function detail($id_pelanggan)
    {
        $pelanggan = $this->Model_pelanggan->getdetail($id_pelanggan);
        if ($pelanggan) {
            echo json_encode($pelanggan);
        } else {
            echo json_encode(['error' => 'Data pelanggan tidak ditemukan']);
        }
    }

    public function search()
    {
        $nama = $this->input->get('nama');

        if (!$nama) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Parameter nama tidak ditemukan',
                'data' => []  // Pastikan data selalu berupa array
            ]);
            return;
        }

        $result = $this->Model_pelanggan->search_pelanggan($nama);

        if (empty($result)) {
            echo json_encode([
                'status' => 'success',
                'message' => 'No pelanggan found',
                'data' => []
            ]);
        } else {
            echo json_encode([
                'status' => 'success',
                'message' => 'Pelanggan found',
                'data' => $result
            ]);
        }
    }

    public function update($id_pelanggan)

    {
        $this->load->model('Pelanggan_model');
        $pelanggan = $this->Pelanggan_model->getdetail($id_pelanggan);

        if (!$pelanggan) {
            $this->output->set_status_header(404);
            echo json_encode(array('message' => 'Nama Pelanggan tidak ditemukan'));
            return;
        }


        $data = json_decode(file_get_contents('php://input'), true);
        $this->Pelanggan_model->update_pelanggan($id, $data);
        $this->output->set_status_header(200);
        echo json_encode(array('message' => 'Update Pelanggan Sukses'));
    }

    // public function search()
    // {
    //     $nama = $this->input->get('nama');
    //     if (!$nama) {
    //         echo json_encode(['error' => 'Parameter nama tidak ditemukan']);
    //         return;
    //     }
    //     $result = $this->Model_pelanggan->search_pelanggan($nama);
    //     echo json_encode($result);
    // }
}
