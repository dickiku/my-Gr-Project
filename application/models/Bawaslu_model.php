<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Bawaslu_model extends CI_Model{

    public function getDataBawasluProvinsi()
    {
        $this->db->where('id_prov','33');
        return $this->db->get('tb_bawaslu');
    }

    public function getDataKecamatanByIdKab($id_kab)
    {
        $this->db->where('id_kab',$id_kab);
        return $this->db->get('wilayah_kec');
    }

    public function getDataDesaByIdKab($id_kec)
    {
        $this->db->where('id_kec',$id_kec);
        return $this->db->get('wilayah_desa');
    }

    public function tambahDataProvinsi()
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'jabatan'      => $this->input->post('jabatan'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
            'id_prov'   => '33'
        ];

        $this->db->insert('tb_bawaslu',$data);
    }

    public function getDataBawasluById($id_bawaslu)
    {
        $this->db->where('id_bawaslu', $id_bawaslu);
        return $this->db->get('tb_bawaslu');
    }

    public function editBawasluProvinsi($id_bawaslu)
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'jabatan'      => $this->input->post('jabatan'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
        ];

        $this->db->where('id_bawaslu', $id_bawaslu);
        $this->db->update('tb_bawaslu', $data);
    }

    public function hapusBawasluProvinsi($id_bawaslu)
    {
        $this->db->where('id_bawaslu', $id_bawaslu);
        $this->db->delete('tb_bawaslu');
    }

    //------------------------------

    public function getDataWilayahByIdKab($id_kab)
    {
        $this->db->where('id_kab', $id_kab);
        return $this->db->get('wilayah_kab');
    }

    public function getDataBawasluByIdKab($id_kab)
    {
        $this->db->where('id_kab', $id_kab);
        return $this->db->get('tb_bawaslu');
    }
    
    public function tambahDataKabupaten()
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'jabatan'      => $this->input->post('jabatan'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
            'id_kab'    => $this->input->post('id_kab')
        ];

        $this->db->insert('tb_bawaslu',$data);
    }

    public function editBawasluKabupaten($id_bawaslu)
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'jabatan'      => $this->input->post('jabatan'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
        ];

        $this->db->where('id_bawaslu', $id_bawaslu);
        $this->db->update('tb_bawaslu', $data);
    }

    public function hapusBawasluKabupaten($id_bawaslu)
    {
        $this->db->where('id_bawaslu', $id_bawaslu);
        $this->db->delete('tb_bawaslu');
    }

    //------------------------------

    public function getDataWilayahByIdKec($id_kec)
    {
        $this->db->where('id_kec', $id_kec);
        return $this->db->get('wilayah_kec');
    }

    public function getDataBawasluByIdKec($id_kec)
    {
        $this->db->where('id_kec', $id_kec);
        return $this->db->get('tb_bawaslu');
    }
    
    public function tambahDataKecamatan()
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'jabatan'      => $this->input->post('jabatan'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
            'id_kec'    => $this->input->post('id_kec')
        ];

        $this->db->insert('tb_bawaslu',$data);
    }

    public function editBawasluKecamatan($id_bawaslu)
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'jabatan'      => $this->input->post('jabatan'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
        ];

        $this->db->where('id_bawaslu', $id_bawaslu);
        $this->db->update('tb_bawaslu', $data);
    }

    public function hapusBawasluKecamatan($id_bawaslu)
    {
        $this->db->where('id_bawaslu', $id_bawaslu);
        $this->db->delete('tb_bawaslu');
    }

    //-----------------------------
    public function getDataWilayahByIdDesa($id_desa)
    {
        $this->db->where('id_desa', $id_desa);
        return $this->db->get('wilayah_desa');
    }

    public function getDataBawasluByIdDesa($id_desa)
    {
        $this->db->where('id_desa', $id_desa);
        return $this->db->get('tb_bawaslu');
    }

    public function tambahDataDesa()
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'jabatan'      => $this->input->post('jabatan'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
            'id_desa'   => $this->input->post('id_desa')
        ];

        $this->db->insert('tb_bawaslu',$data);
    }

    public function editBawasluDesa($id_bawaslu)
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'jabatan'      => $this->input->post('jabatan'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
        ];

        $this->db->where('id_bawaslu', $id_bawaslu);
        $this->db->update('tb_bawaslu', $data);
    }

    public function hapusBawasluDesa($id_bawaslu)
    {
        $this->db->where('id_bawaslu', $id_bawaslu);
        $this->db->delete('tb_bawaslu');
    }
}