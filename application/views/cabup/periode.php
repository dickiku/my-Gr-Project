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
              <li class="breadcrumb-item active">DATA Periode Pilbup</li>
            </ol>
          </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<div class="container ml-2">
    <a href=" " class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahPeriodePilbup">+ Tambah Data Periode Pilbup</a>
</div>
<div class="container ml-2 mb-2">
    <?= $this->session->flashdata('pesan') ?>
</div>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <?php foreach($kabupaten as $kab): ?>
                    <h3 class="card-title">Periode Pilbup Kabupaten/Kota <?= $kab['nm_kab'] ?></h3>
                    <?php endforeach;  ?>
                </div>
                <div class="card-body col-md-12 mx-auto">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" width="20px">No</th>
                                <th class="text-center" >Periode</th>
                                <th class="text-center" width="150px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($periode as $row): ?>

                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row['tahun'] ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url('cabup/showCalon/'). $row['id_tahun'].'/'. $row['id_kab'] ?>" class="btn btn-primary btn-md">
                                                Tab
                                            </a>
                                            <a href="<?= base_url('cabup/showEditPeriode/'.$row['id_tahun']) ?>" class="btn btn-warning btn-md">
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
<div class="modal fade" id="tambahPeriodePilbup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Periode Pemilu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('cabup/tambahPeriode/') ?>" method="post">
            <div class="form-group">
                <label>Kabupaten</label>
                <?php foreach($kabupaten as $kab) : ?>
                <input type="hidden" name="id_kab" value="<?= $kab['id_kab'] ?>" class="form-control" required="required">
                <input type="text" name="" value="<?= $kab['nm_kab'] ?>" class="form-control" required="required" disabled>
                <?php endforeach; ?>
            </div>
            <div class="form-group">
                <label>Periode Pilbup</label>
                <input type="text" name="tahun" value="" class="form-control" required="required">
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