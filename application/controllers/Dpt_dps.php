<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dpt_dps extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        
        $user = $this->session->userdata('userdata');
        if($user['level'] != 'Admin' && $user['level'] != 'Super Admin')
        {
            redirect('admin/auth');
        }
    }

    public function indexAdmKabDptDps()
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $data = [
            'title'     => 'DPT / DPS',
            'aktif'     => 'dpt_dps',
            'wilayahKab'   => $this->Wilayah_kab_model->getDataWilayahKabByIdKab($id_kab)->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dpt_dps/index',$data);
		$this->load->view('templates/footer');
    }
    
    //==========================ADMIN SEMUA========================//
    public function index()
    {
        $data = [
            'title'     => 'DPT / DPS',
            'aktif'     => 'dpt_dps',
            'wilayahKab'   => $this->Wilayah_kab_model->getDataWilayah()->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dpt_dps/index',$data);
		$this->load->view('templates/footer');
    }

    public function showKec($id_kab)
    {
        $user = $this->session->userdata('userdata');

        if($user['level'] == 'Admin' && $user['id_kab'] != $id_kab)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'DPT / DPS',
            'aktif'     => 'dpt_dps',
            'data'      => $this->Dpt_dps_model->getDataWilayahKec($id_kab)->result()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dpt_dps/kecamatan',$data);
		$this->load->view('templates/footer');
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
            'title'     => 'DPT / DPS',
            'aktif'     => 'dpt_dps',
            'data'      => $this->Dpt_dps_model->getDataWilayahDesa($id_kec)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dpt_dps/desa',$data);
		$this->load->view('templates/footer');
    }

    public function showTps($id_desa)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_desa,0,-8);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'DPT / DPS',
            'aktif'     => 'dpt_dps',
            'data'      => $this->Dpt_dps_model->getDataTps($id_desa)->result_array(),
            'desa'      => $this->Badan_saksi_model->getDataBSDesa($id_desa)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dpt_dps/tps',$data);
		$this->load->view('templates/footer');
    }

    public function tambahTPS()
    {
        $id_desa = $this->input->post('id_desa');

        $this->Dpt_dps_model->tambahTps();

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');

        redirect('dpt_dps/showTps/'.$id_desa);
    }

    public function showEditTps($id_tps,$id_desa)
    {
        $data = [
            'title'     => 'DPT / DPS',
            'aktif'     => 'dpt_dps',
            'data'      => $this->Dpt_dps_model->getDetailTps($id_tps)->result_array(),
            'desa'      => $this->Badan_saksi_model->getDataBSDesa($id_desa)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dpt_dps/edit_tps',$data);
		$this->load->view('templates/footer');
    }

    public function prosesEditTps()
    {
        $id_desa = $this->input->post('id_desa');
        $id_tps  = $this->input->post('id_tps');

        $this->Dpt_dps_model->editTps($id_tps);

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Data Berhasil DiEdit.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

        redirect('dpt_dps/showTps/'.$id_desa);
    }

    public function showList($id_desa,$id_tps)
    {
        $user = $this->session->userdata('userdata');

        $subs = substr($id_desa,0,-8);

        if($user['level'] == 'Admin' && $user['id_kab'] != $subs)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'         => 'DPT / DPS',
            'aktif'         => 'dpt_dps',
            'dpt'           => $this->Dpt_dps_model->getDataDpt($id_tps)->result(),
            'dps'           => $this->Dpt_dps_model->getDataDps($id_tps)->result(),
            'tps'           => $this->Dpt_dps_model->getDataTpsDetail($id_tps)->result_array(),
            'desa'          => $this->Badan_saksi_model->getDataBSDesa($id_desa)->result_array(),
            'keanggotaan'   => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktif()->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dpt_dps/list',$data);
		$this->load->view('templates/footer');
    }

    public function showTambahDPT($id_desa,$id_tps)
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];

        $data = [
            'title'             => 'DPT / DPS',
            'aktif'             => 'dpt_dps',
            'tps'               => $this->Dpt_dps_model->getDataTpsDetail($id_tps)->result_array(),
            'desa'              => $this->Badan_saksi_model->getDataBSDesa($id_desa)->result_array(),
            'keanggotaan'       => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktif()->result_array(),
            'keanggotaanKab'    => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktifIdKab($id_kab)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dpt_dps/tambah_dpt',$data);
		$this->load->view('templates/footer');
    }

    public function showTambahDPS($id_desa,$id_tps)
    {
        $user = $this->session->userdata('userdata');
        $id_kab = $user['id_kab'];
        
        $data = [
            'title'             => 'DPT / DPS',
            'aktif'             => 'dpt_dps',
            'tps'               => $this->Dpt_dps_model->getDataTpsDetail($id_tps)->result_array(),
            'desa'              => $this->Badan_saksi_model->getDataBSDesa($id_desa)->result_array(),
            'keanggotaan'       => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktif()->result_array(),
            'keanggotaanKab'    => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktifIdKab($id_kab)->result_array(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('dpt_dps/tambah_dps',$data);
		$this->load->view('templates/footer');
    }

    public function tambahDPT()
    {
        $id_desa = $this->input->post('id_desa');
        $id_tps = $this->input->post('id_tps');

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
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                           <strong>Error!</strong> Data Gagal Ditambah.
                                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                           <span aria-hidden="true">&times;</span>
                                           </button>
                                       </div>');
            redirect('dpt_dps/showList/'.$id_desa.'/'.$id_tps);
        }
        else
        {
            $this->upload->do_upload('file_pendukung');
            $f_pendukung = $this->upload->data();
            $f_pendukung = $f_pendukung['file_name'];

            $this->Dpt_dps_model->tambahDataDPT($f_pendukung);
            // $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            //                                <strong>Sukses!</strong> Data Berhasil Ditambah.
            //                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            //                                <span aria-hidden="true">&times;</span>
            //                                </button>
            //                            </div>');
            redirect('dpt_dps/showList/'.$id_desa.'/'.$id_tps);
        }
    }

    public function tambahDPS()
    {
        $id_desa = $this->input->post('id_desa');
        $id_tps = $this->input->post('id_tps');

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

            //  var_dump($error);

            // die;
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                           <strong>Error!</strong> Data Gagal Ditambah.
                                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                           <span aria-hidden="true">&times;</span>
                                           </button>
                                       </div>');
            redirect('dpt_dps/showTambahDPS/'.$id_desa.'/'.$id_tps);
        }
        else
        {
            $this->upload->do_upload('file_pendukung');
            $f_pendukung = $this->upload->data();
            $f_pendukung = $f_pendukung['file_name'];

            $this->Dpt_dps_model->tambahDataDPS($f_pendukung);
            // $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            //                                <strong>Sukses!</strong> Data Berhasil Ditambah.
            //                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            //                                <span aria-hidden="true">&times;</span>
            //                                </button>
            //                            </div>');
            redirect('dpt_dps/showList/'.$id_desa.'/'.$id_tps);
        }
    }

    public function hapus($id_data,$id_func,$id_desa,$id_tps)
    {
        if($id_func == "1")
        {
            $qt = $this->db->query("SELECT * FROM tb_dpt WHERE id_dpt = '$id_data'")->row()->file;
            $fileFoto = './uploads/'.$qt;
            unlink($fileFoto);

            $this->db->where('id_dpt', $id_data);
            $this->db->delete('tb_dpt');

            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('dpt_dps/showList/'.$id_desa.'/'.$id_tps);
        }
        elseif($id_func == "2")
        {
            $qs = $this->db->query("SELECT * FROM tb_dps WHERE id_dps = '$id_data'")->row()->file;
            $fileFoto = './uploads/'.$qs;
            unlink($fileFoto);

            $this->db->where('id_dps', $id_data);
            $this->db->delete('tb_dps');

            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
            redirect('dpt_dps/showList/'.$id_desa.'/'.$id_tps);
        }
        else
        {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                           <strong>Error!</strong> Data Gagal Dihapus.
                                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                           <span aria-hidden="true">&times;</span>
                                           </button>
                                       </div>');
            redirect('dpt_dps/showList/'.$id_desa.'/'.$id_tps);
        }
    }

    public function showDetail($id_data,$id_func,$id_desa)
    {
        $data = [
            'title'         => 'DPT / DPS',
            'aktif'         => 'dpt_dps',
            'desa'          => $this->Badan_saksi_model->getDataBSDesa($id_desa)->result_array(),
            'keanggotaan'   => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktif()->result_array(),
            'data'          => $this->Dpt_dps_model->getData($id_data,$id_func)->result_array()
        ];

        if($id_func == "1")
        {
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar',$data);
            $this->load->view('dpt_dps/detail',$data);
            $this->load->view('templates/footer');
        }
        elseif($id_func == "2")
        {
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar',$data);
            $this->load->view('dpt_dps/detail',$data);
            $this->load->view('templates/footer');
        }
    }

    public function showEdit($id_data,$id_func,$id_desa)
    {
        $data = [
            'title'         => 'DPT / DPS',
            'aktif'         => 'dpt_dps',
            'desa'          => $this->Badan_saksi_model->getDataBSDesa($id_desa)->result_array(),
            'keanggotaan'   => $this->Keanggotaan_model->getDataKeanggotaanByStatusAktif()->result_array(),
            'data'          => $this->Dpt_dps_model->getData($id_data,$id_func)->result_array()
        ];

        if($id_func == "1")
        {
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar',$data);
            $this->load->view('dpt_dps/edit_dpt',$data);
            $this->load->view('templates/footer');
        }
        elseif($id_func == "2")
        {
            $this->load->view('templates/header');
            $this->load->view('templates/sidebar',$data);
            $this->load->view('dpt_dps/edit_dps',$data);
            $this->load->view('templates/footer');
        }
    }

    public function prosesEdit($id_func)
    {
        $id_data = $this->input->post('id_data');
        $id_desa = $this->input->post('id_desa');
        $id_tps = $this->input->post('id_tps');


        if($_FILES["file_pendukung"]["name"] == "")
        {
            $file_lama = $this->input->post('file_lama');

            $this->Dpt_dps_model->edit($id_data,$id_func,$file_lama);

            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil DiEdit.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('dpt_dps/showList/'.$id_desa.'/'.$id_tps);
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
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                           <strong>Error!</strong> Data Gagal DiEdit.
                                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                           <span aria-hidden="true">&times;</span>
                                           </button>
                                       </div>');
                redirect('dpt_dps/showList/'.$id_desa.'/'.$id_tps);
            }
            else
            {
                $file_lama = $this->input->post('file_lama');

                if($id_func == "1")
                {
                    $q = $this->db->query("SELECT * FROM tb_dpt WHERE file = '$file_lama' ")->row()->file;
                }
                elseif($id_func == "2")
                {
                    $q = $this->db->query("SELECT * FROM tb_dps WHERE file = '$file_lama' ")->row()->file;
                }

                $f = './uploads/'.$q;
                unlink($f);

                $this->upload->do_upload('file_pendukung');
                $f_pendukung = $this->upload->data();
                $f_pendukung = $f_pendukung['file_name'];

                $this->Dpt_dps_model->edit($id_data,$id_func,$f_pendukung );

                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil DiEdit.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('dpt_dps/showList/'.$id_desa.'/'.$id_tps);
            }
        }
    }
}