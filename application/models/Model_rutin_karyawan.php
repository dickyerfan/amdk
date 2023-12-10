<?php
defined('BASEPATH') or exit('No direct script access allowed');

class model_rutin_karyawan extends CI_Model
{
    public function get_all()
    {
        $this->db->select('*,bagian.id_bagian, bagian.nama_bagian');
        $this->db->from('rutin_pegawai');
        $this->db->join('bagian', 'bagian.id_bagian=rutin_pegawai.id_bagian');
        $this->db->where('rutin_pegawai.aktif', 1);
        $this->db->where('rutin_pegawai.status_pegawai', 'Karyawan Tetap');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_nama_barang()
    {
        $this->db->select('*');
        $this->db->from('jenis_barang');
        return $this->db->get()->result();
    }


    public function tambahData()
    {
        $jumlah_ban_ops = intval($this->input->post('jumlah_ban_ops', true));
        $id_jenis_barang = $this->input->post('id_jenis_barang', true);
        $get_harga = $this->db->get_where('harga', ['id_jenis_barang' => $id_jenis_barang])->row();
        $total = $jumlah_ban_ops * $get_harga->harga;

        $data = [
            'id_jenis_barang' => $this->input->post('id_jenis_barang', true),
            'jumlah_ban_ops' => $this->input->post('jumlah_ban_ops', true),
            'harga_ban_ops' => $total,
            'jenis_ban_ops' => $this->input->post('jenis_ban_ops', true),
            'nama_ban_ops' => strtoupper($this->input->post('nama_ban_ops', true)),
            'tanggal_ban_ops' => $this->input->post('tanggal_ban_ops', true),
            'keterangan' => strtoupper($this->input->post('keterangan', true)),
            'input_ban_ops' => $this->session->userdata('nama_lengkap')
        ];
        $this->db->insert('ban_ops', $data);
    }

    public function hapusData($id_pelanggan)
    {
        $this->db->where('id_pelanggan', $id_pelanggan);
        $this->db->delete('pelanggan');
    }

    public function getIdAdmin($id_pelanggan)
    {
        return $this->db->get_where('pelanggan', ['id_pelanggan' => $id_pelanggan])->row();
    }

    public function updateData()
    {

        $data = [
            'area_pelanggan' => strtoupper($this->input->post('area_pelanggan', true)),
            'gol_pelanggan' => strtoupper($this->input->post('gol_pelanggan', true)),
            'nama_pelanggan' => strtoupper($this->input->post('nama_pelanggan', true)),
            'alamat_pelanggan' => strtoupper($this->input->post('alamat_pelanggan', true)),
            'telpon_pelanggan' => $this->input->post('telpon_pelanggan', true),
            'ket' => $this->input->post('ket', true),
            'tarif' => $this->input->post('tarif', true),
            'aktif' => $this->input->post('aktif', true)
        ];
        $this->db->where('id_pelanggan', $this->input->post('id_pelanggan'));
        $this->db->update('pelanggan', $data);
    }
}
