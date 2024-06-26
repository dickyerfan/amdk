<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_barang_produksi extends CI_Model
{

    // awal barang keluar
    public function getbarang_keluar($bulan, $tahun)
    {
        $this->db->select('keluar_baku_produksi.tanggal_keluar_baku, nama_barang_jadi,input_keluar_baku, jenis_barang.id_jenis_barang, jenis_barang.nama_barang_jadi, SUM(jumlah_keluar_baku) as total_keluar_baku');
        $this->db->from('keluar_baku_produksi');
        $this->db->join('barang_baku', 'keluar_baku_produksi.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->join('jenis_barang', 'keluar_baku_produksi.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
        $this->db->where('MONTH(keluar_baku_produksi.tanggal_keluar_baku)', $bulan);
        $this->db->where('YEAR(keluar_baku_produksi.tanggal_keluar_baku)', $tahun);
        $this->db->group_by('keluar_baku_produksi.tanggal_keluar_baku');
        $this->db->group_by('jenis_barang.nama_barang_jadi');
        // $this->db->order_by('id_keluar_baku_produksi', 'ASC');
        $this->db->order_by('tanggal_keluar_baku', 'DESC');
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

    public function get_nama_barang()
    {
        $this->db->select('*');
        $this->db->from('barang_baku');
        return $this->db->get()->result();
    }

    public function upload_barang_lainnya($data)
    {
        return $this->db->insert('keluar_baku_produksi', $data);
    }
    // akhir barang keluar

    // awal barang baku produksi
    public function get_barangbaku_produksi()
    {
        $this->db->select('*,barang_baku.*, 
                   (SELECT SUM(jumlah_keluar) FROM keluar_baku WHERE keluar_baku.id_barang_baku = barang_baku.id_barang_baku AND keluar_baku.bagian = "produksi" AND keluar_baku.status_keluar = 1 ) AS jumlah_masuk,
                   (SELECT SUM(jumlah_stok_awal_baku) FROM stok_awal_baku_produksi WHERE stok_awal_baku_produksi.id_barang_baku = barang_baku.id_barang_baku) AS jumlah_stok_awal,
                   (SELECT SUM(jumlah_keluar_baku) FROM keluar_baku_produksi WHERE keluar_baku_produksi.id_barang_baku = barang_baku.id_barang_baku) AS jumlah_keluar,
                   (SELECT SUM(jumlah_rusak_produksi) FROM rusak_produksi WHERE rusak_produksi.id_barang_baku = barang_baku.id_barang_baku) AS jumlah_rusak', FALSE);
        $this->db->from('barang_baku');
        // $this->db->join('keluar_baku', 'keluar_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        // $this->db->join('keluar_baku_produksi', 'keluar_baku_produksi.id_barang_baku = barang_baku.id_barang_baku', 'left');
        // $this->db->join('rusak_produksi', 'rusak_produksi.id_barang_baku = barang_baku.id_barang_baku', 'left');
        // $this->db->join('stok_awal_baku_produksi', 'stok_awal_baku_produksi.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->join('satuan', 'satuan.id_satuan = barang_baku.id_satuan', 'left');
        $this->db->join('jenis_barang', 'jenis_barang.id_jenis_barang = barang_baku.id_jenis_barang', 'left');
        $this->db->where('barang_baku.status_barang_baku', 1);
        // $this->db->group_by('barang_baku.id_barang_baku');
        return $this->db->get()->result();
    }
    // akhir barang baku produksi

    // public function tambahData($data)
    // {
    //     return $this->db->insert('keluar_baku', $data);
    // }

    // awal permintaan barang baku

    public function getbarang_baku($bulan, $tahun)
    {
        $this->db->select('keluar_baku.*, barang_baku.nama_barang_baku');
        $this->db->from('keluar_baku');
        $this->db->join('barang_baku', 'keluar_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->where('keluar_baku.status_tolak', 1);
        $this->db->where('keluar_baku.bagian', 'produksi');
        $this->db->where('MONTH(keluar_baku.tanggal_keluar)', $bulan);
        $this->db->where('YEAR(keluar_baku.tanggal_keluar)', $tahun);
        // $this->db->group_by('keluar_baku.id_keluar_baku');
        $this->db->order_by('keluar_baku.tanggal_keluar', 'DESC');
        $this->db->order_by('keluar_baku.id_keluar_baku', 'DESC');
        return $this->db->get()->result();
    }

    public function get_nama_barang_baku()
    {
        $this->db->select('*');
        $this->db->from('barang_baku');
        return $this->db->get()->result();
    }
    // akhir permintaan barang baku

    // awal barang rusak
    public function getbarang_rusak($bulan, $tahun)
    {
        $this->db->select('*');
        $this->db->from('rusak_produksi');
        $this->db->join('barang_baku', 'rusak_produksi.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->where('MONTH(rusak_produksi.tanggal_rusak_produksi)', $bulan);
        $this->db->where('YEAR(rusak_produksi.tanggal_rusak_produksi)', $tahun);
        $this->db->group_by('rusak_produksi.id_rusak_produksi');
        $this->db->order_by('id_rusak_produksi', 'DESC');
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
    // akhir barang rusak

    // awal barang jadi
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

    public function get_jenis_barang()
    {
        $this->db->select('*');
        $this->db->from('jenis_barang');
        return $this->db->get()->result();
    }

    public function upload_barang_jadi($data)
    {
        $jenis_barang_info = $this->getJumlahSatuanLiter($data['id_jenis_barang'], $data['jumlah_barang_jadi']);
        $data['jumlah_satuan'] = $jenis_barang_info['jumlah_satuan'];
        $data['jumlah_liter'] = $jenis_barang_info['jumlah_liter'];
        return $this->db->insert('barang_jadi', $data);
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
                $jumlah_liter = ($jumlah_barang_jadi * 48 * 220) / 1000;
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
        return $this->db->insert('keluar_baku_produksi', $data_keluar_baku);
    }

    public function update_status_barang_jadi($id_barang_jadi, $data)
    {
        $this->db->where('id_barang_jadi', $id_barang_jadi);
        return $this->db->update('barang_jadi', $data);
    }
    // akhir barang jadi

    // awal pengembalian galon
    public function get_galon($bulan, $tahun)
    {
        $this->db->select('*');
        $this->db->from('galon_kembali');
        // $this->db->join('barang_baku', 'galon_kembali.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->where('MONTH(galon_kembali.tanggal_kembali)', $bulan);
        $this->db->where('YEAR(galon_kembali.tanggal_kembali)', $tahun);
        $this->db->order_by('id_galon_kembali', 'DESC');
        // $this->db->group_by('rusak_produksi.id_rusak_produksi');
        return $this->db->get()->result();
    }

    public function update_galon_kembali($data_galon, $tanggal_barang_jadi)
    {
        $this->db->where('tanggal_kembali', $tanggal_barang_jadi);
        return $this->db->update('galon_kembali', $data_galon);
    }

    public function update_galon_baru($data_galon, $tanggal_keluar_baku)
    {
        $this->db->where('tanggal_kembali', $tanggal_keluar_baku);
        return $this->db->update('galon_kembali', $data_galon);
    }

    // akhir pengembalian galon

    // awal barang keluar
    public function get_jumlah_galon_baru()
    {
        $this->db->select('*,barang_baku.*, 
                   (SELECT SUM(jumlah_keluar) FROM keluar_baku WHERE keluar_baku.id_barang_baku = barang_baku.id_barang_baku AND keluar_baku.bagian = "produksi" ) AS jumlah_masuk,
                   (SELECT SUM(jumlah_stok_awal_baku) FROM stok_awal_baku_produksi WHERE stok_awal_baku_produksi.id_barang_baku = barang_baku.id_barang_baku) AS jumlah_stok_awal,
                   (SELECT SUM(jumlah_keluar_baku) FROM keluar_baku_produksi WHERE keluar_baku_produksi.id_barang_baku = barang_baku.id_barang_baku) AS jumlah_keluar,
                   (SELECT SUM(jumlah_rusak_produksi) FROM rusak_produksi WHERE rusak_produksi.id_barang_baku = barang_baku.id_barang_baku) AS jumlah_rusak', FALSE);
        $this->db->from('barang_baku');
        $this->db->join('keluar_baku', 'keluar_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->join('keluar_baku_produksi', 'keluar_baku_produksi.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->join('rusak_produksi', 'rusak_produksi.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->join('stok_awal_baku_produksi', 'stok_awal_baku_produksi.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->join('satuan', 'satuan.id_satuan = barang_baku.id_satuan', 'left');
        $this->db->join('jenis_barang', 'jenis_barang.id_jenis_barang = barang_baku.id_jenis_barang', 'left');
        $this->db->where('barang_baku.status_barang_baku', 1);
        $this->db->where('barang_baku.id_barang_baku', 1);
        $this->db->group_by('barang_baku.id_barang_baku');
        return $this->db->get()->row();
    }
    // akhir barang keluar

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

    // kode untuk stok awal baku produksi
    public function getstok_awal_baku_produksi()
    {
        $this->db->select('barang_baku.id_barang_baku,barang_baku.nama_barang_baku, jumlah_stok_awal_baku, tanggal_stok_awal_baku,tgl_input_stok_awal_baku, input_status_stok_awal_baku, id_stok_awal_baku_produksi');
        $this->db->from('stok_awal_baku_produksi');
        $this->db->join('barang_baku', 'stok_awal_baku_produksi.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->group_by('stok_awal_baku_produksi.id_stok_awal_baku_produksi');
        return $this->db->get()->result();
    }

    public function get_id_stok_awal($id_stok_awal_baku_produksi)
    {
        $this->db->select('barang_baku.id_barang_baku,barang_baku.nama_barang_baku, jumlah_stok_awal_baku, tanggal_stok_awal_baku,tgl_input_stok_awal_baku, input_status_stok_awal_baku, id_stok_awal_baku_produksi');
        $this->db->from('stok_awal_baku_produksi');
        $this->db->join('barang_baku', 'stok_awal_baku_produksi.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->where('id_stok_awal_baku_produksi', $id_stok_awal_baku_produksi);
        return $this->db->get()->row();
    }

    public function update_stok()
    {

        $data = [
            'jumlah_stok_awal_baku' => $this->input->post('jumlah_stok_awal_baku', true),
            // 'tanggal_stok_awal_baku' => $this->input->post('tanggal_stok_awal_baku', true),
            'input_status_stok_awal_baku' => $this->session->userdata('nama_lengkap'),
            'tgl_input_stok_awal_baku' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_stok_awal_baku_produksi', $this->input->post('id_stok_awal_baku_produksi'));
        $this->db->update('stok_awal_baku_produksi', $data);
    }

    //kode barang baku untuk produksi
    public function getbarang_baku_produksi()
    {
        $this->db->select('*');
        $this->db->from('barang_baku_produksi');
        $this->db->join('barang_baku', 'barang_baku_produksi.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->join('jenis_barang', 'barang_baku_produksi.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
        return $this->db->get()->result();
    }

    public function get_nama_barang_jadi()
    {
        $this->db->select('*');
        $this->db->from('jenis_barang');
        return $this->db->get()->result();
    }

    public function get_id_barang_baku_produksi($id_barang_baku_produksi)
    {
        $this->db->select('*');
        $this->db->from('barang_baku_produksi');
        $this->db->join('barang_baku', 'barang_baku_produksi.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->join('jenis_barang', 'barang_baku_produksi.id_jenis_barang = jenis_barang.id_jenis_barang', 'left');
        $this->db->where('id_barang_baku_produksi', $id_barang_baku_produksi);
        return $this->db->get()->row();
    }

    public function get_all_barang_baku()
    {
        return $this->db->get('barang_baku')->result();
    }

    public function update_stok_bbp()
    {
        $data = [
            'id_barang_baku' => $this->input->post('id_barang_baku', true),
            'jumlah_keluar_baku' => $this->input->post('jumlah_keluar_baku', true),
            'tgl_barang_produksi' => date('Y-m-d H:i:s'),
            'input_barang_produksi' => $this->session->userdata('nama_lengkap')
        ];
        $this->db->where('id_barang_baku_produksi', $this->input->post('id_barang_baku_produksi'));
        $this->db->update('barang_baku_produksi', $data);
    }
}
