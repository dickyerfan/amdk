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

    // transaksi barang keluar
    public function getbarang_keluar()
    {
        $this->db->select('tanggal_keluar_baku, nama_barang_jadi,input_keluar_baku, jenis_barang.id_jenis_barang, jenis_barang.nama_barang_jadi, SUM(jumlah_keluar_baku) as total_keluar_baku');
        $this->db->from('keluar_baku_produksi');
        $this->db->join('barang_baku', 'keluar_baku_produksi.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->join('jenis_barang', 'keluar_baku_produksi.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
        $this->db->group_by('keluar_baku_produksi.tanggal_keluar_baku');
        $this->db->group_by('jenis_barang.nama_barang_jadi');
        $this->db->order_by('id_keluar_baku_produksi', 'ASC');
        return $this->db->get()->result();
    }

    public function get_detail_barang_keluar($id_jenis_barang, $tanggal)
    {
        $this->db->select('*');
        $this->db->from('keluar_baku_produksi');
        $this->db->join('jenis_barang', 'keluar_baku_produksi.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
        $this->db->join('barang_baku', 'keluar_baku_produksi.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->where('jenis_barang.id_jenis_barang', $id_jenis_barang);
        $this->db->where('tanggal_keluar_baku', $tanggal);
        return $this->db->get()->result();
    }



    public function get_barangbaku_produksi()
    {
        $this->db->select('*,barang_baku.*, 
                   (SELECT SUM(jumlah_keluar) FROM baku_produksi WHERE baku_produksi.id_barang_baku = barang_baku.id_barang_baku AND baku_produksi.status_tolak = 1 AND baku_produksi.status_keluar = 1) AS jumlah_masuk,
                   (SELECT SUM(jumlah_stok_awal_baku) FROM stok_awal_baku_produksi WHERE stok_awal_baku_produksi.id_barang_baku = barang_baku.id_barang_baku) AS jumlah_stok_awal,
                   (SELECT SUM(jumlah_keluar_baku) FROM keluar_baku_produksi WHERE keluar_baku_produksi.id_barang_baku = barang_baku.id_barang_baku) AS jumlah_keluar,
                   (SELECT SUM(jumlah_rusak_produksi) FROM rusak_produksi WHERE rusak_produksi.id_barang_baku = barang_baku.id_barang_baku) AS jumlah_rusak', FALSE);
        $this->db->from('barang_baku');
        $this->db->join('baku_produksi', 'baku_produksi.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->join('keluar_baku_produksi', 'keluar_baku_produksi.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->join('rusak_produksi', 'rusak_produksi.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->join('stok_awal_baku_produksi', 'stok_awal_baku_produksi.id_barang_baku = barang_baku.id_barang_baku', 'left');
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
        $this->db->insert('baku_produksi', $data);
        return $this->db->insert('keluar_baku', $data);
    }
    public function upload_barang_jadi($data)
    {
        $jenis_barang_info = $this->getJumlahSatuanLiter($data['id_jenis_barang'], $data['jumlah_barang_jadi']);
        $data['jumlah_satuan'] = $jenis_barang_info['jumlah_satuan'];
        $data['jumlah_liter'] = $jenis_barang_info['jumlah_liter'];
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
        $this->db->update('baku_produksi', $data);
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

    public function getJumlahSatuanLiter($id_jenis_barang, $jumlah_barang_jadi)
    {
        $this->db->select('jenis_barang');
        $this->db->from('jenis_barang');
        $this->db->where('id_jenis_barang', $id_jenis_barang);
        $query = $this->db->get();
        $jenis_barang = $query->row();

        $jumlah_satuan = 0;
        $jumlah_liter = 0;

        if ($jenis_barang) {
            if ($jenis_barang->jenis_barang == 'galon 19l') {
                $jumlah_satuan = $jumlah_barang_jadi;
                $jumlah_liter = $jumlah_barang_jadi * 19;
            } elseif ($jenis_barang->jenis_barang == 'gelas 220ml') {
                $jumlah_satuan = $jumlah_barang_jadi * 48;
                $jumlah_liter = ($jumlah_barang_jadi * 220) / 1000;
            } elseif ($jenis_barang->jenis_barang == 'botol 330ml') {
                $jumlah_satuan = $jumlah_barang_jadi * 24;
                $jumlah_liter = ($jumlah_barang_jadi * 24 * 330) / 1000;
            } elseif ($jenis_barang->jenis_barang == 'botol 500ml') {
                $jumlah_satuan = $jumlah_barang_jadi * 24;
                $jumlah_liter = ($jumlah_barang_jadi * 24 * 500) / 1000;
            } elseif ($jenis_barang->jenis_barang == 'botol 1500ml') {
                $jumlah_satuan = $jumlah_barang_jadi * 12;
                $jumlah_liter = ($jumlah_barang_jadi * 12 * 1500) / 1000;
            }
        }

        return array('jumlah_satuan' => $jumlah_satuan, 'jumlah_liter' => $jumlah_liter);
    }

    public function getBarangBakuInfo($id_jenis_barang)
    {
        $this->db->where('id_jenis_barang', $id_jenis_barang);
        $query = $this->db->get('barang_baku_produksi');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array(); // Mengembalikan array kosong jika tidak ada data yang ditemukan.
        }
    }

    public function insert_keluar_baku($data_keluar_baku)
    {
        // Gantilah 'keluar_baku_produksi' dengan nama tabel yang sesuai pada database Anda.
        return $this->db->insert('keluar_baku_produksi', $data_keluar_baku);
    }
}
