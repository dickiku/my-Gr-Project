<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?= $title ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><?= $title ?></li>
              <li class="breadcrumb-item active">Kepengurusan Badan saksi</li>
            </ol>
          </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<div class="container ml-2 mb-2">
    <?= $this->session->flashdata('pesan') ?>
</div>

<div class="container ml-2">
    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahTps">+ Tambah TPS</a>
</div>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <?php foreach($desa as $des) : ?>
                    <h3 class="card-title">List TPS Desa <?= $des['nm_desa']?></h3>
                    <?php endforeach; ?>
                </div>
                <div class="card-body col-md-12 mx-auto">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" width="20px">#</th>
                                <th class="text-center">Nama TPS</th>
                                <th class="text-center" width="100px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($data as $row) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['nama_tps']?></td>
                                <td>
                                    <a href="<?= base_url('dpt_dps/showList/').$row['id_desa'].'/'.$row['id_tps'] ?>" class="btn btn-primary btn-md">
                                    Tab
                                    </a>
                                    <a href="<?= base_url('dpt_dps/showEditTps/').$row['id_tps'].'/'.$row['id_desa'] ?>" class="btn btn-danger btn-md">
                                    Edit
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

<!-- Modal Tambah-->
<div class="modal fade" id="tambahTps" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Kepengurusan Badan Saksi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('dpt_dps/tambahTPS') ?>" method="post">
            <div class="form-group">
                <label>Desa</label>
                <?php foreach($desa as $des) : ?>
                <input type="hidden" name="id_desa" value="<?= $des['id_desa']?>">
                <input type="text" value="<?= $des['nm_desa']?>" class="form-control" required="required" disabled>
                <?php endforeach; ?>
            </div>
            <div class="form-group">
                <label>Nama TPS</label><label class="text-danger text-lg">*</label>
                <input type="text" name="nama" value="" class="form-control" required="required">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>                        
        </form>
      </div>
    </div>
  </div>
</div>