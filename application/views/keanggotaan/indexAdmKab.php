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
    <a href="<?= base_url('keanggotaan/tambah') ?>" class="btn btn-primary mb-3">+ Tambah Anggota</a>
</div>
<div class="container ml-2 mb-2">
    <?= $this->session->flashdata('pesan') ?>
</div>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tabel Wilayah</h3>
                </div>
                <div class="card-body col-md-4 mx-auto">
                    <table id="example1" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10px;">#</th>
                                <th>Wilayah</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($wilayahKab as $row ) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row->nm_kab ?></td>
                                <td>
                                    <a href="<?= base_url('keanggotaan/keanggotaan/'). $row->id_kab ?>" class="btn btn-primary btn-md">
                                        Tab
                                    </a>
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