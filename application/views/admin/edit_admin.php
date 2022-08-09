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
              <li class="breadcrumb-item active">Edit Admin</li>
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
                        <form method="post" action="<?= base_url('admin/manajemen_admin/edit_admin_proses/'.$row['id_user']) ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>NIK</label>
                                <input type="text" name="nik" class="form-control" value="<?= $row['nik'] ?>">
                                <?php echo form_error('nik'); ?>
                            </div>
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="nama" class="form-control" value="<?= $row['nama'] ?>">
                                <?php echo form_error('nama'); ?>
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select name="jenis_kelamin"class="form-control">
                                    <option value="">--Pilih Jenis Kelamin--</option>
                                    <option value="Laki-laki" <?php if($row['jenis_kelamin'] == 'Laki-laki'){echo "selected";} ?> >Laki-laki</option>
                                    <option value="Perempuan" <?php if($row['jenis_kelamin'] == 'Perempuan'){echo "selected";} ?> >Perempuan</option>
                                </select>
                                <?php echo form_error('jenis_kelamin'); ?>
                            </div>
                            <?php if($user['level'] == 'Super Admin') : ?>
                            <div class="form-group">
                                <label>Level Admin</label>
                                <select name="level" class="form-control">
                                    <option value="">--Pilih Level Admin--</option>
                                    <option value="Admin" <?php if($row['level'] == 'Admin'){echo "selected";} ?> >Admin</option>
                                    <option value="Super Admin" <?php if($row['level'] == 'Super Admin'){echo "selected";} ?> >Super Admin</option>
                                </select>
                                <?php echo form_error('level'); ?>
                            </div>
                            <?php endif; ?>
                            <button type="submit" class="btn btn-primary">Ubah Data</button>
                       </form>
                    <?php endforeach; ?>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>