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
              <li class="breadcrumb-item active">Kabupaten Kota</li>
            </ol>
          </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<div class="container ml-2">
    <?= $this->session->flashdata('pesan') ?>
    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahKepengurusanGmd">+ Tambah Data Kepengurusan GMD</a>
</div>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Susunan Kepengurusan Kabupaten/Kota </h3>
                </div>
                <div class="card-body col-md-8 mx-auto">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" width="20px">#</th>
                                <th class="text-center">Angkatan</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Jabatan</th>
                                <th class="text-center" width="100px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($kepengurusan as $kp) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $kp['nama_angkatan']?></td>
                                <td><?= $kp['nama']?></td>
                                <td><?= $kp['nama_jabatan']?></td>
                                <td>
                                <?php if($user['level'] == 'Super Admin') : ?>
                                    <a href="<?= base_url('gmd/editKepengurusanKabupaten/').$kp['id_pengurus_gmd'] ?>" class="btn btn-warning btn-md">
                                        Edit
                                    </a>
                                    <a href="<?= base_url('gmd/hapusKepengurusanKabupaten/').$kp['id_pengurus_gmd'] ?>" class="btn btn-danger btn-md" onclick="return confirm('Apakah yakin anda ingin menghapus data ini?')">
                                        Hapus
                                    </a>
                                <?php elseif($user['level'] == 'Admin' ) : ?>
                                    <a href="<?= base_url('gmd/editKepengurusanKabupaten/').$kp['id_pengurus_gmd'] ?>" class="btn btn-warning btn-md">
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
</section>

<!-- Modal Tambah-->
<div class="modal fade" id="tambahKepengurusanGmd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Kepengurusan GMD</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('gmd/tambah_kepengurusan_proses_kabupaten') ?>" method="post">
            <div class="form-group">
                <input type="hidden" name="id_prov" value="33">
            </div>
            <div class="form-group">
                <label>Kabupaten/Kota</label>
                <?php foreach($wilayah as $w) : ?>
                <input type="hidden" name="id_kab" value="<?= $w['id_kab']?>" class="form-control">
                <input type="text" value="<?= $w['nm_kab']?>" class="form-control" disabled>
                <?php endforeach; ?>
            </div>
            <div class="form-group">
                <label>Angkatan</label><label class="text-danger text-lg">*</label>
                <select name="id_angkatan" class="form-control">
                    <option value="">--Pilih Angkatan--</option>
                    <?php foreach($angkatan as $a) : ?>
                    <option value="<?= $a['id_angkatan']?>"><?= $a['nama_angkatan']?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Nama Keanggotaan</label><label class="text-danger text-lg">*</label>
                <input list="keanggotaan" name="keanggotaan" class="form-control">
                <datalist id="keanggotaan">
                    <option value="">--Pilih Keanggotaan--</option>
                    <?php if($user['id_kab']) { ?>
                        <?php foreach($keanggotaanKab as $kgk) : ?>
                            <option value="<?= $kgk['id_keanggotaan'] ?>"> 
                                <?= $kgk['nama'] ?> | 
                                <?= $kgk['no_kta'] ?>
                            </option>
                        <?php endforeach; ?>
                    <?php } else { ?>
                        <?php foreach($keanggotaan as $kg) : ?>
                            <option value="<?= $kg['id_keanggotaan'] ?>"> 
                                <?= $kg['nama'] ?> | 
                                <?= $kg['no_kta'] ?>
                            </option>
                        <?php endforeach; ?>
                    <?php } ?>
                </datalist>
                <?php echo form_error('keanggotaan'); ?>
            </div>
            <div class="form-group">
                <label>Jabatan</label><label class="text-danger text-lg">*</label>
                <select class="form-control" name="jabatan">
                    <option value="">--Pilih Jabatan--</option>
                    <?php foreach($jabatan as $jb) : ?>
                        <option value="<?= $jb['id_jabatan'] ?>"><?= $jb['nama_jabatan'] ?></option>
                    <?php endforeach; ?>
                </select>
                <?php echo form_error('jabatan'); ?>
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