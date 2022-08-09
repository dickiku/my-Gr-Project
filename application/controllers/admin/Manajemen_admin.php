<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Manajemen_admin extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        
        $user = $this->session->userdata('userdata');
        if($user['level'] != 'Admin' && $user['level'] != 'Super Admin')
        {
            redirect('admin/auth');
        }
    }

    public function index()
    {
        $data = [
            'title'     => 'Admin',
            'aktif'     => 'admin',
            'data'      => $this->Admin_model->getDataAdmin()->result_array(),
            'dataa'     => $this->Admin_model->getDataAdminAll()->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('admin/manajemen_admin',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_admin()
    {
        $data = [
            'title'     => 'Admin',
            'aktif'     => 'admin',
            'wilayahKab'    => $this->Wilayah_kab_model->getDataWilayah()->result(),
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('admin/tambah_admin',$data);
		$this->load->view('templates/footer');
    }

    public function tambah_admin_proses()
    {
        $this->_rules();

        if($this->form_validation->run() == FALSE)
        {
            $this->tambah_admin();
        }
        else
        {
            $this->Admin_model->tambahAdmin();
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Ditambahkan.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('admin/manajemen_admin');
        }
    }

    public function edit($id_user)
    {
        $data = [
            'title'     => 'Admin',
            'aktif'     => 'admin',
            'data'      => $this->Admin_model->getDataAdminById($id_user)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('admin/edit_admin',$data);
		$this->load->view('templates/footer');
    }

    public function edit_admin_proses($id_user)
    {
        $this->_rulesEdit();

        if($this->form_validation->run() == FALSE)
        {
            $this->edit($id_user);
        }
        else
        {
            $this->Admin_model->EditAdmin($id_user);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sukses!</strong> Data Berhasil Diedit.
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>');
            redirect('admin/manajemen_admin');
        }
    }

    public function edit_password($id_user)
    {
        $user = $this->session->userdata('userdata');

        if($user['id_user'] != $id_user)
        {
            $this->session->sess_destroy();
            redirect('admin/auth');
        }

        $data = [
            'title'     => 'Ubah Password',
            'aktif'     => 'ubah_password',
            'data'      => $this->Admin_model->getDataAdminById($id_user)->result_array()
        ];

        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('admin/edit_password',$data);
		$this->load->view('templates/footer');
    }

    public function edit_password_proses($id_user)
    {
        $this->_rulesEditPassword();

        if($this->form_validation->run() == FALSE)
        {
            $this->edit_password($id_user);
        }
        else
        {

            $user = $this->db->query("SELECT * FROM tb_users WHERE id_user = '$id_user'")->row_array();

            $pass_lama = $this->input->post('password_lama');
            $pass_baru = password_hash($this->input->post('password_baru'), PASSWORD_DEFAULT);

            if(password_verify($pass_lama, $user['password'])) 
            {
                $data = [
                    'password'  => $pass_baru
                ];

                $this->db->where('id_user', $id_user);
                $this->db->update('tb_users', $data);

                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Password Berhasil Diedit.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('admin/manajemen_admin/edit_password/'.$id_user);
            }
            else
            {           
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>Gagal!</strong> Password Salah.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
                redirect('admin/manajemen_admin/edit_password/'.$id_user);
            }
        }
    }

    public function hapus($id_user)
    {
        $this->db->where('id_user', $id_user);
        $this->db->delete('tb_users');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <strong>Sukses!</strong> Data Berhasil Dihapus.
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>');
        redirect('admin/manajemen_admin');
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nik', 'NIK', 'required|trim|is_unique[tb_users.nik]', [
            'required'  => '<div class="text-danger small"><strong>Error!</strong> NIK wajib diisi</div>',
            'is_unique' => '<div class="text-danger small"><strong>Error!</strong> NIK sudah terdaftar</div>'
        ]);

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim', [
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Nama wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|trim', [
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Jenis Kelamin wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('level', 'Level Admin', 'required|trim', [
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Level Admin wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[6]|matches[password2]', [
            'required'      => '<div class="text-danger small"><strong>Error!</strong> Password wajib diisi</div>',
            'min_length'    => '<div class="text-danger small"><strong>Error!</strong> Minimal panjang password 6 huruf/angka</div>',
            'matches'       => '<div class="text-danger small"><strong>Error!</strong> Password tidak cocok</div>',
        ]);

        $this->form_validation->set_rules('password2', 'Konfirmasi Password', 'required|trim|matches[password1]', [
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Konfirmasi Password wajib diisi</div>',
            'matches'   => '<div class="text-danger small"><strong>Error!</strong> Password tidak cocok</div>',
        ]);
    }

    public function _rulesEdit()
    {
        $this->form_validation->set_rules('nik', 'NIK', 'required|trim', [
            'required'  => '<div class="text-danger small"><strong>Error!</strong> NIK wajib diisi</div>',
        ]);

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim', [
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Nama wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|trim', [
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Jenis Kelamin wajib diisi</div>'
        ]);

        $this->form_validation->set_rules('level', 'Level Admin', 'required|trim', [
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Level Admin wajib diisi</div>'
        ]);
    }

    public function _rulesEditPassword()
    {
        $this->form_validation->set_rules('password_lama', 'Password Lama', 'required|trim|min_length[6]', [
            'required'      => '<div class="text-danger small"><strong>Error!</strong> Password Lama wajib diisi</div>',
            'min_length'    => '<div class="text-danger small"><strong>Error!</strong> Minimal panjang password 6 huruf/angka</div>',
        ]);

        $this->form_validation->set_rules('password_baru', 'Password Baru', 'required|trim|min_length[6]|matches[password_baru_2]', [
            'required'      => '<div class="text-danger small"><strong>Error!</strong> Password Baru wajib diisi</div>',
            'min_length'    => '<div class="text-danger small"><strong>Error!</strong> Minimal panjang password 6 huruf/angka</div>',
            'matches'       => '<div class="text-danger small"><strong>Error!</strong> Password tidak cocok</div>',
        ]);

        $this->form_validation->set_rules('password_baru_2', 'Konfirmasi Password Baru', 'required|trim|matches[password_baru]', [
            'required'  => '<div class="text-danger small"><strong>Error!</strong> Konfirmasi Password Baru wajib diisi</div>',
            'matches'   => '<div class="text-danger small"><strong>Error!</strong> Password tidak cocok</div>',
        ]);
    }
}