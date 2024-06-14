<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_baku_untuk_produksi extends CI_Controller
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
        $data['title'] = 'Jenis Barang Baku untuk Produksi';
        $data['barang_baku_produksi'] = $this->Model_barang_produksi->getbarang_baku_produksi();
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('manager/view_barang_baku_untuk_produksi', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_produksi');
            $this->load->view('templates/pengguna/sidebar_produksi');
            $this->load->view('manager/view_barang_baku_untuk_produksi', $data);
            $this->load->view('templates/pengguna/footer_produksi');
        }
    }

    public function upload()
    {
        $this->form_validation->set_rules('id_jenis_barang', 'Nama Barang Jadi', 'required|trim|is_unique[barang_baku_produksi.id_jenis_barang]');
        $this->form_validation->set_rules('id_barang_baku', 'Nama Barang Baku', 'required|trim');
        $this->form_validation->set_rules('jumlah_keluar_baku', 'Jumlah Barang', 'required|trim');
        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('is_unique', '%s sudah terdaftar');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Tambah barang Baku untuk Produksi';
            $data['nama_barang'] = $this->Model_barang_produksi->get_nama_barang();
            $data['nama_barang_jadi'] = $this->Model_barang_produksi->get_nama_barang_jadi();
            if ($this->session->userdata('level') == 'Admin') {
                $this->load->view('templates/header', $data);
                $this->load->view('templates/navbar');
                $this->load->view('templates/sidebar');
                $this->load->view('manager/view_tambah_barang_baku_untuk_produksi', $data);
                $this->load->view('templates/footer');
            } else {
                $this->load->view('templates/pengguna/header', $data);
                $this->load->view('templates/pengguna/navbar_produksi');
                $this->load->view('templates/pengguna/sidebar_produksi');
                $this->load->view('manager/view_tambah_barang_baku_untuk_produksi', $data);
                $this->load->view('templates/pengguna/footer_produksi');
            }
        } else {
            $data['id_jenis_barang'] = $this->input->post('id_jenis_barang', true);
            $data['id_barang_baku'] = $this->input->post('id_barang_baku', true);
            $data['jumlah_keluar_baku'] = $this->input->post('jumlah_keluar_baku');
            $data['input_barang_produksi'] = $this->session->userdata('nama_lengkap');
            $data['tgl_barang_produksi'] = date('Y-m-d H:i:s');

            $this->Model_barang_produksi->upload('barang_baku_produksi', $data);
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Data barang baku untuk produksi berhasil di simpan
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>'
            );
            redirect('manager/barang_baku_untuk_produksi');
        }
    }

    public function edit($id_barang_baku_produksi)
    {
        $data['title'] = "Form Edit Stok Awal Baku";
        $data['edit_stok'] = $this->Model_barang_produksi->get_id_barang_baku_produksi($id_barang_baku_produksi);
        $data['barang_baku_list'] = $this->Model_barang_produksi->get_all_barang_baku(); // Method to get all barang baku
        if ($this->session->userdata('level') == 'Admin') {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('manager/view_edit_barang_baku_untuk_produksi', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/pengguna/header', $data);
            $this->load->view('templates/pengguna/navbar_produksi');
            $this->load->view('templates/pengguna/sidebar_produksi');
            $this->load->view('manager/view_edit_barang_baku_untuk_produksi', $data);
            $this->load->view('templates/pengguna/footer_produksi');
        }
    }

    public function update()
    {
        $this->Model_barang_produksi->update_stok_bbp();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/barang_baku_untuk_produksi');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Barang Baku untuk produksi berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/barang_baku_untuk_produksi');
        }
    }
}
