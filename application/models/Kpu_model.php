<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Kpu_model extends CI_Model{

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

    public function getDataKpuProvinsi()
    {
        $this->db->where('id_prov','33');
        return $this->db->get('tb_kpu');
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

        $this->db->insert('tb_kpu',$data);
    }

    public function getDataKpuById($id_kpu)
    {
        $this->db->where('id_kpu', $id_kpu);
        return $this->db->get('tb_kpu');
    }

    public function editKpuProvinsi($id_kpu)
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'jabatan'      => $this->input->post('jabatan'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
        ];

        $this->db->where('id_kpu', $id_kpu);
        $this->db->update('tb_kpu', $data);
    }

    public function hapusKpuProvinsi($id_kpu)
    {
        $this->db->where('id_kpu', $id_kpu);
        $this->db->delete('tb_kpu');
    }

    //------------------------

    public function getDataWilayahByIdKab($id_kab)
    {
        $this->db->where('id_kab', $id_kab);
        return $this->db->get('wilayah_kab');
    }

    public function getDataKpuByIdKab($id_kab)
    {
        $this->db->where('id_kab', $id_kab);
        return $this->db->get('tb_kpu');
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

        $this->db->insert('tb_kpu',$data);
    }

    public function editKpuKabupaten($id_kpu)
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'jabatan'      => $this->input->post('jabatan'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
        ];

        $this->db->where('id_kpu', $id_kpu);
        $this->db->update('tb_kpu', $data);
    }

    public function hapusKpuKabupaten($id_kpu)
    {
        $this->db->where('id_kpu', $id_kpu);
        $this->db->delete('tb_kpu');
    }

    //------------------------

    public function getDataWilayahByIdKec($id_kec)
    {
        $this->db->where('id_kec', $id_kec);
        return $this->db->get('wilayah_kec');
    }

    public function getDataKpuByIdKec($id_kec)
    {
        $this->db->where('id_kec', $id_kec);
        return $this->db->get('tb_kpu');
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

        $this->db->insert('tb_kpu',$data);
    }

    public function editKpuKecamatan($id_kpu)
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'jabatan'      => $this->input->post('jabatan'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
        ];

        $this->db->where('id_kpu', $id_kpu);
        $this->db->update('tb_kpu', $data);
    }

    public function hapusKpuKecamatan($id_kpu)
    {
        $this->db->where('id_kpu', $id_kpu);
        $this->db->delete('tb_kpu');
    }

    //------------------------

    public function getDataWilayahByIdDesa($id_desa)
    {
        $this->db->where('id_desa', $id_desa);
        return $this->db->get('wilayah_desa');
    }

    public function getDataKpuByIdDesa($id_desa)
    {
        $this->db->where('id_desa', $id_desa);
        return $this->db->get('tb_kpu');
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

        $this->db->insert('tb_kpu',$data);
    }

    public function editKpuDesa($id_kpu)
    {
        $data = [
            'nama'      => $this->input->post('nama'),
            'jabatan'      => $this->input->post('jabatan'),
            'no_telp'   => $this->input->post('no_telp'),
            'alamat'    => $this->input->post('alamat'),
        ];

        $this->db->where('id_kpu', $id_kpu);
        $this->db->update('tb_kpu', $data);
    }

    public function hapusKpuDesa($id_kpu)
    {
        $this->db->where('id_kpu', $id_kpu);
        $this->db->delete('tb_kpu');
    }
}