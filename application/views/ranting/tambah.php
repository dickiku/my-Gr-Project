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
              <li class="breadcrumb-item active">Tambah Data</li>
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
                        <form method="post" action="<?= base_url('ranting/tambah_proses') ?>" enctype="multipart/form-data">
                            <?php if($user['id_kab']) { ?>
                                <div class="form-group">
                                    <label>Kabupaten/Kota</label>
                                    <select name="dpc_kab_kota" class="form-control" id="wilayah_kab" readonly>
                                        <?php foreach($wilayahKab as $row) : ?>
                                            <option value="<?= $row->id_kab ?>"><?= $row->nm_kab ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php echo form_error('dpc_kab_kota'); ?>
                                </div>
                            <?php } else { ?>
                                <div class="form-group">
                                    <label>Kabupaten/Kota</label>
                                    <select name="dpc_kab_kota" class="form-control" id="wilayah_kab" readonly>
                                        <?php foreach($wilayahKab as $row) : ?>
                                            <option value="<?= $row->id_kab ?>"><?= $row->nm_kab ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php echo form_error('dpc_kab_kota'); ?>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                               <label>Kecamatan</label>
                                <select name="wilayah_kec" class="wilayah_kec form-control" id="wilayah_kec" readonly>
                                    <?php foreach($wilayahKec as $row) : ?>
                                        <option value="<?= $row->id_kec ?>"><?= $row->nm_kec ?></option>
                                    <?php endforeach; ?>
                                </select>
                               <?php echo form_error('wilayah_kec'); ?>
                            </div>
                            <div class="form-group">
                               <label>Kelurahan/Desa</label>
                                <select name="wilayah_desa" class="wilayah_desa form-control" id="wilayah_desa" readonly>
                                    <?php foreach($wilayahDesa as $row) : ?>
                                        <option value="<?= $row->id_desa ?>"><?= $row->nm_desa ?></option>
                                    <?php endforeach; ?>
                                </select>
                               <?php echo form_error('wilayah_desa'); ?>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label><label class="text-danger text-lg">*</label>
                                <textarea name="alamat" class="form-control" cols="3" rows="3"></textarea>
                                <?php echo form_error('alamat'); ?>
                            </div>
                            <div class="form-group">
                                <label>No. Telp</label><label class="text-danger text-lg">*</label>
                                <input type="text" name="no_telp" class="form-control" value="<?= set_value('no_telp')?>">
                                <?php echo form_error('no_telp'); ?>
                            </div>
                            <div class="form-group">
                                <label>No. SK</label><label class="text-danger text-lg">*</label>
                                <input type="text" name="no_sk" class="form-control" value="<?= set_value('no_sk')?>">
                                <?php echo form_error('no_sk'); ?>
                            </div>
                            <div class="form-group">
                                <label>Tanggal SK</label><label class="text-danger text-lg">*</label>
                                <input type="date" name="tanggal_sk" class="form-control" value="<?= set_value('tanggal_sk')?>">
                                <?php echo form_error('tanggal_sk'); ?>
                            </div>
                            <div class="form-group">
                                <label>Admin</label><label class="text-danger text-lg">*</label>
                                <input type="text" name="admin" class="form-control" value="<?= set_value('admin')?>">
                                <?php echo form_error('admin'); ?>
                            </div>
                            <div class="form-group">
                                <label>Link Facebook (Optional)</label>
                                <input type="text" name="link_facebook" class="form-control" value="<?= set_value('link_facebook')?>">
                            </div>
                            <div class="form-group">
                                <label>Link Instagram (Optional)</label>
                                <input type="text" name="link_instagram" class="form-control" value="<?= set_value('link_instagram')?>">
                            </div>
                            <div class="form-group">
                                <label>Link Tiktok (Optional)</label>
                                <input type="text" name="link_tiktok" class="form-control" value="<?= set_value('link_tiktok')?>">
                            </div>
                            <div class="form-group">
                                <label>Scan SK</label><label class="text-danger text-lg">*</label>
                                <input type="file" name="scan_sk" class="form-control">
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
<!-- <script>
        $(document).ready(function(){
            $("#wilayah_kab").change(function (){
                var url = "<?php echo site_url('ranting/getWilayahKecamatan');?>/"+$(this).val();
                $('#wilayah_kec').load(url);
                return false;
            })  

            $("#wilayah_kec").change(function (){
                var url = "<?php echo site_url('ranting/getWilayahDesa');?>/"+$(this).val();
                $('#wilayah_desa').load(url);
                return false;
            })  
        });
</script> -->