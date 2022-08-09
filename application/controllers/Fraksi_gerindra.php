<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fraksi_gerindra extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        
        $user = $this->session->userdata('userdata');
        if($user['level'] != 'Admin' && $user['level'] != 'Super Admin')
        {
            redirect('admin/auth');
        }
    }

    public function indexAdmKabFraksiGerindra()
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];
        
        $data = [
            'title'         => 'Fraksi Gerindra - DPRD-Kab/Kota',
            'aktif'         => 'fraksi_gerindra',
            'sub'           => 'dprdkabkota',
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result()
        ];
    
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('fraksi_gerindra/dprdkabkota/index',$data);
        $this->load->view('templates/footer');
    }
    
    //==========================ADMIN SEMUA========================//

    public function dprri()
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Fraksi Gerindra - DPR-RI',
            'aktif'         => 'fraksi_gerindra',
            'sub'           => 'dprri',
            'data'          => $this->Fraksi_gerindra_model->getDataFraksiRiById()->result_array(),
            'kepengurusan'  => $this->Fraksi_gerindra_model->getDataKepengurusanFraksiRiById()->result_array()
        ];
    
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('fraksi_gerindra/dprri/index',$data);
        $this->load->view('templates/footer');   
    }

    public function tambahKepengurusanRi()
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'             => 'Fraksi Gerindra - DPR-RI',
            'aktif'             => 'fraksi_gerindra',
            'sub'               => 'dprri',
            'keanggotaan'       => $this->Keanggotaan_model->getDataKeanggotaan()->result_array(),
            'jabatan_fraksi'    => $this->Fraksi_gerindra_model->getDataJabatanFraksi()->result_array(),
            'jabatan'           => $this->Fraksi_gerindra_model->getDataJabatan()->result_array(),
            'jabatan_lama'      => $this->Fraksi_gerindra_model->getDataJabatanLama()->result_array(),
        ];
        
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('fraksi_gerindra/dprri/tambahKepengurusanRi',$data);
        $this->load->view('templates/footer');
    }

    public function tambah_proses_ri()
    {
        $this->_rulesKepengurusan();

        if($this->form_validation->run() == FALSE)
        {
            $this->tambahKepengurusanRi();
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> Data Gagal Ditambah.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        }
        else
        {
            $this->Fraksi_gerindra_model->tambahDataKepengurusanRi();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('fraksi_gerindra/dprri');
        }
    }

    public function editRi($id_fraksi_gerindra)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'             => 'Fraksi Gerindra - DPR-RI',
            'aktif'             => 'fraksi_gerindra',
            'sub'               => 'dprri',
            'data'              => $this->Fraksi_gerindra_model->getDataFraksiByIdFraksi($id_fraksi_gerindra)->result_array(),
        ];
        
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('fraksi_gerindra/dprri/editRi',$data);
        $this->load->view('templates/footer');
    }

    public function edit_proses_ri($id_fraksi_gerindra)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->editRi($id_fraksi_gerindra);
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> Data Gagal Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        }
        else
        {
            $this->Fraksi_gerindra_model->editDataRi($id_fraksi_gerindra);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('fraksi_gerindra/dprri');
        }
    }

    public function editKepengurusanRi($id_pengurus_fraksi_gerindra)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'             => 'Fraksi Gerindra - DPR-RI',
            'aktif'             => 'fraksi_gerindra',
            'sub'               => 'dprri',
            'data'              => $this->Fraksi_gerindra_model->getDataKepengurusanFraksiByIdFraksi($id_pengurus_fraksi_gerindra)->result_array(),
            'jabatan_fraksi'    => $this->Fraksi_gerindra_model->getDataJabatanFraksi()->result_array(),
            'jabatan'           => $this->Fraksi_gerindra_model->getDataJabatan()->result_array(),
            'jabatan_lama'      => $this->Fraksi_gerindra_model->getDataJabatanLama()->result_array(),
        ];
        
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('fraksi_gerindra/dprri/editKepengurusanRi',$data);
        $this->load->view('templates/footer');
    }

    public function editKepengurusan_proses_ri($id_pengurus_fraksi_gerindra)
    {
        $this->_rulesEditKepengurusan();

        if($this->form_validation->run() == FALSE)
        {
            $this->editKepengurusanRi($id_pengurus_fraksi_gerindra);
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> Data Gagal Diubah.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        }
        else
        {
            $this->Fraksi_gerindra_model->editKepengurusanRi($id_pengurus_fraksi_gerindra);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('fraksi_gerindra/dprri');
        }
    }

    public function hapusKepengurusanRi($id_pengurus_fraksi_gerindra)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $this->db->where('id_pengurus_fraksi_gerindra', $id_pengurus_fraksi_gerindra);
        $this->db->delete('tb_pengurus_fraksi_gerindra');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        redirect('fraksi_gerindra/dprri');
    }

    public function dprdprov()
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Fraksi Gerindra - DPRD-Provinsi',
            'aktif'         => 'fraksi_gerindra',
            'sub'           => 'dprdprov',
            'data'          => $this->Fraksi_gerindra_model->getDataFraksiByIdProv()->result_array(),
            'kepengurusan'  => $this->Fraksi_gerindra_model->getDataKepengurusanFraksiByIdProv()->result_array()
        ];
    
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('fraksi_gerindra/dprdprov/index',$data);
        $this->load->view('templates/footer');   
    }

    public function tambahKepengurusanProvinsi()
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'             => 'Fraksi Gerindra - DPRD-Provinsi',
            'aktif'             => 'fraksi_gerindra',
            'sub'               => 'dprdprov',
            'keanggotaan'       => $this->Keanggotaan_model->getDataKeanggotaan()->result_array(),
            'jabatan_fraksi'    => $this->Fraksi_gerindra_model->getDataJabatanFraksi()->result_array(),
            'jabatan'           => $this->Fraksi_gerindra_model->getDataJabatan()->result_array(),
            'jabatan_lama'      => $this->Fraksi_gerindra_model->getDataJabatanLama()->result_array(),
        ];
        
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('fraksi_gerindra/dprdprov/tambahKepengurusanProvinsi',$data);
        $this->load->view('templates/footer');
    }

    public function tambah_proses_provinsi()
    {
        $this->_rulesKepengurusan();

        if($this->form_validation->run() == FALSE)
        {
            $this->tambahKepengurusanProvinsi();
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> Data Gagal Ditambah.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        }
        else
        {
            $this->Fraksi_gerindra_model->tambahDataKepengurusanProvinsi();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('fraksi_gerindra/dprdprov');
        }
    }

    public function editProvinsi($id_fraksi_gerindra)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'             => 'Fraksi Gerindra - DPRD-Provinsi',
            'aktif'             => 'fraksi_gerindra',
            'sub'               => 'dprdprov',
            'data'              => $this->Fraksi_gerindra_model->getDataFraksiByIdFraksi($id_fraksi_gerindra)->result_array(),
        ];
        
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('fraksi_gerindra/dprdprov/editProvinsi',$data);
        $this->load->view('templates/footer');
    }

    public function edit_proses_provinsi($id_fraksi_gerindra)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->editProvinsi($id_fraksi_gerindra);
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> Data Gagal Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        }
        else
        {
            $this->Fraksi_gerindra_model->editDataProvinsi($id_fraksi_gerindra);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('fraksi_gerindra/dprdprov');
        }
    }

    public function editKepengurusanProvinsi($id_pengurus_fraksi_gerindra)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'             => 'Fraksi Gerindra - DPRD-Provinsi',
            'aktif'             => 'fraksi_gerindra',
            'sub'               => 'dprdprov',
            'data'              => $this->Fraksi_gerindra_model->getDataKepengurusanFraksiByIdFraksi($id_pengurus_fraksi_gerindra)->result_array(),
            'jabatan_fraksi'    => $this->Fraksi_gerindra_model->getDataJabatanFraksi()->result_array(),
            'jabatan'           => $this->Fraksi_gerindra_model->getDataJabatan()->result_array(),
            'jabatan_lama'      => $this->Fraksi_gerindra_model->getDataJabatanLama()->result_array(),
        ];
        
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('fraksi_gerindra/dprdprov/editKepengurusanProvinsi',$data);
        $this->load->view('templates/footer');
    }

    public function editKepengurusan_proses_provinsi($id_pengurus_fraksi_gerindra)
    {
        $this->_rulesEditKepengurusan();

        if($this->form_validation->run() == FALSE)
        {
            $this->editKepengurusanProvinsi($id_pengurus_fraksi_gerindra);
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> Data Gagal Diubah.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        }
        else
        {
            $this->Fraksi_gerindra_model->editKepengurusanProvinsi($id_pengurus_fraksi_gerindra);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('fraksi_gerindra/dprdprov');
        }
    }

    public function hapusKepengurusanProvinsi($id_pengurus_fraksi_gerindra)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }
        
        $this->db->where('id_pengurus_fraksi_gerindra', $id_pengurus_fraksi_gerindra);
        $this->db->delete('tb_pengurus_fraksi_gerindra');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        redirect('fraksi_gerindra/dprdprov');
    }

    public function dprdkabkota()
    {
        $data = [
            'title'         => 'Fraksi Gerindra - DPRD-Kab/Kota',
            'aktif'         => 'fraksi_gerindra',
            'sub'           => 'dprdkabkota',
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayah()->result()
        ];
    
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('fraksi_gerindra/dprdkabkota/index',$data);
        $this->load->view('templates/footer'); 
    }

    public function detailKepengurusan($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Fraksi Gerindra - DPRD-Kab/Kota',
            'aktif'         => 'fraksi_gerindra',
            'sub'           => 'dprdkabkota',
            'wilayahKab'    => $this->Fraksi_gerindra_model->getDataWilayahKab($id_kab)->result_array(),
            'data'          => $this->Fraksi_gerindra_model->getDataPengurusByIdKab($id_kab)->result_array(),
        ];

        $id_kab = $this->uri->segment(3);
        $this->session->set_userdata('id_kab', $id_kab);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('fraksi_gerindra/dprdkabkota/detailKepengurusan',$data);
		$this->load->view('templates/footer');
    }

    public function detailFraksiGerindra($id_fraksi_gerindra)
    {
        $id_kab = $this->session->userdata('id_kab');

        $data = [
            'title'             => 'Fraksi Gerindra - DPRD-Kab/Kota',
            'aktif'             => 'fraksi_gerindra',
            'sub'               => 'dprdkabkota',
            'data'          => $this->Fraksi_gerindra_model->getDataFraksiByIdKabFraksi($id_kab, $id_fraksi_gerindra)->result_array(),
            'kepengurusan'  => $this->Fraksi_gerindra_model->getDataKepengurusanFraksiByIdKab($id_kab, $id_fraksi_gerindra)->result_array()
        ];
    
        $id_fraksi_gerindra = $this->uri->segment(3);
        $this->session->set_userdata('id_fraksi_gerindra', $id_fraksi_gerindra);

        $this->load->view('templates/header');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('fraksi_gerindra/dprdkabkota/detailFraksiGerindra',$data);
        $this->load->view('templates/footer');   
    }

    public function tambahKepengurusanKabupaten()
    {
        $id_kab = $this->session->userdata('id_kab');

        $data = [
            'title'             => 'Fraksi Gerindra - DPRD-Kab/Kota',
            'aktif'             => 'fraksi_gerindra',
            'sub'               => 'dprdkabkota',
            'keanggotaan'    => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktifIdKab($id_kab)->result_array(),
            // 'keanggotaan'       => $this->Keanggotaan_model->getDataKeanggotaan()->result_array(),
            'wilayahKab'        => $this->Fraksi_gerindra_model->getDataWilayahKab($id_kab)->result_array(),
            'jabatan_fraksi'    => $this->Fraksi_gerindra_model->getDataJabatanFraksi()->result_array(),
            'jabatan'           => $this->Fraksi_gerindra_model->getDataJabatan()->result_array(),
            'jabatan_lama'      => $this->Fraksi_gerindra_model->getDataJabatanLama()->result_array(),
        ];
        
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('fraksi_gerindra/dprdkabkota/tambahKepengurusanKabupaten',$data);
        $this->load->view('templates/footer');
    }

    public function tambahPengurus_proses_kabupaten()
    {
        $id_kab = $this->session->userdata('id_kab');

        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->detailKepengurusan($id_kab);
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> Data Gagal Ditambah.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        }
        else
        {
            $this->Fraksi_gerindra_model->tambahPengurusKabupaten();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('fraksi_gerindra/detailKepengurusan/'.$this->session->userdata('id_kab'));
        }
    }

    public function tambah_proses_kabupaten()
    {
        $this->_rulesKepengurusan();

        if($this->form_validation->run() == FALSE)
        {
            $this->tambahKepengurusanKabupaten();
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> Data Gagal Ditambah.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        }
        else
        {
            $this->Fraksi_gerindra_model->tambahDataKepengurusanKabupaten();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('fraksi_gerindra/detailFraksiGerindra/'.$this->session->userdata('id_fraksi_gerindra'));
        }
    }

    public function editKabupaten($id_fraksi_gerindra)
    {
        $data = [
            'title'             => 'Fraksi Gerindra - DPRD-Kab/Kota',
            'aktif'             => 'fraksi_gerindra',
            'sub'               => 'dprdkabkota',
            'data'              => $this->Fraksi_gerindra_model->getDataFraksiByIdFraksi($id_fraksi_gerindra)->result_array(),
        ];
        
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('fraksi_gerindra/dprdkabkota/editKabupaten',$data);
        $this->load->view('templates/footer');
    }

    public function edit_proses_kabupaten($id_fraksi_gerindra)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->editKabupaten($id_fraksi_gerindra);
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> Data Gagal Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        }
        else
        {
            $this->Fraksi_gerindra_model->editDataKabupaten($id_fraksi_gerindra);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('fraksi_gerindra/detailFraksiGerindra/'.$this->session->userdata('id_fraksi_gerindra'));
        }
    }

    public function editKepengurusanKabupaten($id_pengurus_fraksi_gerindra)
    {
        $data = [
            'title'             => 'Fraksi Gerindra - DPRD-Kab/Kota',
            'aktif'             => 'fraksi_gerindra',
            'sub'               => 'dprdkabkota',
            'data'              => $this->Fraksi_gerindra_model->getDataKepengurusanFraksiByIdFraksi($id_pengurus_fraksi_gerindra)->result_array(),
            'jabatan_fraksi'    => $this->Fraksi_gerindra_model->getDataJabatanFraksi()->result_array(),
            'jabatan'           => $this->Fraksi_gerindra_model->getDataJabatan()->result_array(),
            'jabatan_lama'      => $this->Fraksi_gerindra_model->getDataJabatanLama()->result_array(),
        ];
        
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('fraksi_gerindra/dprdkabkota/editKepengurusanKabupaten',$data);
        $this->load->view('templates/footer');
    }

    public function editKepengurusan_proses_kabupaten($id_pengurus_fraksi_gerindra)
    {
        $this->_rulesEditKepengurusan();

        if($this->form_validation->run() == FALSE)
        {
            $this->editKepengurusanKabupaten($id_pengurus_fraksi_gerindra);
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> Data Gagal Diubah.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        }
        else
        {
            $this->Fraksi_gerindra_model->editKepengurusanKabupaten($id_pengurus_fraksi_gerindra);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('fraksi_gerindra/detailFraksiGerindra/'.$this->session->userdata('id_fraksi_gerindra'));
        }
    }

    public function hapusDataFraksi($id_fraksi_gerindra)
    {
        $this->db->where('id_fraksi_gerindra', $id_fraksi_gerindra);
        $this->db->delete('tb_fraksi_gerindra');

        $this->db->where('id_fraksi_gerindra', $id_fraksi_gerindra);
        $this->db->delete('tb_pengurus_fraksi_gerindra');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        redirect('fraksi_gerindra/detailKepengurusan/'.$this->session->userdata('id_kab'));
    }

    public function hapusKepengurusanKabupaten($id_pengurus_fraksi_gerindra)
    {
        $this->db->where('id_pengurus_fraksi_gerindra', $id_pengurus_fraksi_gerindra);
        $this->db->delete('tb_pengurus_fraksi_gerindra');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        redirect('fraksi_gerindra/detailFraksiGerindra/'.$this->session->userdata('id_fraksi_gerindra'));
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama_fraksi', 'Nama Fraksi', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Nama Fraksi wajib diisi'
        ]);

        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Alamat wajib diisi'
        ]);
        
        $this->form_validation->set_rules('no_telp', 'No. Telp', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> No. Telp wajib diisi'
        ]);
        
        $this->form_validation->set_rules('tenaga_ahli', 'Tenaga Ahli', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Tenaga Ahli wajib diisi'
        ]);
    }

    public function _rulesEditKepengurusan()
    {   
        $this->form_validation->set_rules('id_jabatan_fraksi', 'Jabatan Fraksi', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Jabatan Fraksi wajib diisi'
        ]);

        $this->form_validation->set_rules('id_jabatan_3', 'Jabatan', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Jabatan wajib diisi'
        ]);
        
        $this->form_validation->set_rules('id_jabatan_lama', 'Jabatan Lama', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Jabatan Lama wajib diisi'
        ]);
    }

    public function _rulesKepengurusan()
    {
        // $this->form_validation->set_rules('nama', 'Nama', 'required|trim',[
        //     'required'  => '<div class="text-danger small"><strong>Error!</strong> Nama wajib diisi'
        // ]);

        $this->form_validation->set_rules('keanggotaan', 'Keanggotaan', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Keanggotaan wajib diisi'
        ]);
        
        $this->form_validation->set_rules('id_jabatan_fraksi', 'Jabatan Fraksi', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Jabatan Fraksi wajib diisi'
        ]);

        $this->form_validation->set_rules('id_jabatan_3', 'Jabatan', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Jabatan wajib diisi'
        ]);
        
        $this->form_validation->set_rules('id_jabatan_lama', 'Jabatan Lama', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Jabatan Lama wajib diisi'
        ]);
    }
}