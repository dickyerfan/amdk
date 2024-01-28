<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_barang_baku extends CI_Model
{

    // awal stok barang baku
    public function getdata()
    {
        $tahun_sekarang = date('Y');
        $this->db->select('*,barang_baku.*, 
        COALESCE(
            (SELECT SUM(jumlah_stok_awal_baku) 
             FROM stok_awal_baku 
             WHERE stok_awal_baku.id_barang_baku = barang_baku.id_barang_baku 
             AND YEAR(stok_awal_baku.tanggal_stok_awal_baku) = ' . $tahun_sekarang . '), 
            (SELECT SUM(jumlah_stok_awal_baku) 
             FROM stok_awal_baku 
             WHERE stok_awal_baku.id_barang_baku = barang_baku.id_barang_baku)
        ) AS jumlah_stok_awal,
                   (SELECT SUM(isi_stok_minimum) FROM stok_minimum WHERE stok_minimum.id_barang_baku = barang_baku.id_barang_baku AND stok_minimum.status_stok_minimum = 1) AS isi_stok_minimum, 
                   (SELECT SUM(jumlah_stok_minimum) FROM stok_minimum WHERE stok_minimum.id_barang_baku = barang_baku.id_barang_baku AND stok_minimum.status_stok_minimum = 1) AS jumlah_stok_minimum, 
                   (SELECT SUM(jumlah_masuk) FROM masuk_baku WHERE masuk_baku.id_barang_baku = barang_baku.id_barang_baku AND masuk_baku.status_masuk = 1) AS jumlah_masuk, 
                   (SELECT SUM(jumlah_rusak_baku) FROM rusak_baku WHERE rusak_baku.id_barang_baku = barang_baku.id_barang_baku) AS jumlah_rusak, 
                   (SELECT SUM(jumlah_keluar) FROM keluar_baku WHERE keluar_baku.id_barang_baku = barang_baku.id_barang_baku AND keluar_baku.status_keluar = 1) AS jumlah_keluar', FALSE);
        $this->db->from('barang_baku');
        $this->db->join('stok_awal_baku', 'stok_awal_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->join('masuk_baku', 'masuk_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->join('keluar_baku', 'keluar_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->join('rusak_baku', 'rusak_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->join('stok_minimum', 'stok_minimum.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->join('satuan', 'satuan.id_satuan = barang_baku.id_satuan', 'left');
        $this->db->join('jenis_barang', 'jenis_barang.id_jenis_barang = barang_baku.id_jenis_barang', 'left');
        $this->db->where('barang_baku.status_barang_baku', 1);
        $this->db->group_by('barang_baku.id_barang_baku');
        return $this->db->get()->result();
    }

    public function get_jenis_barang()
    {
        $this->db->select('*');
        $this->db->from('jenis_barang');
        return $this->db->get()->result();
    }

    public function get_satuan()
    {
        $this->db->select('*');
        $this->db->from('satuan');
        return $this->db->get()->result();
    }
    // akhir stok barang baku


    public function upload($table, $data)
    {
        $this->db->insert($table, $data);
    }

    // awal stok awal
    public function getstok_awal()
    {
        $this->db->select('barang_baku.id_barang_baku,barang_baku.nama_barang_baku, jumlah_stok_awal_baku, tanggal_stok_awal_baku, input_status_stok_awal_baku, id_stok_awal_baku');
        $this->db->from('stok_awal_baku');
        $this->db->join('barang_baku', 'stok_awal_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        // $this->db->where('masuk_baku.status_masuk', 1);
        $this->db->group_by('stok_awal_baku.id_stok_awal_baku');
        return $this->db->get()->result();
    }
    public function get_id_stok_awal($id_stok_awal_baku)
    {
        $this->db->select('barang_baku.id_barang_baku,barang_baku.nama_barang_baku, jumlah_stok_awal_baku, tanggal_stok_awal_baku, input_status_stok_awal_baku, id_stok_awal_baku');
        $this->db->from('stok_awal_baku');
        $this->db->join('barang_baku', 'stok_awal_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->where('id_stok_awal_baku', $id_stok_awal_baku);
        return $this->db->get()->row();
    }

    public function update_stok()
    {

        $data = [
            // 'id_barang_baku' => $this->input->post('id_barang_baku', true),
            'jumlah_stok_awal_baku' => $this->input->post('jumlah_stok_awal_baku', true),
            'tanggal_stok_awal_baku' => $this->input->post('tanggal_stok_awal_baku', true),
            'input_status_stok_awal_baku' => $this->session->userdata('nama_lengkap')
        ];
        $this->db->where('id_stok_awal_baku', $this->input->post('id_stok_awal_baku'));
        $this->db->update('stok_awal_baku', $data);
    }
    // akhir stok awal

    // awal barang masuk
    public function getbarang_masuk($bulan, $tahun)
    {
        $this->db->select('*');
        $this->db->from('masuk_baku');
        $this->db->join('barang_baku', 'masuk_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        // $this->db->where('masuk_baku.status_masuk', 1);
        $this->db->where('MONTH(masuk_baku.tanggal_masuk)', $bulan);
        $this->db->where('YEAR(masuk_baku.tanggal_masuk)', $tahun);
        $this->db->group_by('masuk_baku.id_masuk_baku');
        $this->db->order_by('masuk_baku.id_masuk_baku', 'DESC');
        return $this->db->get()->result();
    }

    public function get_nama_barang()
    {
        $this->db->select('*');
        $this->db->from('barang_baku');
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

    // akhir barang masuk

    // awal barang keluar
    public function get_barang_keluar($bulan, $tahun)
    {
        $this->db->select('keluar_baku.*, barang_baku.nama_barang_baku');
        $this->db->from('keluar_baku');
        $this->db->join('barang_baku', 'keluar_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->where('keluar_baku.status_tolak', 1);
        $this->db->where('MONTH(keluar_baku.tanggal_keluar)', $bulan);
        $this->db->where('YEAR(keluar_baku.tanggal_keluar)', $tahun);
        $this->db->group_by('keluar_baku.id_keluar_baku');
        $this->db->order_by('keluar_baku.tanggal_keluar', 'DESC');
        return $this->db->get()->result();
    }

    public function get_permintaan_barang($bulan, $tahun)
    {
        $this->db->select('keluar_baku.*, barang_baku.nama_barang_baku');
        $this->db->from('keluar_baku');
        $this->db->join('barang_baku', 'keluar_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->where('keluar_baku.status_tolak', 1);
        $this->db->where('MONTH(keluar_baku.tanggal_keluar)', $bulan);
        $this->db->where('YEAR(keluar_baku.tanggal_keluar)', $tahun);
        $this->db->group_by('keluar_baku.id_keluar_baku');
        $this->db->order_by('keluar_baku.tanggal_keluar', 'DESC');
        return $this->db->get()->result();
    }

    public function get_detail_barang_keluar($tanggal_keluar, $bagian)
    {
        $this->db->select('*, keluar_baku.kode_barang');
        $this->db->from('keluar_baku');
        $this->db->join('barang_baku', 'keluar_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->where('tanggal_keluar', $tanggal_keluar);
        $this->db->where('bagian', $bagian);
        $this->db->group_by('keluar_baku.id_keluar_baku');
        return $this->db->get()->result();
    }

    public function get_detail_barang_keluar_tgl_sama($tanggal_keluar, $bagian)
    {
        $this->db->select('*, keluar_baku.kode_barang');
        $this->db->from('keluar_baku');
        $this->db->join('barang_baku', 'keluar_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->where('tanggal_keluar', $tanggal_keluar);
        $this->db->where('bagian', $bagian);
        $this->db->where('status_keluar', 0);
        $this->db->group_by('keluar_baku.id_keluar_baku');
        return $this->db->get()->result();
    }

    public function update_Bukti_pemesanan($data, $tanggal_keluar, $bagian)
    {
        $this->db->where('tanggal_keluar', $tanggal_keluar);
        $this->db->where('bagian', $bagian);
        $this->db->set('bukti_keluar_gd', $data['bukti_keluar_gd']);
        $this->db->set('no_nota', $data['no_nota']);
        $this->db->set('status_keluar', $data['status_keluar']);
        $this->db->set('status_produksi', $data['status_produksi']);
        $this->db->update('keluar_baku');
    }

    public function update_Bukti_pemesanan_tgl_sama($data, $tanggal_keluar, $bagian)
    {
        $this->db->where('tanggal_keluar', $tanggal_keluar);
        $this->db->where('bagian', $bagian);
        $this->db->where('status_keluar', 0);
        $this->db->set('bukti_keluar_gd', $data['bukti_keluar_gd']);
        $this->db->set('no_nota', $data['no_nota']);
        $this->db->set('status_keluar', $data['status_keluar']);
        $this->db->set('status_produksi', $data['status_produksi']);
        $this->db->update('keluar_baku');
    }

    // awal barang rusak
    public function getbarang_rusak($bulan, $tahun)
    {
        $this->db->select('*');
        $this->db->from('rusak_baku');
        $this->db->join('barang_baku', 'rusak_baku.id_barang_baku = barang_baku.id_barang_baku', 'left');
        $this->db->where('MONTH(rusak_baku.tanggal_rusak_baku)', $bulan);
        $this->db->where('YEAR(rusak_baku.tanggal_rusak_baku)', $tahun);
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
    // akhir barang rusak
}
