<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Pilkada extends CI_Controller{

    public function indexAdmKabPilbup()
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $data = [
            'title'     => 'Data Pemilu - PILBUP',
            'aktif'     => 'pilkada',
            'sub'       => 'pilbup',
            'data'      => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilbup/index',$data);
        $this->load->view('templates/footer');
    }

// ---------------- PILGUP -----------------
    public function pilgub()
    {
        $data = [
            'title'     => 'Data Pemilu - PILGUB',
            'aktif'     => 'pilkada',
            'sub'       => 'pilgub',
            'data'      => $this->Pilkada_model->pilgub_showPeriode()->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilgub/periode',$data);
		$this->load->view('templates/footer');
    }

    // ------------- Kabupaten -------------
    public function pilgub_showKab($id_periode)
    {   
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $data = [
            'title'         => 'Data Pemilu - PILGUB',
            'aktif'         => 'pilkada',
            'sub'           => 'pilgub',
            'data'          => $this->Wilayah_kab_model->getDataWilayah()->result(),
            'dataById'      => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result()
        ];

        $id_periode = $this->uri->segment(3);
        $this->session->set_userdata('id_periode', $id_periode);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilgub/kabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function pilgub_dpt_hak_pilih_kabupaten($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }
        
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'     => 'Data Pemilu - PILGUB',
            'aktif'     => 'pilkada',
            'sub'       => 'pilgub',
            'data'      => $this->Pilkada_model->pilgub_getDptHakPilihKabupaten($id_kab,$id_periode)->result_array(),
            'wilayahKab'=> $this->Badan_saksi_model->getDataBSKab($id_kab)->result_array(),
            'tahun'     => $this->Pilkada_model->pilgub_getDataPeriodeById($id_periode)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilgub/dpt_hak_pilih_kab',$data);
		$this->load->view('templates/footer');
    }

    public function pilgub_tambahDptKabupaten_proses()
    {
        $id_kab = $this->input->post('id_kab');

        $this->Pilkada_model->pilgub_tambahDptHakPilihKabupaten();

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('pilkada/pilgub_dpt_hak_pilih_kabupaten/'.$id_kab);
    }

    public function edit_pengguna_hak_pilih_kab($id_data)
    {
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'     => 'Data Pemilu - PILGUB',
            'aktif'     => 'pilkada',
            'sub'       => 'pilgub',
            'data'      => $this->Pilkada_model->getDataJumlahPemilihKabById($id_data)->result_array(),
            'tahun'     => $this->Pilkada_model->pilgub_getDataPeriodeById($id_periode)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilgub/edit_dpt_hak_pilih_kab',$data);
		$this->load->view('templates/footer');
    }

    public function editPenggunaHakPilihKab_proses()
    {
        $id_data = $this->input->post('id_data');
        $id_kab = $this->input->post('id_kab');

        $this->Pilkada_model->editJumlahPemilihKab($id_data);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil DiEdit.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');
        
        redirect('pilkada/pilgub_dpt_hak_pilih_kabupaten/'.$id_kab);
    }

    public function hasil_pilgub_kabupaten($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'     => 'Data Pemilu - PILGUB',
            'aktif'     => 'pilkada',
            'sub'       => 'pilgub',
            'data'      => $this->Pilkada_model->pilgub_getHasilPilgubKabupaten($id_kab,$id_periode)->result_array(),
            'wilayahKab'=> $this->Badan_saksi_model->getDataBSKab($id_kab)->result_array(),
            'tahun'     => $this->Pilkada_model->pilgub_getDataPeriodeById($id_periode)->result_array(),
            'calon'     => $this->Pilkada_model->getDataCagubByPeriode($id_periode)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilgub/hasil_pilgub_kab',$data);
		$this->load->view('templates/footer');
    }

    public function pilgub_tambahHasilPilgubKab_proses()
    {
        $id_kab = $this->input->post('id_kab');

        $this->Pilkada_model->pilgub_tambahHasilPilgubKabupaten();

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('pilkada/hasil_pilgub_kabupaten/'.$id_kab);
    }

    public function pilgub_editHasilPilkadaKabupaten($id_data,$id_kab)
    {
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'     => 'Data Pemilu - PILBUP',
            'aktif'     => 'pilkada',
            'sub'       => 'pilbup',
            'data'      => $this->Pilkada_model->getDataHasilPilgubById($id_data)->result_array(),
            'wilayahKab'=> $this->Badan_saksi_model->getDataBSKab($id_kab)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilgub/edit_hasil_pilgub_kab',$data);
        $this->load->view('templates/footer');
    }

    public function pilgub_ProsesEditHasilPilkadaKabupaten()
    {
        $id_data = $this->input->post('id_data');
        $id_kab = $this->input->post('id_kab');

        $this->Pilkada_model->pilgub_editHasilPilkadaKab($id_data);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil DiEdit.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');
        
        redirect('pilkada/hasil_pilgub_kabupaten/'.$id_kab);
    }

    public function pilgub_hapusHasilPilkadaKabupaten($id_data,$id_kab)
    {
        $this->db->where('id_hasil_pilgub', $id_data);
        $this->db->delete('tb_hasil_pilgub');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('pilkada/hasil_pilgub_kabupaten/'.$id_kab);
    }

    // ------------- Kecamatan -------------
    public function pilgub_showKec($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'     => 'Data Pemilu - PILGUB',
            'aktif'     => 'pilkada',
            'sub'       => 'pilgub',
            'data'      => $this->Badan_saksi_model->getDataWilayahKec($id_kab)->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilgub/kecamatan',$data);
		$this->load->view('templates/footer');
    }

    public function pilgub_dpt_hak_pilih_kecamatan($id_kec)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_kec,0,-3);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'     => 'Data Pemilu - PILGUB',
            'aktif'     => 'pilkada',
            'sub'       => 'pilgub',
            'data'      => $this->Pilkada_model->pilgub_getDptHakPilihKecamatan($id_kec,$id_periode)->result_array(),
            'wilayahKec'=> $this->Badan_saksi_model->getDataBSKec($id_kec)->result_array(),
            'tahun'     => $this->Pilkada_model->pilgub_getDataPeriodeById($id_periode)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilgub/dpt_hak_pilih_kec',$data);
		$this->load->view('templates/footer');
    }

    public function pilgub_tambahDptKecamatann_proses()
    {
        $id_kec = $this->input->post('id_kec');

        $this->Pilkada_model->pilgub_tambahDptHakPilihKecamatan();

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('pilkada/pilgub_dpt_hak_pilih_kecamatan/'.$id_kec);
    }

    public function edit_pengguna_hak_pilih_kec($id_data)
    {
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'     => 'Data Pemilu - PILGUB',
            'aktif'     => 'pilkada',
            'sub'       => 'pilgub',
            'data'      => $this->Pilkada_model->getDataJumlahPemilihKecById($id_data)->result_array(),
            'tahun'     => $this->Pilkada_model->pilgub_getDataPeriodeById($id_periode)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilgub/edit_dpt_hak_pilih_kec',$data);
		$this->load->view('templates/footer');
    }

    public function editPenggunaHakPilihKec_proses()
    {
        $id_data = $this->input->post('id_data');
        $id_kec = $this->input->post('id_kec');

        $this->Pilkada_model->editJumlahPemilihKec($id_data);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil DiEdit.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');
        
        redirect('pilkada/pilgub_dpt_hak_pilih_kecamatan/'.$id_kec);
    }

    public function hasil_pilgub_kecamatan($id_kec)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_kec,0,-3);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'     => 'Data Pemilu - PILGUB',
            'aktif'     => 'pilkada',
            'sub'       => 'pilgub',
            'data'      => $this->Pilkada_model->pilgub_getHasilPilgubKecamatan($id_kec,$id_periode)->result_array(),
            'wilayahKec'=> $this->Badan_saksi_model->getDataBSKec($id_kec)->result_array(),
            'tahun'     => $this->Pilkada_model->pilgub_getDataPeriodeById($id_periode)->result_array(),
            'calon'     => $this->Pilkada_model->getDataCagubByPeriode($id_periode)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilgub/hasil_pilgub_kec',$data);
		$this->load->view('templates/footer');
    }

    public function pilgub_tambahHasilPilgubKec_proses()
    {
        $id_kec = $this->input->post('id_kec');

        $this->Pilkada_model->pilgub_tambahHasilPilgubKecamatan();

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('pilkada/hasil_pilgub_kecamatan/'.$id_kec);
    }

    public function pilgub_editHasilPilkadaKecamatan($id_data,$id_kec)
    {
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'     => 'Data Pemilu - PILBUP',
            'aktif'     => 'pilkada',
            'sub'       => 'pilbup',
            'data'      => $this->Pilkada_model->getDataHasilPilgubById($id_data)->result_array(),
            'wilayahKec'=> $this->Badan_saksi_model->getDataBSKec($id_kec)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilgub/edit_hasil_pilgub_kec',$data);
        $this->load->view('templates/footer');
    }

    public function pilgub_ProsesEditHasilPilkadaKecamatan()
    {
        $id_data = $this->input->post('id_data');
        $id_kec = $this->input->post('id_kec');

        $this->Pilkada_model->pilgub_editHasilPilkadaKec($id_data);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil DiEdit.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');
        
        redirect('pilkada/hasil_pilgub_kecamatan/'.$id_kec);
    }

    public function pilgub_hapusHasilPilkadaKecamatan($id_data,$id_kec)
    {
        $this->db->where('id_hasil_pilgub', $id_data);
        $this->db->delete('tb_hasil_pilgub');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('pilkada/hasil_pilgub_kecamatan/'.$id_kec);
    }

    // ------------- Desa -------------
    public function pilgub_showDesa($id_kec)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_kec,0,-3);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'     => 'Data Pemilu - PILGUB',
            'aktif'     => 'pilkada',
            'sub'       => 'pilgub',
            'data'      => $this->Badan_saksi_model->getDataWilayahDesa($id_kec)->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilgub/desa',$data);
		$this->load->view('templates/footer');
    }

    public function pilgub_dpt_hak_pilih_desa($id_desa)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_desa,0,-8);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'     => 'Data Pemilu - PILGUB',
            'aktif'     => 'pilkada',
            'sub'       => 'pilgub',
            'data'      => $this->Pilkada_model->pilgub_getDptHakPilihDesa($id_desa,$id_periode)->result_array(),
            'wilayahDesa'=> $this->Badan_saksi_model->getDataBSDesa($id_desa)->result_array(),
            'tahun'     => $this->Pilkada_model->pilgub_getDataPeriodeById($id_periode)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilgub/dpt_hak_pilih_desa',$data);
		$this->load->view('templates/footer');
    }

    public function pilgub_tambahDptDesa_proses()
    {
        $id_desa = $this->input->post('id_desa');

        $this->Pilkada_model->pilgub_tambahDptHakPilihDesa();

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('pilkada/pilgub_dpt_hak_pilih_desa/'.$id_desa);
    }

    public function edit_pengguna_hak_pilih_desa($id_data)
    {
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'     => 'Data Pemilu - PILGUB',
            'aktif'     => 'pilkada',
            'sub'       => 'pilgub',
            'data'      => $this->Pilkada_model->getDataJumlahPemilihDesaById($id_data)->result_array(),
            'tahun'     => $this->Pilkada_model->pilgub_getDataPeriodeById($id_periode)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilgub/edit_dpt_hak_pilih_desa',$data);
		$this->load->view('templates/footer');
    }

    public function editPenggunaHakPilihDesa_proses()
    {
        $id_data = $this->input->post('id_data');
        $id_desa = $this->input->post('id_desa');

        $this->Pilkada_model->editJumlahPemilihDesa($id_data);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil DiEdit.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');
        
        redirect('pilkada/pilgub_dpt_hak_pilih_desa/'.$id_desa);
    }

    public function hasil_pilgub_desa($id_desa)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_desa,0,-8);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }
        
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'     => 'Data Pemilu - PILGUB',
            'aktif'     => 'pilkada',
            'sub'       => 'pilgub',
            'data'      => $this->Pilkada_model->pilgub_getHasilPilgubDesa($id_desa,$id_periode)->result_array(),
            'wilayahDesa'=> $this->Badan_saksi_model->getDataBSDesa($id_desa)->result_array(),
            'tahun'     => $this->Pilkada_model->pilgub_getDataPeriodeById($id_periode)->result_array(),
            'calon'     => $this->Pilkada_model->getDataCagubByPeriode($id_periode)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilgub/hasil_pilgub_desa',$data);
		$this->load->view('templates/footer');
    }

    public function pilgub_tambahHasilPilgubDesa_proses()
    {
        $id_desa = $this->input->post('id_desa');

        $this->Pilkada_model->pilgub_tambahHasilPilgubDesa();

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('pilkada/hasil_pilgub_desa/'.$id_desa);
    }

    public function pilgub_editHasilPilkadaDesa($id_data,$id_desa)
    {
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'     => 'Data Pemilu - PILBUP',
            'aktif'     => 'pilkada',
            'sub'       => 'pilbup',
            'data'      => $this->Pilkada_model->getDataHasilPilgubById($id_data)->result_array(),
            'wilayahDesa'=> $this->Badan_saksi_model->getDataBSDesa($id_desa)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilgub/edit_hasil_pilgub_desa',$data);
        $this->load->view('templates/footer');
    }

    public function pilgub_ProsesEditHasilPilkadaDesa()
    {
        $id_data = $this->input->post('id_data');
        $id_desa = $this->input->post('id_desa');

        $this->Pilkada_model->pilgub_editHasilPilkadaDesa($id_data);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil DiEdit.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');
        
        redirect('pilkada/hasil_pilgub_desa/'.$id_desa);
    }

    public function pilgub_hapusHasilPilkadaDesa($id_data,$id_desa)
    {
        $this->db->where('id_hasil_pilgub', $id_data);
        $this->db->delete('tb_hasil_pilgub');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('pilkada/hasil_pilgub_desa/'.$id_desa);
    }



// ---------------- PILBUP -----------------
    public function pilbup()
    {
        $data = [
            'title'     => 'Data Pemilu - PILBUP',
            'aktif'     => 'pilkada',
            'sub'       => 'pilbup',
            'data'      => $this->Wilayah_kab_model->getDataWilayah()->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilbup/index',$data);
        $this->load->view('templates/footer');
    }

    public function pilbup_showPeriode($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }
        
        $data = [
            'title'     => 'Data Pemilu - PILBUP',
            'aktif'     => 'pilkada',
            'sub'       => 'pilbup',
            'data'      => $this->Pilkada_model->pilbup_showPeriode($id_kab)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilbup/periode_by_kab',$data);
        $this->load->view('templates/footer');
    }

    public function pilbup_showKab($id_periode,$id_kab)
    {
        $data = [
            'title'     => 'Data Pemilu - PILBUP',
            'aktif'     => 'pilkada',
            'sub'       => 'pilbup',
            'data'      => $this->Pilkada_model->getDataKabById($id_kab)->result()
        ];

        $id_periode = $this->uri->segment(3);
        $this->session->set_userdata('id_periode', $id_periode);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilbup/kabupaten',$data);
        $this->load->view('templates/footer');
    }

    // ------------ Kabupaten ------------
    public function pilbup_showDptHakPilihkab($id_kab)
    {
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'     => 'Data Pemilu - PILBUP',
            'aktif'     => 'pilkada',
            'sub'       => 'pilbup',
            'data'      => $this->Pilkada_model->pilbup_getDataDptHakPilihKab($id_kab,$id_periode)->result_array(),
            'wilayahKab'=> $this->Badan_saksi_model->getDataBSKab($id_kab)->result_array(),
            'tahun'     => $this->Pilkada_model->pilbup_getDataPeriodeByIdKab($id_periode,$id_kab)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilbup/dpt_hak_pilih_kab',$data);
        $this->load->view('templates/footer');
    }

    public function pilbup_tambahDptKab_proses()
    {
        $id_kab = $this->input->post('id_kab');

        $this->Pilkada_model->pilbup_tambahDptHakPilihKab();

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('pilkada/pilbup_showDptHakPilihkab/'.$id_kab);
    }

    public function pilbup_showEditDptKab($id_data)
    {
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'     => 'Data Pemilu - PILBUP',
            'aktif'     => 'pilkada',
            'sub'       => 'pilbup',
            'data'      => $this->Pilkada_model->getDataJumlahPemilihKabById($id_data)->result_array(),
            'tahun'     => $this->Pilkada_model->pilgub_getDataPeriodeById($id_periode)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilbup/edit_dpt_hak_pilih_kab',$data);
		$this->load->view('templates/footer');
    }

    public function pilbup_editDptKab_proses()
    {
        $id_data = $this->input->post('id_data');
        $id_kab = $this->input->post('id_kab');

        $this->Pilkada_model->pilbup_editDptHakPilihKab($id_data);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil DiEdit.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');
        
        redirect('pilkada/pilbup_showDptHakPilihkab/'.$id_kab);
    }

    public function pilbup_showHasilkab($id_kab)
    {
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'     => 'Data Pemilu - PILBUP',
            'aktif'     => 'pilkada',
            'sub'       => 'pilbup',
            'data'      => $this->Pilkada_model->pilbup_getDataHasilPerolehanKab($id_kab,$id_periode)->result_array(),
            'wilayahKab'=> $this->Badan_saksi_model->getDataBSKab($id_kab)->result_array(),
            'tahun'     => $this->Pilkada_model->pilbup_getDataPeriodeByIdKab($id_periode,$id_kab)->result_array(),
            'calon'     => $this->Pilkada_model->getDataCabupByPeriodeKab($id_periode,$id_kab)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilbup/hasil_pilbup_kab',$data);
        $this->load->view('templates/footer');
    }

    public function pilbub_tambahHasilPerolehanKab_proses()
    {
        $id_kab = $this->input->post('id_kab');

        $this->Pilkada_model->pilbup_tambahHasilPerolehanKab();

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('pilkada/pilbup_showHasilkab/'.$id_kab);
    }

    public function pilbup_showhasilPerolehanKab($id_data,$id_kab)
    {
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'     => 'Data Pemilu - PILBUP',
            'aktif'     => 'pilkada',
            'sub'       => 'pilbup',
            'data'      => $this->Pilkada_model->getDataHasilPilbupById($id_data)->result_array(),
            'wilayahKab'=> $this->Badan_saksi_model->getDataBSKab($id_kab)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilbup/edit_hasil_pilbup_kab',$data);
        $this->load->view('templates/footer');
    }

    public function pilbup_editHasilPerolehanKab_proses()
    {
        $id_data = $this->input->post('id_data');
        $id_kab = $this->input->post('id_kab');

        $this->Pilkada_model->pilbup_editHasilPerolehanKab($id_data);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil DiEdit.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');
        
        redirect('pilkada/pilbup_showHasilkab/'.$id_kab);
    }

    public function pilbup_hapusHasilPilbupKab($id_data, $id_kab)
    {
        $this->db->where('id_hasil_pilbup', $id_data);
        $this->db->delete('tb_hasil_pilbup');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('pilkada/pilbup_showHasilkab/'.$id_kab);
    }

    // ------------ Kecamatan ------------
    public function pilbup_showKec($id_kab)
    {
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'     => 'Data Pemilu - PILBUP',
            'aktif'     => 'pilkada',
            'sub'       => 'pilbup',
            'data'      => $this->Badan_saksi_model->getDataWilayahKec($id_kab)->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilbup/Kecamatan',$data);
        $this->load->view('templates/footer');
    }

    public function pilbup_showDptHakPilihKec($id_kec)
    {
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'     => 'Data Pemilu - PILBUP',
            'aktif'     => 'pilkada',
            'sub'       => 'pilbup',
            'data'      => $this->Pilkada_model->pilbup_getDataDptHakPilihKec($id_kec,$id_periode)->result_array(),
            'wilayahKec'=> $this->Badan_saksi_model->getDataBSKec($id_kec)->result_array(),
            'tahun'     => $this->Pilkada_model->pilgub_getDataPeriodeById($id_periode)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilbup/dpt_hak_pilih_kec',$data);
        $this->load->view('templates/footer');
    }

    public function pilbup_tambahDptKec_proses()
    {
        $id_kec = $this->input->post('id_kec');

        $this->Pilkada_model->pilbup_tambahDptHakPilihKec();

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('pilkada/pilbup_showDptHakPilihkec/'.$id_kec);
    }

    public function pilbup_showEditDptKec($id_data)
    {
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'     => 'Data Pemilu - PILBUP',
            'aktif'     => 'pilkada',
            'sub'       => 'pilbup',
            'data'      => $this->Pilkada_model->getDataJumlahPemilihKecById($id_data)->result_array(),
            'tahun'     => $this->Pilkada_model->pilgub_getDataPeriodeById($id_periode)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilbup/edit_dpt_hak_pilih_kec',$data);
		$this->load->view('templates/footer');
    }

    public function pilbup_editDptKec_proses()
    {
        $id_data = $this->input->post('id_data');
        $id_kec = $this->input->post('id_kec');

        $this->Pilkada_model->pilbup_editDptHakPilihKec($id_data);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil DiEdit.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');
        
        redirect('pilkada/pilbup_showDptHakPilihkec/'.$id_kec);
    }

    public function pilbup_showHasilKec($id_kec)
    {
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'     => 'Data Pemilu - PILBUP',
            'aktif'     => 'pilkada',
            'sub'       => 'pilbup',
            'data'      => $this->Pilkada_model->pilbup_getDataHasilPerolehanKec($id_kec,$id_periode)->result_array(),
            'wilayahKec'=> $this->Badan_saksi_model->getDataBSKec($id_kec)->result_array(),
            'tahun'     => $this->Pilkada_model->pilgub_getDataPeriodeById($id_periode)->result_array(),
            'calon'     => $this->Pilkada_model->getDataCabupByIdPeriode($id_periode)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilbup/hasil_pilbup_kec',$data);
        $this->load->view('templates/footer');
    }

    public function pilbub_tambahHasilPerolehanKec_proses()
    {
        $id_kec = $this->input->post('id_kec');

        $this->Pilkada_model->pilbup_tambahHasilPerolehanKec();

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('pilkada/pilbup_showHasilkec/'.$id_kec);
    }

    public function pilbup_showhasilPerolehanKec($id_data,$id_kec)
    {
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'     => 'Data Pemilu - PILBUP',
            'aktif'     => 'pilkada',
            'sub'       => 'pilbup',
            'data'      => $this->Pilkada_model->getDataHasilPilbupById($id_data)->result_array(),
            'wilayahKec'=> $this->Badan_saksi_model->getDataBSKec($id_kec)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilbup/edit_hasil_pilbup_kec',$data);
        $this->load->view('templates/footer');
    }

    public function pilbup_editHasilPerolehanKec_proses()
    {
        $id_data = $this->input->post('id_data');
        $id_kec = $this->input->post('id_kec');

        $this->Pilkada_model->pilbup_editHasilPerolehanKec($id_data);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil DiEdit.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');
        
        redirect('pilkada/pilbup_showHasilkec/'.$id_kec);
    }

    public function pilbup_hapusHasilPilbupKec($id_data, $id_kec)
    {
        $this->db->where('id_hasil_pilbup', $id_data);
        $this->db->delete('tb_hasil_pilbup');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('pilkada/pilbup_showHasilkec/'.$id_kec);
    }

    // ------------ Desa ------------
    public function pilbup_showDesa($id_kec)
    {
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'     => 'Data Pemilu - PILBUP',
            'aktif'     => 'pilkada',
            'sub'       => 'pilbup',
            'data'      => $this->Badan_saksi_model->getDataWilayahDesa($id_kec)->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilbup/Desa',$data);
        $this->load->view('templates/footer');
    }

    public function pilbup_showDptHakPilihDesa($id_desa)
    {
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'     => 'Data Pemilu - PILBUP',
            'aktif'     => 'pilkada',
            'sub'       => 'pilbup',
            'data'      => $this->Pilkada_model->pilbup_getDataDptHakPilihDesa($id_desa,$id_periode)->result_array(),
            'wilayahDesa'=> $this->Badan_saksi_model->getDataBSDesa($id_desa)->result_array(),
            'tahun'     => $this->Pilkada_model->pilgub_getDataPeriodeById($id_periode)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilbup/dpt_hak_pilih_desa',$data);
        $this->load->view('templates/footer');
    }

    public function pilbup_tambahDptDesa_proses()
    {
        $id_desa = $this->input->post('id_desa');

        $this->Pilkada_model->pilbup_tambahDptHakPilihDesa();

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('pilkada/pilbup_showDptHakPilihDesa/'.$id_desa);
    }

    public function pilbup_showEditDptDesa($id_data)
    {
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'     => 'Data Pemilu - PILBUP',
            'aktif'     => 'pilkada',
            'sub'       => 'pilbup',
            'data'      => $this->Pilkada_model->getDataJumlahPemilihDesaById($id_data)->result_array(),
            'tahun'     => $this->Pilkada_model->pilgub_getDataPeriodeById($id_periode)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilbup/edit_dpt_hak_pilih_desa',$data);
		$this->load->view('templates/footer');
    }

    public function pilbup_editDptDesa_proses()
    {
        $id_data = $this->input->post('id_data');
        $id_desa = $this->input->post('id_desa');

        $this->Pilkada_model->pilbup_editDptHakPilihKec($id_data);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil DiEdit.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');
        
        redirect('pilkada/pilbup_showDptHakPilihDesa/'.$id_desa);
    }

    public function pilbup_showHasilDesa($id_desa)
    {
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'     => 'Data Pemilu - PILBUP',
            'aktif'     => 'pilkada',
            'sub'       => 'pilbup',
            'data'      => $this->Pilkada_model->pilbup_getDataHasilPerolehanDesa($id_desa,$id_periode)->result_array(),
            'wilayahDesa'=> $this->Badan_saksi_model->getDataBSDesa($id_desa)->result_array(),
            'tahun'     => $this->Pilkada_model->pilgub_getDataPeriodeById($id_periode)->result_array(),
            'calon'     => $this->Pilkada_model->getDataCabupByIdPeriode($id_periode)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilbup/hasil_pilbup_desa',$data);
        $this->load->view('templates/footer');
    }

    public function pilbub_tambahHasilPerolehanDesa_proses()
    {
        $id_desa = $this->input->post('id_desa');

        $this->Pilkada_model->pilbup_tambahHasilPerolehanDesa();

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('pilkada/pilbup_showHasilDesa/'.$id_desa);
    }

    public function pilbup_showhasilPerolehanDesa($id_data,$id_desa)
    {
        $id_periode = $this->session->userdata('id_periode');

        $data = [
            'title'     => 'Data Pemilu - PILBUP',
            'aktif'     => 'pilkada',
            'sub'       => 'pilbup',
            'data'      => $this->Pilkada_model->getDataHasilPilbupById($id_data)->result_array(),
            'wilayahDesa'=> $this->Badan_saksi_model->getDataBSDesa($id_desa)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('data_pemilu/pilkada/pilbup/edit_hasil_pilbup_desa',$data);
        $this->load->view('templates/footer');
    }

    public function pilbup_editHasilPerolehanDesa_proses()
    {
        $id_data = $this->input->post('id_data');
        $id_desa = $this->input->post('id_desa');

        $this->Pilkada_model->pilbup_editHasilPerolehanDesa($id_data);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil DiEdit.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');
        
        redirect('pilkada/pilbup_showHasilDesa/'.$id_desa);
    }

    public function pilbup_hapusHasilPilbupDesa($id_data, $id_desa)
    {
        $this->db->where('id_hasil_pilbup', $id_data);
        $this->db->delete('tb_hasil_pilbup');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('pilkada/pilbup_showHasilDesa/'.$id_desa);
    }

}