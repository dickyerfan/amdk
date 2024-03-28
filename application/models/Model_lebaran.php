<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_lebaran extends CI_Model
{
    public function get_lebaran($tahun)
    {
        $this->db->select(
            '*, jenis_produk.id_produk, jenis_produk.nama_produk,
            (SELECT SUM(harga_lebaran) FROM lebaran ) AS total_harga,
            (SELECT SUM(jumlah_barang) FROM lebaran ) AS total_barang'
        );
        $this->db->from('lebaran');
        $this->db->join('jenis_produk', 'lebaran.id_jenis_barang=jenis_produk.id_produk');
        $this->db->join('pelanggan', 'lebaran.id_pelanggan=pelanggan.id_pelanggan');
        $this->db->where('YEAR(lebaran.tanggal_lebaran)', $tahun);
        $this->db->order_by('lebaran.id_lebaran', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_nama_barang()
    {
        $this->db->select('*');
        $this->db->from('jenis_produk');
        $this->db->where('status_lebaran', 1);
        return $this->db->get()->result();
    }

    public function get_pelanggan()
    {
        $this->db->select('id_pelanggan, nama_pelanggan, alamat_pelanggan, tarif');
        $this->db->from('pelanggan');
        $this->db->where('aktif', 1);
        $this->db->where('ket', 'BINGKISAN LEBARAN');
        return $this->db->get()->result();
    }


    public function tambahData()
    {
        $jumlah_orang = $this->input->post('jumlah_orang', true);
        $jumlah_barang = $this->input->post('jumlah_barang', true);
        $id_pelanggan = $this->input->post('id_pelanggan');
        $jenis_barang = $this->input->post('id_jenis_barang');
        $total = 0;

        foreach ($jenis_barang as $id_jenis_barang) {
            $jumlah = $jumlah_barang[$id_jenis_barang];

            $tarif = $this->getTarifByIdPelanggan($id_pelanggan);
            $harga_barang = $this->getHargaByJenisBarang($id_jenis_barang, $tarif);
            $no_per = $this->getHargaByJenisBarang($id_jenis_barang, $tarif);
            $no_perkiraan = $no_per->no_perkiraan;
            $harga = $harga_barang->harga;
            $total = $harga * $jumlah * $jumlah_orang;
            $total_barang = $jumlah * $jumlah_orang;

            $data = array(
                'id_jenis_barang' => $id_jenis_barang,
                'jumlah_barang' => $jumlah,
                'id_pelanggan' => $id_pelanggan,
                'jumlah_orang' => $jumlah_orang,
                'harga_lebaran' => $total,
                'tanggal_lebaran' => date('Y-m-d'),
                'keterangan' => strtoupper($this->input->post('keterangan', true)),
                'input_lebaran' => $this->session->userdata('nama_lengkap')
            );
            $this->db->insert('lebaran', $data);

            $data_keluar_jadi = array(
                'id_jenis_barang' => $id_jenis_barang,
                'id_mobil' => 1,
                'id_pelanggan' => $id_pelanggan,
                'jumlah_keluar' => $total_barang,
                'tanggal_keluar' => date('Y-m-d'),
                'jumlah_akhir' => $total_barang,
                'jenis_pesanan' => 5,
                'input_status_keluar' => $this->session->userdata('nama_lengkap')
            );
            $this->db->insert('keluar_jadi', $data_keluar_jadi);

            $data_pemesanan = array(
                'id_jenis_barang' => $id_jenis_barang,
                'id_mobil' => 1,
                'id_pelanggan' => $id_pelanggan,
                'no_perkiraan' => $no_perkiraan,
                'tanggal_pesan' => date('Y-m-d'),
                'jenis_pesanan' => 5,
                'jumlah_pesan' => $total_barang,
                'harga_barang' => $harga,
                'total_harga' => $total,
                'input_pesan' => $this->session->userdata('nama_lengkap'),
                // 'input_bayar' => $this->session->userdata('nama_lengkap'),
                // 'tanggal_bayar' => date('Y-m-d'),
                'status_setor' => 0,
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

    public function get_lebaran_keu($bulan, $tahun)
    {
        $this->db->select('*,jenis_produk.id_produk, jenis_produk.nama_produk, pelanggan.nama_pelanggan,lebaran.jumlah_orang');
        $this->db->from('lebaran');
        $this->db->join('jenis_produk', 'lebaran.id_jenis_barang=jenis_produk.id_produk');
        $this->db->join('pelanggan', 'lebaran.id_pelanggan=pelanggan.id_pelanggan', 'left');
        $this->db->where('MONTH(lebaran.tanggal_lebaran)', $bulan);
        $this->db->where('YEAR(lebaran.tanggal_lebaran)', $tahun);
        return $this->db->get()->result();
    }

    public function get_lebaran_lunas($tahun)
    {
        $this->db->select(
            '*,
        (SELECT SUM(total_harga) FROM pemesanan WHERE YEAR(pemesanan.tanggal_bayar) = "' . $tahun . '" AND jenis_pesanan = 5 AND status_bayar = 1 ) AS total_bayar'
        );
        $this->db->from('pemesanan');
        $this->db->join('jenis_produk', 'jenis_produk.id_produk = pemesanan.id_jenis_barang', 'left');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = pemesanan.id_pelanggan', 'left');
        $this->db->where('YEAR(pemesanan.tanggal_bayar)', $tahun);
        $this->db->where('jenis_pesanan', 5);
        $this->db->order_by('pemesanan.id_pemesanan', 'DESC');
        return  $this->db->get()->result();
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

    public function update_lunas($tahun)
    {

        $data = [
            'status_bayar' => 1,
            'tanggal_bayar' => date('Y-m-d H:i:s'),
            'input_bayar' => $this->session->userdata('nama_lengkap')
        ];
        $this->db->where('jenis_pesanan', 5);
        $this->db->where('status_bayar', 0);
        $this->db->where('YEAR(pemesanan.tanggal_pesan)', $tahun);
        $this->db->update('pemesanan', $data);
    }


    // public function lebaran($bulan, $tahun)
    // {
    //     $this->db->select('*,jenis_produk.id_produk, jenis_produk.nama_produk');
    //     $this->db->from('lebaran');
    //     $this->db->join('jenis_produk', 'lebaran.id_jenis_barang=jenis_produk.id_produk');
    //     $this->db->where('MONTH(lebaran.tanggal_lebaran)', $bulan);
    //     $this->db->where('YEAR(lebaran.tanggal_lebaran)', $tahun);
    //     $this->db->order_by('tanggal_lebaran', 'esc');
    //     return $this->db->get()->result();
    // }

    // public function get_jenis_produk()
    // {
    //     $this->db->select('*');
    //     $this->db->from('jenis_produk');
    //     return $this->db->get()->result();
    // }
}
