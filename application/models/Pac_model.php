<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Pac_model extends CI_Model{

    public function getDataWilayahById($id_kab)
    {
        $q = $this->db->query("SELECT * FROM wilayah_kec WHERE id_kab = '$id_kab'");

        return $q;
    }

    public function getDataKecamatanById($id_kec)
    {
        $q = $this->db->query("SELECT tb_pac.*, wilayah_kab.nm_kab, wilayah_kec.nm_kec
                                FROM tb_pac
                                JOIN wilayah_kab ON tb_pac.id_kab = wilayah_kab.id_kab
                                JOIN wilayah_kec ON tb_pac.id_kec = wilayah_kec.id_kec
                                WHERE tb_pac.id_kec = '$id_kec'");

        return $q;
    }

    public function getDataByIdPac($id_pac)
    {
        $q = $this->db->query("SELECT tb_pac.*, wilayah_kab.nm_kab, wilayah_kec.nm_kec
                                FROM tb_pac
                                JOIN wilayah_kab ON tb_pac.id_kab = wilayah_kab.id_kab
                                JOIN wilayah_kec ON tb_pac.id_kec = wilayah_kec.id_kec                                
                                WHERE id_pac='$id_pac'");

        return $q;
    }

    public function getDataPacByIdKec($id_kec)
    {
        $q = $this->db->query("SELECT tb_pac.*, wilayah_kec.*, wilayah_kab.*
                                FROM tb_pac
                                JOIN wilayah_kec ON tb_pac.id_kec = wilayah_kec.id_kec
                                JOIN wilayah_kab ON tb_pac.id_kab = wilayah_kab.id_kab
                                WHERE tb_pac.id_kec='$id_kec'");

        return $q;
    }

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
            'id_kec'        => $this->input->post('wilayah_kec'),
        ];

        $this->db->insert('tb_pac', $data);
    }

    public function edit($id_pac, $foto, $foto1, $foto2, $scan)
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
        ];

        $this->db->where('id_pac', $id_pac);
        $this->db->update('tb_pac', $data);
    }

    public function getDataKepengurusanPACbyId($id_pac)
    {
        $q = $this->db->query("SELECT tb_pengurus_pac.*, tb_jabatan.nama_jabatan, tb_keanggotaan.nama, wilayah_kec.nm_kec, tb_pac.*
                                FROM tb_pengurus_pac
                                JOIN tb_jabatan ON tb_pengurus_pac.id_jabatan = tb_jabatan.id_jabatan
                                JOIN tb_keanggotaan ON tb_pengurus_pac.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                                JOIN wilayah_kec ON tb_pengurus_pac.id_kec = wilayah_kec.id_kec
                                JOIN tb_pac ON tb_pengurus_pac.id_pac = tb_pac.id_pac
                                WHERE tb_pengurus_pac.id_pac = '$id_pac'");

        return $q;
    }

    public function getDataKepengurusanPACbyIdKec($id_kec)
    {
        $q = $this->db->query("SELECT tb_pengurus_pac.*, tb_jabatan.nama_jabatan, tb_keanggotaan.nama, wilayah_kec.nm_kec, tb_pac.*
                                FROM tb_pengurus_pac
                                JOIN tb_jabatan ON tb_pengurus_pac.id_jabatan = tb_jabatan.id_jabatan
                                JOIN tb_keanggotaan ON tb_pengurus_pac.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                                JOIN wilayah_kec ON tb_pengurus_pac.id_kec = wilayah_kec.id_kec
                                JOIN tb_pac ON tb_pengurus_pac.id_pac = tb_pac.id_pac
                                WHERE tb_pengurus_pac.id_kec = '$id_kec'");

        return $q;
    }

    public function getDataPengurusPacById($id_pengurus_pac)
    {
        $q = $this->db->query("SELECT tb_pengurus_pac.*, tb_jabatan.*, tb_keanggotaan.*
                                FROM tb_pengurus_pac
                                JOIN tb_jabatan ON tb_pengurus_pac.id_jabatan = tb_jabatan.id_jabatan
                                JOIN tb_keanggotaan ON tb_pengurus_pac.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                                WHERE tb_pengurus_pac.id_pengurus_pac='$id_pengurus_pac'");

        return $q;
    }

    public function tambahDataKepengurusan()
    {
        $id_keanggotaan = $this->input->post('keanggotaan');

        $data = [
            'kolom'          => $this->input->post('kolom'),
            'id_keanggotaan' => $this->input->post('keanggotaan'),
            'id_jabatan'     => $this->input->post('jabatan'),
            'id_kec'         => $this->input->post('id_kec'),
            'id_pac'         => $this->input->post('id_pac'),
        ];

        $query = $this->db->where('id_keanggotaan', $id_keanggotaan)
                            ->where('status', 1)
                            ->get('tb_keanggotaan');

        if($query->num_rows() > 0)
        {
            $this->db->insert('tb_pengurus_pac',$data);

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

    public function editKepengurusan($id_pengurus_pac)
    {
        $data = [
            'kolom'             => $this->input->post('kolom'),
            'id_keanggotaan'    => $this->input->post('id_keanggotaan'),
            'id_jabatan'        => $this->input->post('jabatan'),
        ];

        $this->db->where('id_pengurus_pac', $id_pengurus_pac);
        $this->db->update('tb_pengurus_pac', $data);
    }

    public function getDataStrukturPac($id_kec,$jab)
    {
        $q = $this->db->query("SELECT tb_pengurus_pac.*, tb_jabatan.*, tb_keanggotaan.*
                            FROM tb_pengurus_pac
                            JOIN tb_jabatan ON tb_pengurus_pac.id_jabatan = tb_jabatan.id_jabatan
                            JOIN tb_keanggotaan ON tb_pengurus_pac.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                            WHERE tb_pengurus_pac.id_kec = '$id_kec' AND tb_pengurus_pac.id_jabatan = '$jab'");

        return $q;
    }

    public function getDataWilayahKecByIdKec($id_kec)
    {
        $this->db->where('id_kec',$id_kec);
        return $this->db->get('wilayah_kec');
    }

}