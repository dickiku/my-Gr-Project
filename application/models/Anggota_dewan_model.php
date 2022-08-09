<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anggota_dewan_model extends CI_Model{

    // public function getDataDPRRIperiode($id_periode)
    // {
    //     $q = $this->db->where("id_role",'1');
    //     $q = $this->db->where("id_periode",$id_periode);

    //     return $this->db->from('tb_anggota_dewan')
    //         ->join('tb_dapil_ri', 'tb_anggota_dewan.id_dapil = tb_dapil_ri.id_dapil_ri')
    //         ->join('tb_jabatan_3', 'tb_anggota_dewan.jabatan = tb_jabatan_3.id_jabatan_3')
    //         ->get();
    // }

    public function getDataDPRRIperiode($id_periode)
    {
        $q = $this->db->where("id_role",'1');
        $q = $this->db->where("id_periode",$id_periode);

        return $this->db->from('tb_anggota_dewan')
            ->join('tb_dapil_ri', 'tb_anggota_dewan.id_dapil = tb_dapil_ri.id_dapil_ri')
            ->get();
    }

    // public function getDataDPRDProv($id_periode)
    // {
    //     $q = $this->db->query("SELECT tb_anggota_dewan.*, tb_keanggotaan.*, tb_dapil_prov.*, tb_jabatan_3.*
    //                             FROM tb_anggota_dewan
    //                             JOIN tb_keanggotaan ON tb_anggota_dewan.id_keanggotaan = tb_keanggotaan.id_keanggotaan
    //                             JOIN tb_dapil_prov ON tb_anggota_dewan.id_dapil = tb_dapil_prov.id_dapil_prov
    //                             JOIN tb_jabatan_3 ON tb_anggota_dewan.jabatan = tb_jabatan_3.id_jabatan_3
    //                             WHERE id_role = '2'  and id_periode = '$id_periode'");

    //     return $q;    
    // }

    public function getDataDPRDProv($id_periode)
    {
        $q = $this->db->query("SELECT tb_anggota_dewan.*, tb_dapil_prov.*
                                FROM tb_anggota_dewan
                                JOIN tb_dapil_prov ON tb_anggota_dewan.id_dapil = tb_dapil_prov.id_dapil_prov
                                WHERE id_role = '2'  and id_periode = '$id_periode'");

        return $q;    
    }

    // public function getDataDPRDKab($id_periode,$id_kab)
    // {
    //     $q = $this->db->query("SELECT tb_anggota_dewan.*, tb_keanggotaan.*, tb_dapil_kab.*, tb_jabatan_3.*
    //                             FROM tb_anggota_dewan
    //                             JOIN tb_keanggotaan ON tb_anggota_dewan.id_keanggotaan = tb_keanggotaan.id_keanggotaan
    //                             JOIN tb_dapil_kab ON tb_anggota_dewan.id_dapil = tb_dapil_kab.id_dapil_kab
    //                             JOIN tb_jabatan_3 ON tb_anggota_dewan.jabatan = tb_jabatan_3.id_jabatan_3
    //                             WHERE tb_anggota_dewan.id_role = '3'  and tb_anggota_dewan.id_periode = '$id_periode' and tb_anggota_dewan.id_kab = '$id_kab'");

    //     return $q;
    // }

    public function getDataDPRDKab($id_periode,$id_kab)
    {
        $q = $this->db->query("SELECT tb_anggota_dewan.*, tb_dapil_kab.*
                                FROM tb_anggota_dewan
                                JOIN tb_dapil_kab ON tb_anggota_dewan.id_dapil = tb_dapil_kab.id_dapil_kab
                                WHERE tb_anggota_dewan.id_role = '3'  and tb_anggota_dewan.id_periode = '$id_periode' and tb_anggota_dewan.id_kab = '$id_kab'");

        return $q;
    }

    public function perode()
    {
        return $this->db->get('tb_periode_pemilu');
    }

    public function periodeDetail($id_periode)
    {
        $q = $this->db->where("id_periode_pemilu",$id_periode);

        return $this->db->get('tb_periode_pemilu');
    }

    // public function tambahDprRi()
    // {
    //     $data = [
    //         'nama_dewan'        => $this->input->post('nama'),
    //         'no_hp_dewan'        => $this->input->post('no_hp'),
    //         'id_dapil'          => $this->input->post('dapil'),
    //         'komisi'            => $this->input->post('komisi'),
    //         'jabatan'           => $this->input->post('jabatan'),
    //         'id_role'           => '1',
    //         'id_periode'        => $this->input->post('id_periode')
    //     ];

    //     $this->db->insert('tb_anggota_dewan',$data);
    // }

    public function tambahDprRi()
    {
        $data = [
            'nama_dewan'        => $this->input->post('nama'),
            'no_hp_dewan'       => $this->input->post('no_hp'),
            'id_dapil'          => $this->input->post('dapil'),
            'jenis_kelamin'     => $this->input->post('jenis_kelamin'),
            'partai'            => $this->input->post('partai'),
            'alamat'            => $this->input->post('alamat'),
            'perolehan_suara'   => $this->input->post('perolehan_suara'),
            'id_role'           => '1',
            'id_periode'        => $this->input->post('id_periode')
        ];

        $this->db->insert('tb_anggota_dewan',$data);
    }

    // public function tambahDprdProv()
    // {
    //     $data = [
    //         'id_keanggotaan'    => $this->input->post('keanggotaan'),
    //         'id_dapil'          => $this->input->post('dapil'),
    //         'komisi'            => $this->input->post('komisi'),
    //         'jabatan'           => $this->input->post('jabatan'),
    //         'id_role'           => '2',
    //         'id_periode'        => $this->input->post('id_periode')
    //     ];

    //     $this->db->insert('tb_anggota_dewan',$data);
    // }

    public function tambahDprdProv()
    {
        $data = [
            'nama_dewan'        => $this->input->post('nama'),
            'no_hp_dewan'       => $this->input->post('no_hp'),
            'id_dapil'          => $this->input->post('dapil'),
            'jenis_kelamin'     => $this->input->post('jenis_kelamin'),
            'partai'            => $this->input->post('partai'),
            'alamat'            => $this->input->post('alamat'),
            'perolehan_suara'   => $this->input->post('perolehan_suara'),
            'id_role'           => '2',
            'id_periode'        => $this->input->post('id_periode')
        ];

        $this->db->insert('tb_anggota_dewan',$data);
    }

    // public function tambahDprKab()
    // {
    //     $data = [
    //         'id_keanggotaan'    => $this->input->post('keanggotaan'),
    //         'id_dapil'          => $this->input->post('dapil'),
    //         'komisi'            => $this->input->post('komisi'),
    //         'jabatan'           => $this->input->post('jabatan'),
    //         'id_role'           => '3',
    //         'id_periode'        => $this->input->post('id_periode'),
    //         'id_kab'            => $this->input->post('id_kab'),
    //     ];

    //     $this->db->insert('tb_anggota_dewan',$data);
    // }

    public function tambahDprKab()
    {
        $data = [
            'nama_dewan'        => $this->input->post('nama'),
            'no_hp_dewan'       => $this->input->post('no_hp'),
            'id_dapil'          => $this->input->post('dapil'),
            'jenis_kelamin'     => $this->input->post('jenis_kelamin'),
            'partai'            => $this->input->post('partai'),
            'alamat'            => $this->input->post('alamat'),
            'perolehan_suara'   => $this->input->post('perolehan_suara'),
            'id_role'           => '3',
            'id_periode'        => $this->input->post('id_periode'),
            'id_kab'            => $this->input->post('id_kab'),
        ];

        $this->db->insert('tb_anggota_dewan',$data);
    }

    // public function getDataDPRDKabDetail($id_data)
    // {
    //     $q = $this->db->query("SELECT tb_anggota_dewan.*, tb_keanggotaan.*, tb_dapil_kab.*, tb_jabatan_3.*
    //                             FROM tb_anggota_dewan
    //                             JOIN tb_keanggotaan ON tb_anggota_dewan.id_keanggotaan = tb_keanggotaan.id_keanggotaan
    //                             JOIN tb_dapil_kab ON tb_anggota_dewan.id_dapil = tb_dapil_kab.id_dapil_kab
    //                             JOIN tb_jabatan_3 ON tb_anggota_dewan.jabatan = tb_jabatan_3.id_jabatan_3
    //                             WHERE tb_anggota_dewan.id_anggota_dewan = '$id_data'");

    //     return $q;
    // }

    public function getDataDPRDKabDetail($id_data)
    {
        $q = $this->db->query("SELECT tb_anggota_dewan.*, tb_dapil_kab.*
                                FROM tb_anggota_dewan
                                JOIN tb_dapil_kab ON tb_anggota_dewan.id_dapil = tb_dapil_kab.id_dapil_kab
                                WHERE tb_anggota_dewan.id_anggota_dewan = '$id_data'");

        return $q;
    }

    // public function getDataDPRDProvDetail($id_data)
    // {
    //     $q = $this->db->query("SELECT tb_anggota_dewan.*, tb_keanggotaan.*, tb_dapil_prov.*, tb_jabatan_3.*
    //                             FROM tb_anggota_dewan
    //                             JOIN tb_keanggotaan ON tb_anggota_dewan.id_keanggotaan = tb_keanggotaan.id_keanggotaan
    //                             JOIN tb_dapil_prov ON tb_anggota_dewan.id_dapil = tb_dapil_prov.id_dapil_prov
    //                             JOIN tb_jabatan_3 ON tb_anggota_dewan.jabatan = tb_jabatan_3.id_jabatan_3
    //                             WHERE tb_anggota_dewan.id_anggota_dewan = '$id_data'");

    //     return $q;   
    // }

    public function getDataDPRDProvDetail($id_data)
    {
        $q = $this->db->query("SELECT tb_anggota_dewan.*, tb_dapil_prov.*
                                FROM tb_anggota_dewan
                                JOIN tb_dapil_prov ON tb_anggota_dewan.id_dapil = tb_dapil_prov.id_dapil_prov
                                WHERE tb_anggota_dewan.id_anggota_dewan = '$id_data'");

        return $q;   
    }

    // public function getDataDPRRiDetail($id_data)
    // {
    //     $q = $this->db->where("id_anggota_dewan",$id_data);
    //     $q = $this->db->where("id_role",'1');

    //     return $this->db->from('tb_anggota_dewan')
    //         ->join('tb_dapil_ri', 'tb_anggota_dewan.id_dapil = tb_dapil_ri.id_dapil_ri')
    //         ->join('tb_jabatan_3', 'tb_anggota_dewan.jabatan = tb_jabatan_3.id_jabatan_3')
    //         ->get();
    // }

    public function getDataDPRRiDetail($id_data)
    {
        $q = $this->db->where("id_anggota_dewan",$id_data);
        $q = $this->db->where("id_role",'1');

        return $this->db->from('tb_anggota_dewan')
            ->join('tb_dapil_ri', 'tb_anggota_dewan.id_dapil = tb_dapil_ri.id_dapil_ri')
            ->get();
    }

    // public function editDPRDKab($id_data)
    // {
    //     $data = [
    //         'id_keanggotaan'    => $this->input->post('id_keanggotaan'),
    //         'id_dapil'          => $this->input->post('dapil'),
    //         'komisi'            => $this->input->post('komisi'),
    //         'jabatan'           => $this->input->post('jabatan'),
    //         'id_role'           => '3',
    //         'id_periode'        => $this->input->post('id_periode'),
    //         'id_kab'            => $this->input->post('id_kab')
    //     ];

    //     $this->db->where('id_anggota_dewan',$id_data);
    //     $this->db->update('tb_anggota_dewan',$data);
    // }

    public function editDPRDKab($id_data)
    {
        $data = [
            'nama_dewan'        => $this->input->post('nama'),
            'no_hp_dewan'       => $this->input->post('no_hp'),
            'id_dapil'          => $this->input->post('dapil'),
            'jenis_kelamin'     => $this->input->post('jenis_kelamin'),
            'partai'            => $this->input->post('partai'),
            'alamat'            => $this->input->post('alamat'),
            'perolehan_suara'   => $this->input->post('perolehan_suara'),
            'id_role'           => '3',
            'id_periode'        => $this->input->post('id_periode')
        ];

        $this->db->where('id_anggota_dewan',$id_data);
        $this->db->update('tb_anggota_dewan',$data);
    }

    // public function editDPRDProv($id_data)
    // {
    //     $data = [
    //         'id_keanggotaan'    => $this->input->post('id_keanggotaan'),
    //         'id_dapil'          => $this->input->post('dapil'),
    //         'komisi'            => $this->input->post('komisi'),
    //         'jabatan'           => $this->input->post('jabatan'),
    //         'id_role'           => '2',
    //         'id_periode'        => $this->input->post('id_periode')
    //     ];

    //     $this->db->where('id_anggota_dewan',$id_data);
    //     $this->db->update('tb_anggota_dewan',$data);
    // }

    public function editDPRDProv($id_data)
    {
        $data = [
            'nama_dewan'        => $this->input->post('nama'),
            'no_hp_dewan'       => $this->input->post('no_hp'),
            'id_dapil'          => $this->input->post('dapil'),
            'jenis_kelamin'     => $this->input->post('jenis_kelamin'),
            'partai'            => $this->input->post('partai'),
            'alamat'            => $this->input->post('alamat'),
            'perolehan_suara'   => $this->input->post('perolehan_suara'),
            'id_role'           => '2',
            'id_periode'        => $this->input->post('id_periode')
        ];

        $this->db->where('id_anggota_dewan',$id_data);
        $this->db->update('tb_anggota_dewan',$data);
    }

    // public function editDPRRi($id_data)
    // {
    //     $data = [
    //         'nama_dewan'        => $this->input->post('nama'),
    //         'no_hp_dewan'        => $this->input->post('no_hp'),
    //         'id_dapil'          => $this->input->post('dapil'),
    //         'komisi'            => $this->input->post('komisi'),
    //         'jabatan'           => $this->input->post('jabatan'),
    //         'id_role'           => '1',
    //         'id_periode'        => $this->input->post('id_periode')
    //     ];

    //     $this->db->where('id_anggota_dewan',$id_data);
    //     $this->db->update('tb_anggota_dewan',$data);
    // }

    public function editDPRRi($id_data)
    {
        $data = [
            'nama_dewan'        => $this->input->post('nama'),
            'no_hp_dewan'       => $this->input->post('no_hp'),
            'id_dapil'          => $this->input->post('dapil'),
            'jenis_kelamin'     => $this->input->post('jenis_kelamin'),
            'partai'            => $this->input->post('partai'),
            'alamat'            => $this->input->post('alamat'),
            'perolehan_suara'   => $this->input->post('perolehan_suara'),
            'id_role'           => '1',
            'id_periode'        => $this->input->post('id_periode')
        ];

        $this->db->where('id_anggota_dewan',$id_data);
        $this->db->update('tb_anggota_dewan',$data);
    }

    public function jabatanLain()
    {
        return $this->db->get('tb_jabatan_3');
    }
}