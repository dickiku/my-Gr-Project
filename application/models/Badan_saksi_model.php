<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Badan_saksi_model extends CI_Model{

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

    public function getStrukturKec($id_kec)
    {
        $q = $this->db->where("tb_badan_saksi_kec.id_kec",$id_kec);

        return $this->db->from('tb_badan_saksi_kec')
            ->join('tb_keanggotaan', 'tb_badan_saksi_kec.id_keanggotaan = tb_keanggotaan.id_keanggotaan')
            ->get();
    }

    public function getStrukturDesa($id_desa)
    {
        $q = $this->db->where("tb_badan_saksi_desa.id_desa",$id_desa);

        return $this->db->from('tb_badan_saksi_desa')
            ->join('tb_keanggotaan', 'tb_badan_saksi_desa.id_keanggotaan = tb_keanggotaan.id_keanggotaan')
            ->get();
    }

    public function getStrukturKab($id_kab)
    {
        $q = $this->db->where("tb_badan_saksi_kab.id_kab",$id_kab);

        return $this->db->from('tb_badan_saksi_kab')
            ->join('tb_keanggotaan', 'tb_badan_saksi_kab.id_keanggotaan = tb_keanggotaan.id_keanggotaan')
            ->get();
    }

    public function getStrukturProv()
    {
        return $this->db->from('tb_badan_saksi_prov')
            ->join('tb_keanggotaan', 'tb_badan_saksi_prov.id_keanggotaan = tb_keanggotaan.id_keanggotaan')
            ->get();
    }

    public function getDataJabatan()
    {
        return $this->db->get('tb_jabatan_bs');
    }

    public function getDataBSKab($id_kab)
    {
        $q = $this->db->where("id_kab",$id_kab);

        return $this->db->get('wilayah_kab');
    }

    public function getDataBSKec($id_kec)
    {
        $q = $this->db->where("id_kec",$id_kec);

        return $this->db->get('wilayah_kec');
    }

    public function getDataBSDesa($id_desa)
    {
        $q = $this->db->where("id_desa",$id_desa);

        return $this->db->get('wilayah_desa');
    }

    public function tambahPengurusProv()
    {
        $id_keanggotaan = $this->input->post('keanggotaan');

        $data = [
            'id_keanggotaan' => $this->input->post('keanggotaan'),
            'jabatan'       => $this->input->post('jabatan'),
            'kolom'         => $this->input->post('kolom')
        ];

        $query = $this->db->where('id_keanggotaan',$id_keanggotaan)
                          ->where('status', 1 )
                          ->get('tb_keanggotaan');

        if($query->num_rows() > 0)
        {
            $this->db->insert('tb_badan_saksi_prov',$data);

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

    public function tambahPengurusKab()
    {
        $id_keanggotaan = $this->input->post('keanggotaan');

        $data = [
            'id_keanggotaan'    => $this->input->post('keanggotaan'),
            'jabatan'           => $this->input->post('jabatan'),
            'id_kab'            => $this->input->post('id_kab'),
            'kolom'             => $this->input->post('kolom')
        ];

        $query = $this->db->where('id_keanggotaan',$id_keanggotaan)
                          ->where('status', 1 )
                          ->get('tb_keanggotaan');

        if($query->num_rows() > 0)
        {
            $this->db->insert('tb_badan_saksi_kab',$data);

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

    public function tambahPengurusKec()
    {
        $id_keanggotaan = $this->input->post('keanggotaan');

        $data = [
            'id_keanggotaan'    => $this->input->post('keanggotaan'),
            'jabatan'           => $this->input->post('jabatan'),
            'id_kec'            => $this->input->post('id_kec'),
            'kolom'             => $this->input->post('kolom')
        ];

        $query = $this->db->where('id_keanggotaan',$id_keanggotaan)
                          ->where('status', 1 )
                          ->get('tb_keanggotaan');

        if($query->num_rows() > 0)
        {
            $this->db->insert('tb_badan_saksi_kec',$data);

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

    public function tambahPengurusDesa()
    {
        $id_keanggotaan = $this->input->post('keanggotaan');

        $data = [
            'id_keanggotaan'    => $this->input->post('keanggotaan'),
            'jabatan'           => $this->input->post('jabatan'),
            'id_desa'           => $this->input->post('id_desa'),
            'tps'               => $this->input->post('tps'),
            'kolom'             => $this->input->post('kolom')
        ];

        $query = $this->db->where('id_keanggotaan',$id_keanggotaan)
                          ->where('status', 1 )
                          ->get('tb_keanggotaan');

        if($query->num_rows() > 0)
        {
            $this->db->insert('tb_badan_saksi_desa',$data);

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

    public function editKepengurusan($id_pengurus,$id_func)
    {
        if($id_func == "1")
        {
            $data = [
                'id_keanggotaan'    => $this->input->post('id_keanggotaan'),
                'jabatan'           => $this->input->post('jabatan'),
                'id_kec'            => $this->input->post('temp'),
                'kolom'             => $this->input->post('kolom')
            ];
    
            $this->db->where('id_badan_saksi_kec', $id_pengurus);
            $this->db->update('tb_badan_saksi_kec', $data);
        }
        elseif($id_func == "2")
        {
            $data = [
                'id_keanggotaan'    => $this->input->post('id_keanggotaan'),
                'jabatan'           => $this->input->post('jabatan'),
                'id_desa'           => $this->input->post('temp'),
                'tps'               => $this->input->post('tps'),
                'kolom'             => $this->input->post('kolom')
            ];
    
            $this->db->where('id_badan_saksi_desa', $id_pengurus);
            $this->db->update('tb_badan_saksi_desa', $data);
        }
    }

    public function getData($id_data,$id_func)
    {
        if($id_func == "1")
        {
            $q = $this->db->where("id_badan_saksi_kec",$id_data);

            return $this->db->from('tb_badan_saksi_kec')
                ->join('tb_keanggotaan', 'tb_badan_saksi_kec.id_keanggotaan = tb_keanggotaan.id_keanggotaan')
                ->get();
        }
        elseif($id_func == "2")
        {
            $q = $this->db->where("id_badan_saksi_desa",$id_data);

            return $this->db->from('tb_badan_saksi_desa')
                ->join('tb_keanggotaan', 'tb_badan_saksi_desa.id_keanggotaan = tb_keanggotaan.id_keanggotaan')
                ->get();
        }
        elseif($id_func == "3")
        {
            $q = $this->db->where("id_badan_saksi_kab",$id_data);

            return $this->db->from('tb_badan_saksi_kab')
                ->join('tb_keanggotaan', 'tb_badan_saksi_kab.id_keanggotaan = tb_keanggotaan.id_keanggotaan')
                ->get();
        }
        elseif($id_func == "4")
        {
            $q = $this->db->where("id_badan_saksi_prov",$id_data);

            return $this->db->from('tb_badan_saksi_prov')
                ->join('tb_keanggotaan', 'tb_badan_saksi_prov.id_keanggotaan = tb_keanggotaan.id_keanggotaan')
                ->get();
        }
    }

    public function edit($id_data,$id_func)
    { 
        if($id_func == "1")
        {
            $data = [
                'id_keanggotaan'    => $this->input->post('id_keanggotaan'),
                'jabatan'           => $this->input->post('jabatan'),
                'id_kec'            => $this->input->post('temp'),
                'kolom'             => $this->input->post('kolom')
            ];  

            $this->db->where('id_badan_saksi_kec',$id_data);
            $this->db->update('tb_badan_saksi_kec',$data);
        }
        elseif($id_func == "2")
        {
            $data = [
                'id_keanggotaan'    => $this->input->post('id_keanggotaan'),
                'jabatan'           => $this->input->post('jabatan'),
                'id_desa'           => $this->input->post('temp'),
                'tps'               => $this->input->post('tps'),
                'kolom'             => $this->input->post('kolom')
            ];  

            $this->db->where('id_badan_saksi_desa',$id_data);
            $this->db->update('tb_badan_saksi_desa',$data);
        }
        elseif($id_func == "3")
        {
            $data = [
                'id_keanggotaan'    => $this->input->post('id_keanggotaan'),
                'jabatan'           => $this->input->post('jabatan'),
                'id_kab'            => $this->input->post('temp'),
                'kolom'             => $this->input->post('kolom')
            ];  

            $this->db->where('id_badan_saksi_kab',$id_data);
            $this->db->update('tb_badan_saksi_kab',$data);
        }
        elseif($id_func == "4")
        {
            $data = [
                'id_keanggotaan'    => $this->input->post('id_keanggotaan'),
                'jabatan'           => $this->input->post('jabatan'),
                'kolom'             => $this->input->post('kolom')
            ];  

            $this->db->where('id_badan_saksi_prov',$id_data);
            $this->db->update('tb_badan_saksi_prov',$data);
        }
    }

    public function getDataKeanggotaanKab($id_kab)
    {
        $this->db->where('status', 1);
        $this->db->where('id_kab', $id_kab);
        return $this->db->get('tb_keanggotaan');
    }

    public function getDataKeanggotaanKec($id_kec)
    {
        $this->db->where('id_kec',$id_kec);

        return $this->db->get('tb_keanggotaan');
    }

    public function getDataKeanggotaanDesa($id_desa)
    {
        $this->db->where('id_desa',$id_desa);

        return $this->db->get('tb_keanggotaan');
    }

    public function getDataBsSk($id_func,$id_temp)
    {
        if($id_func == '1')
        {
            $this->db->where('id_prov',$id_temp);

            return $this->db->get('tb_badan_saksi_sk');
        }
        elseif($id_func == '2')
        {
            $this->db->where('tb_badan_saksi_sk.id_kab',$id_temp);

            return $this->db->from('tb_badan_saksi_sk')
                ->join('wilayah_kab','tb_badan_saksi_sk.id_kab = wilayah_kab.id_kab')
                ->get();
        }
        elseif($id_func == '3')
        {
            $this->db->where('tb_badan_saksi_sk.id_kec',$id_temp);

            return $this->db->from('tb_badan_saksi_sk')
                ->join('wilayah_kec','tb_badan_saksi_sk.id_kec = wilayah_kec.id_kec')
                ->get();
        }
        elseif($id_func == '4')
        {
            $this->db->where('tb_badan_saksi_sk.id_desa',$id_temp);

            return $this->db->from('tb_badan_saksi_sk')
                ->join('wilayah_desa','tb_badan_saksi_sk.id_desa = wilayah_desa.id_desa')
                ->get();
        }
    }

    public function tambahDataSk($f_pendukung,$id_func)
    {
        if($id_func == '1')
        {
            $data = [
                'no_sk'         => $this->input->post('no_sk'),
                'tanggal'       => $this->input->post('tanggal_sk'),
                'scan_sk'       => $f_pendukung,
                'id_prov'       => $this->input->post('temp')
            ];
    
            $this->db->insert('tb_badan_saksi_sk',$data);
        }
        elseif($id_func == '2')
        {
            $data = [
                'no_sk'         => $this->input->post('no_sk'),
                'tanggal'       => $this->input->post('tanggal_sk'),
                'scan_sk'       => $f_pendukung,
                'id_kab'        => $this->input->post('temp')
            ];
    
            $this->db->insert('tb_badan_saksi_sk',$data);
        }
        elseif($id_func == '3')
        {
            $data = [
                'no_sk'         => $this->input->post('no_sk'),
                'tanggal'       => $this->input->post('tanggal_sk'),
                'scan_sk'       => $f_pendukung,
                'id_kec'        => $this->input->post('temp')
            ];
    
            $this->db->insert('tb_badan_saksi_sk',$data);
        }
        elseif($id_func == '4')
        {
            $data = [
                'no_sk'         => $this->input->post('no_sk'),
                'tanggal'       => $this->input->post('tanggal_sk'),
                'scan_sk'       => $f_pendukung,
                'id_desa'       => $this->input->post('temp')
            ];
    
            $this->db->insert('tb_badan_saksi_sk',$data);
        }
    }

    public function getDataBsSkById($id_data,$id_func)
    {
        $this->db->where('id_badan_saksi_sk',$id_data);

        if($id_func == '1')
        {
            return $this->db->from('tb_badan_saksi_sk')
                ->join('wilayah_prov','tb_badan_saksi_sk.id_prov = wilayah_prov.id_prov')
                ->get();
        }
        elseif($id_func == '2')
        {
            return $this->db->from('tb_badan_saksi_sk')
                ->join('wilayah_kab','tb_badan_saksi_sk.id_kab = wilayah_kab.id_kab')
                ->get();
        }
        elseif($id_func == '3')
        {
            return $this->db->from('tb_badan_saksi_sk')
                ->join('wilayah_kec','tb_badan_saksi_sk.id_kec = wilayah_kec.id_kec')
                ->get();
        }
        elseif($id_func == '4')
        {
            return $this->db->from('tb_badan_saksi_sk')
                ->join('wilayah_desa','tb_badan_saksi_sk.id_desa = wilayah_desa.id_desa')
                ->get();
        }
    }

    public function editBsSk($id_data,$id_func,$f_pendukung)
    {
        if($id_func == '1')
        {
            $data = [
                'no_sk'         => $this->input->post('no_sk'),
                'tanggal'       => $this->input->post('tanggal_sk'),
                'scan_sk'       => $f_pendukung,
                'id_prov'       => $this->input->post('temp')
            ];
        }
        elseif($id_func == '2')
        {
            $data = [
                'no_sk'         => $this->input->post('no_sk'),
                'tanggal'       => $this->input->post('tanggal_sk'),
                'scan_sk'       => $f_pendukung,
                'id_kab'        => $this->input->post('temp')
            ];
        }
        elseif($id_func == '3')
        {
            $data = [
                'no_sk'         => $this->input->post('no_sk'),
                'tanggal'       => $this->input->post('tanggal_sk'),
                'scan_sk'       => $f_pendukung,
                'id_kec'        => $this->input->post('temp')
            ];
        }
        elseif($id_func == '4')
        {
            $data = [
                'no_sk'         => $this->input->post('no_sk'),
                'tanggal'       => $this->input->post('tanggal_sk'),
                'scan_sk'       => $f_pendukung,
                'id_desa'       => $this->input->post('temp')
            ];
        }

        $this->db->where('id_badan_saksi_sk',$id_data);
        $this->db->update('tb_badan_saksi_sk',$data);
    }
}

?>