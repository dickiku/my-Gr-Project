<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Simpul_jaringan extends CI_Controller{


    public function __construct()
    {
        parent::__construct();
        
        $user = $this->session->userdata('userdata');
        if($user['level'] != 'Admin' && $user['level'] != 'Super Admin')
        {
            redirect('admin/auth');
        }
    }

    public function indexAdmKabTogaTomasKabupaten()
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $data = [
            'title'         => 'Simpul Jaringan - Toga Tomas',
            'aktif'         => 'toga_tomas',
            'sub'           => 'tt-kab',
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/toga_tomas/toga_tomas_kabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function indexAdmKabKpuKabupaten()
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $data = [
            'title'         => 'Simpul Jaringan - KPU',
            'aktif'         => 'kpu',
            'sub'           => 'kpu-kab',
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/kpu/kpu_kabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function indexAdmKabBawasluKabupaten()
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $data = [
            'title'         => 'Simpul Jaringan - Bawaslu',
            'aktif'         => 'bawaslu',
            'sub'           => 'bawaslu-kab',
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/bawaslu/bawaslu_kabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function indexAdmKabPolriKabupaten()
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $data = [
            'title'         => 'Simpul Jaringan - POLRI',
            'aktif'         => 'polri',
            'sub'           => 'polri-kab',
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/polri/polri_kabupaten',$data);
        $this->load->view('templates/footer');
    }

    public function indexAdmKabTniKabupaten()
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $data = [
            'title'         => 'Simpul Jaringan - TNI',
            'aktif'         => 'tni',
            'sub'           => 'tni-kab',
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/tni/tni_kabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function indexAdmKabRelawanKabupaten()
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $data = [
            'title'         => 'Simpul Jaringan - Relawan',
            'aktif'         => 'relawan',
            'sub'           => 'relawan-kab',
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/relawan/relawan_kabupaten',$data);
		$this->load->view('templates/footer');
    }

    //=============================ADMIN SEMUA=============================//
    //=============================TOGA TOMAS=============================//
    
    public function toga_tomas()
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Simpul Jaringan - Toga Tomas',
            'aktif'     => 'toga_tomas',
            'sub'       => 'tt-prov',
            'data'      => $this->Toga_tomas_model->getDataTogaTomasProvinsi()->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/toga_tomas/index',$data);
		$this->load->view('templates/footer');
    }

    public function toga_tomas_kabupaten()
    {
        $data = [
            'title'         => 'Simpul Jaringan - Toga Tomas',
            'aktif'         => 'toga_tomas',
            'sub'           => 'tt-kab',
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayah()->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/toga_tomas/toga_tomas_kabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_toga_tomas_provinsi()
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->toga_tomas();
        }
        else
        {
            $this->Toga_tomas_model->tambahDataProvinsi();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('simpul_jaringan/toga_tomas');
        }
    }

    public function editTogaTomasProvinsi($id_toga_tomas)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Simpul Jaringan - Toga Tomas',
            'aktif'     => 'toga_tomas',
            'sub'       => 'tt-prov',
            'data'      => $this->Toga_tomas_model->getDataTogaTomasById($id_toga_tomas)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/toga_tomas/editTogaTomasProvinsi',$data);
		$this->load->view('templates/footer');
    }

    public function editTogaTomas_proses_provinsi($id_toga_tomas)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->editTogaTomasProvinsi($id_toga_tomas);
        }
        else
        {
            $this->Toga_tomas_model->editTogaTomasProvinsi($id_toga_tomas);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('simpul_jaringan/toga_tomas');
        }
    }

    public function hapusTogaTomasProvinsi($id_toga_tomas)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $this->Toga_tomas_model->hapusTogaTomasProvinsi($id_toga_tomas);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
        redirect('simpul_jaringan/toga_tomas');
    }

    public function toga_tomas_cek_kab($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Simpul Jaringan - Toga Tomas',
            'aktif'         => 'toga_tomas',
            'sub'           => 'tt-kab',
            'data'          => $this->Toga_tomas_model->getDataTogaTomasByIdKab($id_kab)->result(),
            'wilayah'       => $this->Toga_tomas_model->getDataWilayahByIdKab($id_kab)->result_array()
        ];

        $id_kab = $this->uri->segment(3);
        $this->session->set_userdata('id_kab', $id_kab);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/toga_tomas/toga_tomas_cek_kab',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_toga_tomas_kabupaten()
    {
        $id_kab = $this->session->userdata('id_kab');

        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->toga_tomas_cek_kab($id_kab);
        }
        else
        {
            $this->Toga_tomas_model->tambahDataKabupaten();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('simpul_jaringan/toga_tomas_cek_kab/'.$this->session->userdata('id_kab'));
        }
    }

    public function editTogaTomasKabupaten($id_toga_tomas)
    {
        $data = [
            'title'     => 'Simpul Jaringan - Toga Tomas',
            'aktif'     => 'toga_tomas',
            'sub'       => 'tt-kab',
            'data'      => $this->Toga_tomas_model->getDataTogaTomasById($id_toga_tomas)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/toga_tomas/editTogaTomasKabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function editTogaTomas_proses_kabupaten($id_toga_tomas)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->editTogaTomasKabupaten($id_toga_tomas);
        }
        else
        {
            $this->Toga_tomas_model->editTogaTomasKabupaten($id_toga_tomas);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('simpul_jaringan/toga_tomas_cek_kab/'.$this->session->userdata('id_kab'));
        }
    }

    public function hapusTogaTomasKabupaten($id_toga_tomas)
    {
        $this->Toga_tomas_model->hapusTogaTomasKabupaten($id_toga_tomas);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
        redirect('simpul_jaringan/toga_tomas_cek_kab/'.$this->session->userdata('id_kab'));
    }

    public function toga_tomas_kecamatan($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Simpul Jaringan - Toga Tomas',
            'aktif'         => 'toga_tomas',
            'sub'           => 'tt-kab',
            'wilayahKec'    => $this->Toga_tomas_model->getDataKecamatanByIdKab($id_kab)->result(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/toga_tomas/toga_tomas_kecamatan',$data);
		$this->load->view('templates/footer');
    }

    public function toga_tomas_cek_kec($id_kec)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_kec,0,-3);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_kab = $this->session->userdata('id_kab');

        $data = [
            'title'         => 'Simpul Jaringan - Toga Tomas',
            'aktif'         => 'toga_tomas',
            'sub'           => 'tt-kab',
            'data'          => $this->Toga_tomas_model->getDataTogaTomasByIdKec($id_kec)->result(),
            'wilayahKab'    => $this->Toga_tomas_model->getDataWilayahByIdKab($id_kab)->result_array(),
            'wilayahKec'    => $this->Toga_tomas_model->getDataWilayahByIdKec($id_kec)->result_array(),
        ];

        $id_kec = $this->uri->segment(3);
        $this->session->set_userdata('id_kec', $id_kec);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/toga_tomas/toga_tomas_cek_kec',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_toga_tomas_kecamatan()
    {
        $id_kec = $this->session->userdata('id_kec');

        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->toga_tomas_cek_kec($id_kec);
        }
        else
        {
            $this->Toga_tomas_model->tambahDataKecamatan();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('simpul_jaringan/toga_tomas_cek_kec/'.$this->session->userdata('id_kec'));
        }
    }

    public function editTogaTomasKecamatan($id_toga_tomas)
    {
        $data = [
            'title'     => 'Simpul Jaringan - Toga Tomas',
            'aktif'     => 'toga_tomas',
            'sub'       => 'tt-kab',
            'data'      => $this->Toga_tomas_model->getDataTogaTomasById($id_toga_tomas)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/toga_tomas/editTogaTomasKecamatan',$data);
		$this->load->view('templates/footer');
    }

    public function editTogaTomas_proses_kecamatan($id_toga_tomas)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->editTogaTomasKecamatan($id_toga_tomas);
        }
        else
        {
            $this->Toga_tomas_model->editTogaTomasKecamatan($id_toga_tomas);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('simpul_jaringan/toga_tomas_cek_kec/'.$this->session->userdata('id_kec'));
        }
    }

    public function hapusTogaTomasKecamatan($id_toga_tomas)
    {
        $this->Toga_tomas_model->hapusTogaTomasKecamatan($id_toga_tomas);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
        redirect('simpul_jaringan/toga_tomas_cek_kec/'.$this->session->userdata('id_kec'));
    }

    public function toga_tomas_desa($id_kec)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_kec,0,-3);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Simpul Jaringan - Toga Tomas',
            'aktif'         => 'toga_tomas',
            'sub'           => 'tt-kab',
            'wilayahDesa'   => $this->Toga_tomas_model->getDataDesaByIdKab($id_kec)->result(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/toga_tomas/toga_tomas_desa',$data);
		$this->load->view('templates/footer');
    }

    public function toga_tomas_cek_desa($id_desa)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_desa,0,-8);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_kab = $this->session->userdata('id_kab');
        $id_kec = $this->session->userdata('id_kec');

        $data = [
            'title'         => 'Simpul Jaringan - Toga Tomas',
            'aktif'         => 'toga_tomas',
            'sub'           => 'tt-kab',
            'data'          => $this->Toga_tomas_model->getDataTogaTomasByIdDesa($id_desa)->result(),
            'wilayahKab'    => $this->Toga_tomas_model->getDataWilayahByIdKab($id_kab)->result_array(),
            'wilayahKec'    => $this->Toga_tomas_model->getDataWilayahByIdKec($id_kec)->result_array(),
            'wilayahDesa'   => $this->Toga_tomas_model->getDataWilayahByIdDesa($id_desa)->result_array(),
        ];

        $id_desa = $this->uri->segment(3);
        $this->session->set_userdata('id_desa', $id_desa);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/toga_tomas/toga_tomas_cek_desa',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_toga_tomas_desa()
    {
        $id_desa = $this->session->userdata('id_desa');

        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->toga_tomas_cek_desa($id_desa);
        }
        else
        {
            $this->Toga_tomas_model->tambahDataDesa();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('simpul_jaringan/toga_tomas_cek_desa/'.$this->session->userdata('id_desa'));
        }
    }

    public function editTogaTomasDesa($id_toga_tomas)
    {
        $data = [
            'title'     => 'Simpul Jaringan - Toga Tomas',
            'aktif'     => 'toga_tomas',
            'sub'       => 'tt-kab',
            'data'      => $this->Toga_tomas_model->getDataTogaTomasById($id_toga_tomas)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/toga_tomas/editTogaTomasDesa',$data);
		$this->load->view('templates/footer');
    }

    public function editTogaTomas_proses_desa($id_toga_tomas)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->editTogaTomasDesa($id_toga_tomas);
        }
        else
        {
            $this->Toga_tomas_model->editTogaTomasDesa($id_toga_tomas);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('simpul_jaringan/toga_tomas_cek_desa/'.$this->session->userdata('id_desa'));
        }
    }

    public function hapusTogaTomasDesa($id_toga_tomas)
    {
        $this->Toga_tomas_model->hapusTogaTomasDesa($id_toga_tomas);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
        redirect('simpul_jaringan/toga_tomas_cek_desa/'.$this->session->userdata('id_desa'));
    }
//=============================KPU=============================//

    public function kpu()
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Simpul Jaringan - KPU',
            'aktif'     => 'kpu',
            'sub'       => 'kpu-prov',
            'data'      => $this->Kpu_model->getDataKpuProvinsi()->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/kpu/index',$data);
		$this->load->view('templates/footer');
    }

    public function kpu_kabupaten()
    {
        $data = [
            'title'         => 'Simpul Jaringan - KPU',
            'aktif'         => 'kpu',
            'sub'           => 'kpu-kab',
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayah()->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/kpu/kpu_kabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_kpu_provinsi()
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->kpu();
        }
        else
        {
            $this->Kpu_model->tambahDataProvinsi();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('simpul_jaringan/kpu');
        }
    }

    public function editKpuProvinsi($id_kpu)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Simpul Jaringan - KPU',
            'aktif'     => 'kpu',
            'sub'       => 'kpu-prov',
            'data'      => $this->Kpu_model->getDataKpuById($id_kpu)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/kpu/editKpuProvinsi',$data);
		$this->load->view('templates/footer');
    }

    public function editKpu_proses_provinsi($id_kpu)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->editKpuProvinsi($id_kpu);
        }
        else
        {
            $this->Kpu_model->editKpuProvinsi($id_kpu);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('simpul_jaringan/kpu');
        }
    }

    public function hapusKpuProvinsi($id_kpu)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $this->Kpu_model->hapusKpuProvinsi($id_kpu);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
        redirect('simpul_jaringan/kpu');
    }

    public function kpu_cek_kab($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Simpul Jaringan - KPU',
            'aktif'         => 'kpu',
            'sub'           => 'kpu-kab',
            'data'          => $this->Kpu_model->getDataKpuByIdKab($id_kab)->result(),
            'wilayah'       => $this->Kpu_model->getDataWilayahByIdKab($id_kab)->result_array()
        ];

        $id_kab = $this->uri->segment(3);
        $this->session->set_userdata('id_kab', $id_kab);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/kpu/kpu_cek_kab',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_kpu_kabupaten()
    {
        $id_kab = $this->session->userdata('id_kab');

        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->kpu_cek_kab($id_kab);
        }
        else
        {
            $this->Kpu_model->tambahDataKabupaten();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('simpul_jaringan/kpu_cek_kab/'.$this->session->userdata('id_kab'));
        }
    }

    public function editKpuKabupaten($id_kpu)
    {
        $data = [
            'title'     => 'Simpul Jaringan - KPU',
            'aktif'     => 'kpu',
            'sub'       => 'kpu-kab',
            'data'      => $this->Kpu_model->getDataKpuById($id_kpu)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/kpu/editKpuKabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function editKpu_proses_kabupaten($id_kpu)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->editKpuKabupaten($id_kpu);
        }
        else
        {
            $this->Kpu_model->editKpuKabupaten($id_kpu);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('simpul_jaringan/kpu_cek_kab/'.$this->session->userdata('id_kab'));
        }
    }

    public function hapusKpuKabupaten($id_kpu)
    {
        $this->Kpu_model->hapusKpuKabupaten($id_kpu);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
        redirect('simpul_jaringan/kpu_cek_kab/'.$this->session->userdata('id_kab'));
    }

    public function kpu_kecamatan($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Simpul Jaringan - KPU',
            'aktif'         => 'kpu',
            'sub'           => 'kpu-kab',
            'wilayahKec'    => $this->Kpu_model->getDataKecamatanByIdKab($id_kab)->result(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/kpu/kpu_kecamatan',$data);
		$this->load->view('templates/footer');
    }

    public function kpu_cek_kec($id_kec)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_kec,0,-3);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_kab = $this->session->userdata('id_kab');

        $data = [
            'title'         => 'Simpul Jaringan - KPU',
            'aktif'         => 'kpu',
            'sub'           => 'kpu-kab',
            'data'          => $this->Kpu_model->getDataKpuByIdKec($id_kec)->result(),
            'wilayahKab'    => $this->Kpu_model->getDataWilayahByIdKab($id_kab)->result_array(),
            'wilayahKec'    => $this->Kpu_model->getDataWilayahByIdKec($id_kec)->result_array(),
        ];

        $id_kec = $this->uri->segment(3);
        $this->session->set_userdata('id_kec', $id_kec);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/kpu/kpu_cek_kec',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_kpu_kecamatan()
    {
        $id_kec = $this->session->userdata('id_kec');

        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->kpu_cek_kec($id_kec);
        }
        else
        {
            $this->Kpu_model->tambahDataKecamatan();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('simpul_jaringan/kpu_cek_kec/'.$this->session->userdata('id_kec'));
        }
    }

    public function editKpuKecamatan($id_kpu)
    {
        $data = [
            'title'     => 'Simpul Jaringan - KPU',
            'aktif'     => 'kpu',
            'sub'       => 'kpu-kab',
            'data'      => $this->Kpu_model->getDataKpuById($id_kpu)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/kpu/editKpuKecamatan',$data);
		$this->load->view('templates/footer');
    }

    public function editKpu_proses_kecamatan($id_kpu)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->editKpuKecamatan($id_kpu);
        }
        else
        {
            $this->Kpu_model->editKpuKecamatan($id_kpu);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('simpul_jaringan/kpu_cek_kec/'.$this->session->userdata('id_kec'));
        }
    }

    public function hapusKpuKecamatan($id_kpu)
    {
        $this->Kpu_model->hapusKpuKecamatan($id_kpu);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
        redirect('simpul_jaringan/kpu_cek_kec/'.$this->session->userdata('id_kec'));
    }

    public function kpu_desa($id_desa)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_desa,0,-3);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Simpul Jaringan - KPU',
            'aktif'         => 'kpu',
            'sub'           => 'kpu-kab',
            'wilayahDesa'   => $this->Kpu_model->getDataDesaByIdKab($id_desa)->result(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/kpu/kpu_desa',$data);
		$this->load->view('templates/footer');
    }

    public function kpu_cek_desa($id_desa)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_desa,0,-8);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_kab = $this->session->userdata('id_kab');
        $id_kec = $this->session->userdata('id_kec');

        $data = [
            'title'         => 'Simpul Jaringan - KPU',
            'aktif'         => 'kpu',
            'sub'           => 'kpu-kab',
            'data'          => $this->Kpu_model->getDataKpuByIdDesa($id_desa)->result(),
            'wilayahKab'    => $this->Kpu_model->getDataWilayahByIdKab($id_kab)->result_array(),
            'wilayahKec'    => $this->Kpu_model->getDataWilayahByIdKec($id_kec)->result_array(),
            'wilayahDesa'   => $this->Kpu_model->getDataWilayahByIdDesa($id_desa)->result_array(),
        ];

        $id_desa = $this->uri->segment(3);
        $this->session->set_userdata('id_desa', $id_desa);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/kpu/kpu_cek_desa',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_kpu_desa()
    {
        $id_desa = $this->session->userdata('id_desa');

        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->kpu_cek_desa($id_desa);
        }
        else
        {
            $this->Kpu_model->tambahDataDesa();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('simpul_jaringan/kpu_cek_desa/'.$this->session->userdata('id_desa'));
        }
    }

    public function editKpuDesa($id_kpu)
    {
        $data = [
            'title'     => 'Simpul Jaringan - KPU',
            'aktif'     => 'kpu',
            'sub'       => 'kpu-kab',
            'data'      => $this->Kpu_model->getDataKpuById($id_kpu)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/kpu/editKpuDesa',$data);
		$this->load->view('templates/footer');
    }

    public function editKpu_proses_desa($id_kpu)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->editKpuDesa($id_kpu);
        }
        else
        {
            $this->Kpu_model->editKpuDesa($id_kpu);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('simpul_jaringan/kpu_cek_desa/'.$this->session->userdata('id_desa'));
        }
    }

    public function hapusKpuDesa($id_kpu)
    {
        $this->Kpu_model->hapusKpuDesa($id_kpu);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
        redirect('simpul_jaringan/kpu_cek_desa/'.$this->session->userdata('id_desa'));
    }

//=============================BAWASLU=============================//

    public function bawaslu()
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Simpul Jaringan - Bawaslu',
            'aktif'     => 'bawaslu',
            'sub'       => 'bawaslu-prov',
            'data'      => $this->Bawaslu_model->getDataBawasluProvinsi()->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/bawaslu/index',$data);
		$this->load->view('templates/footer');
    }

    public function bawaslu_kabupaten()
    {
        $data = [
            'title'         => 'Simpul Jaringan - Bawaslu',
            'aktif'         => 'bawaslu',
            'sub'           => 'bawaslu-kab',
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayah()->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/bawaslu/bawaslu_kabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_bawaslu_provinsi()
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->bawaslu();
        }
        else
        {
            $this->Bawaslu_model->tambahDataProvinsi();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('simpul_jaringan/bawaslu');
        }
    }

    public function editBawasluProvinsi($id_bawaslu)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Simpul Jaringan - Bawaslu',
            'aktif'     => 'bawaslu',
            'sub'       => 'bawaslu-prov',
            'data'      => $this->Bawaslu_model->getDataBawasluById($id_bawaslu)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/bawaslu/editBawasluProvinsi',$data);
		$this->load->view('templates/footer');
    }

    public function editBawaslu_proses_provinsi($id_bawaslu)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->editBawasluProvinsi($id_bawaslu);
        }
        else
        {
            $this->Bawaslu_model->editBawasluProvinsi($id_bawaslu);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('simpul_jaringan/bawaslu');
        }
    }

    public function hapusBawasluProvinsi($id_bawaslu)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $this->Bawaslu_model->hapusBawasluProvinsi($id_bawaslu);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
        redirect('simpul_jaringan/bawaslu');
    }

    public function bawaslu_cek_kab($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Simpul Jaringan - Bawaslu',
            'aktif'         => 'bawaslu',
            'sub'           => 'bawaslu-kab',
            'data'          => $this->Bawaslu_model->getDataBawasluByIdKab($id_kab)->result(),
            'wilayah'       => $this->Bawaslu_model->getDataWilayahByIdKab($id_kab)->result_array()
        ];

        $id_kab = $this->uri->segment(3);
        $this->session->set_userdata('id_kab', $id_kab);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/bawaslu/bawaslu_cek_kab',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_bawaslu_kabupaten()
    {
        $id_kab = $this->session->userdata('id_kab');

        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->bawaslu_cek_kab($id_kab);
        }
        else
        {
            $this->Bawaslu_model->tambahDataKabupaten();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('simpul_jaringan/bawaslu_cek_kab/'.$this->session->userdata('id_kab'));
        }
    }

    public function editBawasluKabupaten($id_bawaslu)
    {
        $data = [
            'title'     => 'Simpul Jaringan - Bawaslu',
            'aktif'     => 'bawaslu',
            'sub'       => 'bawaslu-kab',
            'data'      => $this->Bawaslu_model->getDataBawasluById($id_bawaslu)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/bawaslu/editBawasluKabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function editBawaslu_proses_kabupaten($id_bawaslu)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->editBawasluKabupaten($id_bawaslu);
        }
        else
        {
            $this->Bawaslu_model->editBawasluKabupaten($id_bawaslu);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('simpul_jaringan/bawaslu_cek_kab/'.$this->session->userdata('id_kab'));
        }
    }

    public function hapusBawasluKabupaten($id_bawaslu)
    {
        $this->Bawaslu_model->hapusBawasluKabupaten($id_bawaslu);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
        redirect('simpul_jaringan/bawaslu_cek_kab/'.$this->session->userdata('id_kab'));
    }

    function bawaslu_kecamatan($id_kab){

        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Simpul Jaringan - Bawaslu',
            'aktif'         => 'bawaslu',
            'sub'           => 'bawaslu-kab',
            'wilayahKec'    => $this->Bawaslu_model->getDataKecamatanByIdKab($id_kab)->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/bawaslu/bawaslu_kecamatan',$data);
		$this->load->view('templates/footer');
    }

    public function bawaslu_cek_kec($id_kec)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_kec,0,-3);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_kab = $this->session->userdata('id_kab');

        $data = [
            'title'         => 'Simpul Jaringan - Bawaslu',
            'aktif'         => 'bawaslu',
            'sub'           => 'bawaslu-kab',
            'data'          => $this->Bawaslu_model->getDataBawasluByIdKec($id_kec)->result(),
            'wilayahKab'    => $this->Bawaslu_model->getDataWilayahByIdKab($id_kab)->result_array(),
            'wilayahKec'    => $this->Bawaslu_model->getDataWilayahByIdKec($id_kec)->result_array(),
        ];

        $id_kec = $this->uri->segment(3);
        $this->session->set_userdata('id_kec', $id_kec);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/bawaslu/bawaslu_cek_kec',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_bawaslu_kecamatan()
    {
        $id_kec = $this->session->userdata('id_kec');

        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->bawaslu_cek_kec($id_kec);
        }
        else
        {
            $this->Bawaslu_model->tambahDataKecamatan();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('simpul_jaringan/bawaslu_cek_kec/'.$this->session->userdata('id_kec'));
        }
    }

    public function editBawasluKecamatan($id_bawaslu)
    {
        $data = [
            'title'     => 'Simpul Jaringan - Bawaslu',
            'aktif'     => 'bawaslu',
            'sub'       => 'bawaslu-kab',
            'data'      => $this->Bawaslu_model->getDataBawasluById($id_bawaslu)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/bawaslu/editBawasluKecamatan',$data);
		$this->load->view('templates/footer');
    }

    public function editBawaslu_proses_kecamatan($id_bawaslu)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->editBawasluKecamatan($id_bawaslu);
        }
        else
        {
            $this->Bawaslu_model->editBawasluKecamatan($id_bawaslu);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('simpul_jaringan/bawaslu_cek_kec/'.$this->session->userdata('id_kec'));
        }
    }

    public function hapusBawasluKecamatan($id_bawaslu)
    {
        $this->Bawaslu_model->hapusBawasluKecamatan($id_bawaslu);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
        redirect('simpul_jaringan/bawaslu_cek_kec/'.$this->session->userdata('id_kec'));
    }

    public function bawaslu_desa($id_kec)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_kec,0,-3);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Simpul Jaringan - Bawaslu',
            'aktif'         => 'bawaslu',
            'sub'           => 'bawaslu-kab',
            'wilayahDesa'   => $this->Bawaslu_model->getDataDesaByIdKab($id_kec)->result(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/bawaslu/bawaslu_desa',$data);
		$this->load->view('templates/footer');
    }

    public function bawaslu_cek_desa($id_desa)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_desa,0,-8);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_kab = $this->session->userdata('id_kab');
        $id_kec = $this->session->userdata('id_kec');

        $data = [
            'title'         => 'Simpul Jaringan - Bawaslu',
            'aktif'         => 'bawaslu',
            'sub'           => 'bawaslu-kab',
            'data'          => $this->Bawaslu_model->getDataBawasluByIdDesa($id_desa)->result(),
            'wilayahKab'    => $this->Bawaslu_model->getDataWilayahByIdKab($id_kab)->result_array(),
            'wilayahKec'    => $this->Bawaslu_model->getDataWilayahByIdKec($id_kec)->result_array(),
            'wilayahDesa'   => $this->Bawaslu_model->getDataWilayahByIdDesa($id_desa)->result_array(),
        ];

        $id_desa = $this->uri->segment(3);
        $this->session->set_userdata('id_desa', $id_desa);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/bawaslu/bawaslu_cek_desa',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_bawaslu_desa()
    {
        $id_desa = $this->session->userdata('id_desa');

        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->bawaslu_cek_desa($id_desa);
        }
        else
        {
            $this->Bawaslu_model->tambahDataDesa();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('simpul_jaringan/bawaslu_cek_desa/'.$this->session->userdata('id_desa'));
        }
    }

    public function editBawasluDesa($id_bawaslu)
    {
        $data = [
            'title'     => 'Simpul Jaringan - Bawaslu',
            'aktif'     => 'bawaslu',
            'sub'       => 'bawaslu-kab',
            'data'      => $this->Bawaslu_model->getDataBawasluById($id_bawaslu)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/bawaslu/editBawasluDesa',$data);
		$this->load->view('templates/footer');
    }

    public function editBawaslu_proses_desa($id_bawaslu)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->editBawasluDesa($id_bawaslu);
        }
        else
        {
            $this->Bawaslu_model->editBawasluDesa($id_bawaslu);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('simpul_jaringan/bawaslu_cek_desa/'.$this->session->userdata('id_desa'));
        }
    }

    public function hapusBawasluDesa($id_bawaslu)
    {
        $this->Bawaslu_model->hapusBawasluDesa($id_bawaslu);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
        redirect('simpul_jaringan/bawaslu_cek_desa/'.$this->session->userdata('id_desa'));
    }

//=============================POLRI=============================//

    public function polri()
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Simpul Jaringan - POLRI',
            'aktif'     => 'polri',
            'sub'       => 'polri-prov',
            'data'      => $this->Polri_model->getDataPolriProvinsi()->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/polri/index',$data);
		$this->load->view('templates/footer');
    }

    public function polri_kabupaten()
    {
        $data = [
            'title'         => 'Simpul Jaringan - POLRI',
            'aktif'         => 'polri',
            'sub'           => 'polri-kab',
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayah()->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/polri/polri_kabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_polri_provinsi()
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->polri();
        }
        else
        {
            $this->Polri_model->tambahDataProvinsi();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('simpul_jaringan/polri');
        }
    }

    public function editPolriProvinsi($id_polri)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Simpul Jaringan - POLRI',
            'aktif'     => 'polri',
            'sub'       => 'polri-prov',
            'data'      => $this->Polri_model->getDataPolriById($id_polri)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/polri/editPolriProvinsi',$data);
		$this->load->view('templates/footer');
    }

    public function editPolri_proses_provinsi($id_polri)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->editPolriProvinsi($id_polri);
        }
        else
        {
            $this->Polri_model->editPolriProvinsi($id_polri);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('simpul_jaringan/polri');
        }
    }

    public function hapusPolriProvinsi($id_polri)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $this->Polri_model->hapusPolriProvinsi($id_polri);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
        redirect('simpul_jaringan/polri');
    }

    public function polri_cek_kab($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Simpul Jaringan - POLRI',
            'aktif'         => 'polri',
            'sub'           => 'polri-kab',
            'data'          => $this->Polri_model->getDataPolriByIdKab($id_kab)->result(),
            'wilayah'       => $this->Polri_model->getDataWilayahByIdKab($id_kab)->result_array()
        ];

        $id_kab = $this->uri->segment(3);
        $this->session->set_userdata('id_kab', $id_kab);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/polri/polri_cek_kab',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_polri_kabupaten()
    {
        $id_kab = $this->session->userdata('id_kab');

        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->polri_cek_kab($id_kab);
        }
        else
        {
            $this->Polri_model->tambahDataKabupaten();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('simpul_jaringan/polri_cek_kab/'.$this->session->userdata('id_kab'));
        }
    }

    public function editPolriKabupaten($id_polri)
    {
        $data = [
            'title'     => 'Simpul Jaringan - POLRI',
            'aktif'     => 'polri',
            'sub'       => 'polri-kab',
            'data'      => $this->Polri_model->getDataPolriById($id_polri)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/polri/editPolriKabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function editPolri_proses_kabupaten($id_polri)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->editPolriKabupaten($id_polri);
        }
        else
        {
            $this->Polri_model->editPolriKabupaten($id_polri);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('simpul_jaringan/polri_cek_kab/'.$this->session->userdata('id_kab'));
        }
    }

    public function hapusPolriKabupaten($id_polri)
    {
        $this->Polri_model->hapusPolriKabupaten($id_polri);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
        redirect('simpul_jaringan/polri_cek_kab/'.$this->session->userdata('id_kab'));
    }

    function polri_kecamatan($id_kab){
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Simpul Jaringan - POLRI',
            'aktif'         => 'polri',
            'sub'           => 'polri-kab',
            'wilayahKec'    => $this->Polri_model->getDataKecamatanByIdKab($id_kab)->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/polri/polri_kecamatan',$data);
		$this->load->view('templates/footer');
    }

    public function polri_cek_kec($id_kec)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_kec,0,-3);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_kab = $this->session->userdata('id_kab');

        $data = [
            'title'         => 'Simpul Jaringan - POLRI',
            'aktif'         => 'polri',
            'sub'           => 'polri-kab',
            'data'          => $this->Polri_model->getDataPolriByIdKec($id_kec)->result(),
            'wilayahKab'    => $this->Polri_model->getDataWilayahByIdKab($id_kab)->result_array(),
            'wilayahKec'    => $this->Polri_model->getDataWilayahByIdKec($id_kec)->result_array(),
        ];

        $id_kec = $this->uri->segment(3);
        $this->session->set_userdata('id_kec', $id_kec);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/polri/polri_cek_kec',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_polri_kecamatan()
    {
        $id_kec = $this->session->userdata('id_kec');

        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->polri_cek_kec($id_kec);
        }
        else
        {
            $this->Polri_model->tambahDataKecamatan();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('simpul_jaringan/polri_cek_kec/'.$this->session->userdata('id_kec'));
        }
    }

    public function editPolriKecamatan($id_polri)
    {
        $data = [
            'title'     => 'Simpul Jaringan - POLRI',
            'aktif'     => 'polri',
            'sub'       => 'polri-kab',
            'data'      => $this->Polri_model->getDataPolriById($id_polri)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/polri/editPolriKecamatan',$data);
		$this->load->view('templates/footer');
    }

    public function editPolri_proses_kecamatan($id_polri)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->editPolriKecamatan($id_polri);
        }
        else
        {
            $this->Polri_model->editPolriKecamatan($id_polri);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('simpul_jaringan/polri_cek_kec/'.$this->session->userdata('id_kec'));
        }
    }

    public function hapusPolriKecamatan($id_polri)
    {
        $this->Polri_model->hapusPolriKecamatan($id_polri);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
        redirect('simpul_jaringan/polri_cek_kec/'.$this->session->userdata('id_kec'));
    }

    public function polri_desa($id_kec)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_kec,0,-3);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Simpul Jaringan - POLRI',
            'aktif'         => 'polri',
            'sub'           => 'polri-kab',
            'wilayahDesa'   => $this->Polri_model->getDataDesaByIdKab($id_kec)->result(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/polri/polri_desa',$data);
		$this->load->view('templates/footer');
    }

    public function polri_cek_desa($id_desa)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_desa,0,-8);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_kab = $this->session->userdata('id_kab');
        $id_kec = $this->session->userdata('id_kec');

        $data = [
            'title'         => 'Simpul Jaringan - POLRI',
            'aktif'         => 'polri',
            'sub'           => 'polri-kab',
            'data'          => $this->Polri_model->getDataPolriByIdDesa($id_desa)->result(),
            'wilayahKab'    => $this->Polri_model->getDataWilayahByIdKab($id_kab)->result_array(),
            'wilayahKec'    => $this->Polri_model->getDataWilayahByIdKec($id_kec)->result_array(),
            'wilayahDesa'   => $this->Polri_model->getDataWilayahByIdDesa($id_desa)->result_array(),
        ];

        $id_desa = $this->uri->segment(3);
        $this->session->set_userdata('id_desa', $id_desa);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/polri/polri_cek_desa',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_polri_desa()
    {
        $id_desa = $this->session->userdata('id_desa');

        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->polri_cek_desa($id_desa);
        }
        else
        {
            $this->Polri_model->tambahDataDesa();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('simpul_jaringan/polri_cek_desa/'.$this->session->userdata('id_desa'));
        }
    }

    public function editPolriDesa($id_polri)
    {
        $data = [
            'title'     => 'Simpul Jaringan - POLRI',
            'aktif'     => 'polri',
            'sub'       => 'polri-kab',
            'data'      => $this->Polri_model->getDataPolriById($id_polri)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/polri/editPolriDesa',$data);
		$this->load->view('templates/footer');
    }

    public function editPolri_proses_desa($id_polri)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->editPolriDesa($id_polri);
        }
        else
        {
            $this->Polri_model->editPolriDesa($id_polri);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('simpul_jaringan/polri_cek_desa/'.$this->session->userdata('id_desa'));
        }
    }

    public function hapusPolriDesa($id_polri)
    {
        $this->Polri_model->hapusPolriDesa($id_polri);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
        redirect('simpul_jaringan/polri_cek_desa/'.$this->session->userdata('id_desa'));
    }

//=============================TNI=============================//

    public function tni()
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Simpul Jaringan - TNI',
            'aktif'     => 'tni',
            'sub'       => 'tni-prov',
            'data'      => $this->Tni_model->getDataTniProvinsi()->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/tni/index',$data);
		$this->load->view('templates/footer');
    }

    public function tni_kabupaten()
    {
        $data = [
            'title'         => 'Simpul Jaringan - TNI',
            'aktif'         => 'tni',
            'sub'           => 'tni-kab',
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayah()->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/tni/tni_kabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_tni_provinsi()
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->tni();
        }
        else
        {
            $this->Tni_model->tambahDataProvinsi();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('simpul_jaringan/tni');
        }
    }

    public function editTniProvinsi($id_tni)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Simpul Jaringan - TNI',
            'aktif'     => 'tni',
            'sub'       => 'tni-prov',
            'data'      => $this->Tni_model->getDataTniById($id_tni)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/tni/editTniProvinsi',$data);
		$this->load->view('templates/footer');
    }

    public function editTni_proses_provinsi($id_tni)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->editTniProvinsi($id_tni);
        }
        else
        {
            $this->Tni_model->editTniProvinsi($id_tni);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('simpul_jaringan/tni');
        }
    }

    public function hapusTniProvinsi($id_tni)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $this->Tni_model->hapusTniProvinsi($id_tni);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
        redirect('simpul_jaringan/tni');
    }

    public function tni_cek_kab($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Simpul Jaringan - TNI',
            'aktif'         => 'tni',
            'sub'           => 'tni-kab',
            'data'          => $this->Tni_model->getDataTniByIdKab($id_kab)->result(),
            'wilayah'       => $this->Tni_model->getDataWilayahByIdKab($id_kab)->result_array()
        ];

        $id_kab = $this->uri->segment(3);
        $this->session->set_userdata('id_kab', $id_kab);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/tni/tni_cek_kab',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_tni_kabupaten()
    {
        $id_kab = $this->session->userdata('id_kab');

        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->tni_cek_kab($id_kab);
        }
        else
        {
            $this->Tni_model->tambahDataKabupaten();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('simpul_jaringan/tni_cek_kab/'.$this->session->userdata('id_kab'));
        }
    }

    public function editTniKabupaten($id_tni)
    {
        $data = [
            'title'     => 'Simpul Jaringan - TNI',
            'aktif'     => 'tni',
            'sub'       => 'tni-kab',
            'data'      => $this->Tni_model->getDataTniById($id_tni)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/tni/editTniKabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function editTni_proses_kabupaten($id_tni)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->editTniKabupaten($id_tni);
        }
        else
        {
            $this->Tni_model->editTniKabupaten($id_tni);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('simpul_jaringan/tni_cek_kab/'.$this->session->userdata('id_kab'));
        }
    }

    public function hapusTniKabupaten($id_tni)
    {
        $this->Tni_model->hapusTniKabupaten($id_tni);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
        redirect('simpul_jaringan/tni_cek_kab/'.$this->session->userdata('id_kab'));
    }

    function tni_kecamatan($id_kab){
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Simpul Jaringan - TNI',
            'aktif'         => 'tni',
            'sub'           => 'tni-kab',
            'wilayahKec'    => $this->Tni_model->getDataKecamatanByIdKab($id_kab)->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/tni/tni_kecamatan',$data);
		$this->load->view('templates/footer');
    }

    public function tni_cek_kec($id_kec)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_kec,0,-3);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_kab = $this->session->userdata('id_kab');

        $data = [
            'title'         => 'Simpul Jaringan - TNI',
            'aktif'         => 'tni',
            'sub'           => 'tni-kab',
            'data'          => $this->Tni_model->getDataTniByIdKec($id_kec)->result(),
            'wilayahKab'    => $this->Tni_model->getDataWilayahByIdKab($id_kab)->result_array(),
            'wilayahKec'    => $this->Tni_model->getDataWilayahByIdKec($id_kec)->result_array(),
        ];

        $id_kec = $this->uri->segment(3);
        $this->session->set_userdata('id_kec', $id_kec);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/tni/tni_cek_kec',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_tni_kecamatan()
    {
        $id_kec = $this->session->userdata('id_kec');

        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->tni_cek_kec($id_kec);
        }
        else
        {
            $this->Tni_model->tambahDataKecamatan();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('simpul_jaringan/tni_cek_kec/'.$this->session->userdata('id_kec'));
        }
    }
    
    public function editTniKecamatan($id_tni)
    {
        $data = [
            'title'     => 'Simpul Jaringan - TNI',
            'aktif'     => 'tni',
            'sub'       => 'tni-kab',
            'data'      => $this->Tni_model->getDataTniById($id_tni)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/tni/editTniKecamatan',$data);
		$this->load->view('templates/footer');
    }

    public function editTni_proses_kecamatan($id_tni)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->editTniKecamatan($id_tni);
        }
        else
        {
            $this->Tni_model->editTniKecamatan($id_tni);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('simpul_jaringan/tni_cek_kec/'.$this->session->userdata('id_kec'));
        }
    }

    public function hapusTniKecamatan($id_tni)
    {
        $this->Tni_model->hapusTniKecamatan($id_tni);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
        redirect('simpul_jaringan/tni_cek_kec/'.$this->session->userdata('id_kec'));
    }

    public function tni_desa($id_kec)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_kec,0,-3);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Simpul Jaringan - TNI',
            'aktif'         => 'tni',
            'sub'           => 'tni-kab',
            'wilayahDesa'   => $this->Tni_model->getDataDesaByIdKab($id_kec)->result(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/tni/tni_desa',$data);
		$this->load->view('templates/footer');
    }

    public function tni_cek_desa($id_desa)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_desa,0,-8);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_kab = $this->session->userdata('id_kab');
        $id_kec = $this->session->userdata('id_kec');

        $data = [
            'title'         => 'Simpul Jaringan - TNI',
            'aktif'         => 'tni',
            'sub'           => 'tni-kab',
            'data'          => $this->Tni_model->getDataTniByIdDesa($id_desa)->result(),
            'wilayahKab'    => $this->Tni_model->getDataWilayahByIdKab($id_kab)->result_array(),
            'wilayahKec'    => $this->Tni_model->getDataWilayahByIdKec($id_kec)->result_array(),
            'wilayahDesa'   => $this->Tni_model->getDataWilayahByIdDesa($id_desa)->result_array(),
        ];

        $id_desa = $this->uri->segment(3);
        $this->session->set_userdata('id_desa', $id_desa);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/tni/tni_cek_desa',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_tni_desa()
    {
        $id_desa = $this->session->userdata('id_desa');

        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->tni_cek_desa($id_desa);
        }
        else
        {
            $this->Tni_model->tambahDataDesa();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('simpul_jaringan/tni_cek_desa/'.$this->session->userdata('id_desa'));
        }
    }

    public function editTniDesa($id_tni)
    {
        $data = [
            'title'     => 'Simpul Jaringan - TNI',
            'aktif'     => 'tni',
            'sub'       => 'tni-kab',
            'data'      => $this->Tni_model->getDataTniById($id_tni)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/tni/editTniDesa',$data);
		$this->load->view('templates/footer');
    }

    public function editTni_proses_desa($id_tni)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->editTniDesa($id_tni);
        }
        else
        {
            $this->Tni_model->editTniDesa($id_tni);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('simpul_jaringan/tni_cek_desa/'.$this->session->userdata('id_desa'));
        }
    }

    public function hapusTniDesa($id_tni)
    {
        $this->Tni_model->hapusTniDesa($id_tni);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
        redirect('simpul_jaringan/tni_cek_desa/'.$this->session->userdata('id_desa'));
    }
//=============================RELAWAN=============================//

    public function relawan()
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Simpul Jaringan - Relawan',
            'aktif'     => 'relawan',
            'sub'       => 'relawan-prov',
            'data'      => $this->Relawan_model->getDataRelawanProvinsi()->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/relawan/index',$data);
		$this->load->view('templates/footer');
    }

    public function relawan_kabupaten()
    {
        $data = [
            'title'         => 'Simpul Jaringan - Relawan',
            'aktif'         => 'relawan',
            'sub'           => 'relawan-kab',
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayah()->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/relawan/relawan_kabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_relawan_provinsi()
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->relawan();
        }
        else
        {
            $this->Relawan_model->tambahDataProvinsi();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('simpul_jaringan/relawan');
        }
    }

    public function editRelawanProvinsi($id_relawan)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Simpul Jaringan - Relawan',
            'aktif'     => 'relawan',
            'sub'       => 'relawan-prov',
            'data'      => $this->Relawan_model->getDataRelawanById($id_relawan)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/relawan/editRelawanProvinsi',$data);
		$this->load->view('templates/footer');
    }

    public function editRelawan_proses_provinsi($id_relawan)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->editRelawanProvinsi($id_relawan);
        }
        else
        {
            $this->Relawan_model->editRelawanProvinsi($id_relawan);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('simpul_jaringan/relawan');
        }
    }

    public function hapusRelawanProvinsi($id_relawan)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }
        
        $this->Relawan_model->hapusRelawanProvinsi($id_relawan);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
        redirect('simpul_jaringan/relawan');
    }

    public function relawan_cek_kab($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }
        
        $data = [
            'title'         => 'Simpul Jaringan - Relawan',
            'aktif'         => 'relawan',
            'sub'           => 'relawan-kab',
            'data'          => $this->Relawan_model->getDataRelawanByIdKab($id_kab)->result(),
            'wilayah'       => $this->Relawan_model->getDataWilayahByIdKab($id_kab)->result_array()
        ];

        $id_kab = $this->uri->segment(3);
        $this->session->set_userdata('id_kab', $id_kab);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/relawan/relawan_cek_kab',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_relawan_kabupaten()
    {
        $id_kab = $this->session->userdata('id_kab');

        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->relawan_cek_kab($id_kab);
        }
        else
        {
            $this->Relawan_model->tambahDataKabupaten();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('simpul_jaringan/relawan_cek_kab/'.$this->session->userdata('id_kab'));
        }
    }

    public function editRelawanKabupaten($id_relawan)
    {
        $data = [
            'title'     => 'Simpul Jaringan - Relawan',
            'aktif'     => 'relawan',
            'sub'       => 'relawan-kab',
            'data'      => $this->Relawan_model->getDataRelawanById($id_relawan)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/relawan/editRelawanKabupaten',$data);
		$this->load->view('templates/footer');
    }

    public function editRelawan_proses_kabupaten($id_relawan)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->editRelawanKabupaten($id_relawan);
        }
        else
        {
            $this->Relawan_model->editRelawanKabupaten($id_relawan);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('simpul_jaringan/relawan_cek_kab/'.$this->session->userdata('id_kab'));
        }
    }

    public function hapusRelawanKabupaten($id_relawan)
    {
        $this->Relawan_model->hapusRelawanKabupaten($id_relawan);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
        redirect('simpul_jaringan/relawan_cek_kab/'.$this->session->userdata('id_kab'));
    }

    function relawan_kecamatan($id_kab){
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Simpul Jaringan - Relawan',
            'aktif'         => 'relawan',
            'sub'           => 'relawan-kab',
            'wilayahKec'    => $this->Relawan_model->getDataKecamatanByIdKab($id_kab)->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/relawan/relawan_kecamatan',$data);
		$this->load->view('templates/footer');
    }

    public function relawan_cek_kec($id_kec)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_kec,0,-3);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_kab = $this->session->userdata('id_kab');

        $data = [
            'title'         => 'Simpul Jaringan - Relawan',
            'aktif'         => 'relawan',
            'sub'           => 'relawan-kab',
            'data'          => $this->Relawan_model->getDataRelawanByIdKec($id_kec)->result(),
            'wilayahKab'    => $this->Relawan_model->getDataWilayahByIdKab($id_kab)->result_array(),
            'wilayahKec'    => $this->Relawan_model->getDataWilayahByIdKec($id_kec)->result_array(),
        ];

        $id_kec = $this->uri->segment(3);
        $this->session->set_userdata('id_kec', $id_kec);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/relawan/relawan_cek_kec',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_relawan_kecamatan()
    {
        $id_kec = $this->session->userdata('id_kec');

        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->relawan_cek_kec($id_kec);
        }
        else
        {
            $this->Relawan_model->tambahDataKecamatan();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('simpul_jaringan/relawan_cek_kec/'.$this->session->userdata('id_kec'));
        }
    }

    public function editRelawanKecamatan($id_relawan)
    {
        $data = [
            'title'     => 'Simpul Jaringan - Relawan',
            'aktif'     => 'relawan',
            'sub'       => 'relawan-kab',
            'data'      => $this->Relawan_model->getDataRelawanById($id_relawan)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/relawan/editRelawanKecamatan',$data);
		$this->load->view('templates/footer');
    }

    public function editRelawan_proses_kecamatan($id_relawan)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->editRelawanKecamatan($id_relawan);
        }
        else
        {
            $this->Relawan_model->editRelawanKecamatan($id_relawan);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('simpul_jaringan/relawan_cek_kec/'.$this->session->userdata('id_kec'));
        }
    }

    public function hapusRelawanKecamatan($id_relawan)
    {
        $this->Relawan_model->hapusRelawanKecamatan($id_relawan);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
        redirect('simpul_jaringan/relawan_cek_kec/'.$this->session->userdata('id_kec'));
    }

    public function relawan_desa($id_kec)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_kec,0,-3);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Simpul Jaringan - Relawan',
            'aktif'         => 'relawan',
            'sub'           => 'relawan-kab',
            'wilayahDesa'   => $this->Relawan_model->getDataDesaByIdKab($id_kec)->result(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/relawan/relawan_desa',$data);
		$this->load->view('templates/footer');
    }

    public function relawan_cek_desa($id_desa)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_desa,0,-8);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }
        $id_kab = $this->session->userdata('id_kab');
        $id_kec = $this->session->userdata('id_kec');

        $data = [
            'title'         => 'Simpul Jaringan - Relawan',
            'aktif'         => 'relawan',
            'sub'           => 'relawan-kab',
            'data'          => $this->Relawan_model->getDataRelawanByIdDesa($id_desa)->result(),
            'wilayahKab'    => $this->Relawan_model->getDataWilayahByIdKab($id_kab)->result_array(),
            'wilayahKec'    => $this->Relawan_model->getDataWilayahByIdKec($id_kec)->result_array(),
            'wilayahDesa'   => $this->Relawan_model->getDataWilayahByIdDesa($id_desa)->result_array(),
        ];

        $id_desa = $this->uri->segment(3);
        $this->session->set_userdata('id_desa', $id_desa);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/relawan/relawan_cek_desa',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_relawan_desa()
    {
        $id_desa = $this->session->userdata('id_desa');

        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->relawan_cek_desa($id_desa);
        }
        else
        {
            $this->Relawan_model->tambahDataDesa();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('simpul_jaringan/relawan_cek_desa/'.$this->session->userdata('id_desa'));
        }
    }

    public function editRelawanDesa($id_relawan)
    {
        $data = [
            'title'     => 'Simpul Jaringan - Relawan',
            'aktif'     => 'relawan',
            'sub'       => 'relawan-kab',
            'data'      => $this->Relawan_model->getDataRelawanById($id_relawan)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('simpul_jaringan/relawan/editRelawanDesa',$data);
		$this->load->view('templates/footer');
    }

    public function editRelawan_proses_desa($id_relawan)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->editRelawanDesa($id_relawan);
        }
        else
        {
            $this->Relawan_model->editRelawanDesa($id_relawan);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('simpul_jaringan/relawan_cek_desa/'.$this->session->userdata('id_desa'));
        }
    }

    public function hapusRelawanDesa($id_relawan)
    {
        $this->Relawan_model->hapusRelawanDesa($id_relawan);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Dihapus.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
        redirect('simpul_jaringan/relawan_cek_desa/'.$this->session->userdata('id_desa'));
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Nama wajib diisi'
        ]);
        
        $this->form_validation->set_rules('no_telp', 'No Telepon', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> No Telepon wajib diisi'
        ]);

        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Alamat wajib diisi'
        ]);
    }
}