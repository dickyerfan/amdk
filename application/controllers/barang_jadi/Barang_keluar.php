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
            redirect('auth');
        }
    }
    public function index()
    {
        $tanggal = $this->input->get('tanggal');

        $bulan = substr($tanggal, 5, 2);
        $bulanTitle = substr($tanggal, 5, 2);
        $tahun = substr($tanggal, 0, 4);

        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
            $bulan = date('m');
            $bulanTitle = date('m');
            $tahun = date('Y');
        }

        $bulanTitle = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];


        $data['title'] = 'Transaksi Keluar Barang Jadi' . ' ' . $bulanTitle[$bulan] . ' ' . $tahun;
        $data['barang_keluar'] = $this->Model_barang_jadi->getbarang_keluar($bulan, $tahun);
        if ($this->session->userdata('upk_bagian') == 'admin') {
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
            $this->load->view('templates/pengguna/footer');
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
        ];
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Form Barang Kembali';
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_jadi');
            $this->load->view('templates/pengguna/sidebar_jadi');
            $this->load->view('barang_jadi/view_barang_kembali', $data);
            $this->load->view('templates/pengguna/footer');
        } else {
            // $data_barang_keluar = $this->Model_barang_jadi->get_detail_barang_kembali($id_keluar_jadi);
            $jumlah_keluar = $data_barang_keluar->jumlah_keluar;
            $jumlah_kembali = $this->input->post('jumlah_kembali');
            $jumlah_akhir = $jumlah_keluar - $jumlah_kembali;

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
}
