<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keanggotaan_model extends CI_Model{

    public function getDataKeanggotaanByStatusAktif()
    {
        $q = $this->db->query("SELECT tb_keanggotaan.*, wilayah_kab.* 
                                FROM tb_keanggotaan
                                JOIN wilayah_kab ON tb_keanggotaan.id_kab = wilayah_kab.id_kab
                                WHERE status = '1'");

        return $q;
    }

    public function getDataKeanggotaan()
    {
        $this->db->where('status', 1);
        return $this->db->get('tb_keanggotaan');
    }

    public function getDataKeanggotaanByStatusNon()
    {
        $q = $this->db->query("SELECT tb_keanggotaan.*, wilayah_kab.* 
                                FROM tb_keanggotaan
                                JOIN wilayah_kab ON tb_keanggotaan.id_kab = wilayah_kab.id_kab
                                WHERE status = '0'");

        return $q;
    }

    public function getDataKeanggotaanByStatusAktifIdKab($id_kab)
    {
        $this->db->where('status', 1);
        $this->db->where('id_kab', $id_kab);
        return $this->db->get('tb_keanggotaan');
    }

    public function getDataKeanggotaanByStatusNonIdKab($id_kab)
    {
        $this->db->where('status', 0);
        $this->db->where('id_kab', $id_kab);
        return $this->db->get('tb_keanggotaan');
    }

    // public function getDataIdKeanggotaan($id_keanggotaan)
    // {
    //     $q = $this->db->query("SELECT * FROM tb_keanggotaan WHERE id_keanggotaan = '$id_keanggotaan'");

    //     return $q;
    // }

    public function getDataIdKeanggotaan($id_keanggotaan)
    {
        $q = $this->db->query("SELECT tb_keanggotaan.*, wilayah_kab.*, wilayah_kec.*, wilayah_desa.* 
                                FROM tb_keanggotaan
                                JOIN wilayah_kab ON tb_keanggotaan.id_kab = wilayah_kab.id_kab 
                                JOIN wilayah_kec ON tb_keanggotaan.id_kec = wilayah_kec.id_kec
                                JOIN wilayah_desa ON tb_keanggotaan.id_desa = wilayah_desa.id_desa 
                                WHERE id_keanggotaan = '$id_keanggotaan'");

        return $q;
    }

    public function edit($id_keanggotaan, $foto, $ktp)
    {
        $data = [
            'foto_profil'       => $foto,
            'foto_ktp'          => $ktp,
            'nama'              => $this->input->post('nama'),
            'tempat_lahir'      => $this->input->post('tempat_lahir'),
            'tgl_lahir'         => $this->input->post('tgl_lahir'),
            'no_ktp'            => $this->input->post('no_ktp'),
            'no_kta'            => $this->input->post('no_kta'),
            'alamat'            => $this->input->post('alamat'),
            'agama'             => $this->input->post('agama'),
            'no_hp'             => $this->input->post('no_hp'),
            'email'             => $this->input->post('email'),
            'jenis_kelamin'     => $this->input->post('jenis_kelamin'),
            'status_perkawinan' => $this->input->post('status_perkawinan'),
            'nama_istri_suami'  => $this->input->post('nama_istri_suami'),
            'nama_anak'         => $this->input->post('nama_anak'),
            'latar_pendidikan'  => $this->input->post('latar_pendidikan'),
            'latar_organisasi'  => $this->input->post('latar_organisasi'),
            'latar_pekerjaan'   => $this->input->post('latar_pekerjaan'),
            'id_kab'            => $this->input->post('dpc_kab_kota'),
            'id_kec'            => $this->input->post('wilayah_kec'),
            'id_desa'           => $this->input->post('wilayah_desa'),
        ];

        $this->db->where('id_keanggotaan', $id_keanggotaan);
        $this->db->update('tb_keanggotaan', $data);
    }

    public function tambahData($foto, $ktp)
    {
        $id_kta = preg_replace("/[^0-9]/", "", ($this->input->post('wilayah_desa')));
        $id_kta2 = date('d-m-Y', strtotime($this->input->post('tgl_lahir'))); 
        $sub_kta = substr($id_kta,2,-4);
        $sub_kta2 = preg_replace("/[^0-9]/", "",($id_kta2));
        // $data1 = preg_replace("/[^0-9]/", "", ($this->input->post('wilayah_desa')));
        // $data2 = substr(($this->input->post('no_ktp')),4);
        $query = $this->db->query('SELECT MAX(id_keanggotaan) as id FROM tb_keanggotaan')->row()->id;
        $queri = $query+1;
        $kta = "114"."$sub_kta"."$sub_kta2"."$queri";
        $data = [
            'foto_profil'       => $foto,
            'foto_ktp'          => $ktp,
            'nama'              => $this->input->post('nama'),
            'tempat_lahir'      => $this->input->post('tempat_lahir'),
            'tgl_lahir'         => $this->input->post('tgl_lahir'),
            'no_ktp'            => $this->input->post('no_ktp'),
            'no_kta'            => $kta,
            'alamat'            => $this->input->post('alamat'),
            'agama'             => $this->input->post('agama'),
            'no_hp'             => $this->input->post('no_hp'),
            'email'             => $this->input->post('email'),
            'jenis_kelamin'     => $this->input->post('jenis_kelamin'),
            'status_perkawinan' => $this->input->post('status_perkawinan'),
            'nama_istri_suami'  => $this->input->post('nama_istri_suami'),
            'nama_anak'         => $this->input->post('nama_anak'),
            'latar_pendidikan'  => $this->input->post('latar_pendidikan'),
            'latar_organisasi'  => $this->input->post('latar_organisasi'),
            'latar_pekerjaan'   => $this->input->post('latar_pekerjaan'),
            'id_kab'            => $this->input->post('dpc_kab_kota'),
            'id_kec'            => $this->input->post('wilayah_kec'),
            'id_desa'           => $this->input->post('wilayah_desa'),
            'status'            => 1,
        ];

        $this->db->insert('tb_keanggotaan', $data);
    }

    public function getDataJabatan()
    {
        return $this->db->get('tb_jabatan');
    }

    public function getDataJabatan2()
    {
        return $this->db->get('tb_jabatan_2');
    }

    public function getDataWilayahKec()
    {
        return $this->db->get('wilayah_kec');
    }

    public function getDataWilayahDesa()
    {
        return $this->db->get('wilayah_desa');
    }

}