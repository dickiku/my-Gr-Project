<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ranting extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        
        $user = $this->session->userdata('userdata');
        if($user['level'] != 'Admin' && $user['level'] != 'Super Admin')
        {
            redirect('admin/auth');
        }
    }

    public function indexAdmKabRanting()
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $data = [
            'title'  => 'Ranting',
            'aktif'  => 'ranting',
            'data'   => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('ranting/index',$data);
		$this->load->view('templates/footer');
    }
    
    //==========================ADMIN SEMUA========================//
    public function index()
    {
        $data = [
            'title'     => 'Ranting',
            'aktif'     => 'ranting',
            'data'      => $this->Wilayah_kab_model->getDataWilayah()->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('ranting/index',$data);
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
            'title'     => 'Ranting',
            'aktif'     => 'ranting',
            'data'      => $this->Ranting_model->getDataWilayahById($id_kab)->result()
        ];

        $id_kabupaten = $this->uri->segment(3);
        $this->session->set_userdata('id_kabupaten',  $id_kabupaten);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('ranting/data',$data);
		$this->load->view('templates/footer');
    }

    public function desa($id_kec)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_kec,0,-3);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }
        
        $data = [
            'title'     => 'Ranting',
            'aktif'     => 'ranting',
            'data'      => $this->Ranting_model->getDataWilayahDesa($id_kec)->result_array()
        ];

        $id_kecamatan = $this->uri->segment(3);
        $this->session->set_userdata('id_kecamatan',  $id_kecamatan);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('ranting/desa',$data);
		$this->load->view('templates/footer');
    }

    public function detailDesa($id_desa)
    {
        $data = [
            'title'     => 'Ranting',
            'aktif'     => 'ranting',
            'data'      => $this->Ranting_model->getDetailDesa($id_desa)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('ranting/detailDesa',$data);
		$this->load->view('templates/footer');
    }

    public function tambah()
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $id_kabupaten   = $this->session->userdata('id_kabupaten');
        $id_kecamatan   = $this->session->userdata('id_kecamatan');
        $id_desa   = $this->session->userdata('id_desa');
        
        $data = [
            'title'         => 'Ranting',
            'aktif'         => 'ranting',
            // 'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayah()->result(),
            'wilayahKab'   => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kabupaten)->result(),
            'wilayahKec'   => $this->Wilayah_kab_model->getDataWilayahKecByIdKec($id_kecamatan)->result(),
            'wilayahDesa'   => $this->Wilayah_kab_model->getDataWilayahDesaByIdDesa($id_desa)->result(),
        ];
        
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar',$data);
        $this->load->view('ranting/tambah',$data);
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
            if(!$this->upload->do_upload('scan_sk'))
            {

                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                               <strong>Error!</strong> Data Gagal Ditambah.
                                               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                               <span aria-hidden="true">&times;</span>
                                               </button>
                                           </div>');
                redirect('ranting/tambah');
            }
            else
            {
                $scan_sk = $this->upload->data();
                $scan = $scan_sk['file_name'];

                $this->Ranting_model->tambahData($scan);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                               <strong>Sukses!</strong> Data Berhasil Ditambah.
                                               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                               <span aria-hidden="true">&times;</span>
                                               </button>
                                           </div>');
                if($user['id_kab']){
                    redirect('ranting/indexAdmKabRanting');
                }
                else
                {
                    redirect('ranting');
                }
            }
        }
    }

    public function detailRanting($id_ranting)
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $data = [
            'title'             => 'Ranting',
            'aktif'             => 'ranting',
            'data'              => $this->Ranting_model->getDataByIdRanting($id_ranting)->result_array(),
            'keanggotaan'       => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktif()->result_array(),
            'keanggotaanKab'    => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktifIdKab($id_kab)->result_array(),
            'jabatan'           => $this->Keanggotaan_model->getDataJabatan()->result_array(),
            'kepengurusan'      => $this->Ranting_model->getDataKepengurusanRantingbyId($id_ranting)->result_array()
        ];

        $id = $this->uri->segment(3);
        $this->session->set_userdata('id', $id);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('ranting/detailRanting',$data);
		$this->load->view('templates/footer');
    }

    public function detailRantingDesa($idd_desa)
    {
        $subs = substr($idd_desa,0,-8);

        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $id_kabupaten   = $this->session->userdata('id_kabupaten');
        $id_kecamatan   = $this->session->userdata('id_kecamatan');

        $data = [
            'title'             => 'Ranting',
            'aktif'             => 'ranting',
            'kabupaten'         => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kabupaten)->result_array(),
            'kecamatan'         => $this->Ranting_model->getDataWilayahKecByIdKec($id_kecamatan)->result_array(),
            'desa'              => $this->Ranting_model->getDataWilayahDesaByIdDesa($idd_desa)->result_array(),
            'data'              => $this->Ranting_model->getDataRantingByIdDesa($idd_desa)->result_array(),
            'keanggotaan'       => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktif()->result_array(),
            'keanggotaanKab'    => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktifIdKab($id_kab)->result_array(),
            'jabatan'           => $this->Keanggotaan_model->getDataJabatan()->result_array(),
            'kepengurusan'      => $this->Ranting_model->getDataKepengurusanRantingbyIdDesa($idd_desa)->result_array()
        ];

        $id_desa = $this->uri->segment(3);
        $this->session->set_userdata('id_desa',  $id_desa);

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('ranting/detailRanting',$data);
		$this->load->view('templates/footer');
    }

    public function edit($id_ranting)
    {
        $data = [
            'title'     => 'Ranting',
            'aktif'     => 'ranting',
            'data'      => $this->Ranting_model->getDataByIdRanting($id_ranting)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('ranting/edit',$data);
		$this->load->view('templates/footer');
    }

    public function edit_proses($id_ranting)
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->edit($id_ranting);
        }
        else
        {
            if($_FILES["scan_sk"]["name"] == "")
            {
                $scan_lama = $this->input->post('scan_sk_lama');

                $this->Ranting_model->edit($id_ranting, $scan_lama);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');

                redirect('ranting/detailRantingDesa/'.$this->session->userdata('id_desa'));
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
                if(!$this->upload->do_upload('scan_sk'))
                {
                    $data = [
                        'title'     => 'Ranting',
                        'aktif'     => 'ranting',
                        'data'      => $this->Ranting_model->getDataByIdRanting($id_ranting)->result_array()
                    ];
            
                    $this->load->view('templates/header');
                    $this->load->view('templates/sidebar',$data);
                    $this->load->view('ranting/edit',$data);
                    $this->load->view('templates/footer');
                }
                else
                {
                    $scan_lama = $this->input->post('scan_sk_lama');

                    $qs = $this->db->query("SELECT * FROM tb_ranting WHERE scan_sk = '$scan_lama' ")->row()->scan_sk;

                    $s = './uploads/'.$qs;
                    unlink($s);

                    $scan_sk = $this->upload->data();
                    $scan = $scan_sk['file_name'];
                    
                    $this->Ranting_model->edit($id_ranting, $scan);
                    $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Diupdate.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');

                    redirect('ranting/detailRantingDesa/'.$this->session->userdata('id_desa'));
                }
            }
        }
    }

    public function hapus($id_ranting)
    {
        $user = $this->session->userdata('userdata');
        
        $qs = $this->db->query("SELECT * FROM tb_ranting WHERE id_ranting = '$id_ranting'")->row()->scan_sk;
        $fileScan = './uploads/'.$qs;
        unlink($fileScan);

        $this->db->where('id_ranting', $id_ranting);
        $this->db->delete('tb_ranting');

        $this->db->where('id_ranting', $id_ranting);
        $this->db->delete('tb_pengurus_ranting');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        if($user['id_kab']){
            redirect('ranting/indexAdmKabRanting');
        }
        else
        {
            redirect('ranting');
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
            redirect('ranting/detailRantingDesa/'.$this->session->userdata('id_desa'));
        }
        else
        {
            $this->Ranting_model->tambahDataKepengurusan();
            // $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            //                                     <strong>Sukses!</strong> Data Berhasil Ditambahkan.
            //                                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            //                                     <span aria-hidden="true">&times;</span>
            //                                     </button>
            //                                 </div>');
            redirect('ranting/detailRantingDesa/'.$this->session->userdata('id_desa'));
        }
    }

    public function editKepengurusan($id_pengurus_ranting)
    {
        $data = [
            'title'         => 'Ranting',
            'aktif'         => 'ranting',
            'data'          => $this->Ranting_model->getDataPengurusRantingById($id_pengurus_ranting)->result_array(),
            'jabatan'       => $this->Keanggotaan_model->getDataJabatan()->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('ranting/editKepengurusan',$data);
		$this->load->view('templates/footer');
    }

    public function editKepengurusan_proses($id_pengurus_ranting)
    {
        $this->_rulesEditKepengurusan();

        if($this->form_validation->run() == FALSE)
        {
            $this->editKepengurusan($id_pengurus_ranting);

            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Error!</strong> Data Gagal Diubah.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        }
        else
        {
            $this->Ranting_model->editKepengurusan($id_pengurus_ranting);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diupdate.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('ranting/detailRantingDesa/'.$this->session->userdata('id_desa'));
        }
    }

    public function hapusKepengurusan($id_pengurus_ranting)
    {
        $this->db->where('id_pengurus_ranting', $id_pengurus_ranting);
        $this->db->delete('tb_pengurus_ranting');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        redirect('ranting/detailRantingDesa/'.$this->session->userdata('id_desa'));
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

    // public function kecamatan($id_kec)
    // {
    //     $data = [
    //         'title'     => 'Ranting',
    //         'aktif'     => 'ranting',
    //         'data'      => $this->Ranting_model->getDataKecamatanById($id_kec)->result_array()
    //     ];

    //     $this->load->view('templates/header');
	// 	$this->load->view('templates/sidebar',$data);
	// 	$this->load->view('ranting/kecamatan',$data);
	// 	$this->load->view('templates/footer');
    // }

    
}