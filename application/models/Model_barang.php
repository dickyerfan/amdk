<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_barang extends CI_Model
{

    public function get_all_data($table)
    {
        $this->db->select('*');
        $this->db->from($table);
        return $this->db->get()->result();
    }

    public function upload($table, $data)
    {
        $this->db->insert($table, $data);
    }


    public function get_id($table, $colum, $id)
    {
        return $this->db->get_where($table, [$colum => $id])->row();
    }

    public function update($table, $id, $data)
    {
        $this->db->where($id, $this->input->post($id));
        $this->db->update($table, $data);
    }

    public function hapus($table, $id_link, $id)
    {
        $this->db->where($id_link, $id);
        $this->db->delete($table);
    }
}
