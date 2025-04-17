<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_user');
        $this->load->library('form_validation');
        header('Access-Control-Allow-Origin: *'); // Allow all origins
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
    }


    public function index()
    {

        $data['user'] = $this->Model_user->getAll();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    // public function upload()
    // {
    //     // Set aturan validasi dan pesan kesalahan
    //     $this->form_validation->set_rules('jenis', 'Jenis', 'required|trim', [
    //         'required' => '%s harus di isi'
    //     ]);
    //     $this->form_validation->set_rules('tahun', 'Tahun', 'required|trim|min_length[2]|max_length[4]|numeric', [
    //         'required' => '%s harus di isi',
    //         'min_length' => '%s minimal 2 digit',
    //         'max_length' => '%s maksimal 4 digit',
    //         'numeric' => '%s harus di isi angka'
    //     ]);
    //     $this->form_validation->set_rules('nama_dokumen', 'Nama Dokumen', 'required|trim|is_unique[arsip.nama_dokumen]', [
    //         'required' => '%s harus di isi',
    //         'is_unique' => '%s sudah terdaftar'
    //     ]);
    //     $this->form_validation->set_rules('tentang', 'Tentang', 'required|trim', [
    //         'required' => '%s harus di isi'
    //     ]);

    //     if ($this->form_validation->run() == false) {
    //         // Menangani kesalahan validasi
    //         $this->output->set_status_header(400); // Bad Request
    //         echo json_encode([
    //             'status' => false,
    //             'message' => validation_errors()
    //         ]);
    //         return;
    //     }

    //     // Proses upload file
    //     if (!empty($_FILES['nama_file']['name'])) {
    //         $file_name = $_FILES['nama_file']['name'];

    //         $config['upload_path'] = './uploads/arsip/';
    //         $config['allowed_types'] = 'pdf|doc|docx|xls|xlsx';
    //         $config['max_size'] = 20000;
    //         $config['file_name'] = $file_name;
    //         $config['overwrite'] = true;
    //         // $config['encrypt_name'] = false;

    //         $this->load->library('upload', $config);

    //         if ($this->upload->do_upload('nama_file')) {
    //             $data['nama_file'] = $this->upload->data("file_name");
    //             $data['nama_dokumen'] = $this->input->post('nama_dokumen');
    //             $data['jenis'] = $this->input->post('jenis');
    //             $data['tahun'] = $this->input->post('tahun');
    //             $data['tentang'] = ucwords(strtolower($this->input->post('tentang')));
    //             $data['tgl_upload'] = date('Y-m-d');
    //             $data['tgl_dokumen'] = $this->input->post('tgl_dokumen');
    //             $data['keterangan'] = $this->input->post('keterangan');

    //             // Simpan data ke database menggunakan model Anda
    //             $insert_id = $this->db->insert('arsip', $data);

    //             if ($insert_id) {
    //                 $response = [
    //                     'status' => true,
    //                     'message' => 'File berhasil diunggah dan data tersimpan.',
    //                     'data' => $data
    //                 ];
    //                 $this->output
    //                     ->set_status_header(200)
    //                     ->set_content_type('application/json', 'utf-8')
    //                     ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    //             } else {
    //                 $this->output->set_status_header(500); // Internal Server Error
    //                 echo json_encode([
    //                     'status' => false,
    //                     'message' => 'Gagal menyimpan data ke database.'
    //                 ]);
    //             }
    //         } else {
    //             $this->output->set_status_header(400); // Bad Request
    //             echo json_encode([
    //                 'status' => false,
    //                 'message' => $this->upload->display_errors()
    //             ]);
    //         }
    //     } else {
    //         $this->output->set_status_header(400); // Bad Request
    //         echo json_encode([
    //             'status' => false,
    //             'message' => 'Tidak ada file yang diunggah.'
    //         ]);
    //     }
    // }

    // public function edit($id_arsip)
    // {
    //     // Validasi ID arsip
    //     if (!is_numeric($id_arsip) || $id_arsip <= 0) {
    //         echo json_encode(['error' => 'Invalid arsip ID']);
    //         return;
    //     }

    //     // Ambil data dari database berdasarkan ID arsip
    //     $arsip = $this->db->get_where('arsip', ['id_arsip' => $id_arsip])->row_array();

    //     if ($arsip) {
    //         echo json_encode($arsip);
    //     } else {
    //         echo json_encode(['error' => 'Arsip not found']);
    //     }
    // }

    // public function update($id_arsip)
    // {
    //     $input = json_decode(file_get_contents('php://input'), true);

    //     if ($input && isset($id_arsip)) {
    //         $data = [
    //             'nama_dokumen' => $input['nama_dokumen'],
    //             'jenis' => $input['jenis'],
    //             'tahun' => $input['tahun'],
    //             'tentang' => $input['tentang'],
    //             'tgl_dokumen' => $input['tgl_dokumen'],
    //             'keterangan' => $input['keterangan']
    //         ];

    //         $this->db->where('id_arsip', $id_arsip);
    //         $this->db->update('arsip', $data);

    //         if ($this->db->affected_rows() > 0) {
    //             echo json_encode([
    //                 'status' => true,
    //                 'message' => 'Data berhasil diupdate'
    //             ]);
    //         } else {
    //             echo json_encode([
    //                 'status' => false,
    //                 'message' => 'Gagal mengupdate data atau tidak ada perubahan'
    //             ]);
    //         }
    //     } else {
    //         echo json_encode([
    //             'status' => false,
    //             'message' => 'Data tidak valid atau ID arsip tidak ditemukan'
    //         ]);
    //     }
    // }

    // public function detail($id_arsip)
    // {
    //     // Validasi ID arsip
    //     if (!is_numeric($id_arsip) || $id_arsip <= 0) {
    //         echo json_encode(['error' => 'Invalid arsip ID']);
    //         return;
    //     }

    //     // Ambil data dari database berdasarkan ID arsip
    //     $detail_arsip = $this->db->get_where('arsip', ['id_arsip' => $id_arsip])->row_array();

    //     if ($detail_arsip) {
    //         echo json_encode($detail_arsip);
    //     } else {
    //         echo json_encode(['error' => 'Arsip not found']);
    //     }
    // }
}
