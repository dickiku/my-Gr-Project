<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita_admin_model extends CI_Model{

    public function getDataAdmin()
    {
        return $this->db->get('tb_users');
    }

    public function getDataAdminById($id_user)
    {
        $this->db->where('id_user', $id_user);
        return $this->db->get('tb_users');
    }

    public function tambahAdmin()
    {
        $data = [
            'nik'           => htmlspecialchars($this->input->post('nik', true)),
            'nama'          => htmlspecialchars($this->input->post('nama', true)),
            'jenis_kelamin' => $this->input->post('jenis_kelamin'),
            'password'      => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
            'level'         => $this->input->post('level'),
            'id_kab'        => $this->input->post('dpc_kab_kota'),
        ];

        $this->db->insert('tb_users',$data);
    }

    public function EditAdmin($id_user)
    {
        $data = [
            'nik'           => htmlspecialchars($this->input->post('nik', true)),
            'nama'          => htmlspecialchars($this->input->post('nama', true)),
            'jenis_kelamin' => $this->input->post('jenis_kelamin'),
            'level'         => $this->input->post('level')
        ];

        $this->db->where('id_user', $id_user);
        $this->db->update('tb_users', $data);
    }
}