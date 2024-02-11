<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_piutang extends CI_Model
{

    public function get_all($bulan, $tahun)
    {
        $this->db->select(
            '*,
        (SELECT SUM(total_harga) FROM pemesanan WHERE MONTH(pemesanan.tanggal_pesan) = "' . $bulan . '" AND YEAR(pemesanan.tanggal_pesan) = "' . $tahun . '" AND pemesanan.status_bayar = 0 AND pemesanan.jenis_pesanan != 1) AS total_piutang'
        );
        $this->db->from('pemesanan');
        $this->db->join('jenis_produk', 'jenis_produk.id_produk = pemesanan.id_jenis_barang', 'left');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan', 'left');
        $this->db->join('mobil', 'mobil.id_mobil = pemesanan.id_mobil', 'left');
        $this->db->where('MONTH(pemesanan.tanggal_pesan)', $bulan);
        $this->db->where('YEAR(pemesanan.tanggal_pesan)', $tahun);
        $this->db->where('status_bayar', 0);
        $this->db->where('jenis_pesanan !=', 1);
        // $this->db->or_where('jenis_pesanan', 4);
        $this->db->order_by('pemesanan.id_pemesanan', 'DESC');
        return $this->db->get()->result();
    }

    public function get_by_date($tanggal)
    {
        $this->db->select(
            '*,
        (SELECT SUM(total_harga) FROM pemesanan WHERE DATE(pemesanan.tanggal_pesan) = "' . $tanggal . '"  AND pemesanan.status_bayar = 0 AND pemesanan.jenis_pesanan != 1) AS total_piutang'
        );
        $this->db->from('pemesanan');
        $this->db->join('jenis_produk', 'jenis_produk.id_produk = pemesanan.id_jenis_barang', 'left');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan', 'left');
        $this->db->join('mobil', 'mobil.id_mobil = pemesanan.id_mobil', 'left');
        $this->db->where('DATE(pemesanan.tanggal_pesan)', $tanggal);
        $this->db->where('status_bayar', 0);
        $this->db->where('jenis_pesanan !=', 1);
        // $this->db->or_where('jenis_pesanan', 4);
        $this->db->order_by('pemesanan.id_pemesanan', 'DESC');
        return $this->db->get()->result();
    }
}
