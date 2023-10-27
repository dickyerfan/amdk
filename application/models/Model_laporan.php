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


    public function getdata_bulanan($tanggal, $bulan, $tahun)
    {
        $this->db->select('*, barang_baku.*, 
            (SELECT IFNULL(SUM(jumlah_stok_awal_baku), 0) FROM stok_awal_baku WHERE stok_awal_baku.id_barang_baku = barang_baku.id_barang_baku AND DATE(tanggal_stok_awal_baku) <= DATE("' . $tanggal . '")) AS jumlah_stok_awal,

            (SELECT IFNULL(SUM(jumlah_masuk), 0) FROM masuk_baku WHERE 
            ((YEAR(tanggal_masuk) < ' . $tahun . ')
            OR
            (YEAR(tanggal_masuk) = ' . $tahun . ' AND MONTH(tanggal_masuk) < ' . $bulan . '))
            AND masuk_baku.id_barang_baku = barang_baku.id_barang_baku AND masuk_baku.status_masuk = 1
            ) AS jumlah_masuk_kemaren,

            (SELECT IFNULL(SUM(jumlah_masuk), 0) FROM masuk_baku WHERE masuk_baku.id_barang_baku = barang_baku.id_barang_baku AND MONTH(tanggal_masuk) = ' . $bulan . ' AND YEAR(tanggal_masuk) = ' . $tahun . ' AND masuk_baku.status_masuk = 1) AS jumlah_masuk_sekarang,

            (SELECT IFNULL(SUM(jumlah_masuk), 0) FROM masuk_baku WHERE 
                ((YEAR(tanggal_masuk) = ' . $tahun . ' AND MONTH(tanggal_masuk) <= ' . $bulan . ')
                    OR
                    (YEAR(tanggal_masuk) < ' . $tahun . '))
                AND masuk_baku.id_barang_baku = barang_baku.id_barang_baku AND masuk_baku.status_masuk = 1
            ) AS jumlah_masuk,

            (SELECT IFNULL(SUM(jumlah_keluar), 0) FROM keluar_baku WHERE 
            ((YEAR(tanggal_keluar) < ' . $tahun . ')
            OR
            (YEAR(tanggal_keluar) = ' . $tahun . ' AND MONTH(tanggal_keluar) < ' . $bulan . '))
            AND keluar_baku.id_barang_baku = barang_baku.id_barang_baku AND keluar_baku.status_keluar = 1
            ) AS jumlah_keluar_kemaren,

            (SELECT IFNULL(SUM(jumlah_keluar), 0) FROM keluar_baku WHERE keluar_baku.id_barang_baku = barang_baku.id_barang_baku AND MONTH(tanggal_keluar) = ' . $bulan . ' AND YEAR(tanggal_keluar) = ' . $tahun . ' AND keluar_baku.status_keluar = 1) AS jumlah_keluar_sekarang,

            (SELECT IFNULL(SUM(jumlah_keluar), 0) FROM keluar_baku WHERE 
                ((YEAR(tanggal_keluar) = ' . $tahun . ' AND MONTH(tanggal_keluar) <= ' . $bulan . ')
                    OR
                    (YEAR(tanggal_keluar) < ' . $tahun . '))
                AND keluar_baku.id_barang_baku = barang_baku.id_barang_baku AND keluar_baku.status_keluar = 1
            ) AS jumlah_keluar,

            (SELECT IFNULL(SUM(jumlah_rusak_baku), 0) FROM rusak_baku WHERE rusak_baku.id_barang_baku = barang_baku.id_barang_baku AND MONTH(tanggal_rusak_baku) = ' . $bulan . ' AND YEAR(tanggal_rusak_baku) = ' . $tahun . ' AND rusak_baku.status_rusak_baku = 1) AS jumlah_rusak_sekarang,

            (SELECT IFNULL(SUM(jumlah_rusak_baku), 0) FROM rusak_baku WHERE 
            ((YEAR(tanggal_rusak_baku) < ' . $tahun . ')
            OR
            (YEAR(tanggal_rusak_baku) = ' . $tahun . ' AND MONTH(tanggal_rusak_baku) < ' . $bulan . '))
            AND rusak_baku.id_barang_baku = barang_baku.id_barang_baku AND rusak_baku.status_rusak_baku = 1
            ) AS jumlah_rusak_kemaren,

            (SELECT IFNULL(SUM(jumlah_rusak_baku), 0) FROM rusak_baku WHERE 
                ((YEAR(tanggal_rusak_baku) = ' . $tahun . ' AND MONTH(tanggal_rusak_baku) <= ' . $bulan . ')
                    OR
                    (YEAR(tanggal_rusak_baku) < ' . $tahun . '))
                AND rusak_baku.id_barang_baku = barang_baku.id_barang_baku AND rusak_baku.status_rusak_baku = 1
            ) AS jumlah_rusak', FALSE);

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

    public function get_manager()
    {
        $this->db->select('nama_karyawan, nik_karyawan');
        $this->db->from('karyawan');
        $this->db->where('bagian', 'Manager');
        return $this->db->get()->row();
    }
    public function get_baku()
    {
        $this->db->select('nama_karyawan, nik_karyawan');
        $this->db->from('karyawan');
        $this->db->where('bagian', 'Barang Baku');
        $this->db->limit(1);
        return $this->db->get()->row();
    }
    public function get_produksi()
    {
        $this->db->select('nama_karyawan, nik_karyawan');
        $this->db->from('karyawan');
        $this->db->where('bagian', 'Produksi');
        $this->db->limit(1);
        return $this->db->get()->row();
    }

    public function get_jadi()
    {
        $this->db->select('nama_karyawan, nik_karyawan');
        $this->db->from('karyawan');
        $this->db->where('bagian', 'Barang Jadi');
        $this->db->limit(1);
        return $this->db->get()->row();
    }

    public function getbarang_jadi($tanggal)
    {
        $this->db->select('*');
        $this->db->from('barang_jadi');
        $this->db->join('jenis_barang', 'barang_jadi.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
        $this->db->where('barang_jadi.tanggal_barang_jadi', $tanggal);
        // $this->db->where('YEAR(barang_jadi.tanggal_barang_jadi)', $tahun);
        $this->db->group_by('barang_jadi.id_barang_jadi');
        $this->db->order_by('barang_jadi.id_barang_jadi', 'DESC');
        return $this->db->get()->result();
    }

    public function get_jenis_barang()
    {
        $this->db->select('*');
        $this->db->from('barang_jadi');
        $this->db->join('jenis_barang', 'jenis_barang.id_jenis_barang = barang_jadi.id_jenis_barang');
        return $this->db->get()->result();
    }

    // public function get_nama_barang()
    // {
    //     $this->db->select('nama_barang_jadi');
    //     $this->db->from('jenis_barang');
    //     return $this->db->get()->result_array();
    // }

    public function get_nama_barang()
    {
        $this->db->select('nama_barang_jadi');
        $this->db->from('jenis_barang');
        $result = $this->db->get()->result();

        $nama_barang = [];
        foreach ($result as $row) {
            $nama_barang[] = $row->nama_barang_jadi;
        }
        return $nama_barang;
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
