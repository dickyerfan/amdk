<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_auth');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->form_validation->set_rules('upk_bagian', 'Nama Bagian', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $this->form_validation->set_message('required', '%s masih kosong');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login';
            $this->load->view('auth/view_login', $data);
        } else {
            $upk_bagian = $this->input->post('upk_bagian');
            $password = $this->input->post('password');

            $this->db->from('user');
            $this->db->where('upk_bagian', $upk_bagian);
            $this->db->where('status', 1);
            $query = $this->db->get();
            $users = $query->result();

            $user_found = false;

            foreach ($users as $user) {
                if (password_verify($password, $user->password)) {
                    $user_found = true;

                    $data_session = [
                        'nama_pengguna' => $user->nama_pengguna,
                        'nik_karyawan' => $user->nik_karyawan,
                        'nama_lengkap' => $user->nama_lengkap,
                        'upk_bagian' => $user->upk_bagian,
                        'password' => $user->password,
                        'level' => $user->level,
                        'tipe' => $user->tipe
                    ];

                    $this->session->set_userdata($data_session);
                    $this->session->set_flashdata('info', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Selamat,</strong> Anda Berhasil Login
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>');

                    // Redirect to appropriate page based on 'upk_bagian'
                    $this->redirectBasedOnUpkBagian($user->upk_bagian);
                } else {
                    $this->session->set_flashdata('info', '<div class="alert alert-danger" role="alert">Login Gagal, Password Anda tidak valid.!</div>');
                    redirect('auth');
                }
            }

            if (!$user_found) {
                $this->session->set_flashdata('info', '<div class="alert alert-danger" role="alert">Login Gagal, Nama Bagian tidak valid.!</div>');
                redirect('auth');
            }
        }
    }

    // Fungsi bantuan untuk melakukan redirect berdasarkan 'upk_bagian'
    private function redirectBasedOnUpkBagian($upk_bagian)
    {
        switch ($upk_bagian) {
            case 'admin':
            case 'dicky':
                redirect('dashboard');
                break;
            case 'baku':
                redirect('barang_baku/baku');
                break;
            case 'jadi':
                redirect('barang_jadi/jadi');
                break;
            case 'produksi':
                redirect('barang_produksi/produksi');
                break;
            case 'uang':
                redirect('keuangan/uang');
                break;
            case 'pasar':
                redirect('pemasaran/pasar');
                break;
            case 'kontrol':
                redirect('Q_control/kontrol');
                break;
            default:
                // Redirect ke halaman default jika 'upk_bagian' tidak cocok dengan kasus apa pun
                redirect('auth');
                break;
        }
    }


    public function registrasi()
    {
        if ($this->session->userdata('nama_pengguna')) {
            redirect('dashboard');
        }
        $this->form_validation->set_rules('nama_pengguna', 'Nama Pengguna', 'required|trim|min_length[5]|is_unique[user.nama_pengguna]');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('email', 'email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[5]');

        $this->form_validation->set_message('required', '%s masih kosong');
        $this->form_validation->set_message('valid_email', '%s Harus Valid');
        $this->form_validation->set_message('is_unique', '%s Sudah terdaftar, Ganti yang lain');
        $this->form_validation->set_message('min_length', '%s Minimal 5 karakter');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Registrasi';
            $this->load->view('auth/view_registrasi', $data);
        } else {
            $this->model_auth->registrasi();
            redirect('auth');
        }
    }

    public function logout()
    {

        $this->session->unset_userdata('nama_pengguna');
        $this->session->unset_userdata('nama_lengkap');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('password');
        $this->session->unset_userdata('level');
        $this->session->unset_userdata('tipe');

        $this->session->set_flashdata('info', '<div class="alert alert-success" role="alert">Selamat, Anda Berhasil Logout!</div>');
        redirect('auth');
    }
}
