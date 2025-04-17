<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_auth extends CI_Model
{
    public function log_activity($id, $aktivitas, $user_agent, $ip_address)
    {
        $data = array(
            'id' => $id,
            'aktivitas' => $aktivitas,
            'waktu' => date('Y-m-d H:i:s'),
            'user_agent' => $user_agent,
            'ip_address' => $ip_address
        );
        $this->db->insert('user_log', $data);
    }

    public function get_all_log($tanggal)
    {
        $this->db->select('user_log.*, user.nama_lengkap');
        $this->db->from('user_log');
        $this->db->join('user', 'user.id = user_log.id');
        $this->db->where('DATE(user_log.waktu)', $tanggal);
        $this->db->order_by('id_user_log', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_user_by_username($nama_user)
    {
        return $this->db->get_where('user', array('nama_user' => $nama_user))->row();
    }

    // public function get_user_by_nama_user($nama_user)
    // {
    //     $this->db->from('user');
    //     $this->db->where('nama_user', $nama_user);
    //     $this->db->where('status', 1);
    //     $query = $this->db->get();
    //     return $query->row();
    // }

    // public function registrasi()
    // {
    //     $data = [
    //         'nama_pengguna' => $this->input->post('nama_pengguna', true),
    //         'nama_lengkap' => $this->input->post('nama_lengkap', true),
    //         'upk_bagian' => $this->input->post('upk_bagian', true),
    //         'password' => password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
    //         'level' => $this->input->post('level', true),
    //     ];

    //     return $this->db->insert('user', $data);
    // }
}
