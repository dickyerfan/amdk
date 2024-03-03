<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_piutang extends CI_Model
{

    public function get_all()
    {
        $this->db->select(
            '*,
        (SELECT SUM(total_harga) FROM pemesanan WHERE pemesanan.status_bayar = 0 AND pemesanan.jenis_pesanan != 1) AS total_piutang'
        );
        $this->db->from('pemesanan');
        $this->db->join('jenis_produk', 'jenis_produk.id_produk = pemesanan.id_jenis_barang', 'left');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan', 'left');
        $this->db->join('mobil', 'mobil.id_mobil = pemesanan.id_mobil', 'left');
        $this->db->where('status_bayar', 0);
        $this->db->where('jenis_pesanan !=', 1);
        // $this->db->or_where('jenis_pesanan', 4);
        // $this->db->order_by('pemesanan.id_pemesanan', 'DESC');
        $this->db->order_by('pemesanan.tanggal_pesan', 'DESC');
        return $this->db->get()->result();
    }
    public function get_bulan_tahun($bulan, $tahun)
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
        // $this->db->order_by('pemesanan.id_pemesanan', 'DESC');
        $this->db->order_by('pemesanan.tanggal_pesan', 'DESC');
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
        // $this->db->order_by('pemesanan.id_pemesanan', 'DESC');
        $this->db->order_by('pemesanan.tanggal_pesan', 'DESC');
        return $this->db->get()->result();
    }

    // piutang bagian pemasaran
    public function get_id_pemesanan($id_pemesanan)
    {
        $this->db->where('id_pemesanan', $id_pemesanan);
        return $this->db->get('pemesanan')->row();
    }

    public function update_nota($data)
    {
        $this->db->where('id_pemesanan', $data['id_pemesanan']);
        // $this->db->where('id_pelanggan', $data['id_pelanggan']);
        // $this->db->where('tanggal_pesan', $data['tanggal_pesan']);
        $this->db->set('nota_beli', $data['nota_beli']);
        $this->db->set('tanggal_update', $data['tanggal_update']);
        $this->db->set('input_update', $data['input_update']);
        $this->db->set('status_nota', $data['status_nota']);
        $this->db->set('status_pesan', $data['status_pesan']);
        $this->db->update('pemesanan');
    }

    // piutang bagian keuangan
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

    public function get_produk()
    {
        $this->db->select('id_produk, nama_produk');
        $this->db->from('jenis_produk');
        return $this->db->get()->result();
    }

    public function get_pelanggan()
    {
        $this->db->select('id_pelanggan, nama_pelanggan');
        $this->db->from('pelanggan');
        $this->db->where('aktif', 1);
        return $this->db->get()->result();
    }

    public function get_by_produk($id_produk)
    {
        $this->db->select(
            '*,
        (SELECT SUM(total_harga) FROM pemesanan WHERE pemesanan.id_jenis_barang = "' . $id_produk . '"  AND pemesanan.status_bayar = 0 AND pemesanan.jenis_pesanan != 1) AS total_piutang'
        );
        $this->db->from('pemesanan');
        $this->db->join('jenis_produk', 'jenis_produk.id_produk = pemesanan.id_jenis_barang', 'left');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan', 'left');
        $this->db->join('mobil', 'mobil.id_mobil = pemesanan.id_mobil', 'left');
        $this->db->where('pemesanan.id_jenis_barang', $id_produk);
        $this->db->where('status_bayar', 0);
        $this->db->where('jenis_pesanan !=', 1);
        $this->db->order_by('pemesanan.id_pemesanan', 'DESC');
        return $this->db->get()->result();
    }

    public function get_by_pelanggan($id_pelanggan)
    {
        $this->db->select(
            '*,
        (SELECT SUM(total_harga) FROM pemesanan WHERE pemesanan.id_pelanggan = "' . $id_pelanggan . '"  AND pemesanan.status_bayar = 0 AND pemesanan.jenis_pesanan != 1) AS total_piutang'
        );
        $this->db->from('pemesanan');
        $this->db->join('jenis_produk', 'jenis_produk.id_produk = pemesanan.id_jenis_barang', 'left');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan', 'left');
        $this->db->join('mobil', 'mobil.id_mobil = pemesanan.id_mobil', 'left');
        $this->db->where('pemesanan.id_pelanggan', $id_pelanggan);
        $this->db->where('status_bayar', 0);
        $this->db->where('jenis_pesanan !=', 1);
        $this->db->order_by('pemesanan.id_pemesanan', 'DESC');
        return $this->db->get()->result();
    }
}
