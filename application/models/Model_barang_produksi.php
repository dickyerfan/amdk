<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_barang_produksi extends CI_Model
{

    // public function getdata()
    // {
    //     $this->db->select('*,barang_baku.*, 
    //                (SELECT SUM(jumlah_masuk) FROM masuk_baku WHERE masuk_baku.id_barang_baku = barang_baku.id_barang_baku) AS jumlah_masuk, 
    //                (SELECT SUM(jumlah_rusak) FROM rusak_baku WHERE rusak_baku.id_barang_baku = barang_baku.id_barang_baku) AS jumlah_rusak, 
    //                (SELECT SUM(jumlah_keluar) FROM keluar_baku WHERE keluar_baku.id_barang_baku = barang_baku.id_barang_baku) AS jumlah_keluar', FALSE);
    //     $this->db->from('barang_baku');
    //     $this->db->join('masuk_baku', 'masuk_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
    //     $this->db->join('keluar_baku', 'keluar_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
    //     $this->db->join('rusak_baku', 'rusak_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
    //     $this->db->join('satuan', 'satuan.id_satuan = barang_baku.id_satuan', 'left');
    //     $this->db->join('jenis_barang', 'jenis_barang.id_jenis_barang = barang_baku.id_jenis_barang', 'left');
    //     $this->db->where('barang_baku.status_barang_baku', 1);
    //     $this->db->group_by('barang_baku.id_barang_baku');
    //     return $this->db->get()->result();
    // }


    // public function getbarang_masuk()
    // {
    //     $this->db->select('*');
    //     $this->db->from('masuk_baku');
    //     $this->db->join('barang_baku', 'masuk_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
    //     $this->db->where('masuk_baku.status_masuk', 1);
    //     $this->db->group_by('masuk_baku.id_masuk_baku');
    //     return $this->db->get()->result();
    // }

    public function get_barangbaku_produksi()
    {
        $this->db->select('*,barang_baku.*, 
                   (SELECT SUM(jumlah_keluar) FROM keluar_baku WHERE keluar_baku.id_barang_baku = barang_baku.id_barang_baku AND keluar_baku.status_tolak = 1 AND keluar_baku.status_keluar = 1) AS jumlah_keluar', FALSE);
        $this->db->from('barang_baku');
        $this->db->join('keluar_baku', 'keluar_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->join('satuan', 'satuan.id_satuan = barang_baku.id_satuan', 'left');
        $this->db->join('jenis_barang', 'jenis_barang.id_jenis_barang = barang_baku.id_jenis_barang', 'left');
        $this->db->where('barang_baku.status_barang_baku', 1);
        $this->db->group_by('barang_baku.id_barang_baku');
        return $this->db->get()->result();
    }

    public function get_permintaan_barang($bulan, $tahun)
    {
        $this->db->select('*');
        $this->db->from('keluar_baku');
        $this->db->join('barang_baku', 'keluar_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->where('keluar_baku.status_tolak', 1);
        $this->db->where('MONTH(keluar_baku.tanggal_keluar)', $bulan);
        $this->db->where('YEAR(keluar_baku.tanggal_keluar)', $tahun);
        $this->db->group_by('keluar_baku.id_keluar_baku');
        $this->db->order_by('keluar_baku.id_keluar_baku', 'DESC');
        return $this->db->get()->result();
    }

    public function tambahData($data)
    {
        // $this->db->insert('baku_produksi', $data);
        return $this->db->insert('keluar_baku', $data);
    }
    public function upload_barang_jadi($data)
    {
        // $this->db->insert('baku_produksi', $data);
        return $this->db->insert('barang_jadi', $data);
    }

    public function get_nama_barang()
    {
        $this->db->select('*');
        $this->db->from('barang_baku');
        return $this->db->get()->result();
    }
    public function get_jenis_barang()
    {
        $this->db->select('*');
        $this->db->from('jenis_barang');
        return $this->db->get()->result();
    }

    public function get_Id_Barang($table, $where)
    {
        return $this->db->get_where($table, $where);
    }

    public function get_Id_Barang_edit($id_keluar_baku)
    {
        return $this->db->get_where('keluar_baku', ['id_keluar_baku' => $id_keluar_baku])->row();
    }

    public function update_Barang($where, $data, $table)
    {
        $this->db->where($where);
        return $this->db->update($table, $data);
    }

    public function hapusData($id_keluar_baku)
    {
        $this->db->where('id_keluar_baku', $id_keluar_baku);
        return $this->db->delete('keluar_baku');
    }

    public function tolak_pesanan($id_keluar_baku, $data)
    {
        $this->db->where('id_keluar_baku', $id_keluar_baku);
        return $this->db->update('keluar_baku', $data);
    }

    public function Update_status_barang_jadi($id_barang_jadi, $data)
    {
        $this->db->where('id_barang_jadi', $id_barang_jadi);
        return $this->db->update('barang_jadi', $data);
    }

    public function getbarang_rusak()
    {
        $this->db->select('*');
        $this->db->from('rusak_produksi');
        $this->db->join('barang_baku', 'rusak_produksi.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->group_by('rusak_produksi.id_rusak_produksi');
        return $this->db->get()->result();
    }

    public function get_detail_barang_rusak($id_rusak_produksi)
    {
        $this->db->select('*');
        $this->db->from('rusak_produksi');
        $this->db->join('barang_baku', 'rusak_produksi.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->where('id_rusak_produksi', $id_rusak_produksi);
        $this->db->group_by('rusak_produksi.id_rusak_produksi');
        return $this->db->get()->result();
    }

    public function getbarang_jadi()
    {
        $this->db->select('*');
        $this->db->from('barang_jadi');
        $this->db->join('jenis_barang', 'barang_jadi.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
        $this->db->where_not_in('barang_jadi.jumlah_barang_jadi', 0);
        $this->db->group_by('barang_jadi.id_barang_jadi');
        $this->db->order_by('barang_jadi.id_barang_jadi', 'DESC');
        return $this->db->get()->result();
    }
}
