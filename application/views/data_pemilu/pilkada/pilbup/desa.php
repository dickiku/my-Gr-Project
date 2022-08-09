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
              <li class="breadcrumb-item active">Desa</li>
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
                    <h3 class="card-title">Tabel Wilayah Desa</h3>
                </div>
                <div class="card-body col-md-6 mx-auto">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10px;">#</th>
                                <th class="text-center">Wilayah</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($data as $row ) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row->nm_desa ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('pilkada/pilbup_showDptHakPilihDesa/'). $row->id_desa ?>" class="btn btn-success btn-md">
                                        DPT Hak Pilih
                                    </a>
                                    <a href="<?= base_url('pilkada/pilbup_showHasilDesa/'). $row->id_desa ?>" class="btn btn-info btn-md">
                                        Hasil PILGUB
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