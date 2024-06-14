<?php
defined('BASEPATH') or exit('No direct script access allowed');

class model_produk extends CI_Model
{
    public function get_produk()
    {
        $this->db->select('*');
        $this->db->from('jenis_produk');
        // $this->db->join('jenis_barang', 'jenis_barang.id_jenis_barang = harga.id_jenis_barang');
        // $this->db->where('status_mobil', 1);
        $query = $this->db->get();
        return $query->result();
    }

    public function tambahData()
    {
        $data = [
            'nama_produk' => $this->input->post('nama_produk', true),
            'jenis_produk' => $this->input->post('jenis_produk', true),
            'input_produk' => $this->session->userdata('nama_lengkap'),
            'tgl_input_produk' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('jenis_produk', $data);
    }

    public function hapusData($id_produk)
    {
        $this->db->where('id_produk', $id_produk);
        $this->db->delete('jenis_produk');
    }

    public function get_id_produk($id_produk)
    {
        return $this->db->get_where('jenis_produk', ['id_produk' => $id_produk])->row();
    }

    public function updateData()
    {

        $data = [
            'nama_produk' => $this->input->post('nama_produk', true),
            'jenis_produk' => $this->input->post('jenis_produk', true),
            'input_produk' => $this->session->userdata('nama_lengkap'),
            'tgl_input_produk' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_produk', $this->input->post('id_produk'));
        $this->db->update('jenis_produk', $data);
    }
}
