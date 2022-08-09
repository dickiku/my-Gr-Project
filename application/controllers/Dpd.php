<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dpd extends CI_Controller{

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
            'title'     => 'DPD',
            'aktif'     => 'dpd'
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dpd/index',$data);
		$this->load->view('templates/footer');
    }

    public function kepengurusan()
    {
        $data = [
            'title'             => 'DPD',
            'aktif'             => 'dpd',
            'data'              => $this->Dpd_model->getDataKepengurusan()->result_array(),
            'keanggotaan'       => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktif()->result_array(),
            'jabatan'           => $this->Keanggotaan_model->getDataJabatan()->result_array(),
            'kepengurusan'      => $this->Dpd_model->getDataKepengurusanDPD()->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dpd/kepengurusan',$data);
		$this->load->view('templates/footer');
    }
    
    public function get_kepengurusan() {
        $result = array();
            $projects_count = count($this->Dpd_model->getDataKepengurusanDPD()->result_array());
            $result[] = array($projects_count);
        
        return json_encode($result);
    }

    public function tambah_kepengurusan_proses()
    {
        $this->_rulesKepengurusan();

        if($this->form_validation->run() == FALSE)
        {
            $this->kepengurusan();
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> Data Gagal Ditambah.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        }
        else
        {
            $this->Dpd_model->tambahDataKepengurusan();
            
            redirect('dpd/kepengurusan');
        }
    }

    // public function tambahKepengurusan()
    // {
    //     $data = [
    //         'title'         => 'DPD',
    //         'aktif'         => 'dpd',
    //         'data'          => $this->Keanggotaan_model->getDataKeanggotaan()
    //     ];
        
    //     $this->load->view('templates/header');
    //     $this->load->view('templates/sidebar',$data);
    //     $this->load->view('dpd/tambah',$data);
    //     $this->load->view('templates/footer');
    // }

    // public function tambah_proses()
    // {
    //     $this->_rules();

    //     if($this->form_validation->run() == FALSE)
    //     {
    //         $this->tambah();
    //     }
    //     else
    //     {
    //         //setting config untuk library upload
    //         $config['upload_path']      = './uploads';
    //         $config['allowed_types']    = 'gif|jpg|png|pdf';
    //         $config['max_size']         = 1000000000;
    //         $config['max_width']        = 1024000;
    //         $config['max_height']       = 768000;

    //         //pemanggilan librabry upload
    //         $this->load->library('upload', $config);

    //         //jika upload gagal
    //         if(!$this->upload->do_upload('scan_sk') && !$this->upload->do_upload('file_kantor'))
    //         {

    //             $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //                                            <strong>Error!</strong> Data Gagal Ditambah.
    //                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    //                                            <span aria-hidden="true">&times;</span>
    //                                            </button>
    //                                        </div>');
    //             redirect('dpd/tambah');
    //         }
    //         else
    //         {
    //             $this->upload->do_upload('scan_sk');
    //             $scan_sk = $this->upload->data();
    //             $scan = $scan_sk['file_name'];
                
    //             $this->upload->do_upload('foto_kantor');
    //             $foto_kantor = $this->upload->data();
    //             $foto = $foto_kantor['file_name'];

    //             $this->Dpd_model->tambahData($foto, $scan);
    //             $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
    //                                            <strong>Sukses!</strong> Data Berhasil Ditambah.
    //                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    //                                            <span aria-hidden="true">&times;</span>
    //                                            </button>
    //                                        </div>');
    //             redirect('dpd/kepengurusan');
    //         }
    //     }
    // }

    public function detail($id_dpd)
    {
        $data = [
            'title'  => 'DPD',
            'aktif'  => 'dpd',
            'data'   => $this->Dpd_model->getDataDpdById($id_dpd)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dpd/detail',$data);
		$this->load->view('templates/footer');
    }

    public function edit($id_dpd)
    {
        $data = [
            'title'         => 'DPD',
            'aktif'         => 'dpd',
            'data'          => $this->Dpd_model->getDataDpdById($id_dpd)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dpd/edit',$data);
		$this->load->view('templates/footer');
    }

    public function edit_proses($id_dpd)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->edit($id_dpd);

            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> Data Gagal Diubah.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        }
        else
        {
            //setting config untuk library upload
            $config['upload_path']      = './uploads';
            $config['encrypt_name']     = true;
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

                $this->Dpd_model->edit($id_dpd, $foto_lama, $foto_lama_1, $foto_lama_2, $scan_lama);

                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('dpd/kepengurusan');
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"] == "")
            {
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $scan_lama = $this->input->post('scan_sk_lama');

                $foto_lama = $this->input->post('foto_kantor_lama');
                $qk = $this->db->query("SELECT * FROM tb_dpd WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qk;
                unlink($f);

                $this->upload->do_upload('foto_kantor');
                $foto_kantor = $this->upload->data();
                $foto = $foto_kantor['file_name'];

                $this->Dpd_model->edit($id_dpd, $foto, $foto_lama_1, $foto_lama_2, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('dpd/kepengurusan');
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["foto_kantor_1"]["name"] && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"] == "")
            {
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $scan_lama = $this->input->post('scan_sk_lama');

                $foto_lama = $this->input->post('foto_kantor_lama');
                $qk = $this->db->query("SELECT * FROM tb_dpd WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qk;
                unlink($f);

                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $qk1 = $this->db->query("SELECT * FROM tb_dpd WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                $f1 = './uploads/'.$qk1;
                unlink($f1);

                $this->upload->do_upload('foto_kantor');
                $foto_kantor = $this->upload->data();
                $foto = $foto_kantor['file_name'];

                $this->upload->do_upload('foto_kantor_1');
                $foto_kantor_1 = $this->upload->data();
                $foto_1 = $foto_kantor_1['file_name'];

                $this->Dpd_model->edit($id_dpd, $foto, $foto_1, $foto_lama_2, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('dpd/kepengurusan');
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] && $_FILES["scan_sk"]["name"] == "")
            {
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $scan_lama = $this->input->post('scan_sk_lama');

                $foto_lama = $this->input->post('foto_kantor_lama');
                $qk = $this->db->query("SELECT * FROM tb_dpd WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qk;
                unlink($f);

                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $qk2 = $this->db->query("SELECT * FROM tb_dpd WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
                $f2 = './uploads/'.$qk2;
                unlink($f2);

                $this->upload->do_upload('foto_kantor');
                $foto_kantor = $this->upload->data();
                $foto = $foto_kantor['file_name'];

                $this->upload->do_upload('foto_kantor_2');
                $foto_kantor_2 = $this->upload->data();
                $foto_2 = $foto_kantor_2['file_name'];

                $this->Dpd_model->edit($id_dpd, $foto, $foto_lama_1, $foto_2, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('dpd/kepengurusan');
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"])
            {
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');

                $foto_lama = $this->input->post('foto_kantor_lama');
                $qk = $this->db->query("SELECT * FROM tb_dpd WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qk;
                unlink($f);

                $scan_sk_lama = $this->input->post('scan_sk_lama');
                $qks = $this->db->query("SELECT * FROM tb_dpd WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
                $fs = './uploads/'.$qks;
                unlink($fs);

                $this->upload->do_upload('foto_kantor');
                $foto_kantor = $this->upload->data();
                $foto = $foto_kantor['file_name'];

                $this->upload->do_upload('scan_sk');
                $scan_sk = $this->upload->data();
                $scan = $scan_sk['file_name'];

                $this->Dpd_model->edit($id_dpd, $foto, $foto_lama_1, $foto_lama_2, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('dpd/kepengurusan');
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["foto_kantor_1"]["name"] && $_FILES["foto_kantor_2"]["name"] && $_FILES["scan_sk"]["name"] == "")
            {
                $scan_lama = $this->input->post('scan_sk_lama');

                $foto_lama = $this->input->post('foto_kantor_lama');
                $qk = $this->db->query("SELECT * FROM tb_dpd WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qk;
                unlink($f);

                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $qk1 = $this->db->query("SELECT * FROM tb_dpd WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                $f1 = './uploads/'.$qk1;
                unlink($f1);

                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $qk2 = $this->db->query("SELECT * FROM tb_dpd WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
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

                $this->Dpd_model->edit($id_dpd, $foto, $foto_1, $foto_2, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('dpd/kepengurusan');
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["foto_kantor_1"]["name"] && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"])
            {
                $foto_kantor_lama_2 = $this->input->post('foto_kantor_lama_2');

                $foto_lama = $this->input->post('foto_kantor_lama');
                $qk = $this->db->query("SELECT * FROM tb_dpd WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qk;
                unlink($f);

                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $qk1 = $this->db->query("SELECT * FROM tb_dpd WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                $f1 = './uploads/'.$qk1;
                unlink($f1);

                $scan_sk_lama = $this->input->post('scan_sk_lama');
                $qks = $this->db->query("SELECT * FROM tb_dpd WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
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

                $this->Dpd_model->edit($id_dpd, $foto, $foto_1, $foto_kantor_lama_2, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('dpd/kepengurusan');
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] && $_FILES["scan_sk"]["name"])
            {
                $foto_kantor_lama_1 = $this->input->post('foto_kantor_lama_1');

                $foto_lama = $this->input->post('foto_kantor_lama');
                $qk = $this->db->query("SELECT * FROM tb_dpd WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qk;
                unlink($f);

                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $qk2 = $this->db->query("SELECT * FROM tb_dpd WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
                $f2 = './uploads/'.$qk2;
                unlink($f2);

                $scan_sk_lama = $this->input->post('scan_sk_lama');
                $qks = $this->db->query("SELECT * FROM tb_dpd WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
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

                $this->Dpd_model->edit($id_dpd, $foto, $foto_kantor_lama_1, $foto_2, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('dpd/kepengurusan');
            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"] == "")
            {
                $foto_lama = $this->input->post('foto_kantor_lama');
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $scan_lama = $this->input->post('scan_sk_lama');

                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $qk1 = $this->db->query("SELECT * FROM tb_dpd WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                $f1 = './uploads/'.$qk1;
                unlink($f1);

                $this->upload->do_upload('foto_kantor_1');
                $foto_kantor_1 = $this->upload->data();
                $foto_1 = $foto_kantor_1['file_name'];

                $this->Dpd_model->edit($id_dpd, $foto_lama, $foto_1, $foto_lama_2, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('dpd/kepengurusan');
            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] && $_FILES["foto_kantor_2"]["name"] && $_FILES["scan_sk"]["name"] == "")
            {
                $foto_lama = $this->input->post('foto_kantor_lama');
                $scan_lama = $this->input->post('scan_sk_lama');
                
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $qk1 = $this->db->query("SELECT * FROM tb_dpd WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                $f1 = './uploads/'.$qk1;
                unlink($f1);

                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $qk2 = $this->db->query("SELECT * FROM tb_dpd WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
                $f2 = './uploads/'.$qk2;
                unlink($f2);

                $this->upload->do_upload('foto_kantor_1');
                $foto_kantor_1 = $this->upload->data();
                $foto_1 = $foto_kantor_1['file_name'];
           
                $this->upload->do_upload('foto_kantor_2');
                $foto_kantor_2 = $this->upload->data();
                $foto_2 = $foto_kantor_2['file_name'];

                $this->Dpd_model->edit($id_dpd, $foto_lama, $foto_1, $foto_2, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('dpd/kepengurusan');

            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"])
            {
                $foto_lama = $this->input->post('foto_kantor_lama');
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
               
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $qk1 = $this->db->query("SELECT * FROM tb_dpd WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                $f1 = './uploads/'.$qk1;
                unlink($f1);

                $scan_sk_lama = $this->input->post('scan_sk_lama');
                $qks = $this->db->query("SELECT * FROM tb_dpd WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
                $fs = './uploads/'.$qks;
                unlink($fs);

                $this->upload->do_upload('foto_kantor_1');
                $foto_kantor_1 = $this->upload->data();
                $foto_1 = $foto_kantor_1['file_name'];

                $this->upload->do_upload('scan_sk');
                $scan_sk = $this->upload->data();
                $scan = $scan_sk['file_name'];

                $this->Dpd_model->edit($id_dpd, $foto_lama, $foto_1, $foto_lama_2, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('dpd/kepengurusan');
            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] && $_FILES["foto_kantor_2"]["name"] && $_FILES["scan_sk"]["name"])
            {
                $foto_lama = $this->input->post('foto_kantor_lama');

                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $qk1 = $this->db->query("SELECT * FROM tb_dpd WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                $f1 = './uploads/'.$qk1;
                unlink($f1);

                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $qk2 = $this->db->query("SELECT * FROM tb_dpd WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
                $f2 = './uploads/'.$qk2;
                unlink($f2);

                $scan_sk_lama = $this->input->post('scan_sk_lama');
                $qks = $this->db->query("SELECT * FROM tb_dpd WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
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

                $this->Dpd_model->edit($id_dpd, $foto_lama, $foto_1, $foto_2, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('dpd/kepengurusan');
            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] && $_FILES["scan_sk"]["name"] == "")
            {
                $foto_lama = $this->input->post('foto_kantor_lama');
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $scan_lama = $this->input->post('scan_sk_lama');

                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $qk2 = $this->db->query("SELECT * FROM tb_dpd WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
                $f2 = './uploads/'.$qk2;
                unlink($f2);

                $this->upload->do_upload('foto_kantor_2');
                $foto_kantor_2 = $this->upload->data();
                $foto_2 = $foto_kantor_2['file_name'];

                $this->Dpd_model->edit($id_dpd, $foto_lama, $foto_lama_1, $foto_2, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('dpd/kepengurusan');
            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] && $_FILES["scan_sk"]["name"])
            {
                $foto_lama = $this->input->post('foto_kantor_lama');
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $qk2 = $this->db->query("SELECT * FROM tb_dpd WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
                $f2 = './uploads/'.$qk2;
                unlink($f2);

                $scan_sk_lama = $this->input->post('scan_sk_lama');
                $qks = $this->db->query("SELECT * FROM tb_dpd WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
                $fs = './uploads/'.$qks;
                unlink($fs);

                $this->upload->do_upload('foto_kantor_2');
                $foto_kantor_2 = $this->upload->data();
                $foto_2 = $foto_kantor_2['file_name'];

                $this->upload->do_upload('scan_sk');
                $scan_sk = $this->upload->data();
                $scan = $scan_sk['file_name'];

                $this->Dpd_model->edit($id_dpd, $foto_lama, $foto_lama_1, $foto_2, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('dpd/kepengurusan');
            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"])
            {
                $foto_lama = $this->input->post('foto_kantor_lama');
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');

                $scan_sk_lama = $this->input->post('scan_sk_lama');
                $qks = $this->db->query("SELECT * FROM tb_dpd WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
                $fs = './uploads/'.$qks;
                unlink($fs);

                $this->upload->do_upload('scan_sk');
                $scan_sk = $this->upload->data();
                $scan = $scan_sk['file_name'];

                $this->Dpd_model->edit($id_dpd, $foto_lama, $foto_lama_1, $foto_lama_2, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('dpd/kepengurusan');
            }
            else
            {
                if(!$this->upload->do_upload('foto_kantor') && !$this->upload->do_upload('foto_kantor_1') && !$this->upload->do_upload('foto_kantor_2') && !$this->upload->do_upload('scan_sk'))
                {
                    $data = [
                        'title'         => 'DPD',
                        'aktif'         => 'dpd',
                        'data'          => $this->Dpd_model->getDataDpdById($id_dpd)->result_array()
                    ];
            
                    $this->load->view('templates/header');
                    $this->load->view('templates/sidebar',$data);
                    $this->load->view('dpd/edit',$data);
                    $this->load->view('templates/footer');
                }
                else
                {
                    $foto_lama = $this->input->post('foto_kantor_lama');
                    $qk = $this->db->query("SELECT * FROM tb_dpd WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                    $f = './uploads/'.$qk;
                    unlink($f);

                    $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                    $qk1 = $this->db->query("SELECT * FROM tb_dpd WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                    $f1 = './uploads/'.$qk1;
                    unlink($f1);

                    $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                    $qk2 = $this->db->query("SELECT * FROM tb_dpd WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
                    $f2 = './uploads/'.$qk2;
                    unlink($f2);

                    $scan_sk_lama = $this->input->post('scan_sk_lama');
                    $qks = $this->db->query("SELECT * FROM tb_dpd WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
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

                    $this->Dpd_model->edit($id_dpd, $foto, $foto_1, $foto_2, $scan);
                    $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');
                    redirect('dpd/kepengurusan');
                }
            }
        }
    }

    public function editKepengurusan($id_pengurus_dpd)
    {
        $data = [
            'title'         => 'DPD',
            'aktif'         => 'dpd',
            'data'          => $this->Dpd_model->getDataPengurusDpdById($id_pengurus_dpd)->result_array(),
            'jabatan'       => $this->Keanggotaan_model->getDataJabatan()->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dpd/editKepengurusan',$data);
		$this->load->view('templates/footer');
    }

    public function editKepengurusan_proses($id_pengurus_dpd)
    {
        $this->_rulesEditKepengurusan();

        if($this->form_validation->run() == FALSE)
        {
            $this->editKepengurusan($id_pengurus_dpd);

            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> Data Gagal Diubah.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        }
        else
        {
            $this->Dpd_model->editKepengurusan($id_pengurus_dpd);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil Diupdate.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');
            redirect('dpd/kepengurusan');
        }
    }

    public function hapusKepengurusan($id_pengurus_dpd)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }
        
        $this->db->where('id_pengurus_dpd', $id_pengurus_dpd);
        $this->db->delete('tb_pengurus_dpd');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        redirect('dpd/kepengurusan');
    }

    public function hapus($id_dpd)
    {
        $qf = $this->db->query("SELECT * FROM tb_dpd WHERE id_dpd = '$id_dpd'")->row()->foto_kantor;
        $fileFoto = './uploads/'.$qf;
        unlink($fileFoto);

        $qs = $this->db->query("SELECT * FROM tb_dpd WHERE id_dpd = '$id_dpd'")->row()->scan_sk;
        $fileScan = './uploads/'.$qs;
        unlink($fileScan);

        $this->db->where('id_dpd', $id_dpd);
        $this->db->delete('tb_dpd');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        redirect('dpd/kepengurusan');
    }

    public function _rules()
    {
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Alamat wajib diisi'
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
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Keanggotaan wajib diisi',
            'matches'   => '<div class="text-danger small"><strong>Error!</strong> Daftar Keanggotaan tersebut tidak ada!',
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


}