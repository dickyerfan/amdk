<?php
defined('BASEPATH') or exit('No direct script access allowed');

class model_riwayat extends CI_Model
{
    public function get_riwayat()
    {
        $this->db->select('*');
        $this->db->from('pelanggan');
        $this->db->where('aktif', 1);
        $this->db->where('id_pelanggan !=', 1);
        $this->db->where('id_pelanggan !=', 2);
        $query = $this->db->get();
        return $query->result();
    }
    public function get_detail_riwayat($id_pelanggan)
    {
        $this->db->select('*');
        $this->db->from('pemesanan');
        $this->db->join('jenis_produk', 'jenis_produk.id_produk = pemesanan.id_jenis_barang');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan');
        $this->db->where('pemesanan.id_pelanggan', $id_pelanggan);
        $this->db->order_by('tanggal_pesan', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }
    public function get_pelanggan($id_pelanggan)
    {
        $this->db->select('*');
        $this->db->from('pemesanan');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan');
        $this->db->where('pemesanan.id_pelanggan', $id_pelanggan);
        $this->db->order_by('tanggal_pesan', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }

   
}
