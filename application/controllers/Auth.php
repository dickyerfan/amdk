<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_auth');
        $this->load->library('form_validation');
        header('Access-Control-Allow-Origin: *'); // Allow all origins
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');

    }

    public function index()
    {
        $this->form_validation->set_rules('nama_user', 'Nama User', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $this->form_validation->set_message('required', '%s masih kosong');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login';
            $this->load->view('auth/view_login', $data);
        } else {
            $nama_user = $this->input->post('nama_user');
            $password = $this->input->post('password');

            $this->db->from('user');
            $this->db->where('nama_user', $nama_user);
            $this->db->where('status', 1);
            $query = $this->db->get();
            $users = $query->result();

            $user_found = false;

            foreach ($users as $user) {
                if (password_verify($password, $user->password)) {
                    $user_found = true;

                    $data_session = [
                        'user_id' => $user->id,
                        'nama_pengguna' => $user->nama_pengguna,
                        'nik_karyawan' => $user->nik_karyawan,
                        'nama_user' => $user->nama_user,
                        'nama_lengkap' => $user->nama_lengkap,
                        'upk_bagian' => $user->upk_bagian,
                        'password' => $user->password,
                        'level' => $user->level,
                        'tipe' => $user->tipe
                    ];

                    $this->session->set_userdata($data_session);

                    $user_agent = $this->input->user_agent();
                    $ip_address = $this->input->ip_address();
                    // $ip_address = $this->get_client_ip();
                    $this->model_auth->log_activity($user->id, 'login', $user_agent, $ip_address);

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
                $this->session->set_flashdata('info', '<div class="alert alert-danger" role="alert">Login Gagal, Nama User tidak valid.!</div>');
                redirect('auth');
            }
        }
    }

    public function logout()
    {

        $user_id = $this->session->userdata('user_id');
        if ($user_id) {
            $user_agent = $this->input->user_agent();
            $ip_address = $this->input->ip_address();
            // $ip_address = $this->get_client_ip();
            $this->model_auth->log_activity($user_id, 'logout', $user_agent, $ip_address);
        }

        $this->session->unset_userdata('nama_pengguna');
        $this->session->unset_userdata('nama_user');
        $this->session->unset_userdata('nama_lengkap');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('password');
        $this->session->unset_userdata('level');
        $this->session->unset_userdata('tipe');

        $this->session->set_flashdata('info', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Selamat,</strong> Anda Berhasil Logout.!
        </div>');
        redirect('auth');
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
            case 'kas':
                redirect('keuangan/kas');
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

    public function login_api()
    {
        $this->form_validation->set_rules('nama_user', 'Nama User', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $this->form_validation->set_message('required', '%s masih kosong');

        if ($this->form_validation->run() == false) {
            $error = strip_tags(validation_errors());
            $response = array('status' => false, 'message'  => $error);
            echo json_encode($response);
            return;
        }

        $nama_user = $this->input->post('nama_user');
        $password = $this->input->post('password');

        $this->db->from('user');
        $this->db->where('nama_user', $nama_user);
        $this->db->where('status', 1);
        $query = $this->db->get();
        $users = $query->result();

        $user_found = false;

        foreach ($users as $user) {
            if (password_verify($password, $user->password)) {
                $user_found = true;

                $data_session = [
                    'user_id' => $user->id,
                    'nama_pengguna' => $user->nama_pengguna,
                    'nik_karyawan' => $user->nik_karyawan,
                    'nama_user' => $user->nama_user,
                    'nama_lengkap' => $user->nama_lengkap,
                    'upk_bagian' => $user->upk_bagian,
                    'password' => $user->password,
                    'level' => $user->level
                ];

                $this->session->set_userdata($data_session);

                // $user_agent = $this->input->user_agent();
                // $ip_address = $this->input->ip_address();
                // $this->model_auth->log_activity($user->id, 'login', $user_agent, $ip_address);

                $response = array('status' => true, 'message' => 'Login successful', 'data' => $data_session);
                echo json_encode($response);
                return;
            } else {
                $response = array('status' => false, 'message' => 'Password tidak valid.');
                echo json_encode($response);
                return;
            }
        }

        if (!$user_found) {
            $response = array('status' => false, 'message' => 'Nama User tidak valid.');
            echo json_encode($response);
        }
    }


    public function api_login()
    {
        header('Content-Type: application/json');

        $nama_user = $this->input->post('nama_user');
        $password = $this->input->post('password');

        $this->db->from('user');
        $this->db->where('nama_user', $nama_user);
        $this->db->where('status', 1);
        $query = $this->db->get();
        $user = $query->row();

        if ($user && password_verify($password, $user->password)) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Login berhasil',
                'data' => [
                    'user_id' => $user->id,
                    'nama_user' => $user->nama_user,
                    'nama_lengkap' => $user->nama_lengkap,
                    'level' => $user->level
                ]
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Nama user atau password salah'
            ]);
        }
    }

}
