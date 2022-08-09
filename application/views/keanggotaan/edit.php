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
              <li class="breadcrumb-item active">Edit</li>
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
                    <img src="<?= base_url('uploads/').$keanggotaan['foto_profil'] ?>" class="card-img-top card-img img-circle img-thumbnail mx-auto mt-2" style="max-width: 140px;">
                    <hr>
                    <div class="card-body">
                        <form method="post" action="<?= base_url('keanggotaan/edit_proses/'.$keanggotaan['id_keanggotaan']) ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Ubah Foto Profil</label>
                                <input type="file" name="foto_profil" class="form-control">
                                <input type="hidden" name="foto_profil_lama" class="form-control" value="<?= $keanggotaan['foto_profil']?>">
                            </div>
                            <div class="form-group">
                                <label>Ubah Foto KTP</label>
                                <input type="file" name="foto_ktp" class="form-control">
                                <input type="hidden" name="foto_ktp_lama" class="form-control" value="<?= $keanggotaan['foto_ktp']?>">
                            </div>
                            <div class="form-group">
                               <label>Kabupaten/Kota</label><label class="text-danger text-lg">*</label>
                               <select name="dpc_kab_kota" class="form-control" id="wilayah_kab">
                                    <option value="">--Pilih Kabupaten/Kota--</option>
                                    <?php foreach($wilayahKab as $wk) : ?>
                                        <?php if($wk['id_kab'] == $keanggotaan['id_kab']) : ?>
                                            <option value="<?= $keanggotaan['id_kab'] ?>" selected><?= $keanggotaan['nm_kab']?></option>
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
                                    <?php foreach($wilayahKec as $wk) : ?>
                                        <?php if($wk['id_kec'] == $keanggotaan['id_kec']) : ?>
                                            <option value="<?= $keanggotaan['id_kec'] ?>" selected><?= $keanggotaan['nm_kec']?></option>
                                        <?php else : ?>
                                            
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <?= $keanggotaan['nm_kec']?>
                                </select>
                               <?php echo form_error('wilayah_kec'); ?>
                            </div>
                            <div class="form-group">
                               <label>Kelurahan/Desa</label><label class="text-danger text-lg">*</label>
                                <select name="wilayah_desa" class="wilayah_desa form-control" id="wilayah_desa">
                                    <option value="">--Pilih Kelurahan/Desa--</option>
                                    <?php foreach($wilayahDesa as $wd) : ?>
                                        <?php if($wd['id_desa'] == $keanggotaan['id_desa']) : ?>
                                            <option value="<?= $keanggotaan['id_desa'] ?>" selected><?= $keanggotaan['nm_desa']?></option>
                                        <?php else : ?>
                                            
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <?= $keanggotaan['nm_desa']?>
                                </select>
                               <?php echo form_error('wilayah_desa'); ?>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Nama</label>
                                    <!-- <input type="hidden" name="id_keanggotaan" class="form-control" value="<?= $keanggotaan['id_keanggotaan']?>" > -->
                                    <input type="text" name="nama" class="form-control" value="<?= $keanggotaan['nama']?>" >
                                    <?php echo form_error('nama'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" value="<?= $keanggotaan['tempat_lahir']?> ">
                                <?php echo form_error('tempat_lahir'); ?>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" class="form-control" value="<?= $keanggotaan['tgl_lahir']?>">
                                <?php echo form_error('tgl_lahir'); ?>
                            </div>
                            <div class="form-group">
                                <label>No KTP</label>
                                <input type="text" name="no_ktp" class="form-control" value="<?= $keanggotaan['no_ktp']?>" >
                                <?php echo form_error('no_ktp'); ?>
                            </div>
                            <div class="form-group">
                                <label>No KTA</label>
                                <?  $id_kta = preg_replace("/[^0-9]/", "", ($keanggotaan['id_desa']));
                                    $id_kta2 = date('d-m-Y', strtotime($keanggotaan['tgl_lahir'])); 
                                    $sub_kta = substr($id_kta,2,-4);
                                    $sub_kta2 = preg_replace("/[^0-9]/", "",($id_kta2));
                                ?>
                                <input type="text" name="no_kta" class="form-control" value="114<?php echo $sub_kta, $sub_kta2, $keanggotaan['id_keanggotaan']?>" readonly="">
                                <?php echo form_error('no_kta'); ?>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" name="alamat" class="form-control" value="<?= $keanggotaan['alamat']?>" >
                                <?php echo form_error('alamat'); ?>
                            </div>
                            <div class="form-group">
                                <label>NO HP</label>
                                <input type="text" name="no_hp" class="form-control" value="<?= $keanggotaan['no_hp']?>" >
                                <?php echo form_error('no_hp'); ?>
                            </div>
                            <div class="form-group">
                            <label>Agama</label>
                               <select name="agama" class="form-control">
                                    <option value="">--Pilih Agama--</option>
                                    <option value="Islam" <?php if($keanggotaan['agama'] == 'Islam'){echo "selected";} ?> >Islam</option>
                                    <option value="Kristen" <?php if($keanggotaan['agama'] == 'Kristen'){echo "selected";} ?> >Kristen</option>
                                    <option value="Katholik" <?php if($keanggotaan['agama'] == 'Katholik'){echo "selected";} ?> >Katholik</option>
                                    <option value="Hindu" <?php if($keanggotaan['agama'] == 'Hindu'){echo "selected";} ?> >Hindu</option>
                                    <option value="Budha" <?php if($keanggotaan['agama'] == 'Budha'){echo "selected";} ?> >Budha</option>
                                    <option value="Konghucu" <?php if($keanggotaan['agama'] == 'Konghucu'){echo "selected";} ?> >Konghucu</option>
                               </select>
                               <?php echo form_error('agama'); ?>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control" value="<?= $keanggotaan['email']?>" >
                                <?php echo form_error('email'); ?>
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-control">
                                    <option value="">--Pilih Jenis Kelamin--</option>
                                    <option value="Laki-laki" <?php if($keanggotaan['jenis_kelamin'] == 'Laki-laki'){echo "selected";} ?> >Laki-laki</option>
                                    <option value="Perempuan" <?php if($keanggotaan['jenis_kelamin'] == 'Perempuan'){echo "selected";} ?> >Perempuan</option>
                                </select>
                                <?php echo form_error('jenis_kelamin'); ?>
                            </div>
                            <div class="form-group">
                                <label>Status Perkawinan</label>
                                <select name="status_perkawinan" class="form-control" id="status_perkawinan"  onchange="tampilkan()">
                                    <option value="" >--Pilih Status Perkawinan--</option>
                                    <option value="Menikah" <?php if($keanggotaan['status_perkawinan'] == 'Menikah'){echo "selected";} ?> >Menikah</option>
                                    <option value="Belum Menikah" <?php if($keanggotaan['status_perkawinan'] == 'Belum Menikah'){echo "selected";} ?> >Belum Menikah</option>
                                    <option value="Pernah Menikah" <?php if($keanggotaan['status_perkawinan'] == 'Pernah Menikah'){echo "selected";} ?> >Pernah Menikah</option>
                                </select>
                                <?php echo form_error('status_perkawinan'); ?>
                            </div>
                            <?php if($keanggotaan['status_perkawinan'] == 'Menikah'){
                                echo '
                                <div class="form-group">
                                    <label>Nama Istri / Suami</label>
                                    <input type="text" name="nama_istri_suami" class="form-control" value="'.$keanggotaan['nama_istri_suami'].'".>
                                    '.form_error('nama_istri_suami').'
                                </div>
                                ';}?>
                                <?php if($keanggotaan['nama_anak'] == TRUE){
                                echo '
                                <div class="form-group">
                                    <label>Jumlah Anak</label>
                                    <select name="nama_anak" class="form-control">
                                        <option value="'.$keanggotaan['nama_anak'].'" "selected">'.$keanggotaan['nama_anak'].'</option>
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
                                </div>
                                ';}?>
                                
                            <div id="tampilkan">
                                
                            </div>
                            <div class="form-group">
                                <label>Latar Belakang Pendidikan</label>
                                <input type="text" name="latar_pendidikan" class="form-control" value="<?= $keanggotaan['latar_pendidikan']?>" >
                            </div>
                            <div class="form-group">
                                <label>Jenis Belakang Organisasi</label>
                                <input type="text" name="latar_organisasi" class="form-control" value="<?= $keanggotaan['latar_organisasi']?>" >
                            </div>
                            <div class="form-group">
                                <label>Status Belakang Pekerjaan</label>
                                <input type="text" name="latar_pekerjaan" class="form-control" value="<?= $keanggotaan['latar_pekerjaan']?>" >
                            </div>
                            <button type="submit" class="btn btn-primary">Ubah Data</button>
                       </form>
                    </div> 
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card mb-3 mx-auto">
                    <img src="<?= base_url('uploads/').$keanggotaan['foto_ktp'] ?>" class="card-img-top card-img img-thumbnail mx-auto mt-2" style="max-width: 300px;">
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-3.5.1.min.js'?>"></script>

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


