<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Partai extends CI_Controller{

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
            'title'     => 'Partai',
            'aktif'     => 'partai',
            'data'      => $this->Partai_model->getDataPartai()->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('partai/index',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_proses()
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->index();
        }
        else
        {
            $this->Partai_model->tambahData();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Ditambah.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
            redirect('partai');
        }
    }

    public function edit($id_partai)
    {
        $data = [
            'title'     => 'Partai',
            'aktif'     => 'partai',
            'data'      => $this->Partai_model->getDataPartaiById($id_partai)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('partai/edit',$data);
		$this->load->view('templates/footer');
    }

    public function edit_proses($id_partai)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->edit($id_partai);
        }
        else
        {
            $this->Partai_model->editData($id_partai);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Diupdate.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
            redirect('partai');
        }
    }

    public function hapus($id_partai)
    {
        $this->db->where('id_partai',$id_partai);
        $this->db->delete('tb_partai');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
        redirect('partai');
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama_partai', 'Nama Partai', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Nama Partai wajib diisi</div>'
        ]);
    }
}