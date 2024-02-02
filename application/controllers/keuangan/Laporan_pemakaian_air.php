<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_pemakaian_air extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_laporan');
        // $this->load->model('Model_ambil_air');
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
        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
        }
        // Tentukan rentang tanggal berdasarkan bulan yang dipilih
        $tanggal_awal = date('Y-m-01', strtotime($tanggal));
        $tanggal_akhir = date('Y-m-t', strtotime($tanggal));


        $data['ambil_air'] = $this->Model_laporan->get_ambil_air($tanggal_awal, $tanggal_akhir);
        $data['produksi_air'] = $this->Model_laporan->get_produksi_liter($tanggal_awal, $tanggal_akhir);

        $selectedMonth = $this->input->get('tanggal');
        if (empty($selectedMonth)) {
            $selectedMonth = date('Y-m');
        }
        list($year, $month) = explode('-', $selectedMonth);
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $dateRange = [];
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = "$year-$month-" . sprintf("%02d", $day);
            $dateRange[] = $date;
        }
        $data['dateRange'] = $dateRange;

        $data['title'] = 'Laporan Pemakaian Air AMDK';

        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_laporan_pemakaian_air', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_laporan_pemakaian_air', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
    }

    // public function tambah()
    // {
    //     $data['title'] = "Form Pengambilan Air Baku AMDK";
    //     $data['karyawan'] = $this->Model_ambil_air->get_karyawan();
    //     $this->form_validation->set_rules('tanggal_ambil_air', 'Tanggal', 'required|trim');
    //     $this->form_validation->set_rules('id_karyawan', 'Nama Karyawan', 'required|trim');
    //     $this->form_validation->set_rules('stand_meter', 'Stand Meter', 'required|trim|numeric');
    //     $this->form_validation->set_rules('bbm', 'BBM', 'trim|numeric');

    //     $this->form_validation->set_message('required', '%s masih kosong');
    //     $this->form_validation->set_message('numeric', '%s harus di tulis angka');

    //     $waktu = $this->input->post('waktu', true);

    //     if (preg_match('/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/', $waktu)) {
    //         // Format waktu benar, lanjutkan penyimpanan
    //         $data['waktu'] = $waktu;
    //     } else {
    //         // Format waktu tidak valid
    //         $this->form_validation->set_message('valid_time_format', 'Format waktu tidak valid (HH:MM:SS).');
    //         $this->form_validation->set_rules('waktu', 'Waktu', 'callback_valid_time_format');
    //     }

    //     $harga_solar = 6500;
    //     $ket = 0;
    //     $bbm = intval($this->input->post('bbm', true));
    //     if (!empty($bbm)) {
    //         $ket = $bbm / $harga_solar;
    //         $data['ket'] = round($ket, 0);
    //     } else {
    //         // Atur $data['ket'] ke 0 jika $bbm kosong
    //         $data['ket'] = 0;
    //     }

    //     $this->db->select('stand_meter');
    //     $this->db->order_by('tanggal_ambil_air', 'DESC');
    //     $this->db->limit(1);
    //     $query = $this->db->get('truk_tangki');

    //     if ($query->num_rows() > 0) {
    //         $result = $query->row();
    //         $stand_lalu = $result->stand_meter;
    //     } else {
    //         // Handle jika tidak ada data
    //         $stand_lalu = 0; // Atau sesuaikan dengan nilai default yang diinginkan
    //     }

    //     $stand_ini = $this->input->post('stand_meter', true);

    //     $kubik = intval($stand_ini) - intval($stand_lalu);
    //     $jumlah = $kubik * 1000;

    //     if ($this->form_validation->run() == false) {
    //         $this->load->view('templates/pengguna/header', $data);
    //         $this->load->view('templates/pengguna/navbar_uang');
    //         $this->load->view('templates/pengguna/sidebar_uang');
    //         $this->load->view('keuangan/view_tambah_ambil_air', $data);
    //         $this->load->view('templates/pengguna/footer_uang');
    //     } else {
    //         $data = [
    //             'tanggal_ambil_air' => $this->input->post('tanggal_ambil_air', true),
    //             'id_karyawan' => $this->input->post('id_karyawan', true),
    //             'waktu' => $data['waktu'],
    //             'stand_lalu' => $stand_lalu,
    //             'stand_meter' => $stand_ini,
    //             'jumlah' => $jumlah,
    //             'bbm' => $this->input->post('bbm', true),
    //             'ket' => $data['ket'],
    //             'input_truk_tangki' =>  $this->session->userdata('nama_lengkap')
    //         ];
    //         $data['user'] = $this->Model_ambil_air->tambahData($data);
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    //                     <strong>Sukses,</strong> Data pengambilan air baru berhasil di tambah
    //                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                     </button>
    //                   </div>'
    //         );
    //         redirect('keuangan/pengambilan_air');
    //     }
    // }

    // public function edit($id_pelanggan)
    // {
    //     $data['title'] = "Form Edit Pelanggan";
    //     $data['edit_pelanggan'] = $this->db->get_where('pelanggan', ['id_pelanggan' => $id_pelanggan])->row();
    //     $this->load->view('templates/pengguna/header', $data);
    //     $this->load->view('templates/pengguna/navbar_uang');
    //     $this->load->view('templates/pengguna/sidebar_uang');
    //     $this->load->view('keuangan/view_edit_pelanggan', $data);
    //     $this->load->view('templates/pengguna/footer_uang');
    // }

    // public function update()
    // {
    //     $this->Model_ambil_air->updateData();
    //     if ($this->db->affected_rows() <= 0) {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //                     <strong>Maaf,</strong> tidak ada perubahan data
    //                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                     </button>
    //                   </div>'
    //         );
    //         redirect('keuangan/pengambilan_air');
    //     } else {
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-success alert-dismissible fade show" role="alert">
    //                     <strong>Sukses,</strong> Data Pelanggan berhasil di update
    //                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                     </button>
    //                   </div>'
    //         );
    //         redirect('keuangan/pengambilan_air');
    //     }
    // }

    // public function hapus($id_pelanggan)
    // {
    //     $this->Model_ambil_air->hapusData($id_pelanggan);
    //     $this->session->set_flashdata(
    //         'info',
    //         '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //                 <strong>Sukses,</strong> Data Pelanggan berhasil di hapus
    //                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                 </button>
    //               </div>'
    //     );
    //     redirect('keuangan/pengambilan_air');
    // }

    public function exportpdf()
    {
        $tanggal = $this->session->userdata('$tanggal_lap');
        $bulan = substr($tanggal, 5, 2);
        $tahun = substr($tanggal, 0, 4);

        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
            $bulan = date('m');
            $tahun = date('Y');
        }
        $data['title'] = 'Laporan Pengambilan Air Baku AMDK';
        $data['ambil_air'] = $this->Model_ambil_air->get_ambil_air($bulan, $tahun);

        $data['bulan_lap'] = $bulan;
        $data['tahun_lap'] = $tahun;
        $data['manager'] = $this->Model_laporan->get_manager();
        $data['uang'] = $this->Model_laporan->get_uang();

        // Set paper size and orientation
        $this->pdf->setPaper('folio', 'portrait');

        // $this->pdf->filename = "Potensi Sr.pdf";
        $this->pdf->filename = "Lap_ambil_air-{$bulan}-{$tahun}.pdf";
        $this->pdf->generate('keuangan/laporan_pengambilan_air_pdf', $data);
    }
}
