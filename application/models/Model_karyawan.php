<?php
defined('BASEPATH') or exit('No direct script access allowed');

class model_karyawan extends CI_Model
{
    public function getAll()
    {
        // $this->db->where('level', 'Admin');
        return $this->db->get('user')->result();
    }

    public function get_karyawan()
    {
        $this->db->select('*');
        $this->db->from('karyawan');
        $this->db->where('status', 1);
        $query = $this->db->get();
        return $query->result();
    }

    public function tambahData()
    {
        $data = [
            'nama_karyawan' => $this->input->post('nama_karyawan', true),
            'nik_karyawan' => $this->input->post('nik_karyawan', true),
            'bagian' => $this->input->post('bagian', true),
            'jabatan' => $this->input->post('jabatan', true),
            'jenkel' => $this->input->post('jenkel', true),
            'jenis_kerja' => $this->input->post('jenis_kerja', true),
            'petugas_input' => $this->session->userdata('nama_lengkap'),
            'tgl_input' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('karyawan', $data);
    }

    public function hapusData($id_karyawan)
    {
        $this->db->where('id_karyawan', $id_karyawan);
        $this->db->delete('karyawan');
    }

    public function getIdAdmin($id_karyawan)
    {
        return $this->db->get_where('karyawan', ['id_karyawan' => $id_karyawan])->row();
    }

    public function updateData()
    {

        $data = [
            'nama_karyawan' => $this->input->post('nama_karyawan', true),
            'nik_karyawan' => $this->input->post('nik_karyawan', true),
            'bagian' => $this->input->post('bagian', true),
            'jabatan' => $this->input->post('jabatan', true),
            'jenkel' => $this->input->post('jenkel', true),
            'jenis_kerja' => $this->input->post('jenis_kerja', true),
            'petugas_input' => $this->session->userdata('nama_lengkap'),
            'tgl_input' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_karyawan', $this->input->post('id_karyawan'));
        $this->db->update('karyawan', $data);
    }
}
