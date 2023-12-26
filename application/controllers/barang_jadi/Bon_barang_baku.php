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
        $data['title'] = 'Permintaan Barang Baku';
        $data['barang_baku'] = $this->Model_barang_jadi->getbarang_baku($bulan, $tahun);
        if ($this->session->userdata('upk_bagian') == 'admin') {
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

    public function upload()
    {
        $this->form_validation->set_rules('id_barang_baku', 'Nama Barang', 'required|trim');
        $this->form_validation->set_rules('jumlah_keluar', 'Jumlah Keluar', 'required|trim|numeric|greater_than[0]');
        $this->form_validation->set_rules('tanggal_keluar', 'Tanggal Keluar', 'required|trim');
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
            // Cek apakah ada file yang diupload
            if (!empty($_FILES['bukti_keluar_gd']['name'])) {
                // Mendapatkan tanggal dari input form
                $tanggal_keluar = $this->input->post('tanggal_keluar', true);
                $id_barang_baku = $this->input->post('id_barang_baku', true);

                $kode = $this->db->get_where('barang_baku', ['id_barang_baku' => $id_barang_baku])->row();

                if ($kode) {
                    // Membuat format tanggal dalam bentuk YYYYmmdd
                    $formatted_tanggal = date('ymd', strtotime($tanggal_keluar));
                    $tanggal_query = date('Y-m-d', strtotime($tanggal_keluar));

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
                } else {
                    $kode_barang = null;
                }

                // Membuat nama file sesuai dengan tanggal
                $file_name = date('Y-m-d', strtotime($tanggal_keluar)) . '.jpg';

                // Menyimpan file dengan nama yang sesuai
                $config['upload_path']   = './uploads/baku/keluar/';
                $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config['max_size']      = 1000;
                $config['file_name']     = $file_name;
                $config['overwrite']     = true; // Mengizinkan penggantian file yang ada dengan nama yang sama

                $this->load->library('upload', $config);
                if ($this->upload->do_upload('bukti_keluar_gd')) {
                    // Isi data selain file yang diupload
                    $data['id_barang_baku'] = (int) $this->input->post('id_barang_baku', true);
                    $data['jumlah_keluar'] = $this->input->post('jumlah_keluar', true);
                    $data['tanggal_keluar'] = $this->input->post('tanggal_keluar', true);
                    $data['input_status_keluar'] = $this->session->userdata('nama_lengkap');
                    $data['bagian'] = $this->session->userdata('upk_bagian');
                    $data['bukti_keluar_gd'] = $file_name; // Simpan nama file dalam database
                    $data['kode_barang'] = $kode_barang;
                    // Simpan data ke dalam database
                    // $this->db->insert('baku_produksi', $data);
                    $this->db->insert('keluar_baku', $data);

                    $this->session->set_flashdata(
                        'info',
                        '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>Sukses,</strong> Permintaan barang baku berhasil dikirimkan
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>'
                    );
                    redirect('barang_jadi/bon_barang_baku');
                } else {
                    // Jika proses upload gagal
                    $error_msg = $this->upload->display_errors();
                    $this->session->set_flashdata('info', $error_msg);
                    redirect('barang_jadi/bon_barang_baku');
                }
            } else {
                // Tampilkan pesan kesalahan jika tidak ada file yang diunggah
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Gagal,</strong> Silakan masukkan file permintaan barang
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>'
                );
                redirect('barang_jadi/bon_barang_baku');
            }
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

    public function edit($id_barang_baku_jadi)
    {
        $data['title'] = "Form ambil kardus";
        $data['edit_baku_jadi'] = $this->db->get_where('barang_baku_jadi', ['id_barang_baku_jadi' => $id_barang_baku_jadi])->row();
        $data['nama_barang'] = $this->Model_barang_jadi->get_nama_barang_baku();
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar_jadi');
        $this->load->view('templates/pengguna/sidebar_jadi');
        $this->load->view('barang_jadi/view_edit_barang_baku', $data);
        $this->load->view('templates/pengguna/footer_jadi');
    }

    public function update()
    {
        $this->Model_barang_jadi->update_baku_jadi();
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
