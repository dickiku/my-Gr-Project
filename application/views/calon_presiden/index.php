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
<div class="container ml-2 mb-2 mt-2">
    <?= $this->session->flashdata('pesan') ?>
</div>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary ml-3 mb-2" data-toggle="modal" data-target="#exampleModal">
  + Tambah Data
</button>
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Calon Presiden</h3>
                    </div>
                    <div class="card-body col-md-12 mx-auto">
                        <table id="example1" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th width="10px">#</th>
                                    <th>Nama Presiden</th>
                                    <th>Nama Wakil Presiden</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <?php $no=1; foreach($data as $row) : ?>
                            <tbody>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['nama_capres'] ?></td>
                                    <td><?= $row['nama_wapres'] ?></td>
                                    <td width="150px">
                                    <?php if($user['level'] == 'Super Admin') : ?>
                                        <a href="<?= base_url('calon_presiden/edit/'). $row['id_capres'] ?>" class="btn btn-warning">Edit</a>
                                        <a href="<?= base_url('calon_presiden/hapus/'). $row['id_capres'] ?>" class="btn btn-danger" onclick="return confirm('Apakah yakin anda ingin menghapus data ini?')">Hapus</a>
                                    <?php elseif($user['level'] == 'Admin' ) : ?>
                                        <a href="<?= base_url('calon_presiden/edit/'). $row['id_capres'] ?>" class="btn btn-warning">Edit</a>
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
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Capres</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?= base_url('calon_presiden/tambah_proses') ?>" enctype="multipart/form-data">                             
            <div class="form-group">
                <label>Periode</label>
                <?php foreach($periode as $p) : ?>
                  <input type="hidden" class="form-control" name="id_periode_pemilu" value="<?= $p['id_periode_pemilu'] ?>">
                  <input type="text" class="form-control" value="<?= $p['periode'] ?>" disabled>
                <?php endforeach; ?>
            </div>
            <div class="form-group">
                <label>Nama Calon Presiden</label><label class="text-danger text-lg">*</label>
                <input type="text" class="form-control" name="nama_capres" value="<?= set_value('nama_capres') ?>">
                <?php echo form_error('nama_capres'); ?>
            </div>
            <div class="form-group">
                <label>Nama Calon Wakil Presiden</label><label class="text-danger text-lg">*</label>
                <input type="text" class="form-control" name="nama_wapres" value="<?= set_value('nama_wapres') ?>">
                <?php echo form_error('nama_wapres'); ?>
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