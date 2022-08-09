<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pac extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        
        $user = $this->session->userdata('userdata');
        if($user['level'] != 'Admin' && $user['level'] != 'Super Admin')
        {
            redirect('admin/auth');
        }
    }

    public function indexAdmKabPAC()
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $data = [
            'title'         => 'PAC',
            'aktif'         => 'pac',
            'data'          => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('pac/index',$data);
		$this->load->view('templates/footer');
    }
   
    //==========================ADMIN SEMUA========================//
    public function index()
    {
        $data = [
            'title'     => 'PAC',
            'aktif'     => 'pac',
            'data'      => $this->Wilayah_kab_model->getDataWilayah()->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('pac/index',$data);
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
            'title'     => 'PAC',
            'aktif'     => 'pac',
            'data'      => $this->Pac_model->getDataWilayahById($id_kab)->result()
        ];

        $id_kabupaten = $this->uri->segment(3);
        $this->session->set_userdata('id_kabupaten', $id_kabupaten);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('pac/data',$data);
		$this->load->view('templates/footer');
    }

    public function detailKepengurusan($id_kec)
    {
        $data = [
            'title'     => 'PAC',
            'aktif'     => 'pac',
            'data'      => $this->Pac_model->getDataKecamatanById($id_kec)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('pac/detailKepengurusan',$data);
		$this->load->view('templates/footer');
    }

    public function detailPac($id_pac)
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $data = [
            'title'             => 'PAC',
            'aktif'             => 'pac',
            'data'              => $this->Pac_model->getDataByIdPac($id_pac)->result_array(),
            'keanggotaan'       => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktif()->result_array(),
            'keanggotaanKab'    => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktifIdKab($id_kab)->result_array(),
            'jabatan'           => $this->Keanggotaan_model->getDataJabatan()->result_array(),
            'kepengurusan'      => $this->Pac_model->getDataKepengurusanPACbyId($id_pac)->result_array()
        ];

        $id = $this->uri->segment(3);
        $this->session->set_userdata('id', $id);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('pac/detailPac',$data);
		$this->load->view('templates/footer');
    }

    public function detailPacKec($id_kec)
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $subs = substr($id_kec,0,-3);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_kabupaten = $this->session->userdata('id_kabupaten');

        $data = [
            'title'             => 'PAC',
            'aktif'             => 'pac',
            'kabupaten'         => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kabupaten)->result_array(),
            'data'              => $this->Pac_model->getDataPacByIdKec($id_kec)->result_array(),
            'keanggotaan'       => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktif()->result_array(),
            'keanggotaanKab'    => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktifIdKab($id_kab)->result_array(),
            'jabatan'           => $this->Keanggotaan_model->getDataJabatan()->result_array(),
            'kepengurusan'      => $this->Pac_model->getDataKepengurusanPACbyIdKec($id_kec)->result_array(),
            'kecamatan'         => $this->Pac_model->getDataWilayahKecByIdKec($id_kec)->result_array()
        ];

        $id_kecamatan = $this->uri->segment(3);
        $this->session->set_userdata('id_kecamatan', $id_kecamatan);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('pac/detailPac',$data);
		$this->load->view('templates/footer');
    }

    public function tambah()
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $id_kabupaten = $this->session->userdata('id_kabupaten');
        $id_kecamatan = $this->session->userdata('id_kecamatan');


        $data = [
            'title'         => 'PAC',
            'aktif'         => 'pac',
            // 'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayah()->result(),
            // 'wilayahById'   => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result()
            'wilayahKab'   => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kabupaten)->result(),
            'wilayahKec'   => $this->Pac_model->getDataWilayahKecByIdKec($id_kecamatan)->result(),

        ];
        
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('pac/tambah',$data);
        $this->load->view('templates/footer');
    }

    public function tambah_proses()
    {
        $user = $this->session->userdata('userdata');
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->tambah();
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
           if(!$this->upload->do_upload('scan_sk') || !$this->upload->do_upload('foto_kantor') || !$this->upload->do_upload('foto_kantor_1') || !$this->upload->do_upload('foto_kantor_2'))
           {

               $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                              <strong>Error!</strong> Data Gagal Ditambah.
                                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>');
               redirect('pac/tambah');
           }
           else
           {
               
            $this->upload->do_upload('foto_kantor');
            $foto_kantor = $this->upload->data();
            $foto = $foto_kantor['file_name'];
            
            $this->upload->do_upload('foto_kantor_1');
            $foto_kantor_1 = $this->upload->data();
            $foto_1 = $foto_kantor_1['file_name'];

            $this->upload->do_upload('foto_kantor_2');
            $foto_kantor_2 = $this->upload->data();
            $foto_2 = $foto_kantor_2['file_name'];

            $this->upload->do_upload('scan_sk');
            $scan_sk = $this->upload->data();
            $scan = $scan_sk['file_name'];

            $this->Pac_model->tambahData($foto, $foto_1, $foto_2, $scan);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                           <strong>Sukses!</strong> Data Berhasil Ditambah.
                                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                           <span aria-hidden="true">&times;</span>
                                           </button>
                                       </div>');
            if($user['id_kab']){
                redirect('pac/indexAdmKabPAC');
            }
            else
            {
                redirect('pac');
            }
           }
        }
    }

    public function edit($id_pac)
    {
        $data = [
            'title'     => 'PAC',
            'aktif'     => 'pac',
            'data'      => $this->Pac_model->getDataByIdPac($id_pac)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('pac/edit',$data);
		$this->load->view('templates/footer');
    }

    public function edit_proses($id_pac)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->edit($id_pac);
        }
        else
        {
            //setting config untuk library upload
            $config['upload_path']      = './uploads';
            $config['allowed_types']    = 'gif|jpg|png|pdf';
            $config['encrypt_name']     = true;
            $config['max_size']         = 10000000000;
            $config['max_width']        = 10240000;
            $config['max_height']       = 7680000;

            $this->load->library('upload', $config);

            if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"] == "")
            {
                $foto_lama = $this->input->post('foto_kantor_lama');
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $scan_lama = $this->input->post('scan_sk_lama');

                $this->Pac_model->edit($id_pac, $foto_lama, $foto_lama_1, $foto_lama_2, $scan_lama);

                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('pac/detailPacKec/'.$this->session->userdata('id_kecamatan'));
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"] == "")
            {
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $scan_lama = $this->input->post('scan_sk_lama');

                $foto_lama = $this->input->post('foto_kantor_lama');
                $qk = $this->db->query("SELECT * FROM tb_pac WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qk;
                unlink($f);

                $this->upload->do_upload('foto_kantor');
                $foto_kantor = $this->upload->data();
                $foto = $foto_kantor['file_name'];

                $this->Pac_model->edit($id_pac, $foto, $foto_lama_1, $foto_lama_2, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('pac/detailPacKec/'.$this->session->userdata('id_kecamatan'));
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["foto_kantor_1"]["name"] && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"] == "")
            {
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $scan_lama = $this->input->post('scan_sk_lama');

                $foto_lama = $this->input->post('foto_kantor_lama');
                $qk = $this->db->query("SELECT * FROM tb_pac WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qk;
                unlink($f);

                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $qk1 = $this->db->query("SELECT * FROM tb_pac WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                $f1 = './uploads/'.$qk1;
                unlink($f1);

                $this->upload->do_upload('foto_kantor');
                $foto_kantor = $this->upload->data();
                $foto = $foto_kantor['file_name'];

                $this->upload->do_upload('foto_kantor_1');
                $foto_kantor_1 = $this->upload->data();
                $foto_1 = $foto_kantor_1['file_name'];

                $this->Pac_model->edit($id_pac, $foto, $foto_1, $foto_lama_2, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('pac/detailPacKec/'.$this->session->userdata('id_kecamatan'));
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] && $_FILES["scan_sk"]["name"] == "")
            {
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $scan_lama = $this->input->post('scan_sk_lama');

                $foto_lama = $this->input->post('foto_kantor_lama');
                $qk = $this->db->query("SELECT * FROM tb_pac WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qk;
                unlink($f);

                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $qk2 = $this->db->query("SELECT * FROM tb_pac WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
                $f2 = './uploads/'.$qk2;
                unlink($f2);

                $this->upload->do_upload('foto_kantor');
                $foto_kantor = $this->upload->data();
                $foto = $foto_kantor['file_name'];

                $this->upload->do_upload('foto_kantor_2');
                $foto_kantor_2 = $this->upload->data();
                $foto_2 = $foto_kantor_2['file_name'];

                $this->Pac_model->edit($id_pac, $foto, $foto_lama_1, $foto_2, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('pac/detailPacKec/'.$this->session->userdata('id_kecamatan'));
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"])
            {
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');

                $foto_lama = $this->input->post('foto_kantor_lama');
                $qk = $this->db->query("SELECT * FROM tb_pac WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qk;
                unlink($f);

                $scan_sk_lama = $this->input->post('scan_sk_lama');
                $qks = $this->db->query("SELECT * FROM tb_pac WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
                $fs = './uploads/'.$qks;
                unlink($fs);

                $this->upload->do_upload('foto_kantor');
                $foto_kantor = $this->upload->data();
                $foto = $foto_kantor['file_name'];

                $this->upload->do_upload('scan_sk');
                $scan_sk = $this->upload->data();
                $scan = $scan_sk['file_name'];

                $this->Pac_model->edit($id_pac, $foto, $foto_lama_1, $foto_lama_2, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('pac/detailPacKec/'.$this->session->userdata('id_kecamatan'));
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["foto_kantor_1"]["name"] && $_FILES["foto_kantor_2"]["name"] && $_FILES["scan_sk"]["name"] == "")
            {
                $scan_lama = $this->input->post('scan_sk_lama');

                $foto_lama = $this->input->post('foto_kantor_lama');
                $qk = $this->db->query("SELECT * FROM tb_pac WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qk;
                unlink($f);

                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $qk1 = $this->db->query("SELECT * FROM tb_pac WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                $f1 = './uploads/'.$qk1;
                unlink($f1);

                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $qk2 = $this->db->query("SELECT * FROM tb_pac WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
                $f2 = './uploads/'.$qk2;
                unlink($f2);

                $this->upload->do_upload('foto_kantor');
                $foto_kantor = $this->upload->data();
                $foto = $foto_kantor['file_name'];

                $this->upload->do_upload('foto_kantor_1');
                $foto_kantor_1 = $this->upload->data();
                $foto_1 = $foto_kantor_1['file_name'];

                $this->upload->do_upload('foto_kantor_2');
                $foto_kantor_2 = $this->upload->data();
                $foto_2 = $foto_kantor_2['file_name'];

                $this->Pac_model->edit($id_pac, $foto, $foto_1, $foto_2, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('pac/detailPacKec/'.$this->session->userdata('id_kecamatan'));
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["foto_kantor_1"]["name"] && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"])
            {
                $foto_kantor_lama_2 = $this->input->post('foto_kantor_lama_2');

                $foto_lama = $this->input->post('foto_kantor_lama');
                $qk = $this->db->query("SELECT * FROM tb_pac WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qk;
                unlink($f);

                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $qk1 = $this->db->query("SELECT * FROM tb_pac WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                $f1 = './uploads/'.$qk1;
                unlink($f1);

                $scan_sk_lama = $this->input->post('scan_sk_lama');
                $qks = $this->db->query("SELECT * FROM tb_pac WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
                $fs = './uploads/'.$qks;
                unlink($fs);

                $this->upload->do_upload('foto_kantor');
                $foto_kantor = $this->upload->data();
                $foto = $foto_kantor['file_name'];

                $this->upload->do_upload('foto_kantor_1');
                $foto_kantor_1 = $this->upload->data();
                $foto_1 = $foto_kantor_1['file_name'];

                $this->upload->do_upload('scan_sk');
                $scan_sk = $this->upload->data();
                $scan = $scan_sk['file_name'];

                $this->Pac_model->edit($id_pac, $foto, $foto_1, $foto_kantor_lama_2, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('pac/detailPacKec/'.$this->session->userdata('id_kecamatan'));
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] && $_FILES["scan_sk"]["name"])
            {
                $foto_kantor_lama_1 = $this->input->post('foto_kantor_lama_1');

                $foto_lama = $this->input->post('foto_kantor_lama');
                $qk = $this->db->query("SELECT * FROM tb_pac WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qk;
                unlink($f);

                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $qk2 = $this->db->query("SELECT * FROM tb_pac WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
                $f2 = './uploads/'.$qk2;
                unlink($f2);

                $scan_sk_lama = $this->input->post('scan_sk_lama');
                $qks = $this->db->query("SELECT * FROM tb_pac WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
                $fs = './uploads/'.$qks;
                unlink($fs);

                $this->upload->do_upload('foto_kantor');
                $foto_kantor = $this->upload->data();
                $foto = $foto_kantor['file_name'];

                $this->upload->do_upload('foto_kantor_2');
                $foto_kantor_2 = $this->upload->data();
                $foto_2 = $foto_kantor_2['file_name'];

                $this->upload->do_upload('scan_sk');
                $scan_sk = $this->upload->data();
                $scan = $scan_sk['file_name'];

                $this->Pac_model->edit($id_pac, $foto, $foto_kantor_lama_1, $foto_2, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('pac/detailPacKec/'.$this->session->userdata('id_kecamatan'));
            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"] == "")
            {
                $foto_lama = $this->input->post('foto_kantor_lama');
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $scan_lama = $this->input->post('scan_sk_lama');

                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $qk1 = $this->db->query("SELECT * FROM tb_pac WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                $f1 = './uploads/'.$qk1;
                unlink($f1);

                $this->upload->do_upload('foto_kantor_1');
                $foto_kantor_1 = $this->upload->data();
                $foto_1 = $foto_kantor_1['file_name'];

                $this->Pac_model->edit($id_pac, $foto_lama, $foto_1, $foto_lama_2, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('pac/detailPacKec/'.$this->session->userdata('id_kecamatan'));
            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] && $_FILES["foto_kantor_2"]["name"] && $_FILES["scan_sk"]["name"] == "")
            {
                $foto_lama = $this->input->post('foto_kantor_lama');
                $scan_lama = $this->input->post('scan_sk_lama');
                
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $qk1 = $this->db->query("SELECT * FROM tb_pac WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                $f1 = './uploads/'.$qk1;
                unlink($f1);

                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $qk2 = $this->db->query("SELECT * FROM tb_pac WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
                $f2 = './uploads/'.$qk2;
                unlink($f2);

                $this->upload->do_upload('foto_kantor_1');
                $foto_kantor_1 = $this->upload->data();
                $foto_1 = $foto_kantor_1['file_name'];
           
                $this->upload->do_upload('foto_kantor_2');
                $foto_kantor_2 = $this->upload->data();
                $foto_2 = $foto_kantor_2['file_name'];

                $this->Pac_model->edit($id_pac, $foto_lama, $foto_1, $foto_2, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('pac/detailPacKec/'.$this->session->userdata('id_kecamatan'));
            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"])
            {
                $foto_lama = $this->input->post('foto_kantor_lama');
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
               
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $qk1 = $this->db->query("SELECT * FROM tb_pac WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                $f1 = './uploads/'.$qk1;
                unlink($f1);

                $scan_sk_lama = $this->input->post('scan_sk_lama');
                $qks = $this->db->query("SELECT * FROM tb_pac WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
                $fs = './uploads/'.$qks;
                unlink($fs);

                $this->upload->do_upload('foto_kantor_1');
                $foto_kantor_1 = $this->upload->data();
                $foto_1 = $foto_kantor_1['file_name'];

                $this->upload->do_upload('scan_sk');
                $scan_sk = $this->upload->data();
                $scan = $scan_sk['file_name'];

                $this->Pac_model->edit($id_pac, $foto_lama, $foto_1, $foto_lama_2, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('pac/detailPacKec/'.$this->session->userdata('id_kecamatan'));
            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] && $_FILES["foto_kantor_2"]["name"] && $_FILES["scan_sk"]["name"])
            {
                $foto_lama = $this->input->post('foto_kantor_lama');

                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $qk1 = $this->db->query("SELECT * FROM tb_pac WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                $f1 = './uploads/'.$qk1;
                unlink($f1);

                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $qk2 = $this->db->query("SELECT * FROM tb_pac WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
                $f2 = './uploads/'.$qk2;
                unlink($f2);

                $scan_sk_lama = $this->input->post('scan_sk_lama');
                $qks = $this->db->query("SELECT * FROM tb_pac WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
                $fs = './uploads/'.$qks;
                unlink($fs);

                $this->upload->do_upload('foto_kantor_1');
                $foto_kantor_1 = $this->upload->data();
                $foto_1 = $foto_kantor_1['file_name'];

                $this->upload->do_upload('foto_kantor_2');
                $foto_kantor_2 = $this->upload->data();
                $foto_2 = $foto_kantor_2['file_name'];

                $this->upload->do_upload('scan_sk');
                $scan_sk = $this->upload->data();
                $scan = $scan_sk['file_name'];

                $this->Pac_model->edit($id_pac, $foto_lama, $foto_1, $foto_2, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('pac/detailPacKec/'.$this->session->userdata('id_kecamatan'));
            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] && $_FILES["scan_sk"]["name"] == "")
            {
                $foto_lama = $this->input->post('foto_kantor_lama');
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $scan_lama = $this->input->post('scan_sk_lama');

                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $qk2 = $this->db->query("SELECT * FROM tb_pac WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
                $f2 = './uploads/'.$qk2;
                unlink($f2);

                $this->upload->do_upload('foto_kantor_2');
                $foto_kantor_2 = $this->upload->data();
                $foto_2 = $foto_kantor_2['file_name'];

                $this->Pac_model->edit($id_pac, $foto_lama, $foto_lama_1, $foto_2, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('pac/detailPacKec/'.$this->session->userdata('id_kecamatan'));
            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] && $_FILES["scan_sk"]["name"])
            {
                $foto_lama = $this->input->post('foto_kantor_lama');
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $qk2 = $this->db->query("SELECT * FROM tb_pac WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
                $f2 = './uploads/'.$qk2;
                unlink($f2);

                $scan_sk_lama = $this->input->post('scan_sk_lama');
                $qks = $this->db->query("SELECT * FROM tb_pac WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
                $fs = './uploads/'.$qks;
                unlink($fs);

                $this->upload->do_upload('foto_kantor_2');
                $foto_kantor_2 = $this->upload->data();
                $foto_2 = $foto_kantor_2['file_name'];

                $this->upload->do_upload('scan_sk');
                $scan_sk = $this->upload->data();
                $scan = $scan_sk['file_name'];

                $this->Pac_model->edit($id_pac, $foto_lama, $foto_lama_1, $foto_2, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('pac/detailPacKec/'.$this->session->userdata('id_kecamatan'));
            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"])
            {
                $foto_lama = $this->input->post('foto_kantor_lama');
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');

                $scan_sk_lama = $this->input->post('scan_sk_lama');
                $qks = $this->db->query("SELECT * FROM tb_pac WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
                $fs = './uploads/'.$qks;
                unlink($fs);

                $this->upload->do_upload('scan_sk');
                $scan_sk = $this->upload->data();
                $scan = $scan_sk['file_name'];

                $this->Pac_model->edit($id_pac, $foto_lama, $foto_lama_1, $foto_lama_2, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('pac/detailPacKec/'.$this->session->userdata('id_kecamatan'));
            }
            else
            {
                if(!$this->upload->do_upload('foto_kantor') && !$this->upload->do_upload('foto_kantor_1') && !$this->upload->do_upload('foto_kantor_2') && !$this->upload->do_upload('scan_sk'))
                {
                    $data = [
                        'title'         => 'PAC',
                        'aktif'         => 'pac',
                        'data'          => $this->Pac_model->getDataByIdPac($id_pac)->result_array()
                    ];
            
                    $this->load->view('templates/header');
                    $this->load->view('templates/sidebar',$data);
                    $this->load->view('pac',$data);
                    $this->load->view('templates/footer');
                }
                else
                {
                    $foto_lama = $this->input->post('foto_kantor_lama');
                    $qk = $this->db->query("SELECT * FROM tb_pac WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                    $f = './uploads/'.$qk;
                    unlink($f);

                    $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                    $qk1 = $this->db->query("SELECT * FROM tb_pac WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                    $f1 = './uploads/'.$qk1;
                    unlink($f1);

                    $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                    $qk2 = $this->db->query("SELECT * FROM tb_pac WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
                    $f2 = './uploads/'.$qk2;
                    unlink($f2);

                    $scan_sk_lama = $this->input->post('scan_sk_lama');
                    $qks = $this->db->query("SELECT * FROM tb_pac WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
                    $fs = './uploads/'.$qks;
                    unlink($fs);

                    $this->upload->do_upload('foto_kantor');
                    $foto_kantor = $this->upload->data();
                    $foto = $foto_kantor['file_name'];
                   
                    $this->upload->do_upload('foto_kantor_1');
                    $foto_kantor_1 = $this->upload->data();
                    $foto_1 = $foto_kantor_1['file_name'];

                    $this->upload->do_upload('foto_kantor_2');
                    $foto_kantor_2 = $this->upload->data();
                    $foto_2 = $foto_kantor_2['file_name'];
                    
                    $this->upload->do_upload('scan_sk');
                    $scan_sk = $this->upload->data();
                    $scan = $scan_sk['file_name'];

                    $this->Pac_model->edit($id_pac, $foto, $foto_1, $foto_2, $scan);
                    $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');
                    redirect('pac/detailPacKec/'.$this->session->userdata('id_kecamatan'));
                }
            }
        }
    }

    public function hapus($id_pac)
    {
        $user = $this->session->userdata('userdata');

        $qs = $this->db->query("SELECT * FROM tb_pac WHERE id_pac = '$id_pac'")->row()->scan_sk;
        $fileScan = './uploads/'.$qs;
        unlink($fileScan);

        $this->db->where('id_pac', $id_pac);
        $this->db->delete('tb_pac');

        $this->db->where('id_pac', $id_pac);
        $this->db->delete('tb_pengurus_pac');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        if($user['id_kab']){
            redirect('pac/indexAdmKabPAC');
        }
        else
        {
            redirect('pac');
        }
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
            redirect('pac/detailPacKec/'.$this->session->userdata('id_kecamatan'));
        }
        else
        {
            $this->Pac_model->tambahDataKepengurusan();
            // $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            //                                     <strong>Sukses!</strong> Data Berhasil Ditambahkan.
            //                                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            //                                     <span aria-hidden="true">&times;</span>
            //                                     </button>
            //                                 </div>');
            redirect('pac/detailPacKec/'.$this->session->userdata('id_kecamatan'));
        }
    }

    public function editKepengurusan($id_pengurus_pac)
    {
        $data = [
            'title'         => 'PAC',
            'aktif'         => 'pac',
            'data'          => $this->Pac_model->getDataPengurusPacById($id_pengurus_pac)->result_array(),
            'jabatan'       => $this->Keanggotaan_model->getDataJabatan()->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('pac/editKepengurusan',$data);
		$this->load->view('templates/footer');
    }

    public function editKepengurusan_proses($id_pengurus_pac)
    {
        $this->_rulesEditKepengurusan();

        if($this->form_validation->run() == FALSE)
        {
            $this->editKepengurusan($id_pengurus_pac);

            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> Data Gagal Diubah.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        }
        else
        {
            $this->Pac_model->editKepengurusan($id_pengurus_pac);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            // redirect('pac/detailPacKec/'.$this->session->userdata('id_kecamatan'));
            redirect('pac/detailPacKec/'.$this->session->userdata('id_kecamatan'));
        }
    }

    public function hapusKepengurusan($id_pengurus_pac)
    {
        $this->db->where('id_pengurus_pac', $id_pengurus_pac);
        $this->db->delete('tb_pengurus_pac');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        redirect('pac/detailPacKec/'.$this->session->userdata('id_kecamatan'));
    }

    // public function getWilayahKabupaten($id_prov)
    // {
    //     $query = $this->db->get_where('wilayah_kab',array('id_prov'=>$id_prov));
    //     $data = "<option value=''>- Select Kabupaten -</option>";
    //     foreach ($query->result() as $value) {
    //         $data .= "<option value='".$value->id_kab."'>".$value->nm_kab."</option>";
    //     }
    //     echo $data;
    // }

    public function getWilayahKecamatan($id_kab)
    {
        $query = $this->db->get_where('wilayah_kec',array('id_kab'=>$id_kab));
        $data = "<option value=''>-Pilih Kecamatan-</option>";
        foreach ($query->result() as $value) {
            $data .= "<option value='".$value->id_kec."'>".$value->nm_kec."</option>";
        }
        echo $data;
    }

    public function _rules()
    {
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Alamat wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('no_telp', 'No. Telp', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> No. Telp wajib diisi'
        ]);

        $this->form_validation->set_rules('no_sk', 'No. SK', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> No. SK wajib diisi'
        ]);
        
        $this->form_validation->set_rules('tanggal_sk', 'Tanggal SK', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Tanggal SK wajib diisi'
        ]);
        
        $this->form_validation->set_rules('admin', 'Admin', 'required|trim',[
            'required'      => '<div class="text-danger small"><strong>Error!</strong> Admin wajib diisi'
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

        $this->form_validation->set_rules('kolom', 'Kolom', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Kolom wajib diisi'
        ]);
    }

    public function _rulesEditKepengurusan()
    {
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Jabatan wajib diisi'
        ]);

        $this->form_validation->set_rules('kolom', 'Kolom', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Kolom wajib diisi'
        ]);
    }

        // public function detailPac($id_pac)
    // {
    //     $data = [
    //         'title'         => 'PAC',
    //         'aktif'         => 'pac',
    //         'data'          => $this->Pac_model->getDataKecamatanById($id_pac)->result_array(),
    //         'keanggotaan'   => $this->Keanggotaan_model->getDataKeanggotaan()->result_array(),
    //         'jabatan'       => $this->Keanggotaan_model->getDataJabatan()->result_array(),
    //         'kepengurusan'  => $this->Pac_model->getDataKepengurusanPACbyId($id_pac)->result_array()
    //     ];

    //     $this->load->view('templates/header');
	// 	$this->load->view('templates/sidebar',$data);
	// 	$this->load->view('pac/detailPac',$data);
	// 	$this->load->view('templates/footer');
    // }
}