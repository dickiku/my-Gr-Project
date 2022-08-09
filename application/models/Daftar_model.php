<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_model extends CI_Model{

    public function daftarCalon($foto, $ktp)
    {
        $data1 = preg_replace("/[^0-9]/", "", ($this->input->post('wilayah_desa')));
        $data2 = substr(($this->input->post('no_ktp')),4);
        $kta = "$data1"."$data2";
        $data = [
            'foto_profil'       => $foto,
            'foto_ktp'          => $ktp,
            'nama'              => htmlspecialchars( $this->input->post('nama'), TRUE),
            'no_ktp'            => htmlspecialchars($this->input->post('no_ktp'), TRUE), 
            'no_kta'            => $kta,
            'alamat'            => $this->input->post('alamat'),
            'agama'             => $this->input->post('agama'),
            'no_hp'             => $this->input->post('no_hp'),
            'email'             => $this->input->post('email'),
            'tempat_lahir'      => $this->input->post('tempat_lahir'),
            'tgl_lahir'         => $this->input->post('tgl_lahir'),
            'jenis_kelamin'     => $this->input->post('jenis_kelamin'),
            'status_perkawinan' => $this->input->post('status_perkawinan'),
            'nama_istri_suami'  => $this->input->post('nama_istri_suami'),
            'nama_anak'         => $this->input->post('nama_anak'),
            'latar_pendidikan'  => $this->input->post('latar_pendidikan'),
            'latar_organisasi'  => $this->input->post('latar_organisasi'),
            'latar_pekerjaan'   => $this->input->post('latar_pekerjaan'),
            'status'            => 0,
            'id_kab'            => $this->input->post('dpc_kab_kota'),
            'id_kec'            => $this->input->post('wilayah_kec'),
            'id_desa'           => $this->input->post('wilayah_desa'),
        ];

        $this->db->insert('tb_keanggotaan', $data);
    }

    public function daftarAnggota($foto, $ktp)
    {
        $data = [
            'foto_profil'       => $foto,
            'foto_ktp'          => $ktp,
            'nama'              => $this->input->post('nama'),
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
            'status'            => 1
        ];

        $this->db->insert('tb_keanggotaan', $data);
    }
}