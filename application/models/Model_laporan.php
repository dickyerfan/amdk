<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_laporan extends CI_Model
{

    // public function getdata_harian($tanggal)
    // {
    //     $this->db->select('*,barang_baku.*, 
    //                (SELECT SUM(jumlah_stok_awal_baku) FROM stok_awal_baku WHERE stok_awal_baku.id_barang_baku = barang_baku.id_barang_baku) AS jumlah_stok_awal, 
    //                (SELECT SUM(jumlah_masuk) FROM masuk_baku WHERE masuk_baku.id_barang_baku = barang_baku.id_barang_baku AND masuk_baku.status_masuk = 1) AS jumlah_masuk, 
    //                (SELECT SUM(jumlah_rusak_baku) FROM rusak_baku WHERE rusak_baku.id_barang_baku = barang_baku.id_barang_baku) AS jumlah_rusak, 
    //                (SELECT SUM(jumlah_keluar) FROM keluar_baku WHERE keluar_baku.id_barang_baku = barang_baku.id_barang_baku AND keluar_baku.status_keluar = 1) AS jumlah_keluar', FALSE);
    //     $this->db->from('barang_baku');
    //     $this->db->join('stok_awal_baku', 'stok_awal_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
    //     $this->db->join('masuk_baku', 'masuk_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
    //     $this->db->join('keluar_baku', 'keluar_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
    //     $this->db->join('rusak_baku', 'rusak_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
    //     $this->db->join('satuan', 'satuan.id_satuan = barang_baku.id_satuan', 'left');
    //     $this->db->join('jenis_barang', 'jenis_barang.id_jenis_barang = barang_baku.id_jenis_barang', 'left');
    //     $this->db->where('barang_baku.status_barang_baku', 1);
    //     $this->db->where('masuk_baku.tanggal_masuk', $tanggal);
    //     $this->db->where('keluar_baku.tanggal_keluar', $tanggal);
    //     $this->db->where('rusak_baku.tanggal_rusak_baku', $tanggal);
    //     $this->db->group_by('barang_baku.id_barang_baku');
    //     return $this->db->get()->result();
    // }

    public function getdata_harian($tanggal)
    {
        $this->db->select('*, barang_baku.*, 
            (SELECT IFNULL(SUM(jumlah_stok_awal_baku), 0) FROM stok_awal_baku WHERE stok_awal_baku.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_stok_awal_baku) <= DATE("' . $tanggal . '")) AS jumlah_stok_awal,
            (SELECT IFNULL(SUM(jumlah_masuk), 0) FROM masuk_baku WHERE masuk_baku.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_masuk) < DATE("' . $tanggal . '") AND masuk_baku.status_masuk = 1) AS jumlah_masuk_kemaren,
            (SELECT IFNULL(SUM(jumlah_masuk), 0) FROM masuk_baku WHERE masuk_baku.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_masuk) = DATE("' . $tanggal . '") AND masuk_baku.status_masuk = 1) AS jumlah_masuk_sekarang,
            (SELECT IFNULL(SUM(jumlah_masuk), 0) FROM masuk_baku WHERE masuk_baku.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_masuk) <= DATE("' . $tanggal . '") AND masuk_baku.status_masuk = 1) AS jumlah_masuk,
            (SELECT IFNULL(SUM(jumlah_keluar), 0) FROM keluar_baku WHERE keluar_baku.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_keluar) < DATE("' . $tanggal . '") AND keluar_baku.status_keluar = 1) AS jumlah_keluar_kemaren,
            (SELECT IFNULL(SUM(jumlah_keluar), 0) FROM keluar_baku WHERE keluar_baku.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_keluar) = DATE("' . $tanggal . '") AND keluar_baku.status_keluar = 1) AS jumlah_keluar_sekarang,
            (SELECT IFNULL(SUM(jumlah_keluar), 0) FROM keluar_baku WHERE keluar_baku.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_keluar) <= DATE("' . $tanggal . '") AND keluar_baku.status_keluar = 1) AS jumlah_keluar,
            (SELECT IFNULL(SUM(jumlah_rusak_baku), 0) FROM rusak_baku WHERE rusak_baku.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_rusak_baku) = DATE("' . $tanggal . '") AND rusak_baku.status_rusak_baku = 1) AS jumlah_rusak_sekarang,
            (SELECT IFNULL(SUM(jumlah_rusak_baku), 0) FROM rusak_baku WHERE rusak_baku.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_rusak_baku) <= DATE("' . $tanggal . '") AND rusak_baku.status_rusak_baku = 1) AS jumlah_rusak_kemaren,
            (SELECT IFNULL(SUM(jumlah_rusak_baku), 0) FROM rusak_baku WHERE rusak_baku.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_rusak_baku) = DATE("' . $tanggal . '")) AS jumlah_rusak', FALSE);

        $this->db->from('barang_baku');
        $this->db->join('stok_awal_baku', 'stok_awal_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->join('masuk_baku', 'masuk_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->join('keluar_baku', 'keluar_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->join('rusak_baku', 'rusak_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->join('satuan', 'satuan.id_satuan = barang_baku.id_satuan', 'left');
        $this->db->join('jenis_barang', 'jenis_barang.id_jenis_barang = barang_baku.id_jenis_barang', 'left');
        $this->db->where('barang_baku.status_barang_baku', 1);
        $this->db->group_by('barang_baku.id_barang_baku');

        return $this->db->get()->result();
    }


    public function getdata_bulanan($tanggal)
    {
        $this->db->select('*, barang_baku.*, 
            (SELECT IFNULL(SUM(jumlah_stok_awal_baku), 0) FROM stok_awal_baku WHERE stok_awal_baku.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_stok_awal_baku) <= DATE("' . $tanggal . '")) AS jumlah_stok_awal,
            (SELECT IFNULL(SUM(jumlah_masuk), 0) FROM masuk_baku WHERE masuk_baku.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_masuk) < DATE("' . $tanggal . '") AND masuk_baku.status_masuk = 1) AS jumlah_masuk_kemaren,
            (SELECT IFNULL(SUM(jumlah_masuk), 0) FROM masuk_baku WHERE masuk_baku.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_masuk) = DATE("' . $tanggal . '") AND masuk_baku.status_masuk = 1) AS jumlah_masuk_sekarang,
            (SELECT IFNULL(SUM(jumlah_masuk), 0) FROM masuk_baku WHERE masuk_baku.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_masuk) <= DATE("' . $tanggal . '") AND masuk_baku.status_masuk = 1) AS jumlah_masuk,
            (SELECT IFNULL(SUM(jumlah_keluar), 0) FROM keluar_baku WHERE keluar_baku.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_keluar) < DATE("' . $tanggal . '") AND keluar_baku.status_keluar = 1) AS jumlah_keluar_kemaren,
            (SELECT IFNULL(SUM(jumlah_keluar), 0) FROM keluar_baku WHERE keluar_baku.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_keluar) = DATE("' . $tanggal . '") AND keluar_baku.status_keluar = 1) AS jumlah_keluar_sekarang,
            (SELECT IFNULL(SUM(jumlah_keluar), 0) FROM keluar_baku WHERE keluar_baku.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_keluar) <= DATE("' . $tanggal . '") AND keluar_baku.status_keluar = 1) AS jumlah_keluar,
            (SELECT IFNULL(SUM(jumlah_rusak_baku), 0) FROM rusak_baku WHERE rusak_baku.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_rusak_baku) = DATE("' . $tanggal . '") AND rusak_baku.status_rusak_baku = 1) AS jumlah_rusak_sekarang,
            (SELECT IFNULL(SUM(jumlah_rusak_baku), 0) FROM rusak_baku WHERE rusak_baku.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_rusak_baku) <= DATE("' . $tanggal . '") AND rusak_baku.status_rusak_baku = 1) AS jumlah_rusak_kemaren,
            (SELECT IFNULL(SUM(jumlah_rusak_baku), 0) FROM rusak_baku WHERE rusak_baku.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_rusak_baku) = DATE("' . $tanggal . '")) AS jumlah_rusak', FALSE);

        $this->db->from('barang_baku');
        $this->db->join('stok_awal_baku', 'stok_awal_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->join('masuk_baku', 'masuk_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->join('keluar_baku', 'keluar_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->join('rusak_baku', 'rusak_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->join('satuan', 'satuan.id_satuan = barang_baku.id_satuan', 'left');
        $this->db->join('jenis_barang', 'jenis_barang.id_jenis_barang = barang_baku.id_jenis_barang', 'left');
        $this->db->where('barang_baku.status_barang_baku', 1);
        $this->db->group_by('barang_baku.id_barang_baku');

        return $this->db->get()->result();
    }

    // public function get_stok_akhir_kemaren()
    // {
    //     $tanggal_kemaren = date('Y-m-d', strtotime('-1 day'));

    //     $this->db->select('*');
    //     $this->db->where('tanggal_stok_harian', $tanggal_kemaren);
    //     $query = $this->db->get('stok_awal_harian');

    //     if ($query->num_rows() > 0) {
    //         return $query->result_array();
    //     } else {
    //         return array(); // Kembalikan array kosong jika tidak ada data
    //     }
    // }

    // public function upload_stok_awal($data)
    // {
    //     // Masukkan data stok awal ke dalam tabel stok_awal_harian
    //     $this->db->insert('stok_awal_harian', $data);
    // }

    // public function getdata_bulanan($bulan, $tahun)
    // {
    //     $this->db->select('*,barang_baku.*, 
    //     (SELECT IFNULL(SUM(jumlah_stok_awal_baku), 0) FROM stok_awal_baku WHERE stok_awal_baku.id_barang_baku = barang_baku.id_barang_baku AND MONTH(tanggal_stok_awal_baku) <= ' . $bulan . ' AND YEAR(tanggal_stok_awal_baku) <= ' . $tahun . ') AS jumlah_stok_awal,
    //     (SELECT IFNULL(SUM(jumlah_masuk), 0) FROM masuk_baku WHERE masuk_baku.id_barang_baku = barang_baku.id_barang_baku AND MONTH(tanggal_masuk) < ' . $bulan . ' AND YEAR(tanggal_masuk) = ' . $tahun . ' AND masuk_baku.status_masuk = 1) AS jumlah_masuk_kemaren,
    //     (SELECT IFNULL(SUM(jumlah_masuk), 0) FROM masuk_baku WHERE masuk_baku.id_barang_baku = barang_baku.id_barang_baku AND MONTH(tanggal_masuk) = ' . $bulan . ' AND YEAR(tanggal_masuk) = ' . $tahun . ' AND masuk_baku.status_masuk = 1) AS jumlah_masuk_sekarang,
    //     (SELECT IFNULL(SUM(jumlah_masuk), 0) FROM masuk_baku WHERE masuk_baku.id_barang_baku = barang_baku.id_barang_baku AND MONTH(tanggal_masuk) <= ' . $bulan . ' AND YEAR(tanggal_masuk) <= ' . $tahun . ' AND masuk_baku.status_masuk = 1) AS jumlah_masuk,
    //     (SELECT IFNULL(SUM(jumlah_keluar), 0) FROM keluar_baku WHERE keluar_baku.id_barang_baku = barang_baku.id_barang_baku AND MONTH(tanggal_keluar) < ' . $bulan . ' AND YEAR(tanggal_keluar) = ' . $tahun . ' AND keluar_baku.status_keluar = 1) AS jumlah_keluar_kemaren,
    //     (SELECT IFNULL(SUM(jumlah_keluar), 0) FROM keluar_baku WHERE keluar_baku.id_barang_baku = barang_baku.id_barang_baku AND MONTH(tanggal_keluar) = ' . $bulan . ' AND YEAR(tanggal_keluar) = ' . $tahun . ' AND keluar_baku.status_keluar = 1) AS jumlah_keluar_sekarang,
    //     (SELECT IFNULL(SUM(jumlah_keluar), 0) FROM keluar_baku WHERE keluar_baku.id_barang_baku = barang_baku.id_barang_baku AND MONTH(tanggal_keluar) <= ' . $bulan . ' AND YEAR(tanggal_keluar) <= ' . $tahun . ' AND keluar_baku.status_keluar = 1) AS jumlah_keluar,
    //     (SELECT IFNULL(SUM(jumlah_rusak_baku), 0) FROM rusak_baku WHERE rusak_baku.id_barang_baku = barang_baku.id_barang_baku AND MONTH(tanggal_rusak_baku) = ' . $bulan . ' AND YEAR(tanggal_rusak_baku) = ' . $tahun . ' AND rusak_baku.status_rusak_baku = 1) AS jumlah_rusak_sekarang,
    //     (SELECT IFNULL(SUM(jumlah_rusak_baku), 0) FROM rusak_baku WHERE rusak_baku.id_barang_baku = barang_baku.id_barang_baku AND MONTH(tanggal_rusak_baku) < ' . $bulan . ' AND YEAR(tanggal_rusak_baku) = ' . $tahun . ' AND rusak_baku.status_rusak_baku = 1) AS jumlah_rusak_kemaren,
    //     (SELECT IFNULL(SUM(jumlah_rusak_baku), 0) FROM rusak_baku WHERE rusak_baku.id_barang_baku = barang_baku.id_barang_baku AND MONTH(tanggal_rusak_baku) <= ' . $bulan . ' AND YEAR(tanggal_rusak_baku) <= ' . $tahun . ') AS jumlah_rusak', FALSE);
    //     $this->db->from('barang_baku');
    //     $this->db->join('stok_awal_baku', 'stok_awal_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
    //     $this->db->join('masuk_baku', 'masuk_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
    //     $this->db->join('keluar_baku', 'keluar_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
    //     $this->db->join('rusak_baku', 'rusak_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
    //     $this->db->join('satuan', 'satuan.id_satuan = barang_baku.id_satuan', 'left');
    //     $this->db->join('jenis_barang', 'jenis_barang.id_jenis_barang = barang_baku.id_jenis_barang', 'left');
    //     $this->db->where('barang_baku.status_barang_baku', 1);
    //     $this->db->group_by('barang_baku.id_barang_baku');
    //     return $this->db->get()->result();
    // }

}
