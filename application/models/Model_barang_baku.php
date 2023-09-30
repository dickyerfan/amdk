<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_barang_baku extends CI_Model
{

    public function getdata()
    {
        $this->db->select('*,barang_baku.*, 
                   (SELECT SUM(jumlah_stok_awal_baku) FROM stok_awal_baku WHERE stok_awal_baku.id_barang_baku = barang_baku.id_barang_baku) AS jumlah_stok_awal, 
                   (SELECT SUM(jumlah_masuk) FROM masuk_baku WHERE masuk_baku.id_barang_baku = barang_baku.id_barang_baku) AS jumlah_masuk, 
                   (SELECT SUM(jumlah_rusak_baku) FROM rusak_baku WHERE rusak_baku.id_barang_baku = barang_baku.id_barang_baku) AS jumlah_rusak, 
                   (SELECT SUM(jumlah_keluar) FROM keluar_baku WHERE keluar_baku.id_barang_baku = barang_baku.id_barang_baku AND keluar_baku.status_keluar = 1) AS jumlah_keluar', FALSE);
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
        $this->db->where('masuk_baku.status_masuk', 1);
        $this->db->group_by('masuk_baku.id_masuk_baku');
        return $this->db->get()->result();
    }

    public function getbarang_keluar()
    {
        $this->db->select('*');
        $this->db->from('keluar_baku');
        $this->db->join('barang_baku', 'keluar_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->where('keluar_baku.status_keluar', 0);
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
}
