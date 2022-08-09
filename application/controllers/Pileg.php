<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Pileg extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        
        $user = $this->session->userdata('userdata');
        if($user['level'] != 'Admin' && $user['level'] != 'Super Admin')
        {
            redirect('admin/auth');
        }
    }
    
    // public function index()
    // {
    //     $data = [
    //         'title'     => 'Data Pemilu - PILEG',
    //         'aktif'     => 'pileg',
    //     ];

    //     $this->load->view('templates/header');
	// 	$this->load->view('templates/sidebar',$data);
	// 	$this->load->view('data_pemilu/pileg/index',$data);
	// 	$this->load->view('templates/footer');
    // }

    public function pileg_ri()
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Data Pemilu - PILEG RI',
            'aktif'     => 'pileg',
            'sub'       => 'pileg_ri',
            'periode'   => $this->Pileg_model->getDataPeriode()->result_array()
        ];

        $id_role = $this->uri->segment(3);
        $this->session->set_userdata('id_role', $id_role);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/pileg_ri',$data);
		$this->load->view('templates/footer');
    }

    public function detailPeriodeRi($id_periode)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Data Pemilu - PILEG RI',
            'aktif'     => 'pileg',
            'sub'       => 'pileg_ri',
            'wilayah'   => $this->Pileg_model->getDataWilayahKabJateng()->result()
        ];

        $id_periode = $this->uri->segment(3);
        $this->session->set_userdata('id_periode', $id_periode);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/detailPeriodeRi',$data);
		$this->load->view('templates/footer');
    }

    public function dpt_hak_pilih_kabupaten_ri($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_role    = $this->session->userdata('id_role');
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'         => 'Data Pemilu - PILEG RI',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_ri',
            'data'          => $this->Pileg_model->getDataJumlahPemilihPilegKabupatenByPeriodeRole($id_role,$id_periode,$id_kab)->result_array(),
            'periode'       => $this->Pileg_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
        ];

        $id_kab = $this->uri->segment(3);
        $this->session->set_userdata('id_kab', $id_kab);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/dpt_hak_pilih_kabupaten_ri',$data);
		$this->load->view('templates/footer');
    }

    public function tambahDptKabupatenRi_proses()
    {
        $id_kab = $this->session->userdata('id_kab');

        $this->_rulesJumlahPemilih();

        if($this->form_validation->run() == FALSE)
        {
            $this->dpt_hak_pilih_kabupaten_ri($id_kab);
        }
        else
        {
            $this->Pileg_model->tambahDptKabupatenRi();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/dpt_hak_pilih_kabupaten_ri/'.$this->session->userdata('id_kab'));
        }
    }

    public function edit_pengguna_hak_pilih_kabupaten_ri($id_jumlah_pemilih)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');

        $data = [
            'title'         => 'Data Pemilu - PILEG RI',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_ri',
            'data'          => $this->Pileg_model->getDataJumlahPemilihPilegById($id_jumlah_pemilih)->result_array(),
            'periode'       => $this->Pileg_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/edit_pengguna_hak_pilih_kabupaten_ri',$data);
		$this->load->view('templates/footer');
    }

    public function edit_pengguna_hak_pilih_kabupaten_ri_proses($id_jumlah_pemilih)
    {
        $this->_rulesJumlahPemilih();

        if($this->form_validation->run() == FALSE)
        {
            $this->edit_pengguna_hak_pilih_kabupaten_ri($id_jumlah_pemilih);
        }
        else
        {
            $this->Pileg_model->editJumlahPemilih($id_jumlah_pemilih);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/dpt_hak_pilih_kabupaten_ri/'.$this->session->userdata('id_kab'));
        }
    }

    public function hasil_pileg_kabupaten_ri($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_role    = $this->session->userdata('id_role');
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'         => 'Data Pemilu - PILEG RI',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_ri',
            'data'          => $this->Pileg_model->getDataHasilPilegKabupaten($id_kab,$id_periode,$id_role)->result_array(),
            'partai'        => $this->Pileg_model->getDataPartai()->result_array(),
            'periode'       => $this->Pileg_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
        ];

        $id_kab = $this->uri->segment(3);
        $this->session->set_userdata('id_kab', $id_kab);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/hasil_pileg_kabupaten_ri',$data);
        $this->load->view('templates/footer');
    }

    public function tambah_hasil_pileg_kabupaten_ri_proses()
    {        
        $id_kab = $this->session->userdata('id_kab');

        $this->_rulesHasilPileg();

        if($this->form_validation->run() == FALSE)
        {
            $this->hasil_pileg_kabupaten_ri($id_kab);
        }
        else
        {
            $this->Pileg_model->tambahHasilPilegKabupatenRi();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/hasil_pileg_kabupaten_ri/'.$this->session->userdata('id_kab'));
        }
    }

    public function editHasilPilegKabupatenRi($id_hasil_pileg)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Data Pemilu - PILEG RI',
            'aktif'     => 'pileg',
            'sub'       => 'pileg_ri',
            'data'      => $this->Pileg_model->getDataHasilPilegById($id_hasil_pileg)->result_array(),
            'partai'    => $this->Pileg_model->getDataPartai()->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/editHasilPilegKabupatenRi',$data);
		$this->load->view('templates/footer');
    }

    public function editHasilPilegKabupatenRi_proses($id_hasil_pileg)
    {
        $this->_rulesEditHasilPileg();

        if($this->form_validation->run() == FALSE)
        {
            $this->editHasilPilegKabupatenRi($id_hasil_pileg);
        }
        else
        {
            $this->Pileg_model->editHasilPileg($id_hasil_pileg);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/hasil_pileg_kabupaten_ri/'.$this->session->userdata('id_kab'));
        }
    }

    public function hapusHasilPilegKabupatenRi($id_hasil_pileg)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $this->db->where('id_hasil_pileg',$id_hasil_pileg);
        $this->db->delete('tb_hasil_pileg');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Dihapus.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
        redirect('pileg/hasil_pileg_kabupaten_ri/'.$this->session->userdata('id_kab'));
    }

    ///////////////////KECAMATAN////////////////////

    public function detailKecamatanRi($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Data Pemilu - PILEG RI',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_ri',
            'wilayahKec'    => $this->Pileg_model->getDataKecamatanByIdKab($id_kab)->result(),
        ];

        $id_kab = $this->uri->segment(3);
        $this->session->set_userdata('id_kab', $id_kab);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/detailKecamatanRi',$data);
		$this->load->view('templates/footer');
    }

    public function dpt_hak_pilih_kecamatan_ri($id_kec)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_role    = $this->session->userdata('id_role');
        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');

        $data = [
            'title'         => 'Data Pemilu - PILEG RI',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_ri',
            'data'          => $this->Pileg_model->getDataJumlahPemilihPilegKecamatanByPeriodeRole($id_role,$id_kec,$id_periode)->result_array(),
            'periode'       => $this->Pileg_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pileg_model->getDataWilayahKecById($id_kec)->result_array(),
        ];

        $id_kec = $this->uri->segment(3);
        $this->session->set_userdata('id_kec', $id_kec);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/dpt_hak_pilih_kecamatan_ri',$data);
		$this->load->view('templates/footer');
    }

    public function tambahDptKecamatanRi_proses()
    {
        $id_kec = $this->session->userdata('id_kec');

        $this->_rulesJumlahPemilih();

        if($this->form_validation->run() == FALSE)
        {
            $this->dpt_hak_pilih_kecamatan_ri($id_kec);
        }
        else
        {
            $this->Pileg_model->tambahDptKecamatanRi();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/dpt_hak_pilih_kecamatan_ri/'.$this->session->userdata('id_kec'));
        }
    }

    public function edit_pengguna_hak_pilih_kecamatan_ri($id_jumlah_pemilih)
    {
        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');
        $id_kec     = $this->session->userdata('id_kec');

        $data = [
            'title'         => 'Data Pemilu - PILEG RI',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_ri',
            'data'          => $this->Pileg_model->getDataJumlahPemilihPilegById($id_jumlah_pemilih)->result_array(),
            'periode'       => $this->Pileg_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pileg_model->getDataWilayahKecById($id_kec)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/edit_pengguna_hak_pilih_kecamatan_ri',$data);
		$this->load->view('templates/footer');
    }

    public function edit_pengguna_hak_pilih_kecamatan_ri_proses($id_jumlah_pemilih)
    {
        $this->_rulesJumlahPemilih();

        if($this->form_validation->run() == FALSE)
        {
            $this->edit_pengguna_hak_pilih_kecamatan_ri($id_jumlah_pemilih);
        }
        else
        {
            $this->Pileg_model->editJumlahPemilih($id_jumlah_pemilih);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/dpt_hak_pilih_kecamatan_ri/'.$this->session->userdata('id_kec'));
        }
    }

    public function hasil_pileg_kecamatan_ri($id_kec)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_role    = $this->session->userdata('id_role');
        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');

        $data = [
            'title'         => 'Data Pemilu - PILEG RI',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_ri',
            'data'          => $this->Pileg_model->getDataHasilPilegKecamatan($id_kec,$id_periode,$id_role)->result_array(),
            'partai'        => $this->Pileg_model->getDataPartai()->result_array(),
            'periode'       => $this->Pileg_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pileg_model->getDataWilayahKecById($id_kec)->result_array(),
        ];

        $id_kec = $this->uri->segment(3);
        $this->session->set_userdata('id_kec', $id_kec);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/hasil_pileg_kecamatan_ri',$data);
        $this->load->view('templates/footer');
    }

    public function tambah_hasil_pileg_kecamatan_ri_proses()
    {
        $id_kec = $this->session->userdata('id_kec');

        $this->_rulesHasilPileg();

        if($this->form_validation->run() == FALSE)
        {
            $this->hasil_pileg_kecamatan_ri($id_kec);
        }
        else
        {
            $this->Pileg_model->tambahHasilPilegKecamatanRi();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/hasil_pileg_kecamatan_ri/'.$this->session->userdata('id_kec'));
        }
    }

    public function editHasilPilegKecamatanRi($id_hasil_pileg)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_kab     = $this->session->userdata('id_kab');
        $id_kec     = $this->session->userdata('id_kec');

        $data = [
            'title'         => 'Data Pemilu - PILEG RI',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_ri',
            'data'          => $this->Pileg_model->getDataHasilPilegById2($id_hasil_pileg)->result_array(),
            'partai'        => $this->Pileg_model->getDataPartai()->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pileg_model->getDataWilayahKecById($id_kec)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/editHasilPilegKecamatanRi',$data);
		$this->load->view('templates/footer');
    }

    public function editHasilPilegKecamatanRi_proses($id_hasil_pileg)
    {
        $this->_rulesEditHasilPileg();

        if($this->form_validation->run() == FALSE)
        {
            $this->editHasilPilegKecamatanRi($id_hasil_pileg);
        }
        else
        {
            $this->Pileg_model->editHasilPileg($id_hasil_pileg);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/hasil_pileg_kecamatan_ri/'.$this->session->userdata('id_kec'));
        }
    }

    public function hapusHasilPilegKecamatanRi($id_hasil_pileg)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $this->db->where('id_hasil_pileg',$id_hasil_pileg);
        $this->db->delete('tb_hasil_pileg');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Dihapus.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
        redirect('pileg/hasil_pileg_kecamatan_ri/'.$this->session->userdata('id_kec'));
    }

    ///////////////////DESA////////////////////

    public function detailDesaRi($id_kec)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Data Pemilu - PILEG RI',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_ri',
            'wilayahDesa'   => $this->Pilpres_model->getDataDesaByIdKec($id_kec)->result(),
        ];

        $id_kec = $this->uri->segment(3);
        $this->session->set_userdata('id_kec', $id_kec);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/detailDesaRi',$data);
		$this->load->view('templates/footer');
    }

    public function dpt_hak_pilih_desa_ri($id_desa)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_role    = $this->session->userdata('id_role');
        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');
        $id_kec     = $this->session->userdata('id_kec');

        $data = [
            'title'         => 'Data Pemilu - PILEG RI',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_ri',
            'data'          => $this->Pileg_model->getDataJumlahPemilihPilegDesaByPeriodeRole($id_role,$id_desa,$id_periode)->result_array(),
            'periode'       => $this->Pileg_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pileg_model->getDataWilayahKecById($id_kec)->result_array(),
            'wilayahDesa'   => $this->Pileg_model->getDataWilayahDesaById($id_desa)->result_array(),
        ];

        $id_desa = $this->uri->segment(3);
        $this->session->set_userdata('id_desa', $id_desa);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/dpt_hak_pilih_desa_ri',$data);
		$this->load->view('templates/footer');
    }

    public function tambahDptDesaRi_proses()
    {
        $id_desa = $this->session->userdata('id_desa');

        $this->_rulesJumlahPemilih();

        if($this->form_validation->run() == FALSE)
        {
            $this->dpt_hak_pilih_desa_ri($id_desa);
        }
        else
        {
            $this->Pileg_model->tambahDptDesaRi();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/dpt_hak_pilih_desa_ri/'.$this->session->userdata('id_desa'));
        }
    }

    public function edit_pengguna_hak_pilih_desa_ri($id_jumlah_pemilih)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');
        $id_kec     = $this->session->userdata('id_kec');
        $id_desa    = $this->session->userdata('id_desa');

        $data = [
            'title'         => 'Data Pemilu - PILEG RI',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_ri',
            'data'          => $this->Pileg_model->getDataJumlahPemilihPilegById($id_jumlah_pemilih)->result_array(),
            'periode'       => $this->Pileg_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pileg_model->getDataWilayahKecById($id_kec)->result_array(),
            'wilayahDesa'   => $this->Pileg_model->getDataWilayahDesaById($id_desa)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/edit_pengguna_hak_pilih_desa_ri',$data);
		$this->load->view('templates/footer');
    }

    public function edit_pengguna_hak_pilih_desa_ri_proses($id_jumlah_pemilih)
    {
        $this->_rulesJumlahPemilih();

        if($this->form_validation->run() == FALSE)
        {
            $this->edit_pengguna_hak_pilih_desa_ri($id_jumlah_pemilih);
        }
        else
        {
            $this->Pileg_model->editJumlahPemilih($id_jumlah_pemilih);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/dpt_hak_pilih_desa_ri/'.$this->session->userdata('id_desa'));
        }
    }

    public function hasil_pileg_desa_ri($id_desa)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_role    = $this->session->userdata('id_role');
        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');
        $id_kec     = $this->session->userdata('id_kec');

        $data = [
            'title'         => 'Data Pemilu - PILEG RI',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_ri',
            'data'          => $this->Pileg_model->getDataHasilPilegDesa($id_desa,$id_periode,$id_role)->result_array(),
            'partai'        => $this->Pileg_model->getDataPartai()->result_array(),
            'periode'       => $this->Pileg_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pileg_model->getDataWilayahKecById($id_kec)->result_array(),
            'wilayahDesa'   => $this->Pileg_model->getDataWilayahDesaById($id_desa)->result_array(),
        ];

        $id_desa = $this->uri->segment(3);
        $this->session->set_userdata('id_desa', $id_desa);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/hasil_pileg_desa_ri',$data);
        $this->load->view('templates/footer');
    }

    public function tambah_hasil_pileg_desa_ri_proses()
    {
        $id_desa = $this->session->userdata('id_desa');

        $this->_rulesHasilPileg();

        if($this->form_validation->run() == FALSE)
        {
            $this->hasil_pileg_desa_ri($id_desa);
        }
        else
        {
            $this->Pileg_model->tambahHasilPilegDesaRi();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/hasil_pileg_desa_ri/'.$this->session->userdata('id_desa'));
        }
    }

    public function editHasilPilegDesaRi($id_hasil_pileg)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_kab     = $this->session->userdata('id_kab');
        $id_kec     = $this->session->userdata('id_kec');
        $id_desa    = $this->session->userdata('id_desa');

        $data = [
            'title'         => 'Data Pemilu - PILEG RI',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_ri',
            'data'          => $this->Pileg_model->getDataHasilPilegById2($id_hasil_pileg)->result_array(),
            'partai'        => $this->Pileg_model->getDataPartai()->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pileg_model->getDataWilayahKecById($id_kec)->result_array(),
            'wilayahDesa'   => $this->Pileg_model->getDataWilayahDesaById($id_desa)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/editHasilPilegDesaRi',$data);
		$this->load->view('templates/footer');
    }

    public function editHasilPilegDesaRi_proses($id_hasil_pileg)
    {
        $this->_rulesEditHasilPileg();

        if($this->form_validation->run() == FALSE)
        {
            $this->editHasilPilegDesaRi($id_hasil_pileg);
        }
        else
        {
            $this->Pileg_model->editHasilPileg($id_hasil_pileg);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/hasil_pileg_desa_ri/'.$this->session->userdata('id_desa'));
        }
    }

    public function hapusHasilPilegDesaRi($id_hasil_pileg)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $this->db->where('id_hasil_pileg',$id_hasil_pileg);
        $this->db->delete('tb_hasil_pileg');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Dihapus.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
        redirect('pileg/hasil_pileg_desa_ri/'.$this->session->userdata('id_desa'));
    }

    //=======================PROVINSI===========================//

    public function pileg_prov()
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Data Pemilu - PILEG Provinsi',
            'aktif'     => 'pileg',
            'sub'       => 'pileg_prov',
            'periode'   => $this->Pileg_model->getDataPeriode()->result_array()
        ];

        $id_role = $this->uri->segment(3);
        $this->session->set_userdata('id_role', $id_role);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/pileg_prov',$data);
		$this->load->view('templates/footer');
    }

    public function detailPeriodeProv($id_periode)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Data Pemilu - PILEG Provinsi',
            'aktif'     => 'pileg',
            'sub'       => 'pileg_prov',
            'wilayah'   => $this->Pileg_model->getDataWilayahKabJateng()->result()
        ];

        $id_periode = $this->uri->segment(3);
        $this->session->set_userdata('id_periode', $id_periode);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/detailPeriodeProv',$data);
		$this->load->view('templates/footer');
    }

    public function dpt_hak_pilih_kabupaten_prov($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_role    = $this->session->userdata('id_role');
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'         => 'Data Pemilu - PILEG Provinsi',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_prov',
            'data'          => $this->Pileg_model->getDataJumlahPemilihPilegKabupatenByPeriodeRole($id_role,$id_periode,$id_kab)->result_array(),
            'periode'       => $this->Pileg_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
        ];

        $id_kab = $this->uri->segment(3);
        $this->session->set_userdata('id_kab', $id_kab);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/dpt_hak_pilih_kabupaten_prov',$data);
		$this->load->view('templates/footer');
    }

    public function tambahDptKabupatenProv_proses()
    {
        $id_kab = $this->session->userdata('id_kab');

        $this->_rulesJumlahPemilih();

        if($this->form_validation->run() == FALSE)
        {
            $this->dpt_hak_pilih_kabupaten_prov($id_kab);
        }
        else
        {
            $this->Pileg_model->tambahDptKabupatenProv();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/dpt_hak_pilih_kabupaten_prov/'.$this->session->userdata('id_kab'));
        }
    }

    public function edit_pengguna_hak_pilih_kabupaten_prov($id_jumlah_pemilih)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');

        $data = [
            'title'         => 'Data Pemilu - PILEG Provinsi',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_prov',
            'data'          => $this->Pileg_model->getDataJumlahPemilihPilegById($id_jumlah_pemilih)->result_array(),
            'periode'       => $this->Pileg_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/edit_pengguna_hak_pilih_kabupaten_prov',$data);
		$this->load->view('templates/footer');
    }

    public function edit_pengguna_hak_pilih_kabupaten_prov_proses($id_jumlah_pemilih)
    {
        $this->_rulesJumlahPemilih();

        if($this->form_validation->run() == FALSE)
        {
            $this->edit_pengguna_hak_pilih_kabupaten_prov($id_jumlah_pemilih);
        }
        else
        {
            $this->Pileg_model->editJumlahPemilih($id_jumlah_pemilih);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/dpt_hak_pilih_kabupaten_prov/'.$this->session->userdata('id_kab'));
        }
    }

    public function hasil_pileg_kabupaten_prov($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_role    = $this->session->userdata('id_role');
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'         => 'Data Pemilu - PILEG Provinsi',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_prov',
            'data'          => $this->Pileg_model->getDataHasilPilegKabupaten($id_kab,$id_periode,$id_role)->result_array(),
            'partai'        => $this->Pileg_model->getDataPartai()->result_array(),
            'periode'       => $this->Pileg_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
        ];

        $id_kab = $this->uri->segment(3);
        $this->session->set_userdata('id_kab', $id_kab);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/hasil_pileg_kabupaten_prov',$data);
        $this->load->view('templates/footer');
    }

    public function tambah_hasil_pileg_kabupaten_prov_proses()
    {        
        $id_kab = $this->session->userdata('id_kab');

        $this->_rulesHasilPileg();

        if($this->form_validation->run() == FALSE)
        {
            $this->hasil_pileg_kabupaten_prov($id_kab);
        }
        else
        {
            $this->Pileg_model->tambahHasilPilegKabupatenProvinsi();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/hasil_pileg_kabupaten_prov/'.$this->session->userdata('id_kab'));
        }
    }

    public function editHasilPilegKabupatenProv($id_hasil_pileg)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Data Pemilu - PILEG Provinsi',
            'aktif'     => 'pileg',
            'sub'       => 'pileg_prov',
            'data'      => $this->Pileg_model->getDataHasilPilegById($id_hasil_pileg)->result_array(),
            'partai'    => $this->Pileg_model->getDataPartai()->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/editHasilPilegKabupatenProv',$data);
		$this->load->view('templates/footer');
    }

    public function editHasilPilegKabupatenProv_proses($id_hasil_pileg)
    {
        $this->_rulesEditHasilPileg();

        if($this->form_validation->run() == FALSE)
        {
            $this->editHasilPilegKabupatenProv($id_hasil_pileg);
        }
        else
        {
            $this->Pileg_model->editHasilPileg($id_hasil_pileg);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/hasil_pileg_kabupaten_prov/'.$this->session->userdata('id_kab'));
        }
    }

    public function hapusHasilPilegKabupatenProv($id_hasil_pileg)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $this->db->where('id_hasil_pileg',$id_hasil_pileg);
        $this->db->delete('tb_hasil_pileg');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Dihapus.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
        redirect('pileg/hasil_pileg_kabupaten_prov/'.$this->session->userdata('id_kab'));
    }

    ///////////////////KECAMATAN////////////////////

    public function detailKecamatanProv($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Data Pemilu - PILEG Provinsi',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_prov',
            'wilayahKec'    => $this->Pileg_model->getDataKecamatanByIdKab($id_kab)->result(),
        ];

        $id_kab = $this->uri->segment(3);
        $this->session->set_userdata('id_kab', $id_kab);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/detailKecamatanProv',$data);
		$this->load->view('templates/footer');
    }

    public function dpt_hak_pilih_kecamatan_prov($id_kec)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_role    = $this->session->userdata('id_role');
        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');

        $data = [
            'title'         => 'Data Pemilu - PILEG Provinsi',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_prov',
            'data'          => $this->Pileg_model->getDataJumlahPemilihPilegKecamatanByPeriodeRole($id_role,$id_kec,$id_periode)->result_array(),
            'periode'       => $this->Pileg_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pileg_model->getDataWilayahKecById($id_kec)->result_array(),
        ];

        $id_kec = $this->uri->segment(3);
        $this->session->set_userdata('id_kec', $id_kec);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/dpt_hak_pilih_kecamatan_prov',$data);
		$this->load->view('templates/footer');
    }

    public function tambahDptKecamatanProv_proses()
    {
        $id_kec = $this->session->userdata('id_kec');

        $this->_rulesJumlahPemilih();

        if($this->form_validation->run() == FALSE)
        {
            $this->dpt_hak_pilih_kecamatan_prov($id_kec);
        }
        else
        {
            $this->Pileg_model->tambahDptKecamatanProv();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/dpt_hak_pilih_kecamatan_prov/'.$this->session->userdata('id_kec'));
        }
    }

    public function edit_pengguna_hak_pilih_kecamatan_prov($id_jumlah_pemilih)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');
        $id_kec     = $this->session->userdata('id_kec');

        $data = [
            'title'         => 'Data Pemilu - PILEG Provinsi',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_prov',
            'data'          => $this->Pileg_model->getDataJumlahPemilihPilegById($id_jumlah_pemilih)->result_array(),
            'periode'       => $this->Pileg_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pileg_model->getDataWilayahKecById($id_kec)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/edit_pengguna_hak_pilih_kecamatan_prov',$data);
		$this->load->view('templates/footer');
    }

    public function edit_pengguna_hak_pilih_kecamatan_prov_proses($id_jumlah_pemilih)
    {
        $this->_rulesJumlahPemilih();

        if($this->form_validation->run() == FALSE)
        {
            $this->edit_pengguna_hak_pilih_kecamatan_prov($id_jumlah_pemilih);
        }
        else
        {
            $this->Pileg_model->editJumlahPemilih($id_jumlah_pemilih);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/dpt_hak_pilih_kecamatan_prov/'.$this->session->userdata('id_kec'));
        }
    }

    public function hasil_pileg_kecamatan_prov($id_kec)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_role    = $this->session->userdata('id_role');
        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');

        $data = [
            'title'         => 'Data Pemilu - PILEG Provinsi',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_prov',
            'data'          => $this->Pileg_model->getDataHasilPilegKecamatan($id_kec,$id_periode,$id_role)->result_array(),
            'partai'        => $this->Pileg_model->getDataPartai()->result_array(),
            'periode'       => $this->Pileg_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pileg_model->getDataWilayahKecById($id_kec)->result_array(),
        ];

        $id_kec = $this->uri->segment(3);
        $this->session->set_userdata('id_kec', $id_kec);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/hasil_pileg_kecamatan_prov',$data);
        $this->load->view('templates/footer');
    }

    public function tambah_hasil_pileg_kecamatan_prov_proses()
    {
        $id_kec = $this->session->userdata('id_kec');

        $this->_rulesHasilPileg();

        if($this->form_validation->run() == FALSE)
        {
            $this->hasil_pileg_kecamatan_prov($id_kec);
        }
        else
        {
            $this->Pileg_model->tambahHasilPilegKecamatanProvinsi();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/hasil_pileg_kecamatan_prov/'.$this->session->userdata('id_kec'));
        }
    }

    public function editHasilPilegKecamatanProvinsi($id_hasil_pileg)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_kab     = $this->session->userdata('id_kab');
        $id_kec     = $this->session->userdata('id_kec');

        $data = [
            'title'         => 'Data Pemilu - PILEG Provinsi',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_prov',
            'data'          => $this->Pileg_model->getDataHasilPilegById2($id_hasil_pileg)->result_array(),
            'partai'        => $this->Pileg_model->getDataPartai()->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pileg_model->getDataWilayahKecById($id_kec)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/editHasilPilegKecamatanProvinsi',$data);
		$this->load->view('templates/footer');
    }

    public function editHasilPilegKecamatanProv_proses($id_hasil_pileg)
    {
        $this->_rulesEditHasilPileg();

        if($this->form_validation->run() == FALSE)
        {
            $this->editHasilPilegKecamatanProvinsi($id_hasil_pileg);
        }
        else
        {
            $this->Pileg_model->editHasilPileg($id_hasil_pileg);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/hasil_pileg_kecamatan_prov/'.$this->session->userdata('id_kec'));
        }
    }

    public function hapusHasilPilegKecamatanProvinsi($id_hasil_pileg)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $this->db->where('id_hasil_pileg',$id_hasil_pileg);
        $this->db->delete('tb_hasil_pileg');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Dihapus.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
        redirect('pileg/hasil_pileg_kecamatan_prov/'.$this->session->userdata('id_kec'));
    }

    ///////////////////DESA////////////////////

    public function detailDesaProv($id_kec)
    {
        $data = [
            'title'         => 'Data Pemilu - PILEG Provinsi',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_prov',
            'wilayahDesa'   => $this->Pilpres_model->getDataDesaByIdKec($id_kec)->result(),
        ];

        $id_kec = $this->uri->segment(3);
        $this->session->set_userdata('id_kec', $id_kec);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/detailDesaProv',$data);
		$this->load->view('templates/footer');
    }

    public function dpt_hak_pilih_desa_prov($id_desa)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_role    = $this->session->userdata('id_role');
        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');
        $id_kec     = $this->session->userdata('id_kec');

        $data = [
            'title'         => 'Data Pemilu - PILEG Provinsi',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_prov',
            'data'          => $this->Pileg_model->getDataJumlahPemilihPilegDesaByPeriodeRole($id_role,$id_desa,$id_periode)->result_array(),
            'periode'       => $this->Pileg_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pileg_model->getDataWilayahKecById($id_kec)->result_array(),
            'wilayahDesa'   => $this->Pileg_model->getDataWilayahDesaById($id_desa)->result_array(),
        ];

        $id_desa = $this->uri->segment(3);
        $this->session->set_userdata('id_desa', $id_desa);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/dpt_hak_pilih_desa_prov',$data);
		$this->load->view('templates/footer');
    }

    public function tambahDptDesaProv_proses()
    {
        $id_desa = $this->session->userdata('id_desa');

        $this->_rulesJumlahPemilih();

        if($this->form_validation->run() == FALSE)
        {
            $this->dpt_hak_pilih_desa_prov($id_desa);
        }
        else
        {
            $this->Pileg_model->tambahDptDesaProv();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/dpt_hak_pilih_desa_prov/'.$this->session->userdata('id_desa'));
        }
    }

    public function edit_pengguna_hak_pilih_desa_prov($id_jumlah_pemilih)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');
        $id_kec     = $this->session->userdata('id_kec');
        $id_desa    = $this->session->userdata('id_desa');

        $data = [
            'title'         => 'Data Pemilu - PILEG Provinsi',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_prov',
            'data'          => $this->Pileg_model->getDataJumlahPemilihPilegById($id_jumlah_pemilih)->result_array(),
            'periode'       => $this->Pileg_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pileg_model->getDataWilayahKecById($id_kec)->result_array(),
            'wilayahDesa'   => $this->Pileg_model->getDataWilayahDesaById($id_desa)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/edit_pengguna_hak_pilih_desa_prov',$data);
		$this->load->view('templates/footer');
    }

    public function edit_pengguna_hak_pilih_desa_prov_proses($id_jumlah_pemilih)
    {
        $this->_rulesJumlahPemilih();

        if($this->form_validation->run() == FALSE)
        {
            $this->edit_pengguna_hak_pilih_desa_prov($id_jumlah_pemilih);
        }
        else
        {
            $this->Pileg_model->editJumlahPemilih($id_jumlah_pemilih);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/dpt_hak_pilih_desa_prov/'.$this->session->userdata('id_desa'));
        }
    }

    public function hasil_pileg_desa_prov($id_desa)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_role    = $this->session->userdata('id_role');
        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');
        $id_kec     = $this->session->userdata('id_kec');

        $data = [
            'title'         => 'Data Pemilu - PILEG Provinsi',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_prov',
            'data'          => $this->Pileg_model->getDataHasilPilegDesa($id_desa,$id_periode,$id_role)->result_array(),
            'partai'        => $this->Pileg_model->getDataPartai()->result_array(),
            'periode'       => $this->Pileg_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pileg_model->getDataWilayahKecById($id_kec)->result_array(),
            'wilayahDesa'   => $this->Pileg_model->getDataWilayahDesaById($id_desa)->result_array(),
        ];

        $id_desa = $this->uri->segment(3);
        $this->session->set_userdata('id_desa', $id_desa);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/hasil_pileg_desa_prov',$data);
        $this->load->view('templates/footer');
    }

    public function tambah_hasil_pileg_desa_prov_proses()
    {
        $id_desa = $this->session->userdata('id_desa');

        $this->_rulesHasilPileg();

        if($this->form_validation->run() == FALSE)
        {
            $this->hasil_pileg_desa_prov($id_desa);
        }
        else
        {
            $this->Pileg_model->tambahHasilPilegDesaProv();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/hasil_pileg_desa_prov/'.$this->session->userdata('id_desa'));
        }
    }

    public function editHasilPilegDesaProv($id_hasil_pileg)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_kab     = $this->session->userdata('id_kab');
        $id_kec     = $this->session->userdata('id_kec');
        $id_desa    = $this->session->userdata('id_desa');

        $data = [
            'title'         => 'Data Pemilu - PILEG Provinsi',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_prov',
            'data'          => $this->Pileg_model->getDataHasilPilegById2($id_hasil_pileg)->result_array(),
            'partai'        => $this->Pileg_model->getDataPartai()->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pileg_model->getDataWilayahKecById($id_kec)->result_array(),
            'wilayahDesa'   => $this->Pileg_model->getDataWilayahDesaById($id_desa)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/editHasilPilegDesaProv',$data);
		$this->load->view('templates/footer');
    }

    public function editHasilPilegDesaProv_proses($id_hasil_pileg)
    {
        $this->_rulesEditHasilPileg();

        if($this->form_validation->run() == FALSE)
        {
            $this->editHasilPilegDesaProv($id_hasil_pileg);
        }
        else
        {
            $this->Pileg_model->editHasilPileg($id_hasil_pileg);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/hasil_pileg_desa_prov/'.$this->session->userdata('id_desa'));
        }
    }

    public function hapusHasilPilegDesaProv($id_hasil_pileg)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }
        
        $this->db->where('id_hasil_pileg',$id_hasil_pileg);
        $this->db->delete('tb_hasil_pileg');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Dihapus.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
        redirect('pileg/hasil_pileg_desa_prov/'.$this->session->userdata('id_desa'));
    }

    //=====================KABUPATEN/KOTA=====================//

    public function pileg_kab()
    {
        $data = [
            'title'     => 'Data Pemilu - PILEG Kabupaten/Kota',
            'aktif'     => 'pileg',
            'sub'       => 'pileg_kab',
            'periode'   => $this->Pileg_model->getDataPeriode()->result_array()
        ];

        $id_role = $this->uri->segment(3);
        $this->session->set_userdata('id_role', $id_role);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/pileg_kab',$data);
		$this->load->view('templates/footer');
    }

    public function detailPeriodeKab($id_periode)
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];
        
        $data = [
            'title'         => 'Data Pemilu - PILEG Kabupaten/Kota',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_kab',
            'wilayah'       => $this->Pileg_model->getDataWilayahKabJateng()->result(),
            'wilayahById'   => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result()
        ];

        $id_periode = $this->uri->segment(3);
        $this->session->set_userdata('id_periode', $id_periode);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/detailPeriodeKab',$data);
		$this->load->view('templates/footer');
    }

    public function dpt_hak_pilih_kabupaten_kab($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_role    = $this->session->userdata('id_role');
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'         => 'Data Pemilu - PILEG Kabupaten/Kota',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_kab',
            'data'          => $this->Pileg_model->getDataJumlahPemilihPilegKabupatenByPeriodeRole($id_role,$id_periode,$id_kab)->result_array(),
            'periode'       => $this->Pileg_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
        ];

        $id_kab = $this->uri->segment(3);
        $this->session->set_userdata('id_kab', $id_kab);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/dpt_hak_pilih_kabupaten_kab',$data);
		$this->load->view('templates/footer');
    }

    public function tambahDptKabupatenKab_proses()
    {
        $id_kab = $this->session->userdata('id_kab');

        $this->_rulesJumlahPemilih();

        if($this->form_validation->run() == FALSE)
        {
            $this->dpt_hak_pilih_kabupaten_kab($id_kab);
        }
        else
        {
            $this->Pileg_model->tambahDptKabupatenKab();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/dpt_hak_pilih_kabupaten_kab/'.$this->session->userdata('id_kab'));
        }
    }

    public function edit_pengguna_hak_pilih_kabupaten_kab($id_jumlah_pemilih)
    {
        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');

        $data = [
            'title'         => 'Data Pemilu - PILEG Kabupaten/Kota',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_kab',
            'data'          => $this->Pileg_model->getDataJumlahPemilihPilegById($id_jumlah_pemilih)->result_array(),
            'periode'       => $this->Pileg_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/edit_pengguna_hak_pilih_kabupaten_kab',$data);
		$this->load->view('templates/footer');
    }

    public function edit_pengguna_hak_pilih_kabupaten_kab_proses($id_jumlah_pemilih)
    {
        $this->_rulesJumlahPemilih();

        if($this->form_validation->run() == FALSE)
        {
            $this->edit_pengguna_hak_pilih_kabupaten_kab($id_jumlah_pemilih);
        }
        else
        {
            $this->Pileg_model->editJumlahPemilih($id_jumlah_pemilih);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/dpt_hak_pilih_kabupaten_kab/'.$this->session->userdata('id_kab'));
        }
    }

    public function hasil_pileg_kabupaten_kab($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_role    = $this->session->userdata('id_role');
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'         => 'Data Pemilu - PILEG Kabupaten/Kota',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_kab',
            'data'          => $this->Pileg_model->getDataHasilPilegKabupaten($id_kab,$id_periode,$id_role)->result_array(),
            'partai'        => $this->Pileg_model->getDataPartai()->result_array(),
            'periode'       => $this->Pileg_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
        ];

        $id_kab = $this->uri->segment(3);
        $this->session->set_userdata('id_kab', $id_kab);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/hasil_pileg_kabupaten_kab',$data);
        $this->load->view('templates/footer');
    }

    public function tambah_hasil_pileg_kabupaten_kab_proses()
    {        
        $id_kab = $this->session->userdata('id_kab');

        $this->_rulesHasilPileg();

        if($this->form_validation->run() == FALSE)
        {
            $this->hasil_pileg_kabupaten_kab($id_kab);
        }
        else
        {
            $this->Pileg_model->tambahHasilPilegKabupatenKabupaten();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/hasil_pileg_kabupaten_kab/'.$this->session->userdata('id_kab'));
        }
    }

    public function editHasilPilegKabupatenKab($id_hasil_pileg)
    {

        $data = [
            'title'     => 'Data Pemilu - PILEG Kabupaten/Kota',
            'aktif'     => 'pileg',
            'sub'       => 'pileg_kab',
            'data'      => $this->Pileg_model->getDataHasilPilegById($id_hasil_pileg)->result_array(),
            'partai'    => $this->Pileg_model->getDataPartai()->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/editHasilPilegKabupatenKab',$data);
		$this->load->view('templates/footer');
    }

    public function editHasilPilegKabupatenKab_proses($id_hasil_pileg)
    {
        $this->_rulesEditHasilPileg();

        if($this->form_validation->run() == FALSE)
        {
            $this->editHasilPilegKabupatenKab($id_hasil_pileg);
        }
        else
        {
            $this->Pileg_model->editHasilPileg($id_hasil_pileg);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/hasil_pileg_kabupaten_kab/'.$this->session->userdata('id_kab'));
        }
    }

    public function hapusHasilPilegKabupatenKab($id_hasil_pileg)
    {
        $this->db->where('id_hasil_pileg',$id_hasil_pileg);
        $this->db->delete('tb_hasil_pileg');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Dihapus.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
        redirect('pileg/hasil_pileg_kabupaten_kab/'.$this->session->userdata('id_kab'));
    }

    ///////////////////KECAMATAN////////////////////

    public function detailKecamatanKab($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Data Pemilu - PILEG Kabupaten/Kota',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_kab',
            'wilayahKec'    => $this->Pileg_model->getDataKecamatanByIdKab($id_kab)->result(),
        ];

        $id_kab = $this->uri->segment(3);
        $this->session->set_userdata('id_kab', $id_kab);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/detailKecamatanKab',$data);
		$this->load->view('templates/footer');
    }

    public function dpt_hak_pilih_kecamatan_kab($id_kec)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_kec,0,-3);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_role    = $this->session->userdata('id_role');
        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');

        $data = [
            'title'         => 'Data Pemilu - PILEG Kabupaten/Kota',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_kab',
            'data'          => $this->Pileg_model->getDataJumlahPemilihPilegKecamatanByPeriodeRole($id_role,$id_kec,$id_periode)->result_array(),
            'periode'       => $this->Pileg_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pileg_model->getDataWilayahKecById($id_kec)->result_array(),
        ];

        $id_kec = $this->uri->segment(3);
        $this->session->set_userdata('id_kec', $id_kec);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/dpt_hak_pilih_kecamatan_kab',$data);
		$this->load->view('templates/footer');
    }

    public function tambahDptKecamatanKab_proses()
    {
        $id_kec = $this->session->userdata('id_kec');

        $this->_rulesJumlahPemilih();

        if($this->form_validation->run() == FALSE)
        {
            $this->dpt_hak_pilih_kecamatan_kab($id_kec);
        }
        else
        {
            $this->Pileg_model->tambahDptKecamatanKab();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/dpt_hak_pilih_kecamatan_kab/'.$this->session->userdata('id_kec'));
        }
    }

    public function edit_pengguna_hak_pilih_kecamatan_kab($id_jumlah_pemilih)
    {
        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');
        $id_kec     = $this->session->userdata('id_kec');

        $data = [
            'title'         => 'Data Pemilu - PILEG Kabupaten/Kota',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_kab',
            'data'          => $this->Pileg_model->getDataJumlahPemilihPilegById($id_jumlah_pemilih)->result_array(),
            'periode'       => $this->Pileg_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pileg_model->getDataWilayahKecById($id_kec)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/edit_pengguna_hak_pilih_kecamatan_kab',$data);
		$this->load->view('templates/footer');
    }

    public function edit_pengguna_hak_pilih_kecamatan_kab_proses($id_jumlah_pemilih)
    {
        $this->_rulesJumlahPemilih();

        if($this->form_validation->run() == FALSE)
        {
            $this->edit_pengguna_hak_pilih_kecamatan_kab($id_jumlah_pemilih);
        }
        else
        {
            $this->Pileg_model->editJumlahPemilih($id_jumlah_pemilih);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/dpt_hak_pilih_kecamatan_kab/'.$this->session->userdata('id_kec'));
        }
    }

    public function hasil_pileg_kecamatan_kab($id_kec)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_kec,0,-3);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_role    = $this->session->userdata('id_role');
        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');

        $data = [
            'title'         => 'Data Pemilu - PILEG Kabupaten/Kota',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_kab',
            'data'          => $this->Pileg_model->getDataHasilPilegKecamatan($id_kec,$id_periode,$id_role)->result_array(),
            'partai'        => $this->Pileg_model->getDataPartai()->result_array(),
            'periode'       => $this->Pileg_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pileg_model->getDataWilayahKecById($id_kec)->result_array(),
        ];

        $id_kec = $this->uri->segment(3);
        $this->session->set_userdata('id_kec', $id_kec);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/hasil_pileg_kecamatan_kab',$data);
        $this->load->view('templates/footer');
    }

    public function tambah_hasil_pileg_kecamatan_kab_proses()
    {
        $id_kec = $this->session->userdata('id_kec');

        $this->_rulesHasilPileg();

        if($this->form_validation->run() == FALSE)
        {
            $this->hasil_pileg_kecamatan_kab($id_kec);
        }
        else
        {
            $this->Pileg_model->tambahHasilPilegKecamatanKabupaten();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/hasil_pileg_kecamatan_kab/'.$this->session->userdata('id_kec'));
        }
    }

    public function editHasilPilegKecamatanKabupaten($id_hasil_pileg)
    {
        $id_kab     = $this->session->userdata('id_kab');
        $id_kec     = $this->session->userdata('id_kec');

        $data = [
            'title'         => 'Data Pemilu - PILEG Kabupaten/Kota',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_kab',
            'data'          => $this->Pileg_model->getDataHasilPilegById2($id_hasil_pileg)->result_array(),
            'partai'        => $this->Pileg_model->getDataPartai()->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pileg_model->getDataWilayahKecById($id_kec)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/editHasilPilegKecamatanKabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function editHasilPilegKecamatanKab_proses($id_hasil_pileg)
    {
        $this->_rulesEditHasilPileg();

        if($this->form_validation->run() == FALSE)
        {
            $this->editHasilPilegKecamatanKabupaten($id_hasil_pileg);
        }
        else
        {
            $this->Pileg_model->editHasilPileg($id_hasil_pileg);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/hasil_pileg_kecamatan_kab/'.$this->session->userdata('id_kec'));
        }
    }

    public function hapusHasilPilegKecamatanKabupaten($id_hasil_pileg)
    {
        $this->db->where('id_hasil_pileg',$id_hasil_pileg);
        $this->db->delete('tb_hasil_pileg');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Dihapus.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
        redirect('pileg/hasil_pileg_kecamatan_kab/'.$this->session->userdata('id_kec'));
    }

    ///////////////////DESA////////////////////

    public function detailDesaKab($id_kec)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_kec,0,-3);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Data Pemilu - PILEG Kabupaten/Kota',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_kab',
            'wilayahDesa'   => $this->Pilpres_model->getDataDesaByIdKec($id_kec)->result(),
        ];

        $id_kec = $this->uri->segment(3);
        $this->session->set_userdata('id_kec', $id_kec);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/detailDesaKab',$data);
		$this->load->view('templates/footer');
    }

    public function dpt_hak_pilih_desa_kab($id_desa)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_desa,0,-8);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_role    = $this->session->userdata('id_role');
        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');
        $id_kec     = $this->session->userdata('id_kec');

        $data = [
            'title'         => 'Data Pemilu - PILEG Kabupaten/Kota',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_kab',
            'data'          => $this->Pileg_model->getDataJumlahPemilihPilegDesaByPeriodeRole($id_role,$id_desa,$id_periode)->result_array(),
            'periode'       => $this->Pileg_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pileg_model->getDataWilayahKecById($id_kec)->result_array(),
            'wilayahDesa'   => $this->Pileg_model->getDataWilayahDesaById($id_desa)->result_array(),
        ];

        $id_desa = $this->uri->segment(3);
        $this->session->set_userdata('id_desa', $id_desa);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/dpt_hak_pilih_desa_kab',$data);
		$this->load->view('templates/footer');
    }

    public function tambahDptDesaKab_proses()
    {
        $id_desa = $this->session->userdata('id_desa');

        $this->_rulesJumlahPemilih();

        if($this->form_validation->run() == FALSE)
        {
            $this->dpt_hak_pilih_desa_kab($id_desa);
        }
        else
        {
            $this->Pileg_model->tambahDptDesaKab();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/dpt_hak_pilih_desa_kab/'.$this->session->userdata('id_desa'));
        }
    }

    public function edit_pengguna_hak_pilih_desa_kab($id_jumlah_pemilih)
    {
        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');
        $id_kec     = $this->session->userdata('id_kec');
        $id_desa    = $this->session->userdata('id_desa');

        $data = [
            'title'         => 'Data Pemilu - PILEG Kabupaten/Kota',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_kab',
            'data'          => $this->Pileg_model->getDataJumlahPemilihPilegById($id_jumlah_pemilih)->result_array(),
            'periode'       => $this->Pileg_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pileg_model->getDataWilayahKecById($id_kec)->result_array(),
            'wilayahDesa'   => $this->Pileg_model->getDataWilayahDesaById($id_desa)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/edit_pengguna_hak_pilih_desa_kab',$data);
		$this->load->view('templates/footer');
    }

    public function edit_pengguna_hak_pilih_desa_kab_proses($id_jumlah_pemilih)
    {
        $this->_rulesJumlahPemilih();

        if($this->form_validation->run() == FALSE)
        {
            $this->edit_pengguna_hak_pilih_desa_kab($id_jumlah_pemilih);
        }
        else
        {
            $this->Pileg_model->editJumlahPemilih($id_jumlah_pemilih);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/dpt_hak_pilih_desa_kab/'.$this->session->userdata('id_desa'));
        }
    }

    public function hasil_pileg_desa_kab($id_desa)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_desa,0,-8);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }
        
        $id_role    = $this->session->userdata('id_role');
        $id_periode = $this->session->userdata('id_periode');
        $id_kab     = $this->session->userdata('id_kab');
        $id_kec     = $this->session->userdata('id_kec');

        $data = [
            'title'         => 'Data Pemilu - PILEG Kabupaten/Kota',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_kab',
            'data'          => $this->Pileg_model->getDataHasilPilegDesa($id_desa,$id_periode,$id_role)->result_array(),
            'partai'        => $this->Pileg_model->getDataPartai()->result_array(),
            'periode'       => $this->Pileg_model->getDataPeriodeById($id_periode)->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pileg_model->getDataWilayahKecById($id_kec)->result_array(),
            'wilayahDesa'   => $this->Pileg_model->getDataWilayahDesaById($id_desa)->result_array(),
        ];

        $id_desa = $this->uri->segment(3);
        $this->session->set_userdata('id_desa', $id_desa);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/hasil_pileg_desa_kab',$data);
        $this->load->view('templates/footer');
    }

    public function tambah_hasil_pileg_desa_kab_proses()
    {
        $id_desa = $this->session->userdata('id_desa');

        $this->_rulesHasilPileg();

        if($this->form_validation->run() == FALSE)
        {
            $this->hasil_pileg_desa_kab($id_desa);
        }
        else
        {
            $this->Pileg_model->tambahHasilPilegDesaKab();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/hasil_pileg_desa_kab/'.$this->session->userdata('id_desa'));
        }
    }

    public function editHasilPilegDesaKab($id_hasil_pileg)
    {
        $id_kab     = $this->session->userdata('id_kab');
        $id_kec     = $this->session->userdata('id_kec');
        $id_desa    = $this->session->userdata('id_desa');

        $data = [
            'title'         => 'Data Pemilu - PILEG Kabupaten/Kota',
            'aktif'         => 'pileg',
            'sub'           => 'pileg_kab',
            'data'          => $this->Pileg_model->getDataHasilPilegById2($id_hasil_pileg)->result_array(),
            'partai'        => $this->Pileg_model->getDataPartai()->result_array(),
            'wilayahKab'    => $this->Pileg_model->getDataWilayahKabById($id_kab)->result_array(),
            'wilayahKec'    => $this->Pileg_model->getDataWilayahKecById($id_kec)->result_array(),
            'wilayahDesa'   => $this->Pileg_model->getDataWilayahDesaById($id_desa)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pileg/editHasilPilegDesaKab',$data);
		$this->load->view('templates/footer');
    }

    public function editHasilPilegDesaKab_proses($id_hasil_pileg)
    {
        $this->_rulesEditHasilPileg();

        if($this->form_validation->run() == FALSE)
        {
            $this->editHasilPilegDesaKab($id_hasil_pileg);
        }
        else
        {
            $this->Pileg_model->editHasilPileg($id_hasil_pileg);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('pileg/hasil_pileg_desa_kab/'.$this->session->userdata('id_desa'));
        }
    }

    public function hapusHasilPilegDesaKab($id_hasil_pileg)
    {
        $this->db->where('id_hasil_pileg',$id_hasil_pileg);
        $this->db->delete('tb_hasil_pileg');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Dihapus.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
        redirect('pileg/hasil_pileg_desa_kab/'.$this->session->userdata('id_desa'));
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

    public function _rulesHasilPileg()
    {
        $this->form_validation->set_rules('partai', 'Nama Partai', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Nama Partai wajib diisi'
        ]);
        
        $this->form_validation->set_rules('perolehan', 'Perolehan Suara', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Perolehan Suara wajib diisi'
        ]);
    }
    
    public function _rulesEditHasilPileg()
    {
        
        $this->form_validation->set_rules('perolehan', 'Perolehan Suara', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Perolehan Suara wajib diisi'
        ]);
    }

}