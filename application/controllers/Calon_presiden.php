<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Calon_presiden extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        
        $user = $this->session->userdata('userdata');
        if($user['level'] != 'Admin' && $user['level'] != 'Super Admin' || $user['id_kab'])
        {
            redirect('admin/auth');
        }
    }
    
    public function index()
    {
        $data = [
            'title'     => 'Calon Presiden',
            'aktif'     => 'calon_presiden',
            'periode'   => $this->Calon_presiden_model->getDataPeriode()->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('calon_presiden/periode',$data);
		$this->load->view('templates/footer');
    }

    public function detailCalon($id_periode)
    {
        $data = [
            'title'     => 'Calon Presiden',
            'aktif'     => 'calon_presiden',
            'data'      => $this->Calon_presiden_model->getDataCapresByPeriode($id_periode)->result_array(),
            'periode'   => $this->Calon_presiden_model->getDataPeriodeById($id_periode)->result_array(),
        ];

        $id_periode = $this->uri->segment(3);
        $this->session->set_userdata('id_periode_pemilu', $id_periode);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('calon_presiden/index',$data);
		$this->load->view('templates/footer');
    }

    public function edit($id_capres)
    {
        $id_periode = $this->session->userdata('id_periode_pemilu');

        $data = [
            'title'     => 'Calon Presiden',
            'aktif'     => 'calon_presiden',
            'data'      => $this->Calon_presiden_model->getDataCapresById($id_capres)->result_array(),
            'periode'   => $this->Calon_presiden_model->getDataPeriodeById($id_periode)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('calon_presiden/edit',$data);
		$this->load->view('templates/footer');
    }

    public function edit_proses($id_capres)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->edit($id_capres);
        }
        else
        {
            $this->Calon_presiden_model->editCapres($id_capres);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('calon_presiden/detailCalon/'.$this->session->userdata('id_periode_pemilu'));
        }
    }

    public function tambah_proses()
    {
        $id_periode = $this->session->userdata('id_periode_pemilu');
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->detailCalon($id_periode);
        }
        else
        {
            $this->Calon_presiden_model->tambahCapres();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('calon_presiden/detailCalon/'.$this->session->userdata('id_periode_pemilu'));
        }
    }

    public function hapus($id_capres)
    {
        $this->db->where('id_capres',$id_capres);
        $this->db->delete('tb_capres');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Dihapus.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('calon_presiden/detailCalon/'.$this->session->userdata('id_periode_pemilu'));
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama_capres', 'Nama Capres', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Nama Capres wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('nama_wapres', 'Nama Wapres', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Nama Wapres wajib diisi'
        ]);
    }
}