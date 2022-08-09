<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dpd_model extends CI_Model{

    // public function getDataDpdJateng()
    // {
    //     $q = $this->db->query("SELECT * FROM wilayah_prov WHERE id_prov=33");

    //     return $q;
    // }

    public function getDataKepengurusan()
    {
        $q = $this->db->query("SELECT * FROM tb_dpd");

        return $q;
    }

    public function getDataDpdById($id_dpd)
    {
        $q = $this->db->query("SELECT * FROM tb_dpd WHERE id_dpd='$id_dpd'");

        return $q;
    }

    public function tambahData($foto, $scan)
    {
        $data = [
            'alamat'        => $this->input->post('alamat'),
            'no_telp'       => $this->input->post('no_telp'),
            'no_sk'         => $this->input->post('no_sk'),
            'tanggal_sk'    => $this->input->post('tanggal_sk'),
            'admin'         => $this->input->post('admin'),
            'link_facebook' => $this->input->post('link_facebook'),
            'link_instagram'=> $this->input->post('link_instagram'),
            'link_tiktok'   => $this->input->post('link_tiktok'),
            'admin'         => $this->input->post('admin'),
            'scan_sk'       => $scan,
            'foto_kantor'   => $foto,
        ];

        $this->db->insert('tb_dpd', $data);
    }

    public function edit($id_dpd, $foto, $foto1, $foto2, $scan)
    {
        $data = [
            'alamat'            => $this->input->post('alamat'),
            'no_telp'           => $this->input->post('no_telp'),
            'no_sk'             => $this->input->post('no_sk'),
            'tanggal_sk'        => $this->input->post('tanggal_sk'),
            'admin'             => $this->input->post('admin'),
            'link_facebook'     => $this->input->post('link_facebook'),
            'link_instagram'    => $this->input->post('link_instagram'),
            'link_tiktok'       => $this->input->post('link_tiktok'),
            'scan_sk'           => $scan,
            'foto_kantor'       => $foto,
            'foto_kantor_1'     => $foto1,
            'foto_kantor_2'     => $foto2,

        ];

        $this->db->where('id_dpd', $id_dpd);
        $this->db->update('tb_dpd', $data);
    }

    // public function editFoto($id_dpd, $foto)
    // {
    //     $data = [
    //         'alamat'            => $this->input->post('alamat'),
    //         'no_telp'           => $this->input->post('no_telp'),
    //         'no_sk'             => $this->input->post('no_sk'),
    //         'tanggal_sk'        => $this->input->post('tanggal_sk'),
    //         'admin'             => $this->input->post('admin'),
    //         'foto_kantor'       => $foto,
    //     ];

    //     $this->db->where('id_dpd', $id_dpd);
    //     $this->db->update('tb_dpd', $data);
    // }

    // public function editFoto1($id_dpd, $foto1)
    // {
    //     $data = [
    //         'alamat'            => $this->input->post('alamat'),
    //         'no_telp'           => $this->input->post('no_telp'),
    //         'no_sk'             => $this->input->post('no_sk'),
    //         'tanggal_sk'        => $this->input->post('tanggal_sk'),
    //         'admin'             => $this->input->post('admin'),
    //         'foto_kantor_1'       => $foto1,
    //     ];

    //     $this->db->where('id_dpd', $id_dpd);
    //     $this->db->update('tb_dpd', $data);
    // }

    // public function editFoto2($id_dpd, $foto2)
    // {
    //     $data = [
    //         'alamat'            => $this->input->post('alamat'),
    //         'no_telp'           => $this->input->post('no_telp'),
    //         'no_sk'             => $this->input->post('no_sk'),
    //         'tanggal_sk'        => $this->input->post('tanggal_sk'),
    //         'admin'             => $this->input->post('admin'),
    //         'foto_kantor_2'     => $foto2,
    //     ];

    //     $this->db->where('id_dpd', $id_dpd);
    //     $this->db->update('tb_dpd', $data);
    // }

    //     public function editScan($id_dpd, $scan)
    // {
    //     $data = [
    //         'alamat'            => $this->input->post('alamat'),
    //         'no_telp'           => $this->input->post('no_telp'),
    //         'no_sk'             => $this->input->post('no_sk'),
    //         'tanggal_sk'        => $this->input->post('tanggal_sk'),
    //         'admin'             => $this->input->post('admin'),
    //         'scan_sk'           => $scan,
    //     ];

    //     $this->db->where('id_dpd', $id_dpd);
    //     $this->db->update('tb_dpd', $data);
    // }

    public function tambahDataKepengurusan()
    {
        $id_keanggotaan = $this->input->post('keanggotaan');

        $data = [
            'kolom'             => $this->input->post('kolom'),
            'id_keanggotaan'    => $this->input->post('keanggotaan'),
            'id_jabatan'        => $this->input->post('jabatan')
        ];

        $query = $this->db->where('id_keanggotaan', $id_keanggotaan)
                            ->where('status', 1)
                            ->get('tb_keanggotaan');

        if($query->num_rows() > 0)
        {
            $this->db->insert('tb_pengurus_dpd',$data);

            return $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');
        }
        else
        {
            return $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    <strong>Error!</strong> Data Gagal Ditambahkan.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');
        }      
    }

    public function getDataKepengurusanDPD()
    {
        $q = $this->db->query("SELECT tb_pengurus_dpd.*, tb_jabatan.nama_jabatan, tb_keanggotaan.nama
                                FROM tb_pengurus_dpd
                                JOIN tb_jabatan ON tb_pengurus_dpd.id_jabatan = tb_jabatan.id_jabatan
                                JOIN tb_keanggotaan ON tb_pengurus_dpd.id_keanggotaan = tb_keanggotaan.id_keanggotaan");
        
        return $q;
    }
    
    public function getDataPengurusDpdById($id_pengurus_dpd)
    {
        $q = $this->db->query("SELECT tb_pengurus_dpd.*, tb_jabatan.*, tb_keanggotaan.*
                                FROM tb_pengurus_dpd
                                JOIN tb_jabatan ON tb_pengurus_dpd.id_jabatan = tb_jabatan.id_jabatan
                                JOIN tb_keanggotaan ON tb_pengurus_dpd.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                                WHERE tb_pengurus_dpd.id_pengurus_dpd='$id_pengurus_dpd'");

        return $q;
    }

    public function editKepengurusan($id_pengurus_dpd)
    {
        $data = [
            'kolom'             => $this->input->post('kolom'),
            'id_keanggotaan'    => $this->input->post('id_keanggotaan'),
            'id_jabatan'        => $this->input->post('jabatan'),
        ];

        $this->db->where('id_pengurus_dpd', $id_pengurus_dpd);
        $this->db->update('tb_pengurus_dpd', $data);
    }
}