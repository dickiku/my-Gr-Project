<?php

class Cabup extends CI_Controller{

    public function indexAdmKabCabup()
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $data = [
            'title'         => 'Calon Bupati',
            'aktif'         => 'cabup',
            'wilayahKab'    => $this->Cabup_model->getDataWilayahByIdKab($id_kab)->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('cabup/index',$data);
		$this->load->view('templates/footer');
    }

    public function index()
    {
        $data = [
            'title'         => 'Calon Bupati',
            'aktif'         => 'cabup',
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayah()->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('cabup/index',$data);
		$this->load->view('templates/footer');
    }

    public function showPeriode($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Calon Bupati',
            'aktif'         => 'cabup',
            'kabupaten'     => $this->Badan_saksi_model->getDataBSKab($id_kab)->result_array(),
            'periode'       => $this->Cabup_model->getData($id_kab)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('cabup/periode',$data);
		$this->load->view('templates/footer');
    }

    public function tambahPeriode()
    {
        $id_kab = $this->input->post('id_kab');
        $this->Cabup_model->tambahData();

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('cabup/showPeriode/'.$id_kab);
    }

    public function showEditPeriode($id_data)
    {
        $data = [
            'title'         => 'Calon Bupati',
            'aktif'         => 'cabup',
            'data'          => $this->Cabup_model->getDetailPeriode($id_data)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('cabup/editPeriode',$data);
		$this->load->view('templates/footer');
    }

    public function prosesEditPeriode()
    {
        $id_data = $this->input->post('id_tahun');
        $id_kab = $this->input->post('id_kab');

        $this->Cabup_model->editPeriode($id_data);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil DiEdit.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('cabup/showPeriode/'.$id_kab);
    }


    // ------------------ Calon Bupati -------------------
    public function showCalon($id_tahun,$id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Calon Bupati',
            'aktif'         => 'cabup',
            'kabupaten'     => $this->Badan_saksi_model->getDataBSKab($id_kab)->result_array(),
            'data'          => $this->Cabup_model->getDataCalon($id_tahun)->result_array(),
            'periode'       => $this->Cabup_model->getDetailPeriode($id_tahun)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('cabup/listCalon',$data);
		$this->load->view('templates/footer');
    }

    public function tambahCalon()
    {
        $id_tahun   = $this->input->post('id_tahun');
        $id_kab     = $this->input->post('id_kab');

        $this->Cabup_model->tambahCalon();

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('cabup/showCalon/'.$id_tahun.'/'.$id_kab);
    }

    public function showEditCalon($id_data)
    {
        $data = [
            'title'         => 'Calon Bupati',
            'aktif'         => 'cabup',
            'data'          => $this->Cabup_model->getDetailCalon($id_data)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('cabup/editCalon',$data);
		$this->load->view('templates/footer');
    }

    public function prosesEditCalon()
    {
        $id_tahun = $this->input->post('id_tahun');
        $id_data = $this->input->post('id_cabup');
        $id_kab = $this->input->post('id_tahun');

        $this->Cabup_model->editCalon($id_data);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil DiEdit.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('cabup/showCalon/'.$id_tahun.'/'.$id_kab);
    }

    public function hapusCalon($id_data,$id_tahun,$id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }
        
        $this->db->where('id_cabup',$id_data);
        $this->db->delete('tb_cabup');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('cabup/showCalon/'.$id_tahun.'/'.$id_kab);
    }
}

?>