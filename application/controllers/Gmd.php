<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gmd extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        
        $user = $this->session->userdata('userdata');
        if($user['level'] != 'Admin' && $user['level'] != 'Super Admin')
        {
            redirect('admin/auth');
        }
    }

    public function indexAdmKabGmd()
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $data = [
            'title'     => 'GMD',
            'aktif'     => 'gmd',
            'sub'       => 'gmd-kabupaten',
            'wilayahKab'   => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('gmd/index',$data);
		$this->load->view('templates/footer');
    }
    
    //==========================ADMIN SEMUA========================//
    public function kabupaten()
    {
        $data = [
            'title'     => 'GMD',
            'aktif'     => 'gmd',
            'sub'       => 'gmd-kabupaten',
            'wilayahKab'   => $this->Wilayah_kab_model->getDataWilayah()->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('gmd/index',$data);
		$this->load->view('templates/footer');
    }

    public function provinsi()
    {
        $data = [
            'title'     => 'GMD',
            'aktif'     => 'gmd',
            'sub'       => 'gmd-provinsi',
            'data'      => $this->Gmd_model->getDataAngkatan()->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('gmd/provinsi',$data);
		$this->load->view('templates/footer');
    }

    public function tampil_angkatan()
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'GMD',
            'aktif'     => 'gmd',
            'sub'       => 'gmd-angkatan',
            'data'      => $this->Gmd_model->getDataAngkatan()->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('gmd/tampil_angkatan',$data);
		$this->load->view('templates/footer');
    }

    public function tampil_provinsi()
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'GMD',
            'aktif'         => 'gmd',
            'sub'           => 'gmd-provinsi',
            'data'          => $this->Gmd_model->getDataKepengurusanGmdProvinsi()->result_array(),
            'angkatan'      => $this->Gmd_model->getDataAngkatan()->result_array(),
            'keanggotaan'   => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktif()->result_array(),
            'jabatan'       => $this->Keanggotaan_model->getDataJabatan()->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('gmd/tampil_provinsi',$data);
		$this->load->view('templates/footer');
    }

    public function tampil_kabupaten($id_kab)
    {
        // $id_kab = $this->session->userdata('id_kab');

        $user = $this->session->userdata('userdata');
        $id_kabs = $user['id_kab'];

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'             => 'GMD',
            'aktif'             => 'gmd',
            'sub'               => 'gmd-kabupaten',
            'angkatan'          => $this->Gmd_model->getDataAngkatan()->result_array(),
            'keanggotaan'       => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktif()->result_array(),
            'keanggotaanKab'    => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktifIdKab($id_kabs)->result_array(),
            'jabatan'           => $this->Keanggotaan_model->getDataJabatan()->result_array(),
            'kepengurusan'      => $this->Gmd_model->getDataKepengurusanGmdKabupatenByIdKab($id_kab)->result_array(),
            'wilayah'           => $this->Gmd_model->getDataWilayahKabById($id_kab)->result_array()
        ];

        $id = $this->uri->segment(3);
        $this->session->set_userdata('id', $id);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('gmd/tampil_kabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function angkatan($id_kab)
    {
        $data = [
            'title'         => 'GMD',
            'aktif'         => 'gmd',
            'sub'           => 'gmd-kabupaten',
            'wilayahKab'    => $this->Gmd_model->getDataWilayahKabById($id_kab)->result_array(),
            'data'          => $this->Gmd_model->getDataAngkatan()->result()
        ];

        $id_kab = $this->uri->segment(3);
        $this->session->set_userdata('id_kab', $id_kab);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('gmd/angkatan',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_angkatan_proses_provinsi()
    {
        $this->_rulesAngkatan();

        if($this->form_validation->run() == FALSE)
        {
            $this->tampil_angkatan();
        }
        else
        {
            $data = [
                'nama_angkatan' => $this->input->post('nama_angkatan')
            ];

            $this->db->insert('tb_angkatan', $data);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            // redirect('gmd/tampil_provinsi');
            redirect('gmd/tampil_angkatan');
        }
    }

    //=============================PROVINSI===================================/

    public function detailGmdProvinsi($id_angkatan)
    {
        $data = [
            'title'         => 'GMD',
            'aktif'         => 'gmd',
            'sub'           => 'gmd-provinsi',
            'angkatan'      => $this->Gmd_model->getDataAngkatanById($id_angkatan)->result_array(),
            'keanggotaan'   => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktif()->result_array(),
            'jabatan'       => $this->Keanggotaan_model->getDataJabatan()->result_array(),
            'kepengurusan'  => $this->Gmd_model->getDataKepengurusanGmdById($id_angkatan)->result_array()
        ];

        $id = $this->uri->segment(3);
        $this->session->set_userdata('id', $id);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('gmd/detailGmdProvinsi',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_kepengurusan_proses_provinsi()
    {
        $this->_rulesKepengurusan();

        if($this->form_validation->run() == FALSE)
        {
            $this->tampil_provinsi();
            // $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            //                                 <strong>Error!</strong> Data Gagal Ditambah.
            //                                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            //                                 <span aria-hidden="true">&times;</span>
            //                                 </button>
            //                             </div>');
            // redirect('gmd/tampil_provinsi');
        }
        else
        {
            $this->Gmd_model->tambahDataKepengurusanProvinsi();
            // $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            //                                     <strong>Sukses!</strong> Data Berhasil Ditambahkan.
            //                                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            //                                     <span aria-hidden="true">&times;</span>
            //                                     </button>
            //                                 </div>');
            redirect('gmd/tampil_provinsi');
        }
    }

    public function editKepengurusanProvinsi($id_pengurus_gmd)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'GMD',
            'aktif'     => 'gmd',
            'sub'       => 'gmd-provinsi',
            'data'      => $this->Gmd_model->getDataPengurusGmdById($id_pengurus_gmd)->result_array(),
            'jabatan'   => $this->Keanggotaan_model->getDataJabatan()->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('gmd/editKepengurusanProvinsi',$data);
		$this->load->view('templates/footer');
    }

    public function editKepengurusan_proses_provinsi($id_pengurus_gmd)
    {
        $this->_rulesEditKepengurusan();

        if($this->form_validation->run() == FALSE)
        {
            $this->editKepengurusanProvinsi($id_pengurus_gmd);

            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> Data Gagal Diubah.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        }
        else
        {
            $this->Gmd_model->editKepengurusan($id_pengurus_gmd);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('gmd/tampil_provinsi');
        }
    }

    public function hapusKepengurusanProvinsi($id_pengurus_gmd)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }
        
        $this->db->where('id_pengurus_gmd', $id_pengurus_gmd);
        $this->db->delete('tb_pengurus_gmd');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        redirect('gmd/tampil_provinsi');
    }

    //=============================KABUPATEN/KOTA===================================/

    public function detailGmdKabupaten($id_angkatan)
    {
        $id_kab = $this->session->userdata('id_kab');

        $user = $this->session->userdata('userdata');
        $id_kabs = $user['id_kab'];

        $data = [
            'title'             => 'GMD',
            'aktif'             => 'gmd',
            'sub'               => 'gmd-kabupaten',
            'angkatan'          => $this->Gmd_model->getDataAngkatanById($id_angkatan)->result_array(),
            'keanggotaan'       => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktif()->result_array(),
            'keanggotaanKab'    => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktifIdKab($id_kabs)->result_array(),
            'jabatan'           => $this->Keanggotaan_model->getDataJabatan()->result_array(),
            'kepengurusan'      => $this->Gmd_model->getDataKepengurusanGmdKabupatenById($id_kab, $id_angkatan)->result_array(),
            'wilayah'           => $this->Gmd_model->getDataWilayahKabById($id_kab)->result_array()
        ];

        $id = $this->uri->segment(3);
        $this->session->set_userdata('id', $id);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('gmd/detailGmdKabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_kepengurusan_proses_kabupaten()
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
            redirect('gmd/tampil_kabupaten/'.$this->session->userdata('id'));
        }
        else
        {
            $this->Gmd_model->tambahDataKepengurusanKabupaten();
            // $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            //                                     <strong>Sukses!</strong> Data Berhasil Ditambahkan.
            //                                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            //                                     <span aria-hidden="true">&times;</span>
            //                                     </button>
            //                                 </div>');
            redirect('gmd/tampil_kabupaten/'.$this->session->userdata('id'));
        }
    }

    public function editKepengurusanKabupaten($id_pengurus_gmd)
    {
        $data = [
            'title'     => 'GMD',
            'aktif'     => 'gmd',
            'sub'       => 'gmd-kabupaten',
            'data'      => $this->Gmd_model->getDataPengurusGmdById($id_pengurus_gmd)->result_array(),
            'jabatan'   => $this->Keanggotaan_model->getDataJabatan()->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('gmd/editKepengurusanKabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function editKepengurusan_proses_kabupaten($id_pengurus_gmd)
    {
        $this->_rulesEditKepengurusan();

        if($this->form_validation->run() == FALSE)
        {
            $this->editKepengurusanKabupaten($id_pengurus_gmd);

            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> Data Gagal Diubah.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        }
        else
        {
            $this->Gmd_model->editKepengurusan($id_pengurus_gmd);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('gmd/tampil_kabupaten/'.$this->session->userdata('id'));
        }
    }

    public function hapusKepengurusanKabupaten($id_pengurus_gmd)
    {
        $this->db->where('id_pengurus_gmd', $id_pengurus_gmd);
        $this->db->delete('tb_pengurus_gmd');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        redirect('gmd/tampil_kabupaten/'.$this->session->userdata('id'));
    }

    public function _rulesAngkatan()
    {
        $this->form_validation->set_rules('nama_angkatan', 'Nama Angkatan', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Nama Angkatan wajib diisi'
        ]);
    }

    public function _rulesKepengurusan()
    {
        $this->form_validation->set_rules('id_angkatan', 'Angkatan', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Angkatan wajib diisi'
        ]);

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