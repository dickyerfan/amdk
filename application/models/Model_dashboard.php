<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_dashboard extends CI_Model
{

    public function get_barang_jadi_dashboard($tanggal)
    {
        $this->db->select('jenis_barang.nama_barang_jadi, COALESCE(SUM(barang_jadi.jumlah_barang_jadi), 0) as total');
        $this->db->from('jenis_barang');
        $this->db->join('barang_jadi', 'barang_jadi.id_jenis_barang = jenis_barang.id_jenis_barang AND barang_jadi.tanggal_barang_jadi = "' . $tanggal . '"', 'left');
        $this->db->group_by('jenis_barang.nama_barang_jadi');
        $this->db->order_by('jenis_barang.id_jenis_barang');
        return $this->db->get()->result();
    }

    public function get_penjualan_dashboard($tanggal)
    {
        $this->db->select('jenis_barang.nama_barang_jadi, COALESCE(SUM(pemesanan.jumlah_pesan), 0) as total');
        $this->db->from('jenis_barang');
        // $this->db->join('pemesanan', 'jenis_barang.id_jenis_barang = pemesanan.id_jenis_barang AND pemesanan.tanggal_pesan = "' . $tanggal . '" AND pemesanan.status_nota = 1', 'left');
        $this->db->join('pemesanan', 'jenis_barang.id_jenis_barang = pemesanan.id_jenis_barang AND pemesanan.tanggal_pesan = "' . $tanggal . '" AND pemesanan.id_mobil IS NOT NULL', 'left');
        $this->db->group_by('jenis_barang.nama_barang_jadi');
        $this->db->order_by('jenis_barang.id_jenis_barang');
        return $this->db->get()->result();
    }
}
