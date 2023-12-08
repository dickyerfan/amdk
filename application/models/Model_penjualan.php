<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_penjualan extends CI_Model
{

    public function get_all($bulan, $tahun)
    {
        $this->db->select('*');
        $this->db->from('pemesanan');
        $this->db->join('mobil', 'mobil.id_mobil = pemesanan.id_mobil', 'left');
        $this->db->join('jenis_produk', 'jenis_produk.id_produk = pemesanan.id_jenis_barang', 'left');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan', 'left');
        $this->db->where('MONTH(pemesanan.tanggal_pesan)', $bulan);
        $this->db->where('YEAR(pemesanan.tanggal_pesan)', $tahun);
        $this->db->order_by('pemesanan.id_pemesanan', 'DESC');
        return $this->db->get()->result();
    }

    public function get_lunas($id_pemesanan)
    {
        $this->db->select('pemesanan.status_bayar, pemesanan.id_pelanggan, pemesanan.jumlah_pesan, pemesanan.total_harga, pemesanan.id_jenis_barang,jenis_produk.nama_produk, pelanggan.nama_pelanggan');
        $this->db->from('pemesanan');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan');
        $this->db->join('jenis_produk', 'jenis_produk.id_produk = pemesanan.id_jenis_barang');
        $this->db->where('id_pemesanan', $id_pemesanan);
        return $this->db->get()->result();
    }

    public function update($table, $data, $id_pemesanan)
    {
        $this->db->where('id_pemesanan', $id_pemesanan);
        $this->db->update($table, $data);
    }

    // public function get_jenis_barang()
    // {
    //     $this->db->select('id_jenis_barang, nama_barang_jadi');
    //     $this->db->from('jenis_barang');
    //     return $this->db->get()->result();
    // }
    // public function get_pelanggan()
    // {
    //     $this->db->select('id_pelanggan, nama_pelanggan, alamat_pelanggan, tarif');
    //     $this->db->from('pelanggan');
    //     $this->db->where('aktif', 1);
    //     return $this->db->get()->result();
    // }

    // public function upload($table, $data)
    // {
    //     $this->db->insert($table, $data);
    // }


    // public function getHargaByJenisBarang($id_jenis_barang, $tarif)
    // {
    //     $this->db->select('harga');
    //     $this->db->from('harga');
    //     $this->db->join('pelanggan', 'harga.jenis_harga = pelanggan.tarif', 'left');
    //     $this->db->join('jenis_barang', 'harga.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
    //     $this->db->where('harga.id_jenis_barang', $id_jenis_barang);
    //     $this->db->where('pelanggan.tarif', $tarif);
    //     return $this->db->get()->row();
    // }

    // public function getTarifByIdPelanggan($id_pelanggan)
    // {
    //     $this->db->select('tarif');
    //     $this->db->from('pelanggan');
    //     $this->db->where('id_pelanggan', $id_pelanggan);
    //     return $this->db->get()->row()->tarif;
    // }
}
