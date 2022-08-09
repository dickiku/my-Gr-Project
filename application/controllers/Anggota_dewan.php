<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Anggota_dewan extends CI_Controller{
    
    public function __construct()
    {
        parent::__construct();
        
        $user = $this->session->userdata('userdata');
        if($user['level'] != 'Admin' && $user['level'] != 'Super Admin')
        {
            redirect('admin/auth');
        }
    }

    public function indexAdmKabAnggotaDewan()
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];
        
        $data = [
            'title'         => 'Anggota Dewan - DPRD Kab/Kota',
            'aktif'         => 'anggota_dewan',
            'sub'           => 'dprdkab',
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('anggota_dewan/dprdkabkota/index',$data);
		$this->load->view('templates/footer');
    }

    //==========================ADMIN SEMUA========================//
    
    public function dprri($id_periode)
    {   
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Anggota Dewan - DPR-RI',
            'aktif'         => 'anggota_dewan',
            'sub'           => 'dprri',
            'data'          => $this->Anggota_dewan_model->getDataDPRRIperiode($id_periode)->result_array(),
            'keanggotaan'   => $this->Keanggotaan_model->getDataKeanggotaan()->result_array(),
            'dapil'         => $this->Dapil_model->getDataRi()->result_array(),
            'periode'       => $this->Anggota_dewan_model->periodeDetail($id_periode)->result(),
            'jabatan'       => $this->Anggota_dewan_model->jabatanLain()->result_array()
        ];
    
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('anggota_dewan/dprri/index',$data);
        $this->load->view('templates/footer');   
    }

    public function dprdprov($id_periode)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Anggota Dewan - DPRD-Provinsi',
            'aktif'         => 'anggota_dewan',
            'sub'           => 'dprdprov',
            'data'          => $this->Anggota_dewan_model->getDataDPRDProv($id_periode)->result_array(),
            'keanggotaan'   => $this->Keanggotaan_model->getDataKeanggotaan()->result_array(),
            'dapil'         => $this->Dapil_model->getDataProv()->result_array(),
            'periode'       => $this->Anggota_dewan_model->periodeDetail($id_periode)->result(),
            'jabatan'       => $this->Anggota_dewan_model->jabatanLain()->result_array()
        ];
    
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('anggota_dewan/dprdprov/index',$data);
        $this->load->view('templates/footer');   
    }

    public function kab()
    {
        $data = [
            'title'         => 'Anggota Dewan - DPRD Kab/Kota',
            'aktif'         => 'anggota_dewan',
            'sub'           => 'dprdkab',
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayah()->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('anggota_dewan/dprdkabkota/index',$data);
		$this->load->view('templates/footer');
    }

    public function dprdkabkota($id_periode,$id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }
        
        $data = [
            'title'         => 'Anggota Dewan - DPRD Kab/Kota',
            'aktif'         => 'anggota_dewan',
            'sub'           => 'dprdkab',
            'data'          => $this->Anggota_dewan_model->getDataDPRDKab($id_periode,$id_kab)->result_array(),    
            'keanggotaan'   => $this->Keanggotaan_model->getDataKeanggotaan()->result_array(),
            'dapil'         => $this->Dapil_model->getDataKab($id_kab)->result_array(),
            'periode'       => $this->Anggota_dewan_model->periodeDetail($id_periode)->result(),
            'kabupaten'     => $this->Dapil_model->getDataWilKab($id_kab)->result(),
            'jabatan'       => $this->Anggota_dewan_model->jabatanLain()->result_array()
        ];
    
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('anggota_dewan/dprdkabkota/list',$data);
        $this->load->view('templates/footer');   
    }

    public function showPeriode($id_kab,$id_role)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        if($id_role == '1')
        {
            $data = [
                'title'     => 'Anggota Dewan - DPR-RI',
                'aktif'     => 'anggota_dewan',
                'sub'       => 'dprri',
                'periode'   => $this->Anggota_dewan_model->perode()->result()
            ];

            $this->load->view('templates/header');
            $this->load->view('templates/sidebar',$data);
            $this->load->view('anggota_dewan/dprri/periode',$data);
            $this->load->view('templates/footer');  
        }
        elseif($id_role == '2')
        {
            $data = [
                'title'     => 'Anggota Dewan - DPRD-Provinsi',
                'aktif'     => 'anggota_dewan',
                'sub'       => 'dprdprov',
                'periode'   => $this->Anggota_dewan_model->perode()->result()
            ];

            $this->load->view('templates/header');
            $this->load->view('templates/sidebar',$data);
            $this->load->view('anggota_dewan/dprdprov/periode',$data);
            $this->load->view('templates/footer'); 
        }
        elseif($id_role == '3')
        {
            $data = [
                'title'     => 'Anggota Dewan - DPRD-Kab/Kota',
                'aktif'     => 'anggota_dewan',
                'sub'       => 'dprdkab',
                'periode'   => $this->Anggota_dewan_model->perode()->result(),
                'kab'       => $this->Dapil_model->getDataWilKab($id_kab)->result()
            ];

            $this->load->view('templates/header');
            $this->load->view('templates/sidebar',$data);
            $this->load->view('anggota_dewan/dprdkabkota/periode',$data);
            $this->load->view('templates/footer');
        }
    }

    public function tambah_dprRi()
    {
        $id_periode = $this->input->post('id_periode');

        $this->Anggota_dewan_model->tambahDprRi();

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('anggota_dewan/dprri/'.$id_periode);
    }

    public function tambah_dprdProv()
    {
        $id_periode = $this->input->post('id_periode');

        $this->Anggota_dewan_model->tambahDprdProv();

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('anggota_dewan/dprdprov/'.$id_periode);
    }

    public function tambah_dprdKab()
    {
        $id_periode = $this->input->post('id_periode');
        $id_kab = $this->input->post('id_kab');

        $this->Anggota_dewan_model->tambahDprKab();

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('anggota_dewan/dprdkabkota/'.$id_periode.'/'.$id_kab);
    }

    public function showEditKab($id_data,$id_periode,$id_kab)
    {
        $data = [
            'title'         => 'Anggota Dewan - DPRD Kab/Kota',
            'aktif'         => 'anggota_dewan',
            'sub'           => 'dprdkab',
            'data'          => $this->Anggota_dewan_model->getDataDPRDKabDetail($id_data)->result_array(),
            'dapil'         => $this->Dapil_model->getDataKab($id_kab)->result_array(),
            'periode'       => $this->Anggota_dewan_model->periodeDetail($id_periode)->result(),
            'kabupaten'     => $this->Dapil_model->getDataWilKab($id_kab)->result(),
            'jabatan'       => $this->Anggota_dewan_model->jabatanLain()->result_array()
        ];
    
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('anggota_dewan/dprdkabkota/edit',$data);
        $this->load->view('templates/footer'); 
    }

    public function showEditProv($id_data,$id_periode)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }
        
        $data = [
            'title'         => 'Anggota Dewan - DPRD-Provinsi',
            'aktif'         => 'anggota_dewan',
            'sub'           => 'dprdprov',
            'data'          => $this->Anggota_dewan_model->getDataDPRDProvDetail($id_data)->result_array(),
            'keanggotaan'   => $this->Keanggotaan_model->getDataKeanggotaan()->result_array(),
            'dapil'         => $this->Dapil_model->getDataProv()->result_array(),
            'periode'       => $this->Anggota_dewan_model->periodeDetail($id_periode)->result(),
            'jabatan'       => $this->Anggota_dewan_model->jabatanLain()->result_array()
        ];
    
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('anggota_dewan/dprdprov/edit',$data);
        $this->load->view('templates/footer');
    }

    public function showEditRi($id_data,$id_periode)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Anggota Dewan - DPR-RI',
            'aktif'         => 'anggota_dewan',
            'sub'           => 'dprri',
            'data'          => $this->Anggota_dewan_model->getDataDPRRiDetail($id_data)->result_array(),
            'keanggotaan'   => $this->Keanggotaan_model->getDataKeanggotaan()->result_array(),
            'dapil'         => $this->Dapil_model->getDataRi()->result_array(),
            'periode'       => $this->Anggota_dewan_model->periodeDetail($id_periode)->result(),
            'jabatan'       => $this->Anggota_dewan_model->jabatanLain()->result_array()
        ];
    
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('anggota_dewan/dprri/edit',$data);
        $this->load->view('templates/footer');   
    }

    public function prosesEditDPRDKab()
    {
        $id_data    = $this->input->post('temp');
        $id_periode = $this->input->post('id_periode');
        $id_kab     = $this->input->post('id_kab');

        $this->Anggota_dewan_model->editDPRDKab($id_data);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil DiEdit.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('anggota_dewan/dprdkabkota/'.$id_periode.'/'.$id_kab);
    }

    public function prosesEditDPRDProv()
    {
        $id_data    = $this->input->post('temp');
        $id_periode = $this->input->post('id_periode');

        $this->Anggota_dewan_model->editDPRDProv($id_data);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil DiEdit.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('anggota_dewan/dprdprov/'.$id_periode);
    }
    
    public function prosesEditDPRDRi()
    {
        $id_data    = $this->input->post('temp');
        $id_periode = $this->input->post('id_periode');

        $this->Anggota_dewan_model->editDPRRi($id_data);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil DiEdit.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('anggota_dewan/dprri/'.$id_periode);
    }

    public function hapusData($id_data,$id_periode,$id_role,$id_kab)
    {
        // $this->db->where('id_anggota_dewan',$id_data);
        // $this->db->delete('tb_anggota_dewan');

        // $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        //                                         <strong>Sukses!</strong> Data Berhasil Dihapus.
        //                                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        //                                         <span aria-hidden="true">&times;</span>
        //                                         </button>
        //                                     </div>');

        if($id_role == '1')
        {
            $user = $this->session->userdata('userdata');

            if($user['level'] == 'Admin' && $user['id_kab'])
            {
                $this->session->sess_destroy();
                redirect('admin/auth');
            }

            $this->db->where('id_anggota_dewan',$id_data);
            $this->db->delete('tb_anggota_dewan');
    
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

            redirect('anggota_dewan/dprri/'.$id_periode);
        }
        elseif($id_role == '2')
        {
            $user = $this->session->userdata('userdata');

            if($user['level'] == 'Admin' && $user['id_kab'])
            {
                $this->session->sess_destroy();
                redirect('admin/auth');
            }

            $this->db->where('id_anggota_dewan',$id_data);
            $this->db->delete('tb_anggota_dewan');
    
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

            redirect('anggota_dewan/dprdprov/'.$id_periode);
        }
        elseif($id_role == '3')
        {
            $this->db->where('id_anggota_dewan',$id_data);
            $this->db->delete('tb_anggota_dewan');
    
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');
                                                
            redirect('anggota_dewan/dprdkabkota/'.$id_periode.'/'.$id_kab);
        }
    }
}
