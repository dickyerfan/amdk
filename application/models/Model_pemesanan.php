<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_pemesanan extends CI_Model
{

    public function get_all($tanggal)
    {
        $this->db->select('*');
        $this->db->from('pemesanan');
        $this->db->join('mobil', 'mobil.id_mobil = pemesanan.id_mobil', 'left');
        $this->db->join('jenis_produk', 'jenis_produk.id_produk = pemesanan.id_jenis_barang', 'left');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan', 'left');
        $this->db->where('DATE(pemesanan.tanggal_pesan)', $tanggal);
        $this->db->order_by('pemesanan.id_pemesanan', 'DESC');
        return $this->db->get()->result();
    }

    // public function get_all($bulan, $tahun)
    // {
    //     $this->db->select('*');
    //     $this->db->from('pemesanan');
    //     $this->db->join('mobil', 'mobil.id_mobil = pemesanan.id_mobil', 'left');
    //     $this->db->join('jenis_produk', 'jenis_produk.id_produk = pemesanan.id_jenis_barang', 'left');
    //     $this->db->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan', 'left');
    //     $this->db->where('MONTH(pemesanan.tanggal_pesan)', $bulan);
    //     $this->db->where('YEAR(pemesanan.tanggal_pesan)', $tahun);
    //     $this->db->order_by('pemesanan.id_pemesanan', 'DESC');
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

    public function upload($table, $data)
    {
        return $this->db->insert_batch($table, $data);
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
        $this->db->where('status_mobil', 1);
        return $this->db->get()->result();
    }

    public function get_id_pemesanan($id_pemesanan)
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
        $this->db->select('harga, no_perkiraan');
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

    public function update_nota($data)
    {
        // $this->db->where('id_pemesanan', $data['id_pemesanan']);
        $this->db->where('id_pelanggan', $data['id_pelanggan']);
        $this->db->where('tanggal_pesan', $data['tanggal_pesan']);
        $this->db->set('nota_beli', $data['nota_beli']);
        $this->db->set('tanggal_update', $data['tanggal_update']);
        $this->db->set('input_update', $data['input_update']);
        $this->db->set('status_nota', $data['status_nota']);
        $this->db->set('status_pesan', $data['status_pesan']);
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
        $this->db->select('mobil.id_mobil, mobil.nama_mobil, mobil.plat_nomor, pemesanan.tanggal_pesan, pemesanan.jenis_pesanan, pemesanan.jam_mobil, 
            SUM(pemesanan.jumlah_pesan) as total_pemesanan,
            SUM(CASE WHEN pemesanan.jam_mobil = 1 AND pemesanan.jenis_pesanan = 1 THEN pemesanan.jumlah_pesan ELSE 0 END) as total_jam_1_kunjungan,
            SUM(CASE WHEN pemesanan.jam_mobil = 2 AND pemesanan.jenis_pesanan = 1 THEN pemesanan.jumlah_pesan ELSE 0 END) as total_jam_2_kunjungan,
            SUM(CASE WHEN pemesanan.jam_mobil = 3 AND pemesanan.jenis_pesanan = 1 THEN pemesanan.jumlah_pesan ELSE 0 END) as total_jam_3_kunjungan,
            SUM(CASE WHEN pemesanan.jam_mobil = 4 AND pemesanan.jenis_pesanan = 1 THEN pemesanan.jumlah_pesan ELSE 0 END) as total_jam_4_kunjungan,
            SUM(CASE WHEN pemesanan.jam_mobil = 1 AND pemesanan.jenis_pesanan = 2 THEN pemesanan.jumlah_pesan ELSE 0 END) as total_jam_1_penjualan,
            SUM(CASE WHEN pemesanan.jam_mobil = 2 AND pemesanan.jenis_pesanan = 2 THEN pemesanan.jumlah_pesan ELSE 0 END) as total_jam_2_penjualan,
            SUM(CASE WHEN pemesanan.jam_mobil = 3 AND pemesanan.jenis_pesanan = 2 THEN pemesanan.jumlah_pesan ELSE 0 END) as total_jam_3_penjualan,
            SUM(CASE WHEN pemesanan.jam_mobil = 4 AND pemesanan.jenis_pesanan = 2 THEN pemesanan.jumlah_pesan ELSE 0 END) as total_jam_4_penjualan');
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
        $this->db->select('jenis_produk.nama_produk, pemesanan.jenis_pesanan, pemesanan.jam_mobil, SUM(pemesanan.jumlah_pesan) as jumlah_pesan');
        // $this->db->select('jenis_barang.nama_barang_jadi, pemesanan.jenis_pesanan, pemesanan.jam_mobil, SUM(pemesanan.jumlah_pesan) as jumlah_pesan');
        $this->db->from('pemesanan');
        // $this->db->join('jenis_barang', 'pemesanan.id_jenis_barang = jenis_barang.id_jenis_barang');
        $this->db->join('jenis_produk', 'pemesanan.id_jenis_barang = jenis_produk.id_produk');
        $this->db->where('pemesanan.id_mobil', $idMobil);
        $this->db->where('pemesanan.tanggal_pesan', $tanggalPesan);
        $this->db->group_by('pemesanan.id_jenis_barang, pemesanan.jenis_pesanan, pemesanan.jam_mobil');
        $this->db->order_by('pemesanan.jenis_pesanan'); // Menyusun berdasarkan jenis pesanan
        $this->db->order_by('pemesanan.jam_mobil'); // Kemudian berdasarkan jam mobil
        $query = $this->db->get();

        return $query->result();
    }

    // private function getJenisBarang($idMobil, $tanggalPesan)
    // {
    //     $this->db->select('jenis_barang.nama_barang_jadi, pemesanan.jenis_pesanan, pemesanan.jam_mobil, SUM(pemesanan.jumlah_pesan) as jumlah_pesan');
    //     $this->db->from('pemesanan');
    //     $this->db->join('jenis_barang', 'pemesanan.id_jenis_barang = jenis_barang.id_jenis_barang');
    //     $this->db->where('pemesanan.id_mobil', $idMobil);
    //     $this->db->where('pemesanan.tanggal_pesan', $tanggalPesan);
    //     $this->db->group_by('pemesanan.id_jenis_barang, pemesanan.jam_mobil');
    //     $this->db->order_by('pemesanan.jam_mobil');
    //     $query = $this->db->get();

    //     return $query->result();
    // }

    public function get_all_pesanan($tanggal)
    {
        $this->db->select('SUM(pemesanan.jumlah_pesan) as total_pesanan');
        $this->db->select('SUM(CASE WHEN jenis_pesanan = 1 THEN pemesanan.jumlah_pesan ELSE 0 END) as total_kunjungan');
        $this->db->select('SUM(CASE WHEN jenis_pesanan = 2 THEN pemesanan.jumlah_pesan ELSE 0 END) as total_penjualan');
        $this->db->from('pemesanan');
        $this->db->where('pemesanan.id_mobil IS NOT NULL');
        $this->db->where('pemesanan.id_mobil !=', 1);
        $this->db->where('tanggal_pesan', $tanggal);
        return $this->db->get()->result();
    }

    public function get_jumlah_pesan_lama($id_pemesanan)
    {
        $this->db->select('jumlah_pesan');
        $this->db->from('pemesanan');
        $this->db->where('id_pemesanan', $id_pemesanan);
        $query = $this->db->get();

        // Periksa apakah query berhasil dieksekusi
        if ($query->num_rows() == 1) {
            // Ambil baris hasil query dan kembalikan nilai jumlah_pesan
            $result = $query->row();
            return $result->jumlah_pesan;
        } else {
            // Jika tidak ada hasil atau lebih dari satu hasil, kembalikan false
            return false;
        }
    }


    // awal daftar barang karyawan
    // public function get_pegawai()
    // {
    //     $this->db->select('id, bagian.id_bagian,bagian.nama_bagian,nama, alamat, tarif');
    //     $this->db->from('pegawai');
    //     $this->db->join('bagian', 'bagian.id_bagian = pegawai.id_bagian');
    //     $this->db->where('aktif', 1);
    //     return $this->db->get()->result();
    // }

    // public function getTarifByIdPegawai($id)
    // {
    //     $this->db->select('tarif');
    //     $this->db->from('pegawai');
    //     $this->db->where('id', $id);
    //     return $this->db->get()->row()->tarif;
    // }

    // public function getHargaByJenisBarang_pegawai($id_jenis_barang, $tarif)
    // {
    //     $this->db->select('harga');
    //     $this->db->from('harga');
    //     $this->db->join('pegawai', 'harga.jenis_harga = pegawai.tarif', 'left');
    //     $this->db->join('jenis_barang', 'harga.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
    //     $this->db->where('harga.id_jenis_barang', $id_jenis_barang);
    //     $this->db->where('pegawai.tarif', $tarif);
    //     return $this->db->get()->row();
    // }

    // public function get_all_pegawai($bulan, $tahun)
    // {
    //     $this->db->select('*');
    //     $this->db->from('pemesanan_karyawan');
    //     $this->db->join('mobil', 'mobil.id_mobil = pemesanan_karyawan.id_mobil', 'left');
    //     $this->db->join('jenis_produk', 'jenis_produk.id_produk = pemesanan_karyawan.id_jenis_barang', 'left');
    //     $this->db->join('pegawai', 'pegawai.id = pemesanan_karyawan.id_pelanggan', 'left');
    //     $this->db->where('MONTH(pemesanan_karyawan.tanggal_pesan)', $bulan);
    //     $this->db->where('YEAR(pemesanan_karyawan.tanggal_pesan)', $tahun);
    //     $this->db->order_by('pemesanan_karyawan.id_pemesanan', 'DESC');
    //     return $this->db->get()->result();
    // }

    // public function get_id_masuk_baku_karyawan($id_pemesanan)
    // {
    //     $this->db->where('id_pemesanan', $id_pemesanan);
    //     return $this->db->get('pemesanan_karyawan')->row();
    // }

    // public function get_detail_pemesanan_karyawan($id_pemesanan)
    // {
    //     $this->db->select('*');
    //     $this->db->from('pemesanan_karyawan');
    //     $this->db->join('mobil', 'mobil.id_mobil = pemesanan_karyawan.id_mobil', 'left');
    //     $this->db->join('jenis_produk', 'jenis_produk.id_produk = pemesanan_karyawan.id_jenis_barang', 'left');
    //     $this->db->join('pegawai', 'pegawai.id = pemesanan_karyawan.id_pelanggan', 'left');
    //     $this->db->where('id_pemesanan', $id_pemesanan);
    //     $this->db->order_by('pemesanan_karyawan.id_pemesanan', 'DESC');
    //     return $this->db->get()->result();
    // }
    // akhir daftar barang karyawan
}
