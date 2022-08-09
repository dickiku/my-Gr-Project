<?php $user = $this->session->userdata('userdata'); ?>

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
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tabel Wilayah</h3>
                </div>
                <div class="card-body col-md-12 mx-auto">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10px;">#</th>
                                <th>Wilayah</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($user['id_kab']) {  ?>
                                <?php $no=1; foreach($dataById as $row ) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row->nm_kab ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('pilkada/pilgub_showKec/'). $row->id_kab ?>" class="btn btn-primary btn-md">
                                            Tab
                                        </a>
                                        <a href="<?= base_url('pilkada/pilgub_dpt_hak_pilih_kabupaten/'). $row->id_kab ?>" class="btn btn-success btn-md">
                                            DPT Hak Pilih
                                        </a>
                                        <a href="<?= base_url('pilkada/hasil_pilgub_kabupaten/'). $row->id_kab ?>" class="btn btn-info btn-md">
                                            Hasil PILGUB
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php } else { ?>
                                <?php $no=1; foreach($data as $row ) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row->nm_kab ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('pilkada/pilgub_showKec/'). $row->id_kab ?>" class="btn btn-primary btn-md">
                                            Tab
                                        </a>
                                        <a href="<?= base_url('pilkada/pilgub_dpt_hak_pilih_kabupaten/'). $row->id_kab ?>" class="btn btn-success btn-md">
                                            DPT Hak Pilih
                                        </a>
                                        <a href="<?= base_url('pilkada/hasil_pilgub_kabupaten/'). $row->id_kab ?>" class="btn btn-info btn-md">
                                            Hasil PILGUB
                                        </a>
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
</section>