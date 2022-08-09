
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $judul; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body>
    <!-- general form elements -->
    
<!-- /.card -->
<section class="content">
    <div class="container">
    <?= $this->session->flashdata('pesan'); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary mt-3 mx-auto">
                    <div class="card-header">
                        <h3 class="card-title">Pendaftaran Calon Anggota</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= base_url('calon/daftar/daftar_awal_proses') ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Upload Foto Profil</label><label class="text-danger text-lg">*</label>
                                <input type="file" name="foto_profil" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Upload Foto KTP</label><label class="text-danger text-lg">*</label>
                                <input type="file" name="foto_ktp" class="form-control">
                            </div>
                            <div class="form-group">
                               <label>Kabupaten/Kota</label><label class="text-danger text-lg">*</label>
                               <select name="dpc_kab_kota" class="form-control" id="wilayah_kab">
                                    <option value="">--Pilih Kabupaten/Kota--</option>
                                    <?php foreach($wilayahKab as $wk) : ?>
                                        <?php if($wk['id_kab'] == $row['id_kab']) : ?>
                                            <option value="<?= $row['id_kab'] ?>" selected><?= $row['nm_kab']?></option>
                                        <?php else : ?>
                                            <option value="<?= $wk['id_kab'] ?>"><?= $wk['nm_kab']?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                               </select>
                               <?php echo form_error('dpc_kab_kota'); ?>
                            </div>
                            <div class="form-group">
                               <label>Kecamatan</label><label class="text-danger text-lg">*</label>
                                <select name="wilayah_kec" class="wilayah_kec form-control" id="wilayah_kec">
                                    <option value="">--Pilih Kecamatan--</option>
                                </select>
                               <?php echo form_error('wilayah_kec'); ?>
                            </div>
                            <div class="form-group">
                               <label>Kelurahan/Desa</label><label class="text-danger text-lg">*</label>
                                <select name="wilayah_desa" class="wilayah_desa form-control" id="wilayah_desa">
                                    <option value="">--Pilih Kelurahan/Desa--</option>
                                </select>
                               <?php echo form_error('wilayah_desa'); ?>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Nama</label><label class="text-danger text-lg">*</label>
                                    <!-- <input type="hidden" name="id_keanggotaan" class="form-control" value="<?= $keanggotaan['id_keanggotaan']?>" > -->
                                    <input type="text" name="nama" class="form-control" value="<?= set_value('nama')?>">
                                    <?php echo form_error('nama'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Tempat Lahir</label><label class="text-danger text-lg">*</label>
                                <input type="text" name="tempat_lahir" class="form-control" value="<?= set_value('tempat_lahir')?>">
                                <?php echo form_error('tempat_lahir'); ?>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Lahir</label><label class="text-danger text-lg">*</label>
                                <input type="date" name="tgl_lahir" class="form-control" value="<?= set_value('tanggal_lahir')?>">
                                <?php echo form_error('tgl_lahir'); ?>
                            </div>
                            <div class="form-group">
                                <label>No KTP</label><label class="text-danger text-lg">*</label>
                                <input type="text" name="no_ktp" class="form-control" value="<?= set_value('no_ktp')?>">
                                <?php echo form_error('no_ktp'); ?>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label><label class="text-danger text-lg">*</label>
                                <input type="text" name="alamat" class="form-control" value="<?= set_value('alamat')?>">
                                <?php echo form_error('alamat'); ?>
                            </div>
                            <div class="form-group">
                                <label>NO HP</label><label class="text-danger text-lg">*</label>
                                <input type="text" name="no_hp" class="form-control" value="<?= set_value('no_hp')?>">
                                <?php echo form_error('no_hp'); ?>
                            </div>
                            <div class="form-group">
                            <label>Agama</label><label class="text-danger text-lg">*</label>
                               <select name="agama" class="form-control">
                                    <option value="">--Pilih Agama--</option>
                                    <option value="Islam" >Islam</option>
                                    <option value="Kristen" >Kristen</option>
                                    <option value="Katholik" >Katholik</option>
                                    <option value="Hindu" >Hindu</option>
                                    <option value="Budha" >Budha</option>
                                    <option value="Konghucu" >Konghucu</option>
                               </select>
                               <?php echo form_error('agama'); ?>
                            </div>
                            <div class="form-group">
                                <label>Email</label><label class="text-danger text-lg">*</label>
                                <input type="text" name="email" class="form-control" value="<?= set_value('email')?>">
                                <?php echo form_error('email'); ?>
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin</label><label class="text-danger text-lg">*</label>
                                <select name="jenis_kelamin" class="form-control">
                                    <option value="">--Pilih Jenis Kelamin--</option>
                                    <option value="Laki-laki" >Laki-laki</option>
                                    <option value="Perempuan" >Perempuan</option>
                                </select>
                                <?php echo form_error('jenis_kelamin'); ?>
                            </div>
                            <div class="form-group">
                                <label>Status Perkawinan</label><label class="text-danger text-lg">*</label>
                                <select name="status_perkawinan" class="form-control" id="status_perkawinan"  onchange="tampilkan()">
                                    <option value="" >--Pilih Status Perkawinan--</option>
                                    <option value="Menikah" >Menikah</option>
                                    <option value="Belum Menikah" >Belum Menikah</option>
                                    <option value="Pernah Menikah" >Pernah Menikah</option>
                                </select>
                                <?php echo form_error('status_perkawinan'); ?>
                            </div>
                            <div id="tampilkan">
                                
                            </div>
                            <div class="form-group">
                                <label>Latar Belakang Pendidikan</label>
                                <input type="text" name="latar_pendidikan" class="form-control" value="<?= set_value('latar_pendidikan')?>">
                            </div>
                            <div class="form-group">
                                <label>Latar Belakang Organisasi</label>
                                <input type="text" name="latar_organisasi" class="form-control" value="<?= set_value('latar_organisasi')?>">
                            </div>
                            <div class="form-group">
                                <label>Latar Belakang Pekerjaan</label>
                                <input type="text" name="latar_pekerjaan" class="form-control" value="<?= set_value('latar_pekerjaan')?>">
                            </div>

                            <button type="submit" class="btn btn-primary">Daftar</button>
                       </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-3.5.1.min.js'?>"></script>

<script>
        $(document).ready(function(){
            $("#wilayah_kab").change(function (){
                var url = "<?php echo site_url('calon/daftar/getWilayahKecamatan');?>/"+$(this).val();
                $('#wilayah_kec').load(url);
                return false;
            })  

            $("#wilayah_kec").change(function (){
                var url = "<?php echo site_url('calon/daftar/getWilayahDesa');?>/"+$(this).val();
                $('#wilayah_desa').load(url);
                return false;
            })  
        });
</script>

<script type ="text/javascript">
    $('#status_perkawinan').change(function(){
			//alert($(this).val());
			if ($(this).val() == "Menikah") {
				document.getElementById("tampilkan").innerHTML=`<div class="form-group">
                                    <label>Nama Istri / Suami</label>
                                    <input type="text" name="nama_istri_suami" class="form-control" value="<?= set_value('nama_istri_suami')?>">
                                </div>
                                <div class="form-group">
                                    <label>Jumlah Anak</label>
                                    <select name="nama_anak" class="form-control">
                                        <option value="">--Pilih Jumlah Anak--</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                    </select>
                                </div>` 
			} else if ($(this).val() == "Belum Menikah") {
				document.getElementById("tampilkan").innerHTML="";
			} else if ($(this).val() == "Pernah Menikah") {
				document.getElementById("tampilkan").innerHTML="";
			} else {
                document.getElementById("tampilkan").innerHTML="";
            }
		});
</script>

<!-- jQuery -->
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>assets/dist/js/adminlte.min.js"></script>
</body>
</html>
