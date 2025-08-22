<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kegiatan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_kegiatan');
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

        $data['title'] = 'Data Kegiatan';
        $data['kegiatan'] = $this->Model_kegiatan->getAll();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('manager/kegiatan/view_kegiatan', $data);
        $this->load->view('templates/footer');
    }
    // public function tambah()
    // {
    //     $this->form_validation->set_rules('nama_kegiatan', 'Nama Kegiatan', 'required|trim|is_unique[kegiatan.nama_kegiatan]');
    //     $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required|trim');
    //     $this->form_validation->set_message('required', '%s harus di isi');
    //     $this->form_validation->set_message('is_unique', '%s sudah terdaftar');

    //     if ($this->form_validation->run() == false) {
    //         $data['title'] = 'Upload Data';
    //         $this->load->view('templates/header', $data);
    //         $this->load->view('templates/navbar');
    //         $this->load->view('templates/sidebar');
    //         $this->load->view('manager/kegiatan/view_tambah_kegiatan', $data);
    //         $this->load->view('templates/footer');
    //     } else {
    //         $insert = [
    //             'nama_kegiatan' => $this->input->post('nama_kegiatan'),
    //             'deskripsi'     => $this->input->post('deskripsi'),
    //             'ketua_tim'     => $this->input->post('ketua_tim')
    //         ];
    //         $this->Model_kegiatan->insert($insert);
    //         redirect('manager/kegiatan');
    //     }
    // }
    public function tambah()
    {
        if ($this->input->post()) {
            $insert = [
                'nama_kegiatan' => $this->input->post('nama_kegiatan'),
                'deskripsi'     => $this->input->post('deskripsi'),
                'ketua_tim'     => $this->input->post('ketua_tim')
            ];
            $this->Model_kegiatan->insert($insert);
            redirect('manager/kegiatan');
        }
        $data['title'] = 'Upload Data';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('manager/kegiatan/view_tambah_kegiatan', $data);
        $this->load->view('templates/footer');
    }

    public function detail($id)
    {
        $data['kegiatan'] = $this->Model_kegiatan->getById($id);
        $tahapan = $this->Model_kegiatan->getByKegiatan($id);

        foreach ($tahapan as $t) {
            $t->foto = $this->Model_kegiatan->getByTahapan($t->id);
        }
        $data['tahapan'] = $tahapan;
        $data['title'] = 'Detail Kegiatan';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('manager/kegiatan/view_detail', $data);
        $this->load->view('templates/footer');
    }

    public function tambah_tahapan($id_kegiatan)
    {
        if ($this->input->post()) {
            $insert = [
                'id_kegiatan'       => $id_kegiatan,
                'judul_tahapan'     => $this->input->post('judul_tahapan'),
                'deskripsi_tahapan' => $this->input->post('deskripsi_tahapan'),
                'tanggal'           => $this->input->post('tanggal')
            ];
            $id_tahapan = $this->Model_kegiatan->insert_tahapan($insert);

            // Upload foto
            if (!empty($_FILES['foto']['name'][0])) {
                $filesCount = count($_FILES['foto']['name']);
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file']['name']     = $_FILES['foto']['name'][$i];
                    $_FILES['file']['type']     = $_FILES['foto']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['foto']['tmp_name'][$i];
                    $_FILES['file']['error']    = $_FILES['foto']['error'][$i];
                    $_FILES['file']['size']     = $_FILES['foto']['size'][$i];

                    $config['upload_path']   = './uploads/tahapan/';
                    $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                    $config['max_size']      = 2048;

                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('file')) {
                        $fileData = $this->upload->data();
                        $this->Model_kegiatan->insert_foto([
                            'id_tahapan' => $id_tahapan,
                            'nama_file'  => $fileData['file_name']
                        ]);
                    }
                }
            }
            redirect('manager/kegiatan/detail/' . $id_kegiatan);
        }

        $data['id_kegiatan'] = $id_kegiatan;
        $data['title'] = 'Tambah Tahapan Kegiatan';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('manager/kegiatan/view_tambah_tahapan', $data);
        $this->load->view('templates/footer');
    }

    public function edit($id_arsip)
    {

        $data['arsip'] = $this->db->get_where('arsip', ['id_arsip' => $id_arsip])->row();
        $data['title'] = 'Form Edit Data';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('manager/arsip/view_edit_arsip', $data);
        $this->load->view('templates/footer');
    }

    public function update()
    {
        $data = [
            'nama_dokumen' => $this->input->post('nama_dokumen'),
            'jenis' => $this->input->post('jenis'),
            'tahun' => $this->input->post('tahun'),
            'tentang' => $this->input->post('tentang'),
            'tgl_dokumen' => $this->input->post('tgl_dokumen'),
            'keterangan' => $this->input->post('keterangan')
        ];

        $this->db->where('id_arsip', $this->input->post('id_arsip'));
        $this->db->update('arsip', $data);

        if ($this->db->affected_rows() <= 0) {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>Maaf,</strong> tidak ada perubahan data
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                  </button>
                </div>'
            );
            redirect('manager/arsip');
        } else {
            $this->session->set_flashdata(
                'info',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses,</strong> Data berhasil di update
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
              </div>'
            );
            redirect('manager/arsip');
        }
    }

    public function hapus($id_arsip)
    {
        $cekFileLama = $this->db->get_where('arsip', ['id_arsip' => $id_arsip])->row();

        if (isset($cekFileLama->nama_file)) {
            unlink('uploads/arsip/' . $cekFileLama->nama_file);
        }

        $this->db->where('id_arsip', $id_arsip);
        $this->db->delete('arsip');

        $this->session->set_flashdata(
            'info',
            '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Sukses,</strong> File/Dokumen berhasil di hapus
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
            </button>
          </div>'
        );
        redirect('manager/arsip');
    }
}
