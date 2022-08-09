<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ambulance extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        
        $user = $this->session->userdata('userdata');
        if($user['level'] != 'Admin' && $user['level'] != 'Super Admin')
        {
            redirect('admin/auth');
        }
    }

    public function indexAdmKabAmbulancekabupaten()
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $data = [
            'title'     => 'Ambulance',
            'aktif'     => 'ambulance',
            'sub'       => 'am-kabupaten',
            'wilayahKab'   => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('ambulance/kabupaten',$data);
		$this->load->view('templates/footer');
    }
    
    public function provinsi()
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Ambulance',
            'aktif'     => 'ambulance',
            'sub'       => 'am-provinsi',
            'data'      => $this->Ambulance_model->getDataAmbulanceProv()->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('ambulance/index',$data);
		$this->load->view('templates/footer');
    }

    public function tambah()
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->provinsi();
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>Error!</strong> Data Gagal Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
        }
        else
        {
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambah.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            $this->Ambulance_model->tambahData();
            redirect('Ambulance');
        }
    }

    public function detail($id_ambulance)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Ambulance',
            'aktif'     => 'ambulance',
            'sub'       => 'am-provinsi',
            'data'      => $this->Ambulance_model->getDataAmbulanceById($id_ambulance)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('ambulance/detail',$data);
		$this->load->view('templates/footer');
    }

    public function edit($id_ambulance)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Ambulance',
            'aktif'     => 'ambulance',
            'sub'       => 'am-provinsi',
            'data'      => $this->Ambulance_model->getDataAmbulanceById($id_ambulance)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('ambulance/edit',$data);
		$this->load->view('templates/footer');
    }

    public function edit_proses($id_ambulance)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->edit($id_ambulance);
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>Error!</strong> Data Gagal Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
        }
        else
        {
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            $this->Ambulance_model->editData($id_ambulance);
            redirect('Ambulance/provinsi');
        }
    }

    public function hapus($id_ambulance)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }
        
        $this->Ambulance_model->hapusData($id_ambulance);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
        redirect('Ambulance/provinsi');
    }

    //=============================KABUPATEN/KOTA===============================//
    public function kabupaten()
    {
        $data = [
            'title'     => 'Ambulance',
            'aktif'     => 'ambulance',
            'sub'       => 'am-kabupaten',
            'wilayahKab'   => $this->Wilayah_kab_model->getDataWilayah()->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('ambulance/kabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function detailAmbulance($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }
        
        $data = [
            'title'     => 'Ambulance',
            'aktif'     => 'ambulance',
            'sub'       => 'am-kabupaten',
            'wilayah'   => $this->Ambulance_model->getWilayahKabupaten($id_kab)->result_array(),
            'data'      => $this->Ambulance_model->getDataAmbulanceByIdKab($id_kab)->result_array()
        ];

        $id_kab = $this->uri->segment(3);
        $this->session->set_userdata('id_kab', $id_kab);

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('ambulance/detailAmbulance',$data);
        $this->load->view('templates/footer');
    }

    public function detailKabupaten($id_ambulance)
    {
        $data = [
            'title'     => 'Ambulance',
            'aktif'     => 'ambulance',
            'sub'       => 'am-kabupaten',
            'data'      => $this->Ambulance_model->getDataAmbulanceById($id_ambulance)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('ambulance/detail',$data);
		$this->load->view('templates/footer');
    }

    public function tambahAmbulanceKabupaten()
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $id_kab = $this->session->userdata('id_kab');

            $this->detailAmbulance($id_kab);
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>Error!</strong> Data Gagal Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
        }
        else
        {
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambah.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            $this->Ambulance_model->tambahDataAmbulanceKabupaten();
            redirect('ambulance/detailAmbulance/'.$this->session->userdata('id_kab'));
        }
    }

    public function editKabupaten($id_ambulance)
    {
        $data = [
            'title'     => 'Ambulance',
            'aktif'     => 'ambulance',
            'sub'       => 'am-kabupaten',
            'data'      => $this->Ambulance_model->getDataAmbulanceById($id_ambulance)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('ambulance/editKabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function edit_proses_kabupaten($id_ambulance)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->editKabupaten($id_ambulance);
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>Error!</strong> Data Gagal Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
        }
        else
        {
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            $this->Ambulance_model->editData($id_ambulance);
            redirect('ambulance/detailAmbulance/'.$this->session->userdata('id_kab'));
        }
    }

    public function hapusAmbulanceKabupaten($id_ambulance)
    {
        $this->Ambulance_model->hapusData($id_ambulance);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
        redirect('ambulance/detailAmbulance/'.$this->session->userdata('id_kab'));
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Nama wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('no_hp', 'No. HP', 'required',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> No. HP wajib diisi</div>'
        ]);
        
        $this->form_validation->set_rules('plat', 'Plat', 'required',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Plat wajib diisi</div>'
        ]);

    }
}