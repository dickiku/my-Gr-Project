<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller{

    public function index()
    {
        $this->__rules();

        if($this->form_validation->run() == FALSE)
        {
            $data = [
                'judul' => 'Login Admin Gerindra'
            ];
    
            $this->load->view('admin/login',$data);
        }
        else
        {
            //validasi jika sukses
            $this->_login();
        }

    }

    private function _login()
    {
        $nik        = $this->input->post('nik');
        $password   = $this->input->post('password');

        $user = $this->db->get_where('tb_users', ['nik' => $nik])->row_array();

        if($user)
        {
            if(password_verify($password, $user['password']))
            {
                $data = [
                    'id_user' => $user['id_user'],
                    'nik'     => $user['nik'],
                    'nama'    => $user['nama'],
                    'level'   => $user['level'],
                    'id_kab'  => $user['id_kab'],
                ];

                $this->session->set_userdata('userdata',$data);
                redirect('admin/dashboard');
                
            }
            else
            {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>Error!</strong> Password anda salah
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
                redirect('admin/auth');
            }
        }
        else
        {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>Error!</strong> NIK belum terdaftar.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('admin/auth');
        }
    }

    // private function _login()
    // {
    //     $user        = $this->Login_model->cek_login();

    //     //user ada
    //     if($user)
    //     {
    //         $data = [
    //             'nik'   => $user['nik'],
    //             'level' => $user['level']
    //         ];
    
    //         $this->session->set_userdata('userdata',$data);
    //         redirect('admin/dashboard');
    //     }
    //     else
    //     {
    //         //user tidak ada
    //         $this->session->set_flashdata('pesan', '<div class="alert alert-danger" 
    //                                         role="alert">NIK atau Password Anda Salah!</div>');
    //         redirect('admin/auth');
    //     }
    // }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('admin/auth');
    }

    public function __rules()
    {
        $this->form_validation->set_rules('nik', 'NIK', 'required|trim',[
            'required'  => '*NIK wajib diisi!'
        ]);

        $this->form_validation->set_rules('password', 'Password', 'required|trim',[
            'required'  => '*Password wajib diisi!'
        ]);
    }
}