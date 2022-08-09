<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Relawan_model extends CI_Model{

    public function getDataRelawanProvinsi()
    {
        $this->db->where('id_prov','33');
        return $this->db->get('tb_relawan');
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
            'organisasi'      => $this->input->post('organisasi'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
            'id_prov'   => '33'
        ];

        $this->db->insert('tb_relawan',$data);
    }

    public function getDataRelawanById($id_relawan)
    {
        $this->db->where('id_relawan', $id_relawan);
        return $this->db->get('tb_relawan');
    }

    public function editRelawanProvinsi($id_relawan)
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'organisasi'      => $this->input->post('organisasi'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
        ];

        $this->db->where('id_relawan', $id_relawan);
        $this->db->update('tb_relawan', $data);
    }

    public function hapusRelawanProvinsi($id_relawan)
    {
        $this->db->where('id_relawan', $id_relawan);
        $this->db->delete('tb_relawan');
    }

    //------------------------------

    public function getDataWilayahByIdKab($id_kab)
    {
        $this->db->where('id_kab', $id_kab);
        return $this->db->get('wilayah_kab');
    }

    public function getDataRelawanByIdKab($id_kab)
    {
        $this->db->where('id_kab', $id_kab);
        return $this->db->get('tb_relawan');
    }
    
    public function tambahDataKabupaten()
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'organisasi'      => $this->input->post('organisasi'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
            'id_kab'    => $this->input->post('id_kab')
        ];

        $this->db->insert('tb_relawan',$data);
    }

    public function editRelawanKabupaten($id_relawan)
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'organisasi'      => $this->input->post('organisasi'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
        ];

        $this->db->where('id_relawan', $id_relawan);
        $this->db->update('tb_relawan', $data);
    }

    public function hapusRelawanKabupaten($id_relawan)
    {
        $this->db->where('id_relawan', $id_relawan);
        $this->db->delete('tb_relawan');
    }

    //------------------------------

    public function getDataWilayahByIdKec($id_kec)
    {
        $this->db->where('id_kec', $id_kec);
        return $this->db->get('wilayah_kec');
    }

    public function getDataRelawanByIdKec($id_kec)
    {
        $this->db->where('id_kec', $id_kec);
        return $this->db->get('tb_relawan');
    }
    
    public function tambahDataKecamatan()
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'organisasi'      => $this->input->post('organisasi'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
            'id_kec'    => $this->input->post('id_kec')
        ];

        $this->db->insert('tb_relawan',$data);
    }

    public function editRelawanKecamatan($id_relawan)
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'organisasi'      => $this->input->post('organisasi'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
        ];

        $this->db->where('id_relawan', $id_relawan);
        $this->db->update('tb_relawan', $data);
    }

    public function hapusRelawanKecamatan($id_relawan)
    {
        $this->db->where('id_relawan', $id_relawan);
        $this->db->delete('tb_relawan');
    }

    //-----------------------------
    public function getDataWilayahByIdDesa($id_desa)
    {
        $this->db->where('id_desa', $id_desa);
        return $this->db->get('wilayah_desa');
    }

    public function getDataRelawanByIdDesa($id_desa)
    {
        $this->db->where('id_desa', $id_desa);
        return $this->db->get('tb_relawan');
    }

    public function tambahDataDesa()
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'organisasi'      => $this->input->post('organisasi'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
            'id_desa'   => $this->input->post('id_desa')
        ];

        $this->db->insert('tb_relawan',$data);
    }

    public function editRelawanDesa($id_relawan)
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'organisasi'      => $this->input->post('organisasi'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
        ];

        $this->db->where('id_relawan', $id_relawan);
        $this->db->update('tb_relawan', $data);
    }

    public function hapusRelawanDesa($id_relawan)
    {
        $this->db->where('id_relawan', $id_relawan);
        $this->db->delete('tb_relawan');
    }

}