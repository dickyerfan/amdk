<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jam_lunas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_setting');
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
        $data['title'] = "Setting Batas Jam Pelunasan";
        $data['jam_lunas'] = $this->Model_setting->get_jam_lunas();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('manager/view_jam_lunas', $data);
        $this->load->view('templates/footer');
    }

    // public function tambah()
    // {
    //     $data['title'] = "Tambah Daftar Harga";
    //     $data['barang'] = $this->Model_harga->get_produk();
    //     $this->form_validation->set_rules('id_jenis_barang', 'Jenis Barang', 'required|trim');
    //     $this->form_validation->set_rules('jenis_harga', 'Jenis Harga', 'required|trim');
    //     $this->form_validation->set_rules('harga', 'harga', 'required|trim');
    //     $this->form_validation->set_rules('no_perkiraan', 'no_perkiraan', 'required|trim');

    //     $this->form_validation->set_message('required', '%s masih kosong');
    //     // $this->form_validation->set_message('is_unique', '%s Sudah terdaftar, Ganti yang lain');

    //     if ($this->form_validation->run() == false) {
    //         $this->load->view('templates/header', $data);
    //         $this->load->view('templates/navbar');
    //         $this->load->view('templates/sidebar');
    //         $this->load->view('manager/view_tambah_harga', $data);
    //         $this->load->view('templates/footer');
    //     } else {
    //         $data['user'] = $this->Model_harga->tambahData();
    //         $this->session->set_flashdata(
    //             'info',
    //             '<div class="alert alert-primary alert-dismissible fade show" role="alert">
    //                     <strong>Sukses,</strong> Daftar harga baru berhasil di tambah
    //                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    //                     </button>
    //                   </div>'
    //         );
    //         redirect('manager/harga');
    //     }
    // }

    public function edit($id_jam_lunas)
    {
        $data['title'] = "Form Edit Batas Jam Pelunasan";
        $data['edit_jam_lunas'] = $this->db->get_where('jam_lunas', ['id_jam_lunas' => $id_jam_lunas])->row();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('manager/view_edit_jam_lunas', $data);
        $this->load->view('templates/footer');
    }

    public function update()
    {
        $this->Model_setting->updateData();
        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Maaf,</strong> tidak ada perubahan data
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/harga');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses,</strong> Jam Pelunasan berhasil di update
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                      </div>'
            );
            redirect('manager/jam_lunas');
        }
    }

    public function hapus($id_mobil)
    {
        $this->Model_harga->hapusData($id_mobil);
        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Sukses,</strong> Daftar harga berhasil di hapus
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                  </div>'
        );
        redirect('manager/harga');
    }
}
