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
                    <h3 class="card-title">Tabel Polri Kecamatan</h3>
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
                            <?php $no=1; foreach($wilayahKec as $row ) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row->nm_kec ?></td>
                                <td>
                                    <a href="<?= base_url('simpul_jaringan/polri_desa/'). $row->id_kec ?>" class="btn btn-primary btn-md">
                                        Tab
                                    </a>
                                    <a href="<?= base_url('simpul_jaringan/polri_cek_kec/'). $row->id_kec ?>" class="btn btn-success btn-md">
                                        Detail
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