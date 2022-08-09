<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dapil extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        
        $user = $this->session->userdata('userdata');
        if($user['level'] != 'Admin' && $user['level'] != 'Super Admin')
        {
            redirect('admin/auth');
        }
    }
    
    public function indexAdmKabDapilKabupaten()
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $data = [
            'title'         => 'Dapil Kabupaten',
            'aktif'         => 'dapil',
            'sub'           => 'kab',
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dapil/kab/index',$data);
		$this->load->view('templates/footer');
    }

    //==========================ADMIN SEMUA========================//
    public function ri()
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Dapil RI',
            'aktif'     => 'dapil',
            'sub'       => 'ri',
            'list'      => $this->Dapil_model->getDataRi()->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dapil/ri/index',$data);
		$this->load->view('templates/footer');
    }

    public function prov()
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Dapil Provinsi',
            'aktif'     => 'dapil',
            'sub'       => 'prov',
            'list'      => $this->Dapil_model->getDataProv()->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dapil/prov/index',$data);
		$this->load->view('templates/footer');
    }

    public function kab()
    {
        $data = [
            'title'         => 'Dapil Kabupaten',
            'aktif'         => 'dapil',
            'sub'           => 'kab',
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayah()->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dapil/kab/index',$data);
		$this->load->view('templates/footer');
    }

    public function showKab($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }
        
        $data = [
            'title'     => 'Dapil Kabupaten',
            'aktif'     => 'dapil',
            'sub'       => 'kab',
            'list'      => $this->Dapil_model->getDataKab($id_kab)->result_array(),
            'kabupaten' => $this->Dapil_model->getDataWilKab($id_kab)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dapil/kab/list',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_dapil_ri()
    {
        $this->Dapil_model->tambahDapilRI();

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');

        redirect('dapil/ri/');
    }

    public function tambah_dapil_prov()
    {
        $this->Dapil_model->tambahDapilProv();

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');

        redirect('dapil/prov/');
    }

    public function tambah_dapil_kab()
    {
        $id_kab = $this->input->post('id_kab');

        $this->Dapil_model->tambahDapilKab($id_kab);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');

        redirect('dapil/showKab/'.$id_kab);
    }

    public function showEditRi($id_dapil_ri)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Edit Dapil RI',
            'aktif'     => 'dapil',
            'sub'       => 'ri',
            'data'      => $this->Dapil_model->detailDapilRi($id_dapil_ri)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dapil/ri/edit',$data);
		$this->load->view('templates/footer');
    }

    public function showEditProv($id_dapil_prov)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Edit Dapil Prov',
            'aktif'     => 'dapil',
            'sub'       => 'prov',
            'data'      => $this->Dapil_model->detailDapilProv($id_dapil_prov)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dapil/prov/edit',$data);
		$this->load->view('templates/footer');
    }

    public function showEditKab($id_dapil_kab)
    {
        $data = [
            'title'     => 'Edit Dapil Kabupaten',
            'aktif'     => 'dapil',
            'sub'       => 'kab',
            'data'      => $this->Dapil_model->detailDapilKab($id_dapil_kab)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dapil/kab/edit',$data);
		$this->load->view('templates/footer');
    }

    public function editRi_proses()
    {
        $id_dapil = $this->input->post('id_dapil');

        $this->Dapil_model->editDapilRi($id_dapil);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil DiEdit.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');

        redirect('dapil/Ri/');        
    }

    public function editProv_proses()
    {
        $id_dapil = $this->input->post('id_dapil');

        $this->Dapil_model->editDapilProv($id_dapil);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil DiEdit.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');

        redirect('dapil/Prov/');        
    }

    public function editKab_proses()
    {
        $id_kab = $this->input->post('id_kab');
        $id_dapil = $this->input->post('id_dapil');

        $this->Dapil_model->editDapilKab($id_dapil);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil DiEdit.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');

        redirect('dapil/showKab/'.$id_kab);        
    }

    public function hapusRi($id_dapil)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $this->db->where('id_dapil_ri',$id_dapil);
        $this->db->delete('tb_dapil_ri');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');

        redirect('dapil/Ri/');  
    }

    public function hapusProv($id_dapil)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }
        
        $this->db->where('id_dapil_prov',$id_dapil);
        $this->db->delete('tb_dapil_prov');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
                                    
        redirect('dapil/Prov/');    
    }

    public function hapusKab($id_dapil,$id_kab)
    {
        $this->db->where('id_dapil_kab',$id_dapil);
        $this->db->delete('tb_dapil_kab');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
                                    
        redirect('dapil/showKab/'.$id_kab); 
    }
}
?>