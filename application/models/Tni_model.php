<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Tni_model extends CI_Model{

    public function getDataTniProvinsi()
    {
        $this->db->where('id_prov','33');
        return $this->db->get('tb_tni');
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

        $this->db->insert('tb_tni',$data);
    }

    public function getDataTniById($id_tni)
    {
        $this->db->where('id_tni', $id_tni);
        return $this->db->get('tb_tni');
    }

    public function editTniProvinsi($id_tni)
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'jabatan'      => $this->input->post('jabatan'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
        ];

        $this->db->where('id_tni', $id_tni);
        $this->db->update('tb_tni', $data);
    }

    public function hapusTniProvinsi($id_tni)
    {
        $this->db->where('id_tni', $id_tni);
        $this->db->delete('tb_tni');
    }

    //------------------------------

    public function getDataWilayahByIdKab($id_kab)
    {
        $this->db->where('id_kab', $id_kab);
        return $this->db->get('wilayah_kab');
    }

    public function getDataTniByIdKab($id_kab)
    {
        $this->db->where('id_kab', $id_kab);
        return $this->db->get('tb_tni');
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

        $this->db->insert('tb_tni',$data);
    }

    public function editTniKabupaten($id_tni)
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'jabatan'      => $this->input->post('jabatan'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
        ];

        $this->db->where('id_tni', $id_tni);
        $this->db->update('tb_tni', $data);
    }

    public function hapusTniKabupaten($id_tni)
    {
        $this->db->where('id_tni', $id_tni);
        $this->db->delete('tb_tni');
    }

    //------------------------------

    public function getDataWilayahByIdKec($id_kec)
    {
        $this->db->where('id_kec', $id_kec);
        return $this->db->get('wilayah_kec');
    }

    public function getDataTniByIdKec($id_kec)
    {
        $this->db->where('id_kec', $id_kec);
        return $this->db->get('tb_tni');
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

        $this->db->insert('tb_tni',$data);
    }

    public function editTniKecamatan($id_tni)
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'jabatan'      => $this->input->post('jabatan'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
        ];

        $this->db->where('id_tni', $id_tni);
        $this->db->update('tb_tni', $data);
    }

    public function hapusTniKecamatan($id_tni)
    {
        $this->db->where('id_tni', $id_tni);
        $this->db->delete('tb_tni');
    }

    //-----------------------------
    public function getDataWilayahByIdDesa($id_desa)
    {
        $this->db->where('id_desa', $id_desa);
        return $this->db->get('wilayah_desa');
    }

    public function getDataTniByIdDesa($id_desa)
    {
        $this->db->where('id_desa', $id_desa);
        return $this->db->get('tb_tni');
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

        $this->db->insert('tb_tni',$data);
    }

    public function editTniDesa($id_tni)
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'jabatan'      => $this->input->post('jabatan'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
        ];

        $this->db->where('id_tni', $id_tni);
        $this->db->update('tb_tni', $data);
    }

    public function hapusTniDesa($id_tni)
    {
        $this->db->where('id_tni', $id_tni);
        $this->db->delete('tb_tni');
    }

}