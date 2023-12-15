<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_ambil_rutin_karyawan extends CI_Model
{
    public function get_all($bulan, $tahun)
    {
        $this->db->select('*,bagian.id_bagian, bagian.nama_bagian,
        (SELECT SUM(galon) FROM ambil_rutin_pegawai WHERE MONTH(ambil_rutin_pegawai.tgl_lap) = "' . $bulan . '" AND YEAR(ambil_rutin_pegawai.tgl_lap) = "' . $tahun . '" AND ambil_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_galon,
        (SELECT SUM(gelas) FROM ambil_rutin_pegawai WHERE MONTH(ambil_rutin_pegawai.tgl_lap) = "' . $bulan . '" AND YEAR(ambil_rutin_pegawai.tgl_lap) = "' . $tahun . '" AND ambil_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_gelas,
        (SELECT SUM(btl330) FROM ambil_rutin_pegawai WHERE MONTH(ambil_rutin_pegawai.tgl_lap) = "' . $bulan . '" AND YEAR(ambil_rutin_pegawai.tgl_lap) = "' . $tahun . '" AND ambil_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_btl330,
        (SELECT SUM(btl500) FROM ambil_rutin_pegawai WHERE MONTH(ambil_rutin_pegawai.tgl_lap) = "' . $bulan . '" AND YEAR(ambil_rutin_pegawai.tgl_lap) = "' . $tahun . '" AND ambil_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_btl500,
        (SELECT SUM(btl1500) FROM ambil_rutin_pegawai WHERE MONTH(ambil_rutin_pegawai.tgl_lap) = "' . $bulan . '" AND YEAR(ambil_rutin_pegawai.tgl_lap) = "' . $tahun . '" AND ambil_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_btl1500,
        (SELECT SUM(nominal) FROM ambil_rutin_pegawai WHERE MONTH(ambil_rutin_pegawai.tgl_lap) = "' . $bulan . '" AND YEAR(ambil_rutin_pegawai.tgl_lap) = "' . $tahun . '" AND ambil_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_nominal
        ');
        $this->db->from('ambil_rutin_pegawai');
        $this->db->join('bagian', 'bagian.id_bagian=ambil_rutin_pegawai.id_bagian');
        $this->db->where('MONTH(ambil_rutin_pegawai.tgl_lap)', $bulan);
        $this->db->where('YEAR(ambil_rutin_pegawai.tgl_lap)', $tahun);
        $this->db->where('status', 0);
        $this->db->order_by('ambil_rutin_pegawai.id_bagian', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_sudah_ambil($bulan, $tahun)
    {
        $this->db->select('*,bagian.id_bagian, bagian.nama_bagian,
        (SELECT SUM(galon) FROM ambil_rutin_pegawai WHERE MONTH(ambil_rutin_pegawai.tgl_lap) = "' . $bulan . '" AND YEAR(ambil_rutin_pegawai.tgl_lap) = "' . $tahun . '" AND ambil_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_galon,
        (SELECT SUM(gelas) FROM ambil_rutin_pegawai WHERE MONTH(ambil_rutin_pegawai.tgl_lap) = "' . $bulan . '" AND YEAR(ambil_rutin_pegawai.tgl_lap) = "' . $tahun . '" AND ambil_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_gelas,
        (SELECT SUM(btl330) FROM ambil_rutin_pegawai WHERE MONTH(ambil_rutin_pegawai.tgl_lap) = "' . $bulan . '" AND YEAR(ambil_rutin_pegawai.tgl_lap) = "' . $tahun . '" AND ambil_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_btl330,
        (SELECT SUM(btl500) FROM ambil_rutin_pegawai WHERE MONTH(ambil_rutin_pegawai.tgl_lap) = "' . $bulan . '" AND YEAR(ambil_rutin_pegawai.tgl_lap) = "' . $tahun . '" AND ambil_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_btl500,
        (SELECT SUM(btl1500) FROM ambil_rutin_pegawai WHERE MONTH(ambil_rutin_pegawai.tgl_lap) = "' . $bulan . '" AND YEAR(ambil_rutin_pegawai.tgl_lap) = "' . $tahun . '" AND ambil_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_btl1500,
        (SELECT SUM(nominal) FROM ambil_rutin_pegawai WHERE MONTH(ambil_rutin_pegawai.tgl_lap) = "' . $bulan . '" AND YEAR(ambil_rutin_pegawai.tgl_lap) = "' . $tahun . '" AND ambil_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_nominal
        ');
        $this->db->from('ambil_rutin_pegawai');
        $this->db->join('bagian', 'bagian.id_bagian=ambil_rutin_pegawai.id_bagian');
        $this->db->where('MONTH(ambil_rutin_pegawai.tgl_lap)', $bulan);
        $this->db->where('YEAR(ambil_rutin_pegawai.tgl_lap)', $tahun);
        $this->db->where('status', 1);
        $this->db->order_by('ambil_rutin_pegawai.id_bagian', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_nama_barang()
    {
        $this->db->select('*');
        $this->db->from('jenis_barang');
        return $this->db->get()->result();
    }

    public function ambil_rutin($id_ambil_rutin)
    {
        $this->db->select('*,bagian.id_bagian, bagian.nama_bagian');
        $this->db->from('ambil_rutin_pegawai');
        $this->db->join('bagian', 'bagian.id_bagian=ambil_rutin_pegawai.id_bagian');
        $this->db->where('id_ambil_rutin', $id_ambil_rutin);
        return $this->db->get()->row();
    }


    public function updateData()
    {

        $data = [
            'status' => $this->input->post('status', true),
        ];

        $this->db->where('id_ambil_rutin', $this->input->post('id_ambil_rutin'));
        $this->db->update('ambil_rutin_pegawai', $data);
    }
}
