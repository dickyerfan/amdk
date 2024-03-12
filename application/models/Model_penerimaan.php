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

    public function update_nota($data)
    {
        $this->db->where('DATE(tanggal_bayar)', $data['tanggal_bayar']);
        $update_data = array(
            'nota_setor' => $data['nota_setor'],
            'tanggal_setor' => $data['tanggal_setor'],
            'input_setor' => $data['input_setor'],
            'status_setor' => $data['status_setor']
        );
        $this->db->update('pemesanan', $update_data);
    }

    public function get_terima_kas($tanggal_kas)
    {
        $this->db->select(
            'pemesanan.id_jenis_barang,pemesanan.id_pelanggan,pemesanan.tanggal_pesan,pemesanan.tanggal_setor,pemesanan.status_setor,pemesanan.jumlah_pesan,pemesanan.total_harga,pemesanan.harga_barang,pelanggan.nama_pelanggan,jenis_produk.nama_produk,
        (SELECT SUM(total_harga) FROM pemesanan WHERE DATE(pemesanan.tanggal_setor) = "' . $tanggal_kas . '" AND pemesanan.status_setor = 1) AS total_penerimaan'
        );
        $this->db->from('pemesanan');
        $this->db->join('jenis_produk', 'jenis_produk.id_produk = pemesanan.id_jenis_barang', 'left');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan', 'left');
        $this->db->where('DATE(pemesanan.tanggal_setor)', $tanggal_kas);
        $this->db->where('status_setor', 1);
        $this->db->order_by('pemesanan.id_pemesanan', 'DESC');
        return $this->db->get()->result();
    }
}
