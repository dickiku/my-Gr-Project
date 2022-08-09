<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calon_presiden_model extends CI_Model{

    public function getDataCapresByPeriode($id_periode)
    {
        $this->db->where('id_periode_pemilu',$id_periode);
        return $this->db->get('tb_capres');
    }

    public function getDataPeriode()
    {
        return $this->db->get('tb_periode_pemilu');
    }

    public function getDataCapresById($id_capres)
    {
        $this->db->where('id_capres',$id_capres);
        return $this->db->get('tb_capres');
    }

    public function tambahCapres()
    {
        $data = [
            'nama_capres'       => $this->input->post('nama_capres'),
            'nama_wapres'       => $this->input->post('nama_wapres'),
            'id_periode_pemilu' => $this->input->post('id_periode_pemilu')
        ];  

        $this->db->insert('tb_capres',$data);
    }

    public function editCapres($id_capres)
    {
        $data = [
            'nama_capres'   => $this->input->post('nama_capres'),
            'nama_wapres'   => $this->input->post('nama_wapres'),
        ];

        $this->db->where('id_capres',$id_capres);
        $this->db->update('tb_capres',$data);
    }

    public function getDataPeriodeById($id_periode)
    {
        $this->db->where('id_periode_pemilu',$id_periode);
        return $this->db->get('tb_periode_pemilu');
    }
}