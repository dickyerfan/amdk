<?php
defined('BASEPATH') or exit('No direct script access allowed');

class model_pegawai extends CI_Model
{
    public function getAll()
    {
        // $this->db->where('level', 'Admin');
        return $this->db->get('user')->result();
    }

    public function get_pegawai()
    {
        $this->db->select('*');
        $this->db->from('pegawai');
        $this->db->join('bagian', 'bagian.id_bagian = pegawai.id_bagian');
        $this->db->where('aktif', 1);
        $query = $this->db->get();
        return $query->result();
    }

    public function tambahData()
    {
        $data = [
            'id_bagian' => $this->input->post('id_bagian', true),
            'nama' => $this->input->post('nama', true),
            'alamat' => $this->input->post('alamat', true),
            'agama' => $this->input->post('agama', true),
            'nik' => $this->input->post('nik', true),
            'no_hp' => $this->input->post('no_hp', true),
            'jenkel' => $this->input->post('jenkel', true),
            'tarif' => $this->input->post('tarif', true),
        ];
        $this->db->insert('pegawai', $data);
    }

    public function hapusData($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('pegawai');
    }

    public function getIdAdmin($id)
    {
        return $this->db->get_where('pegawai', ['id' => $id])->row();
    }

    public function get_bagian()
    {
        return $this->db->get('bagian')->result();
    }

    public function updateData()
    {

        $data = [
            'id_bagian' => $this->input->post('id_bagian', true),
            'nama' => $this->input->post('nama', true),
            'alamat' => $this->input->post('alamat', true),
            'agama' => $this->input->post('agama', true),
            'nik' => $this->input->post('nik', true),
            'status_pegawai' => $this->input->post('status_pegawai', true),
            'aktif' => $this->input->post('aktif', true),
            'no_hp' => $this->input->post('no_hp', true),
            'jenkel' => $this->input->post('jenkel', true),
            'tarif' => $this->input->post('tarif', true),
        ];
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('pegawai', $data);
    }
}
