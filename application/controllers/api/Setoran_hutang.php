<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setoran_hutang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_piutang');
        header('Access-Control-Allow-Origin: *'); // Allow all origins
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        // if (!$this->session->userdata('nama_pengguna')) {
        //     $this->session->set_flashdata(
        //         'info',
        //         '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        //                 <strong>Maaf,</strong> Anda harus login untuk akses halaman ini...
        //               </div>'
        //     );
        //     redirect('auth');
        // }
    }



    public function index()

    {
        $data = $this->Model_piutang->get_all_setoran_hutang();
        if (empty($data)) {
            echo json_encode(['error' => 'No data found']);
        } else {
            echo json_encode($data, JSON_PRETTY_PRINT);
        }
    }

    public function get_pelanggan()
    {
        $data = $this->Model_piutang->get_pelanggan();
        echo json_encode($data);
    }


    public function get_produk()
    {
        $data = $this->Model_piutang->get_produk();
        echo json_encode($data);
    }

    // public function search()
    // {
    //     $nama = $this->input->get('nama');
    //     if (!$nama) {
    //         echo json_encode([
    //             'status' => 'error',
    //             'message' => 'Parameter nama tidak ditemukan',
    //             'data' => []
    //         ]);
    //         return;
    //     }

    //     $result = $this->Model_piutang->search_hutang($nama);

    //     // Logging data hasil pencarian
    //     log_message('debug', 'Search result: ' . print_r($result, true));

    //     // Hitung total piutang berdasarkan hasil pencarian
    //     $total_piutang = 0;
    //     foreach ($result as $row) {
    //         $total_piutang += $row['total_harga'];
    //     }

    //     if (empty($result)) {
    //         echo json_encode([
    //             'status' => 'success',
    //             'message' => 'No pelanggan found',
    //             'data' => [],
    //             'total_piutang' => $total_piutang
    //         ]);
    //     } else {
    //         echo json_encode([
    //             'status' => 'success',
    //             'message' => 'Pelanggan found',
    //             'data' => $result,
    //             'total_piutang' => $total_piutang
    //         ]);
    //     }
    // }

    public function search()
    {
        $nama = $this->input->get('nama');

        if ($nama) {
            $result = $this->Model_piutang->search_hutang($nama);
            $totalPiutang = array_sum(array_column($result, 'total_harga'));

            if (empty($result)) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Nama pelanggan tidak ditemukan',
                    'data' => [],
                    'total_piutang' => 0.0
                ]);
            } else {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Nama pelanggan ditemukan',
                    'data' => $result,
                    'total_piutang' => $totalPiutang
                ]);
            }
        } else {
            $result = $this->Model_piutang->get_all_hutang();
            $totalPiutang = array_sum(array_column($result, 'total_harga'));

            echo json_encode([
                'status' => 'success',
                'message' => 'Total piutang untuk semua pelanggan',
                'data' => $result,
                'total_piutang' => $totalPiutang
            ]);
        }
    }




    public function detail($id_pemesanan)
    {
        $pelanggan = $this->Model_piutang->get_by_pelanggan($id_pemesanan);
        if ($pelanggan) {
            echo json_encode($pelanggan);
        } else {
            echo json_encode(['error' => 'Data pelanggan tidak ditemukan']);
        }
    }

    public function upload_lunas($id_pemesanan)
    {
        $tanggal = $this->session->userdata('tanggal');
        $this->form_validation->set_rules('status_setoran_driver', 'Status Pelunasan', 'required|trim');
        $this->form_validation->set_rules('tgl_setoran_driver', 'Tanggal Pelunasan', 'required|trim');
        $this->form_validation->set_message('required', '%s masih kosong');

        if ($this->form_validation->run() == false) {
            $data['upload_nota'] = $this->Model_piutang->get_id_pemesanan($id_pemesanan);
            $data['title'] = 'Form Upload Nota Pembelian';
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_pasar');
            $this->load->view('templates/pengguna/sidebar_pasar');
            $this->load->view('pemasaran/view_lunas_hutang', $data);
            $this->load->view('templates/pengguna/footer');
        } else {

            $data['status_setoran_driver'] = $this->input->post('status_setoran_driver');
            $data['tgl_setoran_driver'] = $this->input->post('tgl_setoran_driver');
            $data['input_setoran_driver'] = $this->session->userdata('nama_lengkap');
            $this->Model_piutang->update('pemesanan', $data, $id_pemesanan);

            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Proses Pelunasan
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('pemasaran/setoran_hutang');
        }
    }

    // public function upload_lunas($id_pemesanan)
    // {
    //     $data['upload_nota'] = $this->Model_piutang->get_id_pemesanan($id_pemesanan);
    //     $data['title'] = 'Form Upload Nota Pembelian';
    //     $this->load->view('templates/pengguna/header', $data);
    //     $this->load->view('templates/pengguna/navbar_pasar');
    //     $this->load->view('templates/pengguna/sidebar_pasar');
    //     $this->load->view('pemasaran/view_lunas_hutang', $data);
    //     $this->load->view('templates/pengguna/footer');
    // }


    // public function update_lunas()
    // {
    //     if (!empty($_FILES['nota_beli']['name'])) {

    //         // Lakukan proses upload file
    //         $config['upload_path']   = './uploads/pasar/nota/';
    //         $config['allowed_types'] = 'jpg|jpeg|png|pdf';
    //         $config['max_size']      = 1000;
    //         $config['overwrite']     = true; // Mengizinkan penggantian file yang ada dengan nama yang sama

    //         $this->load->library('upload', $config);
    //         if ($this->upload->do_upload('nota_beli')) {
    //             $data_upload = $this->upload->data();
    //             $data['nota_beli'] = $data_upload['file_name'];
    //             $data['id_pemesanan'] = $this->input->post('id_pemesanan');
    //             $data['id_pelanggan'] = $this->input->post('id_pelanggan');
    //             $data['tanggal_pesan'] = $this->input->post('tanggal_pesan');
    //         } else {
    //             // Jika proses upload gagal
    //             $error_msg = $this->upload->display_errors();
    //             $this->session->set_flashdata('info', $error_msg);
    //             redirect('pemasaran/piutang');
    //         }

    //         // Isi data selain file yang diupload
    //         $data['input_update'] = $this->session->userdata('nama_lengkap');
    //         $data['tanggal_update'] = $this->input->post('tanggal_update');
    //         $data['status_nota'] = 1;
    //         $data['status_pesan'] = 1;

    //         // Simpan data ke dalam database
    //         $this->Model_piutang->update_nota($data);
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    //                 <strong>Sukses,</strong> Nota Pembelian berhasil di upload
    //                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                 </button>
    //             </div>'
    //         );
    //         // $alamat = 'pemasaran/piutang/pertanggal?tanggal=' . $tanggal;
    //         // redirect($alamat);
    //         redirect('pemasaran/setoran_hutang');
    //     } else {
    //         // Tampilkan pesan kesalahan jika tidak ada file yang diunggah
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //                 <strong>Gagal,</strong> Silakan masukkan bukti nota pembayaran
    //                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                 </button>
    //             </div>'
    //         );
    //         // $alamat = 'pemasaran/piutang/pertanggal?tanggal=' . $tanggal;
    //         // redirect($alamat);
    //         redirect('pemasaran/setoran_hutang');
    //     }
    // }
}
