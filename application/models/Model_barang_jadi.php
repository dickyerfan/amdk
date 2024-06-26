<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_barang_jadi extends CI_Model
{

    // public function getdata($tanggal)
    // {
    //     $this->db->select('jenis_barang.id_jenis_barang, jenis_barang.nama_barang_jadi');
    //     $this->db->select('(SELECT IFNULL(SUM(jumlah_stok_awal_jadi), 0) FROM stok_awal_jadi WHERE stok_awal_jadi.id_jenis_barang = jenis_barang.id_jenis_barang) AS jumlah_stok_awal', FALSE);
    //     $this->db->select('(SELECT IFNULL(SUM(jumlah_barang_jadi), 0) FROM barang_jadi WHERE barang_jadi.id_jenis_barang = jenis_barang.id_jenis_barang AND DATE(tanggal_barang_jadi) < "' . $tanggal . '" AND status_barang_jadi = 1) AS jumlah_masuk_kemaren', FALSE);
    //     $this->db->select('(SELECT IFNULL(SUM(jumlah_barang_jadi), 0) FROM barang_jadi WHERE barang_jadi.id_jenis_barang = jenis_barang.id_jenis_barang AND DATE(tanggal_barang_jadi) = "' . $tanggal . '" AND status_barang_jadi = 1) AS jumlah_masuk_sekarang', FALSE);
    //     $this->db->select('(SELECT IFNULL(SUM(jumlah_keluar), 0) FROM keluar_jadi WHERE keluar_jadi.id_jenis_barang = jenis_barang.id_jenis_barang AND DATE(tanggal_keluar) < "' . $tanggal . '" AND status_keluar = 1) AS jumlah_keluar_kemaren', FALSE);
    //     $this->db->select('(SELECT IFNULL(SUM(jumlah_keluar), 0) FROM keluar_jadi WHERE keluar_jadi.id_jenis_barang = jenis_barang.id_jenis_barang AND DATE(tanggal_keluar) = "' . $tanggal . '" AND status_keluar = 1) AS jumlah_keluar_sekarang', FALSE);
    //     $this->db->select('(SELECT IFNULL(SUM(jumlah_kembali), 0) FROM keluar_jadi WHERE keluar_jadi.id_jenis_barang = jenis_barang.id_jenis_barang AND DATE(tanggal_keluar) < "' . $tanggal . '" AND status_keluar = 1) AS jumlah_kembali_kemaren', FALSE);
    //     $this->db->select('(SELECT IFNULL(SUM(jumlah_kembali), 0) FROM keluar_jadi WHERE keluar_jadi.id_jenis_barang = jenis_barang.id_jenis_barang AND DATE(tanggal_keluar) = "' . $tanggal . '" AND status_keluar = 1) AS jumlah_kembali_sekarang', FALSE);
    //     $this->db->select('(SELECT IFNULL(SUM(jumlah_rusak_akhir), 0) FROM rusak_jadi WHERE rusak_jadi.id_jenis_barang = jenis_barang.id_jenis_barang AND DATE(tanggal_rusak_jadi) < "' . $tanggal . '" AND status_rusak_jadi = 1) AS jumlah_rusak_kemaren', FALSE);
    //     $this->db->select('(SELECT IFNULL(SUM(jumlah_rusak_akhir), 0) FROM rusak_jadi WHERE rusak_jadi.id_jenis_barang = jenis_barang.id_jenis_barang AND DATE(tanggal_rusak_jadi) = "' . $tanggal . '" AND status_rusak_jadi = 1) AS jumlah_rusak_sekarang', FALSE);
    //     $this->db->from('jenis_barang');
    //     return $this->db->get()->result();
    // }

    // kode ini tidak memakan banyak memory
    public function getdata($tanggal)
    {
        $this->db->select('jenis_barang.id_jenis_barang, jenis_barang.nama_barang_jadi');
        $this->db->select('(SELECT IFNULL(SUM(jumlah_stok_awal_jadi), 0) FROM stok_awal_jadi WHERE stok_awal_jadi.id_jenis_barang = jenis_barang.id_jenis_barang) AS jumlah_stok_awal', FALSE);
        $this->db->select('(SELECT IFNULL(SUM(jumlah_barang_jadi), 0) FROM barang_jadi WHERE barang_jadi.id_jenis_barang = jenis_barang.id_jenis_barang AND DATE(tanggal_barang_jadi) < "' . $tanggal . '" AND status_barang_jadi = 1) AS jumlah_masuk_kemaren', FALSE);
        $this->db->select('(SELECT IFNULL(SUM(jumlah_barang_jadi), 0) FROM barang_jadi WHERE barang_jadi.id_jenis_barang = jenis_barang.id_jenis_barang AND DATE(tanggal_barang_jadi) = "' . $tanggal . '" AND status_barang_jadi = 1) AS jumlah_masuk_sekarang', FALSE);
        $this->db->select('(SELECT IFNULL(SUM(jumlah_akhir), 0) FROM keluar_jadi WHERE keluar_jadi.id_jenis_barang = jenis_barang.id_jenis_barang AND DATE(tanggal_keluar) < "' . $tanggal . '" AND status_keluar = 1) AS jumlah_akhir_kemaren', FALSE);
        $this->db->select('(SELECT IFNULL(SUM(jumlah_akhir), 0) FROM keluar_jadi WHERE keluar_jadi.id_jenis_barang = jenis_barang.id_jenis_barang AND DATE(tanggal_keluar) = "' . $tanggal . '" AND status_keluar = 1) AS jumlah_akhir_sekarang', FALSE);
        $this->db->select('(SELECT IFNULL(SUM(jumlah_rusak_akhir), 0) FROM rusak_jadi WHERE rusak_jadi.id_jenis_barang = jenis_barang.id_jenis_barang AND DATE(tanggal_rusak_jadi) < "' . $tanggal . '" AND status_rusak_jadi = 1) AS jumlah_rusak_kemaren', FALSE);
        $this->db->select('(SELECT IFNULL(SUM(jumlah_rusak_akhir), 0) FROM rusak_jadi WHERE rusak_jadi.id_jenis_barang = jenis_barang.id_jenis_barang AND DATE(tanggal_rusak_jadi) = "' . $tanggal . '" AND status_rusak_jadi = 1) AS jumlah_rusak_sekarang', FALSE);
        $this->db->from('jenis_barang');
        return $this->db->get()->result();
    }

    // kode ini memakan banyak memory
    // public function getdata($tanggal)
    // {
    //     $this->db->select('jenis_barang.id_jenis_barang, jenis_barang.nama_barang_jadi, 
    //         (SELECT IFNULL(SUM(jumlah_stok_awal_jadi), 0) FROM stok_awal_jadi WHERE stok_awal_jadi.id_jenis_barang = jenis_barang.id_jenis_barang) AS jumlah_stok_awal,
    //         (SELECT IFNULL(SUM(jumlah_barang_jadi), 0) FROM barang_jadi WHERE barang_jadi.id_jenis_barang = jenis_barang.id_jenis_barang AND DATE(tanggal_barang_jadi) < DATE("' . $tanggal . '") AND barang_jadi.status_barang_jadi = 1) AS jumlah_masuk_kemaren,
    //         (SELECT IFNULL(SUM(jumlah_barang_jadi), 0) FROM barang_jadi WHERE barang_jadi.id_jenis_barang = jenis_barang.id_jenis_barang AND DATE(tanggal_barang_jadi) = DATE("' . $tanggal . '") AND barang_jadi.status_barang_jadi = 1) AS jumlah_masuk_sekarang,
    //         (SELECT IFNULL(SUM(jumlah_akhir), 0) FROM keluar_jadi WHERE keluar_jadi.id_jenis_barang = jenis_barang.id_jenis_barang AND keluar_jadi.status_keluar = 1 AND DATE(tanggal_keluar) < DATE("' . $tanggal . '")) AS jumlah_akhir_kemaren,
    //         (SELECT IFNULL(SUM(jumlah_akhir), 0) FROM keluar_jadi WHERE keluar_jadi.id_jenis_barang = jenis_barang.id_jenis_barang AND keluar_jadi.status_keluar = 1 AND DATE(tanggal_keluar) = DATE("' . $tanggal . '")) AS jumlah_akhir_sekarang,
    //         (SELECT IFNULL(SUM(jumlah_rusak_akhir), 0) FROM rusak_jadi WHERE rusak_jadi.id_jenis_barang = jenis_barang.id_jenis_barang AND DATE(tanggal_rusak_jadi) = DATE("' . $tanggal . '") AND rusak_jadi.status_rusak_jadi = 1) AS jumlah_rusak_sekarang,
    //         (SELECT IFNULL(SUM(jumlah_rusak_akhir), 0) FROM rusak_jadi WHERE rusak_jadi.id_jenis_barang = jenis_barang.id_jenis_barang AND DATE(tanggal_rusak_jadi) < DATE("' . $tanggal . '")) AS jumlah_rusak_kemaren', FALSE);

    //     $this->db->from('jenis_barang');
    //     $this->db->join('stok_awal_jadi', 'stok_awal_jadi.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
    //     $this->db->join('barang_jadi', 'barang_jadi.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
    //     $this->db->join('keluar_jadi', 'keluar_jadi.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
    //     $this->db->join('rusak_jadi', 'rusak_jadi.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
    //     return $this->db->get()->result();
    // }

    //awal upload stok awal
    public function getstok_awal()
    {
        $this->db->select('*');
        $this->db->from('stok_awal_jadi');
        $this->db->join('jenis_barang', 'stok_awal_jadi.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
        // $this->db->where('masuk_baku.status_masuk', 1);
        $this->db->group_by('stok_awal_jadi.id_stok_awal_jadi');
        return $this->db->get()->result();
    }

    public function get_nama_barang()
    {
        $this->db->select('id_jenis_barang,nama_barang_jadi');
        $this->db->from('jenis_barang');
        return $this->db->get()->result();
    }

    public function update_stok_awal_jadi()
    {

        $data = [
            'id_jenis_barang' => $this->input->post('id_jenis_barang', true),
            'jumlah_stok_awal_jadi' => $this->input->post('jumlah_stok_awal_jadi', true),
            'input_status_stok_awal_jadi' => $this->session->userdata('nama_lengkap')
        ];

        $this->db->where('id_stok_awal_jadi', $this->input->post('id_stok_awal_jadi'));
        $this->db->update('stok_awal_jadi', $data);
    }
    //akhir upload stok awal

    //awal barang_masuk
    public function getbarang_jadi($bulan, $tahun)
    {
        $this->db->select('*');
        $this->db->from('barang_jadi');
        $this->db->join('jenis_barang', 'barang_jadi.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
        $this->db->where('MONTH(barang_jadi.tanggal_barang_jadi)', $bulan);
        $this->db->where('YEAR(barang_jadi.tanggal_barang_jadi)', $tahun);
        $this->db->where('status_barang_produksi', 1);
        $this->db->group_by('barang_jadi.id_barang_jadi');
        // $this->db->order_by('barang_jadi.id_barang_jadi', 'DESC');
        $this->db->order_by('barang_jadi.tanggal_barang_jadi', 'DESC');
        return $this->db->get()->result();
    }

    public function update_status_barang_jadi($id_barang_jadi, $data)
    {
        $this->db->where('id_barang_jadi', $id_barang_jadi);
        return $this->db->update('barang_jadi', $data);
    }
    // akhir barang_masuk

    // barang keluar
    public function getbarang_keluar($tanggal)
    {
        $this->db->select('*');
        $this->db->from('keluar_jadi');
        $this->db->join('jenis_produk', 'keluar_jadi.id_jenis_barang = jenis_produk.id_produk', 'left');
        $this->db->join('mobil', 'keluar_jadi.id_mobil = mobil.id_mobil', 'left');
        $this->db->join('pelanggan', 'keluar_jadi.id_pelanggan = pelanggan.id_pelanggan', 'left');
        $this->db->where('DATE(keluar_jadi.tanggal_keluar)', $tanggal);
        // $this->db->where('MONTH(keluar_jadi.tanggal_keluar)', $bulan);
        // $this->db->where('YEAR(keluar_jadi.tanggal_keluar)', $tahun);
        // $this->db->where('keluar_baku.status_keluar', 0);
        // $this->db->group_by('keluar_jadi.id_keluar_jadi');
        $this->db->order_by('keluar_jadi.id_keluar_jadi', 'DESC');
        return $this->db->get()->result();
    }

    public function get_rekap_barang_keluar($tanggal)
    {
        $this->db->select('*, SUM(jumlah_keluar) AS jumlah_keluar, SUM(jumlah_kembali) AS jumlah_kembali');
        $this->db->from('keluar_jadi');
        $this->db->join('jenis_produk', 'keluar_jadi.id_jenis_barang = jenis_produk.id_produk', 'left');
        $this->db->where('DATE(keluar_jadi.tanggal_keluar)', $tanggal);
        $this->db->group_by('jenis_produk.nama_produk');
        $this->db->order_by('keluar_jadi.id_keluar_jadi', 'DESC');
        return $this->db->get()->result();
    }


    public function get_detail_barang_keluar($id_keluar_baku)
    {
        $this->db->select('*');
        $this->db->from('keluar_baku');
        $this->db->join('barang_baku', 'keluar_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->where('id_keluar_baku', $id_keluar_baku);
        $this->db->group_by('keluar_baku.id_keluar_baku');
        return $this->db->get()->result();
    }

    public function get_detail_barang_kembali($id_keluar_jadi)
    {
        $this->db->select('*');
        $this->db->from('keluar_jadi');
        $this->db->join('jenis_barang', 'keluar_jadi.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
        $this->db->where('id_keluar_jadi', $id_keluar_jadi);
        return $this->db->get()->row();
    }

    public function update_barang_kembali($table, $data_jumlah_kembali, $id_keluar_jadi)
    {
        $this->db->where('id_keluar_jadi', $id_keluar_jadi);
        $this->db->update($table, $data_jumlah_kembali);
    }

    // akhir barang keluar

    // awal barang rusak
    public function getbarang_rusak($bulan, $tahun)
    {
        $this->db->select('*');
        $this->db->from('rusak_jadi');
        $this->db->join('jenis_barang', 'rusak_jadi.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
        $this->db->where('MONTH(rusak_jadi.tanggal_rusak_jadi)', $bulan);
        $this->db->where('YEAR(rusak_jadi.tanggal_rusak_jadi)', $tahun);
        $this->db->group_by('rusak_jadi.id_rusak_jadi');
        $this->db->order_by('tanggal_rusak_jadi', 'DESC');
        return $this->db->get()->result();
    }

    public function get_detail_barang_rusak($id_rusak_jadi)
    {
        $this->db->select('*');
        $this->db->from('rusak_jadi');
        $this->db->join('jenis_barang', 'rusak_jadi.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
        $this->db->where('id_rusak_jadi', $id_rusak_jadi);
        $this->db->group_by('rusak_jadi.id_rusak_jadi');
        return $this->db->get()->result();
    }

    public function update_barang_perbaikan($table, $data, $id_rusak_jadi)
    {
        $this->db->where('id_rusak_jadi', $id_rusak_jadi);
        $this->db->update($table, $data);
    }
    //akhir barang rusak


    public function get_nama_barang_baku()
    {
        $this->db->select('*');
        $this->db->from('barang_baku');
        $this->db->where('status_jadi', 1);
        // $this->db->where('id_barang_baku', 8);
        // $this->db->or_where_in('id_barang_baku', 9);
        // $this->db->or_where_in('id_barang_baku', 10);
        // $this->db->or_where_in('id_barang_baku', 11);
        // $this->db->or_where_in('id_barang_baku', 12);
        // $this->db->or_where_in('id_barang_baku', 13);
        // $this->db->or_where_in('id_barang_baku', 27);
        // $this->db->or_where_in('id_barang_baku', 32);
        // $this->db->or_where_in('id_barang_baku', 34);

        return $this->db->get()->result();
    }


    // awal bon barang baku

    // public function getdata_barang_baku_jadi($tanggal)
    // {
    //     $this->db->select('*,barang_baku.*, 
    //     (SELECT IFNULL(SUM(jumlah_masuk), 0) FROM barang_baku_jadi_masuk WHERE barang_baku_jadi_masuk.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_masuk) < DATE("' . $tanggal . '")) AS jumlah_masuk_kemaren,
    //     (SELECT IFNULL(SUM(jumlah_masuk), 0) FROM barang_baku_jadi_masuk WHERE barang_baku_jadi_masuk.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_masuk) = DATE("' . $tanggal . '")) AS jumlah_masuk_sekarang,
    //     (SELECT IFNULL(SUM(jumlah_masuk), 0) FROM barang_baku_jadi_masuk WHERE barang_baku_jadi_masuk.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_masuk) <= DATE("' . $tanggal . '")) AS jumlah_masuk,
    //     (SELECT IFNULL(SUM(jumlah_keluar), 0) FROM barang_baku_jadi_keluar WHERE barang_baku_jadi_keluar.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_keluar) < DATE("' . $tanggal . '")) AS jumlah_keluar_kemaren,
    //     (SELECT IFNULL(SUM(jumlah_keluar), 0) FROM barang_baku_jadi_keluar WHERE barang_baku_jadi_keluar.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_keluar) = DATE("' . $tanggal . '")) AS jumlah_keluar_sekarang,
    //     (SELECT IFNULL(SUM(jumlah_keluar), 0) FROM barang_baku_jadi_keluar WHERE barang_baku_jadi_keluar.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_keluar) <= DATE("' . $tanggal . '")) AS jumlah_keluar', FALSE);

    //     $this->db->from('barang_baku');
    //     $this->db->join('barang_baku_jadi_masuk', 'barang_baku_jadi_masuk.id_barang_baku = barang_baku.id_barang_baku', 'left');
    //     $this->db->join('barang_baku_jadi_keluar', 'barang_baku_jadi_keluar.id_barang_baku = barang_baku.id_barang_baku', 'left');
    //     $this->db->where('barang_baku.status_jadi', 1);
    //     // $this->db->where('barang_baku.id_barang_baku', 8);
    //     // $this->db->or_where_in('barang_baku.id_barang_baku', 9);
    //     // $this->db->or_where_in('barang_baku.id_barang_baku', 10);
    //     // $this->db->or_where_in('barang_baku.id_barang_baku', 11);
    //     // $this->db->or_where_in('barang_baku.id_barang_baku', 12);
    //     // $this->db->or_where_in('barang_baku.id_barang_baku', 13);
    //     // $this->db->or_where_in('barang_baku.id_barang_baku', 27);
    //     // $this->db->or_where_in('barang_baku.id_barang_baku', 32);
    //     // $this->db->or_where_in('barang_baku.id_barang_baku', 34);
    //     $this->db->order_by('barang_baku.id_barang_baku', 'asc');
    //     return $this->db->get()->result();
    // }

    public function getdata_barang_baku_jadi($tanggal)
    {
        $this->db->select('*,barang_baku.*, 
        (SELECT IFNULL(SUM(jumlah_masuk), 0) FROM barang_baku_jadi_masuk WHERE barang_baku_jadi_masuk.id_barang_baku = barang_baku.id_barang_baku AND barang_baku_jadi_masuk.status_masuk = 1 AND DATE(tanggal_masuk) < DATE("' . $tanggal . '")) AS jumlah_masuk_kemaren,
        (SELECT IFNULL(SUM(jumlah_masuk), 0) FROM barang_baku_jadi_masuk WHERE barang_baku_jadi_masuk.id_barang_baku = barang_baku.id_barang_baku AND barang_baku_jadi_masuk.status_masuk = 1 AND DATE(tanggal_masuk) = DATE("' . $tanggal . '")) AS jumlah_masuk_sekarang,
        (SELECT IFNULL(SUM(jumlah_masuk), 0) FROM barang_baku_jadi_masuk WHERE barang_baku_jadi_masuk.id_barang_baku = barang_baku.id_barang_baku AND barang_baku_jadi_masuk.status_masuk = 1 AND DATE(tanggal_masuk) <= DATE("' . $tanggal . '")) AS jumlah_masuk,
        (SELECT IFNULL(SUM(jumlah_keluar), 0) FROM barang_baku_jadi_keluar WHERE barang_baku_jadi_keluar.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_keluar) < DATE("' . $tanggal . '")) AS jumlah_keluar_kemaren,
        (SELECT IFNULL(SUM(jumlah_keluar), 0) FROM barang_baku_jadi_keluar WHERE barang_baku_jadi_keluar.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_keluar) = DATE("' . $tanggal . '")) AS jumlah_keluar_sekarang,
        (SELECT IFNULL(SUM(jumlah_keluar), 0) FROM barang_baku_jadi_keluar WHERE barang_baku_jadi_keluar.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_keluar) <= DATE("' . $tanggal . '")) AS jumlah_keluar', FALSE);

        $this->db->from('barang_baku');
        $this->db->join('barang_baku_jadi_masuk', 'barang_baku_jadi_masuk.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->join('barang_baku_jadi_keluar', 'barang_baku_jadi_keluar.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->where('barang_baku.status_jadi', 1);
        $this->db->order_by('barang_baku.id_barang_baku', 'asc');
        return $this->db->get()->result();
    }

    public function ambil_kardus($data)
    {
        $this->db->insert('barang_baku_jadi_keluar', $data);
    }

    public function upload($table, $data)
    {
        return $this->db->insert($table, $data);
    }


    // public function getbarang_baku($bulan, $tahun)
    // {
    //     $this->db->select('keluar_baku.*, barang_baku.nama_barang_baku');
    //     $this->db->from('keluar_baku');
    //     $this->db->join('barang_baku', 'keluar_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
    //     $this->db->where('keluar_baku.status_tolak', 1);
    //     $this->db->where('keluar_baku.bagian', 'jadi');
    //     $this->db->where('MONTH(keluar_baku.tanggal_keluar)', $bulan);
    //     $this->db->where('YEAR(keluar_baku.tanggal_keluar)', $tahun);
    //     $this->db->order_by('keluar_baku.tanggal_keluar', 'DESC');
    //     $this->db->order_by('keluar_baku.id_keluar_baku', 'DESC');
    //     return $this->db->get()->result();
    // }


    public function terima_barang($data_terima_barang, $id_keluar_jadi)
    {
        $this->db->where('id_keluar_jadi', $id_keluar_jadi);
        $this->db->update('keluar_jadi', $data_terima_barang);
    }


    // kode untuk stok awal barang jadi
    public function getstok_awal_jadi()
    {
        $this->db->select('stok_awal_jadi.*, jenis_barang.nama_barang_jadi');
        $this->db->from('stok_awal_jadi');
        $this->db->join('jenis_barang', 'stok_awal_jadi.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
        return $this->db->get()->result();
    }

    public function get_id_stok_awal($id_stok_awal_jadi)
    {
        $this->db->select('jenis_barang.id_jenis_barang,jenis_barang.nama_barang_jadi, jumlah_stok_awal_jadi, tanggal_stok_awal_jadi, input_status_stok_awal_jadi, id_stok_awal_jadi');
        $this->db->from('stok_awal_jadi');
        $this->db->join('jenis_barang', 'stok_awal_jadi.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
        $this->db->where('id_stok_awal_jadi', $id_stok_awal_jadi);
        return $this->db->get()->row();
    }

    public function update_stok()
    {

        $data = [
            'jumlah_stok_awal_jadi' => $this->input->post('jumlah_stok_awal_jadi', true),
            'tanggal_stok_awal_jadi' => $this->input->post('tanggal_stok_awal_jadi', true),
            'input_status_stok_awal_jadi' => $this->session->userdata('nama_lengkap'),
            'tgl_input_stok_awal_jadi' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_stok_awal_jadi', $this->input->post('id_stok_awal_jadi'));
        $this->db->update('stok_awal_jadi', $data);
    }
}
