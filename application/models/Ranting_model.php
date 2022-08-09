<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Ranting_model extends CI_Model{

    public function getDataWilayahById($id_kab)
    {
        $q = $this->db->query("SELECT * FROM wilayah_kec WHERE id_kab = '$id_kab'");

        return $q;
    }

    public function getDataWilayahDesa($id_kec)
    {
        $q = $this->db->query("SELECT * FROM wilayah_desa WHERE id_kec = '$id_kec'");

        return $q;
    }

    public function getDetailDesa($id_desa)
    {
        $q = $this->db->query("SELECT tb_ranting.*, wilayah_kab.nm_kab, wilayah_kec.nm_kec, wilayah_desa.nm_desa
                                FROM tb_ranting
                                JOIN wilayah_kab ON tb_ranting.id_kab = wilayah_kab.id_kab
                                JOIN wilayah_kec ON tb_ranting.id_kec = wilayah_kec.id_kec
                                JOIN wilayah_desa ON tb_ranting.id_desa = wilayah_desa.id_desa
                                WHERE tb_ranting.id_desa = '$id_desa'");

        return $q;
    }

    public function getDataByIdRanting($id_ranting)
    {
        $q = $this->db->query("SELECT tb_ranting.*, wilayah_kab.nm_kab, wilayah_kec.nm_kec, wilayah_desa.nm_desa
                                FROM tb_ranting
                                JOIN wilayah_kab ON tb_ranting.id_kab = wilayah_kab.id_kab
                                JOIN wilayah_kec ON tb_ranting.id_kec = wilayah_kec.id_kec                                
                                JOIN wilayah_desa ON tb_ranting.id_desa = wilayah_desa.id_desa                                
                                WHERE id_ranting= '$id_ranting'");

        return $q;
    }

    public function getDataRantingByIdDesa($id_desa)
    {
        $q = $this->db->query("SELECT tb_ranting.*, wilayah_kab.*, wilayah_kec.*, wilayah_desa.*
                                FROM tb_ranting
                                JOIN wilayah_kab ON tb_ranting.id_kab = wilayah_kab.id_kab
                                JOIN wilayah_kec ON tb_ranting.id_kec = wilayah_kec.id_kec                                
                                JOIN wilayah_desa ON tb_ranting.id_desa = wilayah_desa.id_desa                                
                                WHERE tb_ranting.id_desa= '$id_desa'");

        return $q;
    }

    public function tambahData($scan)
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
            'id_kab'        => $this->input->post('dpc_kab_kota'),
            'id_kec'        => $this->input->post('wilayah_kec'),
            'id_desa'        => $this->input->post('wilayah_desa'),
        ];

        $this->db->insert('tb_ranting', $data);
    }

    public function edit($id_ranting, $scan)
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
        ];

        $this->db->where('id_ranting', $id_ranting);
        $this->db->update('tb_ranting', $data);
    }

    public function getDataKepengurusanRantingbyId($id_ranting)
    {
        $q = $this->db->query("SELECT tb_pengurus_ranting.*, tb_jabatan.nama_jabatan, tb_keanggotaan.nama, wilayah_desa.nm_desa, tb_ranting.*
                                FROM tb_pengurus_ranting
                                JOIN tb_jabatan ON tb_pengurus_ranting.id_jabatan = tb_jabatan.id_jabatan
                                JOIN tb_keanggotaan ON tb_pengurus_ranting.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                                JOIN wilayah_desa ON tb_pengurus_ranting.id_desa = wilayah_desa.id_desa
                                JOIN tb_ranting ON tb_pengurus_ranting.id_ranting = tb_ranting.id_ranting
                                WHERE tb_pengurus_ranting.id_ranting = '$id_ranting'");

        return $q;
    }

    public function getDataKepengurusanRantingbyIdDesa($idd_desa)
    {
        $q = $this->db->query("SELECT tb_pengurus_ranting.*, tb_jabatan.nama_jabatan, tb_keanggotaan.nama, wilayah_desa.nm_desa, tb_ranting.*
                                FROM tb_pengurus_ranting
                                JOIN tb_jabatan ON tb_pengurus_ranting.id_jabatan = tb_jabatan.id_jabatan
                                JOIN tb_keanggotaan ON tb_pengurus_ranting.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                                JOIN wilayah_desa ON tb_pengurus_ranting.id_desa = wilayah_desa.id_desa
                                JOIN tb_ranting ON tb_pengurus_ranting.id_ranting = tb_ranting.id_ranting
                                WHERE tb_pengurus_ranting.id_desa = '$idd_desa'");

        return $q;
    }

    public function getDataPengurusRantingById($id_pengurus_ranting)
    {
        $q = $this->db->query("SELECT tb_pengurus_ranting.*, tb_jabatan.*, tb_keanggotaan.*
                                FROM tb_pengurus_ranting
                                JOIN tb_jabatan ON tb_pengurus_ranting.id_jabatan = tb_jabatan.id_jabatan
                                JOIN tb_keanggotaan ON tb_pengurus_ranting.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                                WHERE tb_pengurus_ranting.id_pengurus_ranting='$id_pengurus_ranting'");

        return $q;
    }

    public function tambahDataKepengurusan()
    {
        $id_keanggotaan = $this->input->post('keanggotaan');

        $data = [
            'kolom'             => $this->input->post('kolom'),
            'id_keanggotaan'    => $this->input->post('keanggotaan'),
            'id_jabatan'        => $this->input->post('jabatan'),
            'id_desa'           => $this->input->post('id_desa'),
            'id_ranting'        => $this->input->post('id_ranting'),
        ];

        $query = $this->db->where('id_keanggotaan', $id_keanggotaan)
                            ->where('status', 1)
                            ->get('tb_keanggotaan');

        if($query->num_rows() > 0)
        {
            $this->db->insert('tb_pengurus_ranting',$data);

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

    public function editKepengurusan($id_pengurus_ranting)
    {
        $data = [
            'kolom'             => $this->input->post('kolom'),
            'id_keanggotaan'    => $this->input->post('id_keanggotaan'),
            'id_jabatan'        => $this->input->post('jabatan'),
        ];

        $this->db->where('id_pengurus_ranting', $id_pengurus_ranting);
        $this->db->update('tb_pengurus_ranting', $data);
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

    public function getDataStrukturRanting($id_desa,$jab)
    {
        $q = $this->db->query("SELECT tb_pengurus_ranting.*, tb_jabatan.*, tb_keanggotaan.*
                            FROM tb_pengurus_ranting
                            JOIN tb_jabatan ON tb_pengurus_ranting.id_jabatan = tb_jabatan.id_jabatan
                            JOIN tb_keanggotaan ON tb_pengurus_ranting.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                            WHERE tb_pengurus_ranting.id_desa = '$id_desa' AND tb_pengurus_ranting.id_jabatan = '$jab'");

        return $q;
    }

    // public function getDataRanting($id_desa)
    // {
    //     $q = $this->db->query("SELECT tb_ranting.*, wilayah_desa.nm_desa 
    //                             FROM tb_ranting
    //                             JOIN wilayah_desa
    //                             ON tb_ranting.id_desa = wilayah_desa.id_desa
    //                             WHERE tb_ranting.id_desa='$id_desa'");

    //     return $q;
    // }


    // public function getDataDesaById($id_kec)
    // {
    //     $q = $this->db->query("SELECT tb_pac.*, wilayah_kab.nm_kab, wilayah_kec.nm_kec
    //                             FROM tb_pac
    //                             JOIN wilayah_kab ON tb_pac.id_kab = wilayah_kab.id_kab
    //                             JOIN wilayah_kec ON tb_pac.id_kec = wilayah_kec.id_kec
    //                             WHERE tb_pac.id_kec = '$id_kec'");

    //     return $q;
    // }

    // public function getDataKecamatanById($id_kec)
    // {
    //     $q = $this->db->query("SELECT tb_pac.*, wilayah_kab.nm_kab, wilayah_kec.nm_kec
    //                             FROM tb_pac
    //                             JOIN wilayah_kab ON tb_pac.id_kab = wilayah_kab.id_kab
    //                             JOIN wilayah_kec ON tb_pac.id_kec = wilayah_kec.id_kec
    //                             WHERE tb_pac.id_kec = '$id_kec'");

    //     return $q;
    // }
}