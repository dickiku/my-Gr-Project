<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Sayap_partai_model extends CI_Model{

    public function getDataSayapPartai()
    {
        $q = $this->db->query("SELECT * FROM tb_sayap_partai");

        return $q;
    }

    public function getDataWilayahProvById($id_sayap_partai)
    {
        $q = $this->db->query("SELECT * FROM tb_pengurus_sayap_partai WHERE id_sayap_partai = '$id_sayap_partai' AND id_prov = '33'");

        return $q;
    }

    public function getDataWilayahKabById($id_kab, $id_sayap_partai)
    {
        $q = $this->db->query("SELECT * FROM tb_pengurus_sayap_partai WHERE id_sayap_partai = '$id_sayap_partai' AND id_kab = '$id_kab'");

        return $q;
    }

    public function getDataWilayahKecById($id_kec, $id_sayap_partai)
    {
        $q = $this->db->query("SELECT * FROM tb_pengurus_sayap_partai WHERE id_sayap_partai = '$id_sayap_partai' AND id_kec = '$id_kec'");

        return $q;
    }

    public function getDataKabupatenById($id_kab)
    {
        $this->db->where('id_kab', $id_kab);
        return $this->db->get('wilayah_kab');
    }

    public function getDataKecamatanById($id_kab)
    {
        $this->db->where('id_kab', $id_kab);
        return $this->db->get('wilayah_kec');
    }

    public function getDataKecamatanByIdKec($id_kec)
    {
        $this->db->where('id_kec', $id_kec);
        return $this->db->get('wilayah_kec');
    }

    public function getDataSayapPartaiById($id_sayap_partai)
    {
        $q = $this->db->query("SELECT * FROM tb_sayap_partai WHERE id_sayap_partai = '$id_sayap_partai'");

        return $q;
    }

    public function getDataKepengurusanSayapPartaibyId($id_sayap_partai)
    {
        $q = $this->db->query("SELECT tb_pengurus_sayap_partai.*, tb_jabatan.*, tb_keanggotaan.*, tb_sayap_partai.*, wilayah_prov.*
                                FROM tb_pengurus_sayap_partai
                                JOIN tb_jabatan ON tb_pengurus_sayap_partai.id_jabatan = tb_jabatan.id_jabatan
                                JOIN tb_keanggotaan ON tb_pengurus_sayap_partai.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                                JOIN tb_sayap_partai ON tb_pengurus_sayap_partai.id_sayap_partai = tb_sayap_partai.id_sayap_partai
                                JOIN wilayah_prov ON tb_pengurus_sayap_partai.id_prov = wilayah_prov.id_prov
                                WHERE tb_pengurus_sayap_partai.id_prov = '33' AND tb_pengurus_sayap_partai.id_sayap_partai = '$id_sayap_partai'
                                ");

        return $q;
    }

    public function getDataKepengurusanSayapPartaibyIdKab($id_kab, $id_sayap_partai)
    {
        $q = $this->db->query("SELECT tb_pengurus_sayap_partai.*, tb_jabatan.*, tb_keanggotaan.*, tb_sayap_partai.*, wilayah_kab.*
                                FROM tb_pengurus_sayap_partai
                                JOIN tb_jabatan ON tb_pengurus_sayap_partai.id_jabatan = tb_jabatan.id_jabatan
                                JOIN tb_keanggotaan ON tb_pengurus_sayap_partai.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                                JOIN tb_sayap_partai ON tb_pengurus_sayap_partai.id_sayap_partai = tb_sayap_partai.id_sayap_partai
                                JOIN wilayah_kab ON tb_pengurus_sayap_partai.id_kab = wilayah_kab.id_kab
                                WHERE tb_pengurus_sayap_partai.id_kab = '$id_kab' AND tb_pengurus_sayap_partai.id_sayap_partai = '$id_sayap_partai'
                                ");

        return $q;
    }

    public function getDataKepengurusanSayapPartaibyIdKec($id_kec, $id_sayap_partai)
    {
        $q = $this->db->query("SELECT tb_pengurus_sayap_partai.*, tb_jabatan.*, tb_keanggotaan.*, tb_sayap_partai.*, wilayah_kec.*
                                FROM tb_pengurus_sayap_partai
                                JOIN tb_jabatan ON tb_pengurus_sayap_partai.id_jabatan = tb_jabatan.id_jabatan
                                JOIN tb_keanggotaan ON tb_pengurus_sayap_partai.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                                JOIN tb_sayap_partai ON tb_pengurus_sayap_partai.id_sayap_partai = tb_sayap_partai.id_sayap_partai
                                JOIN wilayah_kec ON tb_pengurus_sayap_partai.id_kec = wilayah_kec.id_kec
                                WHERE tb_pengurus_sayap_partai.id_kec = '$id_kec' AND tb_pengurus_sayap_partai.id_sayap_partai = '$id_sayap_partai'
                                ");
        return $q;
    }

    public function tambahDataKepengurusanProvinsi()
    {
        $id_keanggotaan = $this->input->post('keanggotaan');
        
        $data = [
            'id_keanggotaan'    => $this->input->post('keanggotaan'),
            'kolom'             => $this->input->post('kolom'),
            'id_jabatan'        => $this->input->post('jabatan'),
            'id_sayap_partai'   => $this->input->post('id_sayap_partai'),
            'id_prov'           => $this->input->post('id_prov'),
        ];

        $query = $this->db->where('id_keanggotaan', $id_keanggotaan)
                            ->where('status', 1)
                            ->get('tb_keanggotaan');

        if($query->num_rows() > 0)
        {
            $this->db->insert('tb_pengurus_sayap_partai',$data);

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

    public function tambahDataKepengurusanKabupaten()
    {
        $id_keanggotaan = $this->input->post('keanggotaan');

        $data = [
            'id_keanggotaan'    => $this->input->post('keanggotaan'),
            'kolom'             => $this->input->post('kolom'),
            'id_jabatan'        => $this->input->post('jabatan'),
            'id_sayap_partai'   => $this->input->post('id_sayap_partai'),
            'id_kab'            => $this->input->post('id_kab'),
        ];

        $query = $this->db->where('id_keanggotaan', $id_keanggotaan)
                            ->where('status', 1)
                            ->get('tb_keanggotaan');

        if($query->num_rows() > 0)
        {
            $this->db->insert('tb_pengurus_sayap_partai',$data);

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

    public function tambahDataKepengurusanKecamatan()
    {
        $id_keanggotaan = $this->input->post('keanggotaan');

        $data = [
            'id_keanggotaan'    => $this->input->post('keanggotaan'),
            'kolom'             => $this->input->post('kolom'),
            'id_jabatan'        => $this->input->post('jabatan'),
            'id_sayap_partai'   => $this->input->post('id_sayap_partai'),
            'id_kec'            => $this->input->post('id_kec'),
        ];

        $query = $this->db->where('id_keanggotaan', $id_keanggotaan)
                            ->where('status', 1)
                            ->get('tb_keanggotaan');

        if($query->num_rows() > 0)
        {
            $this->db->insert('tb_pengurus_sayap_partai',$data);

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

    public function getDataPengurusSayapPartaiById($id_pengurus_sayap_partai)
    {
        $q = $this->db->query("SELECT tb_pengurus_sayap_partai.*, tb_jabatan.*, tb_keanggotaan.*
                                FROM tb_pengurus_sayap_partai
                                JOIN tb_jabatan ON tb_pengurus_sayap_partai.id_jabatan = tb_jabatan.id_jabatan
                                JOIN tb_keanggotaan ON tb_pengurus_sayap_partai.id_keanggotaan = tb_keanggotaan.id_keanggotaan
                                WHERE tb_pengurus_sayap_partai.id_pengurus_sayap_partai='$id_pengurus_sayap_partai'");

        return $q;
    }

    public function editKepengurusan($id_pengurus_sayap_partai)
    {
        $data = [
            'id_keanggotaan'    => $this->input->post('id_keanggotaan'),
            'kolom'             => $this->input->post('kolom'),
            'id_jabatan'        => $this->input->post('jabatan'),
        ];

        $this->db->where('id_pengurus_sayap_partai', $id_pengurus_sayap_partai);
        $this->db->update('tb_pengurus_sayap_partai', $data);
    }

    ////============update baru untuk prov

    public function getDataSayapPartaiDomProv($id_prov, $id_sayap_partai)
    {
        $q = $this->db->query("SELECT tb_dom_sayap_partai.*, tb_sayap_partai.*
                                FROM tb_dom_sayap_partai
                                JOIN tb_sayap_partai ON tb_dom_sayap_partai.id_sayap_partai = tb_sayap_partai.id_sayap_partai
                                WHERE tb_dom_sayap_partai.id_prov = '$id_prov' AND tb_dom_sayap_partai.id_sayap_partai = '$id_sayap_partai'
                                ");
        return $q;
    }

    public function getDataSayapPartaiDomKab($id_kab, $id_sayap_partai)
    {
        $q = $this->db->query("SELECT tb_dom_sayap_partai.*, tb_sayap_partai.*
                                FROM tb_dom_sayap_partai
                                JOIN tb_sayap_partai ON tb_dom_sayap_partai.id_sayap_partai = tb_sayap_partai.id_sayap_partai
                                WHERE tb_dom_sayap_partai.id_kab = '$id_kab' AND tb_dom_sayap_partai.id_sayap_partai = '$id_sayap_partai'
                                ");
        return $q;
    }

    public function getDataSayapPartaiDomKec($id_kec,$id_sayap_partai)
    {
        $q = $this->db->query("SELECT tb_dom_sayap_partai.*, tb_sayap_partai.*
                                FROM tb_dom_sayap_partai
                                JOIN tb_sayap_partai ON tb_dom_sayap_partai.id_sayap_partai = tb_sayap_partai.id_sayap_partai
                                WHERE tb_dom_sayap_partai.id_kec = '$id_kec' AND tb_dom_sayap_partai.id_sayap_partai = '$id_sayap_partai'
                                ");
        return $q;
    }

    public function getDataSayapPartaiByIdPartai($id_sayap_partai)
    {
        $this->db->where('id_sayap_partai', $id_sayap_partai);
        return $this->db->get('tb_sayap_partai');
    }

    public function tambahDomSayapPartaiProv($foto,$scan)
    {
        $data = [
            'alamat'            => $this->input->post('alamat'),
            'no_telp'           => $this->input->post('no_telp'),
            'foto_kantor'       => $foto,
            'scan_sk'           => $scan,
            'id_prov'           => $this->input->post('id_prov'),
            'id_sayap_partai'   => $this->input->post('id_sayap_partai'),
        ];

        $this->db->insert('tb_dom_sayap_partai',$data);
    }

    public function tambahDomSayapPartaiKab($foto, $scan)
    {
        $data = [
            'alamat'            => $this->input->post('alamat'),
            'no_telp'           => $this->input->post('no_telp'),
            'foto_kantor'       => $foto,
            'scan_sk'           => $scan,
            'id_kab'            => $this->input->post('id_kab'),
            'id_sayap_partai'   => $this->input->post('id_sayap_partai'),
        ];

        $this->db->insert('tb_dom_sayap_partai',$data);
    }

    public function tambahDomSayapPartaiKec($foto, $scan)
    {
        $data = [
            'alamat'            => $this->input->post('alamat'),
            'no_telp'           => $this->input->post('no_telp'),
            'foto_kantor'       => $foto,
            'scan_sk'           => $scan,
            'id_kec'            => $this->input->post('id_kec'),
            'id_sayap_partai'   => $this->input->post('id_sayap_partai'),
        ];

        $this->db->insert('tb_dom_sayap_partai',$data);
    }

    public function editDomProv($id_dom_sayap_partai, $foto, $scan)
    {
        $data = [
            'alamat'            => $this->input->post('alamat'),
            'no_telp'           => $this->input->post('no_telp'),
            'foto_kantor'       => $foto,
            'scan_sk'           => $scan,
        ];

        $this->db->where('id_dom_sayap_partai', $id_dom_sayap_partai);
        $this->db->update('tb_dom_sayap_partai', $data);
    }

    public function editDomKab($id_dom_sayap_partai, $foto, $scan)
    {
        $data = [
            'alamat'            => $this->input->post('alamat'),
            'no_telp'           => $this->input->post('no_telp'),
            'foto_kantor'       => $foto,
            'scan_sk'           => $scan,
        ];

        $this->db->where('id_dom_sayap_partai', $id_dom_sayap_partai);
        $this->db->update('tb_dom_sayap_partai', $data);
    }

    public function editDomKec($id_dom_sayap_partai, $foto, $scan)
    {
        $data = [
            'alamat'            => $this->input->post('alamat'),
            'no_telp'           => $this->input->post('no_telp'),
            'foto_kantor'       => $foto,
            'scan_sk'           => $scan,
        ];  

        $this->db->where('id_dom_sayap_partai', $id_dom_sayap_partai);
        $this->db->update('tb_dom_sayap_partai', $data);
    }

    public function getDataDomSayapPartaiById($id_dom_sayap_partai)
    {
        $this->db->where('id_dom_sayap_partai',$id_dom_sayap_partai);
        return $this->db->get('tb_dom_sayap_partai');
    }

}