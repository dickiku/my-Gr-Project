<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar extends CI_Controller{

    public function index()
    {
        $data = [
            'judul'         => 'Pendaftaran Anggota',
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayah()->result_array(),
            'wilayahKec'    => $this->Keanggotaan_model->getDataWilayahKec()->result_array(),
            'wilayahDesa'   => $this->Keanggotaan_model->getDataWilayahDesa()->result_array(),
        ];

        //$this->load->view('templates/header');
        $this->load->view('landing_page');
        $this->load->view('calon/daftar',$data);
        //$this->load->view('templates/footer');
        
    }

    public function daftar_awal_proses()
    {
        $this->_rulesAwal();

        if($this->form_validation->run() == FALSE)
        {
            $this->index();
        }
        else
        {
            //setting config untuk library upload
            $config['upload_path']      = './uploads';
            $config['allowed_types']    = 'gif|jpg|png|jpeg';
            $config['encrypt_name']     = true;
            $config['max_size']         = 1000000000;
            $config['max_width']        = 1024000;
            $config['max_height']       = 768000;

            //pemanggilan librabry upload
            $this->load->library('upload', $config);

            //jika upload gagal
            if(!$this->upload->do_upload('foto_profil') || !$this->upload->do_upload('foto_ktp') )
            {

                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                               <strong>Error!</strong> Foto Profil dan Foto KTP Wajib Diisi!. 
                                               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                               <span aria-hidden="true">&times;</span>
                                               </button>
                                           </div>');
                redirect('calon/daftar');
            }
            else
            {
                $this->upload->do_upload('foto_profil');
                $foto_profil = $this->upload->data();
                $foto = $foto_profil['file_name'];

                $this->upload->do_upload('foto_ktp');
                $foto_ktp = $this->upload->data();
                $ktp = $foto_ktp['file_name'];

                $this->Daftar_model->daftarCalon($foto, $ktp);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    <strong>Sukses!</strong> Pendaftaran Berhasil.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');
                redirect('https://gerindrajateng.id');
            }

        }
    }

    public function loginCalon()
    {

        $this->_rulesLogin();

        if($this->form_validation->run() == FALSE)
        {
            $data = [
                'judul' => 'Login Calon Anggota'
            ];
    
            $this->load->view('calon/loginCalon',$data);
        }
        else
        {
            //validasi sukses
            $this->_login();
        }

    }

    private function _login()
    {
        $no_ktp     = $this->input->post('no_ktp');
        $password   = $this->input->post('password');

        $user = $this->db->get_where('tb_keanggotaan', ['no_ktp' => $no_ktp])->row_array();

        if($user)
        {
            if(password_verify($password, $user['password']))
            {
                $data = [
                    'id_keanggotaan'    => $user['id_keanggotaan'],
                    'no_ktp'            => $user['no_ktp'],
                    'nama'              => $user['nama'],
                ];

                $this->session->set_userdata('userdataCalon',$data);
                redirect('calon/dashboard/index/'.$data['id_keanggotaan']);
            }
            else
            {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>Error!</strong> Password anda salah
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
                redirect('calon/daftar/loginCalon');
            }
        }
        else
        {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>Error!</strong> No KTP belum terdaftar.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('calon/daftar/loginCalon');
        }
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

    // public function daftar_proses()
    // {
    //     $this->_rules();

    //     if($this->form_validation->run() == FALSE)
    //     {
    //         $this->index();
    //     }
    //     else
    //     {
    //         //setting config untuk library upload
    //         $config['upload_path']      = './uploads';
    //         $config['allowed_types']    = 'gif|jpg|png';
    //         $config['max_size']         = 1000000000;
    //         $config['max_width']        = 1024000;
    //         $config['max_height']       = 768000;

    //         //pemanggilan librabry upload
    //         $this->load->library('upload', $config);

    //         //jika upload gagal
    //         if(!$this->upload->do_upload('foto_profil') || !$this->upload->do_upload('foto_ktp'))
    //         {

    //             $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //                                         <strong>Error!</strong> Data Gagal Ditambah.
    //                                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    //                                         <span aria-hidden="true">&times;</span>
    //                                         </button>
    //                                     </div>');
    //             redirect('daftar');
    //         }
    //         else
    //         {
    //             $this->upload->do_upload('foto_profil');
    //             $foto_profil = $this->upload->data();
    //             $foto = $foto_profil['file_name'];

    //             $this->upload->do_upload('foto_ktp');
    //             $foto_ktp = $this->upload->data();
    //             $ktp = $foto_ktp['file_name'];

    //             $this->Daftar_model->daftarAnggota($foto, $ktp);
    //             // $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
    //             //                             <strong>Sukses!</strong> Data Berhasil Ditambah.
    //             //                             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    //             //                             <span aria-hidden="true">&times;</span>
    //             //                             </button>
    //             //                         </div>');
    //             redirect('landing_page');
    //         }
    //     }
    // }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('calon/daftar/loginCalon');
    }

    public function _rulesLogin()
    {
        $this->form_validation->set_rules('no_ktp', 'No KTP', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong>No KTP wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('password', 'Password', 'required|trim', [
            'required'      => '<div class="text-danger small"><strong>Error!</strong> Password wajib diisi</div>'
        ]);
    }

    public function _rulesAwal()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Nama wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('no_ktp', 'No KTP', 'required|trim|is_unique[tb_keanggotaan.no_ktp]',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong>No KTP wajib diisi</div>',
            'is_unique' => '<div class="text-danger small"><strong>Error!</strong>No KTP sudah terdaftar</div>'
        ]);

        $this->form_validation->set_rules('dpc_kab_kota', 'Wilayah Kabupaten', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Wilayah Kabupaten wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('wilayah_kec', 'Wilayah Kecamatan', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Wilayah Kecamatan wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('wilayah_desa', 'Wilayah Desa', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Wilayah Desa wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Tempat Lahir wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Tanggal Lahir wajib diisi</div>'
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

        // $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|matches[konfirmasi_password]', [
        //     'required'      => '<div class="text-danger small"><strong>Error!</strong> Password wajib diisi</div>',
        //     'min_length'    => '<div class="text-danger small"><strong>Error!</strong> Minimal panjang password 6 huruf/angka</div>',
        //     'matches'       => '<div class="text-danger small"><strong>Error!</strong> Password tidak cocok</div>',
        // ]);

        // $this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi Password', 'required|trim|matches[password]', [
        //     'required'  => '<div class="text-danger small"><strong>Error!</strong> Konfirmasi Password wajib diisi</div>',
        //     'matches'   => '<div class="text-danger small"><strong>Error!</strong> Password tidak cocok</div>',
        // ]);
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Nama wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Tanggal Lahir wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('no_ktp', 'No KTP', 'required|trim|is_unique[tb_keanggotaan.no_ktp]',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong>No KTP wajib diisi</div>',
            'is_unique' => '<div class="text-danger small"><strong>Error!</strong>No KTP sudah terdaftar</div>'
        ]);

        $this->form_validation->set_rules('no_kta', 'No KTA', 'required|trim|is_unique[tb_keanggotaan.no_kta]',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong>No KTA wajib diisi</div>',
            'is_unique' => '<div class="text-danger small"><strong>Error!</strong>No KTA sudah terdaftar</div>'
        ]);

        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong>Alamat wajib diisi</div>'
        ]);
        
        $this->form_validation->set_rules('no_hp', 'No HP', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong>Nama wajib diisi</div>'
        ]);
        
        $this->form_validation->set_rules('agama', 'Agama', 'required|trim',[
            'required'      => '<div class="text-danger small"><strong>Error!</strong>Agama wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[tb_keanggotaan.email]',[
            'required'      => '<div class="text-danger small"><strong>Error!</strong>Email wajib diisi</div>',
            'valid_email'   => '<div class="text-danger small"><strong>Error!</strong>Email yang dimasukkan harus valid</div>'
        ]);

        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong>Jenis Kelamin wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('status_perkawinan', 'Status Perkawinan', 'required|trim',[
            'required'  => '<div class="text-danger small"><strong>Error!</strong>Status Perkawinan wajib diisi</div>'
        ]);
    }
}