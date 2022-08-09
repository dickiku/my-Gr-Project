<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dpc_model extends CI_Model{

    public function tambahData($foto, $foto1, $foto2, $scan)
    {
        $data = [
            'alamat'        => $this->input->post('alamat'),
            'no_telp'       => $this->input->post('no_telp'),
            'no_sk'         => $this->input->post('no_sk'),
            'tanggal_sk'    => $this->input->post('tanggal_sk'),
            'admin'         => $this->input->post('admin'),
            'link_facebook'     => $this->input->post('link_facebook'),
            'link_instagram'    => $this->input->post('link_instagram'),
            'link_tiktok'       => $this->input->post('link_tiktok'),
            'scan_sk'       => $scan,
            'foto_kantor'   => $foto,
            'foto_kantor_1' => $foto1,
            'foto_kantor_2' => $foto2,
            'id_kab'        => $this->input->post('dpc_kab_kota'),
        ];

        $this->db->insert('tb_dpc', $data);
    }

    public function getDataDpcById($id_dpc)
    {
        $q = $this->db->query("SELECT tb_dpc.*, wilayah_kab.nm_kab 
                                FROM tb_dpc
                                JOIN wilayah_kab
                                ON tb_dpc.id_kab = wilayah_kab.id_kab
                                WHERE id_dpc='$id_dpc'");

        return $q;
    }

    public function getDataDpcByIdKab($id_kab)
    {
        $q = $this->db->query("SELECT tb_dpc.*, wilayah_kab.nm_kab 
                                FROM tb_dpc
                                JOIN wilayah_kab
                                ON tb_dpc.id_kab = wilayah_kab.id_kab
                                WHERE tb_dpc.id_kab='$id_kab'");

        return $q;
    }

    public function edit($id_dpc, $foto, $foto1, $foto2, $scan)
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

        $this->db->where('id_dpc', $id_dpc);
        $this->db->update('tb_dpc', $data);
    }

    public function getDataKepengurusanDPCbyId($id_dpc)
    {
        $q = $this->db->query("SELECT tb_pengurus_dpc.*, tb_jabatan.nama_jabatan, tb_keanggotaan.nama, wilayah_kab.nm_kab, tb_dpc.*
                                FROM tb_pengurus_dpc
                                JOIN tb_jabatan ON tb_pengurus_dpc.id_jabatan = tb_jabatan.id_jabatan
                                JOIN tb_keanggotaan ON tb_pengurus_dpc.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                                JOIN wilayah_kab ON tb_pengurus_dpc.id_kab = wilayah_kab.id_kab
                                JOIN tb_dpc ON tb_pengurus_dpc.id_dpc = tb_dpc.id_dpc
                                WHERE tb_pengurus_dpc.id_dpc = '$id_dpc'");

        return $q;
    }

    public function getDataKepengurusanDPCbyIdKab($id_kab)
    {
        $q = $this->db->query("SELECT tb_pengurus_dpc.*, tb_jabatan.nama_jabatan, tb_keanggotaan.nama, wilayah_kab.nm_kab, tb_dpc.*
                                FROM tb_pengurus_dpc
                                JOIN tb_jabatan ON tb_pengurus_dpc.id_jabatan = tb_jabatan.id_jabatan
                                JOIN tb_keanggotaan ON tb_pengurus_dpc.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                                JOIN wilayah_kab ON tb_pengurus_dpc.id_kab = wilayah_kab.id_kab
                                JOIN tb_dpc ON tb_pengurus_dpc.id_dpc = tb_dpc.id_dpc
                                WHERE tb_pengurus_dpc.id_kab = '$id_kab'");

        return $q;
    }

    public function getDataPengurusDpcById($id_pengurus_dpc)
    {
        $q = $this->db->query("SELECT tb_pengurus_dpc.*, tb_jabatan.*, tb_keanggotaan.*
                                FROM tb_pengurus_dpc
                                JOIN tb_jabatan ON tb_pengurus_dpc.id_jabatan = tb_jabatan.id_jabatan
                                JOIN tb_keanggotaan ON tb_pengurus_dpc.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                                WHERE tb_pengurus_dpc.id_pengurus_dpc='$id_pengurus_dpc'");

        return $q;
    }

    public function tambahDataKepengurusan()
    {
        $id_keanggotaan = $this->input->post('keanggotaan');

        $data = [
            'kolom'          => $this->input->post('kolom'),
            'id_keanggotaan' => $this->input->post('keanggotaan'),
            'id_jabatan'     => $this->input->post('jabatan'),
            'id_kab'         => $this->input->post('dpc_kab_kota'),
            'id_dpc'         => $this->input->post('id_dpc'),
        ];

        $query = $this->db->where('id_keanggotaan', $id_keanggotaan)
                            ->where('status', 1)
                            ->get('tb_keanggotaan');

        if($query->num_rows() > 0)
        {
            $this->db->insert('tb_pengurus_dpc',$data);

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

    public function editKepengurusan($id_pengurus_dpc)
    {
        $data = [
            'kolom'             => $this->input->post('kolom'),
            'id_keanggotaan'    => $this->input->post('id_keanggotaan'),
            'id_jabatan'        => $this->input->post('jabatan'),
        ];

        $this->db->where('id_pengurus_dpc', $id_pengurus_dpc);
        $this->db->update('tb_pengurus_dpc', $data);
    }

    public function getDataStrukturDpc($id_kab,$jab)
    {
        $q = $this->db->query("SELECT tb_pengurus_dpc.*, tb_jabatan.*, tb_keanggotaan.*
                            FROM tb_pengurus_dpc
                            JOIN tb_jabatan ON tb_pengurus_dpc.id_jabatan = tb_jabatan.id_jabatan
                            JOIN tb_keanggotaan ON tb_pengurus_dpc.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                            WHERE tb_pengurus_dpc.id_kab = '$id_kab' AND tb_pengurus_dpc.id_jabatan = '$jab'");

        return $q;
    }

    // public function getDataKepengurusanDPC()
    // {
    //     $q = $this->db->query("SELECT tb_pengurus_dpc.*, tb_jabatan.nama_jabatan, tb_keanggotaan.nama, wilayah_kab.nm_kab
    //                             FROM tb_pengurus_dpc
    //                             JOIN tb_jabatan ON tb_pengurus_dpc.id_jabatan = tb_jabatan.id_jabatan
    //                             JOIN tb_keanggotaan ON tb_pengurus_dpc.id_keanggotaan = tb_keanggotaan.id_keanggotaan
    //                             JOIN wilayah_kab ON tb_pengurus_dpc.id_kab = wilayah_kab.id_kab
    //                             ");

    //     return $q;
    // }
}