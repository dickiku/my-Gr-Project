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
                    <h3 class="card-title">Tabel Potensi Caleg Provinsi</h3>
                </div>
                <div class="card-body col-md-12 mx-auto">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10px;">#</th>
                                <th class="text-center" >Nama Dapil</th>
                                <th class="text-center" >Wilayah</th>
                                <th class="text-center" style="width: 10px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($wilayah as $row ) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row->nama_dapil_prov ?></td>
                                <td><?= $row->wilayah ?></td>
                                <td>
                                    <a href="<?= base_url('caleg_potensial/detailKepengurusanCalegProvinsi/'). $row->id_dapil_prov ?>" class="btn btn-primary btn-md">
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