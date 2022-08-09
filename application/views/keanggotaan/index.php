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
    <a href="<?= base_url('keanggotaan/tambah/')?>" class="btn btn-success">Tambah +</a>
</div>

<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card" width="600px">
                    <div class="card-header">
                        <h3 class="card-title">Tabel Keanggotaan</h3>
                    </div>
                    <div class="card-body col-md-12">
                        <table id="example1" class="ui celled table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Email</th>
                                    <th>No HP</th>
                                    <?php if($user['level'] == 'Super Admin') { ?>
                                    <th>Wilayah</th>
                                    <?php } else { } ?>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($user['id_kab']) { ?>
                                    <?php $no=1; foreach($keanggotaanByKab as $row ) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row->nama ?></td>
                                        <td><?= $row->alamat ?></td>
                                        <td><?= $row->email ?></td>
                                        <td><?= $row->no_hp ?></td>
                                        <td>
                                            <?php if($user['level'] == 'Super Admin') : ?>
                                                <a href="<?= base_url('keanggotaan/detail/').base64_encode($row->id_keanggotaan) ?>" class="btn btn-success btn-xs">Detail</a>
                                                <a href="<?= base_url('keanggotaan/edit/').$row->id_keanggotaan ?>" class="btn btn-warning btn-xs">Edit</a>
                                                <a href="<?= base_url('keanggotaan/hapus/'). $row->id_keanggotaan ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah yakin anda ingin menghapus data ini?')">Hapus</a>
                                            <?php elseif($user['level'] == 'Admin' ) : ?>
                                                <a href="<?= base_url('keanggotaan/detail/').$row->id_keanggotaan ?>" class="btn btn-success btn-xs">Detail</a>
                                                <a href="<?= base_url('keanggotaan/edit/'). base64_encode($row->id_keanggotaan) ?>" class="btn btn-warning btn-xs">Edit</a>
                                            <?php endif;?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php } else { ?>
                                    <?php $no=1; foreach($keanggotaan as $row ) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row->nama ?></td>
                                        <td><?= $row->alamat ?></td>
                                        <td><?= $row->email ?></td>
                                        <td><?= $row->no_hp ?></td>
                                        <td><?= $row->nm_kab ?></td>
                                        <td>
                                            <?php if($user['level'] == 'Super Admin') : ?>
                                                <a href="<?= base_url('keanggotaan/detail/').base64_encode($row->id_keanggotaan) ?>" class="btn btn-success btn-xs">Detail</a>
                                                <a href="<?= base_url('keanggotaan/edit/').$row->id_keanggotaan ?>" class="btn btn-warning btn-xs">Edit</a>
                                                <a href="<?= base_url('keanggotaan/hapus/'). $row->id_keanggotaan ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah yakin anda ingin menghapus data ini?')">Hapus</a>
                                            <?php elseif($user['level'] == 'Admin' ) : ?>
                                                <a href="<?= base_url('keanggotaan/detail/').$row->id_keanggotaan ?>" class="btn btn-success btn-xs">Detail</a>
                                                <a href="<?= base_url('keanggotaan/edit/'). base64_encode($row->id_keanggotaan) ?>" class="btn btn-warning btn-xs">Edit</a>
                                            <?php endif;?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


  
