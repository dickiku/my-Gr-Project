<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Satgas extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        
        $user = $this->session->userdata('userdata');
        if($user['level'] != 'Admin' && $user['level'] != 'Super Admin')
        {
            redirect('admin/auth');
        }
    }

    public function indexAdmKabSatgas()
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];
        
        $data = [
            'title'     => 'Satgas',
            'aktif'     => 'satgas',
            'sub'       => 'satgas-kab',
            'wilayahKab'   => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('satgas/index',$data);
		$this->load->view('templates/footer');
    }
    
    public function index()
    {
        $data = [
            'title'     => 'Satgas',
            'aktif'     => 'satgas',
            'sub'       => 'satgas-kab',
            'wilayahKab'   => $this->Wilayah_kab_model->getDataWilayah()->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('satgas/index',$data);
		$this->load->view('templates/footer');
    }

    public function detailSatgas($id_kab)
    {
        $user = $this->session->userdata('userdata');
        // if($user['id_kab']){
        //     $id_kab = $user['id_kab'];
        // }

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'             => 'Satgas',
            'aktif'             => 'satgas',
            'sub'               => 'satgas-kab',
            'data'              => $this->Satgas_model->getDataWilayahKabById($id_kab)->result_array(),
            'keanggotaan'       => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktif()->result_array(),
            'keanggotaanKab'    => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktifIdKab($id_kab)->result_array(),
            'jabatan'           => $this->Keanggotaan_model->getDataJabatan2()->result_array(),
            'kepengurusan'      => $this->Satgas_model->getDataKepengurusanSatgasbyId($id_kab)->result_array()
        ];

        $id = $this->uri->segment(3);
        $this->session->set_userdata('id', $id);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('satgas/detailSatgas',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_kepengurusan_proses()
    {
        $this->_rulesKepengurusan();

        if($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>Error!</strong> Data Gagal Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('satgas/detailSatgas/'.$this->session->userdata('id'));
        }
        else
        {
            $this->Satgas_model->tambahDataKepengurusan();
            // $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            //                                     <strong>Sukses!</strong> Data Berhasil Ditambahkan.
            //                                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            //                                     <span aria-hidden="true">&times;</span>
            //                                     </button>
            //                                 </div>');
            redirect('satgas/detailSatgas/'.$this->session->userdata('id'));
        }
    }

    public function editKepengurusan($id_pengurus_satgas)
    {
        $data = [
            'title'         => 'Satgas',
            'aktif'         => 'satgas',
            'sub'           => 'satgas-kab',
            'data'          => $this->Satgas_model->getDataPengurusSatgasById($id_pengurus_satgas)->result_array(),
            'jabatan'       => $this->Keanggotaan_model->getDataJabatan2()->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('satgas/editKepengurusan',$data);
		$this->load->view('templates/footer');
    }

    public function editKepengurusan_proses($id_pengurus_satgas)
    {
        $this->_rulesEditKepengurusan();

        if($this->form_validation->run() == FALSE)
        {
            $this->editKepengurusan($id_pengurus_satgas);

            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> Data Gagal Diubah.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        }
        else
        {
            $this->Satgas_model->editKepengurusan($id_pengurus_satgas);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('satgas/detailSatgas/'.$this->session->userdata('id'));
        }
    }

    public function hapusKepengurusan($id_pengurus_satgas)
    {
        $this->db->where('id_pengurus_satgas', $id_pengurus_satgas);
        $this->db->delete('tb_pengurus_satgas');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        redirect('satgas/detailSatgas/'.$this->session->userdata('id'));
    }

    ////////PROVINSI///////////
    public function provinsi()
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab']){
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'             => 'Satgas',
            'aktif'             => 'satgas',
            'sub'               => 'satgas-provinsi',
            'keanggotaan'       => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktif()->result_array(),
            'jabatan'           => $this->Keanggotaan_model->getDataJabatan2()->result_array(),
            'kepengurusan'      => $this->Satgas_model->getDataKepengurusanSatgas()->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('satgas/satgasProvinsi',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_kepengurusan_provinsi_proses()
    {
        $this->_rulesKepengurusan();

        if($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>Error!</strong> Data Gagal Ditambah.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('satgas/provinsi');
        }
        else
        {
            $this->Satgas_model->tambahDataKepengurusanProvinsi();
            // $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            //                                     <strong>Sukses!</strong> Data Berhasil Ditambahkan.
            //                                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            //                                     <span aria-hidden="true">&times;</span>
            //                                     </button>
            //                                 </div>');
            redirect('satgas/provinsi');
        }
    }

    public function editKepengurusanProvinsi($id_pengurus_satgas)
    {
        $user = $this->session->userdata('userdata');
        
        if($user['level'] == 'Admin' && $user['id_kab']){
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Satgas',
            'aktif'         => 'satgas',
            'sub'           => 'satgas-provinsi',
            'data'          => $this->Satgas_model->getDataPengurusSatgasProvinsiById($id_pengurus_satgas)->result_array(),
            'jabatan'       => $this->Keanggotaan_model->getDataJabatan2()->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('satgas/editKepengurusan',$data);
		$this->load->view('templates/footer');
    }

    public function editKepengurusanProvinsi_proses($id_pengurus_satgas)
    {
        $this->_rulesEditKepengurusan();

        if($this->form_validation->run() == FALSE)
        {
            $this->editKepengurusanProvinsi($id_pengurus_satgas);

            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> Data Gagal Diubah.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        }
        else
        {
            $this->Satgas_model->editKepengurusan($id_pengurus_satgas);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('satgas/provinsi');
        }
    }

    public function hapusKepengurusanProvinsi($id_pengurus_satgas)
    {
        $user = $this->session->userdata('userdata');
        
        if($user['level'] == 'Admin' && $user['id_kab']){
            $this->session->sess_destroy();
            redirect('admin/auth');
        }
        
        $this->db->where('id_pengurus_satgas', $id_pengurus_satgas);
        $this->db->delete('tb_pengurus_satgas');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        redirect('satgas/provinsi');
    }

    public function _rulesKepengurusan()
    {
        $this->form_validation->set_rules('keanggotaan', 'Keanggotaan', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Keanggotaan wajib diisi'
        ]);
        
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Jabatan wajib diisi'
        ]);
    }

    public function _rulesEditKepengurusan()
    {
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Jabatan wajib diisi'
        ]);
    }

}