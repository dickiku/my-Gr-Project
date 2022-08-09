<?php
$this->load->model('category_model', 'category', true);
$navbar   = $this->category->getCategory();

$category = $this->uri->segment(3);
?>

<nav class="navbar navbar-light navbar-expand-lg navbar-light bg-light fixed-top home">
   <div class="container-fluid">
      <a href="<?= base_url() ?>" class="navbar-brand d-flex w-50 mr-auto">
      <img src="<?= base_url('assets/img/gerindra.jpg') ?>" alt="" width="30" height="20" class="d-inline-block align-top" loading="lazy"> DPD Gerindra
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar3">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="navbar-collapse collapse w-100 " id="collapsingNavbar3">
         <ul class="navbar-nav w-100 justify-content-start">
            <?php foreach ($navbar as $n) : ?>
               <li class="nav-item <?php if ($n->slug === $category) {
                                       echo "active";
                                    } ?> ">
                  <a class="nav-link" href="<?= base_url("blog/category/$n->slug") ?>"><?= $n->category_name ?></a>
               </li>
            <?php endforeach ?>
         </ul> 
         <ul class="nav navbar-nav ml-auto w-100 justify-content-end">
            <li class="nav-item">
               <a class="btn btn-outline-primary my-2 my-sm-0 mr-2" href="<?= base_url('admin/auth') ?>">LOGIN
                  <!-- <i class="fa fa-twitter"></i> -->
               </a>
            </li>
            <li class="nav-item">
               <a class="btn btn-outline-primary my-2 my-sm-0 mr-2" href="<?= base_url('calon/daftar/loginCalon') ?>">LOGIN CALON
                  
               </a>
            </li>
            <li class="nav-item">
               <a class="btn btn-outline-warning my-2 my-sm-0 mr-2" href="<?= base_url('calon/daftar') ?>">DAFTAR
                  
               </a>
            </li>
         </ul>
      </div>
   </div>
</nav>