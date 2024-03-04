<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemesanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_pemesanan');
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
        if ($level_pengguna != 'Admin' && $upk_bagian != 'pasar') {
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

        if (!empty($tanggal)) {
            $this->session->set_userdata('tanggal', $tanggal); // Simpan tanggal ke session jika diperlukan
        }
        $data['tanggal_hari_ini'] = $this->input->get('tanggal');
        $data['title'] = 'Daftar Pemesanan Barang';
        // $data['pesan'] = $this->Model_pemesanan->get_all($bulan, $tahun);
        $data['pesan'] = $this->Model_pemesanan->get_all($tanggal);
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('pemasaran/view_pemesanan', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_pasar');
            $this->load->view('templates/pengguna/sidebar_pasar');
            $this->load->view('pemasaran/view_pemesanan', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    public function upload()
    {
        $tanggal = $this->session->userdata('tanggal');
        // $this->form_validation->set_rules('id_jenis_barang', 'Nama Barang', 'required|trim');
        // $this->form_validation->set_rules('jumlah_pesan', 'Jumlah Pesan', 'required|trim|numeric');
        $this->form_validation->set_rules('id_pelanggan', 'Nama Pelanggan', 'required|trim');
        $this->form_validation->set_rules('tanggal_pesan', 'Tanggal Pesan', 'required|trim');
        $this->form_validation->set_rules('jenis_pesanan', 'Jenis Pesanan', 'required|trim');
        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('numeric', '%s harus berupa angka');


        if ($this->form_validation->run() == false) {
            $data['title'] = 'Transaksi Pemesanan Barang';
            $data['nama_barang'] = $this->Model_pemesanan->get_produk();
            $data['pelanggan'] = $this->Model_pemesanan->get_pelanggan();

            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_pasar');
            $this->load->view('templates/pengguna/sidebar_pasar');
            $this->load->view('pemasaran/view_tambah_pemesanan', $data);
            $this->load->view('templates/pengguna/footer');
        } else {
            $jenis_barang = $this->input->post('id_jenis_barang');
            $id_pelanggan = $this->input->post('id_pelanggan');
            $id_mobil = null;
            $tanggal_pesan = $this->input->post('tanggal_pesan');
            $jenis_pesanan = $this->input->post('jenis_pesanan');
            $jumlah_pesan = $this->input->post('jumlah_pesan');
            $input_pesan = $this->session->userdata('nama_lengkap');

            $data_pesanan = array();
            $total_harga = 0;

            foreach ($jenis_barang as $id_jenis_barang) {
                $jumlah = $jumlah_pesan[$id_jenis_barang];

                // Ambil harga dari jenis barang yang dipilih
                $tarif = $this->Model_pemesanan->getTarifByIdPelanggan($id_pelanggan);
                $harga_barang = $this->Model_pemesanan->getHargaByJenisBarang($id_jenis_barang, $tarif);
                $harga = $harga_barang->harga;

                // Hitung total harga per barang
                $total_harga_barang = $harga * $jumlah;

                $data_pesanan[] = array(
                    'id_jenis_barang' => $id_jenis_barang,
                    'jumlah_pesan' => $jumlah,
                    'tanggal_pesan' => $tanggal_pesan,
                    'id_pelanggan' => $id_pelanggan,
                    'id_mobil' => null,
                    'jenis_pesanan' => $jenis_pesanan,
                    'input_pesan' => $input_pesan,
                    'harga_barang' => $harga,
                    'total_harga' => $total_harga_barang
                );
            }

            $this->Model_pemesanan->upload('pemesanan', $data_pesanan);
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Pesanan baru berhasil di tambah
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            $alamat = 'pemasaran/pemesanan?tanggal=' . $tanggal;
            redirect($alamat);
            // redirect('pemasaran/pemesanan');
        }
    }

    public function upload_admin()
    {
        $tanggal = $this->session->userdata('tanggal');
        $this->form_validation->set_rules('id_pelanggan', 'Nama Pelanggan', 'required|trim');
        $this->form_validation->set_rules('tanggal_pesan', 'Tanggal Pesan', 'required|trim');
        $this->form_validation->set_rules('jenis_pesanan', 'Jenis Pesanan', 'required|trim');
        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('numeric', '%s harus berupa angka');


        if ($this->form_validation->run() == false) {
            $data['title'] = 'Transaksi Pemesanan Barang';
            $data['nama_barang'] = $this->Model_pemesanan->get_produk();
            $data['pelanggan'] = $this->Model_pemesanan->get_pelanggan();

            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_pasar');
            $this->load->view('templates/pengguna/sidebar_pasar');
            $this->load->view('pemasaran/view_tambah_pemesanan', $data);
            $this->load->view('templates/pengguna/footer');
        } else {
            $jenis_barang = $this->input->post('id_jenis_barang');
            $id_pelanggan = $this->input->post('id_pelanggan');
            $id_mobil = 1;
            $tanggal_pesan = $this->input->post('tanggal_pesan');
            $jenis_pesanan = $this->input->post('jenis_pesanan');
            $jumlah_pesan = $this->input->post('jumlah_pesan');
            $input_pesan = $this->session->userdata('nama_lengkap');

            $data_pesanan = array();
            $total_harga = 0;

            foreach ($jenis_barang as $id_jenis_barang) {
                $jumlah = $jumlah_pesan[$id_jenis_barang];

                // Ambil harga dari jenis barang yang dipilih
                $tarif = $this->Model_pemesanan->getTarifByIdPelanggan($id_pelanggan);
                $harga_barang = $this->Model_pemesanan->getHargaByJenisBarang($id_jenis_barang, $tarif);
                $harga = $harga_barang->harga;

                // Hitung total harga per barang
                $total_harga_barang = $harga * $jumlah;

                $data_pesanan[] = array(
                    'id_jenis_barang' => $id_jenis_barang,
                    'jumlah_pesan' => $jumlah,
                    'tanggal_pesan' => $tanggal_pesan,
                    'id_pelanggan' => $id_pelanggan,
                    'id_mobil' => $id_mobil,
                    'jenis_pesanan' => $jenis_pesanan,
                    'input_pesan' => $input_pesan,
                    'harga_barang' => $harga,
                    'total_harga' => $total_harga_barang
                );
            }

            $this->Model_pemesanan->upload('pemesanan', $data_pesanan);
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data Pesanan baru berhasil di tambah
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            $alamat = 'pemasaran/pemesanan?tanggal=' . $tanggal;
            redirect($alamat);
            // redirect('pemasaran/pemesanan');
        }
    }


    public function pilih_mobil($id_pemesanan)
    {
        $tanggal = $this->session->userdata('tanggal');
        $this->form_validation->set_rules('id_mobil', 'Nama Mobil', 'required|trim');
        $this->form_validation->set_message('required', '%s masih kosong');

        if ($this->form_validation->run() == false) {
            // $data['mobil'] = $this->Model_pemesanan->get_id_masuk_baku($id_pemesanan);
            $data['mobil'] = $this->Model_pemesanan->get_mobil();
            $data['title'] = 'Form Pilih Mobil';
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_pasar');
            $this->load->view('templates/pengguna/sidebar_pasar');
            $this->load->view('pemasaran/view_pilih_mobil', $data);
            $this->load->view('templates/pengguna/footer');
        } else {

            $data['id_mobil'] = $this->input->post('id_mobil');
            $this->Model_pemesanan->update('pemesanan', $data, $id_pemesanan);


            // Dapatkan data untuk penyimpanan ke tabel keluar_jadi
            $data_pemesanan = $this->Model_pemesanan->get_id_pemesanan($id_pemesanan);
            $data_keluar_jadi = array(
                'id_jenis_barang' => $data_pemesanan->id_jenis_barang,
                'id_mobil' => $data_pemesanan->id_mobil,
                'jumlah_keluar' => $data_pemesanan->jumlah_pesan,
                'tanggal_keluar' => $data_pemesanan->tanggal_pesan,
                'jumlah_akhir' => $data_pemesanan->jumlah_pesan,
                'jenis_pesanan' => $data_pemesanan->jenis_pesanan,
                'input_status_keluar' => $this->session->userdata('nama_lengkap')
            );

            // insert data ke dalam tabel keluar_jadi
            $this->Model_pemesanan->insert_keluar_jadi('keluar_jadi', $data_keluar_jadi);

            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> data Mobil berhasil di tambah
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            $alamat = 'pemasaran/pemesanan?tanggal=' . $tanggal;
            redirect($alamat);
            // redirect('pemasaran/pemesanan');
        }
    }


    public function upload_nota($id_pemesanan)
    {
        $data['upload_nota'] = $this->Model_pemesanan->get_id_pemesanan($id_pemesanan);
        $data['title'] = 'Form Upload Nota Pembelian';
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar_pasar');
        $this->load->view('templates/pengguna/sidebar_pasar');
        $this->load->view('pemasaran/view_tambah_nota', $data);
        $this->load->view('templates/pengguna/footer');
    }


    public function update_nota()
    {
        $tanggal = $this->session->userdata('tanggal');
        date_default_timezone_set('Asia/Jakarta');
        if (!empty($_FILES['nota_beli']['name'])) {

            // Lakukan proses upload file
            $config['upload_path']   = './uploads/pasar/nota/';
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['max_size']      = 1000;
            $config['overwrite']     = true; // Mengizinkan penggantian file yang ada dengan nama yang sama

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('nota_beli')) {
                $data_upload = $this->upload->data();
                $data['nota_beli'] = $data_upload['file_name'];
                $data['id_pemesanan'] = $this->input->post('id_pemesanan');
                $data['id_pelanggan'] = $this->input->post('id_pelanggan');
                $data['tanggal_pesan'] = $this->input->post('tanggal_pesan');
            } else {
                // Jika proses upload gagal
                $error_msg = $this->upload->display_errors();
                $this->session->set_flashdata('info', $error_msg);
                redirect('pemasaran/pemesanan');
            }

            // Isi data selain file yang diupload
            $data['input_update'] = $this->session->userdata('nama_lengkap');
            // $data['tanggal_update'] = date('Y-m-d H:i:s'); 
            $data['tanggal_update'] = $this->input->post('tanggal_update');
            $data['status_nota'] = 1;
            $data['status_pesan'] = 1;

            // Simpan data ke dalam database
            $this->Model_pemesanan->update_nota($data);
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>Sukses,</strong> Nota Pembelian berhasil di upload
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            $alamat = 'pemasaran/pemesanan?tanggal=' . $tanggal;
            redirect($alamat);
            // redirect('pemasaran/pemesanan');
        } else {
            // Tampilkan pesan kesalahan jika tidak ada file yang diunggah
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal,</strong> Silakan masukkan bukti nota pembayaran
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            $alamat = 'pemasaran/pemesanan?tanggal=' . $tanggal;
            redirect($alamat);
            // redirect('pemasaran/pemesanan');
        }
    }


    public function detail($id_pemesanan)
    {
        $data['detail_pemesanan'] = $this->Model_pemesanan->get_detail_pemesanan($id_pemesanan);
        $data['title'] = 'Detail Pemesanan Barang';
        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar_pasar');
        $this->load->view('templates/pengguna/sidebar_pasar');
        $this->load->view('pemasaran/view_detail_pemesanan', $data);
        $this->load->view('templates/pengguna/footer');
    }

    public function daftar_kiriman()
    {
        $tanggal = $this->input->get('tanggal');
        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
        }

        $this->session->set_userdata('tanggal_exportpdf', $tanggal);
        $data['tanggal_hari_ini'] = $this->input->get('tanggal');
        $data['daftar_kiriman'] = $this->Model_pemesanan->get_daftar_kiriman($tanggal);
        $data['total_pesanan'] = $this->Model_pemesanan->get_all_pesanan($tanggal);
        $data['title'] = 'Daftar Pengiriman Barang';

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('pemasaran/view_daftar_pengiriman', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_pasar');
            $this->load->view('templates/pengguna/sidebar_pasar');
            $this->load->view('pemasaran/view_daftar_pengiriman', $data);
            $this->load->view('templates/pengguna/footer');
        }
    }

    // awal penjualan rutin karyawan
    // public function barang_karyawan()
    // {
    //     $tanggal = $this->input->get('tanggal');
    //     $bulan = substr($tanggal, 5, 2);
    //     $tahun = substr($tanggal, 0, 4);

    //     if (empty($tanggal)) {
    //         $tanggal = date('Y-m-d');
    //         $bulan = date('m');
    //         $tahun = date('Y');
    //     }
    //     $data['bulan_lap'] = $bulan;
    //     $data['tahun_lap'] = $tahun;

    //     if (!empty($tanggal)) {
    //         $this->session->set_userdata('tanggal', $tanggal); // Simpan tanggal ke session jika diperlukan
    //     }

    //     $data['title'] = 'Daftar Penjualan Rutin Karyawan';
    //     $data['pesan'] = $this->Model_pemesanan->get_all_pegawai($bulan, $tahun);
    //     $this->load->view('templates/pengguna/header', $data);
    //     $this->load->view('templates/pengguna/navbar_pasar');
    //     $this->load->view('templates/pengguna/sidebar_pasar');
    //     $this->load->view('pemasaran/view_barang_karyawan', $data);
    //     $this->load->view('templates/pengguna/footer');
    // }

    // public function input_barang_karyawan()
    // {
    //     $this->form_validation->set_rules('id_jenis_barang', 'Nama Barang', 'required|trim');
    //     $this->form_validation->set_rules('id_pelanggan', 'Nama Pelanggan', 'required|trim');
    //     // $this->form_validation->set_rules('id_mobil', 'Nama Mobil', 'required|trim');
    //     $this->form_validation->set_rules('tanggal_pesan', 'Tanggal Pesan', 'required|trim');
    //     $this->form_validation->set_rules('jenis_pesanan', 'Jenis Pesanan', 'required|trim');
    //     $this->form_validation->set_rules('jumlah_pesan', 'Jumlah Pesan', 'required|trim|numeric');
    //     $this->form_validation->set_message('required', '%s masih kosong');
    //     $this->form_validation->set_message('numeric', '%s harus berupa angka');


    //     if ($this->form_validation->run() == false) {
    //         $data['title'] = 'Transaksi Pemesanan Barang';
    //         $data['nama_barang'] = $this->Model_pemesanan->get_produk();
    //         $data['pegawai'] = $this->Model_pemesanan->get_pegawai();

    //         $this->load->view('templates/pengguna/header', $data);
    //         $this->load->view('templates/pengguna/navbar_pasar');
    //         $this->load->view('templates/pengguna/sidebar_pasar');
    //         $this->load->view('pemasaran/view_tambah_pemesanan_karyawan', $data);
    //         $this->load->view('templates/pengguna/footer');
    //     } else {
    //         $data['id_jenis_barang'] = $this->input->post('id_jenis_barang');
    //         $data['id_pelanggan'] = $this->input->post('id_pelanggan');
    //         $data['id_mobil'] = null;
    //         $data['tanggal_pesan'] = $this->input->post('tanggal_pesan');
    //         $data['jenis_pesanan'] = $this->input->post('jenis_pesanan');
    //         $data['jumlah_pesan'] = $this->input->post('jumlah_pesan');
    //         $data['input_pesan'] = $this->session->userdata('nama_lengkap');

    //         $tarif = $this->Model_pemesanan->getTarifByIdPegawai($data['id_pelanggan']);

    //         // Ambil harga dari jenis barang yang dipilih
    //         $harga_barang = $this->Model_pemesanan->getHargaByJenisBarang_pegawai($data['id_jenis_barang'], $tarif);
    //         $harga = $harga_barang->harga;

    //         // Hitung total harga
    //         $data['harga_barang'] = $harga;
    //         $data['total_harga'] = $harga * $data['jumlah_pesan'];

    //         $this->Model_pemesanan->upload('pemesanan_karyawan', $data);
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    //                     <strong>Sukses,</strong> Data Pesanan baru berhasil di tambah
    //                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                     </button>
    //                   </div>'
    //         );
    //         redirect('pemasaran/pemesanan/barang_karyawan');
    //     }
    // }

    // public function pilih_mobil_karyawan($id_pemesanan)
    // {
    //     $this->form_validation->set_rules('id_mobil', 'Nama Mobil', 'required|trim');
    //     $this->form_validation->set_message('required', '%s masih kosong');

    //     if ($this->form_validation->run() == false) {
    //         // $data['mobil'] = $this->Model_pemesanan->get_id_masuk_baku($id_pemesanan);
    //         $data['mobil'] = $this->Model_pemesanan->get_mobil();
    //         $data['title'] = 'Form Pilih Mobil';
    //         $this->load->view('templates/pengguna/header', $data);
    //         $this->load->view('templates/pengguna/navbar_pasar');
    //         $this->load->view('templates/pengguna/sidebar_pasar');
    //         $this->load->view('pemasaran/view_pilih_mobil', $data);
    //         $this->load->view('templates/pengguna/footer');
    //     } else {

    //         $data['id_mobil'] = $this->input->post('id_mobil');
    //         $this->Model_pemesanan->update('pemesanan_karyawan', $data, $id_pemesanan);

    //         // Dapatkan data untuk penyisipan ke tabel keluar_jadi
    //         $data_pemesanan = $this->Model_pemesanan->get_id_masuk_baku_karyawan($id_pemesanan);
    //         $data_keluar_jadi = array(
    //             'id_jenis_barang' => $data_pemesanan->id_jenis_barang,
    //             'id_mobil' => $data_pemesanan->id_mobil,
    //             'jumlah_keluar' => $data_pemesanan->jumlah_pesan,
    //             'tanggal_keluar' => $data_pemesanan->tanggal_pesan,
    //             'jumlah_akhir' => $data_pemesanan->jumlah_pesan,
    //             'jenis_pesanan' => $data_pemesanan->jenis_pesanan,
    //             'input_status_keluar' => $this->session->userdata('nama_lengkap')
    //         );

    //         // Sisipkan data ke dalam tabel keluar_jadi
    //         $this->Model_pemesanan->insert_keluar_jadi('keluar_jadi', $data_keluar_jadi);


    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    //                     <strong>Sukses,</strong> data Mobil berhasil di tambah
    //                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                     </button>
    //                   </div>'
    //         );
    //         redirect('pemasaran/pemesanan/barang_karyawan');
    //     }
    // }
    // public function detail_karyawan($id_pemesanan)
    // {
    //     $data['detail_pemesanan'] = $this->Model_pemesanan->get_detail_pemesanan_karyawan($id_pemesanan);
    //     $data['title'] = 'Detail Pemesanan Barang';
    //     $this->load->view('templates/pengguna/header', $data);
    //     $this->load->view('templates/pengguna/navbar_pasar');
    //     $this->load->view('templates/pengguna/sidebar_pasar');
    //     $this->load->view('pemasaran/view_detail_pemesanan_karyawan', $data);
    //     $this->load->view('templates/pengguna/footer');
    // }
}
