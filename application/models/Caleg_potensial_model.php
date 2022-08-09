<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caleg_potensial_model extends CI_Model{

    public function getDapilProvinsi()
    {
        return $this->db->get('tb_dapil_prov');
    }

    public function getDataCalegPotensialProvById($id_dapil_prov)
    {
        $q = $this->db->query("SELECT tb_caleg_potensial.*, tb_keanggotaan.*
                                FROM tb_caleg_potensial
                                JOIN tb_keanggotaan ON tb_caleg_potensial.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                                WHERE tb_caleg_potensial.id_dapil_prov = '$id_dapil_prov'
                                ");
        return $q;
    }

    public function getDataCalegPotensialKabById($id_dapil_kab)
    {
        $q = $this->db->query("SELECT tb_caleg_potensial.*, tb_keanggotaan.*
                                FROM tb_caleg_potensial
                                JOIN tb_keanggotaan ON tb_caleg_potensial.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                                WHERE tb_caleg_potensial.id_dapil_kab = '$id_dapil_kab'
                                ");
        return $q;
    }

    public function getDataDapilProvById($id_dapil_prov)
    {
        $this->db->where('id_dapil_prov',$id_dapil_prov);
        return $this->db->get('tb_dapil_prov');
    }

    public function getDataDapilByIdKab($id_kab)
    {
        $this->db->where('id_kab',$id_kab);
        return $this->db->get('tb_dapil_kab');
    }

    public function getDataDapilByIdDapilKab($id_dapil_kab)
    {
        $this->db->where('id_dapil_kab',$id_dapil_kab);
        return $this->db->get('tb_dapil_kab');
    }

    public function tambahData()
    {
        $id_keanggotaan = $this->input->post('keanggotaan');

        $data = [
            'id_keanggotaan'    => $this->input->post('keanggotaan'),
            'id_dapil_prov'     => $this->input->post('id_dapil_prov')
        ];

        $query = $this->db->where('id_keanggotaan', $id_keanggotaan)
                            ->where('status', 1)
                            ->get('tb_keanggotaan');

        if($query->num_rows() > 0)
        {
            $this->db->insert('tb_caleg_potensial',$data);

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

    public function tambahDataKabupaten()
    {
        $id_keanggotaan = $this->input->post('keanggotaan');

        $data = [
            'id_keanggotaan'    => $this->input->post('keanggotaan'),
            'id_kab'            => $this->input->post('id_kab'),
            'id_dapil_kab'      => $this->input->post('id_dapil_kab')
        ];

        $query = $this->db->where('id_keanggotaan', $id_keanggotaan)
                            ->where('status', 1)
                            ->get('tb_keanggotaan');

        if($query->num_rows() > 0)
        {
            $this->db->insert('tb_caleg_potensial',$data);

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

    public function getDataWilayahKabById($id_kab)
    {
        $this->db->where('id_kab',$id_kab);
        return $this->db->get('wilayah_kab');
    }
}