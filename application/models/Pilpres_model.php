<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pilpres_model extends CI_Model{

    public function getDataPeriode()
    {
        return $this->db->get('tb_periode_pemilu');
    }

    public function getDataWilayahKabJateng()
    {
        $this->db->where('id_prov','33');
        return $this->db->get('wilayah_kab');
    }

    public function getDataPeriodeById($id_periode)
    {
        $this->db->where('id_periode_pemilu', $id_periode);
        return $this->db->get('tb_periode_pemilu');
    }

    public function getDataWilayahKabById($id_kab)
    {
        $this->db->where('id_kab', $id_kab);
        return $this->db->get('wilayah_kab');
    }

    public function getDataWilayahKecById($id_kec)
    {
        $this->db->where('id_kec', $id_kec);
        return $this->db->get('wilayah_kec');
    }

    public function getDataWilayahDesaById($id_desa)
    {
        $this->db->where('id_desa', $id_desa);
        return $this->db->get('wilayah_desa');
    }

    public function getDataJumlahPemilihKabupatenByPeriode($id_kab,$id_periode)
    {
        $this->db->where('id_kab',$id_kab);
        $this->db->where('id_periode',$id_periode);
        return $this->db->get('tb_jumlah_pemilih');
    }

    public function getDataJumlahPemilihKecamatanByPeriode($id_kec,$id_periode)
    {
        $this->db->where('id_kec',$id_kec);
        $this->db->where('id_periode',$id_periode);
        return $this->db->get('tb_jumlah_pemilih');
    }

    public function getDataJumlahPemilihDesaByPeriode($id_desa,$id_periode)
    {
        $this->db->where('id_desa',$id_desa);
        $this->db->where('id_periode',$id_periode);
        return $this->db->get('tb_jumlah_pemilih');
    }

    public function getDataJumlahPemilihById($id_jumlah_pemilih)
    {
        $this->db->where('id_jumlah_pemilih',$id_jumlah_pemilih);
        return $this->db->get('tb_jumlah_pemilih');
    }

    public function tambahDptKabupaten()
    {
        $data = [
            'id_periode'            => $this->input->post('id_periode_pemilu'),    
            'id_kab'                => $this->input->post('id_kab'),    
            'dpt'                   => $this->input->post('dpt'),
            'pengguna_hak_pilih'    => $this->input->post('pengguna_hak_pilih'),
        ];

        $this->db->insert('tb_jumlah_pemilih',$data);
    }

    public function tambahDptKecamatan()
    {
        $data = [
            'id_periode'            => $this->input->post('id_periode_pemilu'),
            'id_kec'                => $this->input->post('id_kec'),   
            'dpt'                   => $this->input->post('dpt'),
            'pengguna_hak_pilih'    => $this->input->post('pengguna_hak_pilih'),
        ];

        $this->db->insert('tb_jumlah_pemilih',$data);
    }

    public function tambahDptDesa()
    {
        $data = [
            'id_periode'            => $this->input->post('id_periode_pemilu'),
            'id_desa'               => $this->input->post('id_desa'),   
            'dpt'                   => $this->input->post('dpt'),
            'pengguna_hak_pilih'    => $this->input->post('pengguna_hak_pilih'),
        ];

        $this->db->insert('tb_jumlah_pemilih',$data);
    }

    public function editJumlahPemilih($id_jumlah_pemilih)
    {
        $data = [
            'dpt'                   => $this->input->post('dpt'),
            'pengguna_hak_pilih'    => $this->input->post('pengguna_hak_pilih'),
        ];

        $this->db->where('id_jumlah_pemilih',$id_jumlah_pemilih);
        $this->db->update('tb_jumlah_pemilih',$data);
    }

    public function getDataHasilPilpresKabupaten($id_kab,$id_periode)
    {
        $q = $this->db->query("SELECT tb_hasil_pilpres.*, tb_capres.*
                                FROM tb_hasil_pilpres
                                JOIN tb_capres ON tb_hasil_pilpres.id_capres = tb_capres.id_capres
                                WHERE tb_hasil_pilpres.id_periode = '$id_periode' AND tb_hasil_pilpres.id_kab = '$id_kab'
                                ");
        return $q;
    }

    public function getDataHasilPilpresKecamatan($id_kec,$id_periode)
    {
        $q = $this->db->query("SELECT tb_hasil_pilpres.*, tb_capres.*
                                FROM tb_hasil_pilpres
                                JOIN tb_capres ON tb_hasil_pilpres.id_capres = tb_capres.id_capres
                                WHERE tb_hasil_pilpres.id_periode = '$id_periode' AND tb_hasil_pilpres.id_kec = '$id_kec'
                                ");
        return $q;
    }

    public function getDataHasilPilpresDesa($id_desa,$id_periode)
    {
        $q = $this->db->query("SELECT tb_hasil_pilpres.*, tb_capres.*
                                FROM tb_hasil_pilpres
                                JOIN tb_capres ON tb_hasil_pilpres.id_capres = tb_capres.id_capres
                                WHERE tb_hasil_pilpres.id_periode = '$id_periode' AND tb_hasil_pilpres.id_desa = '$id_desa'
                                ");
        return $q;
    }

    public function getDataCapresByPeriode($id_periode)
    {
        $this->db->where('id_periode_pemilu',$id_periode);
        return $this->db->get('tb_capres');
    }

    public function tambahHasilPemiluKabupaten()
    {
        $data = [
            'id_periode'        => $this->input->post('id_periode_pemilu'),
            'id_kab'            => $this->input->post('id_kab'),
            'id_capres'         => $this->input->post('capres'),
            'perolehan'         => $this->input->post('perolehan'),
        ];

        $this->db->insert('tb_hasil_pilpres',$data);
    }

    public function tambahHasilPemiluKecamatan()
    {
        $data = [
            'id_periode'        => $this->input->post('id_periode_pemilu'),
            'id_kec'            => $this->input->post('id_kec'),
            'id_capres'         => $this->input->post('capres'),
            'perolehan'         => $this->input->post('perolehan'),
        ];

        $this->db->insert('tb_hasil_pilpres',$data);
    }

    public function tambahHasilPemiluDesa()
    {
        $data = [
            'id_periode'        => $this->input->post('id_periode_pemilu'),
            'id_desa'           => $this->input->post('id_desa'),
            'id_capres'         => $this->input->post('capres'),
            'perolehan'         => $this->input->post('perolehan'),
        ];

        $this->db->insert('tb_hasil_pilpres',$data);
    }

    public function getDataHasilPilpresById($id_hasil_pilpres)
    {
        $q = $this->db->query("SELECT tb_hasil_pilpres.*, tb_periode_pemilu.*, wilayah_kab.*, tb_capres.*
                                FROM tb_hasil_pilpres
                                JOIN tb_periode_pemilu ON tb_hasil_pilpres.id_periode = tb_periode_pemilu.id_periode_pemilu
                                JOIN wilayah_kab ON tb_hasil_pilpres.id_kab = wilayah_kab.id_kab
                                JOIN tb_capres ON tb_hasil_pilpres.id_capres = tb_capres.id_capres 
                                WHERE tb_hasil_pilpres.id_hasil_pilpres = '$id_hasil_pilpres'
                                ");
        return $q;
    }

    public function getDataHasilPilpresById2($id_hasil_pilpres)
    {
        $q = $this->db->query("SELECT tb_hasil_pilpres.*, tb_periode_pemilu.*, tb_capres.*
                                FROM tb_hasil_pilpres
                                JOIN tb_periode_pemilu ON tb_hasil_pilpres.id_periode = tb_periode_pemilu.id_periode_pemilu
                                JOIN tb_capres ON tb_hasil_pilpres.id_capres = tb_capres.id_capres 
                                WHERE tb_hasil_pilpres.id_hasil_pilpres = '$id_hasil_pilpres'
                                ");
        return $q;
    }

    public function editHasilPemilu($id_hasil_pilpres)
    {
        $data = [
            'perolehan'         => $this->input->post('perolehan'),
        ];

        $this->db->where('id_hasil_pilpres',$id_hasil_pilpres);
        $this->db->update('tb_hasil_pilpres',$data);
    }

    public function getDataKecamatanByIdKab($id_kab)
    {
        $this->db->where('id_kab',$id_kab);
        return $this->db->get('wilayah_kec');
    }

    public function getDataDesaByIdKec($id_kec)
    {
        $this->db->where('id_kec',$id_kec);
        return $this->db->get('wilayah_desa');
    }
}