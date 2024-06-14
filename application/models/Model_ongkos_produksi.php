<?php
defined('BASEPATH') or exit('No direct script access allowed');

class model_ongkos_produksi extends CI_Model
{
    public function get_ongkos_produksi()
    {
        $this->db->select('*');
        $this->db->from('ongkos_produksi');
        $this->db->join('jenis_produk', 'jenis_produk.id_produk = ongkos_produksi.id_jenis_barang');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_produk()
    {
        $this->db->select('id_produk, nama_produk');
        $this->db->from('jenis_produk');
        $query = $this->db->get();
        return $query->result();
    }


    public function tambahData()
    {
        $data = [
            'id_jenis_barang' => $this->input->post('id_jenis_barang', true),
            'ongkos_per_unit' => $this->input->post('ongkos_per_unit', true),
            'input_ongkos' => $this->session->userdata('nama_lengkap'),
            'tanggal_input_ongkos' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('ongkos_produksi', $data);
    }

    public function hapusData($id_ongkos_produksi)
    {
        $this->db->where('id_ongkos_produksi', $id_ongkos_produksi);
        $this->db->delete('ongkos_produksi');
    }

    public function updateData()
    {

        $data = [
            'id_jenis_barang' => $this->input->post('id_jenis_barang', true),
            'ongkos_per_unit' => $this->input->post('ongkos_per_unit', true),
            'input_ongkos' => $this->session->userdata('nama_lengkap'),
            'tanggal_input_ongkos' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_ongkos_produksi', $this->input->post('id_ongkos_produksi'));
        $this->db->update('ongkos_produksi', $data);
    }
}
