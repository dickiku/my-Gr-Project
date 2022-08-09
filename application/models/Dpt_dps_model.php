<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dpt_dps_model extends CI_model{

    public function getDataWilayahKec($id_kab)
    {
        $q = $this->db->where("id_kab",$id_kab);

        return $this->db->get('wilayah_kec');
    }

    public function getDataWilayahDesa($id_kec)
    {
        $q = $this->db->where("id_kec",$id_kec);

        return $this->db->get('wilayah_desa');
    }

    public function getDataDpt($id_tps)
    {
        $q = $this->db->where("id_tps",$id_tps);

        return $this->db->from('tb_dpt')
            ->join('tb_keanggotaan', 'tb_dpt.id_keanggotaan = tb_keanggotaan.id_keanggotaan')
            ->get();
    }

    public function getDataDps($id_tps)
    {
        $q = $this->db->where("id_tps",$id_tps);

        return $this->db->from('tb_dps')
            ->join('tb_keanggotaan', 'tb_dps.id_keanggotaan = tb_keanggotaan.id_keanggotaan')
            ->get();
    }

    public function getDataTps($id_desa)
    {
        $q = $this->db->where("id_desa",$id_desa);

        return $this->db->get('tb_tps');
    }

    public function getDataTpsDetail($id_tps)
    {
        $q = $this->db->where("id_tps",$id_tps);

        return $this->db->get('tb_tps');
    }

    public function tambahTps()
    {
        $data = [
            'id_desa'   => $this->input->post('id_desa'),
            'nama_tps'  => $this->input->post('nama')
        ];

        $this->db->insert('tb_tps',$data);
    }

    public function getDetailTps($id_tps)
    {
        $q = $this->db->where("id_tps",$id_tps);

        return $this->db->get('tb_tps');
    }

    public function editTps($id_tps)
    {
        $data = [
            'id_desa'   => $this->input->post('id_desa'),
            'nama_tps'  => $this->input->post('nama')
        ];

        $this->db->where("id_tps",$id_tps);
        $this->db->update('tb_tps',$data);
    }

    public function tambahDataDPT($f_pendukung)
    {
        $id_keanggotaan = $this->input->post('keanggotaan');

        $data = [
            'id_desa'           => $this->input->post('id_desa'),
            'id_tps'            => $this->input->post('id_tps'),
            'laki'              => $this->input->post('laki'),
            'perempuan'         => $this->input->post('perempuan'),
            'tahun'             => $this->input->post('tahun'),
            'file'              => $f_pendukung,
            'id_keanggotaan'    => $this->input->post('keanggotaan'),
            'ket'               => $this->input->post('ket')
        ];

        $query = $this->db->where('id_keanggotaan', $id_keanggotaan)
                            ->where('status', 1)
                            ->get('tb_keanggotaan');

        if($query->num_rows() > 0)
        {
            $this->db->insert('tb_dpt',$data);

            return $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');
        }
        else
        {
            return $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    <strong>Error!</strong> Data Gagal Ditambahkan.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');
        }
    }

    public function tambahDataDPS($f_pendukung)
    {
        $id_keanggotaan = $this->input->post('keanggotaan');

        $data = [
            'id_desa'           => $this->input->post('id_desa'),
            'id_tps'            => $this->input->post('id_tps'),
            'laki'              => $this->input->post('laki'),
            'perempuan'         => $this->input->post('perempuan'),
            'tahun'             => $this->input->post('tahun'),
            'file'              => $f_pendukung,
            'id_keanggotaan'    => $this->input->post('keanggotaan'),
            'ket'               => $this->input->post('ket')
        ];

        $query = $this->db->where('id_keanggotaan', $id_keanggotaan)
                            ->where('status', 1)
                            ->get('tb_keanggotaan');

        if($query->num_rows() > 0)
        {
            $this->db->insert('tb_dps',$data);

            return $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');
        }
        else
        {
            return $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    <strong>Error!</strong> Data Gagal Ditambahkan.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');
        }
    }

    public function getData($id_data,$id_func)
    {
        if($id_func == "1")
        {
            $q = $this->db->where("id_dpt",$id_data);

            return $this->db->from('tb_dpt')
                ->join('tb_keanggotaan', 'tb_dpt.id_keanggotaan = tb_keanggotaan.id_keanggotaan')
                ->join('tb_tps', 'tb_dpt.id_tps = tb_tps.id_tps')
                ->get();
        }
        elseif($id_func == "2")
        {
            $q = $this->db->where("id_dps",$id_data);

            return $this->db->from('tb_dps')
                ->join('tb_keanggotaan', 'tb_dps.id_keanggotaan = tb_keanggotaan.id_keanggotaan')
                ->join('tb_tps', 'tb_dps.id_tps = tb_tps.id_tps')
                ->get();
        }
    }

    public function edit($id_data,$id_func,$file)
    {
        $data = [
            'id_desa'           => $this->input->post('id_desa'),
            'id_tps'            => $this->input->post('id_tps'),
            'laki'              => $this->input->post('laki'),
            'perempuan'         => $this->input->post('perempuan'),
            'tahun'             => $this->input->post('tahun'),
            'file'              => $file,
            'id_keanggotaan'    => $this->input->post('keanggotaan'),
            'ket'               => $this->input->post('ket')
        ];

        if($id_func == "1")
        {
            $this->db->where('id_dpt',$id_data);
            $this->db->update('tb_dpt',$data);
        }
        elseif($id_func == "2")
        {
            $this->db->where('id_dps',$id_data);
            $this->db->update('tb_dps',$data);
        }
    }
}

?>