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
                    <!-- <hr> -->
                    <div class="card-body">
                        <form method="post" action="<?= base_url('dpd/tambah_proses') ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea name="alamat" class="form-control" cols="3" rows="3"></textarea>
                                <?php echo form_error('alamat'); ?>
                            </div>
                            <div class="form-group">
                                <label>No. Telp</label>
                                <input type="text" name="no_telp" class="form-control" value="<?= set_value('no_telp')?>">
                                <?php echo form_error('no_telp'); ?>
                            </div>
                            <div class="form-group">
                                <label>No. SK</label>
                                <input type="text" name="no_sk" class="form-control" value="<?= set_value('no_sk')?>">
                                <?php echo form_error('no_sk'); ?>
                            </div>
                            <div class="form-group">
                                <label>Tanggal SK</label>
                                <input type="date" name="tanggal_sk" class="form-control" value="<?= set_value('tanggal_sk')?>">
                                <?php echo form_error('tanggal_sk'); ?>
                            </div>
                            <div class="form-group">
                                <label>Admin</label>
                                <input type="text" name="admin" class="form-control" value="<?= set_value('admin')?>">
                                <?php echo form_error('admin'); ?>
                            </div>
                            <div class="form-group">
                                <label>Scan SK</label>
                                <input type="file" name="scan_sk" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Foto Kantor Luar Dalam</label>
                                <input type="file" name="foto_kantor" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary">Tambah</button>
                       </form>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>