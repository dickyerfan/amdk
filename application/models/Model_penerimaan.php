<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_penerimaan extends CI_Model
{

    public function get_all($tanggal)
    {
        $this->db->select(
            '*,
        (SELECT SUM(total_harga) FROM pemesanan WHERE DATE(pemesanan.tanggal_bayar) = "' . $tanggal . '" AND pemesanan.status_bayar = 1) AS total_penerimaan'
        );
        $this->db->from('pemesanan');
        $this->db->join('jenis_produk', 'jenis_produk.id_produk = pemesanan.id_jenis_barang', 'left');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan', 'left');
        $this->db->where('DATE(pemesanan.tanggal_bayar)', $tanggal);
        $this->db->where('status_bayar', 1);
        $this->db->order_by('pemesanan.id_pemesanan', 'DESC');
        return $this->db->get()->result();
    }

    // public function get_all($bulan, $tahun)
    // {
    //     $this->db->select(
    //         '*,
    //     (SELECT SUM(total_harga) FROM pemesanan WHERE MONTH(pemesanan.tanggal_bayar) = "' . $bulan . '" AND YEAR(pemesanan.tanggal_bayar) = "' . $tahun . '" AND pemesanan.status_bayar = 1) AS total_penerimaan'
    //     );
    //     $this->db->from('pemesanan');
    //     $this->db->join('jenis_produk', 'jenis_produk.id_produk = pemesanan.id_jenis_barang', 'left');
    //     $this->db->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan', 'left');
    //     $this->db->where('MONTH(pemesanan.tanggal_bayar)', $bulan);
    //     $this->db->where('YEAR(pemesanan.tanggal_bayar)', $tahun);
    //     $this->db->where('status_bayar', 1);
    //     $this->db->order_by('pemesanan.id_pemesanan', 'DESC');
    //     return $this->db->get()->result();
    // }
}
