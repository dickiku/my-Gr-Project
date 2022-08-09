<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita_home extends CI_Controller {
   
   public function __construct()
   {
      parent::__construct();
      $this->load->helper('text');
      $this->load->model('berita_identity_model', 'identity', true);
      $this->load->model('berita_banner_model', 'banner', true);
      $this->load->model('berita_posting_model', 'posting', true);
      $this->load->model('berita_category_model', 'category', true);
   }
   
   public function index()
   {
      $data['favicon']     = $this->identity->getIdentity();
      $data['title']       = 'Home';
      $data['banner']      = $this->banner->getBanner();
      $data['featured']    = $this->posting->getFeatured();
      $data['choice']      = $this->posting->getChoice();
      $data['popular']     = $this->posting->getMostPopular();
      $data['trending']    = $this->posting->getThread();
      $data['lastNews']    = $this->posting->getLastNews();
      $data['video_game']  = $this->posting->getVideoGames();
      $data['category']    = $this->category->getCategory();

      $data['page'] = 'home';
      $this->load->view('front/layouts/app', $data);
   }    
   
}

/* End of file Home.php */
