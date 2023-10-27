<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_barang_jadi extends CI_Model
{

    public function getdata()
    {
        $tahun_sekarang = date('Y');
        $this->db->select('*,jenis_barang.*, 
        COALESCE(
            (SELECT SUM(jumlah_stok_awal_jadi) 
             FROM stok_awal_jadi 
             WHERE stok_awal_jadi.id_jenis_barang = jenis_barang.id_jenis_barang 
             AND YEAR(stok_awal_jadi.tanggal_stok_awal_jadi) = ' . $tahun_sekarang . '), 
            (SELECT SUM(jumlah_stok_awal_jadi) 
             FROM stok_awal_jadi 
             WHERE stok_awal_jadi.id_jenis_barang = jenis_barang.id_jenis_barang)
        ) AS jumlah_stok_awal,

                   (SELECT SUM(jumlah_barang_jadi) FROM barang_jadi WHERE barang_jadi.id_jenis_barang = jenis_barang.id_jenis_barang AND barang_jadi.status_barang_jadi = 1) AS jumlah_masuk, 
                   (SELECT SUM(jumlah_rusak_jadi) FROM rusak_jadi WHERE rusak_jadi.id_jenis_barang = jenis_barang.id_jenis_barang) AS jumlah_rusak, 
                   (SELECT SUM(jumlah_keluar) FROM keluar_jadi WHERE keluar_jadi.id_jenis_barang = jenis_barang.id_jenis_barang AND keluar_jadi.status_keluar = 1) AS jumlah_keluar', FALSE);
        $this->db->from('jenis_barang');
        $this->db->join('stok_awal_jadi', 'stok_awal_jadi.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
        $this->db->join('barang_jadi', 'barang_jadi.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
        $this->db->join('keluar_jadi', 'keluar_jadi.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
        $this->db->join('rusak_jadi', 'rusak_jadi.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
        // $this->db->join('stok_minimum_jadi', 'stok_minimum_jadi.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
        // $this->db->join('satuan', 'satuan.id_satuan = barang_baku.id_satuan', 'left');
        // $this->db->where('barang_baku.status_barang_baku', 1);
        // $this->db->group_by('barang_baku.id_barang_baku');
        return $this->db->get()->result();
    }

    // public function getdata()
    // {
    //     $tahun_sekarang = date('Y');
    //     $this->db->select('*,jenis_barang.*, 
    //     COALESCE(
    //         (SELECT SUM(jumlah_stok_awal_jadi) 
    //          FROM stok_awal_jadi 
    //          WHERE stok_awal_jadi.id_jenis_barang = jenis-barang.id_jenis_barang 
    //          AND YEAR(stok_awal_jadi.tanggal_stok_awal_jadi) = ' . $tahun_sekarang . '), 
    //         (SELECT SUM(jumlah_stok_awal_jadi) 
    //          FROM stok_awal_jadi 
    //          WHERE stok_awal_jadi.id_jenis_barang = jenis_barang.id_jenis_barang)
    //     ) AS jumlah_stok_awal,
    //                (SELECT SUM(isi_stok_minimum_jadi) FROM stok_minimum_jadi WHERE stok_minimum_jadi.id_jenis_barang = jenis_barang.id_jenis_barang AND stok_minimum_jadi.status_stok_minimum_jadi = 1) AS isi_stok_minimum, 
    //                (SELECT SUM(jumlah_stok_minimum_jadi) FROM stok_minimum_jadi WHERE stok_minimum_jadi.id_jenis_barang = jenis_barang.id_jenis_barang AND stok_minimum_jadi.status_stok_minimum_jadi = 1) AS jumlah_stok_minimum, 
    //                (SELECT SUM(jumlah_barang_jadi) FROM barang_jadi WHERE barang_jadi.id_jenis_barang = jenis_barang.id_jenis_barang AND barang_jadi.status_masuk_jadi = 1) AS jumlah_masuk, 
    //                (SELECT SUM(jumlah_rusak_jadi) FROM rusak_jadi WHERE rusak_jadi.id_jenis_barang = jenis_barang.id_jenis_barang) AS jumlah_rusak, 
    //                (SELECT SUM(jumlah_keluar_jadi) FROM keluar_jadi WHERE keluar_jadi.id_jenis_barang = jenis_barang.id_jenis_barang AND keluar_baku.status_keluar_jadi = 1) AS jumlah_keluar', FALSE);
    //     $this->db->from('jenis_barang');
    //     $this->db->join('stok_awal_jadi', 'stok_awal_jadi.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
    //     $this->db->join('barang_jadi', 'barang_jadi.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
    //     $this->db->join('keluar_jadi', 'keluar_jadi.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
    //     $this->db->join('rusak_jadi', 'rusak_jadi.id_jenis_barang = jensi_barang.id_jenis_barang', 'left');
    //     $this->db->join('stok_minimum_jadi', 'stok_minimum_jadi.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
    //     $this->db->join('satuan', 'satuan.id_satuan = barang_baku.id_satuan', 'left');
    //     // $this->db->where('barang_baku.status_barang_baku', 1);
    //     // $this->db->group_by('barang_baku.id_barang_baku');
    //     return $this->db->get()->result();
    // }


    public function upload($table, $data)
    {
        $this->db->insert($table, $data);
    }


    public function get_satuan()
    {
        $this->db->select('*');
        $this->db->from('satuan');
        return $this->db->get()->result();
    }

    public function get_jenis_barang()
    {
        $this->db->select('*');
        $this->db->from('jenis_barang');
        return $this->db->get()->result();
    }



    public function getbarang_masuk()
    {
        $this->db->select('*');
        $this->db->from('masuk_baku');
        $this->db->join('barang_baku', 'masuk_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        // $this->db->where('masuk_baku.status_masuk', 1);
        $this->db->group_by('masuk_baku.id_masuk_baku');
        $this->db->order_by('masuk_baku.id_masuk_baku', 'DESC');
        return $this->db->get()->result();
    }

    public function get_id_masuk_baku($id_masuk_baku)
    {
        return $this->db->get_where('masuk_baku', ['id_masuk_baku' => $id_masuk_baku])->row();
    }

    public function update_masuk($data)
    {
        $this->db->where('id_masuk_baku', $data['id_masuk_baku']);
        $this->db->set('bukti_masuk_gd', $data['bukti_masuk_gd']);
        $this->db->set('status_masuk', $data['status_masuk']);
        $this->db->set('tgl_update_masuk', $data['tgl_update_masuk']);
        $this->db->update('masuk_baku');
    }

    public function get_detail_barang_masuk($id_masuk_baku)
    {
        $this->db->select('*');
        $this->db->from('masuk_baku');
        $this->db->join('barang_baku', 'masuk_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->where('id_masuk_baku', $id_masuk_baku);
        $this->db->group_by('masuk_baku.id_masuk_baku');
        return $this->db->get()->result();
    }

    //upload stok awal
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
    //upload stok awal

    //barang_masuk
    public function getbarang_jadi($bulan, $tahun)
    {
        $this->db->select('*');
        $this->db->from('barang_jadi');
        $this->db->join('jenis_barang', 'barang_jadi.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
        $this->db->where('MONTH(barang_jadi.tanggal_barang_jadi)', $bulan);
        $this->db->where('YEAR(barang_jadi.tanggal_barang_jadi)', $tahun);
        $this->db->group_by('barang_jadi.id_barang_jadi');
        $this->db->order_by('barang_jadi.id_barang_jadi', 'DESC');
        return $this->db->get()->result();
    }
    //barang_masuk

    public function getbarang_keluar()
    {
        $this->db->select('*');
        $this->db->from('keluar_baku');
        $this->db->join('barang_baku', 'keluar_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->where('keluar_baku.status_keluar', 0);
        $this->db->group_by('keluar_baku.id_keluar_baku');
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

    public function getbarang_rusak()
    {
        $this->db->select('*');
        $this->db->from('rusak_baku');
        $this->db->join('barang_baku', 'rusak_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->group_by('rusak_baku.id_rusak_baku');
        return $this->db->get()->result();
    }

    public function get_detail_barang_rusak($id_rusak_baku)
    {
        $this->db->select('*');
        $this->db->from('rusak_baku');
        $this->db->join('barang_baku', 'rusak_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->where('id_rusak_baku', $id_rusak_baku);
        $this->db->group_by('rusak_baku.id_rusak_baku');
        return $this->db->get()->result();
    }

    public function get_permintaan_barang()
    {
        $this->db->select('*');
        $this->db->from('keluar_baku');
        $this->db->join('barang_baku', 'keluar_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->where('keluar_baku.status_tolak', 1);
        $this->db->group_by('keluar_baku.id_keluar_baku');
        $this->db->order_by('keluar_baku.id_keluar_baku', 'DESC');
        return $this->db->get()->result();
    }
}
