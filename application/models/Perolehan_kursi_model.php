<?php

class Perolehan_kursi_model extends CI_Model{

    public function getDataPeriode()
    {
        return $this->db->get('tb_periode_pemilu');
    }

    public function getDataWilayahKabupaten()
    {
        $this->db->where('id_prov','33');
        return $this->db->get('wilayah_kab');
    }

    public function getDataPerolehanKursiByIdKabPeriode($id_periode,$id_kab)
    {
        $this->db->where('id_periode_pemilu',$id_periode);
        $this->db->where('id_kab', $id_kab);
        return $this->db->get('tb_perolehan_kursi');
    }

    public function getDataWilayahKabupatenById($id_kab)
    {
        $this->db->where('id_kab',$id_kab);
        return $this->db->get('wilayah_kab');
    }

    public function getDataPeriodeById($id_periode)
    {
        $this->db->where('id_periode_pemilu',$id_periode);
        return $this->db->get('tb_periode_pemilu');
    }

    public function tambahPerolehanKursi()
    {
        $data = [
            'nama_partai'       => $this->input->post('nama_partai'),
            'jumlah_kursi'      => $this->input->post('jumlah_kursi'),
            'id_periode_pemilu' => $this->input->post('id_periode'),
            'id_kab'            => $this->input->post('id_kab'),
        ];  

        $this->db->insert('tb_perolehan_kursi',$data);
    }

    public function getDataPerolehanKursiById($id_perolehan_kursi)
    {
        $this->db->where('id_perolehan_kursi',$id_perolehan_kursi);
        return $this->db->get('tb_perolehan_kursi');
    }

    public function editPerolehanKursi($id_perolehan_kursi)
    {
        $data = [
            'nama_partai'       => $this->input->post('nama_partai'),
            'jumlah_kursi'      => $this->input->post('jumlah_kursi'),
        ];

        $this->db->where('id_perolehan_kursi',$id_perolehan_kursi);
        $this->db->update('tb_perolehan_kursi',$data);
    }
}