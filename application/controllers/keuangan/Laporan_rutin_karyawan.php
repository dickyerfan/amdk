<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_rutin_karyawan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_lap_rutin_karyawan');
        $this->load->model('Model_laporan');
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
            $this->session->set_userdata('tanggal', $tanggal);
        }

        $data['title'] = 'Laporan Pembelian Karyawan PDAM';
        $data['rutin'] = $this->Model_lap_rutin_karyawan->get_all($bulan, $tahun);

        if ($this->session->userdata('upk_bagian') == 'admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_laporan_rutin_karyawan', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_laporan_rutin_karyawan', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
    }

    public function input_terima_karyawan()
    {
        $tanggal = $this->session->userdata('tanggal');
        $bulan = substr($tanggal, 5, 2);
        $tahun = substr($tanggal, 0, 4);

        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
            $bulan = date('m');
            $tahun = date('Y');
        }

        $data['bulan_lap'] = $bulan;
        $data['tahun_lap'] = $tahun;
        $data['title'] = 'Input Penerimaaan Rutin Karyawan';
        $data['rutin'] = $this->Model_lap_rutin_karyawan->get_all($bulan, $tahun);
        $data['pesan_karyawan'] = $this->Model_lap_rutin_karyawan->get_pemesanan_karyawan($bulan, $tahun);

        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar_uang');
        $this->load->view('templates/pengguna/sidebar_uang');
        $this->load->view('keuangan/view_input_terima_rutin_karyawan', $data);
        $this->load->view('templates/pengguna/footer_uang');
    }

    public function setor()
    {
        $tanggal = $this->session->userdata('tanggal');
        $bulan = substr($tanggal, 5, 2);
        $tahun = substr($tanggal, 0, 4);

        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
            $bulan = date('m');
            $tahun = date('Y');
        }
        $total_pesanan = $this->Model_lap_rutin_karyawan->get_pemesanan_karyawan($bulan, $tahun)[0]->total_penerimaan;
        $rutin = $this->Model_lap_rutin_karyawan->get_all($bulan, $tahun);
        $total_galon = $total_gelas = $total_btl330 = $total_btl500 = $total_btl1500 = $total_nominal = 0;
        foreach ($rutin as $row) {
            $total_galon += $row->galon;
            $total_gelas += $row->gelas;
            $total_btl330 += $row->btl330;
            $total_btl500 += $row->btl500;
            $total_btl1500 += $row->btl1500;
            $total_nominal += $row->nominal;
        };

        $input_setor = $this->session->userdata('nama_lengkap');

        $galon = $total_galon;
        $gelas = $total_gelas;
        $btl330 = $total_btl330;
        $btl500 = $total_btl500;
        $btl1500 = $total_btl1500;
        $nominal = $total_nominal;

        $rupiah_galon = $total_galon * 11000;
        $rupiah_gelas = $total_gelas * 15000;
        $rupiah_btl330 = $total_btl330 * 33000;
        $rupiah_btl500 = $total_btl500 * 35000;
        $rupiah_btl1500 = $total_btl1500 * 38000;

        if ($total_pesanan == $nominal) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> Total penerimaan sudah disetor. Anda tidak dapat melakukan setoran lagi
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('keuangan/laporan_rutin_karyawan');
        }

        if (!empty($_FILES['nota_setor']['name'])) {
            $config['upload_path']   = './uploads/uang/nota/';
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['max_size']      = 1024;
            $config['overwrite']     = true;

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('nota_setor')) {

                $upload_data = $this->upload->data();
                $nota_setor = $upload_data['file_name'];

                $this->Model_lap_rutin_karyawan->insert_pemesanan(1, 695, $tanggal, 3, $galon, 11000, $rupiah_galon, $tanggal, $nota_setor, $tanggal, 1, $input_setor, 1, 0, 1);
                $this->Model_lap_rutin_karyawan->insert_pemesanan(2, 695, $tanggal, 3, $gelas, 15000, $rupiah_gelas, $tanggal, $nota_setor, $tanggal, 1, $input_setor, 1, 0, 1);
                $this->Model_lap_rutin_karyawan->insert_pemesanan(8, 695, $tanggal, 3, $btl330, 33000, $rupiah_btl330, $tanggal, $nota_setor, $tanggal, 1, $input_setor, 1, 0, 1);
                $this->Model_lap_rutin_karyawan->insert_pemesanan(9, 695, $tanggal, 3, $btl500, 35000, $rupiah_btl500, $tanggal, $nota_setor, $tanggal, 1, $input_setor, 1, 0, 1);
                $this->Model_lap_rutin_karyawan->insert_pemesanan(11, 695, $tanggal, 3, $btl1500, 38000, $rupiah_btl1500, $tanggal, $nota_setor, $tanggal, 1, $input_setor, 1, 0, 1);

                $this->session->set_flashdata(
                    'info',
                    '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>Sukses,</strong> Data Pesanan Rutin karyawan berhasil di setor
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                          </div>'
                );
                redirect('keuangan/laporan_rutin_karyawan');
            } else {
                // Jika proses upload gagal
                $error_msg = $this->upload->display_errors();
                $this->session->set_flashdata('info', $error_msg);
                redirect('barang_produksi/barang_rusak');
            }
        } else {
            // Tampilkan pesan kesalahan jika tidak ada file yang diunggah
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal,</strong> Silakan masukkan file Nota Setor Bank
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>'
            );
            redirect('keuangan/laporan_rutin_karyawan');
        }
    }

    public function exportpdf()
    {
        $tanggal = $this->session->userdata('tanggal');
        $bulan = substr($tanggal, 5, 2);
        $tahun = substr($tanggal, 0, 4);

        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
            $bulan = date('m');
            $tahun = date('Y');
        }
        $data['bulan_lap'] = $bulan;
        $data['tahun_lap'] = $tahun;
        $data['title'] = 'Laporan Pembelian Karyawan PDAM';
        $data['rutin'] = $this->Model_lap_rutin_karyawan->get_all($bulan, $tahun);

        $data['bulan_lap'] = $bulan;
        $data['tahun_lap'] = $tahun;
        $data['manager'] = $this->Model_laporan->get_manager();
        $data['uang'] = $this->Model_laporan->get_uang();

        // Set paper size and orientation
        $this->pdf->setPaper('folio', 'landscape');

        // $this->pdf->filename = "Potensi Sr.pdf";
        $this->pdf->filename = "LapBeliKyw-{$bulan}-{$tahun}.pdf";
        $this->pdf->generate('keuangan/laporan_beli_rutin_kyw_pdf', $data);
    }

    public function download()
    {

        if (isset($_POST['ambil_data'])) {
            $tanggal = $this->input->post('tanggal');
            $bulan = substr($tanggal, 5, 2);
            $tahun = substr($tanggal, 0, 4);

            if (empty($tanggal)) {
                $tanggal = date('Y-m-d');
                $bulan = date('m');
                $tahun = date('Y');
            }
        }

        $this->db->select('nama');
        $this->db->from('lap_rutin_pegawai');
        $this->db->where('MONTH(tgl_lap)', $bulan);
        $this->db->where('YEAR(tgl_lap)', $tahun);
        $query = $this->db->get();


        if ($query->num_rows() > 0) {
            $this->session->set_flashdata('info', '<div class="alert alert-danger" role="alert">
            Download Data Gagal! <br> Daftar Rutin Karyawan sudah ada
          </div>');
            redirect('keuangan/laporan_rutin_karyawan');
        } else {

            $this->db->query("INSERT INTO lap_rutin_pegawai (id_bagian,nama,alamat,no_hp,aktif,tarif,tgl_lap,galon,gelas,btl330,btl500,btl1500,nominal)SELECT id_bagian,nama,alamat,no_hp,aktif,tarif,now(),galon,gelas,btl330,btl500,btl1500,nominal FROM rutin_pegawai");

            $this->session->set_flashdata('info', '<div class="alert alert-success" role="alert">
            Download Data sukses! <br> Daftar Rutin Karyawan tersedia
          </div>');
            redirect('keuangan/laporan_rutin_karyawan');
        }
    }
}
