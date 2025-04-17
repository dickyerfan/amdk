<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_rusak extends CI_Controller
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
        $data['title'] = 'Berita Acara Barang Rusak';
        $data['barang_rusak'] = $this->Model_barang_jadi->getbarang_rusak($bulan, $tahun);
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_jadi/view_barang_rusak', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_jadi');
            $this->load->view('templates/pengguna/sidebar_jadi');
            $this->load->view('barang_jadi/view_barang_rusak', $data);
            $this->load->view('templates/pengguna/footer_jadi');
        }
    }

    public function upload()
    {
        $this->form_validation->set_rules('id_jenis_barang', 'Nama Barang', 'required|trim');
        $this->form_validation->set_rules('jumlah_rusak_jadi', 'Jumlah Rusak', 'required|trim|numeric');
        $this->form_validation->set_rules('tanggal_rusak_jadi', 'Tanggal Rusak', 'required|trim');
        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('numeric', '%s harus berupa angka');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Transaksi Barang Rusak';
            $data['nama_barang'] = $this->Model_barang_jadi->get_nama_barang();
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_jadi');
            $this->load->view('templates/pengguna/sidebar_jadi');
            $this->load->view('barang_jadi/view_rusak_barang_jadi', $data);
            $this->load->view('templates/pengguna/footer_jadi');
        } else {
            // Cek apakah ada file yang diupload
            if (!empty($_FILES['bukti_rusak_jadi']['name'])) {
                // Mendapatkan tanggal dari input form
                $tanggal_rusak_jadi = $this->input->post('tanggal_rusak_jadi', true);
                // Membuat nama file sesuai dengan tanggal
                // $file_name = date('Y-m-d', strtotime($tanggal_rusak_jadi)) . '.jpg';
                $file_name = $_FILES['bukti_rusak_jadi']['name'];

                // Menyimpan file dengan nama yang sesuai
                $config['upload_path']   = './uploads/jadi/rusak/';
                $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config['max_size']      = 1000;
                $config['file_name']     = $file_name;
                $config['overwrite']     = true; // Mengizinkan penggantian file yang ada dengan nama yang sama
                $config['encrypt_name']  = false; // Menonaktifkan enkripsi nama file

                $this->load->library('upload', $config);
                if ($this->upload->do_upload('bukti_rusak_jadi')) {
                    // Isi data selain file yang diupload
                    $data['id_jenis_barang'] = (int) $this->input->post('id_jenis_barang', true);
                    $data['jumlah_rusak_jadi'] = $this->input->post('jumlah_rusak_jadi', true);
                    $data['jumlah_rusak_akhir'] = $this->input->post('jumlah_rusak_jadi', true);
                    $data['tanggal_rusak_jadi'] = $tanggal_rusak_jadi;
                    $data['input_status_rusak_jadi'] = $this->session->userdata('nama_lengkap');
                    // $data['bukti_rusak_jadi'] = $file_name; // Simpan nama file dalam database
                    $data['bukti_rusak_jadi'] = str_replace(' ', '_', $file_name); // Ganti spasi dengan underscore
                    $data['keterangan'] = $this->input->post('keterangan', true);
                    $data['tgl_input_rusak_jadi'] = date('Y-m-d H:i:s');

                    // Simpan data ke dalam database
                    $this->db->insert('rusak_jadi', $data);

                    $this->session->set_flashdata(
                        'info',
                        '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>Sukses,</strong> Transaksi Barang Rusak berhasil di simpan
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>'
                    );
                    redirect('barang_jadi/barang_rusak');
                } else {
                    // Jika proses upload gagal
                    $error_msg = $this->upload->display_errors();
                    $this->session->set_flashdata('info', $error_msg);
                    redirect('barang_jadi/barang_rusak');
                }
            } else {
                // Tampilkan pesan kesalahan jika tidak ada file yang diunggah
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Gagal,</strong> Silakan masukkan file foto barang rusak
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>'
                );
                redirect('barang_jadi/barang_rusak');
            }
        }
    }


    public function detail_rusak($id_rusak_jadi)
    {
        $data['detail_barang_rusak'] = $this->Model_barang_jadi->get_detail_barang_rusak($id_rusak_jadi);
        $data['title'] = 'Detail Barang Rusak';

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_jadi/view_detail_rusak_barang_jadi', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_jadi');
            $this->load->view('templates/pengguna/sidebar_jadi');
            $this->load->view('barang_jadi/view_detail_rusak_barang_jadi', $data);
            $this->load->view('templates/pengguna/footer_jadi');
        }
    }

    public function perbaikan($id_rusak_jadi)
    {
        $this->form_validation->set_rules('jumlah_perbaikan', 'jumlah perbaikan', 'required|trim|numeric');
        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('numeric', '%s harus di isi dengan angka');

        $data_barang_rusak = $this->Model_barang_jadi->get_detail_barang_rusak($id_rusak_jadi);
        $rusak_jadi_detail = $data_barang_rusak[0];

        $nama_barang_jadi = $rusak_jadi_detail->nama_barang_jadi;
        $jumlah_rusak_jadi = $rusak_jadi_detail->jumlah_rusak_jadi;
        $tanggal_rusak_jadi = $rusak_jadi_detail->tanggal_rusak_jadi;

        $data = [
            'nama_barang_jadi' => $nama_barang_jadi,
            'jumlah_rusak_jadi' => $jumlah_rusak_jadi,
            'tanggal_rusak_jadi' => $tanggal_rusak_jadi,
        ];

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Perbaikan Barang Rusak';
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_jadi');
            $this->load->view('templates/pengguna/sidebar_jadi');
            $this->load->view('barang_jadi/view_perbaikan_barang_rusak', $data);
            $this->load->view('templates/pengguna/footer_jadi');
        } else {
            // Ambil elemen pertama dari array result
            $rusak_jadi_detail = $data_barang_rusak[0];
            $jumlah_rusak_jadi = $rusak_jadi_detail->jumlah_rusak_jadi;

            $jumlah_perbaikan = $this->input->post('jumlah_perbaikan');
            $jumlah_rusak_akhir = $jumlah_rusak_jadi - $jumlah_perbaikan;

            if ($jumlah_perbaikan > $jumlah_rusak_jadi) {
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>Maaf,</strong> jumlah yang di inputkan terlalu besar dari stok yang ada
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                          </div>'
                );
                redirect('barang_jadi/barang_rusak');
            }

            $data = [
                'jumlah_perbaikan' => $jumlah_perbaikan,
                'jumlah_rusak_akhir' => $jumlah_rusak_akhir,
                'status_perbaikan' => 1
            ];


            $this->Model_barang_jadi->update_barang_perbaikan('rusak_jadi', $data, $id_rusak_jadi);
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> barang perbaikan berhasil ditambahkan
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('barang_jadi/barang_rusak');
        }
    }
}
