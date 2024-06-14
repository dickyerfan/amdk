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


        $data['title'] = 'Produksi Barang Jadi' . ' ' . $bulanTitle[$bulan] . ' ' . $tahun;
        $data['barang_jadi'] = $this->Model_barang_produksi->getbarang_jadi($bulan, $tahun);
        if ($this->session->userdata('level') == 'Admin') {
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

    // public function upload()
    // {
    //     // $this->form_validation->set_rules('id_jenis_barang', 'Jenis Barang Jadi', 'trim');
    //     // $this->form_validation->set_rules('jumlah_barang_jadi', 'Jumlah Barang Jadi', 'trim|numeric');
    //     $this->form_validation->set_rules('tanggal_barang_jadi', 'Hari ini', 'required|trim|is_unique[barang_jadi.tanggal_barang_jadi]');
    //     $this->form_validation->set_message('required', '%s masih kosong');
    //     $this->form_validation->set_message('numeric', '%s harus berupa angka');
    //     $this->form_validation->set_message('is_unique', '%s sudah dilakukan produksi barang jadi');

    //     if ($this->form_validation->run() == false) {
    //         $data['title'] = 'Produksi Barang Jadi';
    //         $data['jenis_barang'] = $this->Model_barang_produksi->get_jenis_barang();
    //         $this->load->view('templates/pengguna/header', $data);
    //         $this->load->view('templates/pengguna/navbar_produksi');
    //         $this->load->view('templates/pengguna/sidebar_produksi');
    //         $this->load->view('barang_produksi/view_tambah_barang_jadi', $data);
    //         $this->load->view('templates/pengguna/footer_produksi');
    //     } else {
    //         $tanggal_barang_jadi = $this->input->post('tanggal_barang_jadi');
    //         $jumlah_barang_jadi = $this->input->post('jumlah_barang_jadi');
    //         $jenis_barang = $this->input->post('id_jenis_barang');

    //         // Loop melalui jenis barang yang dipilih
    //         foreach ($jenis_barang as $id_jenis_barang) {
    //             $jumlah = $jumlah_barang_jadi[$id_jenis_barang];
    //             $data = array(
    //                 'id_jenis_barang' => $id_jenis_barang,
    //                 'jumlah_barang_jadi' => $jumlah,
    //                 'tanggal_barang_jadi' => $tanggal_barang_jadi,
    //                 'input_status_barang_jadi' => $this->session->userdata('nama_lengkap')
    //             );

    //             $stok_barang_baku_produksi = $this->Model_barang_produksi->get_barangbaku_produksi();
    //             $stok_akhir = 0;
    //             $stok_akhir_negatif = false;

    //             foreach ($stok_barang_baku_produksi as $stok) {
    //                 $jumlah_stok_awal = $stok->jumlah_stok_awal;
    //                 $jumlah_masuk = $stok->jumlah_masuk;
    //                 $jumlah_keluar = $stok->jumlah_keluar;
    //                 $jumlah_rusak = $stok->jumlah_rusak;

    //                 // Hitung stok_akhir untuk jenis barang ini
    //                 $stok_akhir_jenis = $jumlah_stok_awal + $jumlah_masuk - $jumlah_keluar - $jumlah_rusak;

    //                 // Tambahkan stok_akhir jenis ini ke total stok_akhir
    //                 $stok_akhir += $stok_akhir_jenis;
    //                 if ($stok_akhir_jenis < 0) {
    //                     $stok_akhir_negatif = true;
    //                     $this->session->set_flashdata(
    //                         'info',
    //                         '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //                                         <strong>Maaf,</strong> Stok Barang Baku ada yang kosong harap bon ke bagian barang baku
    //                                         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                                         </button>
    //                                     </div>'
    //                     );
    //                     redirect('barang_produksi/barang_jadi');
    //                 }
    //             }

    //             if (!$stok_akhir_negatif) {

    //                 // upload barang jadi ke tabel barang jadi
    //                 $this->Model_barang_produksi->upload_barang_jadi($data);

    //                 // Mengambil informasi barang baku yang dibutuhkan berdasarkan id_jenis_barang
    //                 $barang_baku_info = $this->Model_barang_produksi->getBarangBakuInfo($id_jenis_barang);

    //                 // Menginsert data ke tabel keluar_baku_produksi sesuai dengan ketentuan
    //                 foreach ($barang_baku_info as $item) {
    //                     $data_keluar_baku = array(
    //                         'id_jenis_barang' => $id_jenis_barang,
    //                         'id_barang_baku' => $item['id_barang_baku'],
    //                         'jumlah_keluar_baku' => $item['jumlah_keluar_baku'] * $jumlah,
    //                         'tanggal_keluar_baku' => $tanggal_barang_jadi,
    //                         'input_keluar_baku' =>  $this->session->userdata('nama_lengkap')
    //                     );
    //                     $this->Model_barang_produksi->insert_keluar_baku($data_keluar_baku);
    //                 }
    //             }
    //             $this->session->set_flashdata(
    //                 'info',
    //                 '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    //                                 <strong>Sukses,</strong> Barang jadi berhasil di upload
    //                                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                                 </button>
    //                             </div>'
    //             );
    //             redirect('barang_produksi/barang_jadi');
    //         }
    //     }
    // }

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
                    'input_status_barang_jadi' => $this->session->userdata('nama_lengkap'),
                    'tgl_input_barang_jadi' => date('Y-m-d H:i:s')
                );
                // upload barang jadi ke tabel barang jadi
                $this->Model_barang_produksi->upload_barang_jadi($data);

                // Mengambil informasi barang baku yang dibutuhkan berdasarkan id_jenis_barang
                $barang_baku_info = $this->Model_barang_produksi->getBarangBakuInfo($id_jenis_barang);

                // Menginsert data ke tabel keluar_baku_produksi sesuai dengan ketentuan
                foreach ($barang_baku_info as $item) {
                    $data_keluar_baku = array(
                        'id_jenis_barang' => $id_jenis_barang,
                        'id_barang_baku' => $item['id_barang_baku'],
                        'jumlah_keluar_baku' => $item['jumlah_keluar_baku'] * $jumlah,
                        'tanggal_keluar_baku' => $tanggal_barang_jadi,
                        'input_keluar_baku' =>  $this->session->userdata('nama_lengkap')
                    );
                    $this->Model_barang_produksi->insert_keluar_baku($data_keluar_baku);
                }
            }
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                                    <strong>Sukses,</strong> Barang jadi berhasil di upload
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    </button>
                                </div>'
            );
            redirect('barang_produksi/barang_jadi');
        }
    }

    public function proses_jadi($id_barang_jadi)
    {
        $data = [
            'status_barang_produksi' => 1,
            'status_pesan' => 1,
            'tgl_update_barang_jadi' => date('Y-m-d H:i:s')
        ];
        $this->Model_barang_produksi->update_status_barang_jadi($id_barang_jadi, $data);
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

    public function upload_galon()
    {
        $this->form_validation->set_rules('jumlah_barang_jadi', 'Jumlah Barang Jadi', 'required|trim|numeric|greater_than[0]');
        $this->form_validation->set_rules('tanggal_barang_jadi', 'Hari ini', 'required|trim');
        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('numeric', '%s harus berupa angka');
        $this->form_validation->set_message('is_unique', '%s sudah dilakukan produksi galon');
        $this->form_validation->set_message('greater_than', '%s harus lebih besar dari 0');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Produksi Galon 19 liter';
            $jumlah_galon_kembali = 0;
            $tanggal_barang_jadi = date('Y-m-d');
            $query_result = $this->db->get_where('galon_kembali', ['tanggal_kembali' => $tanggal_barang_jadi])->row();

            if ($query_result) {
                $jumlah_galon_kembali = $query_result->jumlah_akhir;
            } else {
                $jumlah_galon_kembali = 0;
            }

            $data['jumlah_kembali'] = $jumlah_galon_kembali;

            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_produksi');
            $this->load->view('templates/pengguna/sidebar_produksi');
            $this->load->view('barang_produksi/view_tambah_galon', $data);
            $this->load->view('templates/pengguna/footer_produksi');
        } else {
            $tanggal_barang_jadi = $this->input->post('tanggal_barang_jadi');
            $jumlah_barang_jadi = $this->input->post('jumlah_barang_jadi');
            $jumlah_galon_kembali = $this->db->get_where('galon_kembali', ['tanggal_kembali' => $tanggal_barang_jadi])->row()->jumlah_akhir;

            if ($jumlah_galon_kembali < $jumlah_barang_jadi) {
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Maaf,</strong> jumlah Galon tidak mencukupi untuk di produksi hari ini silakan tambah galon baru
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    </button>
                                </div>'
                );
                redirect('barang_produksi/barang_jadi');
            } else {

                $data = array(
                    'id_jenis_barang' => 1,
                    'jumlah_barang_jadi' => $jumlah_barang_jadi,
                    'tanggal_barang_jadi' => $tanggal_barang_jadi,
                    'input_status_barang_jadi' => $this->session->userdata('nama_lengkap'),
                    'tgl_input_barang_jadi' => date('Y-m-d H:i:s')
                );

                $jumlah_akhir = $jumlah_galon_kembali - $jumlah_barang_jadi;

                $data_galon = array(
                    'jumlah_produksi' => $jumlah_barang_jadi,
                    'jumlah_akhir' => $jumlah_akhir
                );
                // upload barang jadi ke tabel barang jadi
                $this->Model_barang_produksi->upload_barang_jadi($data);

                //  update tabel galon_kembali untuk mengisi kolom jumlah_produksi
                $this->Model_barang_produksi->update_galon_kembali($data_galon, $tanggal_barang_jadi);

                // Mengambil informasi barang baku yang dibutuhkan berdasarkan id_jenis_barang
                $barang_baku_info = $this->Model_barang_produksi->getBarangBakuInfo(1);

                // Menginsert data ke tabel keluar_baku_produksi sesuai dengan ketentuan
                foreach ($barang_baku_info as $item) {
                    $data_keluar_baku = array(
                        'id_jenis_barang' => 1,
                        'id_barang_baku' => $item['id_barang_baku'],
                        'jumlah_keluar_baku' => $item['jumlah_keluar_baku'] * $jumlah_barang_jadi,
                        'tanggal_keluar_baku' => $tanggal_barang_jadi,
                        'input_keluar_baku' =>  $this->session->userdata('nama_lengkap')
                    );
                    $this->Model_barang_produksi->insert_keluar_baku($data_keluar_baku);
                }
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                                    <strong>Sukses,</strong> Galon berhasil di produksi hari ini
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    </button>
                                </div>'
                );
                redirect('barang_produksi/barang_jadi');
            }
        }
    }
}
