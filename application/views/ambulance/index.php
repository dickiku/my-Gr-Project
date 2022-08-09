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
              <li class="breadcrumb-item active"><?= $title ?></li>
            </ol>
          </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary ml-3" data-toggle="modal" data-target="#exampleModal">
  + Tambah Data
</button>
<div class="container ml-2 mb-2 mt-2">
    <?= $this->session->flashdata('pesan') ?>
</div>
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ambulance</h3>
                    </div>
                    <div class="card-body col-md-12">
                        <table id="example1" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th width="20px">#</th>
                                    <th>Nama</th>
                                    <th>No. HP</th>
                                    <th>Plat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <?php $no=1; foreach($data as $row) : ?>
                            <tbody>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['nama'] ?></td>
                                    <td><?= $row['no_hp'] ?></td>
                                    <td><?= $row['plat'] ?></td>
                                    <td width="200px">
                                    <?php if($user['level'] == 'Super Admin') : ?>
                                        <a href="<?= base_url('ambulance/detail/'). $row['id_ambulance'] ?>" class="btn btn-success">Detail</a>
                                        <a href="<?= base_url('ambulance/edit/'). $row['id_ambulance'] ?>" class="btn btn-warning">Edit</a>
                                        <a href="<?= base_url('ambulance/hapus/'). $row['id_ambulance'] ?>" class="btn btn-danger" onclick="return confirm('Apakah yakin anda ingin menghapus data ini?')">Hapus</a>
                                    <?php elseif($user['level'] == 'Admin' ) : ?>
                                        <a href="<?= base_url('ambulance/detail/'). $row['id_ambulance'] ?>" class="btn btn-success">Detail</a>
                                        <a href="<?= base_url('ambulance/edit/'). $row['id_ambulance'] ?>" class="btn btn-warning">Edit</a>
                                    <?php endif;?>
                                    </td>
                                </tr>
                            </tbody>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Ambulance</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?= base_url('ambulance/tambah') ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama</label><label class="text-danger text-lg">*</label>
                <input type="text" class="form-control" name="nama" value="<?= set_value('nama') ?>">
                <?php echo form_error('nama'); ?>
            </div>
            <div class="form-group">
                <label>No. HP</label><label class="text-danger text-lg">*</label>
                <input type="text" class="form-control" name="no_hp" value="<?= set_value('no_hp') ?>">
                <?php echo form_error('no_hp'); ?>
            </div>
            <div class="form-group">
                <label>Plat</label><label class="text-danger text-lg">*</label>
                <input type="text" class="form-control" name="plat" value="<?= set_value('plat') ?>">
                <?php echo form_error('plat'); ?>
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