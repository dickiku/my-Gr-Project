<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ambulance_model extends CI_Model{

    public function getDataAmbulanceProv()
    {
        $this->db->where('id_prov','33');
        return $this->db->get('tb_ambulance');
    }

    public function tambahData()
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'no_hp'     => $this->input->post('no_hp'),
            'plat'      => $this->input->post('plat'),
            'id_prov'   => '33'
        ];

        $this->db->insert('tb_ambulance',$data);
    }

    public function getDataAmbulanceById($id_ambulance)
    {
        $q = $this->db->query("SELECT * FROM tb_ambulance WHERE id_ambulance='$id_ambulance'");

        return $q;
    }

    // public function getDataAmbulanceByIdProv($id_ambulance)
    // {
    //     $q = $this->db->query("SELECT * FROM tb_ambulance WHERE id_ambulance='$id_ambulance'");

    //     return $q;
    // }

    public function getDataAmbulanceByIdKab($id_kab)
    {
        $q = $this->db->query("SELECT * FROM tb_ambulance WHERE id_kab='$id_kab'");

        return $q;
    }

    public function editData($id_ambulance)
    {
        $data = [
            'nama'          => $this->input->post('nama'),
            'no_hp'         => $this->input->post('no_hp'),
            'plat'          => $this->input->post('plat'),
        ];

        $this->db->where('id_ambulance', $id_ambulance);
        $this->db->update('tb_ambulance', $data);
    }

    public function hapusData($id_ambulance)
    {
        $this->db->where('id_ambulance',$id_ambulance);
        $this->db->delete('tb_ambulance');
    }

    public function getWilayahKabupaten($id_kab)
    {
        $this->db->where('id_kab', $id_kab);
        return $this->db->get('wilayah_kab');
    }

    public function tambahDataAmbulanceKabupaten()
    {
        $data = [
            'nama'          => $this->input->post('nama'),
            'no_hp'         => $this->input->post('no_hp'),
            'plat'          => $this->input->post('plat'),
            'id_kab'        => $this->input->post('id_kab')
        ];

        $this->db->insert('tb_ambulance',$data);
    }
}