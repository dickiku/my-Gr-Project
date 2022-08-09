<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Satgas_model extends CI_Model{

    public function getDataWilayahKabById($id_kab)
    {
        $q = $this->db->query("SELECT * FROM wilayah_kab WHERE id_kab='$id_kab'");

        return $q;
    }

    public function getDataKepengurusanSatgasbyId($id_kab)
    {
        $q = $this->db->query("SELECT tb_pengurus_satgas.*, tb_jabatan_2.nama_jabatan, tb_keanggotaan.*, wilayah_kab.nm_kab
                                FROM tb_pengurus_satgas
                                JOIN tb_jabatan_2 ON tb_pengurus_satgas.id_jabatan = tb_jabatan_2.id_jabatan
                                JOIN tb_keanggotaan ON tb_pengurus_satgas.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                                JOIN wilayah_kab ON tb_pengurus_satgas.id_kab = wilayah_kab.id_kab
                                WHERE tb_pengurus_satgas.id_kab = '$id_kab'");

        return $q;
    }

    public function getDataKepengurusanSatgas()
    {
        $q = $this->db->query("SELECT tb_pengurus_satgas.*, tb_jabatan_2.nama_jabatan, tb_keanggotaan.*
                                FROM tb_pengurus_satgas
                                JOIN tb_jabatan_2 ON tb_pengurus_satgas.id_jabatan = tb_jabatan_2.id_jabatan
                                JOIN tb_keanggotaan ON tb_pengurus_satgas.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                                WHERE id_prov = 1");

        return $q;
    }

    public function tambahDataKepengurusan()
    {
        $id_keanggotaan = $this->input->post('keanggotaan');

        $data = [
            'id_keanggotaan' => $this->input->post('keanggotaan'),
            'id_jabatan'     => $this->input->post('jabatan'),
            'id_kab'         => $this->input->post('dpc_kab_kota'),
        ];

        $query = $this->db->where('id_keanggotaan', $id_keanggotaan)
                            ->where('status', 1)
                            ->get('tb_keanggotaan');

        if($query->num_rows() > 0)
        {
            $this->db->insert('tb_pengurus_satgas',$data);

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

    public function tambahDataKepengurusanProvinsi()
    {
        $id_keanggotaan = $this->input->post('keanggotaan');

        $data = [
            'id_keanggotaan' => $this->input->post('keanggotaan'),
            'id_kab'         => 0,
            'id_prov'        => 1,
            'id_jabatan'        => $this->input->post('jabatan'),
        ];

        $query = $this->db->where('id_keanggotaan', $id_keanggotaan)
                            ->where('status', 1)
                            ->get('tb_keanggotaan');

        if($query->num_rows() > 0)
        {
            $this->db->insert('tb_pengurus_satgas',$data);

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

    public function editKepengurusan($id_pengurus_satgas)
    {
        $data = [
            'id_keanggotaan'    => $this->input->post('id_keanggotaan'),
            'id_jabatan'           => $this->input->post('jabatan'),
        ];

        $this->db->where('id_pengurus_satgas', $id_pengurus_satgas);
        $this->db->update('tb_pengurus_satgas', $data);
    }

    public function getDataPengurusSatgasById($id_pengurus_satgas)
    {
        $q = $this->db->query("SELECT tb_pengurus_satgas.*, tb_jabatan_2.*, tb_keanggotaan.*
                                FROM tb_pengurus_satgas
                                JOIN tb_jabatan_2 ON tb_pengurus_satgas.id_jabatan = tb_jabatan_2.id_jabatan
                                JOIN tb_keanggotaan ON tb_pengurus_satgas.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                                WHERE tb_pengurus_satgas.id_pengurus_satgas='$id_pengurus_satgas'");

        return $q;
    }

    public function getDataPengurusSatgasProvinsiById($id_pengurus_satgas)
    {
        $q = $this->db->query("SELECT tb_pengurus_satgas.*, tb_jabatan_2.*, tb_keanggotaan.*
                                FROM tb_pengurus_satgas
                                JOIN tb_jabatan_2 ON tb_pengurus_satgas.id_jabatan = tb_jabatan_2.id_jabatan
                                JOIN tb_keanggotaan ON tb_pengurus_satgas.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                                WHERE tb_pengurus_satgas.id_pengurus_satgas='$id_pengurus_satgas'");

        return $q;
    }
}