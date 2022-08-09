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
              <?php foreach($data as $row) : ?>
              <li class="breadcrumb-item active"><?= $row['nm_kab'] ?></li>
              <?php endforeach; ?>
            </ol>
          </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<div class="container ml-2">
    <?= $this->session->flashdata('pesan') ?>
    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahKepengurusanSatgas">+ Tambah Data Kepengurusan Satgas</a>
</div>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <?php foreach($data as $row) : ?>
                        <h3 class="card-title">Susunan Kepengurusan <?= $row['nm_kab'] ?></h3>
                    <?php endforeach; ?>
                </div>
                <div class="card-body col-md-8 mx-auto">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" width="20px">#</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Jabatan</th>
                                <th class="text-center">No HP</th>
                                <th class="text-center" width="100px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($kepengurusan as $kp) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $kp['nama']?></td>
                                <td><?= $kp['nama_jabatan']?></td>
                                <td><?= $kp['no_hp']?></td>
                                <td>
                                <?php if($user['level'] == 'Super Admin') : ?>
                                    <a href="<?= base_url('satgas/editKepengurusan/').$kp['id_pengurus_satgas'] ?>" class="btn btn-warning btn-md">
                                        Edit
                                    </a>
                                    <a href="<?= base_url('satgas/hapusKepengurusan/').$kp['id_pengurus_satgas'] ?>" class="btn btn-danger btn-md" onclick="return confirm('Apakah yakin anda ingin menghapus data ini?')">
                                        Hapus
                                    </a>
                                <?php elseif($user['level'] == 'Admin' ) : ?>
                                    <a href="<?= base_url('satgas/editKepengurusan/').$kp['id_pengurus_satgas'] ?>" class="btn btn-warning btn-md">
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
<div class="modal fade" id="tambahKepengurusanSatgas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Kepengurusan Satgas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('satgas/tambah_kepengurusan_proses') ?>" method="post">
            <div class="form-group">
                <label>Kabupaten/Kota</label>
                <?php foreach($data as $row) : ?>
                <input type="hidden" name="dpc_kab_kota" value="<?= $row['id_kab']?>">
                <select class="form-control" disabled>
                    <option value="<?= $row['id_kab']?>"><?= $row['nm_kab']?></option>
                </select>
                <?php endforeach; ?>
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