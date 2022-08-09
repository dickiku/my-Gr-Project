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

<div class="container ml-2 mb-2">
    <?= $this->session->flashdata('pesan') ?>
</div>

<button type="button" class="btn btn-primary ml-3 mb-3" data-toggle="modal" data-target="#exampleModal">
  + Tambah Data
</button>

<!-- <div class="container ml-2">
    <a href="<?= base_url('fraksi_gerindra/tambahKepengurusanKabupaten') ?>" class="btn btn-primary mb-3">+ Tambah Data</a>
</div> -->

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tabel Wilayah Kabupaten/Kota</h3>
                </div>
                <div class="card-body col-md-8 mx-auto">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10px;">#</th>
                                <th class="text-center">Nama Kab/Kota</th>
                                <th class="text-center">Tenaga Ahli</th>
                                <th class="text-center" style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($data as $row) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['nm_kab'] ?></td>
                                <td><?= $row['tenaga_ahli'] ?></td>
                                <td>
                                <?php if($user['level'] == 'Super Admin') : ?>
                                    <a href="<?= base_url('fraksi_gerindra/detailFraksiGerindra/').$row['id_fraksi_gerindra'] ?>" class="btn btn-success btn-md">
                                        Detail
                                    </a>
                                    <a href="<?= base_url('fraksi_gerindra/hapusDataFraksi/').$row['id_fraksi_gerindra'] ?>" class="btn btn-danger btn-md" onclick="return confirm('Apakah yakin anda ingin menghapus data ini?')">
                                        Hapus
                                    </a>
                                <?php elseif($user['level'] == 'Admin' ) : ?>
                                    <a href="<?= base_url('fraksi_gerindra/detailFraksiGerindra/').$row['id_fraksi_gerindra'] ?>" class="btn btn-success btn-md">
                                        Detail
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pengurus Fraksi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?= base_url('fraksi_gerindra/tambahPengurus_proses_kabupaten') ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label>Kabupaten/Kota</label>
                <?php foreach($wilayahKab as $wk) : ?>
                <input type="hidden" name="id_kab" class="form-control" value="<?= $wk['id_kab']?>">
                <input type="text" class="form-control" value="<?= $wk['nm_kab'] ?>" disabled>
                <?php endforeach; ?>
            </div>
            <div class="form-group">
                <label>Nama Fraksi</label><label class="text-danger text-lg">*</label>
                <input type="text" name="nama_fraksi" class="form-control" value="<?= set_value('nama_fraksi')?>">
                <?php echo form_error('nama_fraksi'); ?>
            </div>
            <div class="form-group">
                <label>Alamat</label><label class="text-danger text-lg">*</label>
                <input type="text" name="alamat" class="form-control" value="<?= set_value('alamat')?>">
                <?php echo form_error('alamat'); ?>
            </div>
            <div class="form-group">
                <label>No. Telp</label><label class="text-danger text-lg">*</label>
                <input type="text" name="no_telp" class="form-control" value="<?= set_value('no_telp')?>">
                <?php echo form_error('no_telp'); ?>
            </div>
            <div class="form-group">
                <label>Tenaga Ahli</label><label class="text-danger text-lg">*</label>
                <input type="text" name="tenaga_ahli" class="form-control" value="<?= set_value('tenaga_ahli')?>">
                <?php echo form_error('tenaga_ahli'); ?>
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
      </div>
    </div>
  </div>
</div>