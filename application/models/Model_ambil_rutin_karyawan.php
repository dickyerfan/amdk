<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_ambil_rutin_karyawan extends CI_Model
{
    public function get_data_karyawan($bulan, $tahun)
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
        $this->db->order_by('ambil_rutin_pegawai.id_bagian', 'asc');
        $query = $this->db->get();
        return $query->result();
    }
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
    public function get_sudah_ambil_pertgl($tanggal)
    {
        $this->db->select('*,bagian.id_bagian, bagian.nama_bagian,
        (SELECT SUM(galon) FROM ambil_rutin_pegawai WHERE DATE(ambil_rutin_pegawai.tgl_ambil) = "' . $tanggal . '" AND ambil_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_galon,
        (SELECT SUM(gelas) FROM ambil_rutin_pegawai WHERE DATE(ambil_rutin_pegawai.tgl_ambil) = "' . $tanggal . '" AND ambil_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_gelas,
        (SELECT SUM(btl330) FROM ambil_rutin_pegawai WHERE DATE(ambil_rutin_pegawai.tgl_ambil) = "' . $tanggal . '" AND ambil_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_btl330,
        (SELECT SUM(btl500) FROM ambil_rutin_pegawai WHERE DATE(ambil_rutin_pegawai.tgl_ambil) = "' . $tanggal . '" AND ambil_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_btl500,
        (SELECT SUM(btl1500) FROM ambil_rutin_pegawai WHERE DATE(ambil_rutin_pegawai.tgl_ambil) = "' . $tanggal . '" AND ambil_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_btl1500,
        (SELECT SUM(nominal) FROM ambil_rutin_pegawai WHERE DATE(ambil_rutin_pegawai.tgl_ambil) = "' . $tanggal . '" AND ambil_rutin_pegawai.id_bagian = bagian.id_bagian ) AS jumlah_nominal
        ');
        $this->db->from('ambil_rutin_pegawai');
        $this->db->join('bagian', 'bagian.id_bagian=ambil_rutin_pegawai.id_bagian');
        $this->db->where('DATE(ambil_rutin_pegawai.tgl_ambil)', $tanggal);
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
            // 'status' => $this->input->post('status', true),
            'status' => 1
        ];

        $this->db->where('id_ambil_rutin', $this->input->post('id_ambil_rutin'));
        $this->db->update('ambil_rutin_pegawai', $data);

        $keluarJadiData = $this->db->get_where('ambil_rutin_pegawai', ['id_ambil_rutin' => $this->input->post('id_ambil_rutin')])->row_array();

        $jenisBarangIds = $this->getJenisBarangIds($keluarJadiData);

        // Jika ada id_jenis_barang yang ditemukan
        if (!empty($jenisBarangIds)) {
            // Insert data ke tabel keluar_jadi untuk setiap id_jenis_barang
            foreach ($jenisBarangIds as $idJenisBarang) {
                // Siapkan data untuk diinsert ke tabel keluar_jadi
                $dataKeluarJadi = [
                    'id_jenis_barang' => $idJenisBarang,
                    'id_mobil' => 1,
                    'id_pelanggan' => 770,
                    'tanggal_keluar' => date('Y-m-d'), // Sesuaikan dengan kolom yang ingin diambil
                    'jenis_pesanan' => 3,
                    'input_status_keluar ' => $this->session->userdata('nama_lengkap')
                ];

                // Ambil nilai dari masing-masing kolom di tabel ambil_rutin_karyawan sesuai dengan id_jenis_barang yang sesuai
                $dataKeluarJadi['jumlah_keluar'] = $this->getJumlahAkhirByIdJenisBarang($keluarJadiData, $idJenisBarang);
                $dataKeluarJadi['jumlah_akhir'] = $this->getJumlahAkhirByIdJenisBarang($keluarJadiData, $idJenisBarang);

                // Insert data ke tabel keluar_jadi
                $this->db->insert('keluar_jadi', $dataKeluarJadi);
            }
        }

        // var_dump($jenisBarangIds);
        // die();
    }

    private function getJenisBarangIds($keluarJadiData)
    {
        // Array yang menentukan korespondensi antara kolom di tabel ambil_rutin_karyawan dengan data di tabel jenis_barang
        $mapping = [
            'galon' => 'galon 19l',
            'gelas' => 'gelas 220ml ijen',
            'btl330' => 'botol 330ml ijen',
            'btl500' => 'botol 500ml ijen',
            'btl1500' => 'botol 1500ml ijen',
        ];

        $jenisBarangIds = [];

        // Iterasi melalui mapping dan cek apakah nilai kolom di tabel ambil_rutin_karyawan cocok dengan data di tabel jenis_barang
        foreach ($mapping as $column => $jenisBarang) {
            if ($keluarJadiData[$column] > 0) {
                $query = $this->db->get_where('jenis_barang', ['nama_barang_jadi' => $jenisBarang]);

                if ($query->num_rows() > 0) {
                    foreach ($query->result() as $row) {
                        $jenisBarangIds[] = $row->id_jenis_barang;
                    }
                }
            }
        }

        // Jika tidak ada kecocokan, Anda perlu menangani ini sesuai dengan logika aplikasi Anda
        return $jenisBarangIds;
    }

    // Fungsi untuk mendapatkan jumlah_akhir berdasarkan id_jenis_barang
    private function getJumlahAkhirByIdJenisBarang($keluarJadiData, $idJenisBarang)
    {
        // Logika untuk mengambil nilai dari masing-masing kolom di tabel ambil_rutin_karyawan sesuai dengan id_jenis_barang yang sesuai
        // Sesuaikan logika ini dengan struktur tabel dan hubungan antara kolom-kolom di tabel ambil_rutin_karyawan
        $jumlahAkhir = 0;

        // Contoh: Jika $idJenisBarang adalah 1, maka ambil nilai dari kolom yang sesuai
        switch ($idJenisBarang) {
            case 1:
                $jumlahAkhir = $keluarJadiData['galon'];
                break;
            case 2:
                $jumlahAkhir = $keluarJadiData['gelas'];
                break;
            case 8:
                $jumlahAkhir = $keluarJadiData['btl330'];
                break;
            case 9:
                $jumlahAkhir = $keluarJadiData['btl500'];
                break;
            case 11:
                $jumlahAkhir = $keluarJadiData['btl1500'];
                break;
        }

        return $jumlahAkhir;
    }
}
