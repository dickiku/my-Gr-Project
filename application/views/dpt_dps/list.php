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
              <li class="breadcrumb-item active">LIST DPT / DPS</li>
            </ol>
          </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<div class="container ml-2 mb-2">
    <?= $this->session->flashdata('pesan') ?>
</div>
<div class="container ml-2">
    <?php foreach($desa as $des) : ?>
        <?php foreach($tps as $t) : ?>
        <a href="<?= base_url('dpt_dps/showTambahDPT/').$des['id_desa'].'/'.$t['id_tps'] ?>" class="btn btn-primary mb-3" >+ Tambah Data DPT</a>
        <?php endforeach; ?>
    <?php endforeach; ?>
    <!-- <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahDPT">+ Tambah Data DPT</a> -->
</div>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <?php foreach($desa as $des) : ?>
                        <?php foreach($tps as $t) : ?>
                        <h3 class="card-title">LIST DPT Desa <?= $des['nm_desa']?> | <?= $t['nama_tps'] ?></h3>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>
                <div class="card-body col-md-23 mx-auto">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10px;">#</th>
                                <th class="text-center">Tahun</th>
                                <th class="text-center">Laki - Laki</th>
                                <th class="text-center">Perempuan</th>
                                <th class="text-center">Nama Asesor</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($dpt as $tetap): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="text-center"><?= $tetap->tahun ?></td>
                                <!-- <?php $jum = $tetap->laki + $tetap->perempuan ?>
                                <td class="text-center"><?= $jum ?></td> -->
                                <td class="text-center"><?= $tetap->laki ?></td>
                                <td class="text-center"><?= $tetap->perempuan ?></td>
                                <td class="text-center"><?= $tetap->nama;?></td>
                                <td>
                                <?php foreach($desa as $des) : ?>
                                <?php if($user['level'] == 'Super Admin') : ?>
                                    <a href="<?= base_url('dpt_dps/showDetail/'.$tetap->id_dpt. '/' .'1'. '/' .$des['id_desa']) ?>" class="btn btn-success btn-md">
                                        Detail
                                    </a>
                                    <a href="<?= base_url('dpt_dps/showEdit/'.$tetap->id_dpt. '/' .'1'. '/' .$des['id_desa']) ?>" class="btn btn-warning btn-md">
                                        Edit
                                    </a>
                                    <a href="<?= base_url('dpt_dps/hapus/'.$tetap->id_dpt. '/' .'1'. '/' .$des['id_desa'].'/'.$tetap->id_tps) ?>" class="btn btn-danger btn-md" onclick="return confirm('Apakah yakin anda ingin menghapus data ini?')">
                                        Hapus
                                    </a>
                                <?php elseif($user['level'] == 'Admin' ) : ?>
                                    <a href="<?= base_url('dpt_dps/showDetail/'.$tetap->id_dpt. '/' .'1'. '/' .$des['id_desa']) ?>" class="btn btn-success btn-md">
                                        Detail
                                    </a>
                                    <a href="<?= base_url('dpt_dps/showEdit/'.$tetap->id_dpt. '/' .'1'. '/' .$des['id_desa']) ?>" class="btn btn-warning btn-md">
                                        Edit
                                    </a>
                                <?php endif;?>
                                <?php endforeach; ?>
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

<div class="container ml-2">
    <?php foreach($desa as $des) : ?>
        <?php foreach($tps as $t) : ?>
            <a href="<?= base_url('dpt_dps/showTambahDPS/').$des['id_desa'].'/'.$t['id_tps'] ?>" class="btn btn-primary mb-3" >+ Tambah Data DPS</a>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <?php foreach($desa as $des) : ?>
                        <?php foreach($tps as $t) : ?>
                        <h3 class="card-title">LIST DPS Desa <?= $des['nm_desa']?> | <?= $t['nama_tps'] ?></h3>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>
                <div class="card-body col-md-12 mx-auto">
                    <table id="example3" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10px;">#</th>
                                <th class="text-center">Tahun</th>
                                <th class="text-center">Laki - Laki</th>
                                <th class="text-center">Perempuan</th>
                                <th class="text-center">Nama Asesor</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no=1; foreach($dps as $sementara): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="text-center"><?= $sementara->tahun ?></td>
                                <!-- <?php $jum = $sementara->laki + $sementara->perempuan ?>
                                <td class="text-center"><?= $jum ?></td> -->
                                <td class="text-center"><?= $sementara->id_desa ?></td>
                                <td class="text-center"><?= $sementara->perempuan ?></td>
                                <td class="text-center"><?= $sementara->nama ?></td>
                                <td>
                                    <?php foreach($desa as $des) : ?>
                                        <?php if($user['level'] == 'Super Admin') : ?>
                                            <a href="<?= base_url('dpt_dps/showDetail/'.$sementara->id_dps. '/' .'2'. '/'. $des['id_desa']) ?>" class="btn btn-success btn-md">
                                                Detail
                                            </a>
                                            <a href="<?= base_url('dpt_dps/showEdit/'.$sementara->id_dps. '/' .'2'. '/'. $des['id_desa']) ?>" class="btn btn-warning btn-md">
                                                Edit
                                            </a>
                                            <a href="<?= base_url('dpt_dps/hapus/'.$sementara->id_dps. '/' .'2'. '/'. $des['id_desa'].'/'.$sementara->id_tps) ?>" class="btn btn-danger btn-md" onclick="return confirm('Apakah yakin anda ingin menghapus data ini?')">
                                                Hapus
                                            </a>
                                        <?php elseif($user['level'] == 'Admin' ) : ?>
                                            <a href="<?= base_url('dpt_dps/showDetail/'.$sementara->id_dps. '/' .'2'. '/'. $des['id_desa']) ?>" class="btn btn-success btn-md">
                                                Detail
                                            </a>
                                            <a href="<?= base_url('dpt_dps/showEdit/'.$sementara->id_dps. '/' .'2'. '/'. $des['id_desa']) ?>" class="btn btn-warning btn-md">
                                                Edit
                                            </a>
                                        <?php endif;?>
                                    <?php endforeach; ?>
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