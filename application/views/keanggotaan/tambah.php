
<?php $user = $this->session->userdata('userdata'); ?>

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
              <li class="breadcrumb-item active">Tambah Anggota</li>
            </ol>
          </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container">
    <?= $this->session->flashdata('pesan'); ?>
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3 mx-auto">
                    <!-- <img src="<?= base_url('uploads/').$keanggotaan['foto_profil'] ?>" class="card-img-top card-img img-circle img-thumbnail mx-auto mt-2" style="max-width: 140px;"> -->
                    <hr>
                    <div class="card-body">
                        <form method="post" action="<?= base_url('keanggotaan/tambah_proses') ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Foto Profil</label><label class="text-danger text-lg">*</label>
                                <input type="file" name="foto_profil" class="form-control">
                            </div>
                            <div class="form-group"> 
                                <label>Foto KTP</label><label class="text-danger text-lg">*</label>
                                <input type="file" name="foto_ktp" class="form-control">
                            </div>
                            <?php if($user['id_kab']) { ?>
                                <div class="form-group">
                                    <label>Kabupaten/Kota</label><label class="text-danger text-lg">*</label>
                                    <select name="dpc_kab_kota" class="form-control" id="wilayah_kab">
                                            <option value="">--Pilih Kabupaten/Kota--</option>
                                            <?php foreach($wilayahById as $row) : ?>
                                                <option value="<?= $row->id_kab ?>"><?= $row->nm_kab ?></option>
                                            <?php endforeach; ?>
                                    </select>
                                    <?php echo form_error('dpc_kab_kota'); ?>
                                </div>
                            <?php } else { ?>
                                <div class="form-group">
                                    <label>Kabupaten/Kota</label><label class="text-danger text-lg">*</label>
                                    <select name="dpc_kab_kota" class="form-control" id="wilayah_kab">
                                            <option value="">--Pilih Kabupaten/Kota--</option>
                                            <?php foreach($wilayahKab as $row) : ?>
                                                <option value="<?= $row->id_kab ?>"><?= $row->nm_kab ?></option>
                                            <?php endforeach; ?>
                                    </select>
                                    <?php echo form_error('dpc_kab_kota'); ?>
                                </div>
                            <?php } ?>
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
                            <div class="form-group">
                                <label>Nama</label><label class="text-danger text-lg">*</label>
                                <input type="text" name="nama" class="form-control" value="<?= set_value('nama')?> ">
                                <?php echo form_error('nama'); ?>
                            </div>
                            <div class="form-group">
                                <label>Tempat Lahir</label><label class="text-danger text-lg">*</label>
                                <input type="text" name="tempat_lahir" class="form-control" value="<?= set_value('tempat_lahir')?> ">
                                <?php echo form_error('tempat_lahir'); ?>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Lahir</label><label class="text-danger text-lg">*</label>
                                <input type="date" name="tgl_lahir" class="form-control" value="<?= set_value('tgl_lahir')?> ">
                                <?php echo form_error('tgl_lahir'); ?>
                            </div>
                            <div class="form-group">
                                <label>No KTP</label><label class="text-danger text-lg">*</label>
                                <input type="text" name="no_ktp" class="form-control" value="<?= set_value('no_ktp')?>" id="no_ktp" onkeyup="input()">
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
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katholik">Katholik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Budha">Budha</option>
                                    <option value="Konghucu">Konghucu</option>
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
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                                <?php echo form_error('jenis_kelamin'); ?>
                            </div>
                            <div class="form-group">
                                <label>Status Perkawinan</label><label class="text-danger text-lg">*</label>
                                <select name="status_perkawinan" class="form-control" id="status_perkawinan"  onchange="tampilkan()">
                                    <option value="" >--Pilih Status Perkawinan--</option>
                                    <option value="Menikah" >Menikah</option>
                                    <option value="Belum Menikah">Belum Menikah</option>
                                    <option value="Pernah Menikah">Pernah Menikah</option>
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

                            <button type="submit" class="btn btn-primary">Tambah</button>
                       </form>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-3.5.1.min.js'?>"></script>

<script>
    $(function(){
        input(); 
    });
    
    function input(){
        input1 = $('#no_ktp').val();
        input2 = $('#tgl_lahir').val().slice(0,10).replace(/-/g,"");
        
        var no_kta = input2 + input1;
        $('input[name="no_kta"]').val(no_kta);
    }
</script>



<script>
        $(document).ready(function(){
            $("#wilayah_kab").change(function (){
                var url = "<?php echo site_url('keanggotaan/getWilayahKecamatan');?>/"+$(this).val();
                $('#wilayah_kec').load(url);
                return false;
            })  

            $("#wilayah_kec").change(function (){
                var url = "<?php echo site_url('keanggotaan/getWilayahDesa');?>/"+$(this).val();
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
                                    <?php echo form_error('nama_istri_suami'); ?>
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


