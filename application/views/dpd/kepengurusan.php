<?php
    $user = $this->session->userdata('userdata');
?>
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
              <li class="breadcrumb-item active">Kepengurusan DPD</li>
            </ol>
          </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<style>


.row > .column {
  padding: 0 8px;
}

.row:after {
  content: "";
  display: table;
  clear: both;
}

.column {
  float: left;
  width: 25%;
}

/* The Modal (background) */
.modalll {
  display: none;
  position: fixed;
  z-index: 1;
  padding-top: 100px;
  left: 0;
  top: 0;
  width: 50%;
  height: 50%;
  overflow: auto;
  background-color: black;
}
.modall {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1050;
    display: none;
    width: 70%;
    height: 70%;
    overflow: hidden;
    outline: 0;
}

/* Modal Content */
.modal-content {
  position: relative;
  background-color: #fefefe;
  margin: auto;
  padding: 0;
  width: 90%;
  max-width: 1200px;
}

/* The Close Button */
.close {
  color: white;
  position: absolute;
  top: 10px;
  right: 25px;
  font-size: 35px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #999;
  text-decoration: none;
  cursor: pointer;
}

.mySlides {
  display: none;
}

.cursor {
  cursor: pointer;
}

/* Next & previous buttons */
/*.prev,*/
/*.next {*/
/*  cursor: pointer;*/
/*  position: absolute;*/
/*  top: 50%;*/
/*  width: auto;*/
/*  padding: 16px;*/
/*  margin-top: -50px;*/
/*  color: white;*/
/*  font-weight: bold;*/
/*  font-size: 20px;*/
/*  transition: 0.6s ease;*/
/*  border-radius: 0 3px 3px 0;*/
/*  user-select: none;*/
/*  -webkit-user-select: none;*/
/*}*/

/* Position the "next button" to the right */
/*.next {*/
/*  right: 0;*/
/*  border-radius: 3px 0 0 3px;*/
/*}*/

/* On hover, add a black background color with a little bit see-through */
.prev:hover,
.next:hover {
  background-color: rgba(0, 0, 0, 0.8);
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

img {
  margin-bottom: -4px;
}

.caption-container {
  text-align: center;
  background-color: black;
  padding: 2px 16px;
  color: white;
}

.demo {
  opacity: 0.6;
}

.active,
.demo:hover {
  opacity: 1;
}

img.hover-shadow {
  transition: 0.3s;
}

.hover-shadow:hover {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
</style>
<!-- <div class="container ml-2">
    <a href="<?= base_url('dpd/tambah') ?>" class="btn btn-primary mb-3">+ Tambah Data Kepengurusan DPD</a>
</div> -->
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
            <?= $this->session->flashdata('pesan') ?>
                <div class="card mb-3 mx-auto">
                    <div class="card-body">
                        <?php foreach($data as $row) : ?>
                            <a href="<?= base_url('dpd/edit/').$row['id_dpd'] ?>" class="btn btn-lg btn-warning mb-2">Edit</a>
                        <?php endforeach; ?>
                        <table class="table table-bordered table-striped table-hover" id="myTable">
                            <tbody>
                                <?php foreach($data as $row) : ?>
                                <tr>
                                    <td><strong>DPD</strong></td>
                                    <td>DPD Prov Jateng</td>
                                </tr>
                                <tr>
                                    <td><strong>Alamat</strong></td>
                                    <td><?= $row['alamat']?></td>
                                </tr>
                                <tr>
                                    <td><strong>No. Telp</strong></td>
                                    <td><?= $row['no_telp']?></td>
                                </tr>
                                <tr>
                                    <td><strong>No. SK</strong></td>
                                    <td><?= $row['no_sk']?></td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal SK</strong></td>
                                    <td><?= $row['tanggal_sk']?></td>
                                </tr>
                                <tr>
                                    <td><strong>Admin</strong></td>
                                    <td><?= $row['admin']?></td>
                                </tr>
                                <tr>
                                    <td><strong>Sosial Media</strong></td>
                                    <td>
                                        <a href="<?= $row['link_facebook']?>">Facebook</a> |
                                        <a href="<?= $row['link_instagram']?>">Instagram</a> |
                                        <a href="<?= $row['link_tiktok']?>">Tiktok</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Scan SK</strong></td>
                                    <td><?= $row['scan_sk']?>
        								<a href="<?php echo base_url()."download/file/".$row['scan_sk'];?>">
        									<i class="fa fa-download" aria-hidden="true"></i>
        								</a>
							        </td>
                                </tr>
                                <tr>
                                    <td><strong>Foto Kantor</strong></td>
                                    <td>
                                        <img onclick="openModal();currentSlide(1)" class="hover-shadow cursor" src="<?= base_url('uploads/').$row['foto_kantor'] ?>" class="card-img-top card-img img-thumbnail mt-2" style="max-width: 140px;">    
                                        <img onclick="openModal();currentSlide(2)" class="hover-shadow cursor" src="<?= base_url('uploads/').$row['foto_kantor_1'] ?>" class="card-img-top card-img img-thumbnail mt-2" style="max-width: 140px;">    
                                        <img onclick="openModal();currentSlide(3)" class="hover-shadow cursor" src="<?= base_url('uploads/').$row['foto_kantor_2'] ?>" class="card-img-top card-img img-thumbnail mt-2" style="max-width: 140px;">    
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container ml-2">
    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahKepengurusanDPD">+ Tambah Data Kepengurusan DPD</a>
</div>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Susunan Kepengurusan DPD Provinsi Jateng</h3>
                </div>
                <div class="card-body col-md-8 mx-auto">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" width="20px">Kolom</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Jabatan</th>
                                <th class="text-center" width="100px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($kepengurusan as $kp) : ?>
                            <tr>
                                <td><?= $kp['kolom']?></td>
                                <td><a href="<?= base_url('keanggotaan/detail/').base64_encode($kp['id_keanggotaan']) ?>"><?= $kp['nama']?></a></td>
                                <td><?= $kp['nama_jabatan']?></td>
                                <td>
                                <?php if($user['level'] == 'Super Admin') : ?>
                                    <a href="<?= base_url('dpd/editKepengurusan/').$kp['id_pengurus_dpd'] ?>" class="btn btn-warning btn-md">
                                        Edit
                                    </a>
                                    <a href="<?= base_url('dpd/hapusKepengurusan/').$kp['id_pengurus_dpd'] ?>" class="btn btn-danger btn-md" onclick="return confirm('Apakah yakin anda ingin menghapus data ini?')">
                                        Hapus
                                    </a>
                                <?php elseif($user['level'] == 'Admin' ) : ?>
                                    <a href="<?= base_url('dpd/editKepengurusan/').$kp['id_pengurus_dpd'] ?>" class="btn btn-warning btn-md">
                                        Edit
                                    </a>
                                <?php endif;?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

    
<div id="myModal" class="modall">
  <span class="close cursor" onclick="closeModal()">&times;</span>
  <div class="modal-content">

    <div class="mySlides">
      <div class="numbertext">1 / 3</div>
      <img src="<?= base_url('uploads/').$row['foto_kantor'] ?>" style="width:70%">
    </div>

    <div class="mySlides">
      <div class="numbertext">2 / 3</div>
      <img src="<?= base_url('uploads/').$row['foto_kantor_1'] ?>" style="width:70%">
    </div>

    <div class="mySlides">
      <div class="numbertext">3 / 3</div>
      <img src="<?= base_url('uploads/').$row['foto_kantor_2'] ?>" style="width:70%">
    </div>
    
    
    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>

    <div class="caption-container">
      <p id="caption"></p>
    </div>


    <div class="column">
      <img class="demo cursor" src="<?= base_url('uploads/').$row['foto_kantor'] ?>" style="width:100%" onclick="currentSlide(1)" alt="Nature and sunrise">
    </div>
    <div class="column">
      <img class="demo cursor" src="<?= base_url('uploads/').$row['foto_kantor_1'] ?>" style="width:100%" onclick="currentSlide(2)" alt="Snow">
    </div>
    <div class="column">
      <img class="demo cursor" src="<?= base_url('uploads/').$row['foto_kantor_2'] ?>" style="width:100%" onclick="currentSlide(3)" alt="Mountains and fjords">
    </div>
  </div>
</div>

<script>
function openModal() {
  document.getElementById("myModal").style.display = "block";
}

function closeModal() {
  document.getElementById("myModal").style.display = "none";
}

var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  var captionText = document.getElementById("caption");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  captionText.innerHTML = dots[slideIndex-1].alt;
}
</script>

<!-- Modal Tambah-->
<div class="modal fade" id="tambahKepengurusanDPD" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Kepengurusan DPD</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('dpd/tambah_kepengurusan_proses') ?>" method="post">
            <div class="form-group">
                <label>Kolom</label><label class="text-danger text-lg">*</label>
                <input type="number" name="kolom" class="form-control">
                <?php echo form_error('kolom'); ?>
            </div>
            <div class="form-group">
                <label>Nama Keanggotaan</label><label class="text-danger text-lg">*</label>
                <input list="keanggotaan" name="keanggotaan" class="form-control">
                <datalist id="keanggotaan">
                    <option value="">--Pilih Keanggotaan--</option>
                    <?php foreach($keanggotaan as $kg) : ?>
                        <option value="<?= $kg['id_keanggotaan'] ?>"> 
                            <?= $kg['nama'] ?> | 
                            <?= $kg['no_kta'] ?>
                        </option>
                    <?php endforeach; ?>
                </datalist>
                <?php echo form_error('keanggotaan'); ?>
            </div>
            <div class="form-group">
                <label>Jabatan</label><label class="text-danger text-lg">*</label>
                <select class="form-control" name="jabatan">
                    <option value="">--Pilih Jabatan--</option>
                    <?php foreach($jabatan as $jb) : ?>
                        <option value="<?= $jb['id_jabatan'] ?>"><?= $jb['nama_jabatan'] ?></option>
                    <?php endforeach; ?>
                </select>
                <?php echo form_error('jabatan'); ?>
            </div> 
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>                        
        </form>
      </div>
    </div>
  </div>
</div>