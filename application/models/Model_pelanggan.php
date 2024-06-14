<?php
defined('BASEPATH') or exit('No direct script access allowed');

class model_pelanggan extends CI_Model
{
    public function get_pelanggan()
    {
        $this->db->select('*');
        $this->db->from('pelanggan');
        $this->db->where('aktif', 1);
        $query = $this->db->get();
        return $query->result();
    }

    public function tambahData()
    {
        $data = [
            'area_pelanggan' => strtoupper($this->input->post('area_pelanggan', true)),
            'gol_pelanggan' => strtoupper($this->input->post('gol_pelanggan', true)),
            'nama_pelanggan' => strtoupper($this->input->post('nama_pelanggan', true)),
            'alamat_pelanggan' => strtoupper($this->input->post('alamat_pelanggan', true)),
            'telpon_pelanggan' => $this->input->post('telpon_pelanggan', true),
            'ket' => strtoupper($this->input->post('ket', true)),
            'tarif' => strtoupper($this->input->post('tarif', true)),
            'input_langgan' => $this->session->userdata('nama_lengkap'),
            'tgl_input' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('pelanggan', $data);
    }

    public function hapusData($id_pelanggan)
    {
        $this->db->where('id_pelanggan', $id_pelanggan);
        $this->db->delete('pelanggan');
    }

    public function getIdAdmin($id_pelanggan)
    {
        return $this->db->get_where('pelanggan', ['id_pelanggan' => $id_pelanggan])->row();
    }

    public function updateData()
    {

        $data = [
            'area_pelanggan' => strtoupper($this->input->post('area_pelanggan', true)),
            'gol_pelanggan' => strtoupper($this->input->post('gol_pelanggan', true)),
            'nama_pelanggan' => strtoupper($this->input->post('nama_pelanggan', true)),
            'alamat_pelanggan' => strtoupper($this->input->post('alamat_pelanggan', true)),
            'telpon_pelanggan' => $this->input->post('telpon_pelanggan', true),
            'ket' => $this->input->post('ket', true),
            'tarif' => $this->input->post('tarif', true),
            'aktif' => $this->input->post('aktif', true),
            'input_langgan' => $this->session->userdata('nama_lengkap'),
            'tgl_input' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_pelanggan', $this->input->post('id_pelanggan'));
        $this->db->update('pelanggan', $data);
    }
}
