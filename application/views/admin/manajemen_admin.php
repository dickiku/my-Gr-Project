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
    <a href="<?= base_url('admin/manajemen_admin/tambah_admin') ?>" class="btn btn-primary mb-3">+ Tambah Admin</a>
</div>
<div class="container ml-2 mb-2">
    <?= $this->session->flashdata('pesan') ?>
</div>
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tabel Manajemen Admin</h3>
                    </div>
                    <div class="card-body col-md-12">
                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="20px">#</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Level</th>
                                    <th>Wilayah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <?php $no=1; foreach($data as $row) : ?>
                            <tbody>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['nik'] ?></td>
                                    <td><?= $row['nama'] ?></td>
                                    <td><?= $row['jenis_kelamin'] ?></td>
                                    <td><?= $row['level'] ?></td>
                                    <td>
                                        <?php if($row['level'] == 'Super Admin') { ?>
                                            -
                                        <?php } else { ?>
                                            <?php foreach($dataa as $dat): ?>
                                                <?php if($dat['id_kab'] == $row['id_kab']){?>
                                                    <?= $dat['nm_kab'] ?>
                                            <?php } else { }?>
                                            <?php endforeach; ?>
                                        <?php } ?>
                                    </td>
                                    <td width="200px">
                                    <?php if($user['level'] == 'Super Admin') : ?>
                                        <a href="<?= base_url('admin/manajemen_admin/edit/'). $row['id_user'] ?>" class="btn btn-warning">Edit</a>
                                        <a href="<?= base_url('admin/manajemen_admin/hapus/'). $row['id_user'] ?>" class="btn btn-danger" onclick="return confirm('Apakah yakin anda ingin menghapus data ini?')">Hapus</a>
                                    <?php elseif($user['level'] == 'Admin' ) : ?>
                                        <a href="<?= base_url('admin/manajemen_admin/edit/'). $row['id_user'] ?>" class="btn btn-warning">Edit</a>
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