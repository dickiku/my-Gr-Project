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
              <li class="breadcrumb-item active">Kecamatan</li>
            </ol>
          </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<div class="container ml-2 mb-2">
    <?= $this->session->flashdata('pesan') ?>
</div>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tabel Wilayah Desa</h3>
                </div>
                <div class="card-body col-md-8 mx-auto">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10px;">#</th>
                                <th class="text-center">Nama Kab/Kota</th>
                                <th class="text-center">Nama Kecamatan</th>
                                <th class="text-center">Nama Desa</th>
                                <th class="text-center">Admin</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($data as $row ) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['nm_kab'] ?></td>
                                <td><?= $row['nm_kec'] ?></td>
                                <td><?= $row['nm_desa'] ?></td>
                                <td><?= $row['admin'] ?></td>
                                <td>
                                <?php if($user['level'] == 'Super Admin') : ?>
                                    <a href="<?= base_url('ranting/detailRanting/').$row['id_ranting'] ?>" class="btn btn-success btn-md">
                                        Detail
                                    </a>
                                    <a href="<?= base_url('ranting/hapus/').$row['id_ranting'] ?>" class="btn btn-danger btn-md" onclick="return confirm('Apakah yakin anda ingin menghapus data ini?')">
                                        Hapus
                                    </a>
                                <?php elseif($user['level'] == 'Admin' ) : ?>
                                    <a href="<?= base_url('ranting/detailRanting/').$row['id_ranting'] ?>" class="btn btn-success btn-md">
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