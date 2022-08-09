<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gmd_model extends CI_Model{

    public function getDataWilayahKabById($id_kab)
    {
        $this->db->where('id_kab', $id_kab);
        return $this->db->get('wilayah_kab');
    }

    public function getDataAngkatan()
    {
        return $this->db->get('tb_angkatan');
    }

    public function getDataAngkatanById($id_angkatan)
    {
        $this->db->where('id_angkatan',$id_angkatan);
        return $this->db->get('tb_angkatan');
    }

    public function getDataKepengurusanGmdById($id_angkatan)
    {
        $q = $this->db->query("SELECT tb_pengurus_gmd.*, tb_jabatan.*, tb_keanggotaan.*, tb_angkatan.*, wilayah_prov.*
                                FROM tb_pengurus_gmd
                                JOIN tb_jabatan ON tb_pengurus_gmd.id_jabatan = tb_jabatan.id_jabatan
                                JOIN tb_keanggotaan ON tb_pengurus_gmd.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                                JOIN tb_angkatan ON tb_pengurus_gmd.id_angkatan = tb_angkatan.id_angkatan
                                JOIN wilayah_prov ON tb_pengurus_gmd.id_prov = wilayah_prov.id_prov
                                WHERE tb_pengurus_gmd.id_prov = '33' AND tb_pengurus_gmd.id_angkatan = '$id_angkatan'
                                ");
        return $q;
    }

    public function getDataKepengurusanGmdKabupatenById($id_kab, $id_angkatan)
    {
        $q = $this->db->query("SELECT tb_pengurus_gmd.*, tb_jabatan.*, tb_keanggotaan.*, tb_angkatan.*, wilayah_kab.*
                                FROM tb_pengurus_gmd
                                JOIN tb_jabatan ON tb_pengurus_gmd.id_jabatan = tb_jabatan.id_jabatan
                                JOIN tb_keanggotaan ON tb_pengurus_gmd.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                                JOIN tb_angkatan ON tb_pengurus_gmd.id_angkatan = tb_angkatan.id_angkatan
                                JOIN wilayah_kab ON tb_pengurus_gmd.id_kab = wilayah_kab.id_kab
                                WHERE tb_pengurus_gmd.id_kab = '$id_kab' AND tb_pengurus_gmd.id_angkatan = '$id_angkatan'
                                ");
        return $q;
    }

    public function getDataKepengurusanGmdKabupatenByIdKab($id_kab)
    {
        $q = $this->db->query("SELECT tb_pengurus_gmd.*, tb_jabatan.*, tb_keanggotaan.*, tb_angkatan.*, wilayah_kab.*
                                FROM tb_pengurus_gmd
                                JOIN tb_jabatan ON tb_pengurus_gmd.id_jabatan = tb_jabatan.id_jabatan
                                JOIN tb_keanggotaan ON tb_pengurus_gmd.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                                JOIN tb_angkatan ON tb_pengurus_gmd.id_angkatan = tb_angkatan.id_angkatan
                                JOIN wilayah_kab ON tb_pengurus_gmd.id_kab = wilayah_kab.id_kab
                                WHERE tb_pengurus_gmd.id_kab = '$id_kab'
                                ");

        return $q;
    }

    public function tambahDataKepengurusanProvinsi()
    {
        $id_keanggotaan = $this->input->post('keanggotaan');

        $data = [
            'id_keanggotaan'    => $this->input->post('keanggotaan'),
            'id_jabatan'        => $this->input->post('jabatan'),
            'id_angkatan'       => $this->input->post('id_angkatan'),
            'id_prov'           => $this->input->post('id_prov'),
        ];

        $query = $this->db->where('id_keanggotaan', $id_keanggotaan)
                            ->where('status', 1)
                            ->get('tb_keanggotaan');

        if($query->num_rows() > 0)
        {
            $this->db->insert('tb_pengurus_gmd',$data);

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

    public function tambahDataKepengurusanKabupaten()
    {
        $id_keanggotaan = $this->input->post('keanggotaan');

        $data = [
            'id_keanggotaan'    => $this->input->post('keanggotaan'),
            'id_jabatan'        => $this->input->post('jabatan'),
            'id_angkatan'       => $this->input->post('id_angkatan'),
            'id_kab'            => $this->input->post('id_kab'),
        ];

        $query = $this->db->where('id_keanggotaan', $id_keanggotaan)
                            ->where('status', 1)
                            ->get('tb_keanggotaan');

        if($query->num_rows() > 0)
        {
            $this->db->insert('tb_pengurus_gmd',$data);

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

    public function getDataPengurusGmdById($id_pengurus_gmd)
    {
        $q = $this->db->query("SELECT tb_pengurus_gmd.*, tb_jabatan.*, tb_keanggotaan.*
                                FROM tb_pengurus_gmd
                                JOIN tb_jabatan ON tb_pengurus_gmd.id_jabatan = tb_jabatan.id_jabatan 
                                JOIN tb_keanggotaan ON tb_pengurus_gmd.id_keanggotaan = tb_keanggotaan.id_keanggotaan 
                                WHERE tb_pengurus_gmd.id_pengurus_gmd = '$id_pengurus_gmd'
                                ");
        return $q;
    }

    public function editKepengurusan($id_pengurus_gmd)
    {
        $data = [
            'id_keanggotaan'    => $this->input->post('id_keanggotaan'),
            'id_jabatan'        => $this->input->post('jabatan'),
        ];

        $this->db->where('id_pengurus_gmd', $id_pengurus_gmd);
        $this->db->update('tb_pengurus_gmd', $data);
    }

    public function getDataKepengurusanGmdProvinsi()
    {
        $q = $this->db->query("SELECT tb_pengurus_gmd.*, tb_jabatan.*, tb_keanggotaan.*, tb_angkatan.*, wilayah_prov.*
                                FROM tb_pengurus_gmd
                                JOIN tb_jabatan ON tb_pengurus_gmd.id_jabatan = tb_jabatan.id_jabatan
                                JOIN tb_keanggotaan ON tb_pengurus_gmd.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                                JOIN tb_angkatan ON tb_pengurus_gmd.id_angkatan = tb_angkatan.id_angkatan
                                JOIN wilayah_prov ON tb_pengurus_gmd.id_prov = wilayah_prov.id_prov
                                WHERE tb_pengurus_gmd.id_prov = '33'
                                ");
        return $q;
    }
}