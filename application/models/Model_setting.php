<?php
defined('BASEPATH') or exit('No direct script access allowed');

class model_setting extends CI_Model
{
    public function get_jam_lunas()
    {
        $this->db->select('*');
        $this->db->from('jam_lunas');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_deadline_time()
    {
        $this->db->where('nama_setting', 'deadline_time');
        $query = $this->db->get('jam_lunas');
        return $query->row()->jam_setting;
    }

    // public function tambahData()
    // {
    //     $data = [
    //         'id_jenis_barang' => $this->input->post('id_jenis_barang', true),
    //         'jenis_harga' => $this->input->post('jenis_harga', true),
    //         'harga' => $this->input->post('harga', true),
    //         'no_perkiraan' => $this->input->post('no_perkiraan', true),
    //         'input_harga' => $this->session->userdata('nama_lengkap'),
    //         'tgl_input_harga' => date('Y-m-d H:i:s')
    //     ];
    //     $this->db->insert('harga', $data);
    // }

    public function hapusData($id_jam_lunas)
    {
        $this->db->where('id_jam_lunas', $id_jam_lunas);
        $this->db->delete('jam_lunas');
    }

    public function updateData()
    {

        $data = [
            'id_jam_lunas' => $this->input->post('id_jam_lunas', true),
            // 'nama_setting' => $this->input->post('nama_setting', true),
            'jam_setting' => $this->input->post('jam_setting', true),
            'input_setting' => $this->session->userdata('nama_lengkap'),
            'tanggal_setting' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_jam_lunas', $this->input->post('id_jam_lunas'));
        $this->db->update('jam_lunas', $data);
    }
}
