<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Toga_tomas_model extends CI_Model{

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

    public function getDataTogaTomasProvinsi()
    {
        $this->db->where('id_prov','33');
        return $this->db->get('tb_toga_tomas');
    }

    public function getDataWilayahByIdKab($id_kab)
    {
        $this->db->where('id_kab', $id_kab);
        return $this->db->get('wilayah_kab');
    }

    public function getDataWilayahByIdKec($id_kec)
    {
        $this->db->where('id_kec', $id_kec);
        return $this->db->get('wilayah_kec');
    }

    public function getDataWilayahByIdDesa($id_desa)
    {
        $this->db->where('id_desa', $id_desa);
        return $this->db->get('wilayah_desa');
    }

    public function tambahDataProvinsi()
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'ltr_belakang'   => $this->input->post('ltr_belakang'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
            'id_prov'   => '33'
        ];

        $this->db->insert('tb_toga_tomas',$data);
    }

    public function getDataTogaTomasById($id_toga_tomas)
    {
        $this->db->where('id_toga_tomas', $id_toga_tomas);
        return $this->db->get('tb_toga_tomas');
    }

    public function editTogaTomasProvinsi($id_toga_tomas)
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'ltr_belakang'   => $this->input->post('ltr_belakang'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
        ];

        $this->db->where('id_toga_tomas', $id_toga_tomas);
        $this->db->update('tb_toga_tomas', $data);
    }

    public function hapusTogaTomasProvinsi($id_toga_tomas)
    {
        $this->db->where('id_toga_tomas', $id_toga_tomas);
        $this->db->delete('tb_toga_tomas');
    }

    //-----------------------------

    public function getDataTogaTomasByIdKab($id_kab)
    {
        $this->db->where('id_kab', $id_kab);
        return $this->db->get('tb_toga_tomas');
    }
    
    public function tambahDataKabupaten()
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'ltr_belakang'   => $this->input->post('ltr_belakang'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
            'id_kab'    => $this->input->post('id_kab')
        ];

        $this->db->insert('tb_toga_tomas',$data);
    }

    public function editTogaTomasKabupaten($id_toga_tomas)
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'ltr_belakang'   => $this->input->post('ltr_belakang'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
        ];

        $this->db->where('id_toga_tomas', $id_toga_tomas);
        $this->db->update('tb_toga_tomas', $data);
    }

    public function hapusTogaTomasKabupaten($id_toga_tomas)
    {
        $this->db->where('id_toga_tomas', $id_toga_tomas);
        $this->db->delete('tb_toga_tomas');
    }

    //-----------------------------
    public function getDataTogaTomasByIdKec($id_kec)
    {
        $this->db->where('id_kec', $id_kec);
        return $this->db->get('tb_toga_tomas');
    }

    public function tambahDataKecamatan()
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'ltr_belakang'   => $this->input->post('ltr_belakang'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
            'id_kec'    => $this->input->post('id_kec')
        ];

        $this->db->insert('tb_toga_tomas',$data);
    }

    public function editTogaTomasKecamatan($id_toga_tomas)
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'ltr_belakang'   => $this->input->post('ltr_belakang'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
        ];

        $this->db->where('id_toga_tomas', $id_toga_tomas);
        $this->db->update('tb_toga_tomas', $data);
    }

    public function hapusTogaTomasKecamatan($id_toga_tomas)
    {
        $this->db->where('id_toga_tomas', $id_toga_tomas);
        $this->db->delete('tb_toga_tomas');
    }

    //-----------------------------
    public function getDataTogaTomasByIdDesa($id_desa)
    {
        $this->db->where('id_desa', $id_desa);
        return $this->db->get('tb_toga_tomas');
    }

    public function tambahDataDesa()
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'ltr_belakang'   => $this->input->post('ltr_belakang'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
            'id_desa'   => $this->input->post('id_desa')
        ];

        $this->db->insert('tb_toga_tomas',$data);
    }

    public function editTogaTomasDesa($id_toga_tomas)
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'ltr_belakang'   => $this->input->post('ltr_belakang'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
        ];

        $this->db->where('id_toga_tomas', $id_toga_tomas);
        $this->db->update('tb_toga_tomas', $data);
    }

    public function hapusTogaTomasDesa($id_toga_tomas)
    {
        $this->db->where('id_toga_tomas', $id_toga_tomas);
        $this->db->delete('tb_toga_tomas');
    }
}