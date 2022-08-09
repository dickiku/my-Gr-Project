<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Pilpres extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        
        $user = $this->session->userdata('userdata');
        if($user['level'] != 'Admin' && $user['level'] != 'Super Admin')
        {
            redirect('admin/auth');
        }
    }
    
    public function index()
    {
        $data = [
            'title'     => 'Data Pemilu - PILPRES',
            'aktif'     => 'pilpres',
            'periode'   => $this->Pilpres_model->getDataPeriode()->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilpres/index',$data);
		$this->load->view('templates/footer');
    }

    public function detailPeriode($id_periode)
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];
        
        $data = [
            'title'     => 'Data Pemilu - PILPRES',
            'aktif'     => 'pilpres',
            'wilayah'   => $this->Pilpres_model->getDataWilayahKabJateng()->result(),
            'wilayahById'   => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result()
        ];

        $id_periode = $this->uri->segment(3);
        $this->session->set_userdata('id_periode', $id_periode);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilpres/detailPeriode',$data);
		$this->load->view('templates/footer');
    }

    public function dpt_hak_pilih_kabupaten($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'         => 'Data Pemilu - PILPRES',
            'aktif'         => 'pilpres',
            'data'          => $this->Pilpres_model->getDataJumlahPemilihKabupatenByPeriode($id_kab,$id_periode)->result_array(),
            'periode'       => $this->Pilpres_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pilpres_model->getDataWilayahKabById($id_kab)->result_array(),
        ];

        $id_kab = $this->uri->segment(3);
        $this->session->set_userdata('id_kab', $id_kab);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilpres/dpt_hak_pilih_kabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function tambahDptKabupaten_proses()
    {
        $id_kab = $this->session->userdata('id_kab');

        $this->_rulesJumlahPemilih();

        if($this->form_validation->run() == FALSE)
        {
            $this->dpt_hak_pilih_kabupaten($id_kab);
        }
        else
        {
            $this->Pilpres_model->tambahDptKabupaten();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pilpres/dpt_hak_pilih_kabupaten/'.$this->session->userdata('id_kab'));
        }
    }

    public function edit_pengguna_hak_pilih_kabupaten($id_jumlah_pemilih)
    {
        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');

        $data = [
            'title'         => 'Data Pemilu - PILPRES',
            'aktif'         => 'pilpres',
            'data'          => $this->Pilpres_model->getDataJumlahPemilihById($id_jumlah_pemilih)->result_array(),
            'periode'       => $this->Pilpres_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pilpres_model->getDataWilayahKabById($id_kab)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilpres/edit_pengguna_hak_pilih_kabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function edit_pengguna_hak_pilih_kabupaten_proses($id_jumlah_pemilih)
    {
        $this->_rulesJumlahPemilih();

        if($this->form_validation->run() == FALSE)
        {
            $this->edit_pengguna_hak_pilih_kabupaten($id_jumlah_pemilih);
        }
        else
        {
            $this->Pilpres_model->editJumlahPemilih($id_jumlah_pemilih);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pilpres/dpt_hak_pilih_kabupaten/'.$this->session->userdata('id_kab'));
        }
    }

    public function hasil_pilpres_kabupaten($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'         => 'Data Pemilu - PILPRES',
            'aktif'         => 'pilpres',
            'data'          => $this->Pilpres_model->getDataHasilPilpresKabupaten($id_kab,$id_periode)->result_array(),
            'capres'        => $this->Pilpres_model->getDataCapresByPeriode($id_periode)->result_array(),
            'periode'       => $this->Pilpres_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pilpres_model->getDataWilayahKabById($id_kab)->result_array(),
        ];

        $id_kab = $this->uri->segment(3);
        $this->session->set_userdata('id_kab', $id_kab);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilpres/hasil_pilpres_kabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_hasil_pilpres_kabupaten_proses()
    {
        $id_kab = $this->session->userdata('id_kab');

        $this->_rulesHasilPilpres();

        if($this->form_validation->run() == FALSE)
        {
            $this->hasil_pilpres_kabupaten($id_kab);
        }
        else
        {
            $this->Pilpres_model->tambahHasilPemiluKabupaten();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pilpres/hasil_pilpres_kabupaten/'.$this->session->userdata('id_kab'));
        }
    }

    public function editHasilPilpresKabupaten($id_hasil_pilpres)
    {
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'     => 'Data Pemilu - PILPRES',
            'aktif'     => 'pilpres',
            'data'      => $this->Pilpres_model->getDataHasilPilpresById($id_hasil_pilpres)->result_array(),
            'capres'    => $this->Pilpres_model->getDataCapresByPeriode($id_periode)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilpres/editHasilPilpresKabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function editHasilPilpresKabupaten_proses($id_hasil_pilpres)
    {
        $this->_rulesEditHasilPilpres();

        if($this->form_validation->run() == FALSE)
        {
            $this->editHasilPilpresKabupaten($id_hasil_pilpres);
        }
        else
        {
            $this->Pilpres_model->editHasilPemilu($id_hasil_pilpres);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pilpres/hasil_pilpres_kabupaten/'.$this->session->userdata('id_kab'));
        }
    }

    public function hapusHasilPilpresKabupaten($id_hasil_pilpres)
    {
        $this->db->where('id_hasil_pilpres',$id_hasil_pilpres);
        $this->db->delete('tb_hasil_pilpres');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Dihapus.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
        redirect('pilpres/hasil_pilpres_kabupaten/'.$this->session->userdata('id_kab'));
    }

    //========================KECAMATAN============================//

    public function detailKecamatan($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Data Pemilu - PILPRES',
            'aktif'         => 'pilpres',
            'wilayahKec'    => $this->Pilpres_model->getDataKecamatanByIdKab($id_kab)->result(),
        ];

        $id_kab = $this->uri->segment(3);
        $this->session->set_userdata('id_kab', $id_kab);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilpres/detailKecamatan',$data);
		$this->load->view('templates/footer');
    }

    public function dpt_hak_pilih_kecamatan($id_kec)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_kec,0,-3);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');

        $data = [
            'title'         => 'Data Pemilu - PILPRES',
            'aktif'         => 'pilpres',
            'data'          => $this->Pilpres_model->getDataJumlahPemilihKecamatanByPeriode($id_kec,$id_periode)->result_array(),
            'periode'       => $this->Pilpres_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pilpres_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pilpres_model->getDataWilayahKecById($id_kec)->result_array(),
        ];

        $id_kec = $this->uri->segment(3);
        $this->session->set_userdata('id_kec', $id_kec);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilpres/dpt_hak_pilih_kecamatan',$data);
		$this->load->view('templates/footer');
    }

    public function tambahDptKecamatan_proses()
    {
        $id_kec = $this->session->userdata('id_kec');

        $this->_rulesJumlahPemilih();

        if($this->form_validation->run() == FALSE)
        {
            $this->dpt_hak_pilih_kecamatan($id_kec);
        }
        else
        {
            $this->Pilpres_model->tambahDptKecamatan();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pilpres/dpt_hak_pilih_kecamatan/'.$this->session->userdata('id_kec'));
        }
    }

    public function edit_pengguna_hak_pilih_kecamatan($id_jumlah_pemilih)
    {
        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');
        $id_kec     = $this->session->userdata('id_kec');

        $data = [
            'title'         => 'Data Pemilu - PILPRES',
            'aktif'         => 'pilpres',
            'data'          => $this->Pilpres_model->getDataJumlahPemilihById($id_jumlah_pemilih)->result_array(),
            'periode'       => $this->Pilpres_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pilpres_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pilpres_model->getDataWilayahKecById($id_kec)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilpres/edit_pengguna_hak_pilih_kecamatan',$data);
		$this->load->view('templates/footer');
    }

    public function edit_pengguna_hak_pilih_kecamatan_proses($id_jumlah_pemilih)
    {
        $this->_rulesJumlahPemilih();

        if($this->form_validation->run() == FALSE)
        {
            $this->edit_pengguna_hak_pilih_kecamatan($id_jumlah_pemilih);
        }
        else
        {
            $this->Pilpres_model->editJumlahPemilih($id_jumlah_pemilih);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pilpres/dpt_hak_pilih_kecamatan/'.$this->session->userdata('id_kec'));
        }
    }

    public function hasil_pilpres_kecamatan($id_kec)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_kec,0,-3);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');

        $data = [
            'title'         => 'Data Pemilu - PILPRES',
            'aktif'         => 'pilpres',
            'data'          => $this->Pilpres_model->getDataHasilPilpresKecamatan($id_kec,$id_periode)->result_array(),
            'capres'        => $this->Pilpres_model->getDataCapresByPeriode($id_periode)->result_array(),
            'periode'       => $this->Pilpres_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pilpres_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pilpres_model->getDataWilayahKecById($id_kec)->result_array(),
        ];

        $id_kec = $this->uri->segment(3);
        $this->session->set_userdata('id_kec', $id_kec);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilpres/hasil_pilpres_kecamatan',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_hasil_pilpres_kecamatan_proses()
    {
        $id_kec = $this->session->userdata('id_kec');

        $this->_rulesHasilPilpres();

        if($this->form_validation->run() == FALSE)
        {
            $this->hasil_pilpres_kecamatan($id_kec);
        }
        else
        {
            $this->Pilpres_model->tambahHasilPemiluKecamatan();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pilpres/hasil_pilpres_kecamatan/'.$this->session->userdata('id_kec'));
        }
    }

    public function editHasilPilpresKecamatan($id_hasil_pilpres)
    {
        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');
        $id_kec     = $this->session->userdata('id_kec');

        $data = [
            'title'         => 'Data Pemilu - PILPRES',
            'aktif'         => 'pilpres',
            'data'          => $this->Pilpres_model->getDataHasilPilpresById2($id_hasil_pilpres)->result_array(),
            'capres'        => $this->Pilpres_model->getDataCapresByPeriode($id_periode)->result_array(),
            'wilayahKab'    => $this->Pilpres_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pilpres_model->getDataWilayahKecById($id_kec)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilpres/editHasilPilpresKecamatan',$data);
		$this->load->view('templates/footer');
    }

    public function editHasilPilpresKecamatan_proses($id_hasil_pilpres)
    {
        $this->_rulesEditHasilPilpres();

        if($this->form_validation->run() == FALSE)
        {
            $this->editHasilPilpresKecamatan($id_hasil_pilpres);
        }
        else
        {
            $this->Pilpres_model->editHasilPemilu($id_hasil_pilpres);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pilpres/hasil_pilpres_kecamatan/'.$this->session->userdata('id_kec'));
        }
    }

    public function hapusHasilPilpresKecamatan($id_hasil_pilpres)
    {
        $this->db->where('id_hasil_pilpres',$id_hasil_pilpres);
        $this->db->delete('tb_hasil_pilpres');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Dihapus.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
        redirect('pilpres/hasil_pilpres_kecamatan/'.$this->session->userdata('id_kec'));
    }

    //=======================DESA============================//

    public function detailDesa($id_kec)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_kec,0,-3);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Data Pemilu - PILPRES',
            'aktif'         => 'pilpres',
            'wilayahKec'    => $this->Pilpres_model->getDataDesaByIdKec($id_kec)->result(),
        ];

        $id_kec = $this->uri->segment(3);
        $this->session->set_userdata('id_kec', $id_kec);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilpres/detailDesa',$data);
		$this->load->view('templates/footer');
    }

    public function dpt_hak_pilih_desa($id_desa)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_desa,0,-8);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');
        $id_kec     = $this->session->userdata('id_kec');

        $data = [
            'title'         => 'Data Pemilu - PILPRES',
            'aktif'         => 'pilpres',
            'data'          => $this->Pilpres_model->getDataJumlahPemilihDesaByPeriode($id_desa,$id_periode)->result_array(),
            'periode'       => $this->Pilpres_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pilpres_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pilpres_model->getDataWilayahKecById($id_kec)->result_array(),
            'wilayahDesa'   => $this->Pilpres_model->getDataWilayahDesaById($id_desa)->result_array(),
        ];

        $id_desa = $this->uri->segment(3);
        $this->session->set_userdata('id_desa', $id_desa);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilpres/dpt_hak_pilih_desa',$data);
		$this->load->view('templates/footer');
    }

    public function tambahDptDesa_proses()
    {
        $id_desa = $this->session->userdata('id_desa');

        $this->_rulesJumlahPemilih();

        if($this->form_validation->run() == FALSE)
        {
            $this->dpt_hak_pilih_desa($id_desa);
        }
        else
        {
            $this->Pilpres_model->tambahDptDesa();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pilpres/dpt_hak_pilih_desa/'.$this->session->userdata('id_desa'));
        }
    }

    public function edit_pengguna_hak_pilih_desa($id_jumlah_pemilih)
    {
        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');
        $id_kec     = $this->session->userdata('id_kec');
        $id_desa    = $this->session->userdata('id_desa');

        $data = [
            'title'         => 'Data Pemilu - PILPRES',
            'aktif'         => 'pilpres',
            'data'          => $this->Pilpres_model->getDataJumlahPemilihById($id_jumlah_pemilih)->result_array(),
            'periode'       => $this->Pilpres_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pilpres_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pilpres_model->getDataWilayahKecById($id_kec)->result_array(),
            'wilayahDesa'   => $this->Pilpres_model->getDataWilayahDesaById($id_desa)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilpres/edit_pengguna_hak_pilih_desa',$data);
		$this->load->view('templates/footer');
    }

    public function edit_pengguna_hak_pilih_desa_proses($id_jumlah_pemilih)
    {
        $this->_rulesJumlahPemilih();

        if($this->form_validation->run() == FALSE)
        {
            $this->edit_pengguna_hak_pilih_desa($id_jumlah_pemilih);
        }
        else
        {
            $this->Pilpres_model->editJumlahPemilih($id_jumlah_pemilih);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pilpres/dpt_hak_pilih_desa/'.$this->session->userdata('id_desa'));
        }
    }

    public function hasil_pilpres_desa($id_desa)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_desa,0,-8);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }
        
        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');
        $id_kec     = $this->session->userdata('id_kec');

        $data = [
            'title'         => 'Data Pemilu - PILPRES',
            'aktif'         => 'pilpres',
            'data'          => $this->Pilpres_model->getDataHasilPilpresDesa($id_desa,$id_periode)->result_array(),
            'capres'        => $this->Pilpres_model->getDataCapresByPeriode($id_periode)->result_array(),
            'periode'       => $this->Pilpres_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pilpres_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pilpres_model->getDataWilayahKecById($id_kec)->result_array(),
            'wilayahDesa'   => $this->Pilpres_model->getDataWilayahDesaById($id_desa)->result_array(),
        ];

        $id_desa = $this->uri->segment(3);
        $this->session->set_userdata('id_desa', $id_desa);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilpres/hasil_pilpres_desa',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_hasil_pilpres_desa_proses()
    {
        $id_desa = $this->session->userdata('id_desa');

        $this->_rulesHasilPilpres();

        if($this->form_validation->run() == FALSE)
        {
            $this->hasil_pilpres_desa($id_desa);
        }
        else
        {
            $this->Pilpres_model->tambahHasilPemiluDesa();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pilpres/hasil_pilpres_desa/'.$this->session->userdata('id_desa'));
        }
    }

    public function editHasilPilpresDesa($id_hasil_pilpres)
    {
        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');
        $id_kec     = $this->session->userdata('id_kec');
        $id_desa    = $this->session->userdata('id_desa');

        $data = [
            'title'         => 'Data Pemilu - PILPRES',
            'aktif'         => 'pilpres',
            'data'          => $this->Pilpres_model->getDataHasilPilpresById2($id_hasil_pilpres)->result_array(),
            'capres'        => $this->Pilpres_model->getDataCapresByPeriode($id_periode)->result_array(),
            'wilayahKab'    => $this->Pilpres_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pilpres_model->getDataWilayahKecById($id_kec)->result_array(),
            'wilayahDesa'   => $this->Pilpres_model->getDataWilayahDesaById($id_desa)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilpres/editHasilPilpresDesa',$data);
		$this->load->view('templates/footer');
    }

    public function editHasilPilpresDesa_proses($id_hasil_pilpres)
    {
        $this->_rulesEditHasilPilpres();

        if($this->form_validation->run() == FALSE)
        {
            $this->editHasilPilpresDesa($id_hasil_pilpres);
        }
        else
        {
            $this->Pilpres_model->editHasilPemilu($id_hasil_pilpres);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pilpres/hasil_pilpres_desa/'.$this->session->userdata('id_desa'));
        }
    }

    public function hapusHasilPilpresDesa($id_hasil_pilpres)
    {
        $this->db->where('id_hasil_pilpres',$id_hasil_pilpres);
        $this->db->delete('tb_hasil_pilpres');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Dihapus.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
        redirect('pilpres/hasil_pilpres_desa/'.$this->session->userdata('id_desa'));
    }

    public function _rulesJumlahPemilih()
    {
        $this->form_validation->set_rules('dpt', 'DPT', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> DPT wajib diisi'
        ]);
        
        $this->form_validation->set_rules('pengguna_hak_pilih', 'Pengguna Hak Pilih', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Pengguna Hak Pilih wajib diisi'
        ]);
    }

    public function _rulesHasilPilpres()
    {
        $this->form_validation->set_rules('capres', 'Capres & Wapres', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Capres & Wapres wajib diisi'
        ]);
        
        $this->form_validation->set_rules('perolehan', 'Perolehan Suara', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Perolehan Suara wajib diisi'
        ]);
    }
    
    public function _rulesEditHasilPilpres()
    {
        
        $this->form_validation->set_rules('perolehan', 'Perolehan Suara', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Perolehan Suara wajib diisi'
        ]);
    }
}