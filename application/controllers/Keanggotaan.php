<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keanggotaan extends CI_Controller{

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
            'title'             => 'Keanggotaan',
            'aktif'             => 'keanggotaan',
            'wilayahKab'        => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('keanggotaan/indexAdmKab',$data);
		$this->load->view('templates/footer');
    }

    //===================SEMUA ADMIN===================//
    
    // public function index()
    // {
    //     $data = [
    //         'title'             => 'Keanggotaan',
    //         'aktif'             => 'keanggotaan',
    //         'wilayahKab'        => $this->Wilayah_kab_model->getDataWilayah()->result()
    //     ];

    //     $this->load->view('templates/header');
	// 	$this->load->view('templates/sidebar',$data);
	// 	$this->load->view('keanggotaan/index',$data);
	// 	$this->load->view('templates/footer');
    // }

    public function index()
    {
        $user = $this->session->userdata('userdata');
        
        if($user['level'] == 'Admin' && $user['id_kab']){
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'       => 'Keanggotaan',
            'aktif'       => 'keanggotaan',
            'keanggotaan' => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktif()->result(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('keanggotaan/index',$data);
		$this->load->view('templates/footer');
    }

    public function keanggotaan($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'             => 'Keanggotaan',
            'aktif'             => 'keanggotaan',
            // 'keanggotaan'       => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktif()->result(),
            'keanggotaan'       => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktifIdKab($id_kab)->result(),
            'keanggotaanByKab'  => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktifIdKab($id_kab)->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('keanggotaan/keanggotaan',$data);
		$this->load->view('templates/footer');
    }

    public function calon_anggota()
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'             => 'Calon Keanggotaan',
            'aktif'             => 'calon',
            'keanggotaan'       => $this->Keanggotaan_model->getDataKeanggotaanByStatusNon()->result(),
            'keanggotaanByKab'  => $this->Keanggotaan_model->getDataKeanggotaanByStatusNonIdKab($id_kab)->result(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('keanggotaan/calon_anggota',$data);
		$this->load->view('templates/footer');
    }

    public function aktivasi($id_keanggotaan)
    {
        $data = [
            'status'    => 1
        ];

        $this->db->where('id_keanggotaan', $id_keanggotaan);
        $this->db->update('tb_keanggotaan', $data);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Anggota Berhasil Diverifikasi.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        redirect('keanggotaan/calon_anggota');
    }

    public function detail($id_keanggotaan)
    {
        $data = [
            'title'         => 'Keanggotaan',
            'aktif'         => 'keanggotaan',
            'keanggotaan'   => $this->Keanggotaan_model->getDataIdKeanggotaan(base64_decode($id_keanggotaan))->row_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('keanggotaan/detail',$data);
		$this->load->view('templates/footer');
    }

    public function detailCalonAnggota($id_keanggotaan)
    {
        $data = [
            'title'         => 'Calon Keanggotaan',
            'aktif'         => 'calon',
            'keanggotaan'   => $this->Keanggotaan_model->getDataIdKeanggotaan($id_keanggotaan)->row_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('keanggotaan/detailCalonAnggota',$data);
		$this->load->view('templates/footer');
    }

    public function edit($id_keanggotaan)
    {
        $data = [
            'title'         => 'Keanggotaan',
            'aktif'         => 'keanggotaan',
            'keanggotaan'   => $this->Keanggotaan_model->getDataIdKeanggotaan($id_keanggotaan)->row_array(),
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayah()->result_array(),
            'wilayahKec'    => $this->Keanggotaan_model->getDataWilayahKec()->result_array(),
            'wilayahDesa'   => $this->Keanggotaan_model->getDataWilayahDesa()->result_array(),
        ];
        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('keanggotaan/edit',$data);
		$this->load->view('templates/footer');
		$this->load->view('keanggotaan/script');
    }

    public function edit_proses($id_keanggotaan)
    {
        $this->__rulesEdit();

        if($this->form_validation->run() == FALSE)
        {
            $this->edit($id_keanggotaan);
        }
        else
        {
            if($_FILES["foto_profil"]["name"] == "" && $_FILES["foto_ktp"]["name"] == "") 
            {
                $foto_lama = $this->input->post('foto_profil_lama');
                $foto_ktp_lama = $this->input->post('foto_ktp_lama');

                $this->Keanggotaan_model->edit($id_keanggotaan, $foto_lama, $foto_ktp_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('keanggotaan');
            }
            else if($_FILES["foto_profil"]["name"] && $_FILES["foto_ktp"]["name"] == "")
            {
                $foto_ktp_lama = $this->input->post('foto_ktp_lama');

                //setting config untuk library upload
                $config['upload_path']      = './uploads';
                $config['allowed_types']    = 'gif|jpg|png|pdf';
                $config['encrypt_name']     = true;
                $config['max_size']         = 1000000000;
                $config['max_width']        = 1024000;
                $config['max_height']       = 768000;

                //pemanggilan librabry upload
                $this->load->library('upload', $config);

                $foto_lama = $this->input->post('foto_profil_lama');
                $qk = $this->db->query("SELECT * FROM tb_keanggotaan WHERE foto_profil = '$foto_lama' ")->row()->foto_profil;

                $f = './uploads/'.$qk;
                unlink($f);

                $this->upload->do_upload('foto_profil');
                $foto_profil = $this->upload->data();
                $foto = $foto_profil['file_name'];

                $this->Keanggotaan_model->edit($id_keanggotaan, $foto, $foto_ktp_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('keanggotaan');
            }
            else if($_FILES["foto_profil"]["name"] == "" && $_FILES["foto_ktp"]["name"])
            {
                $foto_lama = $this->input->post('foto_profil_lama');

                //setting config untuk library upload
                $config['upload_path']      = './uploads';
                $config['allowed_types']    = 'gif|jpg|png|pdf';
                $config['encrypt_name']     = true;
                $config['max_size']         = 1000000000;
                $config['max_width']        = 1024000;
                $config['max_height']       = 768000;

                //pemanggilan librabry upload
                $this->load->library('upload', $config);

                $foto_ktp_lama = $this->input->post('foto_ktp_lama');

                $qs = $this->db->query("SELECT * FROM tb_keanggotaan WHERE foto_ktp = '$foto_ktp_lama' ")->row()->foto_ktp;

                $s = './uploads/'.$qs;
                unlink($s);

                $this->upload->do_upload('foto_ktp');
                $foto_ktp = $this->upload->data();
                $ktp = $foto_ktp['file_name'];

                $this->Keanggotaan_model->edit($id_keanggotaan, $foto_lama, $ktp);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('keanggotaan');
            }
            else
            {
                //setting config untuk library upload
                $config['upload_path']      = './uploads';
                $config['allowed_types']    = 'gif|jpg|png';
                $config['encrypt_name']     = true;
                $config['max_size']         = 1000000000;
                $config['max_width']        = 1024000;
                $config['max_height']       = 768000;

                //pemanggilan librabry upload
                $this->load->library('upload', $config);

                //jika upload gagal
                if(!$this->upload->do_upload('foto_profil') && !$this->upload->do_upload('foto_ktp'))
                {
                    $data = [
                        'title'         => 'Keanggotaan',
                        'aktif'         => 'keanggotaan',
                        'keanggotaan'   => $this->Keanggotaan_model->getDataIdKeanggotaan($id_keanggotaan)->row_array()
                    ];
            
                    $this->load->view('templates/header');
                    $this->load->view('templates/sidebar',$data);
                    $this->load->view('keanggotaan/edit',$data);
                    $this->load->view('templates/footer');
                }
                else
                {
                    $foto_lama = $this->input->post('foto_profil_lama');
                    $foto_ktp_lama = $this->input->post('foto_ktp_lama');

                    $q = $this->db->query("SELECT * FROM tb_keanggotaan WHERE foto_profil = '$foto_lama' ")->row()->foto_profil;
                    $qk = $this->db->query("SELECT * FROM tb_keanggotaan WHERE foto_ktp = '$foto_ktp_lama' ")->row()->foto_ktp;

                    $f = './uploads/'.$q;
                    unlink($f);

                    $fk = './uploads/'.$qk;
                    unlink($fk);

                    $this->upload->do_upload('foto_profil');
                    $foto_profil = $this->upload->data();
                    $foto = $foto_profil['file_name'];

                    $this->upload->do_upload('foto_ktp');
                    $foto_ktp = $this->upload->data();
                    $ktp = $foto_ktp['file_name'];

                    $this->Keanggotaan_model->edit($id_keanggotaan, $foto, $ktp);
                    $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                    redirect('keanggotaan');
                }
            }
        }
    }


    public function tambah()
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $data = [
            'title'         => 'Keanggotaan',
            'aktif'         => 'keanggotaan',
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayah()->result(),
            'wilayahById'   => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result()
        ];
    
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('keanggotaan/tambah',$data);
        $this->load->view('templates/footer');
    }

    public function tambah_proses()
    {
        $this->__rulesEdit();

        if($this->form_validation->run() == FALSE)
        {
            $this->tambah();
        }
        else
        {
             //setting config untuk library upload
             $config['upload_path']      = './uploads';
             $config['allowed_types']    = 'gif|jpg|png';
             $config['encrypt_name']     = true;
             $config['max_size']         = 1000000000;
             $config['max_width']        = 1024000;
             $config['max_height']       = 768000;

             //pemanggilan librabry upload
             $this->load->library('upload', $config);

             //jika upload gagal
             if(!$this->upload->do_upload('foto_profil') || !$this->upload->do_upload('foto_ktp'))
             {

                 $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> Data Gagal Ditambah.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                 redirect('keanggotaan/tambah');
             }
             else
             {
                $this->upload->do_upload('foto_profil');
                $foto_profil = $this->upload->data();
                $foto = $foto_profil['file_name'];

                $this->upload->do_upload('foto_ktp');
                $foto_ktp = $this->upload->data();
                $ktp = $foto_ktp['file_name'];

                 $this->Keanggotaan_model->tambahData($foto, $ktp);
                 $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambah.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                $user = $this->session->userdata('userdata');
                if($user['level'] == 'Admin' ){
                    $st = $user['id_kab'];
                        redirect('keanggotaan/indexAdmKab');
                    }
                elseif ($user['level'] == 'Super Admin') {
                   redirect('keanggotaan');
                }
             }
        }
    }

    public function prints($id_keanggotaan)
    {
        $data = [
            'title'         => 'Keanggotaan',
            'aktif'         => 'keanggotaan',
            'keanggotaan'   => $this->Keanggotaan_model->getDataIdKeanggotaan($id_keanggotaan)->row_array()
        ];
    
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('keanggotaan/kta',$data);
        $this->load->view('templates/footer');
    }

    public function hapus($id_keanggotaan)
    {
        // $user = $this->session->userdata('userdata');
        
        // if($user['level'] == 'Admin' && $user['id_kab']){
        //     $this->session->sess_destroy();
        //     redirect('admin/auth');
        // }

        $q = $this->db->query("SELECT * FROM tb_keanggotaan WHERE id_keanggotaan = '$id_keanggotaan'")->row()->foto_profil;
        $file = './uploads/'.$q;
        unlink($file);

        $this->db->where('id_keanggotaan', $id_keanggotaan);
        $this->db->delete('tb_keanggotaan');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                $user = $this->session->userdata('userdata');
                if($user['level'] == 'Admin' ){
                    $st = $user['id_kab'];
                        redirect('keanggotaan/keanggotaan/'.$st);
                    }
                elseif ($user['level'] == 'Super Admin') {
                   redirect('keanggotaan');
                }
    }

    public function hapusCalonAnggota($id_keanggotaan)
    {
        $user = $this->session->userdata('userdata');
        
        if($user['level'] == 'Admin' && $user['id_kab']){
            $this->session->sess_destroy();
            redirect('admin/auth');
        }
           
        $q = $this->db->query("SELECT * FROM tb_keanggotaan WHERE id_keanggotaan = '$id_keanggotaan'")->row()->foto_profil;
        $file = './uploads/'.$q;
        unlink($file);

        $this->db->where('id_keanggotaan', $id_keanggotaan);
        $this->db->delete('tb_keanggotaan');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        redirect('keanggotaan/calon_anggota');
    }

    public function getWilayahKecamatan($id_kab)
    {
        $query = $this->db->get_where('wilayah_kec',array('id_kab'=>$id_kab));
        $data = "<option value=''>-Pilih Kecamatan-</option>";
        foreach ($query->result() as $value) {
            $data .= "<option value='".$value->id_kec."'>".$value->nm_kec."</option>";
        }
        echo $data;
    }

    public function getWilayahDesa($id_kec)
    {
        $query = $this->db->get_where('wilayah_desa',array('id_kec'=>$id_kec));
        $data = "<option value=''>--Pilih Kelurahan/Desa--</option>";
        foreach ($query->result() as $value) {
            $data .= "<option value='".$value->id_desa."'>".$value->nm_desa."</option>";
        }
        echo $data;
    }

    public function getWilayahKecamatanEdit($id_kab)
    {
        $query      = $this->db->get_where('tb_keanggotaan',array('id_kab'=>$id_kab));
        $wilayahKec = $this->db->get_where('wilayah_kec',array('id_kab'=>$id_kab));

        $data = "<option value=''>--Pilih Kecamatan--</option>";
        foreach ($query->result_array() as $row) {
            foreach($wilayahKec->result_array() as $wkc) {
                if($wkc['id_kec'] == $row['id_kec']) {
                    $data .= "<option value='".$row['id_kec']."' selected>".$row['nm_kec']."</option>";
                }
                else
                {
                    $data .= "<option value='".$wkc['id_kec']."'>".$wkc['nm_kec']."</option>";
                }
            }
        }
        echo $data;
    }

    public function getWilayahDesaEdit($id_kec)
    {
        $query          = $this->db->get_where('tb_keanggotaan',array('id_kec'=>$id_kec));
        $wilayahDesa    = $this->db->get_where('wilayah_desa',array('id_kec'=>$id_kec));

        $data = "<option value=''>--Pilih Desa/Kelurahan--</option>";
        foreach ($query->result_array() as $row) {
            foreach($wilayahDesa->result_array() as $wkd) {
                if($wkd['id_desa'] == $row['id_desa']) {
                    $data .= "<option value='".$row['id_desa']."' selected>".$row['nm_desa']."</option>";
                }
                else
                {
                    $data .= "<option value='".$wkd['id_desa']."'>".$wkd['nm_desa']."</option>";
                }
            }
        }
        echo $data;
    }

    public function _rules()
    {
        $this->form_validation->set_rules('dpc_kab_kota', 'Wilayah Kabupaten', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Wilayah Kabupaten wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('wilayah_kec', 'Wilayah Kecamatan', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Wilayah Kecamatan wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('wilayah_desa', 'Wilayah Desa', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Wilayah Desa wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Nama wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Tempat Lahir wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Tanggal Lahir wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('no_ktp', 'No KTP', 'required|trim|is_unique[tb_keanggotaan.no_ktp]',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong>No KTP wajib diisi',
            'is_unique' => 'No KTP sudah terdaftar'
        ]);

        $this->form_validation->set_rules('no_kta', 'No KTA', 'required|trim|is_unique[tb_keanggotaan.no_kta]',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong>No KTA wajib diisi',
            'is_unique' => 'No KTA sudah terdaftar'
        ]);

        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong>Alamat wajib diisi'
        ]);
        
        $this->form_validation->set_rules('no_hp', 'No HP', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong>Nama wajib diisi'
        ]);
        
        $this->form_validation->set_rules('agama', 'Agama', 'required|trim',[
            'required'      => '<div class="text-danger small"><strong>Error!</strong>Agama wajib diisi'
        ]);

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[tb_keanggotaan.email]',[
            'required'      => '<div class="text-danger small"><strong>Error!</strong>Email wajib diisi',
            'valid_email'   => '<div class="text-danger small"><strong>Error!</strong>Email yang dimasukkan harus valid'
        ]);

        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong>Jenis Kelamin wajib diisi'
        ]);

        $this->form_validation->set_rules('status_perkawinan', 'Status Perkawinan', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong>Status Perkawinan wajib diisi'
        ]);
    }

    public function __rulesEdit()
    {
        $this->form_validation->set_rules('dpc_kab_kota', 'Wilayah Kabupaten', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Wilayah Kabupaten wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('wilayah_kec', 'Wilayah Kecamatan', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Wilayah Kecamatan wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('wilayah_desa', 'Wilayah Desa', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Wilayah Desa wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Nama wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Tempat Lahir wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Tanggal Lahir wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('no_ktp', 'No KTP', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong>No KTP wajib diisi',
        ]);

        // $this->form_validation->set_rules('no_kta', 'No KTA', 'required|trim',[
        //     'required'  => '<div class="text-danger small"><strong>Error!</strong>No KTA wajib diisi',
        // ]);

        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong>Alamat wajib diisi'
        ]);
        
        $this->form_validation->set_rules('no_hp', 'No HP', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong>Nama wajib diisi'
        ]);
        
        $this->form_validation->set_rules('agama', 'Agama', 'required|trim',[
            'required'      => '<div class="text-danger small"><strong>Error!</strong>Agama wajib diisi'
        ]);

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email',[
            'required'      => '<div class="text-danger small"><strong>Error!</strong>Email wajib diisi',
            'valid_email'   => '<div class="text-danger small"><strong>Error!</strong>Email yang dimasukkan harus valid'
        ]);

        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong>Jenis Kelamin wajib diisi'
        ]);

        $this->form_validation->set_rules('status_perkawinan', 'Status Perkawinan', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong>Status Perkawinan wajib diisi'
        ]);
    }
}