<?php
defined('BASEPATH') or exit('No direct script access allowed');

class model_ban_ops extends CI_Model
{
    public function get_ban_ops($bulan, $tahun)
    {
        $this->db->select('*,jenis_produk.id_produk, jenis_produk.nama_produk');
        $this->db->from('ban_ops');
        $this->db->join('jenis_produk', 'ban_ops.id_jenis_barang=jenis_produk.id_produk');
        $this->db->join('pelanggan', 'ban_ops.id_pelanggan=pelanggan.id_pelanggan');
        $this->db->where('MONTH(ban_ops.tanggal_ban_ops)', $bulan);
        $this->db->where('YEAR(ban_ops.tanggal_ban_ops)', $tahun);
        $this->db->order_by('ban_ops.tanggal_ban_ops', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_nama_barang()
    {
        $this->db->select('*');
        $this->db->from('jenis_produk');
        return $this->db->get()->result();
    }

    public function get_pelanggan()
    {
        $this->db->select('id_pelanggan, nama_pelanggan, alamat_pelanggan, tarif');
        $this->db->from('pelanggan');
        $this->db->where('aktif', 1);
        return $this->db->get()->result();
    }


    public function tambahData()
    {
        date_default_timezone_set('Asia/Jakarta');
        $jumlah_ban_ops = ($this->input->post('jumlah_ban_ops', true));
        $jenis_barang = $this->input->post('id_jenis_barang');
        $id_pelanggan = $this->input->post('id_pelanggan');
        $total = 0;

        foreach ($jenis_barang as $id_jenis_barang) {
            $jumlah = $jumlah_ban_ops[$id_jenis_barang];

            $tarif = $this->getTarifByIdPelanggan($id_pelanggan);
            $harga_barang = $this->getHargaByJenisBarang($id_jenis_barang, $tarif);
            $no_per = $this->getHargaByJenisBarang($id_jenis_barang, $tarif);
            $no_perkiraan = $no_per->no_perkiraan;
            $harga = $harga_barang->harga;
            $total = $harga * $jumlah;

            $data = array(
                'id_jenis_barang' => $id_jenis_barang,
                'jumlah_ban_ops' => $jumlah,
                'harga_ban_ops' => $total,
                'id_mobil' => $this->input->post('id_mobil', true),
                'jenis_ban_ops' => $this->input->post('jenis_ban_ops', true),
                'id_pelanggan' => $this->input->post('id_pelanggan', true),
                'tanggal_ban_ops' => $this->input->post('tanggal_ban_ops', true),
                'keterangan' => strtoupper($this->input->post('keterangan', true)),
                'input_ban_ops' => $this->session->userdata('nama_lengkap')
            );
            $this->db->insert('ban_ops', $data);

            $data_keluar_jadi = array(
                'id_jenis_barang' => $id_jenis_barang,
                'id_mobil' => $this->input->post('id_mobil', true),
                'id_pelanggan' => $this->input->post('id_pelanggan', true),
                'jumlah_keluar' => $jumlah,
                'tanggal_keluar' => $this->input->post('tanggal_ban_ops', true),
                'jumlah_akhir' => $jumlah,
                'jenis_pesanan' => 4,
                'input_status_keluar' => $this->session->userdata('nama_lengkap')
            );
            $this->db->insert('keluar_jadi', $data_keluar_jadi);

            $data_pemesanan = array(
                'id_jenis_barang' => $id_jenis_barang,
                'id_mobil' => $this->input->post('id_mobil', true),
                'id_pelanggan' => $this->input->post('id_pelanggan', true),
                'no_perkiraan' => $no_perkiraan,
                'tanggal_pesan' => $this->input->post('tanggal_ban_ops', true),
                'jenis_pesanan' => 4,
                'jumlah_pesan' => $jumlah,
                'harga_barang' => $harga,
                'total_harga' => $total,
                'input_pesan' => $this->session->userdata('nama_lengkap'),
                // 'tanggal_bayar' => $tanggal_bayar,
                // 'nota_setor' => $nota_setor,
                // 'tanggal_setor' => $tanggal_setor,
                'status_setor' => 0,
                // 'input_setor' => $input_setor,
                'status_nota' => 1,
                'status_piutang' => 1,
                'status_bayar' => 0
            );

            $this->db->insert('pemesanan', $data_pemesanan);
        }
    }

    public function getTarifByIdPelanggan($id_pelanggan)
    {
        $this->db->select('tarif');
        $this->db->from('pelanggan');
        $this->db->where('id_pelanggan', $id_pelanggan);
        return $this->db->get()->row()->tarif;
    }

    public function getHargaByJenisBarang($id_jenis_barang, $tarif)
    {
        $this->db->select('harga, no_perkiraan');
        $this->db->from('harga');
        $this->db->join('pelanggan', 'harga.jenis_harga = pelanggan.tarif', 'left');
        $this->db->join('jenis_produk', 'harga.id_jenis_barang = jenis_produk.id_produk', 'left');
        $this->db->where('harga.id_jenis_barang', $id_jenis_barang);
        $this->db->where('pelanggan.tarif', $tarif);
        return $this->db->get()->row();
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
