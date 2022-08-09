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

<div class="container ml-2">
    <?= $this->session->flashdata('pesan') ?>
    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahTogaTomas">+ Tambah Data Toga Tomas</a>
</div>

<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Simpul Jaringan - TOGA TOMAS</h3>
                    </div>
                    <div class="card-body col-md-12">
                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 10px;">#</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Latar Belakang</th>
                                    <th class="text-center">No Telp</th>
                                    <th class="text-center">Alamat</th>
                                    <th class="text-center" style="width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach($data as $row) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row->nama ?></td>
                                    <td><?= $row->ltr_belakang ?></td>
                                    <td><?= $row->no_telp ?></td>
                                    <td><?= $row->alamat ?></td>
                                    <td>
                                    <?php if($user['level'] == 'Super Admin') : ?>
                                        <a href="<?= base_url('simpul_jaringan/editTogaTomasKabupaten/'). $row->id_toga_tomas ?>" class="btn btn-warning btn-md">
                                            Edit
                                        </a>
                                        <a href="<?= base_url('simpul_jaringan/hapusTogaTomasKabupaten/'). $row->id_toga_tomas ?>" class="btn btn-danger btn-md" onclick="return confirm('Apakah yakin anda ingin menghapus data ini?')">
                                            Hapus
                                        </a>
                                    <?php elseif($user['level'] == 'Admin' ) : ?>
                                        <a href="<?= base_url('simpul_jaringan/editTogaTomasKabupaten/'). $row->id_toga_tomas ?>" class="btn btn-warning btn-md">
                                            Edit
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
    </div>
</section>

<!-- Modal Tambah-->
<div class="modal fade" id="tambahTogaTomas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Toga Tomas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('simpul_jaringan/tambah_toga_tomas_kabupaten') ?>" method="post">
        <?php foreach($wilayah as $w) : ?>
            <div class="form-group">
                <label>Kabupaten/Kota</label>
                <input type="hidden" name="id_kab" class="form-control" value="<?= $w['id_kab']?>">
                <input type="text" class="form-control" value="<?= $w['nm_kab']?>" disabled>
                <?= form_error('nama'); ?>
            </div>
        <?php endforeach; ?>
            <div class="form-group">
                <label>Nama</label><label class="text-danger text-lg">*</label>
                <input type="text" name="nama" class="form-control">
                <?= form_error('nama'); ?>
            </div>
            <div class="form-group">
                <label>Latar Belakang</label><label class="text-danger text-lg">*</label>
                <input type="text" name="ltr_belakang" class="form-control">
                <?= form_error('ltr_belakang'); ?>
            </div>
            <div class="form-group">
                <label>No Telepon</label><label class="text-danger text-lg">*</label>
                <input type="text" name="no_telp" class="form-control">
                <?= form_error('no_telp'); ?>
            </div>
            <div class="form-group">
                <label>Alamat</label><label class="text-danger text-lg">*</label>
                <input type="text" name="alamat" class="form-control">
                <?= form_error('alamat'); ?>
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