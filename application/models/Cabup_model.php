<?php

class Cabup_model extends CI_Model{

    public function getDataWilayahByIdKab($id_kab)
    {
        $this->db->where("id_kab", $id_kab);

        return $this->db->get('wilayah_kab');
    }

    public function getData($id_kab)
    {
        $q = $this->db->where("role",'2 ');
        $q = $this->db->where("id_kab",$id_kab);

        return $this->db->get('tb_tahun');
    }

    public function tambahData()
    {
        $data = [
            'tahun'     => $this->input->post('tahun'),
            'id_kab'    => $this->input->post('id_kab'),
            'role'      => '2'
        ];

        $this->db->insert('tb_tahun',$data);
    }

    public function getDetailPeriode($id_tahun){
        $this->db->where("id_tahun",$id_tahun);

        return $this->db->from('tb_tahun')
            ->join('wilayah_kab', 'tb_tahun.id_kab = wilayah_kab.id_kab')
            ->get();
    }

    public function editPeriode($id_tahun)
    {
        $data = [
            'tahun'     => $this->input->post('tahun'),
            'id_kab'    => $this->input->post('id_kab'),
            'role'      => '2'
        ];

        $this->db->where("id_tahun",$id_tahun);
        $this->db->update('tb_tahun',$data);
    }

    // ----------------- Calon Bupati -----------------
    public function getDataCalon($id_tahun)
    {
        $this->db->where("id_tahun",$id_tahun);

        return $this->db->get('tb_cabup');
    }

    public function tambahCalon()
    {
        $data = [
            'nama_cabup'    => $this->input->post('nama_cabup'),
            'nama_cawabup'  => $this->input->post('nama_cawabup'),
            'id_tahun'      => $this->input->post('id_tahun'),
            'id_kab'        => $this->input->post('id_kab'),
            'jkcalon'       => $this->input->post('jkcalon'),
            'jkwakil'       => $this->input->post('jkwakil'),
            'partai_pengusung' => $this->input->post('partai_pengusung'),
            'jumlah_kursi'  => $this->input->post('jumlah_kursi')
        ];

        $this->db->insert('tb_cabup',$data);
    }

    public function getDetailCalon($id_cabup)
    {
        $this->db->where("id_cabup",$id_cabup);

        return $this->db->from('tb_cabup')
            ->join('wilayah_kab', 'tb_cabup.id_kab = wilayah_kab.id_kab')
            ->join('tb_tahun', 'tb_cabup.id_tahun = tb_tahun.id_tahun')
            ->get();
    }

    public function editCalon($id_cabup)
    {
        $data = [
            'nama_cabup'    => $this->input->post('nama_cabup'),
            'nama_cawabup'  => $this->input->post('nama_cawabup'),
            'id_tahun'      => $this->input->post('id_tahun'),
            'id_kab'        => $this->input->post('id_kab'),
            'jkcalon'       => $this->input->post('jkcalon'),
            'jkwakil'       => $this->input->post('jkwakil'),
            'partai_pengusung' => $this->input->post('partai_pengusung'),
            'jumlah_kursi'  => $this->input->post('jumlah_kursi')
        ];

        $this->db->where("id_cabup",$id_cabup);
        $this->db->update('tb_cabup',$data);
    }
}

?>