<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permintaan_barang_baku extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_barang_produksi');
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
        if ($level_pengguna != 'Admin' && $upk_bagian != 'produksi') {
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

        $data['title'] = 'Permintaan Barang Baku';
        $data['barang_baku'] = $this->Model_barang_produksi->getbarang_baku($bulan, $tahun);
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('barang_produksi/view_permintaan_baku', $data);
            $this->load->view('templates/pengguna/footer_produksi');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_produksi', $data);
            $this->load->view('templates/pengguna/sidebar_produksi');
            $this->load->view('barang_produksi/view_permintaan_baku', $data);
            $this->load->view('templates/pengguna/footer_produksi');
        }
    }

    public function upload()
    {
        // $this->form_validation->set_rules('jumlah_keluar', 'Jumlah Keluar', 'required|trim|numeric|greater_than[0]');
        $this->form_validation->set_rules('no_nota', 'NO Nota', 'required|trim');
        $this->form_validation->set_rules('tanggal_keluar', 'Tanggal Keluar', 'required|trim');
        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('numeric', '%s harus berupa angka');
        $this->form_validation->set_message('greater_than', '%s harus lebih besar dari 0');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Transaksi Barang Baku';
            $data['nama_barang'] = $this->Model_barang_produksi->get_nama_barang_baku();

            if ($this->session->userdata('level') == 'Admin') {
                $this->load->view('templates/header', $data);
                $this->load->view('templates/navbar');
                $this->load->view('templates/sidebar');
                $this->load->view('barang_produksi/view_tambah_barang_baku', $data);
                $this->load->view('templates/pengguna/footer_produksi');
            } else {
                $this->load->view('templates/pengguna/header', $data);
                $this->load->view('templates/pengguna/navbar_produksi');
                $this->load->view('templates/pengguna/sidebar_produksi');
                $this->load->view('barang_produksi/view_tambah_barang_baku', $data);
                $this->load->view('templates/pengguna/footer_produksi');
            }
        } else {
            // Cek apakah ada file yang diupload
            if (!empty($_FILES['bukti_keluar_gd']['name'])) {
                // Mendapatkan tanggal dari input form
                $tanggal_keluar = $this->input->post('tanggal_keluar', true);
                $id_barang_baku = $this->input->post('id_barang_baku', true);
                $jumlah_keluar = $this->input->post('jumlah_keluar', true);
                $no_nota = $this->input->post('no_nota', true);


                $dataToInsert = array();
                foreach ($id_barang_baku as $barang_baku) {
                    $jumlah = $jumlah_keluar[$barang_baku];


                    // Membuat kode barang
                    $kode = $this->db->get_where('barang_baku', ['id_barang_baku' => $barang_baku])->row();

                    if ($kode) {
                        // Membuat format tanggal dalam bentuk YYYYmmdd
                        $formatted_tanggal = date('ymd', strtotime($tanggal_keluar));

                        // Mengambil nomor urut terakhir berdasarkan tanggal dan id_barang_baku
                        $this->db->select('MAX(CAST(SUBSTRING_INDEX(kode_barang, "-", -1) AS SIGNED)) as max_urut', false);
                        $this->db->from('keluar_baku');
                        $this->db->where('tanggal_keluar', date('Y-m-d', strtotime($tanggal_keluar)));
                        $this->db->where('id_barang_baku', $barang_baku);
                        $result = $this->db->get()->row();

                        // Jika tidak ada data, kembalikan nomor urut pertama
                        $nomor_urut = $result->max_urut ? $result->max_urut + 1 : 1;

                        // Menggabungkan kode barang dengan nomor urut
                        $kode_barang = strtoupper($kode->kode_barang) . '-' . $formatted_tanggal . '-' . sprintf('%02d', $nomor_urut);
                        $data = array(
                            'id_barang_baku' => $barang_baku,
                            'tanggal_keluar' => $tanggal_keluar,
                            'jumlah_keluar' => $jumlah,
                            'no_nota' => $no_nota,
                            'input_status_keluar' => $this->session->userdata('nama_lengkap'),
                            'bagian' => $this->session->userdata('upk_bagian'),
                            'kode_barang' => $kode_barang
                        );
                        $dataToInsert[] = $data;
                    } else {
                        $kode_barang = null;
                    }
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
                    foreach ($dataToInsert as $data) {

                        $data['bukti_keluar_gd'] = $file_name; // Simpan nama file dalam database

                        // Simpan data ke dalam database
                        $this->db->insert('keluar_baku', $data);
                    }

                    $this->session->set_flashdata(
                        'info',
                        '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>Sukses,</strong> Permintaan barang baku berhasil di simpan
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>'
                    );
                    redirect('barang_produksi/permintaan_barang_baku');
                } else {
                    // Jika proses upload gagal
                    $error_msg = $this->upload->display_errors();
                    $this->session->set_flashdata('info', $error_msg);
                    redirect('barang_produksi/permintaan_barang_baku');
                }
            } else {
                // Tampilkan pesan kesalahan jika tidak ada file yang diunggah
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Gagal,</strong> Silakan masukkan file foto pendukung
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>'
                );
                redirect('barang_produksi/permintaan_barang_baku');
            }
        }
    }

    // public function upload()
    // {
    //     $this->form_validation->set_rules('id_barang_baku', 'Nama Barang', 'required|trim');
    //     $this->form_validation->set_rules('jumlah_keluar', 'Jumlah Keluar', 'required|trim|numeric|greater_than[0]');
    //     $this->form_validation->set_rules('tanggal_keluar', 'Tanggal Keluar', 'required|trim');
    //     $this->form_validation->set_message('required', '%s masih kosong');
    //     $this->form_validation->set_message('numeric', '%s harus berupa angka');
    //     $this->form_validation->set_message('greater_than', '%s harus lebih besar dari 0');

    //     if ($this->form_validation->run() == false) {
    //         $data['title'] = 'Transaksi Barang Baku';
    //         $data['nama_barang'] = $this->Model_barang_produksi->get_nama_barang_baku();
    //         $this->load->view('templates/pengguna/header', $data);
    //         $this->load->view('templates/pengguna/navbar_produksi');
    //         $this->load->view('templates/pengguna/sidebar_produksi');
    //         $this->load->view('barang_produksi/view_tambah_barang_baku', $data);
    //         $this->load->view('templates/pengguna/footer_produksi');
    //     } else {
    //         // Cek apakah ada file yang diupload
    //         if (!empty($_FILES['bukti_keluar_gd']['name'])) {
    //             // Mendapatkan tanggal dari input form
    //             $tanggal_keluar = $this->input->post('tanggal_keluar', true);
    //             $id_barang_baku = $this->input->post('id_barang_baku', true);

    //             // Membuat kode barang
    //             $kode = $this->db->get_where('barang_baku', ['id_barang_baku' => $id_barang_baku])->row();

    //             if ($kode) {
    //                 // Membuat format tanggal dalam bentuk YYYYmmdd
    //                 $formatted_tanggal = date('ymd', strtotime($tanggal_keluar));
    //                 $tanggal_query = date('Y-m-d', strtotime($tanggal_keluar));

    //                 // Mengambil nomor urut terakhir berdasarkan tanggal dan id_barang_baku
    //                 $this->db->select('MAX(CAST(SUBSTRING_INDEX(kode_barang, "-", -1) AS SIGNED)) as max_urut', false);
    //                 $this->db->from('keluar_baku');
    //                 $this->db->where('tanggal_keluar', date('Y-m-d', strtotime($tanggal_keluar)));
    //                 $this->db->where('id_barang_baku', $id_barang_baku);
    //                 $result = $this->db->get()->row();

    //                 // Jika tidak ada data, kembalikan nomor urut pertama
    //                 $nomor_urut = $result->max_urut ? $result->max_urut + 1 : 1;

    //                 // Menggabungkan kode barang dengan nomor urut
    //                 $kode_barang = strtoupper($kode->kode_barang) . '-' . $formatted_tanggal . '-' . sprintf('%02d', $nomor_urut);
    //             } else {
    //                 $kode_barang = null;
    //             }

    //             // Membuat nama file sesuai dengan tanggal
    //             $file_name = date('Y-m-d', strtotime($tanggal_keluar)) . '.jpg';

    //             // Menyimpan file dengan nama yang sesuai
    //             $config['upload_path']   = './uploads/baku/keluar/';
    //             $config['allowed_types'] = 'jpg|jpeg|png|pdf';
    //             $config['max_size']      = 1000;
    //             $config['file_name']     = $file_name;
    //             $config['overwrite']     = true; // Mengizinkan penggantian file yang ada dengan nama yang sama

    //             $this->load->library('upload', $config);
    //             if ($this->upload->do_upload('bukti_keluar_gd')) {
    //                 // Isi data selain file yang diupload
    //                 $data['id_barang_baku'] = (int) $this->input->post('id_barang_baku', true);
    //                 $data['jumlah_keluar'] = $this->input->post('jumlah_keluar', true);
    //                 $data['tanggal_keluar'] = $this->input->post('tanggal_keluar', true);
    //                 $data['input_status_keluar'] = $this->session->userdata('nama_lengkap');
    //                 $data['bagian'] = $this->session->userdata('upk_bagian');
    //                 $data['bukti_keluar_gd'] = $file_name; // Simpan nama file dalam database
    //                 $data['kode_barang'] = $kode_barang;
    //                 // Simpan data ke dalam database
    //                 // $this->db->insert('baku_produksi', $data);
    //                 $this->db->insert('keluar_baku', $data);

    //                 $this->session->set_flashdata(
    //                     'info',
    //                     '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    //                         <strong>Sukses,</strong> Permintaan barang baku berhasil di simpan
    //                         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                         </button>
    //                     </div>'
    //                 );
    //                 redirect('barang_produksi/permintaan_barang_baku');
    //             } else {
    //                 // Jika proses upload gagal
    //                 $error_msg = $this->upload->display_errors();
    //                 $this->session->set_flashdata('info', $error_msg);
    //                 redirect('barang_produksi/permintaan_barang_baku');
    //             }
    //         } else {
    //             // Tampilkan pesan kesalahan jika tidak ada file yang diunggah
    //             $this->session->set_flashdata(
    //                 'info',
    //                 '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //                     <strong>Gagal,</strong> Silakan masukkan file foto pendukung
    //                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                     </button>
    //                 </div>'
    //             );
    //             redirect('barang_produksi/permintaan_barang_baku');
    //         }
    //     }
    // }


    public function tolak_pesanan()
    {
        $id_keluar_baku = $this->input->post('id_keluar_baku');
        $data = [
            'status_keluar' => 1,
            'status_tolak' => 0,
            'status_produksi' => 0
        ];
        $tolak_pesanan = $this->Model_barang_produksi->tolak_pesanan($id_keluar_baku, $data);

        if ($tolak_pesanan) {
            $response = array('status' => true, 'pesan' => 'Data ditolak');
        } else {
            $response = array('status' => false, 'pesan' => 'Data diterima');
        }

        echo json_encode($response);
    }

    public function cek_status_produksi()
    {
        $this->db->select('*');
        $this->db->from('keluar_baku');
        $this->db->where('status_produksi', 0);
        $this->db->where('bagian', 'produksi');
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
        $this->db->where('bagian', 'produksi');
        $this->db->update('keluar_baku', $data);
        redirect('barang_produksi/permintaan_barang_baku');
    }
}
