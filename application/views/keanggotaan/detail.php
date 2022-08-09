<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?= $title ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><?= $title ?></li>
              <li class="breadcrumb-item active">Detail</li>
            </ol>
          </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<div class="container">
    <a href="<?= base_url('keanggotaan/prints/'.$keanggotaan['id_keanggotaan']) ?> "class="btn btn-effect-ripple btn-success ml-2 mb-2"><i class="fa fa-print"></i> Print KTA</a>
</div>
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3 mx-auto">
                    <img src="<?= base_url('uploads/').$keanggotaan['foto_profil'] ?>" class="card-img-top card-img img-circle img-thumbnail mx-auto mt-2" style="max-width: 140px;">
                    <hr>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label>Kabupaten/Kota</label>
                                <input type="text" class="form-control" value="<?= $keanggotaan['nm_kab']?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Kecamatan</label>
                                <input type="text" class="form-control" value="<?= $keanggotaan['nm_kec']?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Desa/Kelurahan</label>
                                <input type="text" class="form-control" value="<?= $keanggotaan['nm_desa']?>" readonly>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" value="<?= $keanggotaan['nama']?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input type="date" class="form-control" value="<?= $keanggotaan['tgl_lahir']?>" readonly>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>No KTP</label>
                                    <input type="text" class="form-control" value="<?= $keanggotaan['no_ktp']?>" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>No KTA</label>
                                    <input type="text" class="form-control" value="<?= $keanggotaan['no_kta']?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" class="form-control" value="<?= $keanggotaan['alamat']?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>NO HP</label>
                                <input type="text" class="form-control" value="<?= $keanggotaan['no_hp']?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Agama</label>
                                <input type="text" class="form-control" value="<?= $keanggotaan['agama']?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" value="<?= $keanggotaan['email']?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <input type="text" class="form-control" value="<?= $keanggotaan['jenis_kelamin']?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Status Perkawinan</label>
                                <input type="text" class="form-control" value="<?= $keanggotaan['status_perkawinan']?>" readonly>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Nama Istri / Suami</label>
                                    <input type="text" class="form-control" value="<?= $keanggotaan['nama_istri_suami']?>" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Nama Anak</label>
                                    <input type="text" class="form-control" value="<?= $keanggotaan['nama_anak']?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Latar Belakang Pendidikan</label>
                                <input type="text" class="form-control" value="<?= $keanggotaan['latar_pendidikan']?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Latar Belakang Organisasi</label>
                                <input type="text" class="form-control" value="<?= $keanggotaan['latar_organisasi']?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Latar Belakang Pekerjaan</label>
                                <input type="text" class="form-control" value="<?= $keanggotaan['latar_pekerjaan']?>" readonly>
                            </div>
                            <?php

                                //menangkap data yang dipostkan di form
                                $angkaa= $keanggotaan['tgl_lahir'] ;
                                $angkab= $keanggotaan['no_ktp'] ;
                                
                                //membuang titik dengan menggunakan fungsi replace
                                $angka1= str_replace("-", "", $angkaa);
                                $angka2= str_replace("-", "", $angkab);
                                $no_kta = "$angka1$angka2";
                                
                                ?>

                            <div class="form-group">
                                <label>KTA COBA</label>
                                <input type="text" class="form-control" value="<?= $no_kta?>" readonly>
                            </div>
                       </form>
                    </div> 
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3 mx-auto">
                    <a href="<?php echo base_url()."download/file/".$keanggotaan['foto_ktp'];?>">
                        <img src="<?= base_url('uploads/').$keanggotaan['foto_ktp'] ?>" class="card-img-top card-img img-thumbnail mx-auto mt-2" style="max-width: 300p;">
        			</a>
                </div>
            </div>
        </div>
    </div>
</section>