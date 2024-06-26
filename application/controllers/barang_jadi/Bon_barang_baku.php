<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bon_barang_baku extends CI_Controller
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
        // $tahun = substr($tanggal, 0, 4);
        // if (empty($tanggal)) {
        //     $tanggal = date('Y-m-d');
        //     $bulan = date('m');
        //     $tahun = date('Y');
        // }
        // $data['bulan_lap'] = $bulan;
        // $data['tahun_lap'] = $tahun;
        // $data['barang_baku'] = $this->Model_barang_jadi->getbarang_baku($bulan, $tahun);

        $tanggal = $this->input->get('tanggal');
        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
        }
        $data['tanggal_hari_ini'] = $this->input->get('tanggal');
        $data['stok_barang'] = $this->Model_barang_jadi->getdata_barang_baku_jadi($tanggal);
        $data['title'] = 'Persediaan Barang Baku';
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_jadi/view_barang_baku', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_jadi');
            $this->load->view('templates/pengguna/sidebar_jadi');
            $this->load->view('barang_jadi/view_barang_baku', $data);
            $this->load->view('templates/pengguna/footer_jadi');
        }
    }

    // public function upload()
    // {
    //     $this->form_validation->set_rules('id_barang_baku', 'Nama Barang', 'required|trim');
    //     $this->form_validation->set_rules('jumlah_keluar', 'Jumlah Barang', 'required|trim|numeric|greater_than[0]');
    //     $this->form_validation->set_rules('tanggal_keluar', 'Tanggal Pesan', 'required|trim');
    //     $this->form_validation->set_message('required', '%s masih kosong');
    //     $this->form_validation->set_message('numeric', '%s harus berupa angka');
    //     $this->form_validation->set_message('greater_than', '%s harus lebih besar dari 0');

    //     if ($this->form_validation->run() == false) {
    //         $data['title'] = 'Transaksi Barang Baku';
    //         $data['nama_barang'] = $this->Model_barang_jadi->get_nama_barang_baku();
    //         $this->load->view('templates/pengguna/header', $data);
    //         $this->load->view('templates/pengguna/navbar_jadi');
    //         $this->load->view('templates/pengguna/sidebar_jadi');
    //         $this->load->view('barang_jadi/view_tambah_barang_baku', $data);
    //         $this->load->view('templates/pengguna/footer_jadi');
    //     } else {

    //         $tanggal_keluar = $this->input->post('tanggal_keluar', true);
    //         $id_barang_baku = $this->input->post('id_barang_baku', true);
    //         $jumlah_keluar = $this->input->post('jumlah_keluar', true);

    //         $kode = $this->db->get_where('barang_baku', ['id_barang_baku' => $id_barang_baku])->row();

    //         if ($kode) {
    //             // Membuat format tanggal dalam bentuk YYYYmmdd
    //             $formatted_tanggal = date('ymd', strtotime($tanggal_keluar));

    //             // Mengambil nomor urut terakhir berdasarkan tanggal dan id_barang_baku
    //             $this->db->select('MAX(CAST(SUBSTRING_INDEX(kode_barang, "-", -1) AS SIGNED)) as max_urut', false);
    //             $this->db->from('keluar_baku');
    //             $this->db->where('tanggal_keluar', date('Y-m-d', strtotime($tanggal_keluar)));
    //             $this->db->where('id_barang_baku', $id_barang_baku);
    //             $result = $this->db->get()->row();

    //             // Jika tidak ada data, kembalikan nomor urut pertama
    //             $nomor_urut = $result->max_urut ? $result->max_urut + 1 : 1;

    //             // Menggabungkan kode barang dengan nomor urut
    //             $kode_barang = strtoupper($kode->kode_barang) . '-' . $formatted_tanggal . '-' . sprintf('%02d', $nomor_urut);
    //             $data = [
    //                 'id_barang_baku' => $id_barang_baku,
    //                 'tanggal_keluar' => $tanggal_keluar,
    //                 'jumlah_keluar' => $jumlah_keluar,
    //                 'input_status_keluar' => $this->session->userdata('nama_lengkap'),
    //                 'bagian' => $this->session->userdata('upk_bagian'),
    //                 'kode_barang' => $kode_barang,
    //                 'tgl_input_keluar' => date('Y-m-d H:i:s')
    //             ];
    //         } else {
    //             $kode_barang = null;
    //         }
    //         // $this->db->insert('keluar_baku', $data);
    //         $this->Model_barang_jadi->upload('keluar_baku', $data);
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    //                     <strong>Sukses,</strong> Permintaan barang baku berhasil dikirimkan
    //                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                     </button>
    //                 </div>'
    //         );
    //         redirect('barang_jadi/bon_barang_baku');
    //     }
    // }

    public function upload()
    {
        $this->form_validation->set_rules('id_barang_baku', 'Nama Barang', 'required|trim');
        $this->form_validation->set_rules('jumlah_keluar', 'Jumlah Barang', 'required|trim|numeric|greater_than[0]');
        $this->form_validation->set_rules('tanggal_keluar', 'Tanggal Pesan', 'required|trim');
        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('numeric', '%s harus berupa angka');
        $this->form_validation->set_message('greater_than', '%s harus lebih besar dari 0');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Transaksi Barang Baku';
            $data['nama_barang'] = $this->Model_barang_jadi->get_nama_barang_baku();
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_jadi');
            $this->load->view('templates/pengguna/sidebar_jadi');
            $this->load->view('barang_jadi/view_tambah_barang_baku', $data);
            $this->load->view('templates/pengguna/footer_jadi');
        } else {

            $tanggal_keluar = $this->input->post('tanggal_keluar', true);
            $id_barang_baku = $this->input->post('id_barang_baku', true);
            $jumlah_keluar = $this->input->post('jumlah_keluar', true);

            $kode = $this->db->get_where('barang_baku', ['id_barang_baku' => $id_barang_baku])->row();

            if ($kode) {
                // Membuat format tanggal dalam bentuk YYYYmmdd
                $formatted_tanggal = date('ymd', strtotime($tanggal_keluar));

                // Mengambil nomor urut terakhir berdasarkan tanggal dan id_barang_baku
                $this->db->select('MAX(CAST(SUBSTRING_INDEX(kode_barang, "-", -1) AS SIGNED)) as max_urut', false);
                $this->db->from('keluar_baku');
                $this->db->where('tanggal_keluar', date('Y-m-d', strtotime($tanggal_keluar)));
                $this->db->where('id_barang_baku', $id_barang_baku);
                $result = $this->db->get()->row();

                // Jika tidak ada data, kembalikan nomor urut pertama
                $nomor_urut = $result->max_urut ? $result->max_urut + 1 : 1;

                // Menggabungkan kode barang dengan nomor urut
                $kode_barang = strtoupper($kode->kode_barang) . '-' . $formatted_tanggal . '-' . sprintf('%02d', $nomor_urut);
                $data = [
                    'id_barang_baku' => $id_barang_baku,
                    'tanggal_keluar' => $tanggal_keluar,
                    'jumlah_keluar' => $jumlah_keluar,
                    'input_status_keluar' => $this->session->userdata('nama_lengkap'),
                    'bagian' => $this->session->userdata('upk_bagian'),
                    'kode_barang' => $kode_barang,
                    'tgl_input_keluar' => date('Y-m-d H:i:s')
                ];

                $data_barang_jadi = [
                    'id_barang_baku' => $id_barang_baku,
                    'jumlah_masuk' => $jumlah_keluar,
                    'tanggal_masuk' => $tanggal_keluar,
                    'input_bbj_masuk' => $this->session->userdata('nama_lengkap'),
                    'tgl_input_bbj_masuk' => date('Y-m-d H:i:s'),
                    'kode_barang' => $kode_barang,
                ];
            } else {
                $kode_barang = null;
            }
            // $this->db->insert('keluar_baku', $data);
            $this->Model_barang_jadi->upload('keluar_baku', $data);
            $this->Model_barang_jadi->upload('barang_baku_jadi_masuk', $data_barang_jadi);
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Permintaan barang baku berhasil dikirimkan
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>'
            );
            redirect('barang_jadi/bon_barang_baku');
        }
    }

    public function cek_status_produksi()
    {
        $this->db->select('*');
        $this->db->from('keluar_baku');
        $this->db->where('status_produksi', 0);
        $this->db->where('bagian', 'jadi');
        $result = $this->db->get()->result();

        if ($result) {
            $response['success'] = true;
        } else {
            $response['success'] = false;
        }

        echo json_encode($response);
    }

    public function update_status_produksi()
    {
        $data = [
            'status_produksi' => 1
        ];
        $this->db->where('bagian', 'jadi');
        $this->db->update('keluar_baku', $data);
        redirect('barang_jadi/bon_barang_baku');
    }

    public function ambil_kardus()
    {
        $this->form_validation->set_rules('id_barang_baku', 'Nama Barang', 'required|trim');
        $this->form_validation->set_rules('jumlah_keluar', 'Jumlah Keluar', 'required|trim|numeric|greater_than[0]');
        $this->form_validation->set_rules('tanggal_keluar', 'Tanggal Keluar', 'required|trim');
        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('numeric', '%s harus berupa angka');
        $this->form_validation->set_message('greater_than', '%s harus lebih besar dari 0');

        if ($this->form_validation->run() == false) {
            $data['title'] = "Form ambil kardus";
            $data['nama_barang'] = $this->Model_barang_jadi->get_nama_barang_baku();
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_jadi');
            $this->load->view('templates/pengguna/sidebar_jadi');
            $this->load->view('barang_jadi/view_ambil_kardus', $data);
            $this->load->view('templates/pengguna/footer_jadi');
        } else {

            $data['id_barang_baku'] = (int) $this->input->post('id_barang_baku', true);
            $data['jumlah_keluar'] = $this->input->post('jumlah_keluar', true);
            $data['tanggal_keluar'] = $this->input->post('tanggal_keluar', true);
            $data['input_bbj_keluar'] = $this->session->userdata('nama_lengkap');

            $this->Model_barang_jadi->ambil_kardus($data);
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Sukses,</strong> barang baku kardus berhasil diambil
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                          </div>'
            );
            redirect('barang_jadi/bon_barang_baku');
        }
    }
}
