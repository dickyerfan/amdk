<?php
defined('BASEPATH') or exit('No direct script access allowed');

class model_karyawan_produksi extends CI_Model
{

    public function get_karyawan()
    {
        // $this->db->select('*');
        $this->db->select('id_karyawan_produksi,nama_karyawan_produksi,jenkel,status,input_karyawan_produksi');
        $this->db->from('karyawan_produksi');
        // $this->db->where('status', 1);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_karyawan_produksi()
    {
        $this->db->select('id_karyawan_produksi,nama_karyawan_produksi');
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
            'input_karyawan_produksi' => $this->session->userdata('nama_lengkap')
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
            'input_karyawan_produksi' => $this->session->userdata('nama_lengkap')
        ];
        $this->db->where('id_karyawan_produksi', $this->input->post('id_karyawan_produksi'));
        $this->db->update('karyawan_produksi', $data);
    }

    public function get_absen_karprod()
    {
        $this->db->select('id_absen_karprod, absen_karyawan_produksi.id_karyawan_produksi, karyawan_produksi.nama_karyawan_produksi, absen_karyawan_produksi.status_absen,absen_karyawan_produksi.tanggal');
        $this->db->from('absen_karyawan_produksi');
        $this->db->join('karyawan_produksi', 'karyawan_produksi.id_karyawan_produksi = absen_karyawan_produksi.id_karyawan_produksi');
        return $this->db->get()->result();
    }

    public function tambah_absen_karProd($data)
    {
        $this->db->insert('absen_karyawan_produksi', $data);
    }

    public function get_jenis_barang()
    {
        $this->db->select('barang_jadi.jumlah_barang_jadi,barang_jadi.id_jenis_barang,barang_jadi.tanggal_barang_jadi, jenis_barang.nama_barang_jadi,ongkos_produksi.ongkos_per_unit');
        $this->db->from('barang_jadi');
        $this->db->join('jenis_barang', 'jenis_barang.id_jenis_barang = barang_jadi.id_jenis_barang');
        $this->db->join('ongkos_produksi', 'barang_jadi.id_jenis_barang = ongkos_produksi.id_jenis_barang');
        return $this->db->get()->result();
    }

    // public function get_ongkos_produksi()
    // {
    //     return $this->db->get('ongkos_produksi')->result();
    // }
}
