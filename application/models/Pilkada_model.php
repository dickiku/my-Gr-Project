<?php

class Pilkada_model extends CI_Model{
// ------------- PILGUB --------------
    public function pilgub_showPeriode()
    {
        $this->db->where('role','1');

        return $this->db->get('tb_tahun');
    }

    public function pilgub_getDataPeriodeById($id_tahun)
    {
        $this->db->where('id_tahun',$id_tahun);

        return $this->db->get('tb_tahun');
    }

    public function getDataCagubByPeriode($id_tahun)
    {
        $this->db->where('id_tahun', $id_tahun);

        return $this->db->get('tb_cagub');
    }

    public function getDataJumlahPemilihById($id_data)
    {
        $this->db->where('id_jumlah_pemilih_pilkada',$id_data);

        return $this->db->from('tb_jumlah_pemilih_pilkada')
            ->join('wilayah_kab', 'tb_jumlah_pemilih_pilkada.id_kab = wilayah_kab.id_kab')
            ->join('wilayah_kec', 'tb_jumlah_pemilih_pilkada.id_kec = wilayah_kec.id_kec')
            ->join('wilayah_desa', 'tb_jumlah_pemilih_pilkada.id_desa = wilayah_desa.id_desa')
            ->get();
    }

    public function getDataHasilPilgubById($id_data)
    {
        $this->db->where('id_hasil_pilgub',$id_data);

        return $this->db->from('tb_hasil_pilgub')
            ->join('tb_cagub', 'tb_hasil_pilgub.id_cagub = tb_cagub.id_cagub')
            ->join('tb_tahun', 'tb_hasil_pilgub.id_tahun = tb_tahun.id_tahun')
            ->get();
    }

    // ------------- Kabupaten -------------
    public function pilgub_getDptHakPilihKabupaten($id_kab,$id_tahun)
    {
        $this->db->where('id_kab',$id_kab);
        $this->db->where('id_tahun',$id_tahun);
        $this->db->where('role','1');

        return $this->db->get('tb_jumlah_pemilih_pilkada');
    }

    public function pilgub_tambahDptHakPilihKabupaten()
    {
        $data = [
            'id_tahun'          => $this->input->post('id_tahun'),
            'id_kab'            => $this->input->post('id_kab'),
            'dpt'               => $this->input->post('dpt'),
            'pengguna_hak_pilih'=> $this->input->post('pengguna_hak_pilih'),
            'role'              => '1'
        ];

        $this->db->insert('tb_jumlah_pemilih_pilkada',$data);
    }

    public function getDataJumlahPemilihKabById($id_data)
    {
        $this->db->where('id_jumlah_pemilih_pilkada',$id_data);

        return $this->db->from('tb_jumlah_pemilih_pilkada')
            ->join('wilayah_kab', 'tb_jumlah_pemilih_pilkada.id_kab = wilayah_kab.id_kab')
            ->get();
    }

    public function editJumlahPemilihKab($id_data)
    {
        $data = [
            'id_tahun'          => $this->input->post('id_tahun'),
            'id_kab'            => $this->input->post('id_kab'),
            'dpt'               => $this->input->post('dpt'),
            'pengguna_hak_pilih'=> $this->input->post('pengguna_hak_pilih'),
            'role'              => '1'
        ];

        $this->db->where('id_jumlah_pemilih_pilkada',$id_data);
        $this->db->update('tb_jumlah_pemilih_pilkada',$data);
    }

    public function pilgub_getHasilPilgubKabupaten($id_kab,$id_tahun)
    {
        $this->db->where('id_kab',$id_kab);
        $this->db->where('tb_hasil_pilgub.id_tahun',$id_tahun);

        return $this->db->from('tb_hasil_pilgub')
            ->join('tb_cagub', 'tb_hasil_pilgub.id_cagub = tb_cagub.id_cagub')
            ->get();
    }

    public function pilgub_tambahHasilPilgubKabupaten()
    {
        $data = [
            'id_tahun'  => $this->input->post('id_tahun'),
            'id_kab'    => $this->input->post('id_kab'),
            'id_cagub'  => $this->input->post('cagub'),
            'perolehan' => $this->input->post('perolehan')
        ];

        $this->db->insert('tb_hasil_pilgub',$data);
    }

    public function pilgub_editHasilPilkadaKab($id_data)
    {
        $data = [
            'id_tahun'  => $this->input->post('id_tahun'),
            'id_kab'    => $this->input->post('id_kab'),
            'id_cagub'  => $this->input->post('cagub'),
            'perolehan' => $this->input->post('perolehan')
        ];

        $this->db->where('id_hasil_pilgub',$id_data);
        $this->db->update('tb_hasil_pilgub',$data);
    }

    // -------------- Kecamatan -------------
    public function pilgub_getDptHakPilihKecamatan($id_kec,$id_tahun)
    {
        $this->db->where('id_kec',$id_kec);
        $this->db->where('id_tahun',$id_tahun);
        $this->db->where('role','1');

        return $this->db->get('tb_jumlah_pemilih_pilkada');
    }

    public function pilgub_tambahDptHakPilihKecamatan()
    {
        $data = [
            'id_tahun'          => $this->input->post('id_tahun'),
            'id_kec'            => $this->input->post('id_kec'),
            'dpt'               => $this->input->post('dpt'),
            'pengguna_hak_pilih'=> $this->input->post('pengguna_hak_pilih'),
            'role'              => '1'
        ];

        $this->db->insert('tb_jumlah_pemilih_pilkada',$data);
    }

    public function getDataJumlahPemilihKecById($id_data)
    {
        $this->db->where('id_jumlah_pemilih_pilkada',$id_data);

        return $this->db->from('tb_jumlah_pemilih_pilkada')
            ->join('wilayah_kec', 'tb_jumlah_pemilih_pilkada.id_kec = wilayah_kec.id_kec')
            ->get();
    }

    public function editJumlahPemilihKec($id_data)
    {
        $data = [
            'id_tahun'          => $this->input->post('id_tahun'),
            'id_kec'            => $this->input->post('id_kec'),
            'dpt'               => $this->input->post('dpt'),
            'pengguna_hak_pilih'=> $this->input->post('pengguna_hak_pilih'),
            'role'              => '1'
        ];

        $this->db->where('id_jumlah_pemilih_pilkada',$id_data);
        $this->db->update('tb_jumlah_pemilih_pilkada',$data);
    }

    public function pilgub_getHasilPilgubKecamatan($id_kec,$id_tahun)
    {
        $this->db->where('id_kec',$id_kec);
        $this->db->where('tb_hasil_pilgub.id_tahun',$id_tahun);

        return $this->db->from('tb_hasil_pilgub')
            ->join('tb_cagub', 'tb_hasil_pilgub.id_cagub = tb_cagub.id_cagub')
            ->get();
    }

    public function pilgub_tambahHasilPilgubKecamatan()
    {
        $data = [
            'id_tahun'  => $this->input->post('id_tahun'),
            'id_kec'    => $this->input->post('id_kec'),
            'id_cagub'  => $this->input->post('cagub'),
            'perolehan' => $this->input->post('perolehan')
        ];

        $this->db->insert('tb_hasil_pilgub',$data);
    }

    public function pilgub_editHasilPilkadaKec($id_data)
    {
        $data = [
            'id_tahun'  => $this->input->post('id_tahun'),
            'id_kec'    => $this->input->post('id_kec'),
            'id_cagub'  => $this->input->post('cagub'),
            'perolehan' => $this->input->post('perolehan')
        ];

        $this->db->where('id_hasil_pilgub',$id_data);
        $this->db->update('tb_hasil_pilgub',$data);
    }

    // -------------- Desa -------------
    public function pilgub_getDptHakPilihDesa($id_desa,$id_tahun)
    {
        $this->db->where('id_desa',$id_desa);
        $this->db->where('id_tahun',$id_tahun);
        $this->db->where('role','1');

        return $this->db->get('tb_jumlah_pemilih_pilkada');
    }

    public function pilgub_tambahDptHakPilihDesa()
    {
        $data = [
            'id_tahun'          => $this->input->post('id_tahun'),
            'id_desa'            => $this->input->post('id_desa'),
            'dpt'               => $this->input->post('dpt'),
            'pengguna_hak_pilih'=> $this->input->post('pengguna_hak_pilih'),
            'role'              => '1'
        ];

        $this->db->insert('tb_jumlah_pemilih_pilkada',$data);
    }

    public function getDataJumlahPemilihDesaById($id_data)
    {
        $this->db->where('id_jumlah_pemilih_pilkada',$id_data);

        return $this->db->from('tb_jumlah_pemilih_pilkada')
            ->join('wilayah_desa', 'tb_jumlah_pemilih_pilkada.id_desa = wilayah_desa.id_desa')
            ->get();
    }

    public function editJumlahPemilihDesa($id_data)
    {
        $data = [
            'id_tahun'          => $this->input->post('id_tahun'),
            'id_desa'           => $this->input->post('id_desa'),
            'dpt'               => $this->input->post('dpt'),
            'pengguna_hak_pilih'=> $this->input->post('pengguna_hak_pilih'),
            'role'              => '1'
        ];

        $this->db->where('id_jumlah_pemilih_pilkada',$id_data);
        $this->db->update('tb_jumlah_pemilih_pilkada',$data);
    }

    public function pilgub_getHasilPilgubDesa($id_data,$id_tahun)
    {
        $this->db->where('id_desa',$id_data);
        $this->db->where('tb_hasil_pilgub.id_tahun',$id_tahun);

        return $this->db->from('tb_hasil_pilgub')
            ->join('tb_cagub', 'tb_hasil_pilgub.id_cagub = tb_cagub.id_cagub')
            ->get();
    }

    public function pilgub_tambahHasilPilgubDesa()
    {
        $data = [
            'id_tahun'  => $this->input->post('id_tahun'),
            'id_desa'    => $this->input->post('id_desa'),
            'id_cagub'  => $this->input->post('cagub'),
            'perolehan' => $this->input->post('perolehan')
        ];

        $this->db->insert('tb_hasil_pilgub',$data);
    }

    public function pilgub_editHasilPilkadaDesa($id_data)
    {
        $data = [
            'id_tahun'  => $this->input->post('id_tahun'),
            'id_desa'   => $this->input->post('id_desa'),
            'id_cagub'  => $this->input->post('cagub'),
            'perolehan' => $this->input->post('perolehan')
        ];

        $this->db->where('id_hasil_pilgub',$id_data);
        $this->db->update('tb_hasil_pilgub',$data);
    }

    

// ------------- PILBUP --------------
    public function pilbup_showPeriode($id_kab)
    {
        $this->db->where('role','2');
        $this->db->where('id_kab',$id_kab);

        return $this->db->get('tb_tahun');
    }

    public function getDataKabById($id_kab)
    {
        $this->db->where('id_kab',$id_kab);

        return $this->db->get('wilayah_kab');
    }

    public function pilbup_getDataPeriodeByIdKab($id_tahun,$id_kab)
    {
        $this->db->where('id_tahun',$id_tahun);
        $this->db->where('id_kab',$id_kab);

        return $this->db->get('tb_tahun');
    }

    public function getDataCabupByPeriodeKab($id_tahun,$id_kab)
    {
        $this->db->where('id_tahun',$id_tahun);
        $this->db->where('id_kab',$id_kab);

        return $this->db->get('tb_cabup');
    }

    public function getDataHasilPilbupById($id_data)
    {
        $this->db->where('id_hasil_pilbup',$id_data);

        return $this->db->from('tb_hasil_pilbup')
            ->join('tb_cabup', 'tb_hasil_pilbup.id_cabup = tb_cabup.id_cabup')
            ->join('tb_tahun', 'tb_hasil_pilbup.id_tahun = tb_tahun.id_tahun')
            ->get();
    }

    public function getDataCabupByIdPeriode($id_tahun)
    {
        $this->db->where('id_tahun',$id_tahun);

        return $this->db->get('tb_cabup');
    }

    // --------- kabupaten ----------
    public function pilbup_getDataDptHakPilihKab($id_kab,$id_tahun)
    {
        $this->db->where('id_kab',$id_kab);
        $this->db->where('id_tahun',$id_tahun);
        $this->db->where('role','2');

        return $this->db->get('tb_jumlah_pemilih_pilkada');
    }

    public function pilbup_tambahDptHakPilihKab()
    {
        $data = [
            'id_tahun'          => $this->input->post('id_tahun'),
            'id_kab'            => $this->input->post('id_kab'),
            'dpt'               => $this->input->post('dpt'),
            'pengguna_hak_pilih'=> $this->input->post('pengguna_hak_pilih'),
            'role'              => '2'
        ];

        $this->db->insert('tb_jumlah_pemilih_pilkada',$data);
    }

    public function pilbup_editDptHakPilihKab($id_data)
    {
        $data = [
            'id_tahun'          => $this->input->post('id_tahun'),
            'id_kab'            => $this->input->post('id_kab'),
            'dpt'               => $this->input->post('dpt'),
            'pengguna_hak_pilih'=> $this->input->post('pengguna_hak_pilih'),
            'role'              => '2'
        ];

        $this->db->where('id_jumlah_pemilih_pilkada',$id_data);
        $this->db->update('tb_jumlah_pemilih_pilkada',$data);
    }

    public function pilbup_getDataHasilPerolehanKab($id_kab,$id_periode)
    {
        $this->db->where('tb_hasil_pilbup.id_kab',$id_kab);
        $this->db->where('tb_hasil_pilbup.id_tahun',$id_periode);

        return $this->db->from('tb_hasil_pilbup')
            ->join('tb_cabup', 'tb_hasil_pilbup.id_cabup = tb_cabup.id_cabup')
            ->get();
    }

    public function pilbup_tambahHasilPerolehanKab()
    {
        $data = [
            'id_tahun'  => $this->input->post('id_tahun'),
            'id_kab'    => $this->input->post('id_kab'),
            'id_cabup'  => $this->input->post('cabup'),
            'perolehan' => $this->input->post('perolehan')
        ];

        $this->db->insert('tb_hasil_pilbup',$data);
    }

    public function pilbup_editHasilPerolehanKab($id_data)
    {
        $data = [
            'id_tahun'  => $this->input->post('id_tahun'),
            'id_kab'    => $this->input->post('id_kab'),
            'id_cabup'  => $this->input->post('cabup'),
            'perolehan' => $this->input->post('perolehan')
        ];

        $this->db->where('id_hasil_pilbup',$id_data);
        $this->db->update('tb_hasil_pilbup',$data);
    }

    // --------- Kecamatan ----------
    public function pilbup_getDataDptHakPilihKec($id_kec,$id_tahun)
    {
        $this->db->where('id_kec',$id_kec);
        $this->db->where('id_tahun',$id_tahun);
        $this->db->where('role','2');

        return $this->db->get('tb_jumlah_pemilih_pilkada');
    }

    public function pilbup_tambahDptHakPilihKec()
    {
        $data = [
            'id_tahun'          => $this->input->post('id_tahun'),
            'id_kec'            => $this->input->post('id_kec'),
            'dpt'               => $this->input->post('dpt'),
            'pengguna_hak_pilih'=> $this->input->post('pengguna_hak_pilih'),
            'role'              => '2'
        ];

        $this->db->insert('tb_jumlah_pemilih_pilkada',$data);
    }

    public function pilbup_editDptHakPilihKec($id_data)
    {
        $data = [
            'id_tahun'          => $this->input->post('id_tahun'),
            'id_kec'            => $this->input->post('id_kec'),
            'dpt'               => $this->input->post('dpt'),
            'pengguna_hak_pilih'=> $this->input->post('pengguna_hak_pilih'),
            'role'              => '2'
        ];

        $this->db->where('id_jumlah_pemilih_pilkada',$id_data);
        $this->db->update('tb_jumlah_pemilih_pilkada',$data);
    }

    public function pilbup_getDataHasilPerolehanKec($id_kec,$id_periode)
    {
        $this->db->where('tb_hasil_pilbup.id_kec',$id_kec);
        $this->db->where('tb_hasil_pilbup.id_tahun',$id_periode);

        return $this->db->from('tb_hasil_pilbup')
            ->join('tb_cabup', 'tb_hasil_pilbup.id_cabup = tb_cabup.id_cabup')
            ->get();
    }

    public function pilbup_tambahHasilPerolehanKec()
    {
        $data = [
            'id_tahun'  => $this->input->post('id_tahun'),
            'id_kec'    => $this->input->post('id_kec'),
            'id_cabup'  => $this->input->post('cabup'),
            'perolehan' => $this->input->post('perolehan')
        ];

        $this->db->insert('tb_hasil_pilbup',$data);
    }

    public function pilbup_editHasilPerolehanKec($id_data)
    {
        $data = [
            'id_tahun'  => $this->input->post('id_tahun'),
            'id_kec'    => $this->input->post('id_kec'),
            'id_cabup'  => $this->input->post('cabup'),
            'perolehan' => $this->input->post('perolehan')
        ];

        $this->db->where('id_hasil_pilbup',$id_data);
        $this->db->update('tb_hasil_pilbup',$data);
    }

    // --------- Desa ----------
    public function pilbup_getDataDptHakPilihDesa($id_desa,$id_tahun)
    {
        $this->db->where('id_desa',$id_desa);
        $this->db->where('id_tahun',$id_tahun);
        $this->db->where('role','2');

        return $this->db->get('tb_jumlah_pemilih_pilkada');
    }

    public function pilbup_tambahDptHakPilihDesa()
    {
        $data = [
            'id_tahun'          => $this->input->post('id_tahun'),
            'id_desa'            => $this->input->post('id_desa'),
            'dpt'               => $this->input->post('dpt'),
            'pengguna_hak_pilih'=> $this->input->post('pengguna_hak_pilih'),
            'role'              => '2'
        ];

        $this->db->insert('tb_jumlah_pemilih_pilkada',$data);
    }

    public function pilbup_editDptHakPilihDesa($id_data)
    {
        $data = [
            'id_tahun'          => $this->input->post('id_tahun'),
            'id_desa'            => $this->input->post('id_desa'),
            'dpt'               => $this->input->post('dpt'),
            'pengguna_hak_pilih'=> $this->input->post('pengguna_hak_pilih'),
            'role'              => '2'
        ];

        $this->db->where('id_jumlah_pemilih_pilkada',$id_data);
        $this->db->update('tb_jumlah_pemilih_pilkada',$data);
    }

    public function pilbup_getDataHasilPerolehanDesa($id_desa,$id_periode)
    {
        $this->db->where('tb_hasil_pilbup.id_desa',$id_desa);
        $this->db->where('tb_hasil_pilbup.id_tahun',$id_periode);

        return $this->db->from('tb_hasil_pilbup')
            ->join('tb_cabup', 'tb_hasil_pilbup.id_cabup = tb_cabup.id_cabup')
            ->get();
    }

    public function pilbup_tambahHasilPerolehanDesa()
    {
        $data = [
            'id_tahun'  => $this->input->post('id_tahun'),
            'id_desa'    => $this->input->post('id_desa'),
            'id_cabup'  => $this->input->post('cabup'),
            'perolehan' => $this->input->post('perolehan')
        ];

        $this->db->insert('tb_hasil_pilbup',$data);
    }

    public function pilbup_editHasilPerolehanDesa($id_data)
    {
        $data = [
            'id_tahun'  => $this->input->post('id_tahun'),
            'id_desa'    => $this->input->post('id_desa'),
            'id_cabup'  => $this->input->post('cabup'),
            'perolehan' => $this->input->post('perolehan')
        ];

        $this->db->where('id_hasil_pilbup',$id_data);
        $this->db->update('tb_hasil_pilbup',$data);
    }

}

?>