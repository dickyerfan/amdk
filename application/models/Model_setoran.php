<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_setoran extends CI_Model
{

    public function get_setoran($tanggal)
    {
        $this->db->select(
            '*,
        (SELECT SUM(total_harga) FROM pemesanan WHERE pemesanan.status_setoran_driver = 1 AND pemesanan.jenis_pesanan = 2 AND pemesanan.tgl_setoran_driver = "' . $tanggal . '") AS total_setoran'
        );
        $this->db->from('pemesanan');
        $this->db->join('mobil', 'mobil.id_mobil = pemesanan.id_mobil', 'left');
        $this->db->join('jenis_produk', 'jenis_produk.id_produk = pemesanan.id_jenis_barang', 'left');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan', 'left');
        $this->db->where('pemesanan.tgl_setoran_driver', $tanggal);
        $this->db->where('jenis_pesanan', 2);
        $this->db->where('status_setoran_driver', 1);
        $this->db->order_by('pemesanan.id_pemesanan', 'DESC');
        return $this->db->get()->result();
    }

    public function get_setoran_by_driver($tanggal, $nama_driver)
    {
        $this->db->select(
            '*,
        (SELECT SUM(total_harga) FROM pemesanan WHERE pemesanan.input_setoran_driver = "' . $nama_driver . '"  AND pemesanan.status_setoran_driver = 1 AND pemesanan.jenis_pesanan = 2 AND pemesanan.tgl_setoran_driver = "' . $tanggal . '") AS total_setoran_driver'
        );
        $this->db->from('pemesanan');
        $this->db->join('mobil', 'mobil.id_mobil = pemesanan.id_mobil', 'left');
        $this->db->join('jenis_produk', 'jenis_produk.id_produk = pemesanan.id_jenis_barang', 'left');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan', 'left');
        $this->db->join('user', 'user.nama_lengkap = pemesanan.input_pesan', 'left');
        $this->db->where('pemesanan.tgl_setoran_driver', $tanggal);
        $this->db->where('pemesanan.input_setoran_driver', $nama_driver);
        $this->db->where('jenis_pesanan', 2);
        $this->db->where('status_setoran_driver', 1);
        $this->db->order_by('pemesanan.id_pemesanan', 'DESC');
        return $this->db->get()->result();
    }

    public function get_driver()
    {
        $this->db->select('id, nama_pengguna, nama_lengkap');
        $this->db->from('user');
        $this->db->where('nama_pengguna', 'Pemasaran');
        return $this->db->get()->result();
    }
}
