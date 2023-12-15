<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_lap_rutin_karyawan extends CI_Model
{
    public function get_all($bulan, $tahun)
    {
        $this->db->select('*,bagian.id_bagian, bagian.nama_bagian,
        (SELECT SUM(galon) FROM lap_rutin_pegawai WHERE MONTH(lap_rutin_pegawai.tgl_lap) = "' . $bulan . '" AND YEAR(lap_rutin_pegawai.tgl_lap) = "' . $tahun . '" AND lap_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_galon,
        (SELECT SUM(gelas) FROM lap_rutin_pegawai WHERE MONTH(lap_rutin_pegawai.tgl_lap) = "' . $bulan . '" AND YEAR(lap_rutin_pegawai.tgl_lap) = "' . $tahun . '" AND lap_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_gelas,
        (SELECT SUM(btl330) FROM lap_rutin_pegawai WHERE MONTH(lap_rutin_pegawai.tgl_lap) = "' . $bulan . '" AND YEAR(lap_rutin_pegawai.tgl_lap) = "' . $tahun . '" AND lap_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_btl330,
        (SELECT SUM(btl500) FROM lap_rutin_pegawai WHERE MONTH(lap_rutin_pegawai.tgl_lap) = "' . $bulan . '" AND YEAR(lap_rutin_pegawai.tgl_lap) = "' . $tahun . '" AND lap_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_btl500,
        (SELECT SUM(btl1500) FROM lap_rutin_pegawai WHERE MONTH(lap_rutin_pegawai.tgl_lap) = "' . $bulan . '" AND YEAR(lap_rutin_pegawai.tgl_lap) = "' . $tahun . '" AND lap_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_btl1500,
        (SELECT SUM(nominal) FROM lap_rutin_pegawai WHERE MONTH(lap_rutin_pegawai.tgl_lap) = "' . $bulan . '" AND YEAR(lap_rutin_pegawai.tgl_lap) = "' . $tahun . '" AND lap_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_nominal
        ');
        $this->db->from('lap_rutin_pegawai');
        $this->db->join('bagian', 'bagian.id_bagian=lap_rutin_pegawai.id_bagian');
        $this->db->where('MONTH(lap_rutin_pegawai.tgl_lap)', $bulan);
        $this->db->where('YEAR(lap_rutin_pegawai.tgl_lap)', $tahun);
        $this->db->order_by('lap_rutin_pegawai.id_bagian', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_nama_barang()
    {
        $this->db->select('*');
        $this->db->from('jenis_barang');
        return $this->db->get()->result();
    }
}
