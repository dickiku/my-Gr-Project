<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dapil_model extends CI_Model{
    
    public function getDataRi()
    {
        return $this->db->get('tb_dapil_ri');
    }

    public function getDataProv()
    {
        return $this->db->get('tb_dapil_prov');
    }

    public function getDataKab($id_kab)
    {
        $q = $this->db->where("id_kab",$id_kab);

        return $this->db->get('tb_dapil_kab');
    }

    public function getDataWilKab($id_kab)
    {
        $q = $this->db->where("id_kab",$id_kab);

        return $this->db->get('wilayah_kab');
    }

    public function tambahDapilRI()
    {
        $data = [
            'nama_dapil_ri' => $this->input->post('nama'),
            'wilayah'       => $this->input->post('wilayah')
        ];

        $this->db->insert('tb_dapil_ri',$data);
    }

    public function tambahDapilProv()
    {
        $data = [
            'nama_dapil_prov' => $this->input->post('nama'),
            'wilayah'       => $this->input->post('wilayah')
        ];

        $this->db->insert('tb_dapil_prov',$data);
    }

    public function tambahDapilKab()
    {
        $data = [
            'nama_dapil_kab' => $this->input->post('nama'),
            'wilayah'       => $this->input->post('wilayah'),
            'id_kab'        => $this->input->post('id_kab')
        ];

        $this->db->insert('tb_dapil_kab',$data);
    }

    public function detailDapilRi($id_dapil_ri)
    {
        $q = $this->db->where("id_dapil_ri",$id_dapil_ri);

        return $this->db->get('tb_dapil_ri');
    }

    public function detailDapilProv($id_dapil_prov)
    {
        $q = $this->db->where("id_dapil_prov",$id_dapil_prov);

        return $this->db->get('tb_dapil_prov');
    }

    public function detailDapilKab($id_dapil_kab)
    {
        $q = $this->db->where("id_dapil_kab",$id_dapil_kab);

        return $this->db->get('tb_dapil_kab');
    }

    public function editDapilRi($id_dapil)
    {
        $data = [
            'nama_dapil_ri' => $this->input->post('nama'),
            'wilayah'       => $this->input->post('wilayah')
        ];

        $this->db->where('id_dapil_ri',$id_dapil);
        $this->db->update('tb_dapil_ri',$data);
    }

    public function editDapilProv($id_dapil)
    {
        $data = [
            'nama_dapil_prov' => $this->input->post('nama'),
            'wilayah'       => $this->input->post('wilayah')
        ];

        $this->db->where('id_dapil_prov',$id_dapil);
        $this->db->update('tb_dapil_prov',$data);
    }

    public function editDapilKab($id_dapil)
    {
        $data = [
            'nama_dapil_kab' => $this->input->post('nama'),
            'wilayah'       => $this->input->post('wilayah'),
            'id_kab'        => $this->input->post('id_kab')
        ];

        $this->db->where('id_dapil_kab',$id_dapil);
        $this->db->update('tb_dapil_kab',$data);
    }

}
?>