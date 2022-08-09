<?php 
  $user = $this->session->userdata('userdata');
  $id_kab = $user['id_kab'];

  $wilayah = $this->db->from('tb_users')
            ->join('wilayah_kab', 'tb_users.id_kab = wilayah_kab.id_kab')
            ->where('tb_users.id_kab',$id_kab)
            ->get()
            ->result_array();

  if($user['id_kab']) {
?>
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
  </nav>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url('admin/dashboard')?>" class="brand-link">
      <img src="<?= base_url() ?>assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Gerindra</span>
    </a>
<!-- Sidebar -->
<div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?= base_url() ?>assets/dist/img/geri.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="<?= base_url('admin/dashboard')?>" class="d-block"><?= $user['nama']?></a>
          <?php foreach ($wilayah as $w) : ?>
          <a href="<?= base_url('admin/dashboard')?>" class="d-block">Admin : <?= $w['nm_kab'] ?></a>
          <?php endforeach; ?>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?= base_url('admin/dashboard')?>" class="nav-link <?php if($aktif == 'dashboard'){echo "active";}?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('keanggotaan/indexAdmKab') ?>" class="nav-link <?php if($aktif == 'keanggotaan'){echo "active";}?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Menu Keanggotaan</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('keanggotaan/calon_anggota')?>" class="nav-link <?php if($aktif == 'calon'){echo "active";}?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Menu Calon Keanggotaan</p>
            </a>
          </li>
          <!-- <li class="nav-header"></li> -->
          <li class="nav-item">
            <a href="<?= base_url('dpc/indexAdmKab')?>" class="nav-link <?php if($aktif == 'dpc'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>DPC</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('pac/indexAdmKabPAC')?>" class="nav-link <?php if($aktif == 'pac'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>PAC</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('ranting/indexAdmKabRanting')?>" class="nav-link <?php if($aktif == 'ranting'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>RANTING</p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link <?php if($aktif == 'anggota_dewan'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                ANGGOTA DEWAN
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('anggota_dewan/indexAdmKabAnggotaDewan');?>" class="nav-link <?php if($aktif == 'anggota_dewan' && $sub == 'dprdkab'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    DPRD Kab/Kota
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link <?php if($aktif == 'fraksi_gerindra'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                FRAKSI GERINDRA
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('fraksi_gerindra/indexAdmKabFraksiGerindra');?>" class="nav-link <?php if($aktif == 'fraksi_gerindra' && $sub == 'dprdkabkota'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    DPRD Kab/Kota
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link <?php if($aktif == 'badan_saksi'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                BADAN SAKSI
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('badan_saksi/indexAdmKabBadanSaksi')?>" class="nav-link <?php if($aktif == 'badan_saksi' && $sub == 'bs_sub'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Kab, Kec, Desa
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('gmd')?>" class="nav-link <?php if($aktif == 'gmd'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>GMD</p>
              <i class="fas fa-angle-left right"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('gmd/indexAdmKabGmd')?>" class="nav-link <?php if($aktif == 'gmd' && $sub == 'gmd-kabupaten'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    GMD Kabupaten/Kota
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('sayap_partai')?>" class="nav-link <?php if($aktif == 'sayap_partai'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>SAYAP PARTAI</p>
              <i class="fas fa-angle-left right"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('sayap_partai/indexAdmKabSayapPartaikabupaten')?>" class="nav-link <?php if($aktif == 'sayap_partai' && $sub == 'sp-kabupaten'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Sayap Partai Kab/Kota
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('sayap_partai/indexAdmKabSayapPartaikecamatan')?>" class="nav-link <?php if($aktif == 'sayap_partai' && $sub == 'sp-kecamatan'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Sayap Partai Kec
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('satgas/indexAdmKabSatgas')?>" class="nav-link <?php if($aktif == 'satgas'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>SATGAS</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link <?php if($aktif == 'ambulance'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>AMBULANCE</p>
              <i class="fas fa-angle-left right"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('ambulance/indexAdmKabAmbulancekabupaten')?>" class="nav-link <?php if($aktif == 'ambulance' && $sub == 'am-kabupaten'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Ambulance Kabupaten
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('dpt_dps/indexAdmKabDptDps')?>" class="nav-link <?php if($aktif == 'dpt_dps'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>DPT/DPS</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if($aktif == 'caleg_potensial'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>CALEG POTENSIAL</p>
              <i class="fas fa-angle-left right"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('caleg_potensial/indexAdmKabCalegPotensialkabupaten')?>" class="nav-link <?php if($aktif == 'caleg_potensial' && $sub == 'cp-kabupaten'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Caleg Potensial Kabupaten
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <!-- <li class="nav-item has-treeview">
            <a href="#" class="nav-link <?php if($aktif == 'data_pemilu'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                DATA PEMILU
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('data_pemilu/pileg')?>" class="nav-link <?php if($aktif == 'data_pemilu' && $sub == 'pileg'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    PILEG
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('data_pemilu/pilpres')?>" class="nav-link <?php if($aktif == 'data_pemilu' && $sub == 'pilpres'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    PILPRES
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('data_pemilu/pilkada')?>" class="nav-link <?php if($aktif == 'data_pemilu' && $sub == 'pilkada'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    PILKADA
                  </p>
                </a>
              </li>
            </ul>
          </li> -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link <?php if($aktif == 'dapil'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                DAPIL
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('dapil/indexAdmKabDapilKabupaten')?>" class="nav-link <?php if($aktif == 'dapil' && $sub == 'kab'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Dapil Kab/Kota
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('cabup/indexAdmKabCabup')?>" class="nav-link <?php if($aktif == 'cabup'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>CALON BUPATI</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('perolehan_kursi')?>" class="nav-link <?php if($aktif == 'perolehan_kursi'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>PEROLEHAN KURSI</p>
            </a>
          </li>
          <!-- <li class="nav-item">
            <a href="<?= base_url('data_pemilu')?>" class="nav-link <?php if($aktif == 'data_pemilu'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>DATA PEMILU</p>
            </a>
          </li> -->
          <li class="nav-header">DATA PEMILU</li>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if($aktif == 'pileg'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                PILEG
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
              <a href="<?= base_url('pileg/pileg_kab/3') ?>" class="nav-link <?php if($aktif == 'pileg' && $sub == 'pileg_kab'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    DPR-Kab/Kota
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('pilpres') ?>" class="nav-link <?php if($aktif == 'pilpres'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                PILPRES
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if($aktif == 'pilkada'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                PILKADA
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('pilkada/pilgub') ?>" class="nav-link <?php if($aktif == 'pilkada' && $sub == 'pilgub'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    PILGUB - Provinsi
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('pilkada/indexAdmKabPilbup') ?>" class="nav-link <?php if($aktif == 'pilkada' && $sub == 'pilbup'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    PILBUP - Kabupaten/Kota
                  </p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-header">SIMPUL JARINGAN</li>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if($aktif == 'toga_tomas'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Toga Tomas
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('simpul_jaringan/indexAdmKabTogaTomasKabupaten')?>" class="nav-link <?php if($aktif == 'toga_tomas' && $sub == 'tt-kab'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Toga Tomas - Kab,Kec,Desa
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if($aktif == 'kpu'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                KPU
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('simpul_jaringan/indexAdmKabKpuKabupaten')?>" class="nav-link <?php if($aktif == 'kpu' && $sub == 'kpu-kab'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    KPU - Kab,Kec,Desa
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if($aktif == 'bawaslu'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Bawaslu
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('simpul_jaringan/indexAdmKabBawasluKabupaten')?>" class="nav-link <?php if($aktif == 'bawaslu' && $sub == 'bawaslu-kab'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Bawaslu - Kab,Kec,Desa
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if($aktif == 'polri'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Polri
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('simpul_jaringan/indexAdmKabPolriKabupaten')?>" class="nav-link <?php if($aktif == 'polri' && $sub == 'polri-kab'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Polri - Kab,Kec,Desa
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if($aktif == 'tni'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                TNI
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('simpul_jaringan/indexAdmKabTniKabupaten')?>" class="nav-link <?php if($aktif == 'tni' && $sub == 'tni-kab'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    TNI - Kab,Kec,Desa
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if($aktif == 'relawan'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Relawan
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('simpul_jaringan/indexAdmKabRelawanKabupaten')?>" class="nav-link <?php if($aktif == 'relawan' && $sub == 'relawan-kab'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Relawan - Kab,Kec,Desa
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('admin/manajemen_admin/edit_password/'.$user['id_user'])?>" class="nav-link <?php if($aktif == 'ubah_password'){echo "active";}?>">
              <p>
                <i class="nav-icon fas fa-lock"></i>
                Ubah Edit Password
              </p>
            </a>
          </li>
          <br>
          <li class="nav-item">
            <a href="<?= base_url('admin/auth/logout')?>" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Logout / Keluar</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

<?php } else { ?>    
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
  </nav>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url('admin/dashboard')?>" class="brand-link">
      <img src="<?= base_url() ?>assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Gerindra</span>
    </a>
<!-- Sidebar -->
<div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?= base_url() ?>assets/dist/img/geri.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="<?= base_url('admin/dashboard')?>" class="d-block"><?= $user['nama']?></a>
          <a href="<?= base_url('admin/dashboard')?>" class="d-block">Super Admin</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?= base_url('admin/dashboard')?>" class="nav-link <?php if($aktif == 'dashboard'){echo "active";}?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('gis/index.php') ?>" class="nav-link <?php if($aktif == 'peta'){echo "active";}?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Peta</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('keanggotaan')?>" class="nav-link <?php if($aktif == 'keanggotaan'){echo "active";}?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Menu Keanggotaan</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('keanggotaan/calon_anggota')?>" class="nav-link <?php if($aktif == 'calon'){echo "active";}?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Menu Calon Keanggotaan</p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="<?= base_url('dpd/kepengurusan')?>" class="nav-link <?php if($aktif == 'dpd'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                DPD
              </p>
            </a>
          </li>
          <!-- <li class="nav-header"></li> -->
          <li class="nav-item">
            <a href="<?= base_url('dpc')?>" class="nav-link <?php if($aktif == 'dpc'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>DPC</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('pac')?>" class="nav-link <?php if($aktif == 'pac'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>PAC</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('ranting')?>" class="nav-link <?php if($aktif == 'ranting'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>RANTING</p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link <?php if($aktif == 'anggota_dewan'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                ANGGOTA DEWAN
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('anggota_dewan/showPeriode/'.'0'.'/'.'1');?>" class="nav-link <?php if($aktif == 'anggota_dewan' && $sub == 'dprri'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    DPR-RI
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('anggota_dewan/showPeriode/'.'0'.'/'.'2');?>" class="nav-link <?php if($aktif == 'anggota_dewan' && $sub == 'dprdprov'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    DPRD Prov
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('anggota_dewan/kab');?>" class="nav-link <?php if($aktif == 'anggota_dewan' && $sub == 'dprdkab'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    DPRD Kab/Kota
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link <?php if($aktif == 'fraksi_gerindra'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                FRAKSI GERINDRA
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('fraksi_gerindra/dprri');?>" class="nav-link <?php if($aktif == 'fraksi_gerindra' && $sub == 'dprri'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    DPR RI
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('fraksi_gerindra/dprdprov');?>" class="nav-link <?php if($aktif == 'fraksi_gerindra' && $sub == 'dprdprov'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    DPRD Prov
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('fraksi_gerindra/dprdkabkota');?>" class="nav-link <?php if($aktif == 'fraksi_gerindra' && $sub == 'dprdkabkota'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    DPRD Kab/Kota
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link <?php if($aktif == 'badan_saksi'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                BADAN SAKSI
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('badan_saksi/showProv')?>" class="nav-link <?php if($aktif == 'badan_saksi' && $sub == 'bs_prov'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Provinsi
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('badan_saksi/showKab')?>" class="nav-link <?php if($aktif == 'badan_saksi' && $sub == 'bs_sub'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Kab, Kec, Desa
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('gmd')?>" class="nav-link <?php if($aktif == 'gmd'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>GMD</p>
              <i class="fas fa-angle-left right"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('gmd/tampil_angkatan')?>" class="nav-link <?php if($aktif == 'gmd' && $sub == 'gmd-angkatan'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Angkatan
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('gmd/tampil_provinsi')?>" class="nav-link <?php if($aktif == 'gmd' && $sub == 'gmd-provinsi'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    GMD Provinsi
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('gmd/kabupaten')?>" class="nav-link <?php if($aktif == 'gmd' && $sub == 'gmd-kabupaten'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    GMD Kabupaten/Kota
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('sayap_partai')?>" class="nav-link <?php if($aktif == 'sayap_partai'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>SAYAP PARTAI</p>
              <i class="fas fa-angle-left right"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('sayap_partai/provinsi')?>" class="nav-link <?php if($aktif == 'sayap_partai' && $sub == 'sp-provinsi'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Sayap Partai Prov
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('sayap_partai/kabupaten')?>" class="nav-link <?php if($aktif == 'sayap_partai' && $sub == 'sp-kabupaten'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Sayap Partai Kab/Kota
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('sayap_partai/kecamatan')?>" class="nav-link <?php if($aktif == 'sayap_partai' && $sub == 'sp-kecamatan'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Sayap Partai Kec
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if($aktif == 'satgas'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>SATGAS</p>
              <i class="fas fa-angle-left right"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('satgas/provinsi')?>" class="nav-link <?php if($aktif == 'satgas' && $sub == 'satgas-provinsi'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Satgas Provinsi
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('satgas')?>" class="nav-link <?php if($aktif == 'satgas' && $sub == 'satgas-kab'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Satgas Kabupaten
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link <?php if($aktif == 'ambulance'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>AMBULANCE</p>
              <i class="fas fa-angle-left right"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('ambulance/provinsi')?>" class="nav-link <?php if($aktif == 'ambulance' && $sub == 'am-provinsi'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Ambulance Provinsi
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('ambulance/kabupaten')?>" class="nav-link <?php if($aktif == 'ambulance' && $sub == 'am-kabupaten'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Ambulance Kabupaten
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('dpt_dps')?>" class="nav-link <?php if($aktif == 'dpt_dps'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>DPT/DPS</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if($aktif == 'caleg_potensial'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>CALEG POTENSIAL</p>
              <i class="fas fa-angle-left right"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('caleg_potensial/provinsi')?>" class="nav-link <?php if($aktif == 'caleg_potensial' && $sub == 'cp-provinsi'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Caleg Potensial Provinsi
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('caleg_potensial/kabupaten')?>" class="nav-link <?php if($aktif == 'caleg_potensial' && $sub == 'cp-kabupaten'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Caleg Potensial Kabupaten
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <!-- <li class="nav-item has-treeview">
            <a href="#" class="nav-link <?php if($aktif == 'data_pemilu'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                DATA PEMILU
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('data_pemilu/pileg')?>" class="nav-link <?php if($aktif == 'data_pemilu' && $sub == 'pileg'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    PILEG
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('data_pemilu/pilpres')?>" class="nav-link <?php if($aktif == 'data_pemilu' && $sub == 'pilpres'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    PILPRES
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('data_pemilu/pilkada')?>" class="nav-link <?php if($aktif == 'data_pemilu' && $sub == 'pilkada'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    PILKADA
                  </p>
                </a>
              </li>
            </ul>
          </li> -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link <?php if($aktif == 'dapil'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                DAPIL
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('dapil/ri')?>" class="nav-link <?php if($aktif == 'dapil' && $sub == 'ri'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Dapil RI
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('dapil/prov')?>" class="nav-link <?php if($aktif == 'dapil' && $sub == 'prov'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Dapil Prov
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('dapil/kab')?>" class="nav-link <?php if($aktif == 'dapil' && $sub == 'kab'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Dapil Kab/Kota
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('periode')?>" class="nav-link <?php if($aktif == 'periode_pemilu'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>PERIODE PEMILU</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('partai')?>" class="nav-link <?php if($aktif == 'partai'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>PARTAI</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('calon_presiden')?>" class="nav-link <?php if($aktif == 'calon_presiden'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>CALON PRESIDEN</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('cagub')?>" class="nav-link <?php if($aktif == 'cagub'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>CALON GUBERNUR</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('cabup')?>" class="nav-link <?php if($aktif == 'cabup'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>CALON BUPATI</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('perolehan_kursi')?>" class="nav-link <?php if($aktif == 'perolehan_kursi'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>PEROLEHAN KURSI</p>
            </a>
          </li>
          <!-- <li class="nav-item">
            <a href="<?= base_url('data_pemilu')?>" class="nav-link <?php if($aktif == 'data_pemilu'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>DATA PEMILU</p>
            </a>
          </li> -->
          <li class="nav-header">DATA PEMILU</li>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if($aktif == 'pileg'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                PILEG
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('pileg/pileg_ri/1') ?>" class="nav-link <?php if($aktif == 'pileg' && $sub == 'pileg_ri'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    DPR-RI
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
              <a href="<?= base_url('pileg/pileg_prov/2') ?>" class="nav-link <?php if($aktif == 'pileg' && $sub == 'pileg_prov'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    DPR-Provinsi
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
              <a href="<?= base_url('pileg/pileg_kab/3') ?>" class="nav-link <?php if($aktif == 'pileg' && $sub == 'pileg_kab'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    DPR-Kab/Kota
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('pilpres') ?>" class="nav-link <?php if($aktif == 'pilpres'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                PILPRES
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if($aktif == 'pilkada'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                PILKADA
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('pilkada/pilgub') ?>" class="nav-link <?php if($aktif == 'pilkada' && $sub == 'pilgub'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    PILGUB - Provinsi
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('pilkada/pilbup') ?>" class="nav-link <?php if($aktif == 'pilkada' && $sub == 'pilbup'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    PILBUP - Kabupaten/Kota
                  </p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-header">SIMPUL JARINGAN</li>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if($aktif == 'toga_tomas'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Toga Tomas
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('simpul_jaringan/toga_tomas')?>" class="nav-link <?php if($aktif == 'toga_tomas' && $sub == 'tt-prov'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Toga Tomas - Provinsi
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('simpul_jaringan/toga_tomas_kabupaten')?>" class="nav-link <?php if($aktif == 'toga_tomas' && $sub == 'tt-kab'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Toga Tomas - Kab,Kec,Desa
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if($aktif == 'kpu'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                KPU
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('simpul_jaringan/kpu')?>" class="nav-link <?php if($aktif == 'kpu' && $sub == 'kpu-prov'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    KPU - Provinsi
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('simpul_jaringan/kpu_kabupaten')?>" class="nav-link <?php if($aktif == 'kpu' && $sub == 'kpu-kab'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    KPU - Kab,Kec,Desa
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if($aktif == 'bawaslu'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Bawaslu
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('simpul_jaringan/bawaslu')?>" class="nav-link <?php if($aktif == 'bawaslu' && $sub == 'bawaslu-prov'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Bawaslu - Provinsi
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('simpul_jaringan/bawaslu_kabupaten')?>" class="nav-link <?php if($aktif == 'bawaslu' && $sub == 'bawaslu-kab'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Bawaslu - Kab,Kec,Desa
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if($aktif == 'polri'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Polri
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('simpul_jaringan/polri')?>" class="nav-link <?php if($aktif == 'polri' && $sub == 'polri-prov'){echo "active";}?>">  
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Polri - Provinsi
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('simpul_jaringan/polri_kabupaten')?>" class="nav-link <?php if($aktif == 'polri' && $sub == 'polri-kab'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Polri - Kab,Kec,Desa
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if($aktif == 'tni'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                TNI
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('simpul_jaringan/tni')?>" class="nav-link <?php if($aktif == 'tni' && $sub == 'tni-prov'){echo "active";}?>"> 
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    TNI - Provinsi
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('simpul_jaringan/tni_kabupaten')?>" class="nav-link <?php if($aktif == 'tni' && $sub == 'tni-kab'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    TNI - Kab,Kec,Desa
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link <?php if($aktif == 'relawan'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Relawan
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('simpul_jaringan/relawan')?>" class="nav-link <?php if($aktif == 'relawan' && $sub == 'relawan-prov'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Relawan - Provinsi
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item ml-1">
                <a href="<?= base_url('simpul_jaringan/relawan_kabupaten')?>" class="nav-link <?php if($aktif == 'relawan' && $sub == 'relawan-kab'){echo "active";}?>">
                  <p>
                    <i class="far fa-circle nav-icon"></i>
                    Relawan - Kab,Kec,Desa
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-header">SISTEM ADMIN</li>
          <li class="nav-item">
            <a href="<?= base_url('admin/manajemen_admin')?>" class="nav-link <?php if($aktif == 'admin'){echo "active";}?>">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Manajemen Admin
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('admin/manajemen_admin/edit_password/'.$user['id_user'])?>" class="nav-link <?php if($aktif == 'ubah_password'){echo "active";}?>">
              <p>
                <i class="nav-icon fas fa-lock"></i>
                Ubah Edit Password
              </p>
            </a>
          </li>
          <br>
          <li class="nav-item">
            <a href="<?= base_url('admin/auth/logout')?>" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Logout / Keluar</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
<?php } ?>