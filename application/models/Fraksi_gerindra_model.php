<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fraksi_gerindra_model extends CI_Model{

    public function getDataFraksiRiById()
    {
        $this->db->where('ri','1');
        return $this->db->get('tb_fraksi_gerindra');
    }

    public function getDataFraksiByIdProv()
    {
        $this->db->where('id_prov','33');
        return $this->db->get('tb_fraksi_gerindra');
    }

    public function getDataFraksiByIdKabFraksi($id_kab, $id_fraksi_gerindra)
    {
        $this->db->where('id_kab', $id_kab);
        $this->db->where('id_fraksi_gerindra', $id_fraksi_gerindra);
        return $this->db->get('tb_fraksi_gerindra');
    }

    public function getDataKepengurusanFraksiRiById()
    {
        $q = $this->db->query("SELECT tb_pengurus_fraksi_gerindra.*, tb_keanggotaan.*, tb_jabatan_fraksi.*, tb_jabatan_3.*, tb_jabatan_lama.*
                                FROM tb_pengurus_fraksi_gerindra
                                JOIN tb_keanggotaan ON tb_pengurus_fraksi_gerindra.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                                JOIN tb_jabatan_fraksi ON tb_pengurus_fraksi_gerindra.id_jabatan_fraksi = tb_jabatan_fraksi.id_jabatan_fraksi
                                JOIN tb_jabatan_3 ON tb_pengurus_fraksi_gerindra.id_jabatan_3 = tb_jabatan_3.id_jabatan_3 
                                JOIN tb_jabatan_lama ON tb_pengurus_fraksi_gerindra.id_jabatan_lama = tb_jabatan_lama.id_jabatan_lama 
                                WHERE tb_pengurus_fraksi_gerindra.ri = '1'
                                ");
        return $q;
    }

    public function getDataKepengurusanFraksiByIdProv()
    {
        $q = $this->db->query("SELECT tb_pengurus_fraksi_gerindra.*, tb_keanggotaan.*, tb_jabatan_fraksi.*, tb_jabatan_3.*, tb_jabatan_lama.*
                                FROM tb_pengurus_fraksi_gerindra
                                JOIN tb_keanggotaan ON tb_pengurus_fraksi_gerindra.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                                JOIN tb_jabatan_fraksi ON tb_pengurus_fraksi_gerindra.id_jabatan_fraksi = tb_jabatan_fraksi.id_jabatan_fraksi
                                JOIN tb_jabatan_3 ON tb_pengurus_fraksi_gerindra.id_jabatan_3 = tb_jabatan_3.id_jabatan_3 
                                JOIN tb_jabatan_lama ON tb_pengurus_fraksi_gerindra.id_jabatan_lama = tb_jabatan_lama.id_jabatan_lama 
                                WHERE tb_pengurus_fraksi_gerindra.id_prov = '33'
                                ");
        return $q;
    }

    public function getDataKepengurusanFraksiByIdKab($id_kab, $id_fraksi_gerindra)
    {
        $q = $this->db->query("SELECT tb_pengurus_fraksi_gerindra.*, tb_keanggotaan.*, tb_jabatan_fraksi.*, tb_jabatan_3.*, tb_jabatan_lama.*
                                FROM tb_pengurus_fraksi_gerindra
                                JOIN tb_keanggotaan ON tb_pengurus_fraksi_gerindra.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                                JOIN tb_jabatan_fraksi ON tb_pengurus_fraksi_gerindra.id_jabatan_fraksi = tb_jabatan_fraksi.id_jabatan_fraksi
                                JOIN tb_jabatan_3 ON tb_pengurus_fraksi_gerindra.id_jabatan_3 = tb_jabatan_3.id_jabatan_3 
                                JOIN tb_jabatan_lama ON tb_pengurus_fraksi_gerindra.id_jabatan_lama = tb_jabatan_lama.id_jabatan_lama 
                                WHERE tb_pengurus_fraksi_gerindra.id_fraksi_gerindra = '$id_fraksi_gerindra' AND tb_pengurus_fraksi_gerindra.id_kab = '$id_kab'
                                ");
        return $q;
    }

    public function getDataJabatanFraksi()
    {
        return $this->db->get('tb_jabatan_fraksi');
    }

    public function getDataJabatan()
    {
        return $this->db->get('tb_jabatan_3');
    }

    public function getDataJabatanLama()
    {
        return $this->db->get('tb_jabatan_lama');
    }

    public function tambahDataKepengurusanRi()
    {
        $data = [
            'id_keanggotaan'        => $this->input->post('keanggotaan'),
            'id_jabatan_fraksi'     => $this->input->post('id_jabatan_fraksi'),
            'id_jabatan_3'          => $this->input->post('id_jabatan_3'),
            'id_jabatan_lama'       => $this->input->post('id_jabatan_lama'),
            'perolehan_suara'       => $this->input->post('perolehan_suara'),
            'ri'                    => '1'
        ];

        $this->db->insert('tb_pengurus_fraksi_gerindra', $data);
    }

    public function tambahDataKepengurusanProvinsi()
    {
        $data = [
            'id_keanggotaan'        => $this->input->post('keanggotaan'),
            'id_jabatan_fraksi'     => $this->input->post('id_jabatan_fraksi'),
            'id_jabatan_3'          => $this->input->post('id_jabatan_3'),
            'id_jabatan_lama'       => $this->input->post('id_jabatan_lama'),
            'perolehan_suara'       => $this->input->post('perolehan_suara'),
            'id_prov'               => '33'
        ];

        $this->db->insert('tb_pengurus_fraksi_gerindra', $data);
    }

    public function getDataFraksiByIdFraksi($id_fraksi_gerindra)
    {
        $this->db->where('id_fraksi_gerindra',$id_fraksi_gerindra);
        return $this->db->get('tb_fraksi_gerindra');
    }

    public function editDataProvinsi($id_fraksi_gerindra)
    {
        $data = [
            'nama_fraksi'   => $this->input->post('nama_fraksi'),
            'alamat'        => $this->input->post('alamat'),
            'no_telp'       => $this->input->post('no_telp'),
            'tenaga_ahli'   => $this->input->post('tenaga_ahli'),
        ];  

        $this->db->where('id_fraksi_gerindra', $id_fraksi_gerindra);
        $this->db->update('tb_fraksi_gerindra', $data);
    }

    public function editDataRi($id_fraksi_gerindra)
    {
        $data = [
            'nama_fraksi'   => $this->input->post('nama_fraksi'),
            'alamat'        => $this->input->post('alamat'),
            'no_telp'       => $this->input->post('no_telp'),
            'tenaga_ahli'   => $this->input->post('tenaga_ahli'),
        ];  

        $this->db->where('id_fraksi_gerindra', $id_fraksi_gerindra);
        $this->db->update('tb_fraksi_gerindra', $data);
    }

    public function editDataKabupaten($id_fraksi_gerindra)
    {
        $data = [
            'nama_fraksi'   => $this->input->post('nama_fraksi'),
            'alamat'        => $this->input->post('alamat'),
            'no_telp'       => $this->input->post('no_telp'),
            'tenaga_ahli'   => $this->input->post('tenaga_ahli'),
        ];  

        $this->db->where('id_fraksi_gerindra', $id_fraksi_gerindra);
        $this->db->update('tb_fraksi_gerindra', $data);
    }

    public function getDataKepengurusanFraksiByIdFraksi($id_pengurus_fraksi_gerindra)
    {
        $q = $this->db->query("SELECT tb_pengurus_fraksi_gerindra.*, tb_keanggotaan.*, tb_jabatan_fraksi.*, tb_jabatan_3.*, tb_jabatan_lama.*
                                FROM tb_pengurus_fraksi_gerindra
                                JOIN tb_keanggotaan ON tb_pengurus_fraksi_gerindra.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                                JOIN tb_jabatan_fraksi ON tb_pengurus_fraksi_gerindra.id_jabatan_fraksi = tb_jabatan_fraksi.id_jabatan_fraksi
                                JOIN tb_jabatan_3 ON tb_pengurus_fraksi_gerindra.id_jabatan_3 = tb_jabatan_3.id_jabatan_3 
                                JOIN tb_jabatan_lama ON tb_pengurus_fraksi_gerindra.id_jabatan_lama = tb_jabatan_lama.id_jabatan_lama 
                                WHERE tb_pengurus_fraksi_gerindra.id_pengurus_fraksi_gerindra = '$id_pengurus_fraksi_gerindra'
                                ");
        return $q;
    }

    public function editKepengurusanProvinsi($id_pengurus_fraksi_gerindra)
    {
        $data = [
            'id_jabatan_fraksi'     => $this->input->post('id_jabatan_fraksi'),
            'id_jabatan_3'          => $this->input->post('id_jabatan_3'),
            'id_jabatan_lama'       => $this->input->post('id_jabatan_lama'),
            'perolehan_suara'       => $this->input->post('perolehan_suara'),
        ];

        $this->db->where('id_pengurus_fraksi_gerindra', $id_pengurus_fraksi_gerindra);
        $this->db->update('tb_pengurus_fraksi_gerindra', $data);
    }

    public function editKepengurusanRi($id_pengurus_fraksi_gerindra)
    {
        $data = [
            'id_jabatan_fraksi'     => $this->input->post('id_jabatan_fraksi'),
            'id_jabatan_3'          => $this->input->post('id_jabatan_3'),
            'id_jabatan_lama'       => $this->input->post('id_jabatan_lama'),
            'perolehan_suara'       => $this->input->post('perolehan_suara'),
        ];

        $this->db->where('id_pengurus_fraksi_gerindra', $id_pengurus_fraksi_gerindra);
        $this->db->update('tb_pengurus_fraksi_gerindra', $data);
    }

    public function editKepengurusanKabupaten($id_pengurus_fraksi_gerindra)
    {
        $data = [
            'id_jabatan_fraksi'     => $this->input->post('id_jabatan_fraksi'),
            'id_jabatan_3'          => $this->input->post('id_jabatan_3'),
            'id_jabatan_lama'       => $this->input->post('id_jabatan_lama'),
            'perolehan_suara'       => $this->input->post('perolehan_suara'),
        ];

        $this->db->where('id_pengurus_fraksi_gerindra', $id_pengurus_fraksi_gerindra);
        $this->db->update('tb_pengurus_fraksi_gerindra', $data);
    }

    public function getDataPengurusByIdKab($id_kab)
    {
        $q = $this->db->query("SELECT tb_fraksi_gerindra.*, wilayah_kab.* 
                                FROM tb_fraksi_gerindra
                                JOIN wilayah_kab ON tb_fraksi_gerindra.id_kab = wilayah_kab.id_kab 
                                WHERE tb_fraksi_gerindra.id_kab = '$id_kab'
                                ");
        return $q;
    }

    public function getDataWilayahKab($id_kab)
    {
        $this->db->where('id_kab', $id_kab);
        return $this->db->get('wilayah_kab');
    }

    public function tambahPengurusKabupaten()
    {
        $data = [
            'nama_fraksi'           => $this->input->post('nama_fraksi'),
            'alamat'                => $this->input->post('alamat'),
            'no_telp'               => $this->input->post('no_telp'),
            'tenaga_ahli'           => $this->input->post('tenaga_ahli'),
            'id_kab'                => $this->input->post('id_kab'),
        ];

        $this->db->insert('tb_fraksi_gerindra',$data);
    }

    public function tambahDataKepengurusanKabupaten()
    {
        $id_fraksi_gerindra = $this->session->userdata('id_fraksi_gerindra');

        $data = [
            'id_keanggotaan'        => $this->input->post('keanggotaan'),
            'id_jabatan_fraksi'     => $this->input->post('id_jabatan_fraksi'),
            'id_jabatan_3'          => $this->input->post('id_jabatan_3'),
            'id_jabatan_lama'       => $this->input->post('id_jabatan_lama'),
            'id_kab'                => $this->input->post('id_kab'),
            'id_fraksi_gerindra'    => $id_fraksi_gerindra,
            'perolehan_suara'       => $this->input->post('perolehan_suara'),
        ];

        $this->db->insert('tb_pengurus_fraksi_gerindra', $data);
    }

}