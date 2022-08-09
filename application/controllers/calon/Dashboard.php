<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        
        $userCalon = $this->session->userdata('userdataCalon');

        if(!$userCalon['no_ktp'])
        {
            redirect('calon/daftar/logincalon');
        }
    }

    public function index($id_keanggotaan)
    {
        $userCalon = $this->session->userdata('userdataCalon');

        if($userCalon['id_keanggotaan'] !== $id_keanggotaan)
        {
            $this->session->sess_destroy();
            redirect('calon/daftar/logincalon');
        }

        $data = [
            'title' => 'Calon Anggota',
            'aktif' => 'dashboard_calon',
            'keanggotaan'  => $this->Calon_model->getDataCalonAnggotaById($id_keanggotaan)->row_array(),
            'anggota'       => $this->Calon_model->getDataCalonAnggotaKu($id_keanggotaan)->row_array(),
        ];
        $this->load->view('templates_calon/header');
		$this->load->view('templates_calon/sidebar',$data);
		$this->load->view('calon/dashboard',$data);
		$this->load->view('templates_calon/footer');
    }

    public function editCalon($id_keanggotaan)
    {
        $userCalon = $this->session->userdata('userdataCalon');

        if($userCalon['id_keanggotaan'] !== $id_keanggotaan)
        {
            $this->session->sess_destroy();
            redirect('calon/daftar/logincalon');
        }
        
        $data = [
            'title'         => 'Calon Anggota',
            'aktif'         => 'dashboard_calon',
            'keanggotaan'   => $this->Calon_model->getDataCalonAnggotaById($id_keanggotaan)->row_array(),
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayah()->result_array(),
            'wilayahKec'    => $this->Keanggotaan_model->getDataWilayahKec()->result_array(),
            'wilayahDesa'   => $this->Keanggotaan_model->getDataWilayahDesa()->result_array(),
        ];

        $this->load->view('templates_calon/header');
		$this->load->view('templates_calon/sidebar',$data);
		$this->load->view('calon/edit',$data);
		$this->load->view('templates_calon/footer');
    }

    public function edit_proses($id_keanggotaan)
    {
        $this->__rulesEdit();

        if($this->form_validation->run() == FALSE)
        {
            $this->editCalon($id_keanggotaan);
            // $data = [
            //     'title' => 'Calon Anggota',
            //     'aktif' => 'dashboard_calon',
            //     'keanggotaan'   => $this->Keanggotaan_model->getDataIdKeanggotaan($id_keanggotaan)->row_array()
            // ];
    
            // $this->load->view('templates_calon/header');
            // $this->load->view('templates_calon/sidebar',$data);
            // $this->load->view('calon/edit',$data);
            // $this->load->view('templates_calon/footer');

            // $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            //                                     <strong>Error!</strong> Data Gagal Diubah.
            //                                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            //                                     <span aria-hidden="true">&times;</span>
            //                                     </button>
            //                                 </div>');
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
                redirect('calon/dashboard/index/'.$id_keanggotaan);
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
                redirect('calon/dashboard/index/'.$id_keanggotaan);
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
                redirect('calon/dashboard/index/'.$id_keanggotaan);
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
                        'title' => 'Calon Anggota',
                        'aktif' => 'dashboard_calon',
                        'keanggotaan'   => $this->Keanggotaan_model->getDataIdKeanggotaan($id_keanggotaan)->row_array()
                    ];
            
                    $this->load->view('templates_calon/header');
                    $this->load->view('templates_calon/sidebar',$data);
                    $this->load->view('calon/edit',$data);
                    $this->load->view('templates_calon/footer');
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
                    redirect('calon/dashboard/index/'.$id_keanggotaan);
                }
            }
        }
    }

    public function getWilayahKecamatan($id_kab)
    {
        $query = $this->db->get_where('wilayah_kec',array('id_kab'=>$id_kab));
        $data = "<option value=''>--Pilih Kecamatan--</option>";
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

        $this->form_validation->set_rules('no_kta', 'No KTA', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong>No KTA wajib diisi',
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

