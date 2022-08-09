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
              <?php foreach($wilayahKab as $wk) : ?>
              <li class="breadcrumb-item active">Kabupaten Kota <?= $wk['nm_kab'] ?></li>
              <?php endforeach; ?>
            </ol>
          </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<div class="container ml-2">
    <?= $this->session->flashdata('pesan') ?>
    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahAngkatan">+ Tambah Data Angkatan</a>
</div>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <?php foreach($wilayahKab as $wk) : ?>
                    <h3 class="card-title">Tabel Angkatan Kabupaten/Kota <?= $wk['nm_kab'] ?></h3>
                <?php endforeach; ?>
                </div>
                <div class="card-body col-md-6 mx-auto">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10px;">#</th>
                                <th class="text-center">Nama Angkatan</th>
                                <th class="text-center" style="width: 10px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($data as $row) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row->nama_angkatan ?></td>
                                <td>
                                    <a href="<?= base_url('gmd/detailGmdKabupaten/'). $row->id_angkatan ?>" class="btn btn-primary btn-md">
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

<!-- Modal Tambah-->
<div class="modal fade" id="tambahAngkatan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Angkatan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('gmd/tambah_angkatan_proses_provinsi') ?>" method="post">
            <div class="form-group">
                <label>Nama Angkatan</label>
                <input type="text" name="nama_angkatan" class="form-control">
                <?= form_error('nama_angkatan'); ?>
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