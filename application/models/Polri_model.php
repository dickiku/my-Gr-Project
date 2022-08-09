<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Polri_model extends CI_Model{

    public function getDataPolriProvinsi()
    {
        $this->db->where('id_prov','33');
        return $this->db->get('tb_polri');
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

        $this->db->insert('tb_polri',$data);
    }

    public function getDataPolriById($id_polri)
    {
        $this->db->where('id_polri', $id_polri);
        return $this->db->get('tb_polri');
    }

    public function editPolriProvinsi($id_polri)
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'jabatan'      => $this->input->post('jabatan'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
        ];

        $this->db->where('id_polri', $id_polri);
        $this->db->update('tb_polri', $data);
    }

    public function hapusPolriProvinsi($id_polri)
    {
        $this->db->where('id_polri', $id_polri);
        $this->db->delete('tb_polri');
    }

    //------------------------------

    public function getDataWilayahByIdKab($id_kab)
    {
        $this->db->where('id_kab', $id_kab);
        return $this->db->get('wilayah_kab');
    }

    public function getDataPolriByIdKab($id_kab)
    {
        $this->db->where('id_kab', $id_kab);
        return $this->db->get('tb_polri');
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

        $this->db->insert('tb_polri',$data);
    }

    public function editPolriKabupaten($id_polri)
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'jabatan'      => $this->input->post('jabatan'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
        ];

        $this->db->where('id_polri', $id_polri);
        $this->db->update('tb_polri', $data);
    }

    public function hapusPolriKabupaten($id_polri)
    {
        $this->db->where('id_polri', $id_polri);
        $this->db->delete('tb_polri');
    }

    //------------------------------

    public function getDataWilayahByIdKec($id_kec)
    {
        $this->db->where('id_kec', $id_kec);
        return $this->db->get('wilayah_kec');
    }

    public function getDataPolriByIdKec($id_kec)
    {
        $this->db->where('id_kec', $id_kec);
        return $this->db->get('tb_polri');
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

        $this->db->insert('tb_polri',$data);
    }

    public function editPolriKecamatan($id_polri)
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'jabatan'      => $this->input->post('jabatan'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
        ];

        $this->db->where('id_polri', $id_polri);
        $this->db->update('tb_polri', $data);
    }

    public function hapusPolriKecamatan($id_polri)
    {
        $this->db->where('id_polri', $id_polri);
        $this->db->delete('tb_polri');
    }

    //-----------------------------
    public function getDataWilayahByIdDesa($id_desa)
    {
        $this->db->where('id_desa', $id_desa);
        return $this->db->get('wilayah_desa');
    }

    public function getDataPolriByIdDesa($id_desa)
    {
        $this->db->where('id_desa', $id_desa);
        return $this->db->get('tb_polri');
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

        $this->db->insert('tb_polri',$data);
    }

    public function editPolriDesa($id_polri)
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'jabatan'      => $this->input->post('jabatan'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
        ];

        $this->db->where('id_polri', $id_polri);
        $this->db->update('tb_polri', $data);
    }

    public function hapusPolriDesa($id_polri)
    {
        $this->db->where('id_polri', $id_polri);
        $this->db->delete('tb_polri');
    }

}