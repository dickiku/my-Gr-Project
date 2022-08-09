<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Calon_model extends CI_Model{

    public function getDataCalonAnggotaById($id_keanggotaan)
    {
        $this->db->where('id_keanggotaan',$id_keanggotaan);
        return $this->db->get('tb_keanggotaan');
    }

    public function getDataCalonAnggotaKu($id_keanggotaan)
    {
        $q = $this->db->query("SELECT tb_keanggotaan.*, wilayah_kab.*, wilayah_kec.*, wilayah_desa.* 
                                FROM tb_keanggotaan
                                JOIN wilayah_kab ON tb_keanggotaan.id_kab = wilayah_kab.id_kab 
                                JOIN wilayah_kec ON tb_keanggotaan.id_kec = wilayah_kec.id_kec
                                JOIN wilayah_desa ON tb_keanggotaan.id_desa = wilayah_desa.id_desa 
                                WHERE tb_keanggotaan.id_keanggotaan = '$id_keanggotaan'");

        return $q;
    }
}