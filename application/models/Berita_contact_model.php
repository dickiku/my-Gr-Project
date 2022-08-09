<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita_contact_model extends CI_Model {

   public function getAbout()
   {
      return $this->db->get('contact')->row();
   }

}

/* End of file Contact_model.php */
