<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dpc extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        
        $user = $this->session->userdata('userdata');
        if($user['level'] != 'Admin' && $user['level'] != 'Super Admin')
        {
            redirect('admin/auth');
        }
    }

    public function indexAdmKab()
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $data = [
            'title'         => 'DPC',
            'aktif'         => 'dpc',
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dpc/index',$data);
		$this->load->view('templates/footer');
    }
    
    //==========================ADMIN SEMUA========================//
    public function index()
    {
        $user = $this->session->userdata('userdata');
        if($user['level'] != 'Admin' && $user['level'] != 'Super Admin' || $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'DPC',
            'aktif'     => 'dpc',
            'wilayahKab'   => $this->Wilayah_kab_model->getDataWilayah()->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dpc/index',$data);
		$this->load->view('templates/footer');
    }

    public function detailKepengurusan($id_kab)
    {
        $data = [
            'title'         => 'DPC',
            'aktif'         => 'dpc',
            'data'          => $this->Wilayah_kab_model->getDataKab($id_kab)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dpc/detailKepengurusan',$data);
		$this->load->view('templates/footer');
    }

    public function detailDpc($id_dpc)
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $data = [
            'title'             => 'DPC',
            'aktif'             => 'dpc',
            'data'              => $this->Dpc_model->getDataDpcById($id_dpc)->result_array(),
            'keanggotaan'       => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktif()->result_array(),
            'keanggotaanKab'    => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktifIdKab($id_kab)->result_array(),
            'jabatan'           => $this->Keanggotaan_model->getDataJabatan()->result_array(),
            'kepengurusan'      => $this->Dpc_model->getDataKepengurusanDPCbyId($id_dpc)->result_array()
        ];

        $id = $this->uri->segment(3);
        $this->session->set_userdata('id', $id);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dpc/detailDpc',$data);
        $this->load->view('templates/footer');
        
    }

    public function detailDpcKab($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'             => 'DPC',
            'aktif'             => 'dpc',
            'data'              => $this->Dpc_model->getDataDpcByIdKab($id_kab)->result_array(),
            'keanggotaan'       => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktif()->result_array(),
            'keanggotaanKab'    => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktifIdKab($id_kab)->result_array(),
            'jabatan'           => $this->Keanggotaan_model->getDataJabatan()->result_array(),
            'kepengurusan'      => $this->Dpc_model->getDataKepengurusanDPCbyIdKab($id_kab)->result_array(),
            'kabupaten'         => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result_array()
        ];

        $id = $this->uri->segment(3);
        $this->session->set_userdata('id', $id);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dpc/detailDpc',$data);
        $this->load->view('templates/footer');
        
    }

    public function tambah()
    {
        $user = $this->session->userdata('userdata');
        $id   = $this->session->userdata('id');
        $id_kab = $user['id_kab'];

        $data = [
            'title'         => 'DPC',
            'aktif'         => 'dpc',
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayah()->result(),
            // 'wilayahById'   => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result()
            'wilayahKabById'=> $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id)->result(),
        ];
        
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('dpc/tambah',$data);
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
                redirect('dpc/tambah');
            }
            else
            {
                if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"] == "")
            {
                $foto_lama = $this->input->post('foto_kantor_lama');
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $scan_lama = $this->input->post('scan_sk_lama');

                $this->Dpc_model->tambahData($foto_lama, $foto_lama_1, $foto_lama_2, $scan_lama);

                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"] == "")
            {
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $scan_lama = $this->input->post('scan_sk_lama');

                $foto_lama = $this->input->post('foto_kantor_lama');
                $qk = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qk;
                unlink($f);

                $this->upload->do_upload('foto_kantor');
                $foto_kantor = $this->upload->data();
                $foto = $foto_kantor['file_name'];

                $this->Dpc_model->tambahData($foto, $foto_lama_1, $foto_lama_2, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["foto_kantor_1"]["name"] && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"] == "")
            {
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $scan_lama = $this->input->post('scan_sk_lama');

                $foto_lama = $this->input->post('foto_kantor_lama');
                $qk = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qk;
                unlink($f);

                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $qk1 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                $f1 = './uploads/'.$qk1;
                unlink($f1);

                $this->upload->do_upload('foto_kantor');
                $foto_kantor = $this->upload->data();
                $foto = $foto_kantor['file_name'];

                $this->upload->do_upload('foto_kantor_1');
                $foto_kantor_1 = $this->upload->data();
                $foto_1 = $foto_kantor_1['file_name'];

                $this->Dpc_model->tambahData($foto, $foto_1, $foto_lama_2, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] && $_FILES["scan_sk"]["name"] == "")
            {
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $scan_lama = $this->input->post('scan_sk_lama');

                $foto_lama = $this->input->post('foto_kantor_lama');
                $qk = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qk;
                unlink($f);

                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $qk2 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
                $f2 = './uploads/'.$qk2;
                unlink($f2);

                $this->upload->do_upload('foto_kantor');
                $foto_kantor = $this->upload->data();
                $foto = $foto_kantor['file_name'];

                $this->upload->do_upload('foto_kantor_2');
                $foto_kantor_2 = $this->upload->data();
                $foto_2 = $foto_kantor_2['file_name'];

                $this->Dpc_model->tambahData($foto, $foto_lama_1, $foto_2, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"])
            {
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');

                $foto_lama = $this->input->post('foto_kantor_lama');
                $qk = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qk;
                unlink($f);

                $scan_sk_lama = $this->input->post('scan_sk_lama');
                $qks = $this->db->query("SELECT * FROM tb_dpc WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
                $fs = './uploads/'.$qks;
                unlink($fs);

                $this->upload->do_upload('foto_kantor');
                $foto_kantor = $this->upload->data();
                $foto = $foto_kantor['file_name'];

                $this->upload->do_upload('scan_sk');
                $scan_sk = $this->upload->data();
                $scan = $scan_sk['file_name'];

                $this->Dpc_model->tambahData($foto, $foto_lama_1, $foto_lama_2, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["foto_kantor_1"]["name"] && $_FILES["foto_kantor_2"]["name"] && $_FILES["scan_sk"]["name"] == "")
            {
                $scan_lama = $this->input->post('scan_sk_lama');

                $foto_lama = $this->input->post('foto_kantor_lama');
                $qk = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qk;
                unlink($f);

                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $qk1 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                $f1 = './uploads/'.$qk1;
                unlink($f1);

                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $qk2 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
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

                $this->Dpc_model->tambahData($foto, $foto_1, $foto_2, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["foto_kantor_1"]["name"] && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"])
            {
                $foto_kantor_lama_2 = $this->input->post('foto_kantor_lama_2');

                $foto_lama = $this->input->post('foto_kantor_lama');
                $qk = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qk;
                unlink($f);

                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $qk1 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                $f1 = './uploads/'.$qk1;
                unlink($f1);

                $scan_sk_lama = $this->input->post('scan_sk_lama');
                $qks = $this->db->query("SELECT * FROM tb_dpc WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
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

                $this->Dpc_model->tambahData($foto, $foto_1, $foto_kantor_lama_2, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] && $_FILES["scan_sk"]["name"])
            {
                $foto_kantor_lama_1 = $this->input->post('foto_kantor_lama_1');

                $foto_lama = $this->input->post('foto_kantor_lama');
                $qk = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qk;
                unlink($f);

                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $qk2 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
                $f2 = './uploads/'.$qk2;
                unlink($f2);

                $scan_sk_lama = $this->input->post('scan_sk_lama');
                $qks = $this->db->query("SELECT * FROM tb_dpc WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
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

                $this->Dpc_model->tambahData($foto, $foto_kantor_lama_1, $foto_2, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }
            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"] == "")
            {
                $foto_lama = $this->input->post('foto_kantor_lama');
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $scan_lama = $this->input->post('scan_sk_lama');

                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $qk1 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                $f1 = './uploads/'.$qk1;
                unlink($f1);

                $this->upload->do_upload('foto_kantor_1');
                $foto_kantor_1 = $this->upload->data();
                $foto_1 = $foto_kantor_1['file_name'];

                $this->Dpc_model->tambahData($foto_lama, $foto_1, $foto_lama_2, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }
            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] && $_FILES["foto_kantor_2"]["name"] && $_FILES["scan_sk"]["name"] == "")
            {
                $foto_lama = $this->input->post('foto_kantor_lama');
                $scan_lama = $this->input->post('scan_sk_lama');
                
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $qk1 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                $f1 = './uploads/'.$qk1;
                unlink($f1);

                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $qk2 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
                $f2 = './uploads/'.$qk2;
                unlink($f2);

                $this->upload->do_upload('foto_kantor_1');
                $foto_kantor_1 = $this->upload->data();
                $foto_1 = $foto_kantor_1['file_name'];
           
                $this->upload->do_upload('foto_kantor_2');
                $foto_kantor_2 = $this->upload->data();
                $foto_2 = $foto_kantor_2['file_name'];

                $this->Dpc_model->tambahData($foto_lama, $foto_1, $foto_2, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }

            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"])
            {
                $foto_lama = $this->input->post('foto_kantor_lama');
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
               
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $qk1 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                $f1 = './uploads/'.$qk1;
                unlink($f1);

                $scan_sk_lama = $this->input->post('scan_sk_lama');
                $qks = $this->db->query("SELECT * FROM tb_dpc WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
                $fs = './uploads/'.$qks;
                unlink($fs);

                $this->upload->do_upload('foto_kantor_1');
                $foto_kantor_1 = $this->upload->data();
                $foto_1 = $foto_kantor_1['file_name'];

                $this->upload->do_upload('scan_sk');
                $scan_sk = $this->upload->data();
                $scan = $scan_sk['file_name'];

                $this->Dpc_model->tambahData($foto_lama, $foto_1, $foto_lama_2, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }
            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] && $_FILES["foto_kantor_2"]["name"] && $_FILES["scan_sk"]["name"])
            {
                $foto_lama = $this->input->post('foto_kantor_lama');

                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $qk1 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                $f1 = './uploads/'.$qk1;
                unlink($f1);

                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $qk2 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
                $f2 = './uploads/'.$qk2;
                unlink($f2);

                $scan_sk_lama = $this->input->post('scan_sk_lama');
                $qks = $this->db->query("SELECT * FROM tb_dpc WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
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

                $this->Dpc_model->tambahData($foto_lama, $foto_1, $foto_2, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }
            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] && $_FILES["scan_sk"]["name"] == "")
            {
                $foto_lama = $this->input->post('foto_kantor_lama');
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $scan_lama = $this->input->post('scan_sk_lama');

                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $qk2 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
                $f2 = './uploads/'.$qk2;
                unlink($f2);

                $this->upload->do_upload('foto_kantor_2');
                $foto_kantor_2 = $this->upload->data();
                $foto_2 = $foto_kantor_2['file_name'];

                $this->Dpc_model->tambahData($foto_lama, $foto_lama_1, $foto_2, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }
            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] && $_FILES["scan_sk"]["name"])
            {
                $foto_lama = $this->input->post('foto_kantor_lama');
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $qk2 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
                $f2 = './uploads/'.$qk2;
                unlink($f2);

                $scan_sk_lama = $this->input->post('scan_sk_lama');
                $qks = $this->db->query("SELECT * FROM tb_dpc WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
                $fs = './uploads/'.$qks;
                unlink($fs);

                $this->upload->do_upload('foto_kantor_2');
                $foto_kantor_2 = $this->upload->data();
                $foto_2 = $foto_kantor_2['file_name'];

                $this->upload->do_upload('scan_sk');
                $scan_sk = $this->upload->data();
                $scan = $scan_sk['file_name'];

                $this->Dpc_model->tambahData($foto_lama, $foto_lama_1, $foto_2, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }
            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"])
            {
                $foto_lama = $this->input->post('foto_kantor_lama');
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');

                $scan_sk_lama = $this->input->post('scan_sk_lama');
                $qks = $this->db->query("SELECT * FROM tb_dpc WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
                $fs = './uploads/'.$qks;
                unlink($fs);

                $this->upload->do_upload('scan_sk');
                $scan_sk = $this->upload->data();
                $scan = $scan_sk['file_name'];

                $this->Dpc_model->tambahData($foto_lama, $foto_lama_1, $foto_lama_2, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }
            }
            else
            {
                if(!$this->upload->do_upload('foto_kantor') && !$this->upload->do_upload('foto_kantor_1') && !$this->upload->do_upload('foto_kantor_2') && !$this->upload->do_upload('scan_sk'))
                {
                    $this->tambah();
                }
                else
                {
                    $foto_lama = $this->input->post('foto_kantor_lama');
                    $qk = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                    $f = './uploads/'.$qk;
                    unlink($f);

                    $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                    $qk1 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                    $f1 = './uploads/'.$qk1;
                    unlink($f1);

                    $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                    $qk2 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
                    $f2 = './uploads/'.$qk2;
                    unlink($f2);

                    $scan_sk_lama = $this->input->post('scan_sk_lama');
                    $qks = $this->db->query("SELECT * FROM tb_dpc WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
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

                    $this->Dpc_model->tambahData($foto, $foto_1, $foto_2, $scan);
                    $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');
                    if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }
                }
            }
        }
    }
    }
    public function detail($id_dpc)
    {
        $data = [
            'title'  => 'DPC',
            'aktif'  => 'dpc',
            'data'   => $this->Dpc_model->getDataDpcById($id_dpc)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dpc/detail',$data);
		$this->load->view('templates/footer');
    }

    public function edit($id_dpc)
    {
        $data = [
            'title'         => 'DPC',
            'aktif'         => 'dpc',
            'data'          => $this->Dpc_model->getDataDpcById($id_dpc)->result_array(),
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayah()->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dpc/edit',$data);
		$this->load->view('templates/footer');
    }

    public function edit_proses($id_dpc)
    {
        $user = $this->session->userdata('userdata');

        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->edit($id_dpc);
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

                $this->Dpc_model->edit($id_dpc, $foto_lama, $foto_lama_1, $foto_lama_2, $scan_lama);

                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"] == "")
            {
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $scan_lama = $this->input->post('scan_sk_lama');

                $foto_lama = $this->input->post('foto_kantor_lama');
                $qk = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qk;
                unlink($f);

                $this->upload->do_upload('foto_kantor');
                $foto_kantor = $this->upload->data();
                $foto = $foto_kantor['file_name'];

                $this->Dpc_model->edit($id_dpc, $foto, $foto_lama_1, $foto_lama_2, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["foto_kantor_1"]["name"] && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"] == "")
            {
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $scan_lama = $this->input->post('scan_sk_lama');

                $foto_lama = $this->input->post('foto_kantor_lama');
                $qk = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qk;
                unlink($f);

                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $qk1 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                $f1 = './uploads/'.$qk1;
                unlink($f1);

                $this->upload->do_upload('foto_kantor');
                $foto_kantor = $this->upload->data();
                $foto = $foto_kantor['file_name'];

                $this->upload->do_upload('foto_kantor_1');
                $foto_kantor_1 = $this->upload->data();
                $foto_1 = $foto_kantor_1['file_name'];

                $this->Dpc_model->edit($id_dpc, $foto, $foto_1, $foto_lama_2, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] && $_FILES["scan_sk"]["name"] == "")
            {
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $scan_lama = $this->input->post('scan_sk_lama');

                $foto_lama = $this->input->post('foto_kantor_lama');
                $qk = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qk;
                unlink($f);

                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $qk2 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
                $f2 = './uploads/'.$qk2;
                unlink($f2);

                $this->upload->do_upload('foto_kantor');
                $foto_kantor = $this->upload->data();
                $foto = $foto_kantor['file_name'];

                $this->upload->do_upload('foto_kantor_2');
                $foto_kantor_2 = $this->upload->data();
                $foto_2 = $foto_kantor_2['file_name'];

                $this->Dpc_model->edit($id_dpc, $foto, $foto_lama_1, $foto_2, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"])
            {
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');

                $foto_lama = $this->input->post('foto_kantor_lama');
                $qk = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qk;
                unlink($f);

                $scan_sk_lama = $this->input->post('scan_sk_lama');
                $qks = $this->db->query("SELECT * FROM tb_dpc WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
                $fs = './uploads/'.$qks;
                unlink($fs);

                $this->upload->do_upload('foto_kantor');
                $foto_kantor = $this->upload->data();
                $foto = $foto_kantor['file_name'];

                $this->upload->do_upload('scan_sk');
                $scan_sk = $this->upload->data();
                $scan = $scan_sk['file_name'];

                $this->Dpc_model->edit($id_dpc, $foto, $foto_lama_1, $foto_lama_2, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["foto_kantor_1"]["name"] && $_FILES["foto_kantor_2"]["name"] && $_FILES["scan_sk"]["name"] == "")
            {
                $scan_lama = $this->input->post('scan_sk_lama');

                $foto_lama = $this->input->post('foto_kantor_lama');
                $qk = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qk;
                unlink($f);

                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $qk1 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                $f1 = './uploads/'.$qk1;
                unlink($f1);

                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $qk2 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
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

                $this->Dpc_model->edit($id_dpc, $foto, $foto_1, $foto_2, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["foto_kantor_1"]["name"] && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"])
            {
                $foto_kantor_lama_2 = $this->input->post('foto_kantor_lama_2');

                $foto_lama = $this->input->post('foto_kantor_lama');
                $qk = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qk;
                unlink($f);

                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $qk1 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                $f1 = './uploads/'.$qk1;
                unlink($f1);

                $scan_sk_lama = $this->input->post('scan_sk_lama');
                $qks = $this->db->query("SELECT * FROM tb_dpc WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
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

                $this->Dpc_model->edit($id_dpc, $foto, $foto_1, $foto_kantor_lama_2, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }
            }
            else if($_FILES["foto_kantor"]["name"] && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] && $_FILES["scan_sk"]["name"])
            {
                $foto_kantor_lama_1 = $this->input->post('foto_kantor_lama_1');

                $foto_lama = $this->input->post('foto_kantor_lama');
                $qk = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                $f = './uploads/'.$qk;
                unlink($f);

                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $qk2 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
                $f2 = './uploads/'.$qk2;
                unlink($f2);

                $scan_sk_lama = $this->input->post('scan_sk_lama');
                $qks = $this->db->query("SELECT * FROM tb_dpc WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
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

                $this->Dpc_model->edit($id_dpc, $foto, $foto_kantor_lama_1, $foto_2, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }
            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"] == "")
            {
                $foto_lama = $this->input->post('foto_kantor_lama');
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $scan_lama = $this->input->post('scan_sk_lama');

                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $qk1 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                $f1 = './uploads/'.$qk1;
                unlink($f1);

                $this->upload->do_upload('foto_kantor_1');
                $foto_kantor_1 = $this->upload->data();
                $foto_1 = $foto_kantor_1['file_name'];

                $this->Dpc_model->edit($id_dpc, $foto_lama, $foto_1, $foto_lama_2, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }
            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] && $_FILES["foto_kantor_2"]["name"] && $_FILES["scan_sk"]["name"] == "")
            {
                $foto_lama = $this->input->post('foto_kantor_lama');
                $scan_lama = $this->input->post('scan_sk_lama');
                
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $qk1 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                $f1 = './uploads/'.$qk1;
                unlink($f1);

                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $qk2 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
                $f2 = './uploads/'.$qk2;
                unlink($f2);

                $this->upload->do_upload('foto_kantor_1');
                $foto_kantor_1 = $this->upload->data();
                $foto_1 = $foto_kantor_1['file_name'];
           
                $this->upload->do_upload('foto_kantor_2');
                $foto_kantor_2 = $this->upload->data();
                $foto_2 = $foto_kantor_2['file_name'];

                $this->Dpc_model->edit($id_dpc, $foto_lama, $foto_1, $foto_2, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }

            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"])
            {
                $foto_lama = $this->input->post('foto_kantor_lama');
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
               
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $qk1 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                $f1 = './uploads/'.$qk1;
                unlink($f1);

                $scan_sk_lama = $this->input->post('scan_sk_lama');
                $qks = $this->db->query("SELECT * FROM tb_dpc WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
                $fs = './uploads/'.$qks;
                unlink($fs);

                $this->upload->do_upload('foto_kantor_1');
                $foto_kantor_1 = $this->upload->data();
                $foto_1 = $foto_kantor_1['file_name'];

                $this->upload->do_upload('scan_sk');
                $scan_sk = $this->upload->data();
                $scan = $scan_sk['file_name'];

                $this->Dpc_model->edit($id_dpc, $foto_lama, $foto_1, $foto_lama_2, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }
            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] && $_FILES["foto_kantor_2"]["name"] && $_FILES["scan_sk"]["name"])
            {
                $foto_lama = $this->input->post('foto_kantor_lama');

                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $qk1 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                $f1 = './uploads/'.$qk1;
                unlink($f1);

                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $qk2 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
                $f2 = './uploads/'.$qk2;
                unlink($f2);

                $scan_sk_lama = $this->input->post('scan_sk_lama');
                $qks = $this->db->query("SELECT * FROM tb_dpc WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
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

                $this->Dpc_model->edit($id_dpc, $foto_lama, $foto_1, $foto_2, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }
            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] && $_FILES["scan_sk"]["name"] == "")
            {
                $foto_lama = $this->input->post('foto_kantor_lama');
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $scan_lama = $this->input->post('scan_sk_lama');

                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $qk2 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
                $f2 = './uploads/'.$qk2;
                unlink($f2);

                $this->upload->do_upload('foto_kantor_2');
                $foto_kantor_2 = $this->upload->data();
                $foto_2 = $foto_kantor_2['file_name'];

                $this->Dpc_model->edit($id_dpc, $foto_lama, $foto_lama_1, $foto_2, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }
            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] && $_FILES["scan_sk"]["name"])
            {
                $foto_lama = $this->input->post('foto_kantor_lama');
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                $qk2 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
                $f2 = './uploads/'.$qk2;
                unlink($f2);

                $scan_sk_lama = $this->input->post('scan_sk_lama');
                $qks = $this->db->query("SELECT * FROM tb_dpc WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
                $fs = './uploads/'.$qks;
                unlink($fs);

                $this->upload->do_upload('foto_kantor_2');
                $foto_kantor_2 = $this->upload->data();
                $foto_2 = $foto_kantor_2['file_name'];

                $this->upload->do_upload('scan_sk');
                $scan_sk = $this->upload->data();
                $scan = $scan_sk['file_name'];

                $this->Dpc_model->edit($id_dpc, $foto_lama, $foto_lama_1, $foto_2, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }
            }
            else if($_FILES["foto_kantor"]["name"] == "" && $_FILES["foto_kantor_1"]["name"] == "" && $_FILES["foto_kantor_2"]["name"] == "" && $_FILES["scan_sk"]["name"])
            {
                $foto_lama = $this->input->post('foto_kantor_lama');
                $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                $foto_lama_2 = $this->input->post('foto_kantor_lama_2');

                $scan_sk_lama = $this->input->post('scan_sk_lama');
                $qks = $this->db->query("SELECT * FROM tb_dpc WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
                $fs = './uploads/'.$qks;
                unlink($fs);

                $this->upload->do_upload('scan_sk');
                $scan_sk = $this->upload->data();
                $scan = $scan_sk['file_name'];

                $this->Dpc_model->edit($id_dpc, $foto_lama, $foto_lama_1, $foto_lama_2, $scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                if($user['id_kab'])
                {
                    redirect('dpc/indexAdmKab');
                }
                else
                {
                    redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                }
            }
            else
            {
                if(!$this->upload->do_upload('foto_kantor') && !$this->upload->do_upload('foto_kantor_1') && !$this->upload->do_upload('foto_kantor_2') && !$this->upload->do_upload('scan_sk'))
                {
                    $data = [
                        'title'         => 'DPC',
                        'aktif'         => 'dpc',
                        'data'          => $this->Dpc_model->getDataDpcById($id_dpc)->result_array()
                    ];
            
                    $this->load->view('templates/header');
                    $this->load->view('templates/sidebar',$data);
                    $this->load->view('dpc',$data);
                    $this->load->view('templates/footer');
                }
                else
                {
                    $foto_lama = $this->input->post('foto_kantor_lama');
                    $qk = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor = '$foto_lama' ")->row()->foto_kantor;
                    $f = './uploads/'.$qk;
                    unlink($f);

                    $foto_lama_1 = $this->input->post('foto_kantor_lama_1');
                    $qk1 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_1 = '$foto_lama_1' ")->row()->foto_kantor_1;
                    $f1 = './uploads/'.$qk1;
                    unlink($f1);

                    $foto_lama_2 = $this->input->post('foto_kantor_lama_2');
                    $qk2 = $this->db->query("SELECT * FROM tb_dpc WHERE foto_kantor_2 = '$foto_lama_2' ")->row()->foto_kantor_2;
                    $f2 = './uploads/'.$qk2;
                    unlink($f2);

                    $scan_sk_lama = $this->input->post('scan_sk_lama');
                    $qks = $this->db->query("SELECT * FROM tb_dpc WHERE scan_sk = '$scan_sk_lama' ")->row()->scan_sk;
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

                    $this->Dpc_model->edit($id_dpc, $foto, $foto_1, $foto_2, $scan);
                    $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');
                    if($user['id_kab'])
                    {
                        redirect('dpc/indexAdmKab');
                    }
                    else
                    {
                        redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
                    }
                }
            }
        }
    }

    public function tambah_kepengurusan_proses()
    {
        // $id_kab = $this->session->userdata('id');
        $this->_rulesKepengurusan();

        if($this->form_validation->run() == FALSE)
        {
            // $this->detailDpcKab($id_kab);
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> Data Gagal Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
        }
        else
        {
            $this->Dpc_model->tambahDataKepengurusan();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
        }
    }

    public function editKepengurusan($id_pengurus_dpc)
    {
        $data = [
            'title'         => 'DPC',
            'aktif'         => 'dpc',
            'data'          => $this->Dpc_model->getDataPengurusDpcById($id_pengurus_dpc)->result_array(),
            'jabatan'       => $this->Keanggotaan_model->getDataJabatan()->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dpc/editKepengurusan',$data);
		$this->load->view('templates/footer');
    }

    public function editKepengurusan_proses($id_pengurus_dpc)
    {
        $this->_rulesEditKepengurusan();

        if($this->form_validation->run() == FALSE)
        {
            $this->editKepengurusan($id_pengurus_dpc);

            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> Data Gagal Diubah.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        }
        else
        {
            $this->Dpc_model->editKepengurusan($id_pengurus_dpc);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
        }
    }

    public function hapusKepengurusan($id_pengurus_dpc)
    {
        $this->db->where('id_pengurus_dpc', $id_pengurus_dpc);
        $this->db->delete('tb_pengurus_dpc');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
    }

    public function hapus($id_dpc)
    {
        $user = $this->session->userdata('userdata');
        
        $qf = $this->db->query("SELECT * FROM tb_dpc WHERE id_dpc = '$id_dpc'")->row()->foto_kantor;
        $fileFoto = './uploads/'.$qf;
        unlink($fileFoto);

        $qs = $this->db->query("SELECT * FROM tb_dpc WHERE id_dpc = '$id_dpc'")->row()->scan_sk;
        $fileScan = './uploads/'.$qs;
        unlink($fileScan);

        $this->db->where('id_dpc', $id_dpc);
        $this->db->delete('tb_dpc');
        
        $this->db->where('id_dpc', $id_dpc);
        $this->db->delete('tb_pengurus_dpc');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        if($user['id_kab'])
        {
            redirect('dpc/indexAdmKab');
        }
        else
        {
            redirect('dpc/detailDpcKab/'.$this->session->userdata('id'));
        }
    }

    public function _rules()
    {
        // $this->form_validation->set_rules('dpc_kab_kota', 'DPC Kab/Kota', 'required|trim|',[
        //     'required'  => '<div class="text-danger small"><strong>Error!</strong> DPC Kab/Kota wajib diisi</div>'
        // ]);

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
}