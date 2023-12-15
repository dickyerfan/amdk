<?php
defined('BASEPATH') or exit('No direct script access allowed');

class model_ban_ops extends CI_Model
{
    public function get_ban_ops($bulan, $tahun)
    {
        $this->db->select('*,jenis_barang.id_jenis_barang, jenis_barang.nama_barang_jadi');
        $this->db->from('ban_ops');
        $this->db->join('jenis_barang', 'ban_ops.id_jenis_barang=jenis_barang.id_jenis_barang');
        $this->db->where('MONTH(ban_ops.tanggal_ban_ops)', $bulan);
        $this->db->where('YEAR(ban_ops.tanggal_ban_ops)', $tahun);
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
        $jumlah_ban_ops = ($this->input->post('jumlah_ban_ops', true));
        $jenis_barang = $this->input->post('id_jenis_barang');
        $total = 0;


        foreach ($jenis_barang as $id_jenis_barang) {
            $jumlah = $jumlah_ban_ops[$id_jenis_barang];
            $get_harga = $this->db->get_where('harga', ['id_jenis_barang' => $id_jenis_barang])->row();
            $total = $jumlah * intval($get_harga->harga);

            $data = array(
                'id_jenis_barang' => $id_jenis_barang,
                'jumlah_ban_ops' => $jumlah,
                'harga_ban_ops' => $total,
                'jenis_ban_ops' => $this->input->post('jenis_ban_ops', true),
                'nama_ban_ops' => strtoupper($this->input->post('nama_ban_ops', true)),
                'tanggal_ban_ops' => $this->input->post('tanggal_ban_ops', true),
                'keterangan' => strtoupper($this->input->post('keterangan', true)),
                'input_ban_ops' => $this->session->userdata('nama_lengkap')
            );
            $this->db->insert('ban_ops', $data);
        }
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
