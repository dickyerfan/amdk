<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ongkos_produksi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_ongkos_produksi');
        $this->load->library('form_validation');
        if (!$this->session->userdata('nama_pengguna')) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> Anda harus login untuk akses halaman ini...
                      </div>'
            );
            redirect('auth');
        }
        if ($this->session->userdata('level') != 'Admin') {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> Anda harus login sebagai Manager...
                      </div>'
            );
            redirect('auth');
        }
    }

    public function index()
    {
        $data['title'] = "Daftar Harga Produk Ijen Water";
        $data['ongkos_produksi'] = $this->Model_ongkos_produksi->get_ongkos_produksi();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('manager/view_ongkos_produksi', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['title'] = "Tambah Daftar Ongkos Produksi";
        $data['barang'] = $this->Model_ongkos_produksi->get_produk();
        $this->form_validation->set_rules('id_jenis_barang', 'Jenis Barang', 'required|trim');
        $this->form_validation->set_rules('ongkos_per_unit', 'Ongkos Produksi', 'required|trim');

        $this->form_validation->set_message('required', '%s masih kosong');
        // $this->form_validation->set_message('is_unique', '%s Sudah terdaftar, Ganti yang lain');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/navbar');
            $this->load->view('templates/sidebar');
            $this->load->view('manager/view_tambah_ongkos_produksi', $data);
            $this->load->view('templates/footer');
        } else {
            $data['user'] = $this->Model_ongkos_produksi->tambahData();
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Daftar ongkos produksi baru berhasil di tambah
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/ongkos_produksi');
        }
    }

    public function edit($id_ongkos_produksi)
    {
        $data['title'] = "Form Edit Ongkos Produksi";
        $data['edit_ongkos_produksi'] = $this->db->get_where('ongkos_produksi', ['id_ongkos_produksi' => $id_ongkos_produksi])->row();
        $data['barang'] = $this->Model_ongkos_produksi->get_produk();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('manager/view_edit_ongkos_produksi', $data);
        $this->load->view('templates/footer');
    }

    public function update()
    {
        $this->Model_ongkos_produksi->updateData();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/ongkos_produksi');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Daftar ongkos produksi berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/ongkos_produksi');
        }
    }

    public function hapus($id_ongkos_produksi)
    {
        $this->Model_ongkos_produksi->hapusData($id_ongkos_produksi);
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Sukses,</strong> Daftar ongkos produksi berhasil di hapus
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                  </div>'
        );
        redirect('manager/ongkos_produksi');
    }
}
