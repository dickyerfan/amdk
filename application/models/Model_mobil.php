<?php
defined('BASEPATH') or exit('No direct script access allowed');

class model_mobil extends CI_Model
{
    public function get_mobil()
    {
        $this->db->select('*');
        $this->db->from('mobil');
        $this->db->join('karyawan', 'karyawan.id_karyawan = mobil.id_karyawan');
        // $this->db->where('status_mobil', 1);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_karyawan()
    {
        $this->db->select('id_karyawan, nama_karyawan');
        $this->db->from('karyawan');
        $this->db->where('jenis_kerja', 'Driver');
        $this->db->where('status', 1);
        $query = $this->db->get();
        return $query->result();
    }


    public function tambahData()
    {
        $data = [
            'nama_mobil' => $this->input->post('nama_mobil', true),
            'jenis_mobil' => $this->input->post('jenis_mobil', true),
            'plat_nomor' => $this->input->post('plat_nomor', true),
            'id_karyawan' => $this->input->post('id_karyawan', true)
        ];
        $this->db->insert('mobil', $data);
    }

    public function hapusData($id_mobil)
    {
        $this->db->where('id_mobil', $id_mobil);
        $this->db->delete('mobil');
    }

    public function getIdMobil($id_mobil)
    {
        return $this->db->get_where('mobil', ['id_mobil' => $id_mobil])->row();
    }

    public function updateData()
    {

        $data = [
            'nama_mobil' => $this->input->post('nama_mobil', true),
            'jenis_mobil' => $this->input->post('jenis_mobil', true),
            'plat_nomor' => $this->input->post('plat_nomor', true),
            'id_karyawan' => $this->input->post('id_karyawan', true),
            'status_mobil' => $this->input->post('status_mobil', true)
        ];
        $this->db->where('id_mobil', $this->input->post('id_mobil'));
        $this->db->update('mobil', $data);
    }
}
