<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_rutin_karyawan extends CI_Model
{
    public function get_all()
    {
        $this->db->select('*,bagian.id_bagian, bagian.nama_bagian');
        $this->db->from('rutin_pegawai');
        $this->db->join('bagian', 'bagian.id_bagian=rutin_pegawai.id_bagian');
        $this->db->where('rutin_pegawai.aktif', 1);
        // $this->db->where('rutin_pegawai.status_pegawai', 'Karyawan Tetap');
        $this->db->order_by('rutin_pegawai.id_bagian', 'asc');
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
        $nominal = $this->hitungNominal();
        $data = [
            'id_bagian' => $this->input->post('id_bagian', true),
            'nama' => $this->input->post('nama', true),
            'alamat' => $this->input->post('alamat', true),
            'no_hp' => $this->input->post('no_hp', true),
            'galon' => $this->input->post('galon', true),
            'gelas' => $this->input->post('gelas', true),
            'btl330' => $this->input->post('btl330', true),
            'btl500' => $this->input->post('btl500', true),
            'btl1500' => $this->input->post('btl1500', true),
            'nominal' => $nominal
        ];
        $this->db->insert('rutin_pegawai', $data);
    }



    public function getIdAdmin($id_pelanggan)
    {
        return $this->db->get_where('pelanggan', ['id_pelanggan' => $id_pelanggan])->row();
    }

    public function updateData()
    {
        $nominal = $this->hitungNominal();

        $data = [
            'id_bagian' => $this->input->post('id_bagian', true),
            'nama' => $this->input->post('nama', true),
            'aktif' => $this->input->post('aktif', true),
            'alamat' => $this->input->post('alamat', true),
            'no_hp' => $this->input->post('no_hp', true),
            'galon' => $this->input->post('galon', true),
            'gelas' => $this->input->post('gelas', true),
            'btl330' => $this->input->post('btl330', true),
            'btl500' => $this->input->post('btl500', true),
            'btl1500' => $this->input->post('btl1500', true)
        ];

        $this->db->where('id_rutin', $this->input->post('id_rutin'));
        $this->db->set('nominal', $nominal);
        $this->db->update('rutin_pegawai', $data);
    }


    private function hitungNominal()
    {
        $galon = $this->input->post('galon', true);
        $gelas = $this->input->post('gelas', true);
        $btl330 = $this->input->post('btl330', true);
        $btl500 = $this->input->post('btl500', true);
        $btl1500 = $this->input->post('btl1500', true);

        // Array untuk menyimpan jenis_barang yang memiliki quantity > 0
        $jenis_barang_array = [];

        if ($galon > 0) {
            $jenis_barang_array[] = 1;
        }
        if ($gelas > 0) {
            $jenis_barang_array[] = 2;
        }
        if ($btl330 > 0) {
            $jenis_barang_array[] = 8;
        }
        if ($btl500 > 0) {
            $jenis_barang_array[] = 9;
        }
        if ($btl1500 > 0) {
            $jenis_barang_array[] = 11;
        }

        // cari harga dari tabel harga didatabase berdasarkan jenis_harga dan jenis_barang
        $prices = $this->db->select('id_jenis_barang, harga')
            ->from('harga')
            ->where('jenis_harga', 'UMUM')
            ->where_in('id_jenis_barang', $jenis_barang_array)
            ->get()
            ->result_array();

        $nominal = 0;        // hitung nominal dari jumlah pesanan dikali harga
        foreach ($prices as $price) {
            $jenis_barang_id = $price['id_jenis_barang'];
            // Periksa nama input yang sesuai dengan ID jenis barang
            $input_name = ''; // Ganti ini dengan nama input yang sesuai dengan ID jenis barang
            switch ($jenis_barang_id) {
                case 1:
                    $input_name = 'galon';
                    break;
                case 2:
                    $input_name = 'gelas';
                    break;
                case 8:
                    $input_name = 'btl330';
                    break;
                case 9:
                    $input_name = 'btl500';
                    break;
                case 11:
                    $input_name = 'btl1500';
                    break;
            }

            $jumlah_jatah = $this->input->post($input_name, true);

            if ($jumlah_jatah > 0) {
                $nominal += $jumlah_jatah * $price['harga'];
            }
        }

        return $nominal;
    }

    public function hapusData($id_rutin)
    {
        $this->db->where('id_rutin', $id_rutin);
        $this->db->delete('rutin_pegawai');
    }
}
