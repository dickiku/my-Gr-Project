<?php 

class Cagub_model extends CI_Model{

    public function getData()
    {
        $q = $this->db->where("role",'1');

        return $this->db->get('tb_tahun');
    }

    public function tambahData()
    {
        $data = [
            'tahun' => $this->input->post('tahun'),
            'role'  => '1'
        ];

        $this->db->insert('tb_tahun',$data);
    }

    public function getDetailPeriode($id_tahun){
        $this->db->where("id_tahun",$id_tahun);

        return $this->db->get('tb_tahun');
    }

    public function editPeriode($id_tahun)
    {
        $data = [
            'tahun' => $this->input->post('tahun'),
            'role'  => '1'
        ];

        $this->db->where("id_tahun",$id_tahun);
        $this->db->update('tb_tahun',$data);
    }

    // ------------------ Calon Gubernur -------------------
    public function getDataCagub($id_tahun)
    {
        $this->db->where("id_tahun",$id_tahun);

        return $this->db->get('tb_cagub');
    }

    public function tambahCalon()
    {
        $data = [
            'nama_cagub'    => $this->input->post('nama_cagub'),
            'nama_cawagub'  => $this->input->post('nama_cawagub'),
            'id_tahun'      => $this->input->post('id_tahun'),
            'jkcalon'       => $this->input->post('jkcalon'),
            'jkwakil'       => $this->input->post('jkwakil'),
            'partai_pengusung' => $this->input->post('partai_pengusung'),
            'jumlah_kursi'  => $this->input->post('jumlah_kursi')
        ];

        $this->db->insert('tb_cagub',$data);
    }

    public function getDetailCalon($id_cagub)
    {
        $this->db->where("id_cagub",$id_cagub);

        return $this->db->from('tb_cagub')
            ->join('tb_tahun', 'tb_cagub.id_tahun = tb_tahun.id_tahun')
            ->get();
    }

    public function editCalon($id_cagub)
    {
        $data = [
            'nama_cagub'    => $this->input->post('nama_cagub'),
            'nama_cawagub'  => $this->input->post('nama_cawagub'),
            'id_tahun'      => $this->input->post('id_tahun'),
            'jkcalon'       => $this->input->post('jkcalon'),
            'jkwakil'       => $this->input->post('jkwakil'),
            'partai_pengusung' => $this->input->post('partai_pengusung'),
            'jumlah_kursi'  => $this->input->post('jumlah_kursi')
        ];

        $this->db->where("id_cagub",$id_cagub);
        $this->db->update('tb_cagub',$data);
    }
}
?>