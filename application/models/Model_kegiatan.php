<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_kegiatan extends CI_Model
{
    public function getAll()
    {
        return $this->db->get('kegiatan_tim')->result();
    }

    public function getById($id)
    {
        return $this->db->where('id', $id)->get('kegiatan_tim')->row();
    }

    public function insert($data)
    {
        $this->db->insert('kegiatan_tim', $data);
        return $this->db->insert_id();
    }

    public function getByKegiatan($id_kegiatan)
    {
        $this->db->where('id_kegiatan', $id_kegiatan);
        $this->db->order_by('tanggal', 'ASC');
        return $this->db->get('tahapan_kegiatan')->result();
    }

    public function insert_tahapan($data)
    {
        $this->db->insert('tahapan_kegiatan', $data);
        return $this->db->insert_id();
    }

    public function getByTahapan($id_tahapan)
    {
        return $this->db->where('id_tahapan', $id_tahapan)->get('foto_tahapan')->result();
    }

    public function insert_foto($data)
    {
        $this->db->insert('foto_tahapan', $data);
    }
}
