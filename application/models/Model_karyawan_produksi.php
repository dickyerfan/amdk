<?php
defined('BASEPATH') or exit('No direct script access allowed');

class model_karyawan_produksi extends CI_Model
{

    public function get_karyawan()
    {
        $this->db->select('*');
        $this->db->from('karyawan_produksi');
        // $this->db->where('status', 1);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_karyawan_produksi()
    {
        $this->db->select('*');
        $this->db->from('karyawan_produksi');
        $this->db->where('status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function tambahData()
    {
        $data = [
            'nama_karyawan_produksi' => $this->input->post('nama_karyawan_produksi', true),
            'jenkel' => $this->input->post('jenkel', true),
        ];
        $this->db->insert('karyawan_produksi', $data);
    }

    public function hapusData($id_karyawan_produksi)
    {
        $this->db->where('id_karyawan_produksi', $id_karyawan_produksi);
        $this->db->delete('karyawan_produksi');
    }

    public function getIdAdmin($id_karyawan_produksi)
    {
        return $this->db->get_where('karyawan_produksi', ['id_karyawan_produksi' => $id_karyawan_produksi])->row();
    }

    public function updateData()
    {

        $data = [
            'nama_karyawan_produksi' => $this->input->post('nama_karyawan_produksi', true),
            'jenkel' => $this->input->post('jenkel', true),
            'status' => $this->input->post('status', true),
        ];
        $this->db->where('id_karyawan_produksi', $this->input->post('id_karyawan_produksi'));
        $this->db->update('karyawan_produksi', $data);
    }

    public function get_absen_karprod()
    {
        $this->db->select('*');
        $this->db->from('karyawan_produksi');
        $this->db->join('absen_karyawan_produksi', 'karyawan_produksi.id_karyawan_produksi = absen_karyawan_produksi.id_karyawan_produksi', 'left');
        return $this->db->get()->result();
    }

    public function tambah_absen_karProd($data)
    {
        $this->db->insert('absen_karyawan_produksi', $data);
    }

    public function get_jenis_barang()
    {
        $this->db->select('*');
        $this->db->from('jenis_barang');
        $this->db->join('barang_jadi', 'jenis_barang.id_jenis_barang = barang_jadi.id_jenis_barang', 'left');
        return $this->db->get()->result();
    }
}
