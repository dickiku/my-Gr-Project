<?php 

class Cagub extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        
        $user = $this->session->userdata('userdata');
        if($user['level'] != 'Admin' && $user['level'] != 'Super Admin' || $user['id_kab'])
        {
            redirect('admin/auth');
        }
    }

    // periode Pilgub
    public function index()
    {
        $data = [
            'title'     => 'Calon Gubernur',
            'aktif'     => 'cagub',
            'periode'   => $this->Cagub_model->getData()->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('cagub/index',$data);
		$this->load->view('templates/footer');
    }

    public function tambahPeriode()
    {
        $this->Cagub_model->tambahData();

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('cagub/index/');
    }

    public function showEditPeriode($id_data)
    {
        $data = [
            'title'     => 'Calon Gubernur',
            'aktif'     => 'cagub',
            'data'   => $this->Cagub_model->getDetailPeriode($id_data)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('cagub/editPeriode',$data);
		$this->load->view('templates/footer');
    }

    public function prosesEditPeriode()
    {
        $id_data = $this->input->post('id_tahun');

        $this->Cagub_model->editPeriode($id_data);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil DiEdit.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('cagub/index/');
    }


    // ------------------ Calon Gubernur -------------------
    public function showCalon($id_tahun)
    {
        $data = [
            'title'     => 'Calon Gubernur',
            'aktif'     => 'cagub',
            'data'      => $this->Cagub_model->getDataCagub($id_tahun)->result_array(),
            'periode'   => $this->Cagub_model->getDetailPeriode($id_tahun)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('cagub/listCalon',$data);
		$this->load->view('templates/footer');
    }

    public function tambahCalon()
    {
        $id_tahun = $this->input->post('id_tahun');

        $this->Cagub_model->tambahCalon();

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('cagub/showCalon/'.$id_tahun);
    }

    public function showEdit($id_data)
    {
        $data = [
            'title'     => 'Calon Gubernur',
            'aktif'     => 'cagub',
            'data'      => $this->Cagub_model->getDetailCalon($id_data)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('cagub/editCagub',$data);
		$this->load->view('templates/footer');
    }

    public function prosesEditCalon()
    {
        $id_tahun = $this->input->post('id_tahun');
        $id_data = $this->input->post('id_cagub');

        $this->Cagub_model->editCalon($id_data);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil DiEdit.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('cagub/showCalon/'.$id_tahun);
    }

    public function prosesDeletecalon($id_data,$id_tahun)
    {
        $this->db->where('id_cagub',$id_data);
        $this->db->delete('tb_cagub');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('cagub/showCalon/'.$id_tahun);
    }
}
?>