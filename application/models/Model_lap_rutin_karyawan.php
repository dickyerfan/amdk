<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_lap_rutin_karyawan extends CI_Model
{
    public function get_all($bulan, $tahun)
    {
        $this->db->select('*,bagian.id_bagian, bagian.nama_bagian,
        (SELECT SUM(galon) FROM lap_rutin_pegawai WHERE MONTH(lap_rutin_pegawai.tgl_lap) = "' . $bulan . '" AND YEAR(lap_rutin_pegawai.tgl_lap) = "' . $tahun . '" AND lap_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_galon,
        (SELECT SUM(gelas) FROM lap_rutin_pegawai WHERE MONTH(lap_rutin_pegawai.tgl_lap) = "' . $bulan . '" AND YEAR(lap_rutin_pegawai.tgl_lap) = "' . $tahun . '" AND lap_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_gelas,
        (SELECT SUM(btl330) FROM lap_rutin_pegawai WHERE MONTH(lap_rutin_pegawai.tgl_lap) = "' . $bulan . '" AND YEAR(lap_rutin_pegawai.tgl_lap) = "' . $tahun . '" AND lap_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_btl330,
        (SELECT SUM(btl500) FROM lap_rutin_pegawai WHERE MONTH(lap_rutin_pegawai.tgl_lap) = "' . $bulan . '" AND YEAR(lap_rutin_pegawai.tgl_lap) = "' . $tahun . '" AND lap_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_btl500,
        (SELECT SUM(btl1500) FROM lap_rutin_pegawai WHERE MONTH(lap_rutin_pegawai.tgl_lap) = "' . $bulan . '" AND YEAR(lap_rutin_pegawai.tgl_lap) = "' . $tahun . '" AND lap_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_btl1500,
        (SELECT SUM(nominal) FROM lap_rutin_pegawai WHERE MONTH(lap_rutin_pegawai.tgl_lap) = "' . $bulan . '" AND YEAR(lap_rutin_pegawai.tgl_lap) = "' . $tahun . '" AND lap_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_nominal
        ');
        $this->db->from('lap_rutin_pegawai');
        $this->db->join('bagian', 'bagian.id_bagian=lap_rutin_pegawai.id_bagian');
        $this->db->where('MONTH(lap_rutin_pegawai.tgl_lap)', $bulan);
        $this->db->where('YEAR(lap_rutin_pegawai.tgl_lap)', $tahun);
        $this->db->order_by('lap_rutin_pegawai.id_bagian', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_nama_barang()
    {
        $this->db->select('*');
        $this->db->from('jenis_barang');
        return $this->db->get()->result();
    }

    public function insert_pemesanan($id_mobil, $id_jenis_barang, $id_pelanggan, $tanggal_pesan, $jenis_pesanan, $jumlah_pesan, $harga_barang, $total_harga, $tanggal_bayar, $status_nota, $status_piutang, $status_bayar)
    {
        $data = array(
            'id_mobil' => $id_mobil,
            'id_jenis_barang' => $id_jenis_barang,
            'id_pelanggan' => $id_pelanggan,
            'tanggal_pesan' => $tanggal_pesan,
            'jenis_pesanan' => $jenis_pesanan,
            'jumlah_pesan' => $jumlah_pesan,
            'harga_barang' => $harga_barang,
            'total_harga' => $total_harga,
            'tanggal_bayar' => $tanggal_bayar,
            'status_nota' => $status_nota,
            'status_piutang' => $status_piutang,
            'status_bayar' => $status_bayar
        );

        $this->db->insert('pemesanan', $data);
    }


    public function get_pemesanan_karyawan($bulan, $tahun)
    {
        $this->db->select(
            '*,
        (SELECT SUM(total_harga) FROM pemesanan WHERE MONTH(pemesanan.tanggal_bayar) = "' . $bulan . '" AND YEAR(pemesanan.tanggal_bayar) = "' . $tahun . '" AND jenis_pesanan = 3 AND pemesanan.status_bayar = 1) AS total_penerimaan'
        );
        $this->db->from('pemesanan');
        $this->db->join('jenis_produk', 'jenis_produk.id_produk = pemesanan.id_jenis_barang', 'left');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan', 'left');
        $this->db->where('MONTH(pemesanan.tanggal_bayar)', $bulan);
        $this->db->where('YEAR(pemesanan.tanggal_bayar)', $tahun);
        $this->db->where('jenis_pesanan', 3);
        $this->db->where('status_bayar', 1);
        $this->db->order_by('pemesanan.id_pemesanan', 'DESC');
        return  $this->db->get()->result();
    }
}
