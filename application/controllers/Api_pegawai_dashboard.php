<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api_pegawai_dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // Load database
        header('Access-Control-Allow-Origin: *'); // Allow all origins
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
    }

    public function get_direktur()
    {

        $direktur = $this->db->query("SELECT * FROM pegawai LEFT JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan WHERE jabatan.nama_jabatan = 'Direktur' AND pegawai.aktif = '1' ")->row();

        $response = ['direktur' => $direktur];

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function get_spi()
    {

        $ketua = $this->db->query("SELECT * FROM pegawai LEFT JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan WHERE jabatan.nama_jabatan = 'Ketua' AND aktif = '1' ")->row();
        $a_spi = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Anggota' AND bagian.nama_bagian = 'S P I' AND subag.nama_subag = 'S P I' AND aktif = '1' ")->result();

        $response = [
            'ketua' => $ketua,
            'a_spi' => $a_spi
        ];

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function get_langganan()
    {

        $k_lang = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian WHERE jabatan.nama_jabatan = 'Kabag' AND bagian.nama_bagian = 'Langganan' AND aktif = '1' ")->row();
        $ks_lang = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kasubag' AND bagian.nama_bagian = 'Langganan' AND subag.nama_subag = 'Langganan' AND aktif = '1' ")->row();
        $ks_tagih = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kasubag' AND bagian.nama_bagian = 'Langganan' AND subag.nama_subag = 'Penagihan' AND aktif = '1' ")->row();
        $s_lang = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'Langganan' AND subag.nama_subag = 'Langganan' AND aktif = '1' ")->result();
        $s_tagih = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'Langganan' AND subag.nama_subag = 'Penagihan' AND aktif = '1' ")->result();
        $s_umumSec =

            $response = [
                'k_lang' => $k_lang,
                'ks_lang' => $ks_lang,
                's_lang' => $s_lang,
                'ks_tagih' => $ks_tagih,
                's_tagih' => $s_tagih
            ];

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function get_umum()
    {

        $k_umum = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian WHERE jabatan.nama_jabatan = 'Kabag' AND bagian.nama_bagian = 'Umum' AND aktif = '1' ")->row();
        $ks_umum = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kasubag' AND bagian.nama_bagian = 'Umum' AND subag.nama_subag = 'Umum' AND aktif = '1' ")->row();
        $s_umum = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'Umum' AND subag.nama_subag = 'Umum' AND aktif = '1' ")->result();
        $s_umumSec = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Security)' AND bagian.nama_bagian = 'Umum' AND subag.nama_subag = 'Umum' AND aktif = '1' ")->result();

        $ks_admin = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kasubag' AND bagian.nama_bagian = 'Umum' AND subag.nama_subag = 'Administrasi' AND aktif = '1' ")->row();

        $s_admin = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'Umum' AND subag.nama_subag = 'Administrasi' AND aktif = '1' ")->result();

        $ks_person = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kasubag' AND bagian.nama_bagian = 'Umum' AND subag.nama_subag = 'Personalia' AND aktif = '1' ")->row();

        $s_person = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'Umum' AND subag.nama_subag = 'Personalia' AND aktif = '1' ")->result();

        $response = [
            'k_umum' => $k_umum,
            'ks_umum' => $ks_umum,
            's_umum' => $s_umum,
            's_umumSec' => $s_umumSec,
            'ks_admin' => $ks_admin,
            's_admin' => $s_admin,
            'ks_person' => $ks_person,
            's_person' => $s_person
        ];

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function get_keuangan()
    {

        $k_keu = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian WHERE jabatan.nama_jabatan = 'Kabag' AND bagian.nama_bagian = 'Keuangan' AND aktif = '1' ")->row();

        $ks_kas = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kasubag' AND bagian.nama_bagian = 'Keuangan' AND subag.nama_subag = 'Kas' AND aktif = '1' ")->row();

        $s_kas = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'Keuangan' AND subag.nama_subag = 'Kas' AND aktif = '1' ")->result();

        $ks_buku = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kasubag' AND bagian.nama_bagian = 'Keuangan' AND subag.nama_subag = 'Pembukuan' AND aktif = '1' ")->row();

        $s_buku = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'Keuangan' AND subag.nama_subag = 'Pembukuan' AND aktif = '1' ")->result();

        $ks_rek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kasubag' AND bagian.nama_bagian = 'Keuangan' AND subag.nama_subag = 'Rekening' AND aktif = '1' ")->row();

        $s_rek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'Keuangan' AND subag.nama_subag = 'Rekening' AND aktif = '1' ")->result();

        $response = [
            'k_keu' => $k_keu,
            'ks_kas' => $ks_kas,
            's_kas' => $s_kas,
            'ks_buku' => $ks_buku,
            's_buku' => $s_buku,
            'ks_rek' => $ks_rek,
            's_rek' => $s_rek,
        ];

        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function get_perencanaan()
    {

        $k_renc = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian WHERE jabatan.nama_jabatan = 'Kabag' AND bagian.nama_bagian = 'Perencanaan' AND aktif = '1' ")->row();

        $ks_renc = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kasubag' AND bagian.nama_bagian = 'Perencanaan' AND subag.nama_subag = 'Perencanaan' AND aktif = '1' ")->row();

        $s_renc = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'Perencanaan' AND subag.nama_subag = 'Perencanaan' AND aktif = '1' ")->result();

        $ks_awas = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kasubag' AND bagian.nama_bagian = 'Perencanaan' AND subag.nama_subag = 'pengawasan' AND aktif = '1' ")->row();

        $s_awas = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'Perencanaan' AND subag.nama_subag = 'pengawasan' AND aktif = '1' ")->result();

        $response = [
            'k_renc' => $k_renc,
            'ks_renc' => $ks_renc,
            's_renc' => $s_renc,
            'ks_awas' => $ks_awas,
            's_awas' => $s_awas
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function get_pemeliharaan()
    {

        $k_peml = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian WHERE jabatan.nama_jabatan = 'Kabag' AND bagian.nama_bagian = 'Pemeliharaan' AND aktif = '1' ")->row();

        $ks_peml = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kasubag' AND bagian.nama_bagian = 'Pemeliharaan' AND subag.nama_subag = 'Pemeliharaan' AND aktif = '1' ")->row();

        $s_peml_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'Pemeliharaan' AND subag.nama_subag = 'Pemeliharaan' AND aktif = '1' ")->result();

        $s_peml_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'Pemeliharaan' AND subag.nama_subag = 'Pemeliharaan' AND aktif = '1' ")->result();

        $ks_alat = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kasubag' AND bagian.nama_bagian = 'Pemeliharaan' AND subag.nama_subag = 'peralatan' AND aktif = '1' ")->row();

        $s_alat_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'Pemeliharaan' AND subag.nama_subag = 'peralatan' AND aktif = '1' ")->result();

        $s_alat_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'Pemeliharaan' AND subag.nama_subag = 'peralatan' AND aktif = '1' ")->result();

        $response = [
            'k_peml' => $k_peml,
            'ks_peml' => $ks_peml,
            's_peml_adm' => $s_peml_adm,
            's_peml_tek' => $s_peml_tek,
            'ks_alat' => $ks_alat,
            's_alat_adm' => $s_alat_adm,
            's_alat_tek' => $s_alat_tek
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function get_bondowoso()
    {

        $bond = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Ka UPK' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Bondowoso' AND aktif = '1' ")->row();

        $bond_p_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Bondowoso' AND aktif = '1' ")->row();

        $bond_s_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Bondowoso' AND aktif = '1' ")->result();

        $bond_s_admPm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Pembaca Meter)' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Bondowoso' AND aktif = '1' ")->result();

        $bond_p_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Bondowoso' AND aktif = '1' ")->row();

        $bond_s_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Bondowoso' AND aktif = '1' ")->result();

        $bond_p_lang = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Pelayanan Pelanggan' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Bondowoso' AND aktif = '1' ")->row();

        $bond_s_lang = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Pelayanan Pelanggan' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Bondowoso' AND aktif = '1' ")->result();

        $response = [
            'bond' => $bond,
            'bond_p_adm' => $bond_p_adm,
            'bond_s_adm' => $bond_s_adm,
            'bond_s_admPm' => $bond_s_admPm,
            'bond_p_tek' => $bond_p_tek,
            'bond_s_tek' => $bond_s_tek,
            'bond_p_lang' => $bond_p_lang,
            'bond_s_lang' => $bond_s_lang,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function get_sukosari_1()
    {
        $suko1 = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Ka UPK' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Sukosari 1' AND aktif = '1' ")->row();

        $suko1_p_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Sukosari 1' AND aktif = '1' ")->row();

        $suko1_s_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Sukosari 1' AND aktif = '1' ")->result();

        $suko1_s_admPm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Pembaca Meter)' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Sukosari 1' AND aktif = '1' ")->result();

        $suko1_p_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Sukosari 1' AND aktif = '1' ")->row();

        $suko1_s_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Sukosari 1' AND aktif = '1' ")->result();

        $response = [
            'suko1' => $suko1,
            'suko1_p_adm' => $suko1_p_adm,
            'suko1_s_adm' => $suko1_s_adm,
            'suko1_s_admPm' => $suko1_s_admPm,
            'suko1_p_tek' => $suko1_p_tek,
            'suko1_s_tek' => $suko1_s_tek,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function get_maesan()
    {
        $maesan = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Ka UPK' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Maesan' AND aktif = '1' ")->row();

        $maesan_p_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Maesan' AND aktif = '1' ")->row();

        $maesan_s_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Maesan' AND aktif = '1' ")->result();

        $maesan_s_admPm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Pembaca Meter)' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Maesan' AND aktif = '1' ")->result();

        $maesan_p_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Maesan' AND aktif = '1' ")->row();

        $maesan_s_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Maesan' AND aktif = '1' ")->result();

        $response = [
            'maesan' => $maesan,
            'maesan_p_adm' => $maesan_p_adm,
            'maesan_s_adm' => $maesan_s_adm,
            'maesan_s_admPm' => $maesan_s_admPm,
            'maesan_p_tek' => $maesan_p_tek,
            'maesan_s_tek' => $maesan_s_tek,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function get_tegalampel()
    {
        $tegalampel = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Ka UPK' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tegalampel' AND aktif = '1' ")->row();

        $tegalampel_p_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tegalampel' AND aktif = '1' ")->row();

        $tegalampel_s_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tegalampel' AND aktif = '1' ")->result();

        $tegalampel_s_admPm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Pembaca Meter)' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tegalampel' AND aktif = '1' ")->result();

        $tegalampel_p_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tegalampel' AND aktif = '1' ")->row();

        $tegalampel_s_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tegalampel' AND aktif = '1' ")->result();

        $response = [
            'tegalampel' => $tegalampel,
            'tegalampel_p_adm' => $tegalampel_p_adm,
            'tegalampel_s_adm' => $tegalampel_s_adm,
            'tegalampel_s_admPm' => $tegalampel_s_admPm,
            'tegalampel_p_tek' => $tegalampel_p_tek,
            'tegalampel_s_tek' => $tegalampel_s_tek,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function get_tapen()
    {
        $tapen = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Ka UPK' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tapen' AND aktif = '1' ")->row();

        $tapen_p_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tapen' AND aktif = '1' ")->row();

        $tapen_s_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tapen' AND aktif = '1' ")->result();

        $tapen_s_admPm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Pembaca Meter)' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tapen' AND aktif = '1' ")->result();

        $tapen_p_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tapen' AND aktif = '1' ")->row();

        $tapen_s_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tapen' AND aktif = '1' ")->result();

        $response = [
            'tapen' => $tapen,
            'tapen_p_adm' => $tapen_p_adm,
            'tapen_s_adm' => $tapen_s_adm,
            'tapen_s_admPm' => $tapen_s_admPm,
            'tapen_p_tek' => $tapen_p_tek,
            'tapen_s_tek' => $tapen_s_tek,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function get_prajekan()
    {
        $prajekan = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Ka UPK' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Prajekan' AND aktif = '1' ")->row();

        $prajekan_p_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Prajekan' AND aktif = '1' ")->row();

        $prajekan_s_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Prajekan' AND aktif = '1' ")->result();

        $prajekan_s_admPm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Pembaca Meter)' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Prajekan' AND aktif = '1' ")->result();

        $prajekan_p_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Prajekan' AND aktif = '1' ")->row();

        $prajekan_s_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Prajekan' AND aktif = '1' ")->result();

        $response = [
            'prajekan' => $prajekan,
            'prajekan_p_adm' => $prajekan_p_adm,
            'prajekan_s_adm' => $prajekan_s_adm,
            'prajekan_s_admPm' => $prajekan_s_admPm,
            'prajekan_p_tek' => $prajekan_p_tek,
            'prajekan_s_tek' => $prajekan_s_tek,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function get_tlogosari()
    {
        $tlogosari = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Ka UPK' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tlogosari' AND aktif = '1' ")->row();

        $tlogosari_p_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tlogosari' AND aktif = '1' ")->row();

        $tlogosari_s_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tlogosari' AND aktif = '1' ")->result();

        $tlogosari_s_admPm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Pembaca Meter)' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tlogosari' AND aktif = '1' ")->result();

        $tlogosari_p_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tlogosari' AND aktif = '1' ")->row();

        $tlogosari_s_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tlogosari' AND aktif = '1' ")->result();

        $response = [
            'tlogosari' => $tlogosari,
            'tlogosari_p_adm' => $tlogosari_p_adm,
            'tlogosari_s_adm' => $tlogosari_s_adm,
            'tlogosari_s_admPm' => $tlogosari_s_admPm,
            'tlogosari_p_tek' => $tlogosari_p_tek,
            'tlogosari_s_tek' => $tlogosari_s_tek,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function get_wringin()
    {
        $wringin = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Ka UPK' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Wringin' AND aktif = '1' ")->row();

        $wringin_p_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Wringin' AND aktif = '1' ")->row();

        $wringin_s_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Wringin' AND aktif = '1' ")->result();

        $wringin_s_admPm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Pembaca Meter)' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Wringin' AND aktif = '1' ")->result();

        $wringin_p_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Wringin' AND aktif = '1' ")->row();

        $wringin_s_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Wringin' AND aktif = '1' ")->result();

        $response = [
            'wringin' => $wringin,
            'wringin_p_adm' => $wringin_p_adm,
            'wringin_s_adm' => $wringin_s_adm,
            'wringin_s_admPm' => $wringin_s_admPm,
            'wringin_p_tek' => $wringin_p_tek,
            'wringin_s_tek' => $wringin_s_tek,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function get_curahdami()
    {
        $curahdami = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Ka UPK' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Curahdami' AND aktif = '1' ")->row();

        $curahdami_p_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Curahdami' AND aktif = '1' ")->row();

        $curahdami_s_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Curahdami' AND aktif = '1' ")->result();

        $curahdami_s_admPm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Pembaca Meter)' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Curahdami' AND aktif = '1' ")->result();

        $curahdami_p_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'curahdami' AND aktif = '1' ")->row();

        $curahdami_s_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Curahdami' AND aktif = '1' ")->result();

        $response = [
            'curahdami' => $curahdami,
            'curahdami_p_adm' => $curahdami_p_adm,
            'curahdami_s_adm' => $curahdami_s_adm,
            'curahdami_s_admPm' => $curahdami_s_admPm,
            'curahdami_p_tek' => $curahdami_p_tek,
            'curahdami_s_tek' => $curahdami_s_tek,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function get_tamanan()
    {
        $tamanan = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Ka UPK' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tamanan' AND aktif = '1' ")->row();

        $tamanan_p_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tamanan' AND aktif = '1' ")->row();

        $tamanan_s_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tamanan' AND aktif = '1' ")->result();

        $tamanan_s_admPm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Pembaca Meter)' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tamanan' AND aktif = '1' ")->result();

        $tamanan_p_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tamanan' AND aktif = '1' ")->row();

        $tamanan_s_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tamanan' AND aktif = '1' ")->result();

        $response = [
            'tamanan' => $tamanan,
            'tamanan_p_adm' => $tamanan_p_adm,
            'tamanan_s_adm' => $tamanan_s_adm,
            'tamanan_s_admPm' => $tamanan_s_admPm,
            'tamanan_p_tek' => $tamanan_p_tek,
            'tamanan_s_tek' => $tamanan_s_tek,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function get_tenggarang()
    {
        $tenggarang = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Ka UPK' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tenggarang' AND aktif = '1' ")->row();

        $tenggarang_p_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tenggarang' AND aktif = '1' ")->row();

        $tenggarang_s_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tenggarang' AND aktif = '1' ")->result();

        $tenggarang_s_admPm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Pembaca Meter)' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tenggarang' AND aktif = '1' ")->result();

        $tenggarang_p_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tenggarang' AND aktif = '1' ")->row();

        $tenggarang_s_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tenggarang' AND aktif = '1' ")->result();

        $response = [
            'tenggarang' => $tenggarang,
            'tenggarang_p_adm' => $tenggarang_p_adm,
            'tenggarang_s_adm' => $tenggarang_s_adm,
            'tenggarang_s_admPm' => $tenggarang_s_admPm,
            'tenggarang_p_tek' => $tenggarang_p_tek,
            'tenggarang_s_tek' => $tenggarang_s_tek,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function get_tamankrocok()
    {
        $tamankrocok = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Ka UPK' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tamankrocok' AND aktif = '1' ")->row();

        $tamankrocok_p_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tamankrocok' AND aktif = '1' ")->row();

        $tamankrocok_s_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tamankrocok' AND aktif = '1' ")->result();

        $tamankrocok_s_admPm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Pembaca Meter)' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tamankrocok' AND aktif = '1' ")->result();

        $tamankrocok_p_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tamankrocok' AND aktif = '1' ")->row();

        $tamankrocok_s_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Tamankrocok' AND aktif = '1' ")->result();

        $response = [
            'tamankrocok' => $tamankrocok,
            'tamankrocok_p_adm' => $tamankrocok_p_adm,
            'tamankrocok_s_adm' => $tamankrocok_s_adm,
            'tamankrocok_s_admPm' => $tamankrocok_s_admPm,
            'tamankrocok_p_tek' => $tamankrocok_p_tek,
            'tamankrocok_s_tek' => $tamankrocok_s_tek,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function get_wonosari()
    {
        $wonosari = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Ka UPK' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'wonosari' AND aktif = '1' ")->row();

        $wonosari_p_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'wonosari' AND aktif = '1' ")->row();

        $wonosari_s_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'wonosari' AND aktif = '1' ")->result();

        $wonosari_s_admPm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Pembaca Meter)' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Wonosari' AND aktif = '1' ")->result();

        $wonosari_p_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'wonosari' AND aktif = '1' ")->row();

        $wonosari_s_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'wonosari' AND aktif = '1' ")->result();

        $response = [
            'wonosari' => $wonosari,
            'wonosari_p_adm' => $wonosari_p_adm,
            'wonosari_s_adm' => $wonosari_s_adm,
            'wonosari_s_admPm' => $wonosari_s_admPm,
            'wonosari_p_tek' => $wonosari_p_tek,
            'wonosari_s_tek' => $wonosari_s_tek,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function get_sukosari_2()
    {
        $suko2 = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Ka UPK' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Sukosari 2' AND aktif = '1' ")->row();

        $suko2_p_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Sukosari 2' AND aktif = '1' ")->row();

        $suko2_s_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Sukosari 2' AND aktif = '1' ")->result();

        $suko2_s_admPm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi(Pembaca Meter)' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Sukosari 2' AND aktif = '1' ")->result();

        $suko2_p_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Pelaksana Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Sukosari 2' AND aktif = '1' ")->row();

        $suko2_s_tek = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Teknik' AND bagian.nama_bagian = 'U P K' AND subag.nama_subag = 'Sukosari 2' AND aktif = '1' ")->result();


        $response = [
            'suko2' => $suko2,
            'suko2_p_adm' => $suko2_p_adm,
            'suko2_s_adm' => $suko2_s_adm,
            'suko2_s_admPm' => $suko2_s_admPm,
            'suko2_p_tek' => $suko2_p_tek,
            'suko2_s_tek' => $suko2_s_tek,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
    public function get_amdk()
    {
        $amdk = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Manager' AND bagian.nama_bagian = 'A M D K' AND subag.nama_subag = 'A M D K' AND aktif = '1' ")->row();

        $amdk2 = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Wakil Manager' AND bagian.nama_bagian = 'A M D K' AND subag.nama_subag = 'A M D K' AND aktif = '1' ")->row();

        $amdk_qc = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kabag' AND bagian.nama_bagian = 'A M D K' AND subag.nama_subag = 'Quality Control' AND aktif = '1' ")->row();

        $amdk_s_qc = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'A M D K' AND subag.nama_subag = 'Quality Control' AND aktif = '1' ")->result();

        $amdk_pro = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kabag' AND bagian.nama_bagian = 'A M D K' AND subag.nama_subag = 'Produksi' AND aktif = '1' ")->row();

        $amdk_s_pro = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf Administrasi' AND bagian.nama_bagian = 'A M D K' AND subag.nama_subag = 'Produksi' AND aktif = '1' ")->result();

        $amdk_pasar = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kabag' AND bagian.nama_bagian = 'A M D K' AND subag.nama_subag = 'Pemasaran' AND aktif = '1' ")->row();

        $amdk_s_pasar = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf administrasi' AND bagian.nama_bagian = 'A M D K' AND subag.nama_subag = 'Pemasaran' AND aktif = '1' ")->result();

        $amdk_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Kabag' AND bagian.nama_bagian = 'A M D K' AND subag.nama_subag = 'Administrasi' AND aktif = '1' ")->row();

        $amdk_s_adm = $this->db->query("SELECT * FROM pegawai JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan JOIN bagian ON pegawai.id_bagian = bagian.id_bagian JOIN subag ON pegawai.id_subag = subag.id_subag WHERE jabatan.nama_jabatan = 'Staf administrasi' AND bagian.nama_bagian = 'A M D K' AND subag.nama_subag = 'Administrasi' AND aktif = '1' ")->result();


        $response = [
            'amdk' => $amdk,
            'amdk2' => $amdk2,
            'amdk_qc' => $amdk_qc,
            'amdk_s_qc' => $amdk_s_qc,
            'amdk_pro' => $amdk_pro,
            'amdk_s_pro' => $amdk_s_pro,
            'amdk_pasar' => $amdk_pasar,
            'amdk_s_pasar' => $amdk_s_pasar,
            'amdk_adm' => $amdk_adm,
            'amdk_s_adm' => $amdk_s_adm,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
}
