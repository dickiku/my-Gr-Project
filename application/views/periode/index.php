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
              <li class="breadcrumb-item active">DATA Periode Pemilu</li>
            </ol>
          </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<div class="container ml-2">
    <a href=" " class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahPeriodePemilu">+ Tambah Data Periode Pemilu</a>
</div>
<div class="container ml-2 mb-2">
    <?= $this->session->flashdata('pesan') ?>
</div>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Periode Pemilu</h3>
                </div>
                <div class="card-body col-md-12 mx-auto">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" width="20px">No</th>
                                <th class="text-center" >Periode</th>
                                <th class="text-center" width="200px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($periode as $row): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row['periode'] ?></td>
                                        <td>
                                        <?php if($user['level'] == 'Super Admin') : ?>
                                            <a href="<?= base_url('periode/showEdit/'.$row['id_periode_pemilu']) ?>" class="btn btn-info btn-md">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a href="<?= base_url('periode/delete_periode/'.$row['id_periode_pemilu']) ?>" class="btn btn-danger btn-md" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus');" >
                                                <i class="fa fa-trash"></i> Hapus
                                            </a>
                                        <?php elseif($user['level'] == 'Admin' ) : ?>
                                            <a href="<?= base_url('periode/showEdit/'.$row['id_periode_pemilu']) ?>" class="btn btn-info btn-md">
                                                <i class="fa fa-edit"></i> Edit
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

<!-- Modal Tambah-->
<div class="modal fade" id="tambahPeriodePemilu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Periode Pemilu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('periode/tambah_periode/') ?>" method="post">
            <div class="form-group">
                <label>Periode Pemilu</label><label class="text-danger text-lg">*</label>
                <input type="text" name="periode" value="" class="form-control" required="required">
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