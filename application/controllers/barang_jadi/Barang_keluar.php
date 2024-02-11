<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_keluar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_barang_jadi');

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
        if ($level_pengguna != 'Admin' && $upk_bagian != 'jadi') {
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
        // $tanggal = $this->input->get('tanggal');

        // $bulan = substr($tanggal, 5, 2);
        // $bulanTitle = substr($tanggal, 5, 2);
        // $tahun = substr($tanggal, 0, 4);

        // if (empty($tanggal)) {
        //     $tanggal = date('Y-m-d');
        //     $bulan = date('m');
        //     $bulanTitle = date('m');
        //     $tahun = date('Y');
        // }

        // $bulanTitle = [
        //     '01' => 'Januari',
        //     '02' => 'Februari',
        //     '03' => 'Maret',
        //     '04' => 'April',
        //     '05' => 'Mei',
        //     '06' => 'Juni',
        //     '07' => 'Juli',
        //     '08' => 'Agustus',
        //     '09' => 'September',
        //     '10' => 'Oktober',
        //     '11' => 'November',
        //     '12' => 'Desember',
        // ];

        // $data['title'] = 'Transaksi Keluar Barang Jadi' . ' ' . $bulanTitle[$bulan] . ' ' . $tahun;

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

        if (!empty($tanggal)) {
            $this->session->set_userdata('tanggal', $tanggal); // Simpan tanggal ke session jika diperlukan
        }
        $data['tanggal_hari_ini'] = $this->input->get('tanggal');
        $data['title'] = 'Transaksi Keluar Barang Jadi';

        $data['barang_keluar'] = $this->Model_barang_jadi->getbarang_keluar($tanggal);
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_jadi/view_barang_keluar', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_jadi');
            $this->load->view('templates/pengguna/sidebar_jadi');
            $this->load->view('barang_jadi/view_barang_keluar', $data);
            $this->load->view('templates/pengguna/footer_jadi');
        }
    }

    public function barang_kembali($id_keluar_jadi)
    {
        $this->form_validation->set_rules('jumlah_kembali', 'jumlah barang kembali', 'required|trim|numeric');
        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('numeric', '%s harus di isi dengan angka');
        $data_barang_keluar = $this->Model_barang_jadi->get_detail_barang_kembali($id_keluar_jadi);
        $data = [
            'nama_barang_jadi' => $data_barang_keluar->nama_barang_jadi,
            'jumlah_keluar' => $data_barang_keluar->jumlah_keluar,
            'tanggal_keluar' => $data_barang_keluar->tanggal_keluar,
            'jenis_pesanan' => $data_barang_keluar->jenis_pesanan,
        ];
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Form Barang Kembali';
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_jadi');
            $this->load->view('templates/pengguna/sidebar_jadi');
            $this->load->view('barang_jadi/view_barang_kembali', $data);
            $this->load->view('templates/pengguna/footer_jadi');
        } else {
            // $data_barang_keluar = $this->Model_barang_jadi->get_detail_barang_kembali($id_keluar_jadi);
            $jumlah_keluar = $data_barang_keluar->jumlah_keluar;
            $jumlah_kembali = $this->input->post('jumlah_kembali');
            $jumlah_akhir = $jumlah_keluar - $jumlah_kembali;

            if ($data_barang_keluar->jenis_pesanan == 1) {
                $jumlah_akhir = 0;
            }

            $data_jumlah_kembali = [
                'jumlah_kembali' => $jumlah_kembali,
                'jumlah_akhir' => $jumlah_akhir,
                'status_kembali' => 1
            ];

            $this->Model_barang_jadi->update_barang_kembali('keluar_jadi', $data_jumlah_kembali, $id_keluar_jadi);
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> barang kembali berhasil ditambahkan
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('barang_jadi/barang_keluar');
        }
    }

    public function terima_barang($id_keluar_jadi)
    {
        date_default_timezone_set('Asia/Jakarta');
        $data_terima_barang = [
            'status_keluar' => 1,
            'input_pemilik_barang' => $this->session->userdata('nama_lengkap'),
            'tanggal_barang_keluar' => date('Y-m-d H:i:s')
        ];
        $this->Model_barang_jadi->terima_barang($data_terima_barang, $id_keluar_jadi);
        redirect('barang_jadi/barang_keluar');
    }

    public function check_permintaan_barang_jadi()
    {
        $this->db->select('*');
        $this->db->from('keluar_jadi');
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
