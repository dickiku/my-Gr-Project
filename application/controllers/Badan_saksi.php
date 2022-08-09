<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Badan_saksi extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        
        $user = $this->session->userdata('userdata');
        if($user['level'] != 'Admin' && $user['level'] != 'Super Admin' && $user['id_kab'])
        {
            redirect('admin/auth');
        }
    }

    public function indexAdmKabBadanSaksi()
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $data = [
            'title'         => 'Badan Saksi',
            'aktif'         => 'badan_saksi',
            'sub'           => 'bs_sub',
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('badan_saksi/index',$data);
		$this->load->view('templates/footer');
    }
    
    //==========================ADMIN SEMUA========================//
    public function showKab()
    {
        $data = [
            'title'     => 'Badan Saksi',
            'aktif'     => 'badan_saksi',
            'sub'       => 'bs_sub',
            'wilayahKab'   => $this->Wilayah_kab_model->getDataWilayah()->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('badan_saksi/index',$data);
		$this->load->view('templates/footer');
    }

    public function showKec($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin')
        {
            if($user['id_kab'] != $id_kab)
            {
                $this->session->sess_destroy();
                redirect('admin/auth');
            }
            else
            {
                $data = [
                    'title'     => 'Badan Saksi',
                    'aktif'     => 'badan_saksi',
                    'sub'       => 'bs_sub',
                    'data'      => $this->Badan_saksi_model->getDataWilayahKec($id_kab)->result()
                ];
        
                $this->load->view('templates/header');
                $this->load->view('templates/sidebar',$data);
                $this->load->view('badan_saksi/kecamatan',$data);
                $this->load->view('templates/footer');
            }
        }
        else
        {
            $data = [
                'title'     => 'Badan Saksi',
                'aktif'     => 'badan_saksi',
                'sub'       => 'bs_sub',
                'data'      => $this->Badan_saksi_model->getDataWilayahKec($id_kab)->result()
            ];
    
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar',$data);
            $this->load->view('badan_saksi/kecamatan',$data);
            $this->load->view('templates/footer');
        }
    }

    public function showDesa($id_kec)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_kec,0,-3);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Badan Saksi',
            'aktif'     => 'badan_saksi',
            'sub'       => 'bs_sub',
            'data'      => $this->Badan_saksi_model->getDataWilayahDesa($id_kec)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('badan_saksi/desa',$data);
		$this->load->view('templates/footer');
    }

    public function showProv()
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Badan Saksi',
            'aktif'         => 'badan_saksi',
            'sub'           => 'bs_prov',
            'keterangan'    => $this->Badan_saksi_model->getDataBsSk(1,33)->result_array(),
            'data'          => $this->Badan_saksi_model->getStrukturProv()->result_array(),
            'keanggotaan'   => $this->Keanggotaan_model->getDataKeanggotaan()->result_array(),
            'jabatan'       => $this->Badan_saksi_model->getDataJabatan()->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('badan_saksi/detailProv',$data);
		$this->load->view('templates/footer');
    }

    public function detailSaksiKab($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Badan Saksi',
            'aktif'         => 'badan_saksi',
            'sub'           => 'bs_sub',
            'data'          => $this->Badan_saksi_model->getStrukturKab($id_kab)->result_array(),
            // 'keanggotaan'   => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktifIdKab($id_kab)->result_array(),
            'keterangan'    => $this->Badan_saksi_model->getDataBsSk(2,$id_kab)->result_array(),
            'keanggotaan'   => $this->Badan_saksi_model->getDataKeanggotaanKab($id_kab)->result_array(),
            'jabatan'       => $this->Badan_saksi_model->getDataJabatan()->result_array(),
            'kabupaten'     => $this->Badan_saksi_model->getDataBSKab($id_kab)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('badan_saksi/detailKab',$data);
		$this->load->view('templates/footer');
    }

    public function detailSaksiKec($id_kec)
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $subs = substr($id_kec,0,-3);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Badan Saksi',
            'aktif'         => 'badan_saksi',
            'sub'           => 'bs_sub',
            'data'          => $this->Badan_saksi_model->getStrukturKec($id_kec)->result_array(),
            // 'keanggotaan'   => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktifIdKab($id_kab)->result_array(),
            'keterangan'    => $this->Badan_saksi_model->getDataBsSk(3,$id_kec)->result_array(),
            'keanggotaan'   => $this->Badan_saksi_model->getDataKeanggotaanKec($id_kec)->result_array(),
            'jabatan'       => $this->Badan_saksi_model->getDataJabatan()->result_array(),
            'kecamatan'     => $this->Badan_saksi_model->getDataBSKec($id_kec)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('badan_saksi/detailKec',$data);
		$this->load->view('templates/footer');
    }

    public function detailSaksiDesa($id_desa)
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $subs = substr($id_desa,0,-8);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'Badan Saksi',
            'aktif'         => 'badan_saksi',
            'sub'           => 'bs_sub',
            'data'          => $this->Badan_saksi_model->getStrukturDesa($id_desa)->result_array(),
            // 'keanggotaan'   => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktifIdKab($id_kab)->result_array(),
            'keterangan'    => $this->Badan_saksi_model->getDataBsSk(4,$id_desa)->result_array(),
            'keanggotaan'   => $this->Badan_saksi_model->getDataKeanggotaanDesa($id_desa)->result_array(),
            'jabatan'       => $this->Badan_saksi_model->getDataJabatan()->result_array(),
            'desa'          => $this->Badan_saksi_model->getDataBSDesa($id_desa)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('badan_saksi/detailDesa',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_pengurus_prov()
    {
        $id_prov = $this->input->post('id_prov');

        $this->Badan_saksi_model->tambahPengurusProv();

        // $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        //                                         <strong>Sukses!</strong> Data Berhasil Ditambahkan.
        //                                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        //                                         <span aria-hidden="true">&times;</span>
        //                                         </button>
        //                                     </div>');

        redirect('badan_saksi/showProv/');
    }

    public function tambah_pengurus_kab()
    {
        $id_kab = $this->input->post('id_kab');

        $this->Badan_saksi_model->tambahPengurusKab();

        // $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        //                                         <strong>Sukses!</strong> Data Berhasil Ditambahkan.
        //                                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        //                                         <span aria-hidden="true">&times;</span>
        //                                         </button>
        //                                     </div>');

        redirect('badan_saksi/detailSaksiKab/'.$id_kab);
    }

    public function tambah_pengurus_kec()
    {
        $id_kec = $this->input->post('id_kec');

        $this->Badan_saksi_model->tambahPengurusKec();

        // $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        //                                         <strong>Sukses!</strong> Data Berhasil Ditambahkan.
        //                                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        //                                         <span aria-hidden="true">&times;</span>
        //                                         </button>
        //                                     </div>');

        redirect('badan_saksi/detailSaksiKec/'.$id_kec);
    }

    public function tambah_pengurus_desa()
    {
        $id_desa = $this->input->post('id_desa');

        $this->Badan_saksi_model->tambahPengurusDesa();

        // $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        //                                         <strong>Sukses!</strong> Data Berhasil Ditambahkan.
        //                                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        //                                         <span aria-hidden="true">&times;</span>
        //                                         </button>
        //                                     </div>');

        redirect('badan_saksi/detailSaksiDesa/'.$id_desa);
    }

    public function hapus_pengurus_kec($id_bs,$id_kec)
    {
        $this->db->where('id_badan_saksi_kec', $id_bs);
        $this->db->delete('tb_badan_saksi_kec');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        redirect('badan_saksi/detailSaksiKec/'.$id_kec);
    }

    public function hapus_pengurus_kab($id_bs,$id_kab)
    {
        $this->db->where('id_badan_saksi_kab', $id_bs);
        $this->db->delete('tb_badan_saksi_kab');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        redirect('badan_saksi/detailSaksiKab/'.$id_kab);
    }

    public function hapus_pengurus_prov($id_bs)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'])
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $this->db->where('id_badan_saksi_prov', $id_bs);
        $this->db->delete('tb_badan_saksi_prov');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        redirect('badan_saksi/showProv/');
    }

    public function hapus_pengurus_desa($id_bs,$id_desa)
    {
        $this->db->where('id_badan_saksi_desa', $id_bs);
        $this->db->delete('tb_badan_saksi_desa');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        redirect('badan_saksi/detailSaksiDesa/'.$id_desa);
    }

    public function showEdit($id_data,$id_func,$id_temp)
    {
        $data = [
            'title'         => 'Badan Saksi',
            'aktif'         => 'badan_saksi',
            'sub'           => 'bs_sub',
            'keanggotaan'   => $this->Keanggotaan_model->getDataKeanggotaan()->result_array(),
            'jabatan'       => $this->Badan_saksi_model->getDataJabatan()->result_array(),
            'desa'          => $this->Badan_saksi_model->getDataBSDesa($id_temp)->result_array(),
            'kecamatan'     => $this->Badan_saksi_model->getDataBSKec($id_temp)->result_array(),
            'kabupaten'     => $this->Badan_saksi_model->getDataBSKab($id_temp)->result_array(),
            'data'          => $this->Badan_saksi_model->getData($id_data,$id_func)->result_array()
        ];
        if($id_func == "1")
        {
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar',$data);
            $this->load->view('badan_saksi/edit_pengurus_kec',$data);
            $this->load->view('templates/footer');
        }
        elseif($id_func == "2")
        {
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar',$data);
            $this->load->view('badan_saksi/edit_pengurus_desa',$data);
            $this->load->view('templates/footer');
        }
        elseif($id_func == "3")
        {
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar',$data);
            $this->load->view('badan_saksi/edit_pengurus_kab',$data);
            $this->load->view('templates/footer');
        }
        elseif($id_func == "4")
        {
            $user = $this->session->userdata('userdata');

            if($user['level'] == 'Admin' && $user['id_kab'])
            {
                $this->session->sess_destroy();
                redirect('admin/auth');
            }

            $this->load->view('templates/header');
            $this->load->view('templates/sidebar',$data);
            $this->load->view('badan_saksi/edit_pengurus_prov',$data);
            $this->load->view('templates/footer');
        }
    }

    public function editPengurus_proses($id_data,$id_func)
    {
        $id_temp = $this->input->post('temp');

        $this->Badan_saksi_model->edit($id_data,$id_func);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Sukses!</strong> Data Berhasil DiEdit.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>');

        if($id_func == "1")
        {
            redirect('badan_saksi/detailSaksiKec/'.$id_temp);
        }
        elseif($id_func == "2")
        {
            redirect('badan_saksi/detailSaksiDesa/'.$id_temp);
        }
        elseif($id_func == "3")
        {
            redirect('badan_saksi/detailSaksiKab/'.$id_temp);
        }
        elseif($id_func == "4")
        {
            redirect('badan_saksi/showProv/');
        }
    }

    public function tambahDataSk($id_func,$id_temp)
    {
        if($id_func == '1')
        {
            $data = [
                'title'         => 'Badan Saksi',
                'aktif'         => 'badan_saksi',
                'sub'           => 'bs_prov',
            ];

            $this->load->view('templates/header');
            $this->load->view('templates/sidebar',$data);
            $this->load->view('badan_saksi/tambah_sk_prov',$data);
            $this->load->view('templates/footer');
        }
        elseif($id_func == 2)
        {
            $data = [
                'title'         => 'Badan Saksi',
                'aktif'         => 'badan_saksi',
                'sub'           => 'bs_sub',
                'kabupaten'     => $this->Badan_saksi_model->getDataBSKab($id_temp)->result_array()
            ];

            $this->load->view('templates/header');
            $this->load->view('templates/sidebar',$data);
            $this->load->view('badan_saksi/tambah_sk_kab',$data);
            $this->load->view('templates/footer');
        }
        elseif($id_func == 3)
        {
            $data = [
                'title'         => 'Badan Saksi',
                'aktif'         => 'badan_saksi',
                'sub'           => 'bs_sub',
                'kecamatan'     => $this->Badan_saksi_model->getDataBSKec($id_temp)->result_array()
            ];

            $this->load->view('templates/header');
            $this->load->view('templates/sidebar',$data);
            $this->load->view('badan_saksi/tambah_sk_kec',$data);
            $this->load->view('templates/footer');
        }
        elseif($id_func == 4)
        {
            $data = [
                'title'         => 'Badan Saksi',
                'aktif'         => 'badan_saksi',
                'sub'           => 'bs_sub',
                'desa'          => $this->Badan_saksi_model->getDataBSDesa($id_temp)->result_array()
            ];

            $this->load->view('templates/header');
            $this->load->view('templates/sidebar',$data);
            $this->load->view('badan_saksi/tambah_sk_desa',$data);
            $this->load->view('templates/footer');
        }
    }

    public function prosesTambahSk($id_func)
    {
        $id_temp = $this->input->post('temp');

        //setting config untuk library upload
        $config['upload_path']      = './uploads';
        $config['allowed_types']    = 'gif|jpg|png|pdf|xlsx|xls';
        $config['encrypt_name']     = true;
        $config['max_size']         = 1000000000;
        $config['max_width']        = 1024000;
        $config['max_height']       = 768000;

        //pemanggilan librabry upload
        $this->load->library('upload', $config);

        //jika upload gagal
        if(!$this->upload->do_upload('file_pendukung'))
        {
            // $error = array('error' => $this->upload->display_errors());
            // var_dump($error);
            // die;
            $this->session->set_flashdata('pesan_data', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                           <strong>Error!</strong> Data Gagal Ditambah.
                                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                           <span aria-hidden="true">&times;</span>
                                           </button>
                                       </div>');

            if($id_func == "1")
            {
                redirect('badan_saksi/showProv/');
            }
            elseif($id_func == "2")
            {
                redirect('badan_saksi/detailSaksiKab/'.$id_temp);
            }
            elseif($id_func == "3")
            {
                redirect('badan_saksi/detailSaksiKec/'.$id_temp);
            }
            elseif($id_func == "4")
            {
                redirect('badan_saksi/detailSaksiDesa/'.$id_temp);
            }
        }
        else
        {
            $this->upload->do_upload('file_pendukung');
            $f_pendukung = $this->upload->data();
            $f_pendukung = $f_pendukung['file_name'];

            $this->Badan_saksi_model->tambahDataSk($f_pendukung,$id_func);
            $this->session->set_flashdata('pesan_data', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                           <strong>Sukses!</strong> Data Berhasil Ditambah.
                                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                           <span aria-hidden="true">&times;</span>
                                           </button>
                                       </div>');

            if($id_func == "1")
            {
                redirect('badan_saksi/showProv/');
            }
            elseif($id_func == "2")
            {
                redirect('badan_saksi/detailSaksiKab/'.$id_temp);
            }
            elseif($id_func == "3")
            {
                redirect('badan_saksi/detailSaksiKec/'.$id_temp);
            }
            elseif($id_func == "4")
            {
                redirect('badan_saksi/detailSaksiDesa/'.$id_temp);
            }
        }
    }

    public function showEditSk($id_data,$id_func)
    {
        if($id_func == 1)
        {
            $data = [
                'title'         => 'Badan Saksi',
                'aktif'         => 'badan_saksi',
                'sub'           => 'bs_prov',
                'data'          => $this->Badan_saksi_model->getDataBsSkById($id_data,$id_func)->result_array()
            ];

            $this->load->view('templates/header');
            $this->load->view('templates/sidebar',$data);
            $this->load->view('badan_saksi/edit_sk_prov',$data);
            $this->load->view('templates/footer');
        }
        elseif($id_func == 2)
        {
            $data = [
                'title'         => 'Badan Saksi',
                'aktif'         => 'badan_saksi',
                'sub'           => 'bs_sub',
                'data'          => $this->Badan_saksi_model->getDataBsSkById($id_data,$id_func)->result_array()
            ];

            $this->load->view('templates/header');
            $this->load->view('templates/sidebar',$data);
            $this->load->view('badan_saksi/edit_sk_kab',$data);
            $this->load->view('templates/footer');
        }
        elseif($id_func == 3)
        {
            $data = [
                'title'         => 'Badan Saksi',
                'aktif'         => 'badan_saksi',
                'sub'           => 'bs_sub',
                'data'          => $this->Badan_saksi_model->getDataBsSkById($id_data,$id_func)->result_array()
            ];

            $this->load->view('templates/header');
            $this->load->view('templates/sidebar',$data);
            $this->load->view('badan_saksi/edit_sk_kec',$data);
            $this->load->view('templates/footer');
        }
        elseif($id_func == 4)
        {
            $data = [
                'title'         => 'Badan Saksi',
                'aktif'         => 'badan_saksi',
                'sub'           => 'bs_sub',
                'data'          => $this->Badan_saksi_model->getDataBsSkById($id_data,$id_func)->result_array()
            ];

            $this->load->view('templates/header');
            $this->load->view('templates/sidebar',$data);
            $this->load->view('badan_saksi/edit_sk_desa',$data);
            $this->load->view('templates/footer');
        }
    }

    public function prosesEditSk($id_func)
    {
        $id_data = $this->input->post('id_data');
        $id_temp = $this->input->post('temp');

        if($_FILES["file_pendukung"]["name"] == "")
        {
            $file_lama = $this->input->post('file_lama');

            $this->Badan_saksi_model->editBsSk($id_data,$id_func,$file_lama);

            $this->session->set_flashdata('pesan_data', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil DiEdit.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            
            if($id_func == "1")
            {
                redirect('badan_saksi/showProv/');
            }
            elseif($id_func == "2")
            {
                redirect('badan_saksi/detailSaksiKab/'.$id_temp);
            }
            elseif($id_func == "3")
            {
                redirect('badan_saksi/detailSaksiKec/'.$id_temp);
            }
            elseif($id_func == "4")
            {
                redirect('badan_saksi/detailSaksiDesa/'.$id_temp);
            }
        }
        else
        {
            //setting config untuk library upload
            $config['upload_path']      = './uploads';
            $config['allowed_types']    = 'gif|jpg|png|pdf|xlsx|xls';
            $config['encrypt_name']     = true;
            $config['max_size']         = 1000000000;
            $config['max_width']        = 1024000;
            $config['max_height']       = 768000;

            //pemanggilan librabry upload
            $this->load->library('upload', $config);

            //jika upload gagal
            if(!$this->upload->do_upload('file_pendukung'))
            {
                $this->session->set_flashdata('pesan_data', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                           <strong>Error!</strong> Data Gagal DiEdit.
                                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                           <span aria-hidden="true">&times;</span>
                                           </button>
                                       </div>');

                if($id_func == "1")
                {
                    redirect('badan_saksi/showProv/');
                }
                elseif($id_func == "2")
                {
                    redirect('badan_saksi/detailSaksiKab/'.$id_temp);
                }
                elseif($id_func == "3")
                {
                    redirect('badan_saksi/detailSaksiKec/'.$id_temp);
                }
                elseif($id_func == "4")
                {
                    redirect('badan_saksi/detailSaksiDesa/'.$id_temp);
                }
            }
            else
            {
                $file_lama = $this->input->post('file_lama');
                $q = $this->db->query("SELECT * FROM tb_badan_saksi_sk WHERE scan_sk = '$file_lama' ")->row()->scan_sk;
                $f = './uploads/'.$q;
                unlink($f);

                $this->upload->do_upload('file_pendukung');
                $f_pendukung = $this->upload->data();
                $f_pendukung = $f_pendukung['file_name'];

                $this->Badan_saksi_model->editBsSk($id_data,$id_func,$f_pendukung);

                $this->session->set_flashdata('pesan_data', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil DiEdit.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                
                if($id_func == "1")
                {
                    redirect('badan_saksi/showProv/');
                }
                elseif($id_func == "2")
                {
                    redirect('badan_saksi/detailSaksiKab/'.$id_temp);
                }
                elseif($id_func == "3")
                {
                    redirect('badan_saksi/detailSaksiKec/'.$id_temp);
                }
                elseif($id_func == "4")
                {
                    redirect('badan_saksi/detailSaksiDesa/'.$id_temp);
                }
            }
        }
    }
}