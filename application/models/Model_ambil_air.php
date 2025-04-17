<?php
defined('BASEPATH') or exit('No direct script access allowed');

class model_ambil_air extends CI_Model
{
    public function get_ambil_air($tanggal_mulai, $tanggal_selesai)
    {
        $this->db->select('*');
        $this->db->from('truk_tangki');
        $this->db->join('karyawan', 'truk_tangki.id_karyawan = karyawan.id_karyawan');
        $this->db->where('truk_tangki.tanggal_ambil_air >=', $tanggal_mulai);
        $this->db->where('truk_tangki.tanggal_ambil_air <=', $tanggal_selesai);
        $this->db->order_by('id_truk', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_karyawan()
    {
        $this->db->select('id_karyawan,nama_karyawan, jenis_kerja');
        $this->db->from('karyawan');
        $this->db->where('jenis_kerja', 'Driver');
        $query = $this->db->get();
        return $query->result();
    }

    public function tambahData($data)
    {

        $this->db->insert('truk_tangki', $data);
    }

    // public function hapusData($id_pelanggan)
    // {
    //     $this->db->where('id_pelanggan', $id_pelanggan);
    //     $this->db->delete('pelanggan');
    // }

    // public function getIdAdmin($id_pelanggan)
    // {
    //     return $this->db->get_where('pelanggan', ['id_pelanggan' => $id_pelanggan])->row();
    // }

    // public function updateData()
    // {

    //     $data = [
    //         'area_pelanggan' => strtoupper($this->input->post('area_pelanggan', true)),
    //         'gol_pelanggan' => strtoupper($this->input->post('gol_pelanggan', true)),
    //         'nama_pelanggan' => strtoupper($this->input->post('nama_pelanggan', true)),
    //         'alamat_pelanggan' => strtoupper($this->input->post('alamat_pelanggan', true)),
    //         'telpon_pelanggan' => $this->input->post('telpon_pelanggan', true),
    //         'ket' => $this->input->post('ket', true),
    //         'tarif' => $this->input->post('tarif', true),
    //         'aktif' => $this->input->post('aktif', true)
    //     ];
    //     $this->db->where('id_pelanggan', $this->input->post('id_pelanggan'));
    //     $this->db->update('pelanggan', $data);
    // }
}
