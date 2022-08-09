<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Partai_model extends CI_Model{

    public function getDataPartai()
    {
        return $this->db->get('tb_partai');
    }

    public function tambahData()
    {
        $data = [
            'nama_partai'   => $this->input->post('nama_partai')
        ];

        $this->db->insert('tb_partai',$data);
    }

    public function getDataPartaiById($id_partai)
    {
        $this->db->where('id_partai',$id_partai);
        return $this->db->get('tb_partai');
    }

    public function editData($id_partai)
    {
        $data = [
            'nama_partai'   => $this->input->post('nama_partai')
        ];

        $this->db->where('id_partai',$id_partai);
        $this->db->update('tb_partai',$data);
    }
}