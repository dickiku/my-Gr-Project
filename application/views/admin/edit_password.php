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
                    <div class="card-body">
                    <?php foreach($data as $row) : ?>
                        <form method="post" action="<?= base_url('admin/manajemen_admin/edit_password_proses/'.$row['id_user']) ?>" enctype="multipart/form-data">
                    <?php endforeach; ?> 
                            <div class="form-group">
                                <label>Password Lama</label><label class="text-danger text-lg">*</label>
                                <input type="password" name="password_lama" class="form-control" placeholder="Masukkan Password Lama">
                                <?php echo form_error('password_lama'); ?>
                            </div>
                            <div class="form-group">
                                <label>Password Baru</label><label class="text-danger text-lg">*</label>
                                <input type="password" name="password_baru" class="form-control" placeholder="Masukkan Password Baru">
                                <?php echo form_error('password_baru'); ?>
                            </div>
                            <div class="form-group">
                                <label>Konfirmasi Password Baru</label><label class="text-danger text-lg">*</label>
                                <input type="password" name="password_baru_2" class="form-control" placeholder="Masukkan Konfirmasi Password Baru">
                                <?php echo form_error('password_baru_2'); ?>
                            </div>
                            <button type="submit" class="btn btn-primary">Ubah Data</button>
                        </form>
                    
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>