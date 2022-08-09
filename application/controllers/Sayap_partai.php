<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sayap_partai extends CI_Controller{
    
    public function __construct()
    {
        parent::__construct();
        
        $user = $this->session->userdata('userdata');
        if($user['level'] != 'Admin' && $user['level'] != 'Super Admin')
        {
            redirect('admin/auth');
        }
    }

    public function indexAdmKabSayapPartaikabupaten()
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $data = [
            'title'         => 'Sayap Partai',
            'aktif'         => 'sayap_partai',
            'sub'           => 'sp-kabupaten',
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('sayap_partai/kabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function indexAdmKabSayapPartaikecamatan()
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $data = [
            'title'         => 'Sayap Partai',
            'aktif'         => 'sayap_partai',
            'sub'           => 'sp-kecamatan',
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('sayap_partai/kecamatan',$data);
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
            'title'     => 'Sayap Partai',
            'aktif'     => 'sayap_partai',
            'sub'       => 'sp-provinsi',
            'data'      => $this->Sayap_partai_model->getDataSayapPartai()->result(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('sayap_partai/provinsi',$data);
		$this->load->view('templates/footer');
    }

    public function kabupaten()
    {
        $data = [
            'title'     => 'Sayap Partai',
            'aktif'     => 'sayap_partai',
            'sub'       => 'sp-kabupaten',
            'wilayahKab'   => $this->Wilayah_kab_model->getDataWilayah()->result(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('sayap_partai/kabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function struktur($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Sayap Partai',
            'aktif'     => 'sayap_partai',
            'sub'       => 'sp-kabupaten',
            'data'      => $this->Sayap_partai_model->getDataSayapPartai()->result()
        ];

        $id_kab = $this->uri->segment(3);
        $this->session->set_userdata('id_kab', $id_kab);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('sayap_partai/struktur',$data);
		$this->load->view('templates/footer');
    }

    public function detailSayapPartaiProvinsi($id_sayap_partai)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Sayap Partai',
            'aktif'         => 'sayap_partai',
            'sub'           => 'sp-provinsi',
            'dom'           => $this->Sayap_partai_model->getDataSayapPartaiDomProv(33,$id_sayap_partai)->result_array(),
            'sayap'         => $this->Sayap_partai_model->getDataSayapPartaiById($id_sayap_partai)->result_array(),
            'data'          => $this->Sayap_partai_model->getDataWilayahProvById($id_sayap_partai)->result_array(),
            'keanggotaan'   => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktif()->result_array(),
            'jabatan'       => $this->Keanggotaan_model->getDataJabatan()->result_array(),
            'kepengurusan'  => $this->Sayap_partai_model->getDataKepengurusanSayapPartaibyId($id_sayap_partai)->result_array()
        ];

        $id = $this->uri->segment(3);
        $this->session->set_userdata('id', $id);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('sayap_partai/detailSayapPartaiProvinsi',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_kepengurusan_proses_provinsi()
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
            redirect('sayap_partai/detailSayapPartaiProvinsi/'.$this->session->userdata('id'));
        }
        else
        {
            $this->Sayap_partai_model->tambahDataKepengurusanProvinsi();
            // $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            //                                     <strong>Sukses!</strong> Data Berhasil Ditambahkan.
            //                                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            //                                     <span aria-hidden="true">&times;</span>
            //                                     </button>
            //                                 </div>');
            redirect('sayap_partai/detailSayapPartaiProvinsi/'.$this->session->userdata('id'));
        }
    }

    public function editKepengurusanProvinsi($id_pengurus_sayap_partai)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Sayap Partai',
            'aktif'     => 'sayap_partai',
            'sub'       => 'sp-provinsi',
            'data'      => $this->Sayap_partai_model->getDataPengurusSayapPartaiById($id_pengurus_sayap_partai)->result_array(),
            'jabatan'   => $this->Keanggotaan_model->getDataJabatan()->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('sayap_partai/editKepengurusanProvinsi',$data);
		$this->load->view('templates/footer');
    }

    public function editKepengurusan_proses_provinsi($id_pengurus_sayap_partai)
    {
        $this->_rulesEditKepengurusan();

        if($this->form_validation->run() == FALSE)
        {
            $this->editKepengurusanProvinsi($id_pengurus_sayap_partai);

            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> Data Gagal Diubah.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        }
        else
        {
            $this->Sayap_partai_model->editKepengurusan($id_pengurus_sayap_partai);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('sayap_partai/detailSayapPartaiProvinsi/'.$this->session->userdata('id'));
        }
    }

    public function hapusKepengurusanProvinsi($id_pengurus_sayap_partai)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }
        
        $this->db->where('id_pengurus_sayap_partai', $id_pengurus_sayap_partai);
        $this->db->delete('tb_pengurus_sayap_partai');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        redirect('sayap_partai/detailSayapPartaiProvinsi/'.$this->session->userdata('id'));
    }

    //---------------------------KABUPATEN KOTA---------------------------//

    public function detailSayapPartaiKabupaten($id_sayap_partai)
    {
        $id_kab = $this->session->userdata('id_kab');

        $user = $this->session->userdata('userdata');
        $id_kabs = $user['id_kab'];

        $data = [
            'title'             => 'Sayap Partai',
            'aktif'             => 'sayap_partai',
            'sub'               => 'sp-kabupaten',
            'dom'               => $this->Sayap_partai_model->getDataSayapPartaiDomKab($id_kab,$id_sayap_partai)->result_array(),
            'sayap'             => $this->Sayap_partai_model->getDataSayapPartaiById($id_sayap_partai)->result_array(),
            'data'              => $this->Sayap_partai_model->getDataWilayahKabById($id_kab, $id_sayap_partai)->result_array(),
            'keanggotaan'       => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktif()->result_array(),
            'keanggotaanKab'    => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktifIdKab($id_kabs)->result_array(),
            'jabatan'           => $this->Keanggotaan_model->getDataJabatan()->result_array(),
            'kepengurusan'      => $this->Sayap_partai_model->getDataKepengurusanSayapPartaibyIdKab($id_kab, $id_sayap_partai)->result_array(),
            'wilayah'           => $this->Sayap_partai_model->getDataKabupatenById($id_kab)->result_array()
        ];

        $id = $this->uri->segment(3);
        $this->session->set_userdata('id', $id);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('sayap_partai/detailSayapPartaiKabupaten',$data);
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
            redirect('sayap_partai/detailSayapPartaiKabupaten/'.$this->session->userdata('id'));
        }
        else
        {
            $this->Sayap_partai_model->tambahDataKepengurusanKabupaten();
            // $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            //                                     <strong>Sukses!</strong> Data Berhasil Ditambahkan.
            //                                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            //                                     <span aria-hidden="true">&times;</span>
            //                                     </button>
            //                                 </div>');
            redirect('sayap_partai/detailSayapPartaiKabupaten/'.$this->session->userdata('id'));
        }
    }
    
    public function editKepengurusanKabupaten($id_pengurus_sayap_partai)
    {
        $data = [
            'title'     => 'Sayap Partai',
            'aktif'     => 'sayap_partai',
            'sub'       => 'sp-kabupaten',
            'data'      => $this->Sayap_partai_model->getDataPengurusSayapPartaiById($id_pengurus_sayap_partai)->result_array(),
            'jabatan'   => $this->Keanggotaan_model->getDataJabatan()->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('sayap_partai/editKepengurusanKabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function editKepengurusan_proses_kabupaten($id_pengurus_sayap_partai)
    {
        $this->_rulesEditKepengurusan();

        if($this->form_validation->run() == FALSE)
        {
            $this->editKepengurusanKabupaten($id_pengurus_sayap_partai);

            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> Data Gagal Diubah.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        }
        else
        {
            $this->Sayap_partai_model->editKepengurusan($id_pengurus_sayap_partai);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('sayap_partai/detailSayapPartaiKabupaten/'.$this->session->userdata('id'));
        }
    }

    public function hapusKepengurusanKabupaten($id_pengurus_sayap_partai)
    {
        $this->db->where('id_pengurus_sayap_partai', $id_pengurus_sayap_partai);
        $this->db->delete('tb_pengurus_sayap_partai');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        redirect('sayap_partai/detailSayapPartaiKabupaten/'.$this->session->userdata('id'));
    }

    //---------------------------KECAMATAN---------------------------//

    public function kecamatan()
    {
        $data = [
            'title'     => 'Sayap Partai',
            'aktif'     => 'sayap_partai',
            'sub'       => 'sp-kecamatan',
            'wilayahKab'   => $this->Wilayah_kab_model->getDataWilayah()->result(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('sayap_partai/kecamatan',$data);
		$this->load->view('templates/footer');
    }

    public function struktur_kecamatan($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Sayap Partai',
            'aktif'         => 'sayap_partai',
            'sub'           => 'sp-kecamatan',
            'wilayahKec'    => $this->Sayap_partai_model->getDataKecamatanById($id_kab)->result(),
        ];

        $id_kab = $this->uri->segment(3);
        $this->session->set_userdata('id_kab', $id_kab);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('sayap_partai/struktur_kecamatan',$data);
		$this->load->view('templates/footer');
    }

    public function struktur_sayap_partai($id_kec)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_kec,0,-3);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Sayap Partai',
            'aktif'     => 'sayap_partai',
            'sub'       => 'sp-kecamatan',
            'data'      => $this->Sayap_partai_model->getDataSayapPartai()->result()
        ];

        $id_kec = $this->uri->segment(3);
        $this->session->set_userdata('id_kec', $id_kec);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('sayap_partai/struktur_sayap_partai',$data);
		$this->load->view('templates/footer');
    }

    public function detailSayapPartaiKecamatan($id_sayap_partai)
    {
        $id_kab = $this->session->userdata('id_kab');
        $id_kec = $this->session->userdata('id_kec');

        $user = $this->session->userdata('userdata');
        $id_kabs = $user['id_kab'];

        $data = [
            'title'             => 'Sayap Partai',
            'aktif'             => 'sayap_partai',
            'sub'               => 'sp-kecamatan',
            'dom'               => $this->Sayap_partai_model->getDataSayapPartaiDomKec($id_kec,$id_sayap_partai)->result_array(),
            'sayap'             => $this->Sayap_partai_model->getDataSayapPartaiById($id_sayap_partai)->result_array(),
            'data'              => $this->Sayap_partai_model->getDataWilayahKecById($id_kec, $id_sayap_partai)->result_array(),
            'keanggotaan'       => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktif()->result_array(),
            'keanggotaanKab'    => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktifIdKab($id_kabs)->result_array(),
            'jabatan'           => $this->Keanggotaan_model->getDataJabatan()->result_array(),
            'kepengurusan'      => $this->Sayap_partai_model->getDataKepengurusanSayapPartaibyIdKec($id_kec, $id_sayap_partai)->result_array(),
            'wilayahKec'        => $this->Sayap_partai_model->getDataKecamatanByIdKec($id_kec)->result_array(),
            'wilayah'           => $this->Sayap_partai_model->getDataKabupatenById($id_kab)->result_array()
        ];

        $id = $this->uri->segment(3);
        $this->session->set_userdata('id', $id);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('sayap_partai/detailSayapPartaiKecamatan',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_kepengurusan_proses_kecamatan()
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
            redirect('sayap_partai/detailSayapPartaiKecamatan/'.$this->session->userdata('id'));
        }
        else
        {
            $this->Sayap_partai_model->tambahDataKepengurusanKecamatan();
            // $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            //                                     <strong>Sukses!</strong> Data Berhasil Ditambahkan.
            //                                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            //                                     <span aria-hidden="true">&times;</span>
            //                                     </button>
            //                                 </div>');
            redirect('sayap_partai/detailSayapPartaiKecamatan/'.$this->session->userdata('id'));
        }
    }

    public function editKepengurusanKecamatan($id_pengurus_sayap_partai)
    {
        $data = [
            'title'     => 'Sayap Partai',
            'aktif'     => 'sayap_partai',
            'sub'       => 'sp-kecamatan',
            'data'      => $this->Sayap_partai_model->getDataPengurusSayapPartaiById($id_pengurus_sayap_partai)->result_array(),
            'jabatan'   => $this->Keanggotaan_model->getDataJabatan()->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('sayap_partai/editKepengurusanKecamatan',$data);
		$this->load->view('templates/footer');
    }

    public function editKepengurusan_proses_kecamatan($id_pengurus_sayap_partai)
    {
        $this->_rulesEditKepengurusan();

        if($this->form_validation->run() == FALSE)
        {
            $this->editKepengurusanKecamatan($id_pengurus_sayap_partai);

            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> Data Gagal Diubah.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        }
        else
        {
            $this->Sayap_partai_model->editKepengurusan($id_pengurus_sayap_partai);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('sayap_partai/detailSayapPartaiKecamatan/'.$this->session->userdata('id'));
        }
    }

    public function hapusKepengurusanKecamatan($id_pengurus_sayap_partai)
    {
        $this->db->where('id_pengurus_sayap_partai', $id_pengurus_sayap_partai);
        $this->db->delete('tb_pengurus_sayap_partai');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        redirect('sayap_partai/detailSayapPartaiKecamatan/'.$this->session->userdata('id'));
    }

    public function tambahDomSayapPartaiProv()
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_sayap_partai = $this->session->userdata('id');

        $data = [
            'title'     => 'Sayap Partai',
            'aktif'     => 'sayap_partai',
            'sub'       => 'sp-prov',
            'sayap'     => $this->Sayap_partai_model->getDataSayapPartaiByIdPartai($id_sayap_partai)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('sayap_partai/tambahDomSayapPartaiProv',$data);
		$this->load->view('templates/footer');
    }

    public function tambahDomSayapPartaiKab()
    {
        $id_kab = $this->session->userdata('id_kab');
        $id_sayap_partai = $this->session->userdata('id');

        $data = [
            'title'     => 'Sayap Partai',
            'aktif'     => 'sayap_partai',
            'sub'       => 'sp-kabupaten',
            'sayap'     => $this->Sayap_partai_model->getDataSayapPartaiByIdPartai($id_sayap_partai)->result_array(),
            'wilayah'   => $this->Sayap_partai_model->getDataKabupatenById($id_kab)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('sayap_partai/tambahDomSayapPartaiKab',$data);
		$this->load->view('templates/footer');
    }

    public function tambahDomSayapPartaiKec()
    {
        $id_kec = $this->session->userdata('id_kec');
        $id_sayap_partai = $this->session->userdata('id');

        $data = [
            'title'     => 'Sayap Partai',
            'aktif'     => 'sayap_partai',
            'sub'       => 'sp-kecamatan',
            'sayap'     => $this->Sayap_partai_model->getDataSayapPartaiByIdPartai($id_sayap_partai)->result_array(),
            'wilayah'   => $this->Sayap_partai_model->getDataKecamatanByIdKec($id_kec)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('sayap_partai/tambahDomSayapPartaiKec',$data);
		$this->load->view('templates/footer');
    }

    public function tambahDomSayapPartaiProv_proses()
    {
        $user = $this->session->userdata('userdata');
        $this->_rulesDomSayapPartai();

        if($this->form_validation->run() == FALSE)
        {
            $this->tambahDomSayapPartaiProv();
        }
        else
        {
            //setting config untuk library upload
            $config['upload_path']      = './uploads';
            $config['allowed_types']    = 'gif|jpg|png|pdf';
            $config['encrypt_name']     = true;
            $config['max_size']         = 1000000000;
            $config['max_width']        = 1024000;
            $config['max_height']       = 768000;

            //pemanggilan librabry upload
            $this->load->library('upload', $config);

            //jika upload gagal
            if(!$this->upload->do_upload('foto_kantor') || !$this->upload->do_upload('scan_sk') )
            {

                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                               <strong>Error!</strong> Data Gagal Ditambah. [Foto Harus dan Scan SK wajib diisi]
                                               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                               <span aria-hidden="true">&times;</span>
                                               </button>
                                           </div>');
                redirect('sayap_partai/tambahDomSayapPartaiProv');
            }
            else
            {
                $this->upload->do_upload('foto_kantor');
                $foto_kantor = $this->upload->data();
                $foto = $foto_kantor['file_name'];

                $this->upload->do_upload('scan_sk');
                $scan_sk = $this->upload->data();
                $scan = $scan_sk['file_name'];

                $this->Sayap_partai_model->tambahDomSayapPartaiProv($foto, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                               <strong>Sukses!</strong> Data Berhasil Ditambah.
                                               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                               <span aria-hidden="true">&times;</span>
                                               </button>
                                           </div>');
                if($user['id_kab']){
                    redirect('sayap_partai/indexAdmKabSayapPartaikabupaten');
                }
                else
                {
                    redirect('sayap_partai/detailSayapPartaiProvinsi/'.$this->session->userdata('id'));
                }
            }
        }
    }

    public function tambahDomSayapPartaiKab_proses()
    {
        $user = $this->session->userdata('userdata');
        $this->_rulesDomSayapPartai();

        if($this->form_validation->run() == FALSE)
        {
            $this->tambahDomSayapPartaiKab();
        }
        else
        {
            //setting config untuk library upload
            $config['upload_path']      = './uploads';
            $config['allowed_types']    = 'gif|jpg|png|pdf';
            $config['encrypt_name']     = true;
            $config['max_size']         = 1000000000;
            $config['max_width']        = 1024000;
            $config['max_height']       = 768000;

            //pemanggilan librabry upload
            $this->load->library('upload', $config);

            //jika upload gagal
            if(!$this->upload->do_upload('foto_kantor') || !$this->upload->do_upload('scan_sk'))
            {

                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                               <strong>Error!</strong> Data Gagal Ditambah. [Foto Harus dan Scan SK wajib diisi]
                                               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                               <span aria-hidden="true">&times;</span>
                                               </button>
                                           </div>');
                redirect('sayap_partai/tambahDomSayapPartaiKab');
            }
            else
            {
                $this->upload->do_upload('foto_kantor');
                $foto_kantor = $this->upload->data();
                $foto = $foto_kantor['file_name'];

                $this->upload->do_upload('scan_sk');
                $scan_sk = $this->upload->data();
                $scan = $scan_sk['file_name'];

                $this->Sayap_partai_model->tambahDomSayapPartaiKab($foto, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                               <strong>Sukses!</strong> Data Berhasil Ditambah.
                                               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                               <span aria-hidden="true">&times;</span>
                                               </button>
                                           </div>');
                if($user['id_kab']){
                    redirect('sayap_partai/indexAdmKabSayapPartaikabupaten');
                }
                else
                {
                    redirect('sayap_partai/detailSayapPartaiKabupaten/'.$this->session->userdata('id'));
                }
            }
        }
    }

    public function tambahDomSayapPartaiKec_proses()
    {
        $user = $this->session->userdata('userdata');
        $this->_rulesDomSayapPartai();

        if($this->form_validation->run() == FALSE)
        {
            $this->tambahDomSayapPartaiKec();
        }
        else
        {
            //setting config untuk library upload
            $config['upload_path']      = './uploads';
            $config['allowed_types']    = 'gif|jpg|png|pdf';
            $config['encrypt_name']     = true;
            $config['max_size']         = 1000000000;
            $config['max_width']        = 1024000;
            $config['max_height']       = 768000;

            //pemanggilan librabry upload
            $this->load->library('upload', $config);

            //jika upload gagal
            if(!$this->upload->do_upload('foto_kantor') || !$this->upload->do_upload('scan_sk'))
            {

                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                               <strong>Error!</strong> Data Gagal Ditambah. [Foto Harus dan Scan SK wajib diisi]
                                               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                               <span aria-hidden="true">&times;</span>
                                               </button>
                                           </div>');
                redirect('sayap_partai/tambahDomSayapPartaiKec');
            }
            else
            {
                $this->upload->do_upload('foto_kantor');
                $foto_kantor = $this->upload->data();
                $foto = $foto_kantor['file_name'];

                $this->upload->do_upload('scan_sk');
                $scan_sk = $this->upload->data();
                $scan = $scan_sk['file_name'];

                $this->Sayap_partai_model->tambahDomSayapPartaiKec($foto, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                               <strong>Sukses!</strong> Data Berhasil Ditambah.
                                               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                               <span aria-hidden="true">&times;</span>
                                               </button>
                                           </div>');
                if($user['id_kab']){
                    redirect('sayap_partai/indexAdmKabSayapPartaikabupaten');
                }
                else
                {
                    redirect('sayap_partai/detailSayapPartaiKecamatan/'.$this->session->userdata('id'));
                }
            }
        }
    }

    public function editDomSayapPartaiProv($id_dom_sayap_partai)
    {
        $data = [
            'title'     => 'Sayap Partai',
            'aktif'     => 'sayap_partai',
            'sub'       => 'sp-prov',
            'data'      => $this->Sayap_partai_model->getDataDomSayapPartaiById($id_dom_sayap_partai)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('sayap_partai/editDomSayapPartaiProv',$data);
		$this->load->view('templates/footer');
    }

    public function editDomSayapPartaiKab($id_dom_sayap_partai)
    {
        $data = [
            'title'     => 'Sayap Partai',
            'aktif'     => 'sayap_partai',
            'sub'       => 'sp-kabupaten',
            'data'      => $this->Sayap_partai_model->getDataDomSayapPartaiById($id_dom_sayap_partai)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('sayap_partai/editDomSayapPartaiKab',$data);
		$this->load->view('templates/footer');
    }

    public function editDomSayapPartaiKec($id_dom_sayap_partai)
    {
        $data = [
            'title'     => 'Sayap Partai',
            'aktif'     => 'sayap_partai',
            'sub'       => 'sp-kecamatan',
            'data'      => $this->Sayap_partai_model->getDataDomSayapPartaiById($id_dom_sayap_partai)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('sayap_partai/editDomSayapPartaiKec',$data);
		$this->load->view('templates/footer');
    }

    public function editDomSayapPartaiProv_proses($id_dom_sayap_partai)
    {
        $this->_rulesDomSayapPartai();

        //setting config untuk library upload
        $config['upload_path']      = './uploads';
        $config['allowed_types']    = 'gif|jpg|png|pdf';
        $config['encrypt_name']     = true;
        $config['max_size']         = 1000000000;
        $config['max_width']        = 1024000;
        $config['max_height']       = 768000;

        //pemanggilan librabry upload
        $this->load->library('upload', $config);

        if($this->form_validation->run() == FALSE)
        {
            $this->editDomSayapPartaiProv($id_dom_sayap_partai);
        }
        else
        {
            if($_FILES["foto_kantor"]["name"] == "" && $_FILES["scan_sk"]["name"])
            {
                $foto_lama = $this->input->post('foto_lama');

                $scan_lama = $this->input->post('scan_lama');
                $qs = $this->db->query("SELECT * FROM tb_dom_sayap_partai WHERE scan_sk = '$scan_lama' ")->row()->scan_sk;
                $s = './uploads/'.$qs;
                unlink($s);

                $this->upload->do_upload('scan_sk');
                $scan_sk = $this->upload->data();
                $scan = $scan_sk['file_name'];

                $this->Sayap_partai_model->editDomProv($id_dom_sayap_partai, $foto_lama, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('sayap_partai/detailSayapPartaiProvinsi/'.$this->session->userdata('id'));
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["scan_sk"]["name"] == "")
            {
                $scan_lama = $this->input->post('scan_lama');

                $foto_lama = $this->input->post('foto_lama');
                $qf = $this->db->query("SELECT * FROM tb_dom_sayap_partai WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qf;
                unlink($f);

                $this->upload->do_upload('foto_kantor');
                $foto_kantor = $this->upload->data();
                $foto = $foto_kantor['file_name'];

                $this->Sayap_partai_model->editDomProv($id_dom_sayap_partai, $foto, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('sayap_partai/detailSayapPartaiProvinsi/'.$this->session->userdata('id'));
            }
            // else if($_FILES["scan_sk"]["name"] == "")
            // {
            //     $scan_lama = $this->input->post('scan_lama');

            //     $this->Sayap_partai_model->editDomProv($id_dom_sayap_partai, $scan_lama);
            //     $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            //                                     <strong>Sukses!</strong> Data Berhasil Diupdate.
            //                                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            //                                     <span aria-hidden="true">&times;</span>
            //                                     </button>
            //                                 </div>');

            //     redirect('sayap_partai/detailSayapPartaiProvinsi/'.$this->session->userdata('id'));
            // }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["scan_sk"]["name"] == "")
            {
                $foto_lama = $this->input->post('foto_lama');
                $scan_lama = $this->input->post('scan_lama');

                $this->Sayap_partai_model->editDomProv($id_dom_sayap_partai, $foto_lama, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('sayap_partai/detailSayapPartaiProvinsi/'.$this->session->userdata('id'));
            }
            else
            {
                //setting config untuk library upload
                $config['upload_path']      = './uploads';
                $config['allowed_types']    = 'gif|jpg|png|pdf';
                $config['encrypt_name']     = true;
                $config['max_size']         = 1000000000;
                $config['max_width']        = 1024000;
                $config['max_height']       = 768000;

                //pemanggilan librabry upload
                $this->load->library('upload', $config);

                //jika upload gagal
                if(!$this->upload->do_upload('foto_kantor') || !$this->upload->do_upload('scan_sk'))
                {
                    $data = [
                        'title'     => 'Sayap Partai',
                        'aktif'     => 'sayap_partai',
                        'sub'       => 'sp-prov',
                        'data'      => $this->Sayap_partai_model->getDataDomSayapPartaiById($id_dom_sayap_partai)->result_array()
                    ];
            
                    $this->load->view('templates/header');
                    $this->load->view('templates/sidebar',$data);
                    $this->load->view('sayap_partai/editDomProv',$data);
                    $this->load->view('templates/footer');
                }
                else
                {
                    $foto_lama = $this->input->post('foto_lama');
                    $scan_lama = $this->input->post('scan_lama');

                    $qf = $this->db->query("SELECT * FROM tb_dom_sayap_partai WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                    $qs = $this->db->query("SELECT * FROM tb_dom_sayap_partai WHERE scan_sk = '$scan_lama' ")->row()->scan_sk;

                    $f = './uploads/'.$qf;
                    unlink($f);

                    $s = './uploads/'.$qs;
                    unlink($s);

                    $this->upload->do_upload('foto_kantor');
                    $foto_kantor = $this->upload->data();
                    $foto = $foto_kantor['file_name'];

                    $this->upload->do_upload('scan_sk');
                    $scan_sk = $this->upload->data();
                    $scan = $scan_sk['file_name'];
                    
                    $this->Sayap_partai_model->editDomProv($id_dom_sayap_partai, $foto, $scan);
                    $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');

                    redirect('sayap_partai/detailSayapPartaiProvinsi/'.$this->session->userdata('id'));
                }
            }
        }
    }

    public function editDomSayapPartaiKab_proses($id_dom_sayap_partai)
    {
        $this->_rulesDomSayapPartai();

        //setting config untuk library upload
        $config['upload_path']      = './uploads';
        $config['allowed_types']    = 'gif|jpg|png|pdf';
        $config['encrypt_name']     = true;
        $config['max_size']         = 1000000000;
        $config['max_width']        = 1024000;
        $config['max_height']       = 768000;

        //pemanggilan librabry upload
        $this->load->library('upload', $config);

        if($this->form_validation->run() == FALSE)
        {
            $this->editDomSayapPartaiKab($id_dom_sayap_partai);
        }
        else
        {
            if($_FILES["foto_kantor"]["name"] == "" && $_FILES["scan_sk"]["name"])
            {
                $foto_lama = $this->input->post('foto_lama');

                $scan_lama = $this->input->post('scan_lama');
                $qs = $this->db->query("SELECT * FROM tb_dom_sayap_partai WHERE scan_sk = '$scan_lama' ")->row()->scan_sk;
                $s = './uploads/'.$qs;
                unlink($s);

                $this->upload->do_upload('scan_sk');
                $scan_sk = $this->upload->data();
                $scan = $scan_sk['file_name'];

                $this->Sayap_partai_model->editDomKab($id_dom_sayap_partai, $foto_lama, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');

                redirect('sayap_partai/detailSayapPartaiKabupaten/'.$this->session->userdata('id'));
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["scan_sk"]["name"] == "")
            {
                $scan_lama = $this->input->post('scan_lama');

                $foto_lama = $this->input->post('foto_lama');
                $qf = $this->db->query("SELECT * FROM tb_dom_sayap_partai WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qf;
                unlink($f);

                $this->upload->do_upload('foto_kantor');
                $foto_kantor = $this->upload->data();
                $foto = $foto_kantor['file_name'];


                $this->Sayap_partai_model->editDomKab($id_dom_sayap_partai, $foto, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');

                redirect('sayap_partai/detailSayapPartaiKabupaten/'.$this->session->userdata('id'));
            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["scan_sk"]["name"] == "")
            {
                $foto_lama = $this->input->post('foto_lama');
                $scan_lama = $this->input->post('scan_lama');

                $this->Sayap_partai_model->editDomKab($id_dom_sayap_partai, $foto_lama, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');

                redirect('sayap_partai/detailSayapPartaiKabupaten/'.$this->session->userdata('id'));
            }
            else
            {
                //setting config untuk library upload
                $config['upload_path']      = './uploads';
                $config['allowed_types']    = 'gif|jpg|png|pdf';
                $config['encrypt_name']     = true;
                $config['max_size']         = 1000000000;
                $config['max_width']        = 1024000;
                $config['max_height']       = 768000;

                //pemanggilan librabry upload
                $this->load->library('upload', $config);

                //jika upload gagal
                if(!$this->upload->do_upload('foto_kantor') || !$this->upload->do_upload('scan_sk'))
                {
                    $data = [
                        'title'     => 'Sayap Partai',
                        'aktif'     => 'sayap_partai',
                        'sub'       => 'sp-kabupaten',
                        'data'      => $this->Sayap_partai_model->getDataDomSayapPartaiById($id_dom_sayap_partai)->result_array()
                    ];
            
                    $this->load->view('templates/header');
                    $this->load->view('templates/sidebar',$data);
                    $this->load->view('sayap_partai/editDomKab',$data);
                    $this->load->view('templates/footer');
                }
                else
                {
                    $foto_lama = $this->input->post('foto_lama');
                    $scan_lama = $this->input->post('scan_lama');

                    $qf = $this->db->query("SELECT * FROM tb_dom_sayap_partai WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                    $qs = $this->db->query("SELECT * FROM tb_dom_sayap_partai WHERE scan_sk = '$scan_lama' ")->row()->scan_sk;

                    $f = './uploads/'.$qf;
                    unlink($f);

                    $s = './uploads/'.$qs;
                    unlink($s);

                    $this->upload->do_upload('foto_kantor');
                    $foto_kantor = $this->upload->data();
                    $foto = $foto_kantor['file_name'];

                    $this->upload->do_upload('scan_sk');
                    $scan_sk = $this->upload->data();
                    $scan = $scan_sk['file_name'];
                    
                    $this->Sayap_partai_model->editDomKab($id_dom_sayap_partai, $foto, $scan);
                    $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');

                    redirect('sayap_partai/detailSayapPartaiKabupaten/'.$this->session->userdata('id'));
                }
            }
        }
    }

    public function editDomSayapPartaiKec_proses($id_dom_sayap_partai)
    {
        $this->_rulesDomSayapPartai();

        //setting config untuk library upload
        $config['upload_path']      = './uploads';
        $config['allowed_types']    = 'gif|jpg|png|pdf';
        $config['encrypt_name']     = true;
        $config['max_size']         = 1000000000;
        $config['max_width']        = 1024000;
        $config['max_height']       = 768000;

        //pemanggilan librabry upload
        $this->load->library('upload', $config);

        if($this->form_validation->run() == FALSE)
        {
            $this->editDomSayapPartaiKec($id_dom_sayap_partai);
        }
        else
        {
            if($_FILES["foto_kantor"]["name"] == "" && $_FILES["scan_sk"]["name"])
            {
                $foto_lama = $this->input->post('foto_lama');

                $scan_lama = $this->input->post('scan_lama');
                $qs = $this->db->query("SELECT * FROM tb_dom_sayap_partai WHERE scan_sk = '$scan_lama' ")->row()->scan_sk;
                $s = './uploads/'.$qs;
                unlink($s);

                $this->upload->do_upload('scan_sk');
                $scan_sk = $this->upload->data();
                $scan = $scan_sk['file_name'];

                $this->Sayap_partai_model->editDomKec($id_dom_sayap_partai, $foto_lama, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');

                redirect('sayap_partai/detailSayapPartaiKecamatan/'.$this->session->userdata('id'));
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["scan_sk"]["name"] == "")
            {
                $scan_lama = $this->input->post('scan_lama');

                $foto_lama = $this->input->post('foto_lama');
                $qf = $this->db->query("SELECT * FROM tb_dom_sayap_partai WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qf;
                unlink($f);

                $this->upload->do_upload('foto_kantor');
                $foto_kantor = $this->upload->data();
                $foto = $foto_kantor['file_name'];

                $this->Sayap_partai_model->editDomKec($id_dom_sayap_partai, $foto, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');

                redirect('sayap_partai/detailSayapPartaiKecamatan/'.$this->session->userdata('id'));
            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["scan_sk"]["name"] == "")
            {
                $foto_lama = $this->input->post('foto_lama');
                $scan_lama = $this->input->post('scan_lama');

                $this->Sayap_partai_model->editDomKec($id_dom_sayap_partai, $foto_lama, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');

                redirect('sayap_partai/detailSayapPartaiKecamatan/'.$this->session->userdata('id'));
            }
            else
            {
                //setting config untuk library upload
                $config['upload_path']      = './uploads';
                $config['allowed_types']    = 'gif|jpg|png|pdf';
                $config['encrypt_name']     = true;
                $config['max_size']         = 1000000000;
                $config['max_width']        = 1024000;
                $config['max_height']       = 768000;

                //pemanggilan librabry upload
                $this->load->library('upload', $config);

                //jika upload gagal
                if(!$this->upload->do_upload('foto_kantor') || !$this->upload->do_upload('scan_sk'))
                {
                    $data = [
                        'title'     => 'Sayap Partai',
                        'aktif'     => 'sayap_partai',
                        'sub'       => 'sp-kecamatan',
                        'data'      => $this->Sayap_partai_model->getDataDomSayapPartaiById($id_dom_sayap_partai)->result_array()
                    ];
            
                    $this->load->view('templates/header');
                    $this->load->view('templates/sidebar',$data);
                    $this->load->view('sayap_partai/editDomKec',$data);
                    $this->load->view('templates/footer');
                }
                else
                {
                    $foto_lama = $this->input->post('foto_lama');
                    $scan_lama = $this->input->post('scan_lama');

                    $qf = $this->db->query("SELECT * FROM tb_dom_sayap_partai WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                    $qs = $this->db->query("SELECT * FROM tb_dom_sayap_partai WHERE scan_sk = '$scan_lama' ")->row()->scan_sk;

                    $f = './uploads/'.$qf;
                    unlink($f);

                    $s = './uploads/'.$qs;
                    unlink($s);

                    $this->upload->do_upload('foto_kantor');
                    $foto_kantor = $this->upload->data();
                    $foto = $foto_kantor['file_name'];

                    $this->upload->do_upload('scan_sk');
                    $scan_sk = $this->upload->data();
                    $scan = $scan_sk['file_name'];
                    
                    $this->Sayap_partai_model->editDomKec($id_dom_sayap_partai, $foto, $scan);
                    $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');

                    redirect('sayap_partai/detailSayapPartaiKecamatan/'.$this->session->userdata('id'));
                }
            }
        }
    }

    // public function detailSayapPartai($id_sayap_partai)
    // {
    //     $id_kab = $this->session->userdata('id');

    //     $data = [
    //         'title'     => 'Sayap Partai',
    //         'aktif'     => 'sayap_partai',
    //         'keanggotaan'   => $this->Keanggotaan_model->getDataKeanggotaan()->result_array(),
    //         'jabatan'       => $this->Keanggotaan_model->getDataJabatan()->result_array(),
    //         // 'kepengurusan'  => $this->Sayap_partai_model->getDataKepengurusanSayapPartaibyId($id_sayap_partai)->result_array()
    //     ];

    //     $this->load->view('templates/header');
	// 	$this->load->view('templates/sidebar',$data);
	// 	$this->load->view('sayap_partai/detailSayapPartai',$data);
	// 	$this->load->view('templates/footer');
    // }

    public function _rulesDomSayapPartai()
    {
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Alamat wajib diisi'
        ]);
        
        $this->form_validation->set_rules('no_telp', 'No Telp', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> No Telp wajib diisi'
        ]);
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