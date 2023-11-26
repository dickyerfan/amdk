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

    public function upload($table, $data)
    {
        $this->db->insert($table, $data);
    }

    public function update($table, $data, $id_pemesanan)
    {
        $this->db->where('id_pemesanan', $id_pemesanan);
        $this->db->update($table, $data);
    }

    // awal pilih mobil
    // ketika bagian pemasaran pilik mobil armada maka sekaligus mengirim permintaan ke bagian barang jadi
    // dengan insert ke tabel keluar_jadi

    public function get_mobil()
    {
        $this->db->select('id_mobil, nama_mobil');
        $this->db->from('mobil');
        return $this->db->get()->result();
    }

    public function get_id_masuk_baku($id_pemesanan)
    {
        $this->db->where('id_pemesanan', $id_pemesanan);
        return $this->db->get('pemesanan')->row();
    }

    // untuk insert data ke tabel keluar jadi untuk pengeluaran barang bagian barang jadi
    public function insert_keluar_jadi($table, $data)
    {
        $this->db->insert($table, $data);
    }
    // akhir pilih mobil


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

    public function get_id_pemesanan($id_pemesanan)
    {
        return $this->db->get_where('pemesanan', ['id_pemesanan' => $id_pemesanan])->row();
    }

    public function update_nota($data)
    {
        $this->db->where('id_pemesanan', $data['id_pemesanan']);
        $this->db->set('nota_beli', $data['nota_beli']);
        $this->db->set('tanggal_update', $data['tanggal_update']);
        $this->db->set('input_update', $data['input_update']);
        $this->db->set('status_nota', $data['status_nota']);
        $this->db->update('pemesanan');
    }

    public function get_detail_pemesanan($id_pemesanan)
    {
        $this->db->select('*');
        $this->db->from('pemesanan');
        $this->db->join('mobil', 'mobil.id_mobil = pemesanan.id_mobil', 'left');
        $this->db->join('jenis_produk', 'jenis_produk.id_produk = pemesanan.id_jenis_barang', 'left');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan', 'left');
        $this->db->where('id_pemesanan', $id_pemesanan);
        $this->db->order_by('pemesanan.id_pemesanan', 'DESC');
        return $this->db->get()->result();
    }

    public function get_daftar_kiriman($tanggal)
    {
        $this->db->select('mobil.id_mobil, mobil.nama_mobil, mobil.plat_nomor, pemesanan.tanggal_pesan, 
            SUM(pemesanan.jumlah_pesan) as total_pemesanan');
        $this->db->from('pemesanan');
        $this->db->join('mobil', 'pemesanan.id_mobil = mobil.id_mobil');
        $this->db->group_by('pemesanan.id_mobil, pemesanan.tanggal_pesan');
        $this->db->where('pemesanan.id_mobil IS NOT NULL'); // Hanya pilih yang id_mobil tidak null
        $this->db->where('pemesanan.id_mobil !=', 1);
        $this->db->where('tanggal_pesan', $tanggal);
        $query = $this->db->get();

        $result = $query->result();

        foreach ($result as $mobil) {
            $mobil->jenis_barang = $this->getJenisBarang($mobil->id_mobil, $mobil->tanggal_pesan);
        }

        return $result;
    }

    private function getJenisBarang($idMobil, $tanggalPesan)
    {
        $this->db->select('jenis_barang.nama_barang_jadi, SUM(pemesanan.jumlah_pesan) as jumlah_pesan');
        $this->db->from('pemesanan');
        $this->db->join('jenis_barang', 'pemesanan.id_jenis_barang = jenis_barang.id_jenis_barang');
        $this->db->where('pemesanan.id_mobil', $idMobil);
        $this->db->where('pemesanan.tanggal_pesan', $tanggalPesan);
        $this->db->group_by('pemesanan.id_jenis_barang');
        $query = $this->db->get();

        return $query->result();
    }
}