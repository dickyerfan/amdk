<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_pemesanan extends CI_Model
{

    public function get_all()
    {
        $this->db->select('*');
        $this->db->from('pemesanan');
        $this->db->join('mobil', 'mobil.id_mobil = pemesanan.id_mobil', 'left');
        $this->db->join('jenis_produk', 'jenis_produk.id_produk = pemesanan.id_jenis_barang', 'left');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan', 'left');
        $this->db->order_by('pemesanan.id_pemesanan', 'DESC');
        return $this->db->get()->result();
    }

    // public function get_all()
    // {
    //     $this->db->select('*');
    //     $this->db->from('pemesanan');
    //     $this->db->join('mobil', 'mobil.id_mobil = pemesanan.id_mobil', 'left');
    //     $this->db->join('jenis_barang', 'jenis_barang.id_jenis_barang = pemesanan.id_jenis_barang', 'left');
    //     $this->db->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan', 'left');
    //     return $this->db->get()->result();
    // }

    // public function getdata()
    // {
    //     $tahun_sekarang = date('Y');
    //     $this->db->select('*,barang_baku.*, 
    //     COALESCE(
    //         (SELECT SUM(jumlah_stok_awal_baku) 
    //          FROM stok_awal_baku 
    //          WHERE stok_awal_baku.id_barang_baku = barang_baku.id_barang_baku 
    //          AND YEAR(stok_awal_baku.tanggal_stok_awal_baku) = ' . $tahun_sekarang . '), 
    //         (SELECT SUM(jumlah_stok_awal_baku) 
    //          FROM stok_awal_baku 
    //          WHERE stok_awal_baku.id_barang_baku = barang_baku.id_barang_baku)
    //     ) AS jumlah_stok_awal,
    //                (SELECT SUM(isi_stok_minimum) FROM stok_minimum WHERE stok_minimum.id_barang_baku = barang_baku.id_barang_baku AND stok_minimum.status_stok_minimum = 1) AS isi_stok_minimum, 
    //                (SELECT SUM(jumlah_stok_minimum) FROM stok_minimum WHERE stok_minimum.id_barang_baku = barang_baku.id_barang_baku AND stok_minimum.status_stok_minimum = 1) AS jumlah_stok_minimum, 
    //                (SELECT SUM(jumlah_masuk) FROM masuk_baku WHERE masuk_baku.id_barang_baku = barang_baku.id_barang_baku AND masuk_baku.status_masuk = 1) AS jumlah_masuk, 
    //                (SELECT SUM(jumlah_rusak_baku) FROM rusak_baku WHERE rusak_baku.id_barang_baku = barang_baku.id_barang_baku) AS jumlah_rusak, 
    //                (SELECT SUM(jumlah_keluar) FROM keluar_baku WHERE keluar_baku.id_barang_baku = barang_baku.id_barang_baku AND keluar_baku.status_keluar = 1) AS jumlah_keluar', FALSE);
    //     $this->db->from('barang_baku');
    //     $this->db->join('stok_awal_baku', 'stok_awal_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
    //     $this->db->join('masuk_baku', 'masuk_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
    //     $this->db->join('keluar_baku', 'keluar_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
    //     $this->db->join('rusak_baku', 'rusak_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
    //     $this->db->join('stok_minimum', 'stok_minimum.id_barang_baku = barang_baku.id_barang_baku', 'left');
    //     $this->db->join('satuan', 'satuan.id_satuan = barang_baku.id_satuan', 'left');
    //     $this->db->join('jenis_barang', 'jenis_barang.id_jenis_barang = barang_baku.id_jenis_barang', 'left');
    //     $this->db->where('barang_baku.status_barang_baku', 1);
    //     $this->db->group_by('barang_baku.id_barang_baku');
    //     return $this->db->get()->result();
    // }

    public function get_produk()
    {
        $this->db->select('id_produk, nama_produk');
        $this->db->from('jenis_produk');
        return $this->db->get()->result();
    }
    public function get_pelanggan()
    {
        $this->db->select('id_pelanggan, nama_pelanggan, alamat_pelanggan, tarif');
        $this->db->from('pelanggan');
        $this->db->where('aktif', 1);
        return $this->db->get()->result();
    }
    public function get_mobil()
    {
        $this->db->select('id_mobil, nama_mobil');
        $this->db->from('mobil');
        return $this->db->get()->result();
    }


    public function upload($table, $data)
    {
        $this->db->insert($table, $data);
    }

    public function update($table, $data, $id_pemesanan)
    {
        $this->db->where('id_pemesanan', $id_pemesanan);
        $this->db->update($table, $data);
    }

    public function get_id_masuk_baku($id_pemesanan)
    {
        $this->db->where('id_pemesanan', $id_pemesanan);
        return $this->db->get('pemesanan')->row();
    }

    public function tambah_keluar_jadi($table, $data)
    {
        $this->db->insert($table, $data);
    }


    public function getHargaByJenisBarang($id_jenis_barang, $tarif)
    {
        $this->db->select('harga');
        $this->db->from('harga');
        $this->db->join('pelanggan', 'harga.jenis_harga = pelanggan.tarif', 'left');
        $this->db->join('jenis_barang', 'harga.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
        $this->db->where('harga.id_jenis_barang', $id_jenis_barang);
        $this->db->where('pelanggan.tarif', $tarif);
        return $this->db->get()->row();
    }

    public function getTarifByIdPelanggan($id_pelanggan)
    {
        $this->db->select('tarif');
        $this->db->from('pelanggan');
        $this->db->where('id_pelanggan', $id_pelanggan);
        return $this->db->get()->row()->tarif;
    }
}
