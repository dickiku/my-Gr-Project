<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caleg_potensial extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        
        $user = $this->session->userdata('userdata');
        if($user['level'] != 'Admin' && $user['level'] != 'Super Admin')
        {
            redirect('admin/auth');
        }
    }

    public function indexAdmKabCalegPotensialkabupaten()
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $data = [
            'title'     => 'Caleg Potensial',
            'aktif'     => 'caleg_potensial',
            'sub'       => 'cp-kabupaten',
            'wilayahKab'   => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result()
        ];
    
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('caleg_potensial/kabupaten',$data);
        $this->load->view('templates/footer');
    }

    //==========================ADMIN SEMUA========================//
    
    public function provinsi()
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Caleg Potensial',
            'aktif'     => 'caleg_potensial',
            'sub'       => 'cp-provinsi',
            'wilayah'   => $this->Caleg_potensial_model->getDapilProvinsi()->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('caleg_potensial/provinsi',$data);
		$this->load->view('templates/footer');
    }

    public function detailKepengurusanCalegProvinsi($id_dapil_prov)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Caleg Potensial',
            'aktif'         => 'caleg_potensial',
            'sub'           => 'cp-provinsi',
            'data'          => $this->Caleg_potensial_model->getDataCalegPotensialProvById($id_dapil_prov)->result_array(),
            'dapil'         => $this->Caleg_potensial_model->getDataDapilProvById($id_dapil_prov)->result_array(),   
            'keanggotaan'   => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktif()->result_array(),
        ];

        $id_dapil_prov = $this->uri->segment(3);
        $this->session->set_userdata('id_dapil_prov', $id_dapil_prov);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('caleg_potensial/detailKepengurusanCalegProvinsi',$data);
		$this->load->view('templates/footer');
    }

    public function tambahCalegPotensial_proses_provinsi()
    {
        $id_dapil_prov = $this->session->userdata('id_dapil_prov');
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->detailKepengurusanCalegProvinsi($id_dapil_prov);
        }
        else
        {
            $this->Caleg_potensial_model->tambahData();
            // $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            //                                 <strong>Sukses!</strong> Data Berhasil Ditambah.
            //                                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            //                                 <span aria-hidden="true">&times;</span>
            //                                 </button>
            //                             </div>');
            redirect('caleg_potensial/detailKepengurusanCalegProvinsi/'.$this->session->userdata('id_dapil_prov'));
        }
    }

    public function hapusDataKepengurusanCalegProvinsi($id_caleg_potensial)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }
        
        $this->db->where('id_caleg_potensial', $id_caleg_potensial);
        $this->db->delete('tb_caleg_potensial');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Dihapus.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
        redirect('caleg_potensial/detailKepengurusanCalegProvinsi/'.$this->session->userdata('id_dapil_prov'));
    }

    //=========================KABUPATEN=========================//

    public function kabupaten()
    {
        $data = [
            'title'     => 'Caleg Potensial',
            'aktif'     => 'caleg_potensial',
            'sub'       => 'cp-kabupaten',
            'wilayahKab'   => $this->Wilayah_kab_model->getDataWilayah()->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('caleg_potensial/kabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function detailDapilKabupaten($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Caleg Potensial',
            'aktif'         => 'caleg_potensial',
            'sub'           => 'cp-kabupaten',
            'dapil'         => $this->Caleg_potensial_model->getDataDapilByIdKab($id_kab)->result()
        ];

        $id_kab = $this->uri->segment(3);
        $this->session->set_userdata('id_kab', $id_kab);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('caleg_potensial/detailDapilKabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function detailKepengurusanCalegKabupaten($id_dapil_kab)
    {
        $id_kab = $this->session->userdata('id_kab');

        $user = $this->session->userdata('userdata');
        $id_kabs = $user['id_kab'];

        $data = [
            'title'             => 'Caleg Potensial',
            'aktif'             => 'caleg_potensial',
            'sub'               => 'cp-kabupaten',
            'wilayah'           => $this->Caleg_potensial_model->getDataWilayahKabById($id_kab)->result_array(),
            'data'              => $this->Caleg_potensial_model->getDataCalegPotensialKabById($id_dapil_kab)->result_array(),
            'dapil'             => $this->Caleg_potensial_model->getDataDapilByIdDapilKab($id_dapil_kab)->result_array(),   
            'keanggotaan'       => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktif()->result_array(),
            'keanggotaanKab'    => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktifIdKab($id_kabs)->result_array(),
        ];

        $id_dapil_kab = $this->uri->segment(3);
        $this->session->set_userdata('id_dapil_kab', $id_dapil_kab);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('caleg_potensial/detailKepengurusanCalegKabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function tambahCalegPotensial_proses_kabupaten()
    {
        $id_dapil_kab = $this->session->userdata('id_dapil_kab');
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->detailKepengurusanCalegKabupaten($id_dapil_kab);
        }
        else
        {
            $this->Caleg_potensial_model->tambahDataKabupaten();
            // $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            //                                 <strong>Sukses!</strong> Data Berhasil Ditambah.
            //                                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            //                                 <span aria-hidden="true">&times;</span>
            //                                 </button>
            //                             </div>');
            redirect('caleg_potensial/detailKepengurusanCalegKabupaten/'.$this->session->userdata('id_dapil_kab'));
        }
    }

    public function hapusDataKepengurusanCalegKabupaten($id_caleg_potensial)
    {
        $this->db->where('id_caleg_potensial', $id_caleg_potensial);
        $this->db->delete('tb_caleg_potensial');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Dihapus.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
        redirect('caleg_potensial/detailKepengurusanCalegKabupaten/'.$this->session->userdata('id_dapil_kab'));
    }

    public function _rules()
    {
        $this->form_validation->set_rules('keanggotaan', 'Keanggotaan', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Keanggotaan wajib diisi'
        ]);
    }
}