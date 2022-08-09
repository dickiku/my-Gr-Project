<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Periode_pemilu_model extends CI_Model{

    public function getDataPeriode()
    {
        return $this->db->get('tb_periode_pemilu');
    }

    public function tambahPeriode()
    {
        $data = [
            'periode' => $this->input->post('periode')
        ];

        $this->db->insert('tb_periode_pemilu',$data);
    }

    public function getDetailPeriode($id_periode)
    {
        $q = $this->db->where("id_periode_pemilu",$id_periode);

        return $this->db->get('tb_periode_pemilu'); 
    }

    public function editDataPeriode($id_periode)
    {
        $data = [
            'periode' => $this->input->post('periode')
        ];

        $this->db->where("id_periode_pemilu",$id_periode);
        $this->db->update('tb_periode_pemilu',$data);
    }
}

?>