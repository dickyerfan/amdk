<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_ban_ops extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
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

    // public function index()
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
    //         $this->session->set_userdata('tanggal_ops', $tanggal);
    //     }

    //     $data['title'] = 'Laporan Operasional AMDK';
    //     // Ambil data dari model
    //     $ban_ops = $this->Model_laporan->get_ops($bulan, $tahun);

    //     $jenis_produk = $this->Model_laporan->get_jenis_produk();

    //     // Mengelompokkan data berdasarkan nama dan tanggal
    //     $grouped_ban_ops = [];
    //     foreach ($ban_ops as $row) {
    //         $key = $row->nama_pelanggan . $row->tanggal_ban_ops;
    //         if (!isset($grouped_ban_ops[$key])) {
    //             $grouped_ban_ops[$key] = (object)[
    //                 'nama_pelanggan' => $row->nama_pelanggan,
    //                 'tanggal_ban_ops' => $row->tanggal_ban_ops,
    //                 'jumlah' => [],
    //                 'harga_ban_ops_total' => 0,
    //                 'keterangan' => $row->keterangan,
    //             ];
    //         }
    //         $grouped_ban_ops[$key]->harga_ban_ops_total += $row->harga_ban_ops; // Menambahkan total harga
    //         $grouped_ban_ops[$key]->jumlah[$row->nama_barang_jadi] = $row->jumlah_ban_ops;
    //     }
    //     $data['grouped_ban_ops'] = $grouped_ban_ops;
    //     $data['jenis_produk'] = $jenis_produk;
    //     if ($this->session->userdata('level') == 'Admin') {
    //         $this->load->view('templates/header', $data);
    //         $this->load->view('templates/navbar');
    //         $this->load->view('templates/sidebar');
    //         $this->load->view('keuangan/view_laporan_ops', $data);
    //         $this->load->view('templates/footer');
    //     } else {
    //         $this->load->view('templates/pengguna/header', $data);
    //         $this->load->view('templates/pengguna/navbar_uang');
    //         $this->load->view('templates/pengguna/sidebar_uang');
    //         $this->load->view('keuangan/view_laporan_ops', $data);
    //         $this->load->view('templates/pengguna/footer_uang');
    //     }
    // }

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
            $this->session->set_userdata('tanggal_ops', $tanggal);
        }

        $data['title'] = 'Laporan Operasional AMDK';
        // Ambil data dari model
        $ban_ops = $this->Model_laporan->get_ops($bulan, $tahun);

        $jenis_produk = $this->Model_laporan->get_jenis_produk();

        // Mengelompokkan data berdasarkan nama dan tanggal
        $grouped_ban_ops = [];
        foreach ($ban_ops as $row) {
            $key = $row->nama_pelanggan . '_' . $row->tanggal_ban_ops;
            if (!isset($grouped_ban_ops[$key])) {
                $grouped_ban_ops[$key] = (object)[
                    'nama_pelanggan' => $row->nama_pelanggan,
                    'tanggal_ban_ops' => $row->tanggal_ban_ops,
                    'jumlah' => [],
                    'harga_ban_ops_total' => 0,
                    'keterangan' => $row->keterangan,
                ];
            }

            // Menambahkan total harga
            $grouped_ban_ops[$key]->harga_ban_ops_total += $row->harga_ban_ops;

            // Menambahkan jumlah barang
            if (!isset($grouped_ban_ops[$key]->jumlah[$row->nama_barang_jadi])) {
                $grouped_ban_ops[$key]->jumlah[$row->nama_barang_jadi] = 0;
            }
            $grouped_ban_ops[$key]->jumlah[$row->nama_barang_jadi] += $row->jumlah_ban_ops;
        }

        $data['grouped_ban_ops'] = $grouped_ban_ops;
        $data['jenis_produk'] = $jenis_produk;
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_laporan_ops', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_laporan_ops', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
    }



    public function input_terima_ban_ops()
    {
        $tanggal = $this->session->userdata('tanggal_ops');
        $bulan = substr($tanggal, 5, 2);
        $tahun = substr($tanggal, 0, 4);

        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
            $bulan = date('m');
            $tahun = date('Y');
        }

        $data['bulan_lap'] = $bulan;
        $data['tahun_lap'] = $tahun;
        $data['title'] = 'Input Penerimaaan Operasional/Bantuan';
        $ban_ops = $this->Model_laporan->get_ban_ops($bulan, $tahun);

        $jenis_produk = $this->Model_laporan->get_jenis_produk();

        $data['ban_ops'] = $this->Model_laporan->get_ban_ops($bulan, $tahun);
        $data['pesan_ban_ops'] = $this->Model_laporan->get_pemesanan_ban_ops($bulan, $tahun);

        $this->load->view('templates/pengguna/header', $data);
        $this->load->view('templates/pengguna/navbar_uang');
        $this->load->view('templates/pengguna/sidebar_uang');
        $this->load->view('keuangan/view_input_terima_ban_ops', $data);
        $this->load->view('templates/pengguna/footer_uang');
    }

    public function setor()
    {
        $tanggal = $this->session->userdata('tanggal_ops');
        $bulan = substr($tanggal, 5, 2);
        $tahun = substr($tanggal, 0, 4);

        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
            $bulan = date('m');
            $tahun = date('Y');
        }


        $ban_ops = $this->Model_laporan->get_ban_ops($bulan, $tahun);
        $total_ban_ops = 0;
        foreach ($ban_ops as $row) {
            $total_ban_ops = $row->total_ban_ops;
        }

        $pesan_ban_ops = $this->Model_laporan->get_pemesanan_ban_ops($bulan, $tahun);
        $total_pesan_ban_ops = 0;
        foreach ($pesan_ban_ops as $row) {
            $total_pesan_ban_ops = $row->total_pesan_ban_ops;
        }

        if ($total_ban_ops == $total_pesan_ban_ops) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> Total penerimaan operasional sudah disetor. Anda tidak dapat melakukan setoran lagi
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('keuangan/laporan_ban_ops');
        } else {
            $data = [
                'status_bayar' => 1,
                'input_bayar' => $this->session->userdata('namaLengkap'),
                'tanggal_bayar' => date('Y-m-d H:i:s'),
                'status_pesan' => 0,
                'status_piutang' => 0
            ];

            $this->Model_laporan->update_pemesanan($bulan, $tahun, $data);
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong>Sukses,</strong> Data penerimaan operasional/bantuan berhasil di bayar
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                          </div>'
            );
            redirect('keuangan/laporan_ban_ops');
        }
    }


    public function exportpdf_ops()
    {
        $tanggal = $this->session->userdata('tanggal_ops');
        $bulan = substr($tanggal, 5, 2);
        $tahun = substr($tanggal, 0, 4);

        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
            $bulan = date('m');
            $tahun = date('Y');
        }
        $data['bulan_lap'] = $bulan;
        $data['tahun_lap'] = $tahun;
        $data['title'] = 'Laporan Operasional AMDK';

        // Ambil data dari model
        $ban_ops = $this->Model_laporan->get_ops($bulan, $tahun);

        $jenis_produk = $this->Model_laporan->get_jenis_produk();

        // Mengelompokkan data berdasarkan nama dan tanggal
        $grouped_ban_ops = [];
        foreach ($ban_ops as $row) {
            $key = $row->nama_pelanggan . '_' . $row->tanggal_ban_ops;
            if (!isset($grouped_ban_ops[$key])) {
                $grouped_ban_ops[$key] = (object)[
                    'nama_pelanggan' => $row->nama_pelanggan,
                    'tanggal_ban_ops' => $row->tanggal_ban_ops,
                    'jumlah' => [],
                    'harga_ban_ops_total' => 0,
                    'keterangan' => $row->keterangan,
                ];
            }

            // Menambahkan total harga
            $grouped_ban_ops[$key]->harga_ban_ops_total += $row->harga_ban_ops;

            // Menambahkan jumlah barang
            if (!isset($grouped_ban_ops[$key]->jumlah[$row->nama_barang_jadi])) {
                $grouped_ban_ops[$key]->jumlah[$row->nama_barang_jadi] = 0;
            }
            $grouped_ban_ops[$key]->jumlah[$row->nama_barang_jadi] += $row->jumlah_ban_ops;
        }

        $data['grouped_ban_ops'] = $grouped_ban_ops;
        $data['jenis_produk'] = $jenis_produk;

        $data['bulan_lap'] = $bulan;
        $data['tahun_lap'] = $tahun;
        $data['manager'] = $this->Model_laporan->get_manager();
        $data['uang'] = $this->Model_laporan->get_uang();

        $this->pdf->setPaper('folio', 'landscape');
        $this->pdf->filename = "LapOps-{$bulan}-{$tahun}.pdf";
        $this->pdf->generate('keuangan/laporan_operasional_pdf', $data);
    }

    public function lap_ban()
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
            $this->session->set_userdata('tanggal_ban', $tanggal);
        }

        $data['title'] = 'Laporan Bantuan AMDK';
        // Ambil data dari model
        $ban_ops = $this->Model_laporan->get_ban($bulan, $tahun);
        $jenis_produk = $this->Model_laporan->get_jenis_produk();

        // Mengelompokkan data berdasarkan nama dan tanggal
        $grouped_ban_ops = [];
        foreach ($ban_ops as $row) {
            $key = $row->nama_pelanggan . $row->tanggal_ban_ops;
            if (!isset($grouped_ban_ops[$key])) {
                $grouped_ban_ops[$key] = (object)[
                    'nama_pelanggan' => $row->nama_pelanggan,
                    'tanggal_ban_ops' => $row->tanggal_ban_ops,
                    'jumlah' => [],
                    'harga_ban_ops_total' => 0,
                    'keterangan' => $row->keterangan,
                ];
            }
            $grouped_ban_ops[$key]->harga_ban_ops_total += $row->harga_ban_ops; // Menambahkan total harga
            if (!isset($grouped_ban_ops[$key]->jumlah[$row->nama_barang_jadi])) {
                $grouped_ban_ops[$key]->jumlah[$row->nama_barang_jadi] = 0;
            }
            $grouped_ban_ops[$key]->jumlah[$row->nama_barang_jadi] += $row->jumlah_ban_ops;
        }

        $data['grouped_ban_ops'] = $grouped_ban_ops;
        $data['jenis_produk'] = $jenis_produk;
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('keuangan/view_laporan_ban', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_uang');
            $this->load->view('templates/pengguna/sidebar_uang');
            $this->load->view('keuangan/view_laporan_ban', $data);
            $this->load->view('templates/pengguna/footer_uang');
        }
    }

    public function exportpdf_ban()
    {
        $tanggal = $this->session->userdata('tanggal_ban');
        $bulan = substr($tanggal, 5, 2);
        $tahun = substr($tanggal, 0, 4);

        if (empty($tanggal)) {
            $tanggal = date('Y-m-d');
            $bulan = date('m');
            $tahun = date('Y');
        }
        $data['bulan_lap'] = $bulan;
        $data['tahun_lap'] = $tahun;
        $data['title'] = 'Laporan Bantuan AMDK';
        // Ambil data dari model
        $ban_ops = $this->Model_laporan->get_ban($bulan, $tahun);
        $jenis_produk = $this->Model_laporan->get_jenis_produk();

        // Mengelompokkan data berdasarkan nama dan tanggal
        $grouped_ban_ops = [];
        foreach ($ban_ops as $row) {
            $key = $row->nama_pelanggan . $row->tanggal_ban_ops;
            if (!isset($grouped_ban_ops[$key])) {
                $grouped_ban_ops[$key] = (object)[
                    'nama_pelanggan' => $row->nama_pelanggan,
                    'tanggal_ban_ops' => $row->tanggal_ban_ops,
                    'jumlah' => [],
                    'harga_ban_ops_total' => 0,
                    'keterangan' => $row->keterangan,
                ];
            }
            $grouped_ban_ops[$key]->harga_ban_ops_total += $row->harga_ban_ops; // Menambahkan total harga
            if (!isset($grouped_ban_ops[$key]->jumlah[$row->nama_barang_jadi])) {
                $grouped_ban_ops[$key]->jumlah[$row->nama_barang_jadi] = 0;
            }
            $grouped_ban_ops[$key]->jumlah[$row->nama_barang_jadi] += $row->jumlah_ban_ops;
        }
        $data['grouped_ban_ops'] = $grouped_ban_ops;
        $data['jenis_produk'] = $jenis_produk;

        $data['bulan_lap'] = $bulan;
        $data['tahun_lap'] = $tahun;
        $data['manager'] = $this->Model_laporan->get_manager();
        $data['uang'] = $this->Model_laporan->get_uang();

        $this->pdf->setPaper('folio', 'landscape');
        $this->pdf->filename = "LapBan-{$bulan}-{$tahun}.pdf";
        $this->pdf->generate('keuangan/laporan_bantuan_pdf', $data);
    }
}
