<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_jadi extends CI_Controller
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
        $data['title'] = 'Produksi Barang Jadi';
        $data['barang_jadi'] = $this->Model_barang_produksi->getbarang_jadi();
        if ($this->session->userdata('upk_bagian') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_produksi/view_barang_jadi', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_produksi');
            $this->load->view('templates/pengguna/sidebar_produksi');
            $this->load->view('barang_produksi/view_barang_jadi', $data);
            $this->load->view('templates/pengguna/footer_produksi');
        }
    }

    public function upload()
    {
        // $this->form_validation->set_rules('id_jenis_barang', 'Jenis Barang Jadi', 'trim');
        // $this->form_validation->set_rules('jumlah_barang_jadi', 'Jumlah Barang Jadi', 'trim|numeric');
        $this->form_validation->set_rules('tanggal_barang_jadi', 'Tanggal Barang Jadi', 'required|trim');
        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('numeric', '%s harus berupa angka');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Produksi Barang Jadi';
            $data['jenis_barang'] = $this->Model_barang_produksi->get_jenis_barang();
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_produksi');
            $this->load->view('templates/pengguna/sidebar_produksi');
            $this->load->view('barang_produksi/view_tambah_barang_jadi', $data);
            $this->load->view('templates/pengguna/footer_produksi');
        } else {
            $tanggal_barang_jadi = $this->input->post('tanggal_barang_jadi');
            $jumlah_barang_jadi = $this->input->post('jumlah_barang_jadi');
            $jenis_barang = $this->input->post('id_jenis_barang');

            // Loop melalui jenis barang yang dipilih
            foreach ($jenis_barang as $id_jenis_barang) {
                $jumlah = $jumlah_barang_jadi[$id_jenis_barang];
                $data = array(
                    'id_jenis_barang' => $id_jenis_barang,
                    'jumlah_barang_jadi' => $jumlah,
                    'tanggal_barang_jadi' => $tanggal_barang_jadi,
                    'input_status_barang_jadi' => $this->session->userdata('nama_lengkap')
                );
                $this->Model_barang_produksi->upload_barang_jadi($data);
            }
            redirect('barang_produksi/barang_jadi');
        }
    }
    // public function upload()
    // {
    //     $this->form_validation->set_rules('id_jenis_barang', 'Jenis Barang Jadi', 'trim');
    //     $this->form_validation->set_rules('jumlah_barang_jadi', 'Jumlah Barang Jadi', 'trim|numeric');
    //     $this->form_validation->set_rules('tanggal_barang_jadi', 'Tanggal Barang Jadi', 'required|trim');
    //     $this->form_validation->set_message('required', '%s masih kosong');
    //     $this->form_validation->set_message('numeric', '%s harus berupa angka');

    //     if ($this->form_validation->run() == false) {
    //         $data['title'] = 'Produksi Barang Jadi';
    //         $data['jenis_barang'] = $this->Model_barang_produksi->get_jenis_barang();
    //         $this->load->view('templates/pengguna/header', $data);
    //         $this->load->view('templates/pengguna/navbar_produksi');
    //         $this->load->view('templates/pengguna/sidebar_produksi');
    //         $this->load->view('barang_produksi/view_tambah_barang_jadi', $data);
    //         $this->load->view('templates/pengguna/footer_produksi');
    //     } else {
    //         $data['id_jenis_barang'] = (int) $this->input->post('id_jenis_barang', true);
    //         $data['jumlah_barang_jadi'] = $this->input->post('jumlah_barang_jadi', true);
    //         $data['tanggal_barang_jadi'] = $this->input->post('tanggal_barang_jadi', true);
    //         $data['input_status_barang_jadi'] = $this->session->userdata('nama_lengkap');

    //         // Simpan data ke dalam database
    //         // $this->db->insert('barang_jadi', $data);
    //         $this->Model_barang_produksi->upload_barang_jadi($data);
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    //                             <strong>Sukses,</strong> Transaksi Barang jadi berhasil di simpan
    //                             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                             </button>
    //                         </div>'
    //         );
    //         redirect('barang_produksi/barang_jadi');
    //     }
    // }

    public function proses_jadi($id_barang_jadi)
    {
        $data = [
            'status_barang_produksi' => 0,
            'status_barang_jadi' => 1
            // 'tgl_update_barang_jadi' => date('Y-m-d H:i:s')
        ];
        $this->Model_barang_produksi->Update_status_barang_jadi($id_barang_jadi, $data);
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>Sukses,</strong> Barang berhasil di kirim ke Barang Jadi
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>'
        );
        redirect('barang_produksi/barang_jadi');
    }
}
