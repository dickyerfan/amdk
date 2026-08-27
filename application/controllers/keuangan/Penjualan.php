<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_penjualan');
        $this->load->model('Model_pemesanan');
        $this->load->model('Model_penerimaan');
        $this->load->model('Model_setting');
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
        if ($level_pengguna != 'Admin' && $upk_bagian != 'uang') {
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
        date_default_timezone_set('Asia/Jakarta');
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
        $data['title'] = 'Daftar Penjualan Barang';
        $data['pesan'] = $this->Model_penjualan->get_all($tanggal);
        $deadline_time = $this->Model_setting->get_deadline_time();

        $deadline_timestamp = strtotime($deadline_time);
        $data['deadline_time'] = date('H:i', $deadline_timestamp);

        // $data['pesan'] = $this->Model_penjualan->get_all($bulan, $tahun);
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_penjualan', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_penjualan', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
    }

    public function pilih_lunas($id_pemesanan)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = $this->session->userdata('tanggal');
        $this->form_validation->set_rules('status_bayar', 'Status bayar', 'required|trim');
        // $this->form_validation->set_rules('tanggal_bayar', 'Tanggal bayar', 'required|trim');
        $this->form_validation->set_message('required', '%s harus pilih');

        if ($this->form_validation->run() == false) {
            $data['lunas'] = $this->Model_penjualan->get_lunas($id_pemesanan);
            $data['title'] = 'Form Pelunasan';
            if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_pilih_lunas', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_pilih_lunas', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
        } else {

            $data['status_bayar'] = $this->input->post('status_bayar');
            $data['status_pesan'] = 0;
            $data['input_bayar'] = $this->session->userdata('nama_lengkap');
            // ini untuk production
            $data['tanggal_bayar'] = date('Y-m-d H:i:s');
            // ini hanya untuk input data
            // $data['tanggal_bayar'] = $this->input->post('tanggal_bayar');

            // Periksa bulan dan tahun antara tanggal_pesan dan tanggal_bayar
            $bulan_tahun_pesan = date('Y-m', strtotime($this->db->get_where('pemesanan', ['id_pemesanan' => $id_pemesanan])->row()->tanggal_pesan));
            $bulan_tahun_bayar = date('Y-m', strtotime($data['tanggal_bayar']));

            if ($bulan_tahun_bayar > $bulan_tahun_pesan) {
                // Jika bulan dan tahun tanggal_bayar lebih besar dari tanggal_pesan, update status_piutang tetap 1
                $data['status_piutang'] = 1;
            } else {
                // Jika bulan dan tahun tanggal_bayar sama atau lebih kecil dari tanggal_pesan, status_piutang menjadi 0
                $data['status_piutang'] = 0;
            }

            $this->Model_penjualan->update('pemesanan', $data, $id_pemesanan);
            $cek_lunas = $this->db->get_where('pemesanan', ['id_pemesanan' => $id_pemesanan])->row();
            if ($cek_lunas->status_bayar == 0) {
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Maaf,</strong> pembayaran gagal, pilih lunas untuk membayar
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                          </div>'
                );
                $alamat = 'keuangan/penjualan?tanggal=' . $tanggal;
                redirect($alamat);
                // redirect('keuangan/penjualan');
            } else {
                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>Sukses,</strong> Barang lunas dibayar
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                          </div>'
                );
                $alamat = 'keuangan/penjualan?tanggal=' . $tanggal;
                redirect($alamat);
                // redirect('keuangan/penjualan');
            }
        }
    }

    public function detail($id_pemesanan)
    {
        $data['detail_pemesanan'] = $this->Model_pemesanan->get_detail_pemesanan($id_pemesanan);
        $data['title'] = 'Detail Penjualan Barang';
        if ($this->session->userdata('level') == 'Admin') {
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('keuangan/view_detail_pemesanan', $data);
        $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_detail_pemesanan', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
    }

    public function cek_status_pesanan()
    {
        $this->db->select('*');
        $this->db->from('pemesanan');
        $this->db->where('status_pesan', 1);
        $result = $this->db->get()->result();

        if ($result) {
            $response['success'] = true;
        } else {
            $response['success'] = false;
        }

        echo json_encode($response);
    }

    // public function update_status_pesan()
    // {
    //     $data = [
    //         'status_pesan' => 0
    //     ];
    //     $this->db->update('pemesanan', $data);
    //     redirect('keuangan/penjualan');
    // }

    public function tambah_penerimaan_lainnya()
    {
        $data['title'] = 'Form Tambah Penerimaan Lainnya';
        $data['produk_lainnya'] = $this->Model_penerimaan->get_produk_lainnya();
        $data['pelanggan'] = $this->db->get_where('pelanggan', ['aktif' => 1])->result();

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_tambah_penerimaan_lainnya_penjualan', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_tambah_penerimaan_lainnya_penjualan', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
    }

    public function simpan_penerimaan_lainnya()
    {
        date_default_timezone_set('Asia/Jakarta');

        $this->form_validation->set_rules('id_produk', 'Jenis Penerimaan', 'required|trim');
        $this->form_validation->set_rules('id_pelanggan', 'Nama Pembeli', 'required|trim');
        $this->form_validation->set_rules('total', 'Total', 'required|trim|numeric');
        $this->form_validation->set_message('required', '%s harus diisi');
        $this->form_validation->set_message('numeric', '%s harus berupa angka');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal,</strong> Silakan isi form dengan benar.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'
            );
            redirect('keuangan/penjualan/tambah_penerimaan_lainnya');
        } else {
            $tanggal = date('Y-m-d');

            $id_produk = $this->input->post('id_produk');
            $id_pelanggan = $this->input->post('id_pelanggan');
            $total = $this->input->post('total');

            $nota_beli = '';
            $status_nota = 0;

            if (!empty($_FILES['nota_beli']['name'])) {
                $config['upload_path']   = './uploads/uang/nota/';
                $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config['max_size']      = 2048;
                $config['overwrite']     = true;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('nota_beli')) {
                    $data_upload = $this->upload->data();
                    $nota_beli = $data_upload['file_name'];
                    $status_nota = 1;
                } else {
                    $this->session->set_flashdata(
                        'info',
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Gagal,</strong> Upload Kwitansi/Nota gagal. ' . $this->upload->display_errors() . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>'
                    );
                    redirect('keuangan/penjualan/tambah_penerimaan_lainnya');
                    return;
                }
            }

            $data = [
                'id_jenis_barang'        => $id_produk,
                'id_pelanggan'           => $id_pelanggan,
                'id_mobil'               => NULL,
                'jam_mobil'              => 0,
                'no_perkiraan'           => '88.02.08',
                'cabang'                 => 13,
                'tanggal_pesan'          => $tanggal,
                'jenis_pesanan'          => 5,
                'jumlah_pesan'           => 1,
                'status_kembali'         => 0,
                'harga_barang'           => $total,
                'total_harga'            => $total,
                'input_pesan'            => $this->session->userdata('nama_lengkap'),
                'tanggal_input'          => date('Y-m-d H:i:s'),
                'nota_beli'              => $nota_beli,
                'status_nota'            => $status_nota,
                'input_bayar'            => '',
                'status_bayar'           => 0,
                'tanggal_bayar'          => '',
                'input_update'           => '',
                'tanggal_update'         => date('Y-m-d H:i:s'),
                'status_pesan'           => 0,
                'status_piutang'         => 0,
                'nota_setor'             => '',
                'status_setor'           => 0,
                'tanggal_setor'          => date('Y-m-d H:i:s'),
                'input_setor'            => '',
                'status_setoran_driver'  => 0,
                'tgl_setoran_driver'     => $tanggal,
                'input_setoran_driver'   => $this->session->userdata('nama_lengkap'),
            ];

            $this->Model_penerimaan->insert_penerimaan_lainnya($data);

            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>Sukses,</strong> Penerimaan lainnya berhasil ditambahkan. Silakan pilih lunas untuk memproses pembayaran.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'
            );
            redirect('keuangan/penjualan');
        }
    }
}
