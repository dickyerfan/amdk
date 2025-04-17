<?php
defined('BASEPATH') or exit('No direct script access allowed');

class model_harga extends CI_Model
{
    public function get_harga()
    {
        $this->db->select('*');
        $this->db->from('harga');
        $this->db->join('jenis_produk', 'jenis_produk.id_produk = harga.id_jenis_barang');
        // $this->db->where('status_mobil', 1);
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
            'jenis_harga' => $this->input->post('jenis_harga', true),
            'harga' => $this->input->post('harga', true),
            'no_perkiraan' => $this->input->post('no_perkiraan', true),
            'input_harga' => $this->session->userdata('nama_lengkap'),
            'tgl_input_harga' => date('Y-m-d H:i:s')
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
            'harga' => $this->input->post('harga', true),
            'no_perkiraan' => $this->input->post('no_perkiraan', true),
            'input_harga' => $this->session->userdata('nama_lengkap'),
            'tgl_input_harga' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_harga', $this->input->post('id_harga'));
        $this->db->update('harga', $data);
    }

    public function get_harga_barang_baku()
    {
        $this->db->select('*');
        $this->db->from('harga_barang_baku');
        $this->db->join('barang_baku', 'barang_baku.id_barang_baku = harga_barang_baku.id_barang_baku');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_barang_baku()
    {
        $this->db->select('id_barang_baku, nama_barang_baku');
        $this->db->from('barang_baku');
        $query = $this->db->get();
        return $query->result();
    }

    public function tambah_harga_barang_baku()
    {
        $data = [
            'id_barang_baku' => $this->input->post('id_barang_baku', true),
            'harga' => $this->input->post('harga', true),
            'tanggal_berlaku' => $this->input->post('tanggal_berlaku', true),
            'input_harga_barang_baku' => $this->session->userdata('nama_lengkap'),
            'tanggal_input' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('harga_barang_baku', $data);
    }

    public function update_harga_barang_baku()
    {

        $data = [
            'id_barang_baku' => $this->input->post('id_barang_baku', true),
            'harga' => $this->input->post('harga', true),
            'tanggal_berlaku' => $this->input->post('tanggal_berlaku', true),
            'input_harga_barang_baku' => $this->session->userdata('nama_lengkap'),
            'tanggal_input' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_harga', $this->input->post('id_harga'));
        $this->db->update('harga_barang_baku', $data);
    }

    public function hapus_harga_barang_baku($id_harga)
    {
        $this->db->where('id_harga', $id_harga);
        $this->db->delete('harga_barang_baku');
    }
}
