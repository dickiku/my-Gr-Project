<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Pileg_model extends CI_Model{

    public function getDataPeriode()
    {
        return $this->db->get('tb_periode_pemilu');
    }

    public function getDataWilayahKabJateng()
    {
        $this->db->where('id_prov','33');
        return $this->db->get('wilayah_kab');
    }

    public function getDataPeriodeById($id_periode)
    {
        $this->db->where('id_periode_pemilu',$id_periode);
        return $this->db->get('tb_periode_pemilu');
    }

    public function getDataWilayahKabById($id_kab)
    {
        $this->db->where('id_kab', $id_kab);
        return $this->db->get('wilayah_kab');
    }

    public function getDataWilayahKecById($id_kec)
    {
        $this->db->where('id_kec', $id_kec);
        return $this->db->get('wilayah_kec');
    }

    public function getDataWilayahDesaById($id_desa)
    {
        $this->db->where('id_desa', $id_desa);
        return $this->db->get('wilayah_desa');
    }

    public function getDataJumlahPemilihPilegKabupatenByPeriodeRole($id_role,$id_periode,$id_kab)
    {
        $this->db->where('id_periode',$id_periode);
        $this->db->where('id_role',$id_role);
        $this->db->where('id_kab',$id_kab);
        return $this->db->get('tb_jumlah_pemilih_pileg');
    }

    public function getDataJumlahPemilihPilegKecamatanByPeriodeRole($id_role,$id_kec,$id_periode)
    {
        $this->db->where('id_periode',$id_periode);
        $this->db->where('id_role',$id_role);
        $this->db->where('id_kec',$id_kec);
        return $this->db->get('tb_jumlah_pemilih_pileg');
    }

    public function getDataJumlahPemilihPilegDesaByPeriodeRole($id_role,$id_desa,$id_periode)
    {
        $this->db->where('id_periode',$id_periode);
        $this->db->where('id_role',$id_role);
        $this->db->where('id_desa',$id_desa);
        return $this->db->get('tb_jumlah_pemilih_pileg');
    }

    public function tambahDptKabupatenRi()
    {
        $data = [
            'id_periode'            => $this->input->post('id_periode_pemilu'),    
            'id_role'               => 1,
            'id_kab'                => $this->input->post('id_kab'),    
            'dpt'                   => $this->input->post('dpt'),
            'pengguna_hak_pilih'    => $this->input->post('pengguna_hak_pilih'),
        ];

        $this->db->insert('tb_jumlah_pemilih_pileg',$data);
    }

    public function tambahDptKabupatenProv()
    {
        $data = [
            'id_periode'            => $this->input->post('id_periode_pemilu'),    
            'id_role'               => 2,
            'id_kab'                => $this->input->post('id_kab'),    
            'dpt'                   => $this->input->post('dpt'),
            'pengguna_hak_pilih'    => $this->input->post('pengguna_hak_pilih'),
        ];

        $this->db->insert('tb_jumlah_pemilih_pileg',$data);
    }

    public function tambahDptKabupatenKab()
    {
        $data = [
            'id_periode'            => $this->input->post('id_periode_pemilu'),    
            'id_role'               => 3,
            'id_kab'                => $this->input->post('id_kab'),    
            'dpt'                   => $this->input->post('dpt'),
            'pengguna_hak_pilih'    => $this->input->post('pengguna_hak_pilih'),
        ];

        $this->db->insert('tb_jumlah_pemilih_pileg',$data);
    }

    public function tambahDptKecamatanRi()
    {
        $data = [
            'id_periode'            => $this->input->post('id_periode_pemilu'),    
            'id_role'               => 1,
            'id_kec'                => $this->input->post('id_kec'),    
            'dpt'                   => $this->input->post('dpt'),
            'pengguna_hak_pilih'    => $this->input->post('pengguna_hak_pilih'),
        ];

        $this->db->insert('tb_jumlah_pemilih_pileg',$data);
    }

    public function tambahDptKecamatanProv()
    {
        $data = [
            'id_periode'            => $this->input->post('id_periode_pemilu'),    
            'id_role'               => 2,
            'id_kec'                => $this->input->post('id_kec'),    
            'dpt'                   => $this->input->post('dpt'),
            'pengguna_hak_pilih'    => $this->input->post('pengguna_hak_pilih'),
        ];

        $this->db->insert('tb_jumlah_pemilih_pileg',$data);
    }

    public function tambahDptKecamatanKab()
    {
        $data = [
            'id_periode'            => $this->input->post('id_periode_pemilu'),    
            'id_role'               => 3,
            'id_kec'                => $this->input->post('id_kec'),    
            'dpt'                   => $this->input->post('dpt'),
            'pengguna_hak_pilih'    => $this->input->post('pengguna_hak_pilih'),
        ];

        $this->db->insert('tb_jumlah_pemilih_pileg',$data);
    }

    public function tambahDptDesaRi()
    {
        $data = [
            'id_periode'            => $this->input->post('id_periode_pemilu'),    
            'id_role'               => 1,
            'id_desa'               => $this->input->post('id_desa'),    
            'dpt'                   => $this->input->post('dpt'),
            'pengguna_hak_pilih'    => $this->input->post('pengguna_hak_pilih'),
        ];

        $this->db->insert('tb_jumlah_pemilih_pileg',$data);
    }

    public function tambahDptDesaProv()
    {
        $data = [
            'id_periode'            => $this->input->post('id_periode_pemilu'),    
            'id_role'               => 2,
            'id_desa'               => $this->input->post('id_desa'),    
            'dpt'                   => $this->input->post('dpt'),
            'pengguna_hak_pilih'    => $this->input->post('pengguna_hak_pilih'),
        ];

        $this->db->insert('tb_jumlah_pemilih_pileg',$data);
    }

    public function tambahDptDesaKab()
    {
        $data = [
            'id_periode'            => $this->input->post('id_periode_pemilu'),    
            'id_role'               => 3,
            'id_desa'               => $this->input->post('id_desa'),    
            'dpt'                   => $this->input->post('dpt'),
            'pengguna_hak_pilih'    => $this->input->post('pengguna_hak_pilih'),
        ];

        $this->db->insert('tb_jumlah_pemilih_pileg',$data);
    }

    public function getDataJumlahPemilihPilegById($id_jumlah_pemilih)
    {
        $this->db->where('id_jumlah_pemilih_pileg',$id_jumlah_pemilih);
        return $this->db->get('tb_jumlah_pemilih_pileg');
    }

    public function editJumlahPemilih($id_jumlah_pemilih)
    {
        $data = [
            'dpt'                   => $this->input->post('dpt'),
            'pengguna_hak_pilih'    => $this->input->post('pengguna_hak_pilih'),
        ];

        $this->db->where('id_jumlah_pemilih_pileg',$id_jumlah_pemilih);
        $this->db->update('tb_jumlah_pemilih_pileg',$data);
    }

    public function getDataHasilPilegKabupaten($id_kab,$id_periode,$id_role)
    {
        $q = $this->db->query("SELECT tb_hasil_pileg.*, tb_partai.*
                                FROM tb_hasil_pileg
                                JOIN tb_partai ON tb_hasil_pileg.id_partai = tb_partai.id_partai 
                                WHERE tb_hasil_pileg.id_kab = '$id_kab' AND tb_hasil_pileg.id_periode = '$id_periode' AND tb_hasil_pileg.id_role = '$id_role'
                                ");
        return $q;
    }

    public function getDataHasilPilegKecamatan($id_kec,$id_periode,$id_role)
    {
        $q = $this->db->query("SELECT tb_hasil_pileg.*, tb_partai.*
                                FROM tb_hasil_pileg
                                JOIN tb_partai ON tb_hasil_pileg.id_partai = tb_partai.id_partai 
                                WHERE tb_hasil_pileg.id_kec = '$id_kec' AND tb_hasil_pileg.id_periode = '$id_periode' AND tb_hasil_pileg.id_role = '$id_role'
                                ");
        return $q;
    }

    public function getDataHasilPilegDesa($id_desa,$id_periode,$id_role)
    {
        $q = $this->db->query("SELECT tb_hasil_pileg.*, tb_partai.*
                                FROM tb_hasil_pileg
                                JOIN tb_partai ON tb_hasil_pileg.id_partai = tb_partai.id_partai 
                                WHERE tb_hasil_pileg.id_desa = '$id_desa' AND tb_hasil_pileg.id_periode = '$id_periode' AND tb_hasil_pileg.id_role = '$id_role'
                                ");
        return $q;
    }

    public function getDataPartai()
    {
        return $this->db->get('tb_partai');
    }

    public function tambahHasilPilegKabupatenRi()
    {
        $data = [
            'id_role'           => 1,
            'id_periode'        => $this->input->post('id_periode_pemilu'),
            'id_kab'            => $this->input->post('id_kab'),
            'id_partai'         => $this->input->post('partai'),
            'perolehan'         => $this->input->post('perolehan'),
        ];

        $this->db->insert('tb_hasil_pileg',$data);
    }

    public function tambahHasilPilegKabupatenProvinsi()
    {
        $data = [
            'id_role'           => 2,
            'id_periode'        => $this->input->post('id_periode_pemilu'),
            'id_kab'            => $this->input->post('id_kab'),
            'id_partai'         => $this->input->post('partai'),
            'perolehan'         => $this->input->post('perolehan'),
        ];

        $this->db->insert('tb_hasil_pileg',$data);
    }

    public function tambahHasilPilegKabupatenKabupaten()
    {
        $data = [
            'id_role'           => 3,
            'id_periode'        => $this->input->post('id_periode_pemilu'),
            'id_kab'            => $this->input->post('id_kab'),
            'id_partai'         => $this->input->post('partai'),
            'perolehan'         => $this->input->post('perolehan'),
        ];

        $this->db->insert('tb_hasil_pileg',$data);
    }

    public function tambahHasilPilegKecamatanRi()
    {
        $data = [
            'id_role'           => 1,
            'id_periode'        => $this->input->post('id_periode_pemilu'),
            'id_kec'            => $this->input->post('id_kec'),
            'id_partai'         => $this->input->post('partai'),
            'perolehan'         => $this->input->post('perolehan'),
        ];

        $this->db->insert('tb_hasil_pileg',$data);
    }

    public function tambahHasilPilegKecamatanProvinsi()
    {
        $data = [
            'id_role'           => 2,
            'id_periode'        => $this->input->post('id_periode_pemilu'),
            'id_kec'            => $this->input->post('id_kec'),
            'id_partai'         => $this->input->post('partai'),
            'perolehan'         => $this->input->post('perolehan'),
        ];

        $this->db->insert('tb_hasil_pileg',$data);
    }

    public function tambahHasilPilegKecamatanKabupaten()
    {
        $data = [
            'id_role'           => 3,
            'id_periode'        => $this->input->post('id_periode_pemilu'),
            'id_kec'            => $this->input->post('id_kec'),
            'id_partai'         => $this->input->post('partai'),
            'perolehan'         => $this->input->post('perolehan'),
        ];

        $this->db->insert('tb_hasil_pileg',$data);
    }

    public function tambahHasilPilegDesaRi()
    {
        $data = [
            'id_role'           => 1,
            'id_periode'        => $this->input->post('id_periode_pemilu'),
            'id_desa'           => $this->input->post('id_desa'),
            'id_partai'         => $this->input->post('partai'),
            'perolehan'         => $this->input->post('perolehan'),
        ];

        $this->db->insert('tb_hasil_pileg',$data);
    }

    public function tambahHasilPilegDesaProv()
    {
        $data = [
            'id_role'           => 2,
            'id_periode'        => $this->input->post('id_periode_pemilu'),
            'id_desa'           => $this->input->post('id_desa'),
            'id_partai'         => $this->input->post('partai'),
            'perolehan'         => $this->input->post('perolehan'),
        ];

        $this->db->insert('tb_hasil_pileg',$data);
    }

    public function tambahHasilPilegDesaKab()
    {
        $data = [
            'id_role'           => 3,
            'id_periode'        => $this->input->post('id_periode_pemilu'),
            'id_desa'           => $this->input->post('id_desa'),
            'id_partai'         => $this->input->post('partai'),
            'perolehan'         => $this->input->post('perolehan'),
        ];

        $this->db->insert('tb_hasil_pileg',$data);
    }

    public function getDataHasilPilegById($id_hasil_pileg)
    {
        $q = $this->db->query("SELECT tb_hasil_pileg.*, tb_partai.*, tb_periode_pemilu.*, wilayah_kab.*
                                FROM tb_hasil_pileg
                                JOIN tb_partai ON tb_hasil_pileg.id_partai = tb_partai.id_partai
                                JOIN tb_periode_pemilu ON tb_hasil_pileg.id_periode = tb_periode_pemilu.id_periode_pemilu
                                JOIN wilayah_kab ON tb_hasil_pileg.id_kab = wilayah_kab.id_kab
                                WHERE tb_hasil_pileg.id_hasil_pileg = '$id_hasil_pileg'
                                ");
        return $q;
    }

    public function getDataHasilPilegById2($id_hasil_pileg)
    {
        $q = $this->db->query("SELECT tb_hasil_pileg.*, tb_partai.*, tb_periode_pemilu.*
                                FROM tb_hasil_pileg
                                JOIN tb_partai ON tb_hasil_pileg.id_partai = tb_partai.id_partai
                                JOIN tb_periode_pemilu ON tb_hasil_pileg.id_periode = tb_periode_pemilu.id_periode_pemilu
                                WHERE tb_hasil_pileg.id_hasil_pileg = '$id_hasil_pileg'
                                ");
        return $q;
    }

    public function editHasilPileg($id_hasil_pileg)
    {
        $data = [
            'perolehan'         => $this->input->post('perolehan'),
        ];

        $this->db->where('id_hasil_pileg',$id_hasil_pileg);
        $this->db->update('tb_hasil_pileg',$data);
    }

    public function getDataKecamatanByIdKab($id_kab)
    {
        $this->db->where('id_kab',$id_kab);
        return $this->db->get('wilayah_kec');
    }

    public function getDataDesaByIdKec($id_kec)
    {
        $this->db->where('id_kec',$id_kec);
        return $this->db->get('wilayah_desa');
    }
}