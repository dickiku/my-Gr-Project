<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita_category_model extends CI_Model {

   private $table = 'tb_berita_category';
   
   public function getCategory()
   {
      return $this->db->get($this->table)->result();
   }

}

/* End of file Category_model.php */
