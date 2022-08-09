<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wilayah_kab_model extends CI_Model{

    public function getDataWilayah()
    {
        $q = $this->db->query("SELECT * FROM wilayah_kab WHERE id_prov=33");

        return $q;
    }

    public function getDataKab($id_kab)
    {
        $q = $this->db->query("SELECT wilayah_kab.nm_kab, tb_dpc.*
                                FROM wilayah_kab
                                JOIN tb_dpc
                                ON wilayah_kab.id_kab = tb_dpc.id_kab
                                WHERE tb_dpc.id_kab = '$id_kab'");
        return $q;
    }

    public function getDataWilayahKabByIdKab($id_kab)
    {
        $this->db->where('id_kab',$id_kab);
        return $this->db->get('wilayah_kab');
    }

    public function getDataWilayahKecByIdKec($id_kecamatan)
    {
        $this->db->where('id_kec',$id_kecamatan);
        return $this->db->get('wilayah_kec');
    }

    public function getDataWilayahDesaByIdDesa($id_desa)
    {
        $this->db->where('id_desa',$id_desa);
        return $this->db->get('wilayah_desa');
    }

    public function getDataWilayahKecByIdKab($id_kab)
    {
        $this->db->where('id_kab',$id_kab);
        return $this->db->get('wilayah_kec');
    }

    
}