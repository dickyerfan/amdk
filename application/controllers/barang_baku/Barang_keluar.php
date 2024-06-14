<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_keluar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_barang_baku');

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
        if ($level_pengguna != 'Admin' && $upk_bagian != 'baku') {
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
        $this->session->set_userdata('tanggal_keluar', $tanggal);
        $data['bulan_lap'] = $bulan;
        $data['tahun_lap'] = $tahun;

        $data['title'] = 'Transaksi Barang Keluar';
        $data['barang_keluar'] = $this->Model_barang_baku->get_barang_keluar($bulan, $tahun);
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_baku/view_barang_keluar', $data);
            $this->load->view('templates/pengguna/footer_baku');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_baku');
            $this->load->view('templates/pengguna/sidebar_baku');
            $this->load->view('barang_baku/view_barang_keluar', $data);
            $this->load->view('templates/pengguna/footer_baku');
        }
    }

    // function get_permintaan_barang()
    // {
    //     $tanggal = $this->session->userdata('tanggal_keluar');

    //     $bulan = substr($tanggal, 5, 2);
    //     $tahun = substr($tanggal, 0, 4);

    //     if (empty($tanggal)) {
    //         $tanggal = date('Y-m-d');
    //         $bulan = date('m');
    //         $tahun = date('Y');
    //     }
    //     $data = $this->Model_barang_baku->get_permintaan_barang($bulan, $tahun);
    //     echo json_encode($data);
    // }

    // public function update_status_keluar()
    // {
    //     $id_keluar_baku = $this->input->post('id_keluar_baku');

    //     // Lakukan pembaruan status_keluar ke 1 di tabel keluar_baku
    //     $data_keluar = [
    //         'status_keluar' => 1,
    //         'status_produksi' => 0
    //     ];
    //     $this->db->where('id_keluar_baku', $id_keluar_baku);
    //     $result_keluar = $this->db->update('keluar_baku', $data_keluar);

    //     // Jika pembaruan tabel keluar_baku berhasil
    //     if ($result_keluar) {
    //         // Jika bagian adalah barang jadi, tambahkan data ke tabel barang_baku_jadi
    //         $this->db->where('id_keluar_baku', $id_keluar_baku);
    //         $query_keluar = $this->db->get('keluar_baku');
    //         $data_keluar_baku = $query_keluar->row_array();
    //         if ($data_keluar_baku['bagian'] === 'jadi') {

    //             $data_baku_jadi = [
    //                 'id_barang_baku' => $data_keluar_baku['id_barang_baku'],
    //                 'jumlah_masuk' => $data_keluar_baku['jumlah_keluar'],
    //                 'jumlah_akhir' => $data_keluar_baku['jumlah_keluar'],
    //                 'tanggal_order' => $data_keluar_baku['tanggal_keluar'],
    //                 'status_baku_jadi' => $data_keluar_baku['status_keluar'],
    //                 'input_status_baku_jadi' => $data_keluar_baku['input_status_keluar'],
    //                 'kode_barang' => $data_keluar_baku['kode_barang']
    //             ];

    //             $result_baku_jadi = $this->db->insert('barang_baku_jadi', $data_baku_jadi);

    //             if ($result_baku_jadi) {
    //                 $response['success'] = true;
    //                 $response['inserted_data'] = $data_keluar_baku;
    //             } else {
    //                 $response['success'] = false;
    //                 $response['error'] = 'Gagal menambahkan data ke tabel barang_baku_jadi';
    //             }
    //         } else {
    //             $response['success'] = true;
    //             $response['message'] = 'Data tidak ditambahkan karena bukan bagian barang jadi';
    //         }
    //     } else {
    //         $response['success'] = false;
    //         $response['error'] = 'Gagal memperbarui status_keluar di tabel keluar_baku';
    //     }

    //     echo json_encode($response);
    // }

    public function update_status_keluar($tanggal_keluar, $bagian)
    {
        $data['detail_barang_keluar'] = $this->Model_barang_baku->get_detail_barang_keluar($tanggal_keluar, $bagian);
        $data['title'] = 'Update Pemesanan Barang Baku';
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_baku/view_update_keluar_barang_baku', $data);
            $this->load->view('templates/pengguna/footer_baku');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_baku');
            $this->load->view('templates/pengguna/sidebar_baku');
            $this->load->view('barang_baku/view_update_keluar_barang_baku', $data);
            $this->load->view('templates/pengguna/footer_baku');
        }
    }


    public function terima_barang($tanggal_keluar, $bagian)
    {
        date_default_timezone_set('Asia/Jakarta');
        if (!empty($_FILES['bukti_keluar_gd']['name'])) {

            // Fungsi untuk mendapatkan dan menyimpan nomor urut terakhir
            function getLastNumber($filename)
            {
                // Membaca nomor urut terakhir dari file
                $lastNumber = file_get_contents($filename);

                // Jika file kosong atau gagal dibaca, menggunakan nilai default
                if ($lastNumber === false || empty($lastNumber)) {
                    $lastNumber = 512;
                }

                return intval($lastNumber);
            }

            // Fungsi untuk menyimpan nomor urut terakhir
            function saveLastNumber($filename, $number)
            {
                // Menyimpan nomor urut terakhir ke file
                file_put_contents($filename, $number);
            }

            // Fungsi untuk membuat nomor nota
            function generateNotaNumber($kode_gudang, $tahun, &$no_urut)
            {
                $no_nota_ = $kode_gudang . '/' . $no_urut . '/' . $tahun;

                // Memperbarui nomor urut
                $no_urut++;

                return $no_nota_;
            }

            // Nama file untuk menyimpan nomor urut terakhir
            $filename = 'last_number.txt';

            // Nomor urut dimulai dari file atau nilai default
            $no_urut = getLastNumber($filename);

            // Prefix dan tahun yang diinginkan
            $kode_gudang = 'GD.01';
            $tahun = date('y', strtotime($tanggal_keluar));

            // Membuat nomor nota menggunakan fungsi
            $nota = generateNotaNumber($kode_gudang, $tahun, $no_urut);

            // Menyimpan nomor urut terakhir
            saveLastNumber($filename, $no_urut);

            // Membuat nama file sesuai dengan tanggal
            $file_name = date('Y-m-d', strtotime($tanggal_keluar)) . '_' . $bagian . '.jpg';
            // Lakukan proses upload file
            $config['upload_path']   = './uploads/baku/keluar/';
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['max_size']      = 1000;
            $config['file_name']     = $file_name;
            $config['overwrite']     = true; // Mengizinkan penggantian file yang ada dengan nama yang sama

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('bukti_keluar_gd')) {
                $data_upload = $this->upload->data();
                $data['bukti_keluar_gd'] = $file_name;
                $data['tanggal_keluar'] = $this->input->post('tanggal_keluar');
            } else {
                // Jika proses upload gagal
                $error_msg = $this->upload->display_errors();
                $this->session->set_flashdata('info', $error_msg);
                redirect('barang_baku/barang_keluar');
            }

            // Isi data selain file yang diupload
            $data['status_keluar'] = 1;
            $data['status_produksi'] = 0;
            $data['no_nota'] = $nota;

            // Simpan data ke dalam database
            $this->Model_barang_baku->update_Bukti_pemesanan($data, $tanggal_keluar, $bagian);

            // Jika bagian adalah barang jadi, tambahkan data ke tabel barang_baku_jadi_masuk

            $this->db->where('tanggal_keluar', $tanggal_keluar);
            $this->db->where('bagian', 'jadi');
            $query_keluar = $this->db->get('keluar_baku');
            $data_keluar_baku = $query_keluar->result_array();

            // foreach ($data_keluar_baku as $data_keluar) {
            //     if ($data_keluar['bagian'] === 'jadi') {
            //         // Cek apakah data sudah ada di tabel barang_baku_jadi_masuk
            //         $this->db->where('id_barang_baku', $data_keluar['id_barang_baku']);
            //         $this->db->where('tanggal_masuk', $data_keluar['tanggal_keluar']);
            //         $this->db->where('kode_barang', $data_keluar['kode_barang']);
            //         // $this->db->where('no_nota', $data_keluar['no_nota']);
            //         $query_baku_jadi = $this->db->get('barang_baku_jadi_masuk');

            //         if ($query_baku_jadi->num_rows() == 0) {
            //             // Proses masukkan ke tabel barang_baku_jadi_masuk
            //             $data_baku_jadi = [
            //                 'id_barang_baku' => $data_keluar['id_barang_baku'],
            //                 'jumlah_masuk' => $data_keluar['jumlah_keluar'],
            //                 'tanggal_masuk' => $data_keluar['tanggal_keluar'],
            //                 'status_masuk' => $data_keluar['status_keluar'],
            //                 'input_bbj_masuk' => $data_keluar['input_status_keluar'],
            //                 'kode_barang' => $data_keluar['kode_barang'],
            //                 'no_nota' => $data_keluar['no_nota']
            //             ];
            //             $this->db->insert('barang_baku_jadi_masuk', $data_baku_jadi);
            //         }
            //     }
            // }

            foreach ($data_keluar_baku as $data_keluar) {
                if ($data_keluar['bagian'] === 'jadi') {
                    $data_baku_jadi = [
                        'status_masuk' => 1,
                        'no_nota' => $data_keluar['no_nota']
                    ];
                    $this->db->where('kode_barang', $data_keluar['kode_barang']);
                    $this->db->where('input_bbj_masuk', $data_keluar['input_status_keluar']);
                    $this->db->update('barang_baku_jadi_masuk', $data_baku_jadi);
                }
            }

            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>Sukses,</strong> Bukti pemesanan berhasil di upload
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('barang_baku/barang_keluar');
        } else {
            // Tampilkan pesan kesalahan jika tidak ada file yang diunggah
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal,</strong> Silakan masukkan bukti pemesanan
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('barang_baku/barang_keluar');
        }
    }

    public function detail_status_keluar($tanggal_keluar, $bagian)
    {
        $data['detail_barang_keluar'] = $this->Model_barang_baku->get_detail_barang_keluar($tanggal_keluar, $bagian);
        $data['title'] = 'Detail Barang Baku';

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_baku/view_detail_keluar_barang_baku', $data);
            $this->load->view('templates/pengguna/footer_baku');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_baku');
            $this->load->view('templates/pengguna/sidebar_baku');
            $this->load->view('barang_baku/view_detail_keluar_barang_baku', $data);
            $this->load->view('templates/pengguna/footer_baku');
        }
    }

    public function update_status_keluar_tanggal_sama($tanggal_keluar, $bagian)
    {
        $data['detail_barang_keluar'] = $this->Model_barang_baku->get_detail_barang_keluar_tgl_sama($tanggal_keluar, $bagian);
        $data['title'] = 'Update Pemesanan Barang Baku Susulan';
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_baku/view_update_keluar_barang_baku_tgl_sama', $data);
            $this->load->view('templates/pengguna/footer_baku');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_baku');
            $this->load->view('templates/pengguna/sidebar_baku');
            $this->load->view('barang_baku/view_update_keluar_barang_baku_tgl_sama', $data);
            $this->load->view('templates/pengguna/footer_baku');
        }
    }

    public function terima_barang_tgl_sama($tanggal_keluar, $bagian)
    {
        date_default_timezone_set('Asia/Jakarta');
        if (!empty($_FILES['bukti_keluar_gd']['name'])) {

            // Fungsi untuk mendapatkan dan menyimpan nomor urut terakhir
            function getLastNumber($filename)
            {
                // Membaca nomor urut terakhir dari file
                $lastNumber = file_get_contents($filename);

                // Jika file kosong atau gagal dibaca, menggunakan nilai default
                if ($lastNumber === false || empty($lastNumber)) {
                    $lastNumber = 512;
                }

                return intval($lastNumber);
            }

            // Fungsi untuk menyimpan nomor urut terakhir
            function saveLastNumber($filename, $number)
            {
                // Menyimpan nomor urut terakhir ke file
                file_put_contents($filename, $number);
            }

            // Fungsi untuk membuat nomor nota
            function generateNotaNumber($kode_gudang, $tahun, &$no_urut)
            {
                $no_nota_ = $kode_gudang . '/' . $no_urut . '/' . $tahun;

                // Memperbarui nomor urut
                $no_urut++;

                return $no_nota_;
            }

            // Nama file untuk menyimpan nomor urut terakhir
            $filename = 'last_number.txt';

            // Nomor urut dimulai dari file atau nilai default
            $no_urut = getLastNumber($filename);

            // Prefix dan tahun yang diinginkan
            $kode_gudang = 'GD.01';
            $tahun = date('y', strtotime($tanggal_keluar));

            // Membuat nomor nota menggunakan fungsi
            $nota = generateNotaNumber($kode_gudang, $tahun, $no_urut);

            // Menyimpan nomor urut terakhir
            saveLastNumber($filename, $no_urut);

            // Membuat nama file sesuai dengan tanggal
            $file_name = date('Y-m-d', strtotime($tanggal_keluar)) . '_' . $bagian . '.jpg';
            // Lakukan proses upload file
            $config['upload_path']   = './uploads/baku/keluar/';
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['max_size']      = 1000;
            $config['file_name']     = $file_name;
            $config['overwrite']     = true; // Mengizinkan penggantian file yang ada dengan nama yang sama

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('bukti_keluar_gd')) {
                $data_upload = $this->upload->data();
                $data['bukti_keluar_gd'] = $file_name;
                // $data['tanggal_keluar'] = $this->input->post('tanggal_keluar');
            } else {
                // Jika proses upload gagal
                $error_msg = $this->upload->display_errors();
                $this->session->set_flashdata('info', $error_msg);
                redirect('barang_baku/barang_keluar');
            }

            // Isi data selain file yang diupload
            $data['status_keluar'] = 1;
            $data['status_produksi'] = 0;
            $data['no_nota'] = $nota;

            // Simpan data ke dalam database
            $this->Model_barang_baku->update_Bukti_pemesanan_tgl_sama($data, $tanggal_keluar, $bagian);

            // Jika bagian adalah barang jadi, tambahkan data ke tabel barang_baku_jadi

            $this->db->where('tanggal_keluar', $tanggal_keluar);
            $this->db->where('bagian', 'jadi');
            $query_keluar = $this->db->get('keluar_baku');
            $data_keluar_baku = $query_keluar->row_array();

            if (isset($data_keluar_baku['bagian']) && $data_keluar_baku['bagian'] === 'jadi') {
                $data_baku_jadi = [
                    'id_barang_baku' => $data_keluar_baku['id_barang_baku'],
                    'jumlah_masuk' => $data_keluar_baku['jumlah_keluar'],
                    'jumlah_akhir' => $data_keluar_baku['jumlah_keluar'],
                    'tanggal_order' => $data_keluar_baku['tanggal_keluar'],
                    'status_baku_jadi' => $data_keluar_baku['status_keluar'],
                    'input_status_baku_jadi' => $data_keluar_baku['input_status_keluar'],
                    'kode_barang' => $data_keluar_baku['kode_barang'],
                    'no_nota' => $data_keluar_baku['no_nota']
                ];

                $this->db->insert('barang_baku_jadi', $data_baku_jadi);
            }

            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>Sukses,</strong> Bukti pemesanan berhasil di upload
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('barang_baku/barang_keluar');
        } else {
            // Tampilkan pesan kesalahan jika tidak ada file yang diunggah
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal,</strong> Silakan masukkan bukti pemesanan
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('barang_baku/barang_keluar');
        }
    }

    public function cek_status_permintaan_barang()
    {
        $this->db->select('*');
        $this->db->from('keluar_baku');
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
