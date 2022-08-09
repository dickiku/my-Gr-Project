<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller{

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
            'aktif' => 'dashboard',
            
        ];
        $this->load->view('templates/header');
		$this->load->view('templates/sidebar',$data);
		$this->load->view('admin/dashboard');
		$this->load->view('templates/footer');
		$this->load->view('admin/script');
    }
}