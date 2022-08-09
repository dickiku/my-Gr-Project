<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Periode extends CI_Controller{

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
            'title'     => 'Periode Pemilu',
            'aktif'     => 'periode_pemilu',
            'periode'   => $this->Periode_pemilu_model->getDataPeriode()->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('periode/index',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_periode()
    {
        $this->Periode_pemilu_model->tambahPeriode();

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');

        redirect('periode/index/');
    }

    public function showEdit($id_periode)
    {
        $data = [
            'title'     => 'Periode Pemilu',
            'aktif'     => 'periode_pemilu',
            'data'      => $this->Periode_pemilu_model->getDetailPeriode($id_periode)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('periode/edit',$data);
		$this->load->view('templates/footer');
    }

    public function editPeriode()
    {
        $id_periode = $this->input->post('id_periode');

        $this->Periode_pemilu_model->editDataPeriode($id_periode);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil DiEdit.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('periode/index/');
    }

    public function delete_periode($id_data)
    {
        $this->db->where('id_periode_pemilu',$id_data);
        $this->db->delete('tb_periode_pemilu');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('periode/index/');
    }

}

?>