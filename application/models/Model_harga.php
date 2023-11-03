<?php
defined('BASEPATH') or exit('No direct script access allowed');

class model_harga extends CI_Model
{
    public function get_harga()
    {
        $this->db->select('*');
        $this->db->from('harga');
        $this->db->join('jenis_barang', 'jenis_barang.id_jenis_barang = harga.id_jenis_barang');
        // $this->db->where('status_mobil', 1);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_jenis_barang()
    {
        $this->db->select('id_jenis_barang, nama_barang_jadi');
        $this->db->from('jenis_barang');
        $query = $this->db->get();
        return $query->result();
    }


    public function tambahData()
    {
        $data = [
            'id_jenis_barang' => $this->input->post('id_jenis_barang', true),
            'jenis_harga' => $this->input->post('jenis_harga', true),
            'harga' => $this->input->post('harga', true),
            'input_harga' => $this->session->userdata('nama_lengkap')
        ];
        $this->db->insert('harga', $data);
    }

    public function hapusData($id_harga)
    {
        $this->db->where('id_harga', $id_harga);
        $this->db->delete('harga');
    }

    public function getIdharga($id_harga)
    {
        return $this->db->get_where('harga', ['id_harga' => $id_harga])->row();
    }

    public function updateData()
    {

        $data = [
            'id_jenis_barang' => $this->input->post('id_jenis_barang', true),
            'jenis_harga' => $this->input->post('jenis_harga', true),
            'harga' => $this->input->post('harga', true)
        ];
        $this->db->where('id_harga', $this->input->post('id_harga'));
        $this->db->update('harga', $data);
    }
}
