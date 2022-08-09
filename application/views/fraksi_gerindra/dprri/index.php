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

<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
            <?= $this->session->flashdata('pesan') ?>
                <div class="card mb-3 mx-auto">
                    <div class="card-body">
                        <?php foreach($data as $row) : ?>
                            <a href="<?= base_url('fraksi_gerindra/editRi/').$row['id_fraksi_gerindra'] ?>" class="btn btn-lg btn-warning mb-2">Edit</a>
                        <?php endforeach; ?>
                        <table class="table table-bordered table-striped table-hover" id="myTable">
                            <tbody>
                                <?php foreach($data as $row) : ?>
                                <tr>
                                    <td><strong>Nama Fraksi</strong></td>
                                    <td><?= $row['nama_fraksi'] ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Alamat</strong></td>
                                    <td><?= $row['alamat']?></td>
                                </tr>
                                <tr>
                                    <td><strong>No. Telp</strong></td>
                                    <td><?= $row['no_telp']?></td>
                                </tr>
                                <tr>
                                    <td><strong>Tenaga Ahli</strong></td>
                                    <td><?= $row['tenaga_ahli']?></td>
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

<div class="container ml-2">
    <a href="<?= base_url('fraksi_gerindra/tambahKepengurusanRi') ?>" class="btn btn-primary mb-3">+ Tambah Data</a>
</div>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Susunan Kepengurusan Fraksi Gerindra DPR RI</h3>
                </div>
                <div class="card-body col-md-12 mx-auto">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" width="20px">#</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Jabatan Fraksi</th>
                                <th class="text-center">Jabatan AKD</th>
                                <th class="text-center">Jabatan AKD Lain</th>
                                <th class="text-center">Perolehan Suara</th>
                                <th class="text-center" width="100px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no=1; foreach($kepengurusan as $kp) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $kp['nama'] ?></td>
                                <td><?= $kp['nama_jabatan_fraksi'] ?></td>
                                <td><?= $kp['nama_jabatan_3'] ?></td>
                                <td><?= $kp['nama_jabatan_lama'] ?></td>
                                <td><?= $kp['perolehan_suara'] ?></td>
                                <td>
                                <?php if($user['level'] == 'Super Admin') : ?>
                                    <a href="<?= base_url('fraksi_gerindra/editKepengurusanRi/').$kp['id_pengurus_fraksi_gerindra'] ?>" class="btn btn-warning btn-md">
                                        Edit
                                    </a>
                                    <a href="<?= base_url('fraksi_gerindra/hapusKepengurusanRi/').$kp['id_pengurus_fraksi_gerindra'] ?>" class="btn btn-danger btn-md" onclick="return confirm('Apakah yakin anda ingin menghapus data ini?')">
                                        Hapus
                                    </a>
                                <?php elseif($user['level'] == 'Admin' ) : ?>
                                    <a href="<?= base_url('fraksi_gerindra/editKepengurusanRi/').$kp['id_pengurus_fraksi_gerindra'] ?>" class="btn btn-warning btn-md">
                                        Edit
                                    </a>
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
</section>