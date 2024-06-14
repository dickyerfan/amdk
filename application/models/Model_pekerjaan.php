<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_pekerjaan extends CI_Model
{
    public function getAll()
    {
        return $this->db->get('jabatan')->result();
    }

    public function getAllSubag()
    {
        return $this->db->get('subag')->result();
    }

    public function getAllBagian()
    {
        return $this->db->get('bagian')->result();
    }

    // Jabatan
    public function tambahDataJabatan()
    {
        $data = [
            "nama_jabatan" => $this->input->post('nama_jabatan', true),
        ];
        $this->db->insert('jabatan', $data);
    }

    // public function getIdJabatan($id)
    // {
    //     return $this->db->get_where('jabatan', ['id_jabatan' => $id])->row();
    // }

    public function getJabatan()
    {
        $this->db->select('*');
        $this->db->from('jabatan');
        return $this->db->get()->result();
    }

    public function updateDataJabatan()
    {
        $data = [
            "nama_jabatan" => $this->input->post('nama_jabatan', true),
        ];
        $this->db->where('id_jabatan', $this->input->post('id_jabatan'));
        $this->db->update('jabatan', $data);
    }

    public function hapusDataJabatan($id)
    {
        $this->db->where('id_jabatan', $id);
        $this->db->delete('jabatan');
    }

    // Bagian

    public function tambahDataBagian()
    {
        $data = [
            "nama_bagian" => $this->input->post('nama_bagian', true),
        ];
        $this->db->insert('bagian', $data);
    }

    public function getBagian()
    {
        $this->db->select('*');
        $this->db->from('bagian');
        return $this->db->get()->result();
    }

    public function updateDataBagian()
    {
        $data = [
            "nama_bagian" => $this->input->post('nama_bagian', true),
        ];
        $this->db->where('id_bagian', $this->input->post('id_bagian'));
        $this->db->update('bagian', $data);
    }

    public function hapusDataBagian($id)
    {
        $this->db->where('id_bagian', $id);
        $this->db->delete('bagian');
    }

    // Subag

    public function tambahDataSubag()
    {
        $data = [
            "nama_subag" => $this->input->post('nama_subag', true),
        ];
        $this->db->insert('subag', $data);
    }

    public function getSubag()
    {
        $this->db->select('*');
        $this->db->from('subag');
        return $this->db->get()->result();
    }

    public function updateDataSubag()
    {
        $data = [
            "nama_subag" => $this->input->post('nama_subag', true),
        ];
        $this->db->where('id_subag', $this->input->post('id_subag'));
        $this->db->update('subag', $data);
    }

    public function hapusDataSubag($id)
    {
        $this->db->where('id_subag', $id);
        $this->db->delete('subag');
    }
}
