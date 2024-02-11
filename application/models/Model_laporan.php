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

    // Laporan Bulanan barang baku
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

    // laporan barang produksi
    public function get_jenis_barang()
    {
        $this->db->select('*');
        $this->db->from('barang_jadi');
        $this->db->join('jenis_barang', 'jenis_barang.id_jenis_barang = barang_jadi.id_jenis_barang');
        $this->db->where('barang_jadi.status_barang_produksi', 1);
        return $this->db->get()->result();
    }

    public function get_nama_barang()
    {
        $this->db->select('nama_produk');
        $this->db->from('jenis_produk');
        $result = $this->db->get()->result();

        $nama_barang = [];
        foreach ($result as $row) {
            $nama_barang[] = $row->nama_produk;
        }
        return $nama_barang;
    }

    // laporan pemasaran
    public function get_penjualan()
    {
        $this->db->select('jenis_produk.nama_produk,pemesanan.id_jenis_barang, pemesanan.tanggal_pesan, SUM(pemesanan.jumlah_pesan) as total_pesanan');
        $this->db->from('pemesanan');
        $this->db->join('jenis_produk', 'jenis_produk.id_produk = pemesanan.id_jenis_barang');
        // $this->db->where('pemesanan.status_nota', 1);
        $this->db->where('pemesanan.id_mobil IS NOT NULL');
        $this->db->where('pemesanan.jenis_pesanan', 2);
        $this->db->or_where('pemesanan.jenis_pesanan', 3);
        $this->db->or_where('pemesanan.jenis_pesanan', 4);
        $this->db->group_by('jenis_produk.nama_produk, pemesanan.tanggal_pesan'); // Mengelompokkan berdasarkan tanggal dan produk
        return $this->db->get()->result();
    }



    // laporan barang jadi
    public function get_nama_barang_jadi()
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

    public function get_jenis_barang_jadi()
    {
        $this->db->select('*');
        $this->db->from('barang_jadi');
        $this->db->join('jenis_barang', 'jenis_barang.id_jenis_barang = barang_jadi.id_jenis_barang');
        $this->db->where('barang_jadi.status_barang_jadi', 1);
        return $this->db->get()->result();
    }

    // Laporan keuangan
    public function get_lunas()
    {
        $this->db->select('jenis_produk.nama_produk,pemesanan.id_jenis_barang, pemesanan.tanggal_pesan, SUM(pemesanan.total_harga) as total_harga');
        $this->db->from('pemesanan');
        $this->db->join('jenis_produk', 'jenis_produk.id_produk = pemesanan.id_jenis_barang');
        $this->db->where('status_piutang', 0);
        $this->db->where('jenis_pesanan', 2);
        $this->db->or_where('jenis_pesanan', 3);
        // $this->db->or_where('jenis_pesanan', 4);
        $this->db->group_by('jenis_produk.nama_produk, pemesanan.tanggal_pesan'); // Mengelompokkan berdasarkan tanggal dan produk
        return $this->db->get()->result();
    }
    public function get_piutang()
    {
        $this->db->select('jenis_produk.nama_produk,pemesanan.id_jenis_barang, pemesanan.tanggal_pesan, SUM(pemesanan.total_harga) as total_harga');
        $this->db->from('pemesanan');
        $this->db->join('jenis_produk', 'jenis_produk.id_produk = pemesanan.id_jenis_barang');
        $this->db->where('status_piutang', 1);
        $this->db->where('jenis_pesanan', 2);
        $this->db->or_where('jenis_pesanan', 3);
        $this->db->or_where('jenis_pesanan', 4);
        $this->db->group_by('jenis_produk.nama_produk, pemesanan.tanggal_pesan'); // Mengelompokkan berdasarkan tanggal dan produk
        return $this->db->get()->result();
    }

    public function get_penerimaan()
    {
        $this->db->select('jenis_produk.nama_produk,pemesanan.id_jenis_barang, pemesanan.tanggal_bayar, SUM(pemesanan.total_harga) as total_harga');
        $this->db->from('pemesanan');
        $this->db->join('jenis_produk', 'jenis_produk.id_produk = pemesanan.id_jenis_barang');
        $this->db->where('status_setor', 1);
        $this->db->group_by('jenis_produk.id_produk, jenis_produk.nama_produk, pemesanan.id_jenis_barang, pemesanan.tanggal_bayar');
        $this->db->order_by('pemesanan.tanggal_bayar', 'asc');
        return $this->db->get()->result();
    }

    public function get_jumlah_barang()
    {
        $this->db->select('jenis_produk.nama_produk,pemesanan.id_jenis_barang, pemesanan.tanggal_bayar, pemesanan.jumlah_pesan, SUM(pemesanan.jumlah_pesan) as total_barang');
        $this->db->from('pemesanan');
        $this->db->join('jenis_produk', 'jenis_produk.id_produk = pemesanan.id_jenis_barang');
        $this->db->where('status_bayar', 1);
        $this->db->group_by('jenis_produk.id_produk, jenis_produk.nama_produk, pemesanan.id_jenis_barang, pemesanan.tanggal_bayar');
        return $this->db->get()->result();
    }

    public function get_ops($bulan, $tahun)
    {
        $this->db->select('*,jenis_barang.id_jenis_barang, jenis_barang.nama_barang_jadi, pelanggan.nama_pelanggan');
        $this->db->from('ban_ops');
        $this->db->join('jenis_barang', 'ban_ops.id_jenis_barang=jenis_barang.id_jenis_barang');
        $this->db->join('pelanggan', 'ban_ops.id_pelanggan=pelanggan.id_pelanggan', 'left');
        $this->db->where('jenis_ban_ops', 'operasional');
        $this->db->where('MONTH(ban_ops.tanggal_ban_ops)', $bulan);
        $this->db->where('YEAR(ban_ops.tanggal_ban_ops)', $tahun);
        $this->db->order_by('tanggal_ban_ops', 'esc');
        return $this->db->get()->result();
    }

    public function get_ban($bulan, $tahun)
    {
        $this->db->select('*,jenis_barang.id_jenis_barang, jenis_barang.nama_barang_jadi, pelanggan.nama_pelanggan');
        $this->db->from('ban_ops');
        $this->db->join('jenis_barang', 'ban_ops.id_jenis_barang=jenis_barang.id_jenis_barang');
        $this->db->join('pelanggan', 'ban_ops.id_pelanggan=pelanggan.id_pelanggan', 'left');
        $this->db->where('jenis_ban_ops', 'bantuan');
        $this->db->where('MONTH(ban_ops.tanggal_ban_ops)', $bulan);
        $this->db->where('YEAR(ban_ops.tanggal_ban_ops)', $tahun);
        $this->db->order_by('tanggal_ban_ops', 'esc');
        return $this->db->get()->result();
    }

    public function get_jenis_produk()
    {
        $this->db->select('*');
        $this->db->from('jenis_barang');
        return $this->db->get()->result();
    }

    public function get_ambil_air($tanggal_awal, $tanggal_akhir)
    {
        $this->db->select('*, SUM(jumlah) as jumlah_air');
        $this->db->from('truk_tangki');
        $this->db->where('tanggal_ambil_air>=', $tanggal_awal);
        $this->db->where('tanggal_ambil_air <=', $tanggal_akhir);
        $this->db->group_by('tanggal_ambil_air');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_produksi_liter($tanggal_awal, $tanggal_akhir)
    {
        $this->db->select('*, SUM(jumlah_liter) as jumlah_liter');
        $this->db->from('barang_jadi');
        $this->db->where('tanggal_barang_jadi>=', $tanggal_awal);
        $this->db->where('tanggal_barang_jadi <=', $tanggal_akhir);
        $this->db->group_by('tanggal_barang_jadi');
        $query = $this->db->get();
        return $query->result();
    }

    // tanda tangan laporan
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
    public function get_pasar()
    {
        $this->db->select('nama_karyawan, nik_karyawan');
        $this->db->from('karyawan');
        $this->db->where('bagian', 'Pemasaran');
        $this->db->limit(1);
        return $this->db->get()->row();
    }
    public function get_uang()
    {
        $this->db->select('nama_karyawan, nik_karyawan');
        $this->db->from('karyawan');
        $this->db->where('bagian', 'Keuangan');
        $this->db->limit(1);
        return $this->db->get()->row();
    }
}
